<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cntrl_tsms extends CI_Controller {

	function __construct(){
    
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('tsms_model');
        $this->load->library('upload','acl');

        $this->load->library('user_agent');

        //$this->db1 = $this->load->database('austin', TRUE);

        //$this->myforge = $this->load->dbforge($this->db1, TRUE);

        if(empty($this->session->userdata('server'))){
            $this->session->set_userdata('server', 'MAIN');
        }

        //die($this->session->userdata('server'));
    }

    function sanitize($string){
    
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = trim($string);
        return $string;
    }

    function set_server($server = 'MAIN'){

        if(!in_array($server, ['MAIN', 'talibon', 'cas'])){
            die('SERVER NOT FOUND!');   
            
        }

        $this->session->set_userdata('server', $server);

        if(empty($this->agent->referrer())){
            redirect('cntrl_tsms/'); 
        }else{
            redirect($this->agent->referrer());
        } 
    }


    function get_dateTime(){
    
        $timestamp = time();
        $date_time = date('F j, Y g:i:s A  ', $timestamp);
        $result['current_dateTime'] = $date_time;
        echo json_encode($result);
    }

    public function testpage(){
        
        if (!$this->session->userdata('is_logged_in')) 
            redirect('cntrl_tsms/');

        $data['trade_name'] = $this->tsms_model->get_tenant_name();
        $data['flashdata'] = $this->session->flashdata('message');
        $this->load->view('header', $data);
        $this->load->view('test/index');
        $this->load->view('footer');
    }


	public function index()
    { 
       // echo "SORRY, PAGE IS TEMPORARILY DOWN.";

        // if($this->input->ip_address() == '172.16.43.162' || $this->input->ip_address() == '172.16.43.75')
        // {
            $this->load->view('header', []);
            $this->load->view('test/index');
            $this->load->view('footer');
        // }
        // else
        // {
        //     $this->load->view('errors/index.html');
        // }
       // $this->load->view('errors/index.html');
       // header("views:index.html");

    }

    public function ipadress()
    {
        echo $this->input->ip_address();
    }

    public function receivable_invoices(){
        $this->load->view('header', []);
        $this->load->view('test/receivable_invoices');
        $this->load->view('footer');
    }

    public function payments_ledger(){
        $this->load->view('header', []);
        $this->load->view('test/payments_ledger');
        $this->load->view('footer');
    }

    public function ar_reports(){
        $this->load->view('header', []);
        $this->load->view('test/ar_reports');
        $this->load->view('footer');
    }

    public function sl_report(){
        $this->load->view('header', []);
        $this->load->view('test/sl_report');
        $this->load->view('footer');
    }

    public function per_tenant(){
        $this->load->view('header', []);
        $this->load->view('test/per_tenant');
        $this->load->view('footer');
    }

    public function per_tenant_payment_ledger(){
        $this->load->view('header', []);
        $this->load->view('test/per_tenant_payment_ledger');
        $this->load->view('footer');
    }
    public function per_tenant_invoices_ledger(){
        $this->load->view('header', []);
        $this->load->view('test/per_tenant_invoices_ledger');
        $this->load->view('footer');
    }


    public function generate_nav_txtfile($type = 'invoice'){
        $this->load->view('header', []);
        $this->load->view('test/generate_nav_txtfile_'.$type);
        $this->load->view('footer');
    }

    public function nav_by_docno(){
        $this->load->view('header', []);
        $this->load->view('test/nav_by_docno');
        $this->load->view('footer');
    }


    public function test(){


        if ($this->db1->table_exists('sequence_2') )
        {
          die('table exists');
        }else{
            
            $this->myforge->add_field([
                'id'=> [
                    'type'              =>'INT',
                    'unsigned'          =>TRUE,
                    'auto_increment'    =>TRUE,
                    'null'              =>FALSE
                ],
                'created_by' => [
                    'type'          =>'INT',
                    'constraint'    => '10',
                    'null'          => true,
                ]
            ]);

            $this->myforge->add_key('id', TRUE);


            if($this->myforge->create_table('sequence_2')){
                die('table created');
            }
          

            die('table not exists');
        }
    }


}



	

