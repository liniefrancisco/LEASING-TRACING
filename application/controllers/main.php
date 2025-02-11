<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cntrl_tsms extends CI_Controller {

	function __construct(){
    
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('tsms_model');
        $this->load->library('upload','acl');

        
    }

     function sanitize($string){
    
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = trim($string);
        return $string;
    }


     function get_dateTime(){
    
        $timestamp = time();
        $date_time = date('F j, Y g:i:s A  ', $timestamp);
        $result['current_dateTime'] = $date_time;
        echo json_encode($result);
    }

	public function index()
    {
        if ($this->session->userdata('is_logged_in')) 
       {
          redirect('cntrl_tsms/home');
        } else {
           $data['flashdata'] = $this->session->flashdata('message');
           $this->load->view('login', $data);
       }
    }
    
    public function login(){
    
        $username = $this->sanitize($this->input->post('username'));
        $password = $this->sanitize($this->input->post('password'));
        $result = $this->tsms_model->check_login($username, $password);
        if ($result) {

             $this->session->set_flashdata('message', 'Login Succesful');
           redirect ('cntrl_tsms/home');

        } else {
            $this->session->set_flashdata('message', 'Invalid Login');
            redirect ('cntrl_tsms/');

        }
    }

     public function logout(){
    
        $newdata = array(
            'id'   => '',
            'name' => '',
            'password' => '',
            'username'  => '',
            'last_name'  => '',
            'is_logged_in' => FALSE
        );
    

        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        redirect('cntrl_tsms/index/');
    }

    public function user_credentials(){
    
        $this -> db -> select('*');
        $this -> db -> from('add_users');
        $this -> db -> where('id = ' . "'" . $this->_user_id . "'");
        $query = $this -> db -> get();

        return $query->result_array();
    }
 
    public function home()
    {
        if ($this->session->userdata('is_logged_in')) 
        {   
   
            $data['flashdata'] = $this->session->flashdata('message');  
            $this->load->view('header', $data);
            $this->load->view('home');
            $this->load->view('footer');
            
            
        } else {
            redirect('cntrl_tsms/');
        }
    }


    public function upload_files(){

        if($this->session->userdata('is_logged_in')){
            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('Upload');
            $this->load->view('footer');
        }
    }

    public function comparative_report(){

        if($this->session->userdata('is_logged_in')){
            
            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('comparative_report');
            $this->load->view('footer');

        }
        
    }

    public function add_tsms_user(){

    if($this->session->userdata('is_logged_in'))
        {
            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('add_tsms_user');
            $this->load->view('footer');
          
        } else {
            redirect('cntrl_tsms');
        }
    }
    
     public function add_user()
    {
     ($data=array(
            'name'=>$this->input->post('username'),
            'last_name'=>$this->input->post('last_name'),
            'username'=>$this->input->post('username'),
            'password'=>md5($this->input->post('password')),
            'user_type'=>$this->input->post('user_type'))); 
        $this->db->insert('add_users',$data);
        $this->add_tsms_user();
 
        redirect('cntrl_tsms/user');
    }

    public function get_tsms_users()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
            $result = $this->tsms_model->get_tsms_users();
            echo json_encode($result);
        } else {
            redirect('cntrl_tsms/');
        }
    }

    


	public function members(){
		if ($this->session->userdata('is_logged_in')){
			$this->load->view('index');

		} else {

			redirect('for_validation/restricted');
		}

	}


	public function transaction(){
    
        if($this->session->userdata('is_logged_in'))
        {
            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('transaction');
            $this->load->view('footer');

        } else {
            redirect('cntrl_tsms');
        }
    }

    public function database(){
    
        if($this->session->userdata('is_logged_in'))
        {
            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('database');
            $this->load->view('footer');

        } else {
            redirect('cntrl_tsms');
        }
    }

	public function about(){
    
        if($this->session->userdata('is_logged_in'))
        {
            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('about');
            $this->load->view('footer');

        } else {
            redirect('cntrl_tsms');
        }
    }

    public function user(){

         if($this->session->userdata('is_logged_in'))
        {
            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('user');
            $this->load->view('footer');

        } else {
            redirect('cntrl_tsms');
        }

    }

    public function tsms_list(){
        
           if($this->session->userdata('is_logged_in'))
        {

            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('tsms_list');
            $this->load->view('footer');

        } else {
            redirect('cntrl_tsms');
        }

    }

    public function final_list(){
        
           if($this->session->userdata('is_logged_in'))
        {

            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('final_list');
            $this->load->view('footer');

        } else {
            redirect('cntrl_tsms');
        }

    }

        public function daily_sales_list(){
        
           if($this->session->userdata('is_logged_in'))
        {

            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('daily_sales_list');
            $this->load->view('footer');

        } else {
            redirect('cntrl_tsms');
        }

    }

        public function jollibee_sales(){

            if($this->session->userdata('is_logged_in'))
        {

            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('Jollibee');
            $this->load->view('footer');

        } else {
            redirect('cntrl_tsms');
        }

    }

        public function discounts_and_deductions(){

            if($this->session->userdata('is_logged_in'))
        {

            $data['flashdata'] = $this->session->flashdata('message');
            $this->load->view('header', $data);
            $this->load->view('discounts_and_deductions');
            $this->load->view('footer');

        } else {
            redirect('cntrl_tsms');
        }

    }

        function addFoo()
        {

    if ($this->input->post('submit')) {
                $id = $this->input->post('id');            
                $foo1 = $this->input->post('foo1');
                $foo2 = $this->input->post('foo2');
                $foo3  = $this->input->post('foo3');
                $foo4  = $this->input->post ('foo4');

    $this->load->model('tsms_model');
    $this->tsms_model->addFoo($id, $foo1, $foo2, $foo3, $foo4);
    }
        }
    

        }



	

