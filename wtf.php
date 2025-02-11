<?php 

"SELECT 
    tbl.*,
    SUM(tbl.debit) AS debit,
    SUM(tbl.credit) AS credit,
    SUM(tbl.debit + tbl.credit) AS amount,
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
                g.company_code,
                g.department_code,
                a.gl_account,
                SUM(IFNULL(g.debit, 0)) debit,
                SUM(IFNULL(g.credit, 0)) credit,
                sl2.partnerID
        FROM
            subsidiary_ledger AS g
        LEFT JOIN (
            SELECT 
                DISTINCT(tnt.prospect_id) AS prospect_id,
                tnt.tenant_id,
                tnt.store_code
            FROM
                tenants tnt) t 
            ON t.tenant_id = g.tenant_id
        LEFT JOIN prospect p ON p.id = t.prospect_id
        LEFT JOIN gl_accounts a ON a.id = g.gl_accountID
        LEFT JOIN (
            SELECT 
                s.*, s.gl_accountID AS partnerID
            FROM
                subsidiary_ledger s
            WHERE
                s.debit IS NULL AND s.credit IS NOT NULL
                    AND s.document_type = 'Payment'
            GROUP BY s.doc_no , s.ref_no , s.credit) 
            AS sl2 
            ON g.doc_no = sl2.doc_no
            AND g.ref_no = sl2.ref_no
            AND g.db <> 0
            AND g.db = ABS(sl2.credit)
            AND g.tenant_id = sl2.tenant_id
        WHERE
            DATE(g.posting_date) LIKE '%2020-01%'
                AND t.store_code = 'ICM'
                AND g.document_type = 'Payment'
                AND (g.tenant_id <> 'DELETED'
                AND g.ref_no <> 'DELETED'
                AND g.doc_no <> 'DELETED')
                AND g.tenant_id <> 'ICM-LT000064'
                AND g.export_batch_code IS NULL
                OR g.export_batch_code = ''
        GROUP BY 
            g.doc_no, g.ref_no, g.gl_accountID, g.tenant_id, g.posting_date, sl2.partnerID
        ORDER BY 
        g.document_type , g.doc_no
    ) AS tbl
        
GROUP BY tbl.doc_no, tbl.gl_accountID , tbl.posting_date,  tbl.ref_no,
ORDER BY tbl.posting_date , tbl.id , credit DESC , debit DESC , tbl.trade_name , tbl.ref_no , tbl.doc_no" 

?>