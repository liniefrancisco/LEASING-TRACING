<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart_controller extends CI_controller {


  function __construct(){

        parent::__construct();
        $this->load->helper(array('form', 'url', 'my'));
        $this->load->library('form_validation');
        $this->load->model('tsms_model');
        $this->load->library('upload','acl');
        $this->load->library('fpdf');
        $this->_DB1 = $this->load->database('cyril', TRUE);
        $this->_DB2 = $this->load->database('austin', TRUE);

        if(!$this->session->userdata('is_logged_in'))
            JSONResponse(['type'=>'warning', 'msg'=>'Authentication error!']);
    }

    function get_dateTime()
    {
    	date_default_timezone_set("Asia/Manila");
        $timestamp = time();
        $date_time = date('F j, Y g:i:s A  ', $timestamp);
        $result['current_dateTime'] = $date_time;
        echo json_encode($result);
    }

    public function monthly_sales($date =''){
       

        if(empty($date)){
            $sales = (array)$this->db->query("
                SELECT
                    total_net_sales,
                    total_gross_sales,
                    trade_name,
                    date_end
                FROM 
                    total_monthly_sales
                WHERE
                    date_end IN (SELECT MAX(date_end)  FROM total_monthly_sales)
                AND
                    tenant_code LIKE '%" . $this->session->userdata('store_code') . "%'
                ORDER BY
                    trade_name
            ")->result_array();
        } else{
            $sales = (array)$this->db->query("
                SELECT
                    total_net_sales,
                    total_gross_sales,
                    trade_name,
                    date_end
                FROM 
                    total_monthly_sales
                WHERE
                    date_end = '$date'
                AND 
                    tenant_code LIKE '%" . $this->session->userdata('store_code') . "%'
                ORDER BY
                    trade_name
            ")->result_array();
        }

        $sales  = empty($sales) ? [['total_net_sales'=>'', 'total_gross_sales'=>'', 'trade_name'=>'', 'date_end'=>'']] : $sales;

        JSONResponse($sales);
    }

 	public function home_chart()
 	{
            $a='';
            $new_date = date('Y-m-d');
            $data = explode("-", $new_date);
            unset($data[2]);
            intval($data[1]);
            $new = $data[1]-1;


            if($new == 00){

                $new = 12;
                intval($data[0]);
                $b = $data[0]-1;

            }else{

                $new = $data[1]-1;
                intval($data[0]);
                $b = $data[0];
            }

            for ($i=0; $i < count($new); $i++)
            { 
                if($new < 10){
                    $a = sprintf("%02d", $new);
                    }else{
                    $a = $new;
                    }
            }
             $date = array($b,$a);
             $date_end = join("-", $date);

            $result = $this->tsms_model->home_chart($date_end);
            echo json_encode($result);

 	
 	}

    public function latest_12_month_sale(){
        if($this->session->userdata('is_logged_in'))
        {   
            

            $max_date   = $this->tsms_model->get_lastest_monthly_sale_date();
            $max_date   = isset($max_date->max_date) ?  $max_date->max_date : date('Y-m') ;

            $exp_date   = explode('-', $max_date);
            $year       = $exp_date[0];
            $month      = $exp_date[1];

            for ($m=0; $m < 12  ; $m++) { 

                if($month == 0){
                    $month =12;
                    $year--;
                }
                $date = $year.'-'.sprintf("%02d", $month);
                $msale = $this->tsms_model->latest_12_month_sale($date);
                $msale->date = date('M Y', strtotime($date));

                $msale->total_gross_sales       = isset($msale->total_gross_sales) ? $msale->total_gross_sales : 0;
                $msale->total_netsales_amount   = isset($msale->total_netsales_amount) ? $msale->total_netsales_amount : 0;

                $partial[] = (array)$msale;

                $month--;
            }
            
            $partial = array_reverse($partial);

            foreach ($partial as $par) {

                foreach ($par as $key => $value) {
                    $result[$key][] = $value;
                }
     
            }

            JSONResponse($result);
        }
    }

 	public function home_chart_search($data, $year)
 	{
 		if($this->session->userdata('is_logged_in'))
 		{
            $data           = explode("_", urldecode($data));
            $tenant_list    = $data[0];
            $trade_name     = $data[1];
            $year           = urldecode($year);

            for ($m=1; $m <= 12  ; $m++) {   
                $msale = $this->tsms_model->chart_tenant_yearly_rec($tenant_list, $trade_name, $year.'-'.sprintf("%02d", $m));
                
                $result[] = ['total_gross_sales'    => isset($msale->total_gross_sales) ? $msale->total_gross_sales : 0, 
                           'total_netsales_amount'  => isset($msale->total_netsales_amount) ? $msale->total_netsales_amount : 0];
            }
           
            JSONResponse($result);
 		}
 	}

 	public function monthly_chart(){
 		if($this->session->userdata('is_logged_in'))
 		{
 			
 			
 		}
 	}
}