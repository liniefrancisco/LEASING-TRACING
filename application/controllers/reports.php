<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    function __construct(){

        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('tsms_model');
        $this->load->library('upload','acl');
        $this->load->library('fpdf');
        $this->load->library('mypdf');
        $this->_DB1 = $this->load->database('cyril', TRUE);
        $this->_DB2 = $this->load->database('austin', TRUE);

        if (!$this->session->userdata('is_logged_in')){
            $base_url = base_url();
            show_error('You are unauthorize to access this page! <a href="'.$base_url.'">Click here to login</a>.' , 403, "Error 403 : Access Forbidden");
        }
            
           
    }

    public function monthly_sales(){

        
        $tenant_list        = $this->input->post('tenant_list');
        $trade_name         = $this->input->post('trade_name');
        $filter_date        = $this->input->post('filter_date'); 


        $curr_time = date('F j, Y, g:i A ');


        $daily = $this->tsms_model->monthly_report($tenant_list,$trade_name,$filter_date);
        $month = $this->tsms_model->get_monthly_total_report($tenant_list, $trade_name, $filter_date);

        


        $stmt_daily= '';
        $stmt_monthly= '';
        foreach ($daily as $day) {
            $day = (object) $day;

            $stmt_daily.= '
            <tr>   
                <td class="text-left">&nbsp; &nbsp;'.$day->transac_date.'</td>
                <td class="text-right">'.number_format($day->total_sc_discounts, 2).'&nbsp; &nbsp;</td>
                <td class="text-right">'.number_format($day->other_discounts, 2).' &nbsp; &nbsp;</td>
                <td class="text-right">'.number_format($day->total_pwd_discounts, 2).' &nbsp; &nbsp;</td>
                <td class="text-right">'.number_format($day->total_nontax_sales, 2).' &nbsp; &nbsp;</td>
                <td class="text-right">'.number_format($day->total_taxvat, 2).' &nbsp; &nbsp;</td>
                <td class="text-right">'.number_format($day->total_cash_sales, 2).' &nbsp; &nbsp;</td>
                <td class="text-right">'.number_format($day->total_gross_sales, 2).' &nbsp; &nbsp;</td>
                <td class="text-right">'.number_format($day->total_net_sales, 2).' &nbsp; &nbsp;</td>
            </tr>';
        }


        if(!empty($month)){
            $stmt_monthly.= '
            <tr>   
                <td class="total text-right">TOTAL :</td>
                <td class="total text-right">'.number_format($month->total_sc_discounts, 2).'&nbsp; &nbsp;</td>
                <td class="total text-right">'.number_format($month->other_discounts, 2).' &nbsp; &nbsp;</td>
                <td class="total text-right">'.number_format($month->total_pwd_discounts, 2).' &nbsp; &nbsp;</td>
                <td class="total text-right">'.number_format($month->total_nontax_sales, 2).' &nbsp; &nbsp;</td>
                <td class="total text-right">'.number_format($month->total_taxvat, 2).' &nbsp; &nbsp;</td>
                <td class="total text-right">'.number_format($month->total_cash_sales, 2).' &nbsp; &nbsp;</td>
                <td class="total text-right">'.number_format($month->total_gross_sales, 2).' &nbsp; &nbsp;</td>
                <td class="total text-right">'.number_format($month->total_net_sales, 2).' &nbsp; &nbsp;</td>
            </tr>';
        } else {
             $stmt_monthly.= '
            <tr class="highlight">   
                <td colspan="100%" align="center" class="text-bold"> NO MONTHLY CALCULATION FOUND. PLEASE CALCULATE MONTHLY SALE. </td>
            </tr>';
        }
            
   

        $additional = '';
        if(count($daily) >= 25){
            for ($i=0; $i < 31 -  count($daily); $i++) { 
                $additional.='<tr>   
                    <td class="noborder" colspan="100%">&nbsp; &nbsp;</td>
                </tr>';
            }
        }  


        $pdf = new MYPDF;
        $pdf->title = "MONTHLY SALES REPORT";
        $pdf->set_default_settings();

        $pdf->SetMargins(10, 20, 10);

        $pdf->AddPage('L', 'A4');
        $pdf->SetPrintHeader(false);

        $pdf->SetFont('times', '', 10);
        $pdf->writeHTMLCell(0, 0, '', '', "ISLAND CITY MALL", 0, 1, 0, true, 'C', true);

        $pdf->SetFont('times', 'b', 12);
        $pdf->writeHTMLCell(0, 0, '', '', "MONTHLY SALES REPORT", 0, 1, 0, true, 'C', true);

        $pdf->Ln(5);
        $pdf->SetFont('times', '', 10);
        $pdf->writeHTMLCell(0, 0, '', '', "Date Printed : $curr_time", 0, 1, 0, true, 'l', true);

        $pdf->SetFont('times', '', 10);
        $pdf->writeHTMLCell(0, 0, '', '', "Tenant Name : $trade_name", 0, 1, 0, true, 'l', true);
        $pdf->Ln(5);
        $html = <<<EOD
            <style>
                table {
                    margin-bottom: 0px;
                }
                table, td {
                  border: 1px solid #ccc;
                }
                
                th{
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                }

                .highlight {
                    background-color: #ccc;
                }

                .total { 
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                    font-size: 13px;
                    font-weight: bolder;
                    background-color: #ccc;
                }

                .text-right{
                    text-align: right;
                }
                .text-center{
                    text-align: center;
                }

                table, .noborder {
                    border: 1px solid #fff;

                }

                td {
                    margin-left: 5px;
                    margin-right: 5px;                
                }

                .text-bold {
                    font-weight : bold;
                }

            </style>
            <table  cellspacing="0" cellpadding="1">
                <thead>
                    <tr class="text-center highlight border">
                        <th width="8%"> <b> Trans. Date </b></th>
                        <th width="10%"> <b> SC Discounts </b></th>
                        <th width="11%"> <b> Other Discounts </b></th>
                        <th width="11%"> <b> Total PWD Disc. </b></th>
                        <th width="15%"> <b> Total Nontax Sales </b></th>
                        <th width="10%"> <b> Total Tax/Vat </b></th>
                        <th width="15%"> <b> Total Cash Sales </b></th>
                        <th width="10%"> <b> Gross Sales </b></th>
                        <th width="10%"> <b> Net Sales </b></th>
                    </tr>
                <thead>
                
                <tbody>
                    $stmt_daily
                    
                </tbody>
                <tfoot>
                    $stmt_monthly
                    $additional 
                </tfoot>  
            </table>        
EOD;
    
        $pdf->writeHTML($html, true, false, true, false, '');

        ob_end_clean();
        $pdf->Output("MONTHLY SALES REPORT", 'I');

    }

    public function total_monthly_sales(){
        $tenant_list = $this->input->post('tenant_list');
        $filter_date = $this->input->post('filter_date'); 

        $curr_time = date('F j, Y, g:i A ');


        $total_monthly_sales = $this->tsms_model->monthly_total($tenant_list, $filter_date);


        $stmt_monthly= '';

        foreach ($total_monthly_sales as $sale) {
            $sale = (object) $sale;

            $stmt_monthly.= '
            <tr>   
                <td>&nbsp; &nbsp;'.$sale->trade_name.'</td>
                <td class="text-center">'.$sale->date_end.'</td>
                <td>&nbsp; &nbsp;'.$sale->rental_type.'</td>
                <td>&nbsp; &nbsp;'.$sale->tenant_type.'</td>
                <td class="text-right">'.number_format($sale->total_nontax_sales, 2).' &nbsp;</td>
                <td class="text-right">'.number_format($sale->total_taxvat, 2).' &nbsp; </td>
                <td class="text-right">'.number_format($sale->total_cash_sales, 2).' &nbsp; </td>
                <td class="text-right">'.number_format($sale->total_net_sales, 2).' &nbsp; </td>
                <td class="text-right">'.number_format($sale->total_gross_sales, 2).' &nbsp; </td>
            </tr>';
        }



        $pdf = new MYPDF;
        $pdf->title = "TOTAL MONTHLY SALES REPORT $filter_date";
        $pdf->set_default_settings();

        $pdf->SetMargins(10, 20, 10);

        $pdf->AddPage('L', 'A4');
        $pdf->SetPrintHeader(false);

        $pdf->SetFont('times', '', 10);
        $pdf->writeHTMLCell(0, 0, '', '', "ISLAND CITY MALL", 0, 1, 0, true, 'C', true);

        $pdf->SetFont('times', 'b', 12);
        $pdf->writeHTMLCell(0, 0, '', '', "TOTAL MONTHLY SALES REPORT", 0, 1, 0, true, 'C', true);

        $pdf->Ln(5);
        $pdf->SetFont('times', '', 10);
        $pdf->writeHTMLCell(0, 0, '', '', "Date Printed : $curr_time", 0, 1, 0, true, 'l', true);
        $pdf->writeHTMLCell(0, 0, '', '', "Filter Date : $filter_date", 0, 1, 0, true, 'l', true);
        $pdf->Ln(5);
        $html = <<<EOD
            <style>
                table {
                    margin-bottom: 0px;
                }
                table, td {
                  border: 1px solid #ccc;
                }
                
                th{
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                }

                .highlight {
                    background-color: #ccc;
                }

                .total { 
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                    font-size: 13px;
                    font-weight: bolder;
                    background-color: #ccc;
                }

                .text-right{
                    text-align: right;
                }
                .text-center{
                    text-align: center;
                }

                td {
                    margin-left: 5px;
                    margin-right: 5px;                
                }
                
            </style>
            <table  cellspacing="0" cellpadding="1">
                <thead>
                    <tr class="text-center highlight border">
                        <th width="12%"> <b> Trade Name  </b></th>
                        <th width="8%"> <b> Date </b></th>
                        <th width="15%"> <b> Rental Type  </b></th>
                        <th width="13%"> <b> Tenant Type  </b></th>
                        <th width="10%"> <b> Nontax Sales </b></th>
                        <th width="12%"> <b> Tax/Vat  </b></th>
                        <th width="10%"> <b> Cash Sales</b></th>
                        <th width="10%"> <b> Net Sales  </b></th>
                        <th width="10%"> <b> Gross Sales </b></th>
                    </tr>
                <thead>
                
                <tbody>
                    $stmt_daily
                </tbody>
                <tfoot>
                    $stmt_monthly
                </tfoot>    
            </table>        
EOD;
    
        $pdf->writeHTML($html, true, false, true, false, '');

        ob_end_clean();
        $pdf->Output("TOTAL MONTHLY SALES REPORT $filter_date", 'I');

    }

    public function fixed_monthly_sales(){
        $tenant_list    = $this->input->post('tenant_list');
        $filter_date    = $this->input->post('filter_date');

        $curr_time = date('F j, Y, g:i A ');

        $sales = $this->tsms_model->fixed_monthly_total($tenant_list,$filter_date);


        $stmt_sales= '';

        foreach ($sales as $sale) {
            $sale = (object) $sale;

            $stmt_sales.= '
            <tr>   
                <td>&nbsp; &nbsp;'.$sale->trade_name.'</td>
                <td class="text-center">'.$sale->date.'</td>
                <td class="text-center">&nbsp; &nbsp;'.$sale->rental_type.'</td>
                <td class="text-center">&nbsp; &nbsp;'.$sale->tenant_type.'</td>
                <td class="text-right">'.number_format($sale->total_gross_sales, 2).' &nbsp;</td>
                <td class="text-right">'.number_format($sale->total_netsales_amount, 2).' &nbsp; </td>
            </tr>';
        }


        $pdf = new MYPDF;
        $pdf->title = "FIXED MONTHLY SALES REPORT";
        $pdf->set_default_settings();

        $pdf->SetMargins(10, 20, 10);

        $pdf->AddPage('L', 'A4');
        $pdf->SetPrintHeader(false);

        $pdf->SetFont('times', '', 10);
        $pdf->writeHTMLCell(0, 0, '', '', "ISLAND CITY MALL", 0, 1, 0, true, 'C', true);

        $pdf->SetFont('times', 'b', 12);
        $pdf->writeHTMLCell(0, 0, '', '', "FIXED MONTHLY SALES REPORT", 0, 1, 0, true, 'C', true);

        $pdf->Ln(5);
        $pdf->SetFont('times', '', 10);
        $pdf->writeHTMLCell(0, 0, '', '', "Date Printed : $curr_time", 0, 1, 0, true, 'l', true);

        $pdf->Ln(5);


         $html = <<<EOD
            <style>
                table {
                    margin-bottom: 0px;
                }
                table, td {
                  border: 1px solid #ccc;
                }
                
                th{
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                }

                .highlight {
                    background-color: #ccc;
                }

                .total { 
                    border-top: 1px solid black;
                    border-bottom: 1px solid black;
                    font-size: 13px;
                    font-weight: bolder;
                    background-color: #ccc;
                }

                .text-right{
                    text-align: right;
                }
                .text-center{
                    text-align: center;
                }

                td {
                    margin-left: 5px;
                    margin-right: 5px;                
                }   
            </style>

            <table  cellspacing="0" cellpadding="1">
                <thead>
                    <tr class="text-center highlight border">
                        <th width="22%"> <b> Trade Name  </b></th>
                        <th width="15%"> <b> Date </b></th>
                        <th width="15%"> <b> Rental Type  </b></th>
                        <th width="18%"> <b> Tenant Type  </b></th>
                        <th width="15%"> <b> Gross Sales </b></th>
                        <th width="15%"> <b> Net Sales  </b></th>
                    </tr>
                <thead>
                <tbody>
                    $stmt_sales
                </tbody>  
            </table>        
EOD;
    
        $pdf->writeHTML($html, true, false, true, false, '');

        ob_end_clean();
        $pdf->Output("FIXED MONTHLY SALES REPORT $filter_date", 'I');

    }


    public function print_monthly_report()
    {
        if ($this->session->userdata('is_logged_in')) 
        {

            $result = array();
            $date = new DateTime();
            $timeStamp = $date->getTimestamp();
            date_default_timezone_set("Asia/Manila");
            $new_date = date('F j, Y, g:i A ');

            $tenant_list = $this->input->post('tenant_list');
            $trade_name = $this->input->post('trade_name');
            $get_date = $this->input->post('filter_date'); 
            $done_date = explode("-", $get_date);
            unset($done_date[2]);
            $filter_date = implode ('-',$done_date);


            $result = $this->tsms_model->monthly_report($tenant_list,$trade_name,$filter_date);
            $total = $this->tsms_model->get_monthly_total_report($tenant_list, $trade_name, $filter_date);

                
                    
                    $pdf = new FPDF('l','mm','A4');
                    $pdf->AddPage();
                    $pdf->setDisplayMode ('fullpage');            
                    $pdf->SetFont('Arial','',11);
                    // $pdf->Image('img/logo-icm.png',127,5,30);
                    $pdf->Cell(280,5, $new_date, 0, 0, 'R');
                    $pdf->ln(10);
                    $pdf->Cell(270,5,'Island City Mall', 0, 0, 'C');
                    $pdf->ln(6);
                    $pdf->Cell(270,5,'Monthly Sales Report', 0, 0, 'C');
                    $pdf->ln(6);
                    $pdf->Cell(270,5,'Tenant Name: '. $trade_name, 0, 0, 'C');
                    $pdf->ln(7);
                    $pdf->Cell(25, 5, 'Transac Date', 1, 0, 'C');
                    $pdf->Cell(30, 5, 'SC Discounts', 1, 0, 'C');
                    $pdf->Cell(30, 5, 'Other Discounts', 1, 0, 'C');
                    $pdf->Cell(40, 5, 'Total PWD Discounts', 1, 0, 'C');
                    $pdf->Cell(40, 5, 'Total Nontax Sales', 1, 0, 'C');
                    $pdf->Cell(30, 5, 'Total Tax/Vat', 1, 0, 'C');
                    $pdf->Cell(29, 5, 'Total Cash Sales', 1, 0, 'C');
                    $pdf->Cell(25, 5, 'Gross Sales', 1, 0, 'C');
                    $pdf->Cell(25, 5, 'Net Sales', 1, 0, 'C');
                    $pdf->ln(5);


                     foreach ($result as $value) 
                        {
                            $pdf->SetFont('times','',10);
                            // $pdf->Line(10,62,200,62);
                            $pdf->Cell(25, 5, $value['transac_date'], 1, 0, 'C');
                            $pdf->Cell(30, 5, number_format($value['total_sc_discounts'],2), 1, 0, 'C');
                            $pdf->Cell(30, 5, number_format($value['other_discounts'],2), 1, 0, 'C');
                            $pdf->Cell(40, 5, number_format($value['total_pwd_discounts'],2), 1, 0, 'C');
                            $pdf->Cell(40, 5, number_format($value['total_nontax_sales'],2), 1, 0, 'C');
                            $pdf->Cell(30, 5, number_format($value['total_taxvat'],2), 1, 0, 'C');
                            $pdf->Cell(29, 5, number_format($value['total_cash_sales'],2), 1, 0, 'C');
                            $pdf->Cell(25, 5, number_format($value['total_gross_sales'],2), 1, 0, 'C');
                            $pdf->Cell(25, 5, number_format($value['total_net_sales'],2), 1, 0, 'C');
                            // $pdf->Line(10,69,200,69);
                            $pdf->ln(5);
                            $pdf->SetAutoPageBreak(1);
                               
                        }

                     foreach ($total as $get_total)
                        {
                            $pdf->SetFont('times','B',10);
                            $pdf->Cell(25, 5, 'Total :', 0, 0, 'C');
                            $pdf->Cell(30, 5, number_format($get_total['total_sc_discounts'],2), 0, 0, 'C');
                            $pdf->Cell(30, 5, number_format($get_total['other_discounts'],2), 0, 0, 'C');
                            $pdf->Cell(40, 5, number_format($get_total['total_pwd_discounts'],2), 0, 0, 'C');
                            $pdf->Cell(40, 5, number_format($get_total['total_nontax_sales'],2), 0, 0, 'C');
                            $pdf->Cell(30, 5, number_format($get_total['total_taxvat'],2), 0, 0, 'C');
                            $pdf->Cell(29, 5, number_format($get_total['total_cash_sales'],2), 0, 0, 'C');
                            $pdf->Cell(25, 5, number_format($get_total['total_gross_sales'],2), 0, 0, 'C');
                            $pdf->Cell(25, 5, number_format($get_total['total_net_sales'],2), 0, 0, 'C');
                            // $pdf->ln(5);
                            // $pdf->SetAutoPageBreak(1);
                        }

                    $file_name =  $timeStamp . '.pdf';
                    $response['file_name'] = base_url() . 'assets/reports/' . $file_name;
                    $pdf->Output('assets/reports/' . $file_name , 'F');
                    
                    $response['msg'] = 'Success';
                    echo json_encode($response);

        }
    }

    public function tenants_sales_report()
    {
        if($this->session->userdata('is_logged_in'))
        {

            $result = array();
            $date = new DateTime();
            $timeStamp = $date->getTimestamp();
            date_default_timezone_set("Asia/Manila");
            $new_date = date('F j, Y, g:i A ');

            $tenant_list = $this->input->post('tenant_list');
            $get_date = $this->input->post('filter_date'); 
            $done_date = explode("-", $get_date);
            unset($done_date[2]);
            $filter_date = implode ('-',$done_date);

            $result = $this->tsms_model->tenants_sales_report($tenant_list, $filter_date);

            $pdf = new FPDF('l','mm','A4');
                    $pdf->AddPage();
                    $pdf->setDisplayMode ('fullpage');            
                    $pdf->SetFont('Arial','',11);
                    // $pdf->Image('img/logo-icm.png',85,5,30);
                    $pdf->Cell(280,5, $new_date, 0, 0, 'R');
                    $pdf->ln(10);
                    $pdf->Cell(270,5,'Island City Mall', 0, 0, 'C');
                    $pdf->ln(6);
                    $pdf->Cell(270,5,'Tenant Monthly Sales Report', 0, 0, 'C');
                    $pdf->ln(10);
                    $pdf->Cell(35, 5, 'Trade Name', 1, 0, 'C');
                    $pdf->Cell(20, 5, 'Date', 1, 0, 'C');
                    $pdf->Cell(45, 5, 'Rental Type', 1, 0, 'C');
                    $pdf->Cell(35, 5, 'Tenant Type', 1, 0, 'C');
                    $pdf->Cell(30, 5, 'Nontax Sales', 1, 0, 'C');
                    $pdf->Cell(30, 5, 'Tax/Vat', 1, 0, 'C');
                    $pdf->Cell(27, 5, 'Cash Sales', 1, 0, 'C');
                    $pdf->Cell(27, 5, 'Net Sales', 1, 0, 'C');
                    $pdf->Cell(27, 5, 'Gross Sales', 1, 0, 'C');
                    $pdf->ln(5);


                    foreach ($result as $value) 
                        {
                            $pdf->SetFont('times','',10);
                            $pdf->Cell(35, 5, $value['trade_name'], 1, 0, 'C');
                            $pdf->Cell(20, 5, $value['date_end'], 1, 0, 'C');
                            $pdf->Cell(45, 5, $value['rental_type'], 1, 0, 'C');
                            $pdf->Cell(35, 5, $value['tenant_type'], 1, 0, 'C');
                            $pdf->Cell(30, 5, number_format($value['total_nontax_sales'],2), 1, 0, 'C');
                            $pdf->Cell(30, 5, number_format($value['total_taxvat'],2), 1, 0, 'C');
                            $pdf->Cell(27, 5, number_format($value['total_cash_sales'],2), 1, 0, 'C');
                            $pdf->Cell(27, 5, number_format($value['total_net_sales'],2), 1, 0, 'C');
                            $pdf->Cell(27, 5, number_format($value['total_gross_sales'],2), 1, 0, 'C');
                            $pdf->ln(5);
                            $pdf->SetAutoPageBreak(1);
                        }


                    $file_name =  $timeStamp . '.pdf';
                    $response['file_name'] = base_url() . 'assets/reports/' . $file_name;
                    $pdf->Output('assets/reports/' . $file_name , 'F');
                    
                    $response['msg'] = 'Success';
                    echo json_encode($response);

        }
    }

    public function fixed_sales_report()
    {
        if($this->session->userdata('is_logged_in'))
        {

            $result = array();
            $date = new DateTime();
            $timeStamp = $date->getTimestamp();
            date_default_timezone_set("Asia/Manila");
            $new_date = date('F j, Y, g:i A ');

            $tenant_list = $this->input->post('tenant_list');
            $get_date = $this->input->post('filter_date'); 
            $done_date = explode("-", $get_date);
            unset($done_date[2]);
            $filter_date = implode ('-',$done_date);

            $result = $this->tsms_model->fixed_sales_report($tenant_list, $filter_date);
            
                $pdf = new FPDF('l','mm','A4');

                    $pdf->AddPage();
                    $pdf->setDisplayMode ('fullpage');            
                    $pdf->SetFont('Arial','',11);
                    // $pdf->Image('img/logo-icm.png',85,5,30);
                    $pdf->Cell(280,5, $new_date, 0, 0, 'R');
                    $pdf->ln(10);
                    $pdf->Cell(270,5,'Island City Mall', 0, 0, 'C');
                    $pdf->ln(6);
                    $pdf->Cell(270,5,'Fixed Monthly Sales Report', 0, 0, 'C');
                    $pdf->ln(10);
                    $pdf->Cell(70, 5, 'Trade Name', 1, 0, 'C');
                    $pdf->Cell(40, 5, 'Date', 1, 0, 'C');
                    $pdf->Cell(45, 5, 'Rental Type', 1, 0, 'C');
                    $pdf->Cell(35, 5, 'Tenant Type', 1, 0, 'C');
                    $pdf->Cell(40, 5, 'Gross Sales', 1, 0, 'C');
                    $pdf->Cell(40, 5, 'Net Sales', 1, 0, 'C');
                    $pdf->ln(5);
                    $pdf->SetAutoPageBreak(1);

                foreach ($result as $value)

                        {
                            $pdf->SetFont('times','',10);
                            $pdf->Cell(70, 5, $value['trade_name'], 1, 0, 'C');
                            $pdf->Cell(40, 5, $value['date'], 1, 0, 'C');
                            $pdf->Cell(45, 5, $value['rental_type'], 1, 0, 'C');
                            $pdf->Cell(35, 5, $value['tenant_type'], 1, 0, 'C');
                            $pdf->Cell(40, 5, number_format($value['total_gross_sales'],2), 1, 0, 'C');
                            $pdf->Cell(40, 5, number_format($value['total_netsales_amount'],2), 1, 0, 'C');
                            $pdf->ln(5);
                            $pdf->SetAutoPageBreak(1);
                        }

                    $pdf->ln(5);

                    $file_name =  $timeStamp . '.pdf';
                    $response['file_name'] = base_url() . 'assets/reports/' . $file_name;
                    $pdf->Output('assets/reports/' . $file_name , 'F');
                    
                    $response['msg'] = 'Success';
                    echo json_encode($response);

        }
    } 

}