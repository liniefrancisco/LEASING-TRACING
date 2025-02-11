<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracing_Controller extends CI_Controller {

	function __construct(){
    
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('upload','acl');

        if(empty($this->session->userdata('server'))){
            $this->session->set_userdata('server', 'MAIN');
        }

        // $db_server = $this->session->userdata('server') == 'talibon' ? 'pms_tal' : 'pms_main';
        
        switch ($this->session->userdata('server')) {
            case 'talibon':
                $db_server = 'pms_tal';
                break;
            case 'cas':
                $db_server = 'pms_cas';
                break;
            default:
                $db_server = 'pms_main';
                break;
        }


        $this->db_pms = $this->load->database($db_server, TRUE);

        ini_set('max_execution_time', 600);


        
    }

    function sanitize($string){
    
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = trim($string);
        return $string;
    }

    function get_bank($store, $bank_code){
        $query = $this->db_pms->query("SELECT * FROM accredited_banks WHERE bank_code = '$bank_code' AND store_code = '$store' LIMIT 1");
        return $query->row();
    }

    public function get_init(){
    	$gl_accounts = $this->db_pms->query("SELECT * FROM gl_accounts ORDER BY gl_account")->result_array();
    	$stores 	 = $this->db_pms->query("SELECT * FROM stores")->result_array();

    	return JSONResponse(compact('gl_accounts', 'stores'));
    }

    public function get_stores(){
        $stores      = $this->db_pms->query("SELECT * FROM stores")->result_array();

        return JSONResponse($stores);
    }

    public function get_gl_accounts($doc_type = 'invoice'){

        if($doc_type == "invoice" || $doc_type == 'payment'){

            if($doc_type == "invoice")
                $account_ids = [4,5,6,11,12,13,14,15,16,17,18,19,20,21,22,29];
            else
                $account_ids = [4,22,29,7,8,9,3,26,23,24,25,31,32]; 

            $account_ids = "'".implode("','", $account_ids)."'";
            $gl_accounts = $this->db_pms->query("SELECT * FROM gl_accounts WHERE id IN ($account_ids)  ORDER BY gl_account")->result_array();

        }else{
            $gl_accounts = $this->db_pms->query("SELECT * FROM gl_accounts WHERE id ORDER BY gl_account")->result_array();
        }
        
        
        // echo $this->db->last_query();
        return JSONResponse($gl_accounts);
    }

    public function get_gl_data(){

        /*$this->form_validation->set_rules('store', 'Store', 'required');
        $this->form_validation->set_rules('gl_id', 'GL ID', 'required');
        $this->form_validation->set_rules('post_date', 'Posting Date', 'required'); 
    
        if ($this->form_validation->run() === FALSE){
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);
        }*/

        $store      = $this->sanitize($this->input->post('store'));
        $gl_id      = $this->sanitize($this->input->post('gl_id'));
        $post_date  = $this->sanitize($this->input->post('post_date'));

        $group_by   = $this->sanitize($this->input->post('group_by'));

        switch ($group_by) {
            case 'doc_no':
                $group_by = 'g.doc_no';
                break;
            
            default:
                $group_by = 'g.id';
                break;
        }


        $result = $this->db_pms->query("
            SELECT * FROM 
                (SELECT
                    g.id,
                    g.doc_no,
                    p.trade_name,
                    SUM(IF(g.debit IS NULL, 0, g.debit)) as debit,
                    SUM(IF(g.credit IS NULL, 0, g.credit)) as credit,
                    g.document_type as doc_type,
                    g.posting_date,
                    g.tenant_id,
                    g.ref_no,
                    a.gl_account,
                    (CASE 
                        WHEN (g.status != '' AND g.status IS NOT NULL) THEN  g.status
                        WHEN (a.gl_account = 'Creditable WHT Receivable' AND g.tag != '' AND g.tag IS NOT NULL) THEN  g.tag
                        ELSE ''
                    END) AS description
                FROM 
                    subsidiary_ledger as g
                LEFT JOIN 
                    (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id  FROM tenants tnt) t on t.tenant_id = g.tenant_id
                LEFT JOIN 
                    prospect p on p.id = t.prospect_id
                LEFT JOIN 
                    gl_accounts a ON a.id = g.gl_accountID 
                WHERE
                    g.posting_date LIKE '%$post_date%'
                AND
                    g.tenant_id LIKE '%$store%'
                AND
                    (g.tenant_id <> 'DELETED' AND g.ref_no <> 'DELETED' AND g.doc_no <> 'DELETED')
                AND 
                    g.tenant_id <> 'ICM-LT000064'
                and
                    g.gl_accountID = $gl_id
                GROUP BY
                    g.gl_accountID, $group_by, g.posting_date
                order by 
                    g.document_type, g.doc_no
                ) as tbl
            order by  
            tbl.posting_date, tbl.credit DESC, tbl.debit DESC, tbl.trade_name, tbl.ref_no, tbl.doc_no", ["%$post_date%", "%$store%"]);

        //tbl.trade_name, tbl.doc_no, tbl.id, tbl.doc_type,  tbl.credit, tbl.debit

        JSONResponse($result->result_array());
    }

    public function get_other_charges_arnt(){

        $store      = $this->sanitize($this->input->post('store'));
        $post_date  = $this->sanitize($this->input->post('post_date'));


        $invoices = $this->db_pms->query("
            SELECT
                s.*,
                p.trade_name,
                a.gl_account
            FROM 
                subsidiary_ledger as s
            LEFT JOIN 
                (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id  FROM tenants tnt) t on t.tenant_id = s.tenant_id
            LEFT JOIN 
                prospect p on p.id = t.prospect_id
            LEFT JOIN 
                gl_accounts a ON a.id = s.gl_accountID 
            WHERE
                s.document_type IN ('Invoice', 'Invoice Adjustment', 'Credit Memo', 'Debit Memo')
            AND 
                (s.gl_accountID = '12' OR s.gl_accountID = '13' OR s.gl_accountID = '14' OR s.gl_accountID = '15' OR s.gl_accountID = '16' OR s.gl_accountID = '17' OR s.gl_accountID = '18' OR s.gl_accountID = '20' OR s.gl_accountID = '22' OR s.gl_accountID = '29' OR s.gl_accountID = '30' OR ( s.gl_accountID = '5' AND s.tag = 'Expanded'))
            AND
                (s.tenant_id <> 'DELETED' AND s.ref_no <> 'DELETED' AND s.doc_no <> 'DELETED')
            AND 
                s.tenant_id <> 'ICM-LT000064'
            AND 
                s.posting_date LIKE '%$post_date%'
            AND 
                s.tenant_id LIKE '%$store%'
            AND 
                s.tenant_id != 'ICM-LT000064'
            ORDER BY 
                a.gl_account, p.trade_name, s.document_type, s.doc_no
        ")->result_array();

       JSONResponse($invoices);
    }

    public function get_gl_receivable_invoices(){


        $store      = $this->sanitize($this->input->post('store'));
        $gl_ids     = $this->input->post('gl_ids');
        $post_date  = $this->sanitize($this->input->post('post_date'));

        $gl_account_IDS = implode("','", $gl_ids);


        $tenant_id  = $this->sanitize($this->input->post('tenant_id'));

        if($tenant_id){
            $condition = "tenant_id = '$tenant_id'";
            $condition2 = "t.tenant_id = '$tenant_id'";
        }else{
            $condition = "tenant_id LIKE '%$store%'";
            $condition2 = "t.store_code = '$store'";
        }

   

        $invoices = $this->db_pms->query("
            SELECT 
                doc_no, 
                ref_no
            FROM
                subsidiary_ledger
            WHERE 
                DATE_FORMAT(posting_date, '%Y-%m-%d') LIKE '%$post_date%'
            AND 
                gl_accountID IN ('$gl_account_IDS')
            AND
                (tenant_id <> 'DELETED' AND ref_no <> 'DELETED' AND doc_no <> 'DELETED')
            AND 
                tenant_id <> 'ICM-LT000064'
            AND 
                $condition
            AND
                document_type IN ('Invoice', 'Invoice Adjustment')
            GROUP BY 
                doc_no
        ")->result();
        
        $doc_nos = [];

        foreach ($invoices as $key => $invoice) {
            $doc_nos[] = $invoice->doc_no;
        }

        $doc_nos = implode("','", $doc_nos);

        $result = $this->db_pms->query("
            SELECT 
                tbl.*,
                IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 )as debit,
                IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0) as credit
             FROM 
                (SELECT
                    g.id,
                    TRIM(g.tenant_id) tenant_id,
                    TRIM(g.posting_date) posting_date,
                    TRIM(g.due_date) due_date,
                    TRIM(g.doc_no) doc_no,
                    TRIM(g.ref_no) ref_no,
                    TRIM(g.document_type) document_type,
                    TRIM(g.gl_accountID) gl_accountID,
                    TRIM(p.trade_name) trade_name,
                    SUM(IFNULL(g.debit, 0)) debit,
                    SUM(IFNULL(g.credit, 0)) credit,
                    (CASE 
                        WHEN (g.status != '' AND g.status IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.status) 
                        WHEN (a.gl_account = 'Creditable WHT Receivable' AND g.tag != '' AND g.tag IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.tag) 
                        ELSE a.gl_account 
                    END) AS description,
                    a.gl_account
                FROM 
                    subsidiary_ledger as g
                LEFT JOIN 
                    (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id, tnt.store_code  FROM tenants tnt) t 
                    ON t.tenant_id = g.tenant_id
                LEFT JOIN 
                    prospect p on p.id = t.prospect_id
                LEFT JOIN 
                    gl_accounts a ON a.id = g.gl_accountID
                WHERE
                    (g.doc_no IN ('$doc_nos'))
                AND 
                    g.document_type IN ('Invoice', 'Invoice Adjustment')
                AND
                    (g.tenant_id <> 'DELETED' AND g.ref_no <> 'DELETED' AND g.doc_no <> 'DELETED')
                AND 
                    g.tenant_id != 'ICM-LT000064'
                AND 
                    $condition2
                GROUP BY
                    g.doc_no, g.ref_no, g.gl_accountID, g.tenant_id
                ORDER BY 
                    g.document_type, g.doc_no) 
            AS 
                tbl
            LEFT JOIN 
                (SELECT 
                    memo.ref_no,
                    memo.gl_accountID,
                    memo.tenant_id,
                    SUM(IFNULL(memo.debit, 0) + IFNULL(memo.credit, 0)) as amt
                FROM 
                    subsidiary_ledger as memo
                WHERE 
                    (memo.document_type = 'Credit Memo' OR memo.document_type = 'Debit Memo')
                AND
                    memo.tenant_id != 'DELETED'
                GROUP BY
                    memo.ref_no, memo.gl_accountID, memo.tenant_id
                ) AS m
            ON 
                (tbl.ref_no = m.ref_no AND tbl.gl_accountID = m.gl_accountID AND tbl.document_type = 'Invoice')
            ORDER BY  
                tbl.posting_date, tbl.debit DESC,  tbl.credit DESC, tbl.trade_name, tbl.gl_account, tbl.doc_no,  tbl.id, tbl.document_type
        ")->result_array();


        JSONResponse($result);
    }


    /*public function get_sl_report_data_bkp(){
        $store      = $this->sanitize($this->input->post('store'));
        $gl_ids     = $this->input->post('gl_ids');
        $date_from  = $this->sanitize($this->input->post('date_from'));
        $date_to    = $this->sanitize($this->input->post('date_to'));

        $date_from  = date('Y-m-d', strtotime($date_from));
        $date_to    = date('Y-m-d', strtotime($date_to));

        $group_by   = $this->sanitize($this->input->post('group_by'));

        switch ($group_by) {
            case 'doc_no':
                $group_by = 'g.doc_no';
                break;
            
            default:
                $group_by = 'g.id';
                break;
        }

        $gl_account_IDS = implode("','", $gl_ids);


        $result = $this->db_pms->query("
            SELECT 
                *,
                SUM(debit) as debit,
                SUM(credit) as credit,
                SUM(debit + credit) as amount
            FROM 
            (
                SELECT
                    g.id,
                    g.tenant_id,
                    g.posting_date,
                    g.due_date,
                    g.doc_no,
                    g.ref_no,
                    g.document_type,
                    p.trade_name,
                    g.gl_accountID,
                    (CASE 
                        WHEN (g.status != '' AND g.status IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.status) 
                        WHEN (a.gl_account = 'Creditable WHT Receivable' AND g.tag != '' AND g.tag IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.tag) 
                        ELSE a.gl_account 
                    END) AS gl_account,
                    SUM(IF(g.debit IS NOT NULL, g.debit + IFNULL(m.amt,0), 0 )) as debit,
                    SUM(IF(g.credit IS NOT NULL, g.credit + IFNULL(m.amt,0), 0)) as credit
                FROM 
                    subsidiary_ledger as g
                LEFT JOIN 
                    (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id, tnt.store_code  FROM tenants tnt) t on t.tenant_id = g.tenant_id
                LEFT JOIN 
                    prospect p on p.id = t.prospect_id
                LEFT JOIN 
                    gl_accounts a ON a.id = g.gl_accountID
                LEFT JOIN 
                    (SELECT 
                        memo.ref_no,
                        memo.gl_accountID,
                        memo.tenant_id,
                        SUM(IFNULL(memo.debit, 0) + IFNULL(memo.credit, 0)) as amt
                    FROM 
                        subsidiary_ledger as memo
                    WHERE 
                        (memo.document_type = 'Credit Memo' OR memo.document_type = 'Debit Memo')
                    AND
                        memo.tenant_id != 'DELETED'
                    GROUP BY
                        memo.ref_no, memo.gl_accountID, memo.tenant_id
                    ) AS m
                ON 
                    (g.ref_no = m.ref_no AND g.gl_accountID = m.gl_accountID AND g.document_type = 'Invoice')
                WHERE
                    date(g.posting_date) BETWEEN  date('$date_from') AND date('$date_to')
                AND 
                    g.gl_accountID IN ('$gl_account_IDS')
                AND 
                    t.store_code = '$store'
                AND 
                    (g.document_type = 'Invoice' OR g.document_type = 'Payment')
                AND
                    (g.tenant_id <> 'DELETED' AND g.ref_no <> 'DELETED' AND g.doc_no <> 'DELETED')
                AND 
                    g.tenant_id <> 'ICM-LT000064'

                GROUP BY
                    g.gl_accountID, $group_by
                ORDER BY 
                    g.document_type, g.doc_no
            ) 
            AS 
                tbl
            GROUP BY 
                tbl.doc_no , tbl.ref_no , tbl.gl_accountID
            HAVING 
                SUM(debit + credit) <> 0
            ORDER BY  
                tbl.posting_date, tbl.credit DESC, tbl.debit DESC, tbl.trade_name, tbl.ref_no, tbl.doc_no")->result_array();



            //==================================================
    
                SELECT * FROM 
                    (SELECT
                        g.id,
                        g.tenant_id,
                        g.posting_date,
                        g.due_date,
                        g.doc_no,
                        g.ref_no,
                        g.document_type,
                        p.trade_name,
                        (CASE 
                            WHEN (g.status != '' AND g.status IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.status) 
                            WHEN (a.gl_account = 'Creditable WHT Receivable' AND g.tag != '' AND g.tag IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.tag) 
                            ELSE a.gl_account 
                        END) AS gl_account,
                        g.debit + IFNULL(cm.credit, 0) + IFNULL(cm.debit, 0) as debit,
                        g.credit + IFNULL(cm.credit, 0) + IFNULL(cm.debit, 0) as credit
                    FROM 
                        general_ledger as g
                    LEFT JOIN 
                        (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id, tnt.store_code  FROM tenants tnt) t on t.tenant_id = g.tenant_id
                    LEFT JOIN 
                        prospect p on p.id = t.prospect_id
                    LEFT JOIN 
                        gl_accounts a ON a.id = g.gl_accountID 
                    LEFT JOIN 
                        subsidiary_ledger as cm ON (cm.document_type = 'Credit Memo'  OR cm.document_type = 'Debit Memo')
                        AND g.ref_no = cm.ref_no 
                        AND g.gl_accountID = cm.gl_accountID
                        AND cm.tenant_id != 'DELETED'
                        AND g.document_type = 'Invoice'
                    WHERE
                        g.posting_date LIKE '%$post_date%'
                    AND 
                        g.gl_accountID IN ('$gl_account_IDS')
                    AND 
                        t.store_code = '$store'
                    AND 
                        (g.document_type = 'Invoice' OR g.document_type = 'Payment')
                    ORDER BY 
                        g.document_type, g.doc_no) 
                AS 
                    tbl
                ORDER BY  
                    tbl.trade_name, tbl.ref_no, tbl.doc_no, tbl.posting_date


            =============================================================================/


        JSONResponse($result);
    }*/

    public function get_payments_ledger_data(){
        $tenant_id  = $this->sanitize($this->input->post('tenant_id'));
        $store      = $this->sanitize($this->input->post('store'));
        $post_date  = $this->sanitize($this->input->post('post_date'));
        $group_by   = $this->sanitize($this->input->post('group_by'));

        $condition = '';

        if($tenant_id){
            $condition = "t.tenant_id = '$tenant_id'";
        }else{
            $condition = "t.store_code = '$store'";
        }


        switch ($group_by) {
            case 'doc_no':
                $group_by = 'g.doc_no';
                $having = 'HAVING SUM(debit + credit) <> 0';
                $group_by2 = 'tbl.doc_no';
                break;
            
            default:
                $group_by = 'g.id';
                $having = '';
                $group_by2 = 'tbl.id';
                break;
        }

        $result = $this->db_pms->query("
            SELECT 
                *,
                SUM(debit) as debit,
                SUM(credit) as credit,
                SUM(debit + credit) as amount
            FROM 
            (
                SELECT
                    g.id,
                    g.tenant_id,
                    g.posting_date,
                    g.due_date,
                    g.doc_no,
                    g.ref_no,
                    g.document_type,
                    p.trade_name,
                    g.gl_accountID,
                    (CASE 
                        WHEN (g.status != '' AND g.status IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.status) 
                        WHEN (a.gl_account = 'Creditable WHT Receivable' AND g.tag != '' AND g.tag IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.tag) 
                        ELSE a.gl_account 
                    END) AS description,
                    a.gl_account,
                    SUM(IFNULL(g.debit,0)) as debit,
                    SUM(IFNULL(g.credit,0)) as credit
                FROM 
                    subsidiary_ledger as g
                LEFT JOIN 
                    (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id, tnt.store_code  FROM tenants tnt) t on t.tenant_id = g.tenant_id
                LEFT JOIN 
                    prospect p on p.id = t.prospect_id
                LEFT JOIN 
                    gl_accounts a ON a.id = g.gl_accountID 
                WHERE
                    date(g.posting_date) LIKE '%$post_date%'
                AND 
                    $condition
                AND 
                    g.document_type IN ('Payment', 'Payment Adjustment')
                AND
                    (g.tenant_id <> 'DELETED' AND g.ref_no <> 'DELETED' AND g.doc_no <> 'DELETED')
                AND 
                    g.tenant_id <> 'ICM-LT000064'
                GROUP BY
                    g.gl_accountID, g.posting_date, $group_by
                ORDER BY 
                    g.document_type, g.doc_no
            ) 
            AS 
                tbl
            GROUP BY 
                $group_by2 , tbl.ref_no , tbl.gl_accountID, tbl.posting_date
            $having

            ORDER BY  
                tbl.posting_date, tbl.id, tbl.credit DESC, tbl.debit DESC, tbl.trade_name, tbl.ref_no, tbl.doc_no")->result_array();

        JSONResponse($result);
    }

    public function get_sl_report_data(){
        $store      = $this->sanitize($this->input->post('store'));
        $gl_ids     = $this->input->post('gl_ids');
        $date_from  = $this->sanitize($this->input->post('date_from'));
        $date_to    = $this->sanitize($this->input->post('date_to'));
        $date_from  = date('Y-m-d', strtotime($date_from));
        $date_to    = date('Y-m-d', strtotime($date_to));
        $group_by   = $this->sanitize($this->input->post('group_by'));
        $csv        = $this->sanitize($this->input->post('csv'));

        switch ($group_by) {
            case 'doc_no':
                $group_by = 'g.doc_no';
            break;
            
            default:
                $group_by = 'g.id';
            break;
        }

        $gl_account_IDS = implode("','", $gl_ids);


        $result = $this->db_pms->query("
            SELECT 
                tbl.*,
                IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) as debit,
                IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0) as credit,
                (IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) + IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0)) as amount
            FROM 
            (
                SELECT
                    g.id,
                    g.tenant_id,
                    g.posting_date,
                    g.due_date,
                    g.doc_no,
                    g.ref_no,
                    g.document_type,
                    p.trade_name,
                    g.gl_accountID,
                    a.gl_account,
                    g.bank_code,
                    g.bank_name,
                    t.tin,
                    (CASE 
                        WHEN (g.status != '' AND g.status IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.status) 
                        WHEN (a.gl_account = 'Creditable WHT Receivable' AND g.tag != '' AND g.tag IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.tag) 
                        ELSE a.gl_account 
                    END) AS description,
                    SUM(IFNULL(g.debit, 0)) debit,
                    SUM(IFNULL(g.credit, 0)) credit
                FROM 
                    subsidiary_ledger as g
                LEFT JOIN 
                    (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id, tnt.store_code,tnt.tin FROM tenants tnt) t on t.tenant_id = g.tenant_id
                LEFT JOIN 
                    prospect p on p.id = t.prospect_id
                LEFT JOIN 
                    gl_accounts a ON a.id = g.gl_accountID
                WHERE
                    date(g.posting_date) BETWEEN  date('$date_from') AND date('$date_to')
                AND 
                    g.gl_accountID IN ('$gl_account_IDS')
                AND 
                    t.store_code = '$store'
                AND 
                    g.document_type IN ('Invoice', 'Payment', 'Invoice Adjustment', 'Payment Adjustment')
                    /*(g.document_type = 'Invoice' OR g.document_type = 'Payment')*/
                AND
                    (g.tenant_id <> 'DELETED' AND g.ref_no <> 'DELETED' AND g.doc_no <> 'DELETED')
                AND 
                    g.tenant_id <> 'ICM-LT000064'ssd

                GROUP BY
                    CASE 
                    WHEN g.document_type IN ('Invoice', 'Invoice Adjustment')
                    THEN  CONCAT(TRIM(g.doc_no),TRIM(g.ref_no),TRIM(g.gl_accountID),TRIM(g.tenant_id), TRIM(g.document_type))
                    ELSE CONCAT(TRIM(g.gl_accountID), TRIM(g.posting_date), TRIM($group_by),TRIM(g.tenant_id), TRIM(g.ref_no)) 
                    END
                ORDER BY 
                    g.document_type, g.doc_no
            ) 
            AS 
                tbl
            LEFT JOIN 
                (SELECT 
                    memo.ref_no,
                    memo.gl_accountID,
                    memo.tenant_id,
                    SUM(IFNULL(memo.debit, 0) + IFNULL(memo.credit, 0)) as amt
                FROM 
                    subsidiary_ledger as memo
                WHERE 
                    (memo.document_type = 'Credit Memo' OR memo.document_type = 'Debit Memo')
                AND
                    memo.tenant_id != 'DELETED'
                GROUP BY
                    memo.ref_no, memo.gl_accountID, memo.tenant_id
                ) AS m
            ON 
                (tbl.ref_no = m.ref_no AND tbl.gl_accountID = m.gl_accountID AND tbl.document_type = 'Invoice')
            WHERE  
                (IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) + IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0)) <> 0
            /*GROUP BY 
                tbl.doc_no , tbl.ref_no , tbl.gl_accountID, tbl.tenant_id*/
            ORDER BY  
                tbl.posting_date, tbl.credit DESC, tbl.debit DESC, tbl.trade_name, tbl.ref_no, tbl.doc_no")->result_array();

        if($csv){
            $csv_data[] = [
                'ID',
                'Tenant Code',
                'Trade Name',
                'Tin',
                'Document Type',
                'GL Account',
                'Doc. No.',
                'Ref. No.',
                'Posting Date',
                'Due Date',
                'Bank Code',
                'Bank Name',
                'Debit',
                'Credit'
            ];

            foreach ($result as $d) {
                $d = (object) $d;

                $csv_data[] =  [
                    $d->id,
                    $d->tenant_id,
                    $d->trade_name,
                    $d->tin,
                    $d->document_type,
                    $d->description,
                    $d->doc_no,
                    $d->ref_no,
                    $d->posting_date,
                    $d->due_date,
                    $d->bank_code,
                    $d->bank_name,
                    $d->debit,
                    $d->credit,    
                ];
            }


           $csv_data =  arrayToString($csv_data);

            $file_name = "GL Report - $store ".strtoupper(uniqid()).'.csv';

            $dir = getcwd().'/reports/'.$file_name;

            writeNewFile($dir, $csv_data);

            JSONResponse($file_name);
        }



        JSONResponse($result);
    }

    public function get_per_tenant_report(){
        $tenant_id  = $this->sanitize($this->input->post('tenant_id'));
        $gl_ids     = $this->input->post('gl_ids');
        $date_from  = $this->sanitize($this->input->post('date_from'));
        $date_to    = $this->sanitize($this->input->post('date_to'));
        $date_from  = date('Y-m-d', strtotime($date_from));
        $date_to    = date('Y-m-d', strtotime($date_to));
        $group_by   = $this->sanitize($this->input->post('group_by'));
        $csv        = $this->sanitize($this->input->post('csv'));

        switch ($group_by) {
            case 'doc_no':
                $group_by = 'g.doc_no';
            break;
            
            default:
                $group_by = 'g.id';
            break;
        }

        $gl_account_IDS = implode("','", $gl_ids);


        $result = $this->db_pms->query("
            SELECT 
                tbl.*,
                IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) as debit,
                IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0) as credit,
                (IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) + IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0)) as amount
            FROM 
            (
                SELECT
                    g.id,
                    g.tenant_id,
                    g.posting_date,
                    g.due_date,
                    g.doc_no,
                    g.ref_no,
                    g.document_type,
                    p.trade_name,
                    g.gl_accountID,
                    a.gl_account,
                    g.bank_code,
                    g.bank_name,
                    (CASE 
                        WHEN (g.status != '' AND g.status IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.status) 
                        WHEN (a.gl_account = 'Creditable WHT Receivable' AND g.tag != '' AND g.tag IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.tag) 
                        ELSE a.gl_account 
                    END) AS description,
                    SUM(IFNULL(g.debit, 0)) debit,
                    SUM(IFNULL(g.credit, 0)) credit
                FROM 
                    subsidiary_ledger as g
                LEFT JOIN 
                    (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id, tnt.store_code  FROM tenants tnt) t on t.tenant_id = g.tenant_id
                LEFT JOIN 
                    prospect p on p.id = t.prospect_id
                LEFT JOIN 
                    gl_accounts a ON a.id = g.gl_accountID
                WHERE
                    date(g.posting_date) BETWEEN  date('$date_from') AND date('$date_to')
                AND 
                    g.gl_accountID IN ('$gl_account_IDS')
                AND 
                    g.tenant_id = '$tenant_id'
                AND 
                    g.document_type IN ('Invoice', 'Payment', 'Invoice Adjustment', 'Payment Adjustment')
                    /*(g.document_type = 'Invoice' OR g.document_type = 'Payment')*/
                AND 
                    g.tenant_id <> 'DELETED'

                GROUP BY
                    CASE 
                    WHEN g.document_type IN ('Invoice', 'Invoice Adjustment')
                    THEN  CONCAT(TRIM(g.doc_no),TRIM(g.ref_no),TRIM(g.gl_accountID),TRIM(g.tenant_id), TRIM(g.document_type))
                    ELSE CONCAT(TRIM(g.gl_accountID), TRIM(g.posting_date),TRIM($group_by),TRIM(g.tenant_id), TRIM(g.ref_no)) 
                    END
                ORDER BY 
                    g.document_type, g.doc_no
            ) 
            AS 
                tbl
            LEFT JOIN 
                (SELECT 
                    memo.ref_no,
                    memo.gl_accountID,
                    memo.tenant_id,
                    SUM(IFNULL(memo.debit, 0) + IFNULL(memo.credit, 0)) as amt
                FROM 
                    subsidiary_ledger as memo
                WHERE 
                    (memo.document_type = 'Credit Memo' OR memo.document_type = 'Debit Memo')
                AND
                    memo.tenant_id != 'DELETED'
                GROUP BY
                    memo.ref_no, memo.gl_accountID, memo.tenant_id
                ) AS m
            ON 
                (tbl.ref_no = m.ref_no AND tbl.gl_accountID = m.gl_accountID AND tbl.document_type = 'Invoice')
            WHERE  
                (IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) + IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0)) <> 0
            /*GROUP BY 
                tbl.doc_no , tbl.ref_no , tbl.gl_accountID, tbl.tenant_id*/
            
            ORDER BY  
                tbl.posting_date, tbl.credit DESC, tbl.debit DESC, tbl.trade_name, tbl.ref_no, tbl.doc_no")->result_array();


        if($csv){
            $csv_data[] = [
                'ID',
                'Tenant Code',
                'Trade Name',
                'Document Type',
                'GL Account',
                'Doc. No.',
                'Ref. No.',
                'Posting Date',
                'Due Date',
                'Bank Code',
                'Bank Name',
                'Debit',
                'Credit'
            ];

            foreach ($result as $d) {
                $d = (object) $d;

                $csv_data[] =  [
                    $d->id,
                    $d->tenant_id,
                    $d->trade_name,
                    $d->document_type,
                    $d->description,
                    $d->doc_no,
                    $d->ref_no,
                    $d->posting_date,
                    $d->due_date,
                    $d->bank_code,
                    $d->bank_name,
                    $d->debit,
                    $d->credit,
                    
                ];
            }


           $csv_data =  arrayToString($csv_data);

            $file_name = "Tenant Ledger Report - $tenant_id ".strtoupper(uniqid()).'.csv';

            $dir = getcwd().'/reports/'.$file_name;

            writeNewFile($dir, $csv_data);

            JSONResponse($file_name);
        }


        JSONResponse($result);
    }

    public function navigate_per_doc_no(){
        $store       = $this->sanitize($this->input->post('store'));
        $doc_nos     = $this->sanitize($this->input->post('doc_nos'));

        $doc_nos     = array_map('trim', explode(',', $doc_nos));

        foreach ($doc_nos as $key => $docno) {
            if($docno == '') array_splice($doc_nos, $key, 1);
        }

        $doc_nos = "'".implode("', '", $doc_nos)."'";


        $group_by   = $this->sanitize($this->input->post('group_by'));
        switch ($group_by) {
            case 'doc_no':
                $group_by = 'g.doc_no';
                break;
            
            default:
                $group_by = 'g.id';
                break;
        }


        $result = $this->db_pms->query("
            SELECT 
                tbl.*,
                IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) as debit,
                IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0) as credit,
                (IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) + IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0)) as amount
            FROM 
            (
                SELECT
                    g.id,
                    g.tenant_id,
                    g.posting_date,
                    g.due_date,
                    g.doc_no,
                    g.ref_no,
                    g.document_type,
                    p.trade_name,
                    g.gl_accountID,
                    g.bank_code,
                    g.bank_name,
                    a.gl_account,
                    (CASE 
                        WHEN (g.status != '' AND g.status IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.status) 
                        WHEN (a.gl_account = 'Creditable WHT Receivable' AND g.tag != '' AND g.tag IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.tag) 
                        ELSE a.gl_account 
                    END) AS description,
                    SUM(IFNULL(g.debit, 0)) debit,
                    SUM(IFNULL(g.credit, 0)) credit
                FROM 
                    subsidiary_ledger as g
                LEFT JOIN 
                    (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id, tnt.store_code  FROM tenants tnt) t on t.tenant_id = g.tenant_id
                LEFT JOIN 
                    prospect p on p.id = t.prospect_id
                LEFT JOIN 
                    gl_accounts a ON a.id = g.gl_accountID
                WHERE
                    (g.doc_no IN ($doc_nos) OR g.ref_no IN ($doc_nos))
                AND 
                    t.store_code = '$store'
                AND 
                    g.document_type in ('Invoice', 'Payment', 'Invoice Adjustment', 'Payment Adjustment')
                    /*(g.document_type = 'Invoice' OR g.document_type = 'Payment' )*/
                AND
                    (g.tenant_id <> 'DELETED' AND g.ref_no <> 'DELETED' AND g.doc_no <> 'DELETED')
                AND 
                    g.tenant_id <> 'ICM-LT000064'

                GROUP BY
                    CASE 
                    WHEN g.document_type IN ('Invoice', 'Invoice Adjustment')
                    THEN  CONCAT(TRIM(g.doc_no),TRIM(g.ref_no),TRIM(g.gl_accountID),TRIM(g.tenant_id), TRIM(g.document_type))
                    ELSE CONCAT(TRIM(g.gl_accountID), TRIM(g.posting_date), TRIM($group_by),TRIM(g.tenant_id), TRIM(g.ref_no)) 
                    END
                ORDER BY 
                    g.document_type, g.doc_no, g.document_type
            ) 
            AS 
                tbl
            LEFT JOIN 
                (SELECT 
                    memo.ref_no,
                    memo.gl_accountID,
                    memo.tenant_id,
                    SUM(IFNULL(memo.debit, 0) + IFNULL(memo.credit, 0)) as amt
                FROM 
                    subsidiary_ledger as memo
                WHERE 
                    (memo.document_type = 'Credit Memo' OR memo.document_type = 'Debit Memo')
                AND
                    memo.tenant_id != 'DELETED'
                GROUP BY
                    memo.ref_no, memo.gl_accountID, memo.tenant_id
                ) AS m
            ON 
                (tbl.ref_no = m.ref_no AND tbl.gl_accountID = m.gl_accountID AND tbl.document_type = 'Invoice')
            WHERE  
                (IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) + IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0)) <> 0
            /*GROUP BY 
                tbl.doc_no , tbl.ref_no , tbl.gl_accountID, tbl.tenant_id*/
            
            ORDER BY  
                tbl.posting_date, 
                tbl.trade_name, 
                tbl.ref_no, 
                tbl.doc_no,
                tbl.document_type,
                tbl.gl_accountID,
                ABS(IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) + IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0)) DESC
        ")->result_array();


        JSONResponse($result);
    }



    public function GET(){
        $store      = $this->sanitize($this->input->post('store'));
        $gl_ids     = $this->input->post('gl_ids');
        $date_from  = $this->sanitize($this->input->post('date_from'));
        $date_to    = $this->sanitize($this->input->post('date_to'));

        $date_from  = date('Y-m-d', strtotime($date_from));
        $date_to    = date('Y-m-d', strtotime($date_to));

        $group_by   = $this->sanitize($this->input->post('group_by'));

        switch ($group_by) {
            case 'doc_no':
                $group_by = 'g.doc_no';
                break;
            
            default:
                $group_by = 'g.id';
                break;
        }

        $gl_account_IDS = implode("','", $gl_ids);


        $result = $this->db_pms->query("
            SELECT 
                tbl.*,
                IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) as debit,
                IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0) as credit,
                (IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) + IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0)) as amount
            FROM 
            (
                SELECT
                    g.id,
                    g.tenant_id,
                    g.posting_date,
                    g.due_date,
                    g.doc_no,
                    g.ref_no,
                    g.document_type,
                    p.trade_name,
                    g.gl_accountID,
                    (CASE 
                        WHEN (g.status != '' AND g.status IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.status) 
                        WHEN (a.gl_account = 'Creditable WHT Receivable' AND g.tag != '' AND g.tag IS NOT NULL) THEN CONCAT(a.gl_account, '-', g.tag) 
                        ELSE a.gl_account 
                    END) AS gl_account,
                    SUM(IFNULL(g.debit, 0)) debit,
                    SUM(IFNULL(g.credit, 0)) credit
                FROM 
                    subsidiary_ledger as g
                LEFT JOIN 
                    (SELECT distinct(tnt.prospect_id) as prospect_id, tnt.tenant_id, tnt.store_code  FROM tenants tnt) t on t.tenant_id = g.tenant_id
                LEFT JOIN 
                    prospect p on p.id = t.prospect_id
                LEFT JOIN 
                    gl_accounts a ON a.id = g.gl_accountID
                WHERE
                    date(g.posting_date) BETWEEN  date('$date_from') AND date('$date_to')
                AND 
                    g.gl_accountID IN ('$gl_account_IDS')
                AND 
                    t.store_code = '$store'
                AND 
                    g.document_type IN ('Invoice', 'Payment', 'Invoice Adjustment', 'Payment Adjustment')
                    /*(g.document_type = 'Invoice' OR g.document_type = 'Payment')*/
                AND 
                    g.tenant_id <> 'DELETED'

                GROUP BY
                    CASE 
                    WHEN g.document_type = 'Invoice'
                    THEN  CONCAT(TRIM(g.doc_no),TRIM(g.ref_no),TRIM(g.gl_accountID),TRIM(g.tenant_id), TRIM(g.document_type))
                    ELSE CONCAT(TRIM(g.gl_accountID),TRIM($group_by),TRIM(g.tenant_id), TRIM(g.ref_no)) 
                    END
                ORDER BY 
                    g.document_type, g.doc_no
            ) 
            AS 
                tbl
            LEFT JOIN 
                (SELECT 
                    memo.ref_no,
                    memo.gl_accountID,
                    memo.tenant_id,
                    SUM(IFNULL(memo.debit, 0) + IFNULL(memo.credit, 0)) as amt
                FROM 
                    subsidiary_ledger as memo
                WHERE 
                    (memo.document_type = 'Credit Memo' OR memo.document_type = 'Debit Memo')
                AND
                    memo.tenant_id != 'DELETED'
                GROUP BY
                    memo.ref_no, memo.gl_accountID, memo.tenant_id
                ) AS m
            ON 
                (tbl.ref_no = m.ref_no AND tbl.gl_accountID = m.gl_accountID AND tbl.document_type = 'Invoice')
            WHERE  
                (IF(tbl.debit <> 0, tbl.debit + IFNULL(m.amt,0), 0 ) + IF(tbl.credit <> 0, tbl.credit + IFNULL(m.amt,0), 0)) <> 0
            /*GROUP BY 
                tbl.doc_no , tbl.ref_no , tbl.gl_accountID, tbl.tenant_id*/
            
            ORDER BY  
                tbl.posting_date, tbl.credit DESC, tbl.debit DESC, tbl.trade_name, tbl.ref_no, tbl.doc_no")->result_array();

        JSONResponse($result);
    }


    public function gen_manual_nav_txtfile(){


        $month              = $this->input->post('month');
        $store              = $this->input->post('store');
        $entries            = $this->input->post('entries');

        $store  = $this->db_pms->select('*')->from('stores')->where(['store_code'=>$store])->limit(1)->get()->row();

        $date   = date("m/t/Y", strtotime($month));
        $month  = date("M-Y", strtotime($date));
        $doc_no = 'LS'.date("mdy", strtotime($date));

        $data_csv = [];

        $entry_line = 0;


        foreach ($entries as $key => $entry) {
            $entry = (object) $entry;

            $gl_account_id      = $entry->gl_account_id;
            $amount             = $entry->amount;

            $gl     = $this->db_pms->select('*')->from('gl_accounts')->where(['id'=>$gl_account_id])->limit(1)->get()->row();

            $entry_line += 1000;
            $amount = round($amount, 2);

            $data = [
                'SALES',
                'LEASING',
                $entry_line,
                'G/L Account',
                $gl->gl_code,
                $date,
                'Invoice',
                $month,
                $doc_no,
                $gl->gl_account,
                'PHP',
                $amount,
                $amount >= 0 ? abs($amount) : '',
                $amount < 0  ? abs($amount) : '',
                $amount,
                $amount,
                '1',
                $store->company_code,
                $store->dept_code,
                'SALESJNL',
                $amount,
                $amount * -1,
                $date,
                $amount,
                $amount * -1
            ];

            $data_csv[] = $data;

        }

        $data = arrayToString($data_csv);
        download_send_headers(date("Y-m",strtotime($date)).".txt" , $data);
    }


    public function get_payment_by_doc_nos(){

        $doc_nos = $this->sanitize($this->input->post('doc_nos'));
        $store   = $this->input->post('store');

        $doc_nos = array_map('trim', explode(',', $doc_nos));

        foreach ($doc_nos as $key => $docno) {
            if($docno == '') array_splice($doc_nos, $key, 1);
        }

        $doc_nos = "'".implode("', '", $doc_nos)."'";


        $query = $this->db_pms->query("
            SELECT
                sl.bank_code,
                sl.bank_name,
                sl.posting_date,
                sl.ref_no,
                ga.gl_code,
                ga.gl_account,
                sl.gl_accountID,
                sl.doc_no,
                SUM(IFNULL(sl.debit, 0)) debit,
                SUM(IFNULL(sl.credit, 0)) credit,
                SUM(IFNULL(sl.debit, 0)) + SUM(IFNULL(sl.credit, 0)) amount,
                sl2.partnerID
            FROM
                subsidiary_ledger sl
            LEFT JOIN 
                gl_accounts ga
            ON 
                ga.id = sl.gl_accountID
            LEFT JOIN
                (SELECT s.*, s.gl_accountID as partnerID FROM subsidiary_ledger s where s.debit IS NULL AND s.credit IS NOT NULL AND s.document_type IN ('Payment', 'Payment Adjustment') GROUP BY s.doc_no, s.ref_no, s.credit, s.document_type) sl2
            ON
                sl.doc_no = sl2.doc_no   AND
                sl.ref_no = sl2.ref_no AND 
                sl.debit IS NOT NULL AND 
                sl.debit = ABS(sl2.credit) AND 
                sl.tenant_id = sl2.tenant_id AND
                sl.document_type = sl2.document_type
            WHERE
                (sl.gl_accountID = '4' OR sl.gl_accountID = '22' OR sl.gl_accountID = '29' OR sl.gl_accountID = '7' OR sl.gl_accountID = '8'OR sl.gl_accountID = '9' OR sl.gl_accountID = '3' OR sl.gl_accountID = '26' OR sl.gl_accountID = '23' 
                    OR sl.gl_accountID = '24'  OR sl.gl_accountID = '25' OR sl.gl_accountID = '31' OR sl.gl_accountID = '32')
            AND
                sl.document_type IN ('Payment', 'Payment Adjustment')
            AND 
                sl.doc_no IN ($doc_nos)
            AND
                sl.tenant_id IN(
                    SELECT 
                        t.tenant_id 
                    FROM 
                        tenants t, prospect p 
                    WHERE  
                        t.store_code = '$store' 
                    AND 
                        t.tenant_id != 'ICM-LT000064' 
                    AND 
                        t.prospect_id = p.id 
                    GROUP BY 
                    tenant_id
                )

            GROUP BY
                sl.doc_no, sl.gl_accountID, sl.posting_date, sl2.partnerID
            ORDER BY posting_date, sl.doc_no ASC, sl.ref_no ASC, sl.gl_accountID ASC,   sl.id ASC , bank_code ASC"
        );




        return JSONResponse($query->result());
    }

    public function gen_nav_payment_txtfile(){

        $store     = $this->input->post('store');
        $entries   = $this->input->post('entries');

        $store  = $this->db_pms->select('*')->from('stores')->where(['store_code'=>$store])->limit(1)->get()->row();

        $line_no = 10000;
        $data_csv = [];

        $doc_nos = [];

        foreach ($entries as $key => $entry) {
            $entry = (object) $entry;

            $entry->gl_accountID = str_replace("string:", "", $entry->gl_accountID);

            if(!in_array($entry->doc_no, $doc_nos)){
                $doc_nos[] = $entry->doc_no;
            }

            if($entry->amount == 0 ) continue;


            $doc_no = 'PR' .  date('mdy', strtotime($entry->posting_date));

            if($entry->gl_accountID == 3){

                $bank_name = '';
                $bank = $this->get_bank($store->store_code, $entry->bank_code);

                if($bank){
                    $bank_name = $bank->bank_name;
                }

                $data_csv[] = array(
                    'CASH RECEI',
                    'LS COLL',
                    $line_no,
                    'Bank Account',
                    $entry->bank_code,
                    date('m/d/Y', strtotime($entry->posting_date)),
                    'Payment',
                    strval($entry->doc_no),
                    $doc_no,
                    $bank_name . ' - ' . $store->store_code,
                    'PHP',
                    $entry->amount,
                    $entry->amount,
                    '',
                    $entry->amount,
                    $entry->amount,
                    '1',
                    $store->company_code,
                    $store->dept_code,
                    'PAYMENTJNL',
                    $entry->amount,
                    $entry->amount * -1,
                    date('m/d/Y', strtotime($entry->posting_date)),
                    'Bank Account',
                    $entry->bank_code,
                    $entry->amount,
                    $entry->amount * -1
                );

            } else{

                $gl = $this->db_pms->select('*')->from('gl_accounts')->where(['id'=>$entry->gl_accountID])->limit(1)->get()->row();


                $data_csv[] = array(
                    'CASH RECEI',
                    'LS COLL',
                    $line_no,
                    'G/L Account',
                    $gl->gl_code,
                    date('m/d/Y', strtotime($entry->posting_date)),
                    'Payment',
                    strval($entry->doc_no),
                    $doc_no,
                    $gl->gl_account,
                    'PHP',
                    $entry->amount,
                    $entry->amount > 0  ? abs($entry->amount) : '',
                    $entry->amount < 0  ? abs($entry->amount) : '',
                    $entry->amount,
                    $entry->amount,
                    '1',
                    $store->company_code,
                    $store->dept_code,
                    'PAYMENTJNL',
                    $entry->amount,
                    $entry->amount * -1,
                    date('m/d/Y', strtotime($entry->posting_date)),
                    '',
                    '',
                    $entry->amount,
                    $entry->amount * -1
                );

            }

            $line_no += 10000;

        }

        $data = arrayToString($data_csv);

        $name_ext = implode(" ", $doc_nos);
        $date = new DateTime();
        $timeStamp = $date->getTimestamp();

        $name_ext = strlen($name_ext) > 40 ? substr($name_ext,0,40).'...' : $name_ext;
        $file_name = "Payment $name_ext -" .$timeStamp . ".txt";

       
        download_send_headers($file_name, $data);

    }




















    public function sample(){
    	/*$target = 25;
    	$numbers = [10, 1, 2, 3, 5, 6];
    	$max = 0;
    	$fastMode = true;

    	//arsort($numbers);
    	$total_comb = pow(2, count($numbers));

    	$count = 0;
    	$id = "_123";

    	$this->sum_up_rec($numbers, $target, [], $max, $fastMode, $count, $total_comb, $id);
    	var_dump($this->session->get_userdata());
    	die("not found!");*/

    	for($x= 0; $x < 1000; $x++){
    		$total = 1000;
    		$count = $x;

    		$this->session->set_userdata("_u8rzcgv34", compact('total', 'count'));
    		sleep(2);
    	}
    }

    

    public function sum_up(){
    	$this->form_validation->set_rules('target', 'Target Value', 'required|numeric');
    	$this->form_validation->set_rules('max', 'Max Variance Allowed', 'required|numeric');

    	
    	if ($this->form_validation->run() === FALSE){
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);
        }



        $target		= $this->sanitize($this->input->post('target'));
    	$numbers	= $this->input->post('numbers');
    	$max		= $this->sanitize($this->input->post('max'));
    	$fastMode   = $this->input->post('fastMode') == 1 ? true : false;
 	

 		$id = "_".uniqid();

    	$this->session->set_userdata($id, compact('target', 'numbers', 'max', 'fastMode'));

    	//$this->sum_up_rec($numbers, $target, [], $max, $fastMode, $count, $total ,$id);

    	JSONResponse(["type"=>"success", "id"=>$id]);
    }

    /**
     * sum_up_recursive find the combination to match the sum
     * 
     * @param array $numbers - array of numbers
     * @param integer $target - sum or target to match
     * @param array $partial - partial combination
     * @param int $max - max variance allowed
     * @param bool $fastMode
     * @param array $count - progress count

     */

    function sum_up_rec($numbers, $target, $partial = [], $max = 0, $fastMode = true, &$count=0, $total, $id = ""){
     
    	$count++;

    	$this->session->set_userdata($id, compact('total', 'count'));

    	$progress = round($count / $total * 100);
    	$this->sendMsg($id, json_encode(["done"=>false, "progress"=>$progress, "fastMode"=>$fastMode]), "progress");
    	

    	$s = 0;
    	foreach ($partial as  $x) {
    		$s+= (double)$x;
    	}

	    if (abs(round($s - $target, 2)) <= round($max, 2)){
	        $this->sendMsg($id, json_encode(["done"=>true, "progress"=>100, "data"=>$partial]), "progress");
	        exit();
	    }


	    if ($s >= $target && $fastMode)
	        return;

	    for ($i = 0; $i < count($numbers); $i++)
	    {
	        $remaining = array();
	        $n = $numbers[$i];
	        for ($j = $i + 1; $j < count($numbers); $j++) 
	        	array_push($remaining, $numbers[$j]);

	        $partial_rec = $partial;
	        array_push($partial_rec, $n);

	        $this->sum_up_rec($remaining, $target, $partial_rec, $max, $fastMode, $count, $total, $id);
	    }
    }

    public function monitor($id){

    	header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
  		

  		$data = (object)$this->session->userdata($id);


  		$numbers 	= $data->numbers;
  		$target 	= $data->target;
  		$max 		= $data->max;
  		$fastMode 	= $data->fastMode;

  		$total = pow(2, count($numbers));

  		$count = 0;

  		$this->sum_up_rec($numbers, $target, [], $max, $fastMode, $count, $total ,$id);

  		$this->sendMsg($id, json_encode(["done"=>true, "progress"=>100, "data"=>[]]), "progress");
    	
    }

    function sendMsg($id, $msg, $event) {
	  echo "id: $id" . PHP_EOL;
	  echo "event: $event". PHP_EOL;
	  echo "data: $msg" . PHP_EOL;
	  echo PHP_EOL;
	  ob_flush();
	  flush();
	}

    
}
