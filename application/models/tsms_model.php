<?php

class Tsms_model extends CI_Model 
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->_user_group = $this->session->userdata('user_group');
        $this->_user_id = $this->session->userdata('id');
        //$this->_DB1 = $this->load->database('cyril', TRUE);
       // $this->_DB2 = $this->load->database('austin', TRUE);
       
    }


    public function check_login($username, $password){ 

        $password = md5($password);

        $query = $this->db->query("
            SELECT 
                u.*,
                s.store_code
            FROM 
                `agc-tsms`.`add_users` u 
            LEFT JOIN
                `agc-pms`.`stores` s 
            ON 
                u.user_group = s.id 
            WHERE 
                u.password = '$password'
            AND
                u.username = '$username'
            AND 
                u.status = 'Active'
            LIMIT 1 ");
    
        if($query->num_rows()>0){
        
            $user = (array)$query->row();
            $user['is_logged_in'] = TRUE;


            if($user['user_type'] == 'Administrator')   
                unset($user['store_code']);

            $this->session->set_userdata($user);

            return true; 
        }
     
        return false;
    }

    public function check_admin_login($username, $password)
    {
        $this -> db -> select('*');
        $this -> db -> from('add_users');
        $this -> db -> where('username = ' . "'" . $username . "'");
        $this -> db -> where('password = ' . "'" . md5($password) . "'");
        $this -> db -> where("status =  'Active'");
        $this -> db -> where('user_type = ' . "'" . 'Administrator' . "'");
        $this -> db -> limit(1);
        $query = $this -> db -> get();


        if($query->num_rows()>0)
        {
            $rows = $query->result()[0];                

            //add all data to session
            $data = array(
                'id'                    =>  $rows->id,
                'name'                  =>  $rows->name,
                'password'              =>  $rows->password,
                'user_type'             =>  $rows->user_type,
                'username'              =>  $rows->username,
                'last_name'             =>  $rows->last_name,
                'user_group'            =>  $rows->user_group,
                'is_logged_in'          =>  TRUE
            );

            $this->session->set_userdata($data);
            return true;
        }
        return false;
    }

    public function user_credentials(){
    
        $this -> db -> select('*');
        $this -> db -> from('add_users');
        $this -> db -> where('id = ' . "'" . $this->_user_id . "'");
        $query = $this -> db -> get();

        return $query->result_array();
    }


    public function get_tsms_users(){
    
        $query = $this->_DB2->query(
            "SELECT
                `add_users`.`id`,
                `add_users`.`name`,                       
                `add_users`.`last_name`,
                `add_users`.`username`,
                `add_users`.`password`,
                `add_users`.`user_type`
            FROM
                `add_users`
            WHERE
                `add_users`.`id`
     
            ORDER BY 
                `name`
            AND
                    `ths`.`id` = '" . $this->_user_group . "'
        ");

        return $query->result_array();
    }

    public function getAll() {
        return $this->_DB2->from($this->add_users)->get()->result_array();
    }

    public function get_users()
    {

        if ($this->session->userdata('user_type') != '') 
        {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `add_users` `au`
                WHERE
                    `au`.`id` 
         
            ");
        } else {
            $query = $this->_DB2->query(
                "SELECT
                    `au`.`id`,
                    `au`.`name`,
                    `au`.`last_name`,    
                    `au`.`username`,
                    `au`.`user_type`
                FROM
                    `add_users` `au`
                WHERE
                    `au`.`id` 

                AND
                    `ths`.`id` = '" . $this->_user_group . "'
            ");

        }

        return $query->result_array();

    }

    public function get_pending_list()
    {

            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `tenant_daily_sales`
                WHERE
                    `status` = 'Pending' 
         
            ");

        
        return $query->result_array();

    }

    public function get_pending_list2()
    {

            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `tenant_hourly_sales`
                WHERE
                    `status` = 'Pending' 
         
            ");

        
        return $query->result_array();

    }

    public function get_upload_history()
    {
        $query = $this->_DB2->query(
            "SELECT
                *
            FROM
                `upload_history`
            WHERE
                `tenant_type` = 'Long Term Tenants'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
     
        ");

        return $query->result_array();

    }

    public function get_tsmsusers_data($id)
    {
        $query = $this->_DB2->query(
            "SELECT
                    *
                FROM
                    `add_users` `au`
                WHERE
                    `au`.`id` 
                AND
                    `au`.`id` = '$id'
                LIMIT 1
        ");

        return $query->result_array();
    }


    

    public function update_hourly($data, $id_to_update, $tbl_name) 
    {           
            
        $this->_DB2->where('id', $id_to_update);
        $this->_DB2->update($tbl_name, $data);
        
        if($this->_DB2->affected_rows()> 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function update($data, $id, $tbl_name)
    {
        $this->_DB2->where('id', $id);
        $this->_DB2->update($tbl_name, $data);

        if ($this->_DB2->affected_rows() > 0) 
        {
            return TRUE;
        } else { 
            return FALSE;
        } 
    }

    public function approve_hourly_sales2($data, $txtfile_name, $tbl_name)
    {
        $this->_DB2->where('txtfile_name', $txtfile_name);
        $this->_DB2->update($tbl_name, $data);

        if ($this->_DB2->affected_rows() > 0) 
        {
            return TRUE;
        } else { 
            return FALSE;
        } 
    }

     public function approve_daily_sales2($data, $id, $tbl_name)
    {
        $this->_DB2->where('id', $id);
        $this->_DB2->update($tbl_name, $data);

        if ($this->_DB2->affected_rows() > 0) 
        {
            return TRUE;
        } else { 
            return FALSE;
        } 
    }

    public function get_stores(){
        $query = $this->_DB1->query(
            "SELECT 
                *
            FROM    
                `stores`
            ORDER BY 
                store_name
            ");

        return $query->result_array();
    }

    public function check_store($id){
        $query = $this->_DB1->query(
            "SELECT 
                `id` 
            FROM    
                `stores` 
            WHERE 
                `store_name` = '$id' 
            LIMIT 1

            ")->row()->id;
        
        return empty($query) ;
    }

    

    public function store_id($info)
    {
        $store = $this->_DB1->query(
            "SELECT 
                `id` 
            FROM    
                `stores` 
            WHERE 
                `store_name` = '$info'
            OR
                `id` = '$info'
            LIMIT 1
            ")->row();
        
        return empty($store) ? 0 : $store->id;
    }

    public function verify_user($id)
    {
        $query = $this->db->query(
            "SELECT 
                `id` 
            FROM    
                `add_users` 
            WHERE 
                `id` = '$id' 
            ")->result_array();


        if(count($query) > 0) {
            return TRUE;
        }

        return FALSE;
    }


    public function check_user($id, $password)
    {   
        $password = md5($password);

        $query = $this->db->query(
            "SELECT 
                `id` 
            FROM    
                `add_users` 
            WHERE 
                `id` = '$id'
            AND 
                `password` = '$password';
            ")->result_array();


        if(count($query) > 0) {
            return TRUE;
        }

        return FALSE;
    }

    public function disapprove_hourly_sales($data, $txtfile_name, $tbl_name)
    {
        $this->_DB2->where('txtfile_name', $txtfile_name);
        $this->_DB2->update($tbl_name, $data);

        if ($this->_DB2->affected_rows() > 0) 
        {
            return TRUE;
        } else { 
            return FALSE;
        } 
    }

    public function disapprove_daily_sales($data, $id, $tbl_name)
    {
        $this->_DB2->where('id', $id);
        $this->_DB2->update($tbl_name, $data);

        if ($this->_DB2->affected_rows() > 0) 
        {
            return TRUE;
        } else { 
            return FALSE;
        } 
    }

       public function checked_and_audited($data, $id, $tbl_name)
    {
        $this->_DB2->where('id', $id);
        $this->_DB2->insert($tbl_name, $data);

        if ($this->_DB2->affected_rows() > 0) 
        {
            return TRUE;
        } else {
            return FALSE;
        } 
    }


     public function save_totalmonthly_sales($data, $tbl_name)
    {
        $this->_DB2->insert($tbl_name, $data);

        if ($this->_DB2->affected_rows() > 0) 
        {
            return TRUE;
        } else {
            return FALSE;
        } 
    }

    public function checked_and_audited_m($data, $id, $tbl_name)
    {
        $this->_DB2->where('id', $id);
        $this->_DB2->insert($tbl_name, $data);

        if ($this->_DB2->affected_rows() > 0) 
        {
            return TRUE;
        } else {
            return FALSE;
        } 
    }

    public function hourly_history_record($data, $tbl_name)
    {
       
        $this->_DB2->insert($tbl_name, $data);

        if ($this->_DB2->affected_rows() > 0) 
        {
            return TRUE;
        } else {
            return FALSE;
        } 
    }

    public function delete($tbl_name, $where, $value)
    {
        $this->_DB2->where($where, $value);
        $this->_DB2->delete($tbl_name);

        if($this->_DB2->affected_rows() > 0)
        {
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function get_hourly_sales()
    {

            $query = $this->_DB2->query(
                "SELECT
                    `id`,
                    `tenant_code`,
                    `pos_num`,
                    `transac_date`,
                    `hour_code`,
                    `netsales_amount_hour`,
                    `numsales_transac_hour`,
                    `customer_count_hour`,
                    `totalnetsales_amount_hour`,
                    `totalnumber_sales_transac`,
                    `total_customer_count_day`,
                    `status`,
                    `tenant_type`,
                    `rental_type`,
                    `trade_name`,
                    `tenant_type_code`,
                    `date_upload`,
                    `location_code`,
                    `txtfile_name`,
                    min(`hour_code`) as hour_code
                FROM
                    `tenant_hourly_sales`
                WHERE
                    `status` != 'Unmatched'
                AND
                    `status` != 'Confirmed and Audited'
                AND
                    `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
                GROUP BY
                    `txtfile_name`, `date_upload`
                ORDER BY
                    `transac_date` ASC, `trade_name` ASC
            ");

            $result = $query->result_array();
            foreach ($result as $key => $rs) {

                $status2 = array_filter($this->view_hourly_sales($rs['transac_date'], $rs['tenant_code'], $rs['date_upload'], $rs['pos_num']), function($hs){
                    return $hs['status'] == 'Unconfirmed';
                });

                $result[$key]['status'] = count($status2) > 0 ? 'Unconfirmed' : 'Confirmed';
            }

        return $result;
    }

    public function get_unhourly_sales()
    {

        $query = $this->_DB2->query(
            "SELECT
                `id`,
                `tenant_code`,
                `pos_num`,
                `transac_date`,
                `hour_code`,
                `netsales_amount_hour`,
                `numsales_transac_hour`,
                `customer_count_hour`,
                `totalnetsales_amount_hour`,
                `totalnumber_sales_transac`,
                `total_customer_count_day`,
                `status`,
                `tenant_type`,
                `rental_type`,
                `trade_name`,
                `tenant_type_code`,
                `date_upload`,
                `location_code`,
                `txtfile_name`,
                min(`hour_code`) as hour_code
            FROM
                `tenant_hourly_sales`
            WHERE
                `status` = 'Unmatched'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            GROUP BY
                `txtfile_name`, `date_upload`
            ORDER BY
                `transac_date`
        ");
       

        $result = $query->result_array();
            foreach ($result as $key => $rs) {

                $status2 = array_filter($this->view_hourly_sales($rs['transac_date'], $rs['tenant_code'], $rs['date_upload'], $rs['pos_num']), function($hs){
                    return $hs['status'] == 'Unmatched';
                });

                $result[$key]['status'] = count($status2) > 0 ? 'Unmatched' : 'Confirmed';
            }

        return $result;
    }

    public function confirmed_hourly_sales()
    {
        $query;
            $query = $this->_DB2->query(
                "SELECT
                    `id`,
                    `tenant_code`,
                    `pos_num`,
                    `transac_date`,
                    `hour_code`,
                    `netsales_amount_hour`,
                    `numsales_transac_hour`,
                    `customer_count_hour`,
                    `totalnetsales_amount_hour`,
                    `totalnumber_sales_transac`,
                    `total_customer_count_day`,
                    `status`,
                    `tenant_type`,
                    `rental_type`,
                    `trade_name`,
                    `tenant_type_code`,
                    `date_upload`,
                    `prospect_id`,
                    `txtfile_name`,
                    min(`hour_code`) as hour_code
                FROM
                    `tenant_hourly_sales`
                WHERE
                    `status` = 'Pending'
                GROUP BY
                    `txtfile_name`
         
            ");

        return $query->result_array();
    }

    public function get_hourly_total()
    {
            
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `confirmed_hourly_sales` 
         
            ");

        return $query->result_array();
    }

    public function get_upload_status(){
    
        $query = $this->_DB2->query(
            "SELECT
                `add_users`.`id`,
                `add_users`.`name`,                       
                `add_users`.`last_name`,
                `add_users`.`username`,
                `add_users`.`password`,
                `add_users`.`user_type`
            FROM
                `add_users`
            WHERE
                `add_users`.`id`
     
            ORDER BY 
                `name`
            AND
                    `ths`.`id` = '" . $this->_user_group . "'
        ");

        return $query->result_array();
    }

        function get_hourlysales_data($id)
    {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `tenant_hourly_sales`
                WHERE
                    `id` = '$id'
                
            ");
          
        return $query->result_array();
    }

    function get_disapprove_hourly_data($id)
    {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `tenant_hourly_sales`
                WHERE
                    `id` = '$id'
                
            ");
          
        return $query->result_array();
    }

    public function for_leasing_data($tenant_list, $trade_name)
    {
        $query = $this->_DB2->query(
            "SELECT
                *
            FROM
                `data_for_leasing`
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$trade_name'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            ");
        return $query->result_array();
    }

     function for_approvement_data($transac_date, $trade_name)
    {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `tenant_hourly_sales`
                WHERE
                    `transac_date` = '$transac_date'
                AND
                    `trade_name` = '$trade_name'
                
            ");
          
        return $query->result_array();
    }

    public function get_uploadhistory_data($id)
    {
        $query = $this->_DB2->query(
            "SELECT
                *
            FROM
                `upload_history`
            WHERE
                `id` = '$id'


            ");
    }

        public function get_daily_sales()
    {
            $query = $this->db->query(
                "SELECT
                    `td`.`id`,
                    `td`.`tenant_code`,
                    `td`.`pos_num`,
                    `td`.`transac_date`,
                    `td`.`old_acctotal`,
                    `td`.`new_acctotal`,
                    `td`.`total_gross_sales`,
                    `td`.`total_nontax_sales`,
                    `td`.`total_sc_discounts`,
                    `td`.`total_pwd_discounts`,
                    `td`.`total_discounts_w_approval`,
                    `td`.`total_discounts_wo_approval`,
                    `td`.`other_discounts`,
                    `td`.`total_refund_amount`,
                    `td`.`total_taxvat`,
                    `td`.`total_other_charges`,
                    `td`.`total_service_charge`,
                    `td`.`total_net_sales`,
                    `td`.`total_cash_sales`,
                    `td`.`total_charge_sales`,
                    `td`.`total_gcother_values`,
                    `td`.`total_void_amount`,
                    `td`.`total_customer_count`,
                    `td`.`control_num`,
                    `td`.`total_sales_transaction`,
                    `td`.`sales_type`,
                    `td`.`total_netsales_amount`,
                    `td`.`status`,
                    `td`.`tenant_type`,
                    `td`.`rental_type`,
                    `td`.`trade_name`,
                    `td`.`tenant_type_code`,
                    `td`.`date_upload`,
                    `td`.`location_code`,
                    `td`.`txtfile_name`,
                    `td`.`adjustment`
                FROM
                    `agc-tsms`.`tenant_daily_sales` `td`
                    
                WHERE
                    `td`.`status` != 'Unmatched'
                AND
                    `td`.`status` != 'Confirmed and Audited'
                AND
                    `td`.`tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
                
                ORDER BY
                    `transac_date`
            ");
            //GROUP BY
            //        `txtfile_name`
       

        return $query->result_array();
    }

    public function get_undaily_sales()
    {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `tenant_daily_sales`
                WHERE
                    `status` = 'Unmatched'
                AND
                    `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            ");
       

        return $query->result_array();
    }

    public function validate_update_daily($id)

    {
        $query = $this->_DB2->query(
            "SELECT
                *
                FROM
                    `confirmed_daily_sales`
                WHERE
                   
                    `id` = '$id'
            ");

    }

    function get_dailysales_data($id)
        {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `tenant_daily_sales`
                WHERE
                    `id` = '$id'
                AND
                    `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
                LIMIT 1
         
            ");
          
        return $query->result_array();
        }

    function get_inputsales_data($id)
        {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `input_sales_data`
                WHERE
                    `id` = '$id'
                AND
                    `location_code` LIKE '%" . $this->session->userdata('store_code') . "%'
                LIMIT 1
         
            ");
          
        return $query->result_array();
        }

    function get_variance_data($id)
        {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `variance_report`
                WHERE
                    `id` = '$id'
                LIMIT 1
         
            ");
          
        return $query->result_array();
        }

    function get_undailysales_data($id)
    {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `tenant_daily_sales`
                WHERE
                    `id` = '$id'
                AND
                    `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
                LIMIT 1
         
            ");
          
        return $query->result_array();
    }

      function get_pending_data($id)
        {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `confirmed_daily_sales`
                WHERE
                    `id` = '$id'
                AND
                    `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
                LIMIT 1
         
            ");
          
        return $query->result_array();
        }


    public function get_tenant_name()
    {

            $query = $this->_DB1->query(
                "SELECT
                    `pt`.`id`,
                    `pt`.`trade_name`
                FROM
                    `prospect` `pt`
         
            ");
        

        return $query->result_array();
    }


    public function get_tenants($flag)
    {   
        $flag = urldecode($flag);

        $type;
        if ($flag == 'Long Term Tenants') 
        {
            $type = "Long Term";
        }
        else
        {
            $type = "Short Term";
        }


        $query = $this->_DB1->query(
            "SELECT 
                `prospect`.`trade_name`
            FROM 
                `prospect`
            LEFT JOIN
                `tenants`
            ON
                `prospect`.`id` = `tenants`.`prospect_id`
            WHERE
                `prospect`.`flag` = '$type'
            AND
                `prospect`.`status` = 'On Contract'
            AND
                `tenants`.`rental_type` != 'Fixed'
            AND
                `tenants`.`status` = 'Active'
            AND
                `tenant_id` LIKE '%" . $this->session->userdata('store_code') . "%'
            GROUP BY 
                `prospect`.`trade_name`

            ORDER BY
                `trade_name`

        ");

        //var_dump($query->result_array());

        return $query->result_array();

    }

    public function get_delupload_status($trade_name,$txtfile_name)
    {
        $query = $this->_DB2->query(
            "SELECT
                `id`,
                `tenant_name`,
                `date_upload`,
                `location_code`,
                `txtfile_name`
            FROM
                `upload_status`
            WHERE
                `tenant_name` = '$trade_name'
            AND
                `txtfile_name` LIKE '%$txtfile_name%'
            AND `location_code` LIKE '%" . $this->session->userdata('store_code') . "%'

            ");

            return $query->result_array();
    }

    public function get_fixed_tenants($flag)
    {
        $type;
        if ($flag == 'Long Term Tenants') 
        {
            $type = "Long Term";
        }
        else
        {
            $type = "Short Term";
        }


        $query = $this->_DB1->query(
            "SELECT 
                `prospect`.`trade_name`
            FROM 
                `prospect`
            LEFT JOIN
                `tenants`
            ON
                `prospect`.`id` = `tenants`.`prospect_id`
            WHERE
                `prospect`.`flag` = '$type'
            AND
                `prospect`.`status` = 'On Contract'
            AND
                `tenants`.`status` = 'Active'
            AND
                `tenants`.`rental_type` = 'Fixed'
            AND
                `tenant_id` LIKE '%" . $this->session->userdata('store_code') . "%'
            GROUP BY
                `trade_name`
            ORDER BY
                `trade_name`


        ");

        return $query->result_array();

    }

    public function get_location_code($trade_name)
    {       
        $store = $this->session->userdata('store_code');

        $query = $this->_DB1->query("
            SELECT 
                l.location_code,
                t.rental_type
            FROM 
                tenants t
            LEFT JOIN
                prospect p
            ON 
                t.prospect_id = p.id
            LEFT JOIN
                location_code l
            ON 
                t.locationCode_id = l.id
            WHERE
                p.trade_name = '$trade_name'
            AND 
                t.status = 'Active'
            AND 
                l.location_code LIKE '%$store%'
        ");

        /*$query = $this->_DB1->query(
            "SELECT
                    `lc`.`location_code`,
                    `t`.`rental_type`
                FROM
                    tenants t,
                    prospect p,
                    location_code lc
                WHERE
                    t.prospect_id = p.id
                AND
                    p.trade_name = '$trade_name'
                AND
                    t.status = 'Active'
                AND
                    t.locationCode_id = lc.id
                AND
                    lc.status = 'Active'
                AND
                    `location_code` LIKE '%" . $this->session->userdata('store_code') . "%' 
        ");*/

     
        return $query->result_array();
    }

    public function get_rental_type($location_code)
    {
        
        $query = $this->_DB1->query(
            "SELECT 
                `rental_type`
            FROM 
                tenants t,
                prospect p,
                location_code lc
            WHERE
                t.prospect_id = p.id
            AND
                lc.location_code = '$location_code'
            AND
                t.status = 'Active'
            AND
                t.locationCode_id = lc.id
            AND
                lc.status = 'Active' 
            LIMIT 1
        ");

        return $query->result_array();
    }

    public function get_tenantList_daily()
    {

        $query = $this->db->query(
            "SELECT  p.trade_name, l.location_code, MAX(u.date_upload) as last_upload
            FROM `agc-pms`.`prospect` p
            LEFT JOIN `agc-pms`.`tenants` t
            ON p.id = t.prospect_id
            LEFT JOIN `agc-pms`.`location_code` l
            ON t.locationCode_id = l.id
            LEFT JOIN `agc-tsms`.`upload_status` u
            ON l.location_code = u.location_code
            WHERE p.status = 'On Contract'
            AND t.status = 'Active'
            AND t.rental_type != 'Fixed'
            AND l.location_code  LIKE ?
            GROUP BY l.location_code
            ORDER BY p.trade_name ASC, u.id DESC", ["%" . $this->session->userdata('store_code') . "%"]);

        /*$query = $this->db->query(

            "SELECT 
                `prospect`.`trade_name`,
                max(`upload_status`.`date_upload`) as id
            FROM 
                `agc-pms`.`prospect`
            LEFT JOIN
                `agc-tsms`.`upload_status`
            ON
                `prospect`.`trade_name` = `upload_status`.`tenant_name`
            LEFT JOIN
                `agc-pms`.`tenants`
            ON
                `prospect`.`id` = `tenants`.`prospect_id`
            WHERE
                `prospect`.`status` = 'On Contract'
            AND
                `tenants`.`rental_type` != 'Fixed'
            AND
                `tenants`.`status` = 'Active'
            AND
                `tenants`.`tenant_id` LIKE '%" . $this->session->userdata('store_code') . "%'
            GROUP BY
                `prospect`.`trade_name`
        ");*/

        return $query->result_array();

    }

     public function get_tenantList_hourly()
    {

        $query = $this->db->query(

            "SELECT 
                `prospect`.`trade_name`,
                max(`upload_status_hourly`.`date_upload`) as id
            FROM 
                `agc-pms`.`prospect`
            LEFT JOIN
                `agc-tsms`.`upload_status_hourly`
            ON
                `prospect`.`id` = `upload_status_hourly`.`prospect_id`
            LEFT JOIN
                `agc-pms`.`tenants`
            ON
                `prospect`.`id` = `tenants`.`prospect_id`
            WHERE
                `prospect`.`status` = 'On Contract'
            AND
                `tenants`.`rental_type` != 'Fixed'
            GROUP BY
                `prospect`.`trade_name`


        ");

        return $query->result_array();

    }

    public function filter_sales($tenant_list,$trade_name,$filter_date, $tenant_code)
    {
        if($filter_date == ''){
            $query = NULL;
        }else{
        $query = $this->_DB2->query(
            "SELECT
                   *
            FROM
                `confirmed_hourly_sales` 
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$trade_name'
            AND 
                `transac_date` = '$filter_date'
            AND
                `status` = 'Confirmed'
            AND
                `tenant_code` LIKE '%$tenant_code%'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            ORDER BY
                `transac_date`
            ");

            return $query->result_array();
        }
    }

    public function filter_sales_m($tenant_type,$trade_name,$filter_date, $tenant_code)
    {

        $query = $this->db->query(
        "SELECT
                    `cds`.`id`,
                    `cds`.`tenant_code`,
                    `cds`.`pos_num`,
                    `cds`.`transac_date`,
                    `cds`.`old_acctotal`,
                    `cds`.`new_acctotal`,
                    `cds`.`total_gross_sales`,
                    `cds`.`total_nontax_sales`,
                    `cds`.`total_sc_discounts`,
                    `cds`.`total_pwd_discounts`,
                    `cds`.`total_discounts_w_approval`,
                    `cds`.`total_discounts_wo_approval`,
                    `cds`.`other_discounts`,
                    `cds`.`total_refund_amount`,
                    `cds`.`total_taxvat`,
                    `cds`.`total_other_charges`,
                    `cds`.`total_service_charge`,
                    `cds`.`total_net_sales`,
                    `cds`.`total_cash_sales`,
                    `cds`.`total_charge_sales`,
                    `cds`.`total_gcother_values`,
                    `cds`.`total_void_amount`,
                    `cds`.`total_customer_count`,
                    `cds`.`control_num`,
                    `cds`.`total_sales_transaction`,
                    `cds`.`sales_type`,
                    `cds`.`total_netsales_amount`,
                    `cds`.`status`,
                    `cds`.`tenant_type`,
                    `cds`.`rental_type`,
                    `cds`.`trade_name`,
                    `cds`.`tenant_type_code`,
                    `cds`.`date_upload`,
                    `cds`.`location_code`,
                    `cds`.`txtfile_name`,
                    `cds`.`approved_by`,
                    `cds`.`adjustment`,
                    `tenant`.`sales`
            FROM 
                `agc-tsms`.`confirmed_daily_sales` `cds`
            LEFT JOIN
                (SELECT
                    t.`sales`, l.`location_code`
                FROM
                    `agc-pms`.`tenants` t
                LEFT JOIN
                    `agc-pms`.`location_code` l
                ON
                    `t`.`locationCode_id` = `l`.`id`
                WHERE
                    `l`.`location_code` LIKE '%$tenant_code%'
                AND 
                    `t`.`status` = 'active'
                LIMIT 1) `tenant`
            ON 
                `cds`.`tenant_code` LIKE  CONCAT('%', tenant.location_code, '%')
            
            WHERE
                `cds`.`tenant_type` = '$tenant_type'
            AND 
                `cds`.`tenant_code` LIKE '%$tenant_code%'
            AND
                `cds`.`trade_name` = '$trade_name'
            AND 
                `cds`.`transac_date` LIKE '%$filter_date%'
            AND 
                `cds`.`status` = 'Confirmed'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            ORDER BY
                `transac_date`, `pos_num`
            ");

        //die($this->db->last_query());
        return $query->result_array();

    }

    public function filter_sales_m1($trade_name)
    {
        if($filter_date == '')
        {
            $query = NULL;
        }else{

        $query = $this->db->query(
        "SELECT
                `cds`.`location_code`
            FROM 
                `agc-tsms`.`confirmed_daily_sales` `cds`
            WHERE
                `cds`.`trade_name` = '$trade_name'
            AND 
                `cds`.`status` = 'Confirmed'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            ORDER BY
                `transac_date`

            ");

        return $query->result_array();
        }

    }

    public function sales_type($location_code)
    {
        $query = $this->db->query(
            "SELECT
                `sales`
            FROM
                `agc-pms`.`tenants`
            LEFT JOIN
                `agc-pms`.`location_code`
            ON
                `tenants`.`locationCode_id` = `location_code`.`id`
            WHERE
                `location_code`.`location_code` = '$location_code'
            ");
        
        return $query->row()->sales;

    }
    public function history_hourly_sales()
    {   
        $query = $this->_DB2->query(
            "SELECT
                *
            FROM
                `tenant_hourly_sales`
            WHERE
                `status` = 'Confirmed and Audited'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
        ");

        return $query->result_array();
    }

    public function filter_hourly_history_sales($tenant_type, $trade_name, $tenant_code, $date){
        $ths = $this->db->query("
            SELECT
                *
            FROM 
                tenant_hourly_sales
            WHERE
                status = 'Confirmed and Audited'
            AND
                tenant_type = ?
            AND 
                trade_name = ?
            AND 
                tenant_code LIKE ?
            AND
                transac_date LIKE ?
            AND
                `tenant_code` LIKE ?
            ORDER BY
                transac_date

            ", [$tenant_type, $trade_name, '%'.$tenant_code.'%', "%$date%", "%".$this->session->userdata('store_code')."%"]);
    
        return $ths->result_array();
    }


    public function filter_daily_history_sales($tenant_type, $trade_name, $tenant_code, $date){
        $tds = $this->db->query("
            SELECT
                *
            FROM 
                tenant_daily_sales
            WHERE
                status = 'Confirmed and Audited'
            AND
                tenant_type = ?
            AND 
                trade_name = ?
            AND 
                tenant_code LIKE ?
            AND
                transac_date LIKE ?
            AND
                `tenant_code` LIKE ?
            ORDER BY
                transac_date

            ", [$tenant_type, $trade_name, '%'.$tenant_code.'%', "%$date%", "%".$this->session->userdata('store_code')."%"]);
    
        return $tds->result_array();
    }

    public function history_daily_sales()
    {
        $query = $this->_DB2->query(
            "SELECT
                *
            FROM
                `tenant_daily_sales`
            WHERE
                `status` = 'Confirmed and Audited'
            AND
            `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
     
        ");

        return $query->result_array();
    }

    public function save_total_sales($tenant_list,$tenant_name,$filter_date, $tenant_code)
    {

        $query = $this->_DB2->query(
        "SELECT
                   *
            FROM
                `total_monthly_sales` 
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$tenant_name'
            AND 
                `date_end` = '$filter_date'
            AND
                `tenant_code` = '$tenant_code'
        ");

        return $query->result_array();

    }

    public function data_for_leasing($tenant_list,$tenant_name,$filter_date,$total_netsales_amount_data)
    {

        $query = $this->_DB2->query(
        "SELECT
                   *
            FROM
                `total_monthly_sales` 
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$tenant_name'
            AND 
                `date_end` = '$filter_date'
            AND 
                `total_netsales_amount` = '$total_netsales_amount_data'

            ");

        return $query->result_array();

    }

    public function percentage_sales($tenant_type,$trade_name,$date_end,$total_netsales_amount)
    {
        $query = $this->_DB1->query(
            " SELECT *
            FROM
                `percentage_of_sales`
            WHERE
                `tenant_type` = '$tenant_type'
            AND
                `trade_name` = '$trade_name'
            AND
                `date_end` = '$date_end'
            AND
                `total_netsales_amount` = '$total_netsales_amount'
            
            ");

        return $query->result_array();
    }

    public function monthly_total($tenant_list,$filter_date)
    {
        $query = $this->_DB2->query(
            "SELECT
                   *
            FROM
                `total_monthly_sales`
            WHERE
                `tenant_type` = '$tenant_list'
            AND 
                `date_end` = '$filter_date'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'

            ");

        return $query->result_array();
    }

    public function tenants_sales_report($tenant_list,$filter_date)
    {
        $query = $this->_DB2->query(
            "SELECT
                   *
            FROM
                `total_monthly_sales`
            WHERE
                `tenant_type` = '$tenant_list'
            AND 
                `date_end` = '$filter_date'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            ");

        return $query->result_array();
    }

    public function fixed_monthly_total($tenant_list,$filter_date)
    {
        $query = $this->_DB2->query(
            "SELECT
                   *
            FROM
                `input_sales_data`
            WHERE
                `tenant_type` = '$tenant_list'
            AND 
                `date` LIKE '%$filter_date%'

            ");

        return $query->result_array();
    }

     public function pending_items($tenant_list,$trade_name,$filter_date)
    {
        $query = $this->_DB2->query(
            "SELECT
                   *
            FROM
                `confirmed_daily_sales`
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$trade_name'
            AND 
                `transac_date` LIKE '%$filter_date%'
            AND
                `status` = 'Pending'

            ");

        return $query->result_array();
    }

     public function for_approvement()
    {
        $query = $this->_DB2->query(
            "SELECT
                   *
            FROM
                `confirmed_daily_sales`
            WHERE
                `status` = 'Pending'

            ");

        return $query->result_array();
    }

    public function leasing_data($tenant_list,$trade_name)
    {
        $query = $this->_DB2->query(
            "SELECT
                   *
            FROM
                `total_monthly_sales`
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$trade_name'

            ");

        return $query->result_array();
    }

    function get_monthly_total($id)
        {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `total_monthly_sales`
                WHERE
                    `total_monthly_sales`.`id` = '$id'
                LIMIT 1
         
            ");
          
        return $query->result_array();
        }

    public function monthly_report($tenant_list, $trade_name, $filter_date)
    {
        if(empty($filter_date) || empty($tenant_list) || empty($trade_name))
            return NULL;
        
        $query = $this->_DB2->query(
        "SELECT
                   `transac_date`,
                   `total_net_sales`,
                   `total_sc_discounts`,
                   `other_discounts`,
                   `total_gross_sales`,
                   `total_pwd_discounts`,
                   `total_nontax_sales`,
                   `total_taxvat`,
                   `total_cash_sales`
            FROM
                `confirmed_daily_sales` 
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$trade_name'
            AND 
                `transac_date` LIKE '%$filter_date%'
            AND 
                `status` = 'Confirmed'
            ORDER BY
                `transac_date`
        ");

        return $query->result_array();
   
    }

    function get_leasing_data($id)
    {
            $query = $this->_DB2->query(
                "SELECT
                    *
                FROM
                    `data_for_leasing`
                WHERE
                    `data_for_leasing`.`id` = '$id'
                AND
                    `tenant_code` LIKE '%" .$this->session->userdata('store_code') . "%'
                LIMIT 1
            ");
          
        return $query->result_array();
    }

    public function get_leasing_data_to_delete($id){
        $query = $this->_DB2->query(
        "SELECT 
            *
        FROM
            `data_for_leasing`
        WHERE
            `id` = '$id'
        AND
            `tenant_code` LIKE '%" .$this->session->userdata('store_code') . "%'
        LIMIT 1
        ");

        return (array)$query->row();
    }

    public function get_data_for_sales_db($id){
        $query = $this->_DB2->query(
        "SELECT 
            *
        FROM
            `data_for_leasing`
        WHERE
            `id` = '$id'
        AND 
            `status` = 'Pending'
        AND
            `tenant_code` LIKE '%" .$this->session->userdata('store_code') . "%'
        LIMIT 1
        ");

        return (array)$query->row();
    }

    public function upload_to_leasing($id)
    {
        $query = $this->_DB2->query(
            "SELECT 
                *
            FROM
                `data_for_leasing`
            WHERE
                `id` = '$id'
            LIMIT 1

            ");

        return $query->result_array();
    }

    public function get_hourly_sales_to_confirm($id){
        $query = $this->_DB2->query(
            "SELECT 
                *
            FROM
                `tenant_hourly_sales`
            WHERE
                `id` = '$id'
            LIMIT 1
            ");
        
        return $query->row();
    
    }

    public function check_confirmed_hourly_existence($tenant_type, $trade_name, $location_code, $transac_date, $hour_code, $pos_num){

        $query = $this->_DB2->query(
            "SELECT 
                *
            FROM
                `confirmed_hourly_sales`
            WHERE
                tenant_type = ?
            AND 
                trade_name = ?
            AND 
                pos_num = ?
            AND 
                location_code LIKE ?
            AND 
                transac_date = ?
            AND 
                hour_code LIKE ?
            ", [$tenant_type, $trade_name, $pos_num, "%$location_code%", $transac_date, "%$hour_code%"]);

        return count($query->result_array()) > 0 ? TRUE : FALSE;
    }

    public function check_hourly_sales($id)

    {
        $query = $this->_DB2->query(
            "SELECT 
                *
            FROM
                `tenant_hourly_sales`
            WHERE
                `id` = '$id'
            LIMIT 1

            ");
        
        return $query->result_array();
    }

    public function check_pending_hourly_sales($txtfile_name)

    {
        $query = $this->_DB2->query(
            "SELECT 
                *
            FROM
                `tenant_hourly_sales`
            WHERE
                `txtfile_name` = '$txtfile_name'

            ");
        
        return $query->result_array();
    }

    public function check_pending_daily_sales($id)

    {
        $query = $this->_DB2->query(
            "SELECT 
                *
            FROM
                `tenant_daily_sales`
            WHERE
                `id` = '$id'

            ");
        
        return $query->result_array();
    }

    public function check_hourly_sales_record($id)

    {
        $query = $this->_DB2->query(
            "SELECT 
                `status`
            FROM
                `tenant_hourly_sales`
            WHERE
                `id` = '$id'
            ");
        
        return $query->result_array();
    }

    public function validate_hourly_sales($id)

    {
        $query = $this->_DB2->query(
            "SELECT 
                status
            FROM
                tenant_hourly_sales
            WHERE
                id = '$id'
            AND
                (status = 'Unconfirmed'
            OR
                status = 'Unmatched')
        ");

        
        return $query->result_array();
    }

    public function validate_unmatched($id)

    {
        $query = $this->_DB2->query(
            "SELECT 
                `status`
            FROM
                `tenant_hourly_sales`
            WHERE
                `id` = '$id'
            AND
                `status` = 'Unmatched'
            ");
        
        return $query->result_array();
    }

    public function validate_disapprove_hourly($id)

    {
        $query = $this->_DB2->query(
            "SELECT 
                `status`
            FROM
                `disapproved_data_hourly`
            WHERE
                `id` = '$id'
            AND
                `status` = 'To be reviewed'
            

            ");
        
        return $query->result_array();
    }


    public function home_chart($date_end)
    {
        $query = $this->db->query(
            "SELECT
                `tm`.`total_net_sales`,
                `tm`.`trade_name`,
                `tm`.`date_end`
            FROM
                `agc-tsms`.`total_monthly_sales` `tm`
            WHERE
                `date_end` = '$date_end'
            AND
                `tm`.`tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            ");
        
        return $query->result_array();
    }

    public function get_daily_unconfirmed(){

        $store  = $this->session->userdata('store_code');

        $query = $this->db->query("
            SELECT 
                * 
            FROM 
                tenant_daily_sales 
            WHERE 
                status = 'unconfirmed' 
            AND 
                tenant_code LIKE ?", "%$store%")->result_array();

        return $query;
    }

    public function get_daily_unmatched(){

        $store  = $this->session->userdata('store_code');
        
        $query = $this->db->query("
            SELECT 
                * 
            FROM 
                tenant_daily_sales 
            WHERE 
                status = 'unmatched' 
            AND 
                tenant_code LIKE ?",["%$store%"])->result_array();

        return $query;
    }

    public function get_hourly_unconfirmed(){
        $store  = $this->session->userdata('store_code');

        $query = $this->db->query("
            SELECT 
                * 
            FROM 
                tenant_hourly_sales 
            WHERE 
                status = 'unconfirmed' 
            AND 
            tenant_code LIKE ?", ["%$store%"] )->result_array();

        return $query;
    }


    public function get_hourly_unmatched(){
        $store  = $this->session->userdata('store_code');

        $query = $this->db->query("
            SELECT 
                * 
            FROM 
                tenant_hourly_sales 
            WHERE 
                status = 'unmatched' 
            AND 
            tenant_code LIKE ?", ["%$store%"] )->result_array();

        return $query;
    }

    public function get_variance_pending(){

        $store  = $this->session->userdata('store_code');

        $query = $this->db->query("
            SELECT
                * 
            FROM 
                variance_report 
            WHERE 
                status = 'pending' 
            AND 
                tenant_code LIKE ?", ["%$store%"])->result_array();

        return $query;
    }

    public function get_leasing_pending(){

        $store  = $this->session->userdata('store_code');

        $query = $this->db->query("
            SELECT
                * 
            FROM 
                data_for_leasing 
            WHERE 
                status = 'pending' 
            AND 
                tenant_code LIKE ?", ["%$store%"])->result_array();

        return $query;
    }

    public function get_lastest_monthly_sale_date(){
        $store  = $this->session->userdata('store_code');
        $query = $this->_DB2->query(
            "SELECT
                MAX(date_end) as max_date
            FROM
                    `total_monthly_sales`
            WHERE
                tenant_code LIKE ?", ["%$store%"]);

        return $query->row();
    }
    public function latest_12_month_sale($date_end){
        $store  = $this->session->userdata('store_code');
        $query = $this->_DB2->query(
            "SELECT
                SUM(total_gross_sales) as total_gross_sales,
                SUM(total_netsales_amount) as total_netsales_amount
                FROM
                    `total_monthly_sales`
                WHERE
                    `date_end` = '$date_end'
                AND
                    tenant_code LIKE ?", ["%$store%"]);

        return $query->row();

    }

    public function chart_tenant_yearly_rec($tenant_list, $trade_name, $date_end){

        $query = $this->_DB2->query(
            "SELECT
                `total_gross_sales`,
                `total_netsales_amount`,
                `date_end`

                FROM
                    `total_monthly_sales`
                WHERE
                    `tenant_type` = '$tenant_list'
                AND
                    `trade_name`  = '$trade_name'
                AND
                    `date_end` = '$date_end'
                LIMIT 1
            ");

        return $query->row();

    }

    public function chart_data($tenant_list, $trade_name, $date_end)
    {
        $query = $this->_DB2->query(
            "SELECT
                `total_gross_sales`,
                `total_netsales_amount`,
                `date_end`

                FROM
                    `total_monthly_sales`
                WHERE
                    `tenant_type` = '$tenant_list'
                AND
                    `trade_name`  = '$trade_name'
                AND
                    `date_end` LIKE '%$date_end%'
                ORDER BY
                    `date_end`
               
            ");
        return $query->result_array();
    }

  public function archive_hourly_sales()
  { 

        $table = 'tenant_hourly_sales';
        $data = ['status' => 'Confirmed and Audited'];
        $condition = "status = 'Confirmed' AND tenant_code LIKE  '%".$this->session->userdata('store_code')."%'";

        $this->_DB2->update($table, $data, $condition);

        return $this->_DB2->affected_rows() > 0 ? TRUE : FALSE;
  }

  public function id_to_update()
  {
    $query = $this->_DB2->query(
        "SELECT
            id
        FROM
            `tenant_hourly_sales`
        WHERE
            `status` = 'Confirmed'
        AND
            `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'

        ");
    return $query->result_array();
  }

  public function id_to_update_daily()
  {
    $query = $this->_DB2->query(
        "SELECT
            id
        FROM
            `tenant_daily_sales`
        WHERE
            `status` = 'Confirmed'
        AND
            `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'

        ");
    return $query->result_array();
  }

    public function archive_daily_sales()
    {
        $this->db->query("
            UPDATE 
                tenant_daily_sales 
            SET 
                status = 'Confirmed and Audited'
            WHERE
                `status` = 'Confirmed'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'");

        return $this->db->affected_rows() > 0 ? TRUE : FALSE;
    }
  
  public function validate_upload_file($file_name)
  {

    $query = $this->db->query(
        "SELECT
            `tenant_name`,
            `txtfile_name`
        FROM
            `upload_status`
        WHERE
            `txtfile_name` = '$file_name'
        ");
    return $query->result_array();
  }
   public function validate_upload_file_hourly($file_names)
  {

    $query = $this->db->query(
        "SELECT
            `tenant_name`,
            `txtfile_name`
        FROM
            `upload_status_hourly`
        WHERE
            `txtfile_name` = '$file_names'

        ");
    return $query->result_array();
  }

  public function validate_tenant_id($file_tenant_id, $prospect_id)
  {

    $query = $this->_DB1->query(
        "SELECT
            `tenant_id`,
            `prospect_id`
        FROM
            `tenants`
        WHERE
            `tenant_id` = '$file_tenant_id'
        AND
            `prospect_id` = '$prospect_id'

        ");
    return $query->result_array();
  }

  public function validate_tenant_name($location_code)
  {
    $location_code = $this->_DB1->query(
        "SELECT
            `location_code`
        FROM
            `location_code`
        WHERE
            `location_code` = '$location_code'
        LIMIT 1

        ")->row()->location_code;

     return $location_code;
  }

  public function validate_location_code($location_code)
  {
    $result = $this->_DB1->query(
        "SELECT
            `location_code`
        FROM
            `location_code`
        WHERE
            `location_code` = '$location_code'
        LIMIT 1

        ")->result_array();


     return empty($result) ? false : true;
  }

  public function match_sales($transac_date, $trade_name, $location_code="")
  {

    $query = $this->_DB2->query(
        "SELECT
            `total_net_sales`,
            `total_sales_transaction`,
            `total_customer_count`,
            `total_netsales_amount`,
            `pos_num`
        FROM
            `confirmed_daily_sales`
        WHERE
            `transac_date` = '$transac_date'
        AND
            `trade_name` = '$trade_name'
        AND
            `tenant_code` LIKE '%$location_code%'
        AND
            `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
        ");

    return (array)$query->result_array();
  }

    public function view_hourly_sales($transac_date, $tenant_code, $date_upload, $pos_num)
    {   
        $store = $this->session->userdata('store_code');

        $query = $this->_DB2->query("
            SELECT
                *
            FROM
                `tenant_hourly_sales`
            WHERE
                `transac_date` = ?
            AND
                `tenant_code` LIKE ?
            AND 
                `date_upload` LIKE ?
            AND 
                `pos_num`  = ?

        ", [$transac_date, "%$tenant_code%", "%$date_upload%", $pos_num]);
        
        return $query->result_array();
    }

    public function view_unhourly_sales($transac_date, $trade_name)
    {
        $query = $this->_DB2->query(
            "SELECT
                *
            FROM
                `tenant_hourly_sales`
            WHERE
                `transac_date` = '$transac_date'
            AND
                `trade_name` = '$trade_name'
            AND
                    `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'

            ");
        return $query->result_array();
    }

    public function view_disapprove_data_hourly($transac_date, $trade_name)
    {
        $query = $this->_DB2->query(
            "SELECT
                *
            FROM
                `disapproved_data_hourly`
            WHERE
                `transac_date` = '$transac_date'
            AND
                `trade_name` = '$trade_name'
            AND
                `status` = 'To be reviewed'

            ");
        return $query->result_array();
    }

  public function view_disapprove_data_daily($id)
  {
        $query = $this->_DB2->query(
            "SELECT
                *
            FROM
                `disapproved_data_daily`
            WHERE
                `id` = '$id'
            AND
                `status` = 'To be reviewed'

            ");
        return $query->result_array();
  }
    public function delete_hourly_sales_record($tran_date, $tenant_code, $date_upload, $pos_num){

        $this->db->query("
            DELETE 
            FROM
                tenant_hourly_sales
            WHERE 
                tenant_code LIKE ?
            AND 
                transac_date = ?
            AND 
                date_upload LIKE ?
            AND
                pos_num = ?"

            , ["%$tenant_code%", $tran_date, "%$date_upload%", $pos_num]);

       return $this->db->affected_rows();
    }

    public function delete_hourly_by_date($tbl_name, $where, $value)
    {
        $this->_DB2->where($where, $value);
        $this->_DB2->delete($tbl_name);

        if($this->_DB2->affected_rows() > 0)
        {
            return true;
        }else{
            return false;
        }
        

    }

    public function delete_unhourly_by_date($tbl_name, $where, $value)
    {
        $this->_DB2->where($where, $value);
        $this->_DB2->delete($tbl_name);

        if($this->_DB2->affected_rows() > 0)
        {
            return true;
        }else{
            return false;
        }
        

    }

    public function delete_disapprove_hourly($tbl_name, $where, $value)
    {
        $this->_DB2->where($where, $value);
        $this->_DB2->delete($tbl_name);

        if($this->_DB2->affected_rows() > 0)
        {
            return true;
        }else{
            return false;
        }
        

    }

  public function delete_disapprove_daily($tbl_name, $where, $value)
  {
        $this->_DB2->where($where, $value);
        $this->_DB2->delete($tbl_name);

        if($this->_DB2->affected_rows() > 0)
        {
            return true;
        }else{
            return false;
        }
        

  }

    public function get_disapproved_hourly()
    {

            $query = $this->_DB2->query(
                "SELECT
                    `id`,
                    `tenant_code`,
                    `pos_num`,
                    `transac_date`,
                    `hour_code`,
                    `netsales_amount_hour`,
                    `numsales_transac_hour`,
                    `customer_count_hour`,
                    `totalnetsales_amount_hour`,
                    `totalnumber_sales_transac`,
                    `total_customer_count_day`,
                    `status`,
                    `tenant_type`,
                    `rental_type`,
                    `trade_name`,
                    `tenant_type_code`,
                    `date_upload`,
                    `prospect_id`,
                    `txtfile_name`,
                    min(`hour_code`) as hour_code
                FROM
                    `disapproved_data_hourly`
                WHERE
                    `status` = 'To be reviewed'
                GROUP BY
                    `txtfile_name`

            ");
       
        return $query->result_array();
    }

     public function get_disapproved_daily()
    {

            $query = $this->_DB2->query(
                "SELECT
                    `id`,
                    `tenant_code`,
                    `pos_num`,
                    `transac_date`,
                    `old_acctotal`,
                    `new_acctotal`,
                    `total_gross_sales`,
                    `total_nontax_sales`,
                    `total_sc_discounts`,
                    `total_pwd_discounts`,
                    `other_discounts`,
                    `total_refund_amount`,
                    `total_taxvat`,
                    `total_other_charges`,
                    `total_service_charge`,
                    `total_net_sales`,
                    `total_cash_sales`,
                    `total_charge_sales`,
                    `total_gcother_values`,
                    `total_void_amount`,
                    `total_customer_count`,
                    `control_num`,
                    `total_sales_transaction`,
                    `sales_type`,
                    `total_netsales_amount`,
                    `status`,
                    `tenant_type`,
                    `rental_type`,
                    `trade_name`,
                    `tenant_type_code`,
                    `date_upload`,
                    `prospect_id`,
                    `txtfile_name`,
                    `disapproved_by`
                FROM
                    `disapproved_data_daily`
                WHERE
                    `status` = 'To be reviewed'
                GROUP BY
                    `transac_date`
            ");
       
        return $query->result_array();
    }

    public function get_monthly_total_report($tenant_list,$trade_name,$filter_date)
    {
        $query = $this->_DB2->query(
            "SELECT
                `total_net_sales`,
                `other_discounts`,
                `total_sc_discounts`,
                `total_gross_sales`,
                `total_nontax_sales`,
                `total_taxvat`,
                `total_cash_sales`,
                `total_pwd_discounts`
            FROM
                `total_monthly_sales`
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$trade_name'
            AND 
                `date_end` = '$filter_date'
            ");
        return $query->row();
    }

    

    public function fixed_sales_report($tenant_list,$filter_date)
    {
        $query = $this->_DB2->query(
            "SELECT
                   *
            FROM
                `input_sales_data`
            WHERE
                `tenant_type` = '$tenant_list'
            AND 
                `date` LIKE '%$filter_date%'

            ");

        return $query->result_array();
    }

    public function filter_sales_yearly($tenant_list,$trade_name,$year, $location_code)
    {
        if($year == '' || $tenant_list == '' || $trade_name == '')
        {
            $query = NULL;
        }else{

        $query = $this->_DB2->query(
        "SELECT
                   *
            FROM
                `total_monthly_sales` 
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$trade_name'
            AND 
                `date_end` LIKE '%$year%'
            AND
                `tenant_code` LIKE '%$location_code%'
            AND
                `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'

            ORDER BY
                `date_end`
            ");

        return $query->result_array();
        }
    }

    public function verify_yearly_sale($tenant_list,$trade_name,$year, $location_code)
    {

        $query = $this->_DB2->query(
            "SELECT
                   *
            FROM
                `tenant_yearly_sales` 
            WHERE
                `tenant_type` = '$tenant_list'
            AND
                `trade_name` = '$trade_name'
            AND 
                `year` = '$year'
            AND
                `tenant_code` LIKE '$location_code'
        ");

        return $query->result_array();
    }
    

    public function yearly_sales($tenant_list, $year, $year1)
    {
        $query = $this->db->query(
            "SELECT
                    `total_netsales_amount`,
                    `trade_name`,
                    `year`
                    
                FROM
                    `tenant_yearly_sales`
                WHERE
                    `year` = '$year'
                OR
                    `year` = '$year1'
                AND
                    `tenant_type` = '$tenant_list'
                ORDER BY
                    `trade_name`
            ");

        return $query->result_array();
    }

    public function check_input_sales_data($trade_name, $tenant_type, $total_gross_sales, $total_netsales_amount, $date)
    {
        $query = $this->db->query(
            "SELECT
                    `trade_name`,
                    `tenant_type`,
                    `total_gross_sales`,
                    `total_netsales_amount`
                FROM
                    `input_sales_data`
                WHERE
                    `trade_name` = '$trade_name'
                AND
                    `tenant_type` = '$tenant_type'
                AND
                    `total_gross_sales` = '$total_gross_sales'
                AND
                    `total_netsales_amount` = '$total_netsales_amount'
                AND
                    `date` = '$date'

            ");

        return $query->result_array();
    }

    public function get_input_sales_data()
    {
        $query = $this->db->query(
            "SELECT
                *
                FROM
                    `input_sales_data`
                WHERE
                    `location_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            ");

        return $query->result_array();
    }

    public function get_variance()
    {
        $query = $this->db->query(
            "SELECT
                *
                FROM
                    `variance_report`
                WHERE
                    `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
            ");

        return $query->result_array();
    }
    public function get_upload_data()
    {
        $query = $this->db->query(
            "SELECT
                *
                FROM
                    `data_for_leasing`
                WHERE
                    `status` = 'Pending'
                AND
                    `tenant_code` LIKE '%" . $this->session->userdata('store_code') . "%'
                ORDER BY 
                    `trade_name`

            ");

        return $query->result_array();
    }
    public function check_data_uploaded($id)
    {
        $query = $this->db->query(
            "SELECT
                    *
                FROM
                    `sales`
                WHERE
                    `id` = '$id'
                AND
                    `tenant_code` LIKE '%" .$this->session->userdata('store_code') . "%'
                


            ");
    }


    public function getData($table_name, $where ='', array $data = []){

        $stmt = "SELECT * FROM $table_name";
        if(gettype($where) == 'array'){
            $stmt.= ' WHERE'; 
         
            foreach ($where as $column => $value) {
                $stmt.=" $column = '$value' AND";
            }
            $stmt = rtrim($stmt, 'AND');
        } else {
            $stmt.= " WHERE $where";
        }
        $query = $this -> db -> query($stmt, $data);
        return $query->result_array();
    }

    public function get_yearly_sales($tenant_type, $trade_name, $tenant_code){

        $query = $this->db->query("
            SELECT
                *
            FROM 
                tenant_yearly_sales
            WHERE
                tenant_type = ?
            AND 
                trade_name = ?
            AND 
                tenant_code LIKE ?
            ORDER BY
                year
            ", [$tenant_type, $trade_name, '%'.$tenant_code.'%']);


        return $query->result_array();
    }

    public function get_monthly_sales($tenant_type, $trade_name, $tenant_code, $year){
         $query = $this->db->query("
            SELECT
                *
            FROM 
                total_monthly_sales
            WHERE
                tenant_type = ?
            AND 
                trade_name = ?
            AND 
                tenant_code LIKE ?
            AND
                date_end LIKE ?

            ORDER BY
                date_end

            ", [$tenant_type, $trade_name, '%'.$tenant_code.'%', "%$year%"]);


        return $query->result_array();
    }

    public function get_daily_sales_record($tenant_type, $trade_name, $tenant_code, $date){
        $tds = $this->db->query("
            SELECT
                *
            FROM 
                tenant_daily_sales
            WHERE
                tenant_type = ?
            AND 
                trade_name = ?
            AND 
                tenant_code LIKE ?
            AND
                transac_date LIKE ?

            ORDER BY
                transac_date

            ", [$tenant_type, $trade_name, '%'.$tenant_code.'%', "%$date%"]);

        $ctds = $this->db->query("
            SELECT
                *
            FROM 
                confirmed_daily_sales
            WHERE
                tenant_type = ?
            AND 
                trade_name = ?
            AND 
                tenant_code LIKE ?
            AND
                transac_date LIKE ?

            ORDER BY
                transac_date

            ", [$tenant_type, $trade_name, '%'.$tenant_code.'%', "%$date%"]);

        return ["tds"=>$tds->result_array(), "ctds"=> $ctds->result_array()];
    }


    public function get_hourly_sales_record($tenant_type, $trade_name, $tenant_code, $date)
    {

        $hourlysale = $this->_DB2->query(
            "SELECT
                *
            FROM
                `tenant_hourly_sales`
             WHERE
                tenant_type = ?
            AND 
                trade_name = ?
            AND 
                tenant_code LIKE ?
            AND
                transac_date LIKE ?
            GROUP BY
                `txtfile_name`, `date_upload`
            ORDER BY
                `transac_date` 
        ", [$tenant_type, $trade_name, '%'.$tenant_code.'%', "%$date%"]);
       

        $hourlysale = $hourlysale->result_array();

        foreach ($hourlysale as $key => $rs) {

            $sales = $this->view_hourly_sales($rs['transac_date'], $rs['tenant_code'], $rs['date_upload'], $rs['pos_num']);

            $unmatched = array_filter($sales, function($hs){
                return $hs['status'] == 'Unmatched';
            });

            $unconfirmed = array_filter($sales, function($hs){
                return $hs['status'] == 'Unmatched' || $hs['status'] == 'Unconfirmed';
            });


            $hourlysale[$key]['status'] =  count($unmatched) == 0 &&  count($unconfirmed) == 0 ? 'All Confirmed'  : 
                (count($unmatched) > count($unconfirmed) ? 'has unmatched' : 'has unconfirmed');

        }


        $confHourlysale = $this->_DB2->query(
            "SELECT
                *
            FROM
                `confirmed_hourly_sales`
             WHERE
                tenant_type = ?
            AND 
                trade_name = ?
            AND 
                tenant_code LIKE ?
            AND
                transac_date LIKE ?
            GROUP BY
                `txtfile_name`
            ORDER BY
                `transac_date` 
        ", [$tenant_type, $trade_name, '%'.$tenant_code.'%', "%$date%"]);

        $confHourlysale = $confHourlysale->result_array();

        return ['hs' => $hourlysale,  'chs' => $confHourlysale];
    }

    public function view_confirmed_hourly_sales($transac_date, $tenant_code, $pos_num)
    {   
        $store = $this->session->userdata('store_code');

        $query = $this->_DB2->query(
            "SELECT
                *
            FROM
                `confirmed_hourly_sales`
            WHERE
                `transac_date` = ?
            AND
                `tenant_code` LIKE ?
            AND 
                `pos_num` = ?
            ORDER BY
                hour_code
        ", [$transac_date, "%$tenant_code%", $pos_num]);
        
        return $query->result_array();
    }


    public function delete_confirmed_hourly_sales($tran_date, $tenant_code){

        $this->db->query("
            DELETE 
            FROM
                confirmed_hourly_sales
            WHERE 
                tenant_code LIKE ?
            AND 
                transac_date = ?", ["%$tenant_code%", $tran_date]);

       return $this->db->affected_rows();
    }

    public function get_leasing_data_records($tenant_type, $trade_name, $tenant_code){

        $data_leasing = $this->db->query("
            SELECT
                *
            FROM
                data_for_leasing
            WHERE
                tenant_type = ?
            AND
                trade_name = ?
            AND 
                tenant_code LIKE ?
            ORDER BY
                date_end
            ", [$tenant_type, $trade_name, "%$tenant_code%"])->result_array();


        $upload_history = $this->db->query("
            SELECT
                *
            FROM
                upload_history
            WHERE
                tenant_type = ?
            AND
                trade_name = ?
            AND 
                tenant_code LIKE ?
            ORDER BY
                date 
            ", [$tenant_type, $trade_name, "%$tenant_code%"])->result_array();

        return ["dl" => $data_leasing, "uh" => $upload_history];


    }

    public function get_sales_data($tenant_type, $trade_name, $tenant_code){
        $query = $this->db->query("
            SELECT
                * 
            FROM 
                sales
            WHERE
                tenant_type = ?
            AND
                trade_name = ?
            AND
                tenant_code LIKE ?
        ", [$tenant_type, $trade_name, "%$tenant_code%"]);

        return $query->result_array();
    }

}//end tsms_model//