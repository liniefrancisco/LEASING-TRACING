<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tsms_controller extends CI_Controller {

    function __construct(){

        
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('tsms_model');
        $this->load->library('upload','acl');
        $this->load->library('fpdf');
        $this->_DB1 = $this->load->database('cyril', TRUE);
        $this->_DB2 = $this->load->database('austin', TRUE);

        $this->form_validation->set_error_delimiters('', '<br>');

        if (!$this->session->userdata('is_logged_in')) 
            JSONResponse(["type"=>"error", "msg"=>"Unauthorize action!"]);
    }


    function sanitize($string)
    {
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = trim($string);
        return $string;
    }


    public function add_user()
    {
       if ($this->session->userdata('user_type') != 'Administrator')
            JSONResponse(['type'=>'error', 'msg'=>'Unauthorize access!']);


        $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[4]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[2]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[add_users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
        $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('user_type', 'User Type', 'required');
        $this->form_validation->set_rules('user_group', 'User Group', 'callback_verify_userGroup');
        
         if ($this->form_validation->run() === FALSE)
                JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);

        $first_name     = $this->sanitize($this->input->post('first_name'));
        $last_name      = $this->sanitize($this->input->post('last_name'));
        $username       = $this->sanitize($this->input->post('username'));
        $password       = $this->sanitize($this->input->post('password'));
        $user_type      = $this->sanitize($this->input->post('user_type'));
        $user_group     = $this->tsms_model->store_id($this->input->post('user_group'));
        
        $data = array(
            'name'          =>  $first_name,
            'last_name'     =>  $last_name,
            'username'      =>  $username,
            'password'      =>  md5($password),
            'user_type'     =>  $user_type,
            'status'        =>  'Active',
            'user_group'    =>  $user_group
        );

        if($this->db->insert('add_users',$data)){
            JSONResponse(['type'=>'success', 'msg'=>'User has been added.']);
        }

        JSONResponse(['type'=>'warning', 'msg'=>'Error adding user information!']);
    }

    public function update_user($id)
    {
        if ($this->session->userdata('user_type') != 'Administrator')
            JSONResponse(['type'=>'error', 'msg'=>'Unauthorize access!']);

        $id = urldecode($id);

        if(!$this->tsms_model->verify_user($id))
            JSONResponse(['type'=>'error', 'msg'=>'User not found!']);


        $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[4]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[2]');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]');
        $this->form_validation->set_rules('user_type', 'User Type', 'required');
        $this->form_validation->set_rules('user_group', 'User Group', 'callback_verify_userGroup');
        
         if ($this->form_validation->run() === FALSE)
                JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);

        $first_name     = $this->sanitize($this->input->post('first_name'));
        $last_name      = $this->sanitize($this->input->post('last_name'));
        $username       = $this->sanitize($this->input->post('username'));
        $user_type      = $this->sanitize($this->input->post('user_type'));
        $user_group     = $this->sanitize($this->input->post('user_group'));

        
        $data = array(
            'name'          =>  $first_name,
            'last_name'     =>  $last_name,
            'username'      =>  $username,
            'user_type'     =>  $user_type,
            'user_group'    =>  $user_group
        );

        if($this->tsms_model->update($data, $id, 'add_users')){
            JSONResponse(['type'=>'success', 'msg'=>'User has been updated.']);
        }

        JSONResponse(['type'=>'warning', 'msg'=>'Error updating user information!']);
    }

    public function verify_userGroup($str){
        $user_type = $this->input->post('user_type');

        $store_id = $this->tsms_model->store_id($str);

        if($user_type != 'Administrator' && $store_id == 0){
            $this->form_validation->set_message('verify_userGroup', "The {field} field is not a valid value.");
            return FALSE;
        }

        return TRUE;
    }


    public function delete_user($id)
    {
        if ($this->session->userdata('user_type') != 'Administrator')
            JSONResponse(['type'=>'error', 'msg'=>'Unauthorize access!']);

        $id = urldecode($id);

        if ($this->tsms_model->delete('add_users', 'id', $id)) {
            JSONResponse(['type'=>'success', 'msg'=>'User has been deleted.']);
        } 
            
        JSONResponse(['type'=>'warning', 'msg'=>'Error deleting user!']);
        
    }

    public function reset_password($id)
    {
        if ($this->session->userdata('user_type') != 'Administrator')
            JSONResponse(['type'=>'error', 'msg'=>'Unauthorize access!']);

        $id = urldecode($id);

        if ($this->tsms_model->update(['password' => md5('agc-tsms')], $id, 'add_users')) {
           JSONResponse(['type'=>'success', 'msg'=>'User password has been set to default.']);
        }

        JSONResponse(['type'=>'warning', 'msg'=>'Error resetting user password!']);
    }

    public function activate_user($id)
    {
        if ($this->session->userdata('user_type') != 'Administrator')
            JSONResponse(['type'=>'error', 'msg'=>'Unauthorize access!']);

        $id = urldecode($id);

        if ($this->tsms_model->update(['status' => 'Active'], $id, 'add_users')) {
           JSONResponse(['type'=>'success', 'msg'=>'User has been activated.']);
        }

        JSONResponse(['type'=>'warning', 'msg'=>'Error activating user!']);
    }

    public function block_user($id)
    {  
        if ($this->session->userdata('user_type') != 'Administrator')
            JSONResponse(['type'=>'error', 'msg'=>'Unauthorize access!']);

        $id = urldecode($id);

        if ($this->tsms_model->update(['status' => 'Blocked'], $id, 'add_users')) {
           JSONResponse(['type'=>'success', 'msg'=>'User has been blocked.']);
        }

        JSONResponse(['type'=>'warning', 'msg'=>'Error blocking user!']);

    }

    public function change_username(){

        $this->form_validation->set_message('is_unique', 'The %s is already taken.');

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[add_users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE)
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);

        $username = $this->sanitize($this->input->post('username'));
        $password = $this->sanitize($this->input->post('password'));

        $user_id = $this->session->userdata('id');

        if($this->tsms_model->check_user($user_id, $password)){

            $this->tsms_model->update(['username' => $username], $user_id, 'add_users');
            JSONResponse(['type'=>'success', 'msg'=>'Username successfully changed.']);
        }

        JSONResponse(['type'=>'warning', 'msg'=>'Password mismatched!']);

    }

    public function change_password(){

        $this->form_validation->set_rules('curr_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[5]');
        $this->form_validation->set_rules('conf_password', 'Confirm Password', 'required|matches[new_password]');

        if ($this->form_validation->run() === FALSE)
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);


        $curr_password          = $this->sanitize($this->input->post('curr_password'));
        $new_password           = $this->sanitize($this->input->post('new_password'));

        $user_id = $this->session->userdata('id');

        if($this->tsms_model->check_user($user_id, $curr_password)){

            $this->tsms_model->update(['password' => md5($new_password)], $user_id, 'add_users');
            JSONResponse(['type'=>'success', 'msg'=>'Password successfully changed.']);
        }

        JSONResponse(['type'=>'warning', 'msg'=>'Password mismatched!']);
    }

     public function get_tsms_users()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
           
                $result = $this->tsms_model->get_tsms_users();
                echo json_encode($result);
           
        } else {
            redirect('cntrl_tsms');
        }
    }

    public function get_tsmsusers_data()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_tsmsusers_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function dashboard_data()
    {   
        

        $daily_unconfirmed   = $this->tsms_model->get_daily_unconfirmed();
        $daily_unmatched     = $this->tsms_model->get_daily_unmatched();
        $daily               = ['unconfirmed' => count($daily_unconfirmed), 'unmatched'=> count($daily_unmatched)];


        $hourly_unconfirmed  = $this->tsms_model->get_hourly_unconfirmed();
        $hourly_unmatched    = $this->tsms_model->get_hourly_unmatched();
        $hourly              =  ['unconfirmed' => count($hourly_unconfirmed), 'unmatched'=> count($hourly_unmatched)];

        $leasing             = count($this->tsms_model->get_leasing_pending());
        $variance            = count($this->tsms_model->get_variance_pending());

        JSONResponse(compact('daily', 'hourly', 'leasing', 'variance'));
    }

    public function checkbox(){
      
        if ($this->input->post('submit')) {
      
            $status = $this->input->post('status');
          



        $this->load->model('tsms_model');
        $this->tsms_model->status($status);
        }
    }

    public function hourly_sales() {
    
        $result=$this->_DB2->get('tenant_hourly_sales')->result();
        $arr_data=array();
        $i=0;
        foreach($result as $r){
            $arr_data[$i]['tenant_code']=$r->tenant_code;
            $arr_data[$i]['pos_num']=$r->pos_num;
            $arr_data[$i]['transac_date']=$r->transac_date;
            $arr_data[$i]['hour_code']=$r->hour_code;
            $arr_data[$i]['netsales_amount_hour']=$r->netsales_amount_hour;
            $arr_data[$i]['numsales_transac_hour']=$r->numsales_transac_hour;
            $arr_data[$i]['customer_count_hour']=$r->customer_count_hour;
            $arr_data[$i]['totalnetsales_amount_hour']=$r->totalnetsales_amount_hour;
            $arr_data[$i]['totalnumber_sales_transac']=$r->totalnumber_sales_transac;
            $arr_data[$i]['total_customer_count_day']=$r->total_customer_count_day;
            $arr_data[$i]['status']=$r->status;
     




          
            $i++;
    }


    echo json_encode($arr_data);
    }

    public function get_users() 
    {
        JSONResponse($this->tsms_model->get_users()); 
    }

    public function get_pending_list() 
    {
        JSONResponse($this->tsms_model->get_pending_list2());
    }

    public function get_pending_list2() 
    {
        JSONResponse($this->tsms_model->get_pending_list());
    }

    public function get_upload_history() 
    {             
        JSONResponse($this->tsms_model->get_upload_history());
    }

    public function get_stores(){
        JSONResponse($this->tsms_model->get_stores());
    }

    public function verify_username($username)
    {
        $result = $this->db->query("SELECT 
                                        `id` 
                                    FROM 
                                        `add_users`
                                    WHERE 
                                       `username` = '$username'");
        if ($result->num_rows()>0) {
            echo true;
        } else {
            echo false;
        }
    }
    
    public function verify_username_update($data)
    {
        $data = explode("_", $data);
        $username = $data[0];
        $id = $data[1];

        $result = $this->_DB2->query("SELECT 
                                        id
                                    FROM
                                        add_users
                                    WHERE 
                                        username = '$username' 
                                    AND  
                                        id <> '$id'");
        if ($result->num_rows()>0) 
        {
            echo true;
        } else {

            echo false;
        }
    }

     public function add_discounts()
    {
        ($data=array(

        'tenant_code'=>$this->input->post('tenant_code'),
        'trade_name'=>$this->input->post('trade_name'),
        'discounts_and_deduction_type'=>$this->input->post('discounts_and_deduction_type'),
        'date'=>$this->input->post('date')));
        
            $this->_DB2->insert('discount_deduction_types',$data);
        redirect('main/discounts_and_deductions');

    }



    public function get_hourly_sales()
    {
        $result = $this->tsms_model->get_hourly_sales();
        JSONResponse($result);
    }

    public function get_unhourly_sales()
    { 
        $result = $this->tsms_model->get_unhourly_sales();
        JSONResponse($result);
    }

    public function get_disapproved_hourly()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
            
                $result = $this->tsms_model->get_disapproved_hourly();
                echo json_encode($result);
           
        } else {
            redirect('cntrl_tsms');
        }
    }

    public function get_disapproved_daily()
    {
        $result = $this->tsms_model->get_disapproved_daily();
        JSONResponse($result);
    }

    public function confirmed_hourly_sales()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
            
                $result = $this->tsms_model->confirmed_hourly_sales();
                echo json_encode($result);
           
        } else {
            redirect('cntrl_tsms');
        }
    }

    public function get_hourly_total()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
            
                
                $result = $this->tsms_model->get_hourly_total();
                echo json_encode($result);
           
        } else {
            redirect('cntrl_tsms');
        }
    }

    public function get_hourlysales_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_hourlysales_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function get_disapprove_hourly_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_hourlysales_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function for_approvement_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $transac_date = $this->uri->segment(3);
            $trade_name = str_replace("%20"," ", $this->uri->segment(4));
            $result = $this->tsms_model->for_approvement_data($transac_date,$trade_name);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function get_uploadhistory_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_uploadhistory_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function get_leasing_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_leasing_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function for_leasing_data($tenant_list, $trade_name)
    {
        if ($this->session->userdata('is_logged_in')) 
        {
            $tenant_list    = urldecode($tenant_list);
            $trade_name     =  urldecode($trade_name);

            $result = $this->tsms_model->for_leasing_data($tenant_list, $trade_name);
            JSONResponse($result);
        }
    }

    public function get_daily_sales()
    {
        if (!$this->session->userdata('is_logged_in')) 
             redirect('cntrl_tsms');
            
        $result = $this->tsms_model->get_daily_sales();
            JSONResponse($result);
        
      
    }

    public function get_undaily_sales()
    {
        $result = $this->tsms_model->get_undaily_sales();
            JSONResponse($result);
    }

    public function get_upload_status()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
           
                $result = $this->tsms_model->get_upload_status();
                echo json_encode($result);
        
        } else {
            redirect('cntrl_tsms');
        }
    }

    public function get_dailysales_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_dailysales_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function get_inputsales_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_inputsales_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function get_undailysales_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_undailysales_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function get_pending_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_pending_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function get_variance_data()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_variance_data($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }

    public function update_hourly_sales()
        {
            if ($this->session->userdata('is_logged_in'))
          {
          
           
             
                $id_to_update = $this->uri->segment(3);
                $id_to_insert = $this->uri->segment(3);

                $tenant_code = $this->sanitize($this->input->post('tenant_code'));
                $tenant_type_code = $this->input->post('tenant_type_code');
                $pos_num = $this->sanitize($this->input->post('pos_num'));
                $trade_name = $this->sanitize($this->input->post('trade_name'));
                $rental_type = $this->sanitize($this->input->post('rental_type'));
                $tenant_type = $this->sanitize($this->input->post('tenant_type'));
                $transac_date = $this->sanitize($this->input->post('transac_date'));
                $hour_code = $this->sanitize($this->input->post('hour_code'));
                $netsales_amount_hour = $this->sanitize($this->input->post('netsales_amount_hour'));
                $numsales_transac_hour = $this->sanitize($this->input->post('numsales_transac_hour'));
                $customer_count_hour = $this->sanitize($this->input->post('customer_count_hour'));
                $totalnetsales_amount_hour = $this->sanitize($this->input->post('totalnetsales_amount_hour'));
                $totalnumber_sales_transac = $this->sanitize($this->input->post('totalnumber_sales_transac'));
                $total_customer_count_day = $this->sanitize($this->input->post('total_customer_count_day'));
                $status = $this->sanitize($this->input->post('status'));
                $status1 = $this->sanitize($this->input->post('status1'));
                $date_upload = $this->sanitize($this->input->post('date_upload'));
                $prospect_id = $this->sanitize($this->input->post('prospect_id'));
                $txtfile_name = $this->sanitize($this->input->post('txtfile_name'));
              
              $data = array(

                    'tenant_code'               =>          $tenant_code,
                    'tenant_type_code'          =>          $tenant_type_code,
                    'pos_num'                   =>          $pos_num,
                    'trade_name'                =>          $trade_name,
                    'tenant_type'               =>          $tenant_type,
                    'rental_type'               =>          $rental_type,
                    'transac_date'              =>          $transac_date,
                    'hour_code'                 =>          $hour_code,
                    'netsales_amount_hour'      =>          $netsales_amount_hour,
                    'numsales_transac_hour'     =>          $numsales_transac_hour,
                    'customer_count_hour'       =>          $customer_count_hour,
                    'totalnetsales_amount_hour' =>          $totalnetsales_amount_hour,
                    'totalnumber_sales_transac' =>          $totalnumber_sales_transac,
                    'total_customer_count_day'  =>          $total_customer_count_day,
                    'status'                    =>          'Pending',
                    'date_upload'               =>          $date_upload,
                    'prospect_id'               =>          $prospect_id,
                    'txtfile_name'               =>          $txtfile_name
                   
                );
                
               

                if($status == 'Confirmed' && $status1 == 'Unconfirmed')
            {  

                 if($this->tsms_model->update($data, $id_to_update, 'tenant_hourly_sales'))
                    {  
                        
                               
                                $this->tsms_model->checked_and_audited_m($data, $id_to_update, 'confirmed_hourly_sales');
                                $this->session->set_flashdata('message', 'Updated');
                                redirect('cntrl_tsms/tenant_hourly_sales'); 
                        
                                             
                      
                    }else{
                            $this->session->set_flashdata('message', 'Already Exist');
                            redirect('cntrl_tsms/tenant_hourly_sales');
                        }  
            }else{
                $this->session->set_flashdata('message', 'Already Exist');
                redirect('cntrl_tsms/tenant_hourly_sales');
                }   
            

          }else{
            redirect('cntrl_tsms/');
          }

            
        }

            public function delete_hourly_sales()
    {
            if($this->session->userdata('is_logged_in'))
        {   
            $id_to_delete = $this->uri->segment(3);

            if($this->tsms_model->delete('tenant_hourly_sales', 'id', $id_to_delete)){

                $this->session->set_flashdata('message','Deleted');
            }else{
                $this->session->set_flashdata('message', 'Error');
            }
                redirect('cntrl_tsms/tenant_hourly_sales/');
        }else{
            redirect('cntrl_tsms/');
        }

    }

    public function update_daily_sales($id_to_update)
    {                     
        $id_to_update = urldecode($id_to_update);

        $data = (array)$this->db->query("SELECT * FROM tenant_daily_sales WHERE id = '$id_to_update' LIMIT 1")->row();

        if(empty($data))
            JSONResponse(['type'=>'warning', 'msg' =>'Tenant Daily Sale not found!']);
  
         
        if($data['status'] == 'Unconfirmed' ||  $data['status'] == 'Unmatched')
        {  

            if($data['status'] == 'Unconfirmed' ){
                $data2 = ['status' => 'Confirmed', 'approved_by'=> $this->session->userdata('name')];
            } else {
                $data2 = ['status' => 'Confirmed', 'adjustment' => 'Updated', 'approved_by'=> $this->session->userdata('name')];
                $data['adjustment'] = 'Updated';
            }

            $data['status'] = 'Confirmed';
            $data['approved_by'] = $this->session->userdata('name');

            
            $condition = [
                'tenant_type'       => $data["tenant_type"],
                'tenant_code'       => $data["tenant_code"], 
                'transac_date'      => $data["transac_date"],
                'pos_num'           => $data["pos_num"]
            ];

            $confirmed = $this->tsms_model->getData('confirmed_daily_sales', $condition);
            
            if(empty($confirmed))
            {
                $this->tsms_model->checked_and_audited_m($data, $id_to_update, 'confirmed_daily_sales'); 
                $this->tsms_model->update($data2, $id_to_update, 'tenant_daily_sales');
                JSONResponse(['type'=>'success', 'msg' =>'Tenant Daily Sale succesfully confirmed.']);
            }

            JSONResponse(['type'=>'warning', 'msg' =>'Tenant Daily Sale already exists in Confirmed Tenant Daily Sale Table']);

        }else{
            JSONResponse(['type'=>'warning', 'msg' =>'Tenant Daily Sale status already confirmed. No changes made.']);
        }
    }

    public function update_undaily_sales()
    {
            if ($this->session->userdata('is_logged_in'))
        {
                 
              $id_to_update = $this->uri->segment(3);

              $approved_by = $this->session->userdata('name'); 
              $tenant_code = $this->sanitize($this->input->post('tenant_code'));
              $pos_num = $this->sanitize($this->input->post('pos_num'));
              $transac_date = $this->sanitize($this->input->post('transac_date'));
              $old_acctotal = $this->sanitize($this->input->post('old_acctotal'));
              $new_acctotal = $this->sanitize($this->input->post('new_acctotal'));
              $total_gross_sales = $this->sanitize($this->input->post('total_gross_sales'));
              $total_nontax_sales = $this->sanitize($this->input->post('total_nontax_sales'));
              $total_sc_discounts = $this->sanitize($this->input->post('total_sc_discounts'));
              $other_discounts = $this->sanitize($this->input->post('other_discounts'));
              $total_pwd_discounts = $this->sanitize($this->input->post('total_pwd_discounts'));
              $total_refund_amount = $this->sanitize($this->input->post('total_refund_amount'));
              $total_taxvat = $this->sanitize($this->input->post('total_taxvat'));
              $total_other_charges = $this->sanitize($this->input->post('total_other_charges'));
              $total_service_charge = $this->sanitize($this->input->post('total_service_charge'));
              $total_net_sales = $this->sanitize($this->input->post('total_net_sales'));
              $total_cash_sales = $this->sanitize($this->input->post('total_cash_sales'));
              $total_charge_sales = $this->sanitize($this->input->post('total_charge_sales'));
              $total_gcother_values = $this->sanitize($this->input->post('total_gcother_values'));
              $total_void_amount = $this->sanitize($this->input->post('total_void_amount'));
              $total_customer_count = $this->sanitize($this->input->post('total_customer_count'));
              $control_num = $this->sanitize($this->input->post('control_num'));
              $total_sales_transaction = $this->sanitize($this->input->post('total_sales_transaction'));
              $sales_type = $this->sanitize($this->input->post('sales_type'));
              $total_netsales_amount = $this->sanitize($this->input->post('total_netsales_amount'));
              $tenant_type = $this->sanitize($this->input->post('tenant_type'));
              $rental_type = $this->sanitize($this->input->post('rental_type'));
              $trade_name = $this->sanitize($this->input->post('trade_name'));
              $tenant_type_code = $this->sanitize($this->input->post('tenant_type_code'));
              $status = $this->sanitize($this->input->post('status'));
              $status1 = $this->sanitize($this->input->post('status1'));
              $date_upload = $this->sanitize($this->input->post('date_upload'));
              $location_code = $this->sanitize($this->input->post('location_code'));
              $txtfile_name = $this->sanitize($this->input->post('txtfile_name'));

              $data = array(
                    'id'                        =>          $id_to_update,
                    'old_acctotal'              =>          $old_acctotal,
                    'tenant_code'               =>          $tenant_code,
                    'pos_num'                   =>          $pos_num,
                    'transac_date'              =>          $transac_date,
                    'new_acctotal'              =>          $new_acctotal,
                    'total_gross_sales'         =>          $total_gross_sales,
                    'total_nontax_sales'        =>          $total_nontax_sales,
                    'total_sc_discounts'        =>          $total_sc_discounts,
                    'other_discounts'           =>          $other_discounts,
                    'total_pwd_discounts'       =>          $total_pwd_discounts,
                    'total_refund_amount'       =>          $total_refund_amount,
                    'total_taxvat'              =>          $total_taxvat,
                    'total_other_charges'       =>          $total_other_charges,
                    'total_service_charge'      =>          $total_service_charge,
                    'total_net_sales'           =>          $total_net_sales,
                    'total_cash_sales'          =>          $total_cash_sales,
                    'total_charge_sales'        =>          $total_charge_sales,
                    'total_gcother_values'      =>          $total_gcother_values,
                    'total_void_amount'         =>          $total_void_amount,
                    'total_customer_count'      =>          $total_customer_count,
                    'control_num'               =>          $control_num,
                    'total_sales_transaction'   =>          $total_sales_transaction,
                    'sales_type'                =>          $sales_type,
                    'total_netsales_amount'     =>          $total_netsales_amount,
                    'tenant_type'               =>          $tenant_type,
                    'rental_type'               =>          $rental_type,
                    'trade_name'                =>          $trade_name,
                    'tenant_type_code'          =>          $tenant_type_code,
                    'total_netsales_amount'     =>          $total_netsales_amount,
                    'status'                    =>          'Confirmed',
                    'date_upload'               =>          $date_upload,
                    'location_code'             =>          $location_code,
                    'txtfile_name'              =>          $txtfile_name,
                    'approved_by'               =>          $approved_by,
                    'adjustment'                =>          'Updated'   
                );

              $data2 = array('status' => 'Confirmed', 'adjustment' => 'Updated');
   
                if($status == 'Confirm' && $status1 == 'Unmatched')
                {  

                     if($this->tsms_model->update($data2, $id_to_update, 'tenant_daily_sales'))
                        {  
                            
                            $this->tsms_model->checked_and_audited_m($data, $id_to_update, 'confirmed_daily_sales');
                            $this->session->set_flashdata('message', 'Updated');
                            redirect('cntrl_tsms/unmatched_daily_sales'); 

                        }else{
                                $this->session->set_flashdata('message', 'Already Exist');
                                redirect('cntrl_tsms/unmatched_daily_sales');
                            }  
                }else{
                    $this->session->set_flashdata('message', 'Already Exist');
                    redirect('cntrl_tsms/unmatched_daily_sales');
                    }


            
        } else {
                redirect('cntrl_tsms/');
                }

    }

    public function delete_daily_sales($id)
    {
        $id = urldecode($id);

        if($this->tsms_model->delete('tenant_daily_sales', 'id', $id)){
            JSONResponse(['type'=>'success', 'msg'=>'Daily sale has been deleted!']);
        }else{
            JSONResponse(['type'=>'success', 'msg'=>'Error deleting daily sale record!']);
        }
    }

    public function delete_inputsales_data($id)
    {
        $id = urldecode($id);

        if($this->tsms_model->delete('input_sales_data', 'id', $id)){
            JSONResponse(['type'=>'success', 'msg'=>'Sales Data has been deleted.']);
        }
        
        JSONResponse(['type'=>'warning', 'msg'=>'Error deleting Sales Data!']);

    }

    public function delete_undaily_sales()
    {
            if($this->session->userdata('is_logged_in'))
        {   
            $id_to_delete = $this->uri->segment(3);

            if($this->tsms_model->delete('tenant_daily_sales', 'id', $id_to_delete)){

                $this->session->set_flashdata('message','Deleted');
            }else{
                $this->session->set_flashdata('message', 'Error');
            }
                redirect('cntrl_tsms/unmatched_daily_sales/');
        }else{
            redirect('cntrl_tsms/');
        }


    }
    public function archive_hourly_sales()
    {
        if($this->tsms_model->archive_hourly_sales())
            JSONResponse(['type'=>'success', 'msg'=>"Confirmed hourly sales succesfully archived"]);

        JSONResponse(['type'=>'warning', 'msg'=>'No confirmed hourly sales available to archive']);
    }

    public function archive_daily_sales()
    {
           
        if($this->tsms_model->archive_daily_sales()){
            JSONResponse(['type'=>'success', 'msg'=>'Successfuly archived!']);
        }

        JSONResponse(['type'=>'warning', 'msg'=>'No record available to archive!']);
    }

    public function get_trade_name()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
          
                $result = $this->tsms_model->get_trade_name();
                echo json_encode($result);
           
        } else {
            redirect('cntrl_tsms');
        }
    }

    public function get_delupload_status($trade_name, $txt_file)
    {
        
            $trade_name     = urldecode($trade_name);
            $txtfile        = urldecode($txt_file);

            $result = $this->tsms_model->get_delupload_status($trade_name, $txtfile);

            JSONResponse($result);
    
    }

    public function get_tenants($flag)
    {   
        $flag = urldecode($flag);
        if ($this->session->userdata('is_logged_in')) 
        {
           $result = $this->tsms_model->get_tenants($flag);
           JSONResponse($result);
        }
    }

    public function get_fixed_tenants($flag)
    {
       $result = $this->tsms_model->get_fixed_tenants(urldecode($flag));
       JSONResponse($result);

    }

    public function get_location_code($trade_name)
    {       
        $trade_name = urldecode($trade_name);

        if ($this->session->userdata('is_logged_in')) 
        {
            $result = $this->tsms_model->get_location_code($trade_name);
            echo json_encode($result);
        }
    }

    public function get_rental_type()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
            $location_code = str_replace("%20", " ", $this->uri->segment(3));
            $result = $this->tsms_model->get_rental_type($location_code);
            echo json_encode($result);
        }
    }


    public function tenantList_daily()
    {

       $result = $this->tsms_model->get_tenantList_daily();
       JSONResponse($result);

    }

    public function tenantList_hourly()
    {
        if ($this->session->userdata('is_logged_in')) 
        {
           $result = $this->tsms_model->get_tenantList_hourly();
           echo json_encode($result);
        }
    }


    public function filter_sales($data, $trade_name, $location_code="")
    {

         
        //$data = explode("_", str_replace("%20"," ", $this->uri->segment(3)));
        //$trade_name = str_replace("%20"," ", $this->uri->segment(4));

        $trade_name         = urldecode($trade_name);
        $location_code      = urldecode($location_code);
        $data               = explode("_", urldecode($data));
        $tenant_list        = $data[0];
        $filter_date        = $data[1];
        
        $hourly     = $this->tsms_model->filter_sales($tenant_list, $trade_name, $filter_date, $location_code);
        $daily      = $this->tsms_model->match_sales($filter_date, $trade_name, $location_code);

        JSONResponse(["hourly"=>$hourly, 'daily'=>$daily]);
    }

    public function filter_sales_m($details, $trade_name, $res_type = 'json')
    {   
        $details        = explode('_', urldecode($details));
        $trade_name     = urldecode($trade_name);


        $tenant_term    = $details[0];
        $filter_date    = $details[1];
        $tenant_code    = $details[2];

    

        $store = $this->session->userdata('store_code');

        /*if(stripos($tenant_code, $store) === false && !empty($store))
           die();*/



        $result = $this->tsms_model->filter_sales_m($tenant_term, $trade_name,$filter_date,$tenant_code);

        if($res_type == 'json')
            JSONResponse($result);

        return $result;
    }

    public function sales_type($location_code)
    {
        // $location_code = $this->input->post('tenant_code');
        $location_code = urldecode($location_code);
        $result = $this->tsms_model->sales_type($location_code);
        JSONResponse($result);
    }

    public function calculate_total_m()
    {

        if ($this->session->userdata('is_logged_in')) 
        {   
            $data = explode("_", str_replace("%20"," ", $this->uri->segment(3)));
            $tenant_list = $data[0];

            $data1 = explode("-", $data[1]);
            unset($data1[0]);
            $filter_date = implode ('-',$data1);

            $trade_name = str_replace("%20"," ", $this->uri->segment(4));
           
            
            $result = $this->tsms_model->filter_sales_m($tenant_list,$trade_name,$filter_date);
            echo json_encode($result);

        } 
    }

    public function history_hourly_sales()
    {
        
        $result = $this->tsms_model->history_hourly_sales();
        JSONResponse($result);   
       
    }

    public function filter_daily_history_sales($tenant_type, $trade_name, $tenant_code, $date){

        $tenant_type    = urldecode($tenant_type);
        $trade_name     = urldecode($trade_name);
        $tenant_code    = urldecode($tenant_code);
        $date           = urldecode($date);

        JSONResponse($this->tsms_model->filter_daily_history_sales($tenant_type, $trade_name, $tenant_code, $date));
    }


    public function filter_hourly_history_sales($tenant_type, $trade_name, $tenant_code, $date){

        $tenant_type    = urldecode($tenant_type);
        $trade_name     = urldecode($trade_name);
        $tenant_code    = urldecode($tenant_code);
        $date           = urldecode($date);

        JSONResponse($this->tsms_model->filter_hourly_history_sales($tenant_type, $trade_name, $tenant_code, $date));
    }

    public function history_daily_sales()
    {
        $result = $this->tsms_model->history_daily_sales();
        JSONResponse($result);   
    }

    public function save_monthly_sale_computation($details, $trade_name){

      // if($_SERVER['REQUEST_METHOD'] != 'POST')
            //JSONResponse(['type'=>'warning', 'msg'=>'Invalid Request!']);

        

        $data = $this->filter_sales_m($details, $trade_name, 'array');

        if(empty($data))
            JSONResponse(['type'=>'warning', 'msg'=>'Record not found!']);


        
        $grouped_data = array_group_by($data, function($dt){ return $dt['pos_num']; });
        

        $old_acctotal = 0;
        $new_acctotal = 0;

        foreach($grouped_data as $gdata) {
            $x = count($gdata) - 1;
            $old_acctotal     += (float)$gdata[$x]["old_acctotal"];
            $new_acctotal     += (float)$gdata[$x]["new_acctotal"];
        }

       
        $fdate = explode('-', $data[0]['transac_date']);

        $pos_num          = implode(', ',array_keys($grouped_data));

        $rental_type      = $data[0]["rental_type"];
        $sales_type       = $data[0]["sales_type"];
        $control_num      = $data[0]["control_num"];
        $tenant_type_code = $data[0]["tenant_type_code"];
        $tenant_code      = $data[0]["tenant_code"];
        $location_code    = $data[0]["location_code"];
        $trade_name       = $data[0]["trade_name"];
        $tenant_type      = $data[0]["tenant_type"];
        $filter_date      = $fdate[0].'-'.$fdate[1];
        $location_code    = $data[0]["location_code"];

    
        $total_gross_sales          = 0; 
        $total_nontax_sales         = 0;
        $total_sc_discounts         = 0;
        $total_pwd_discounts        = 0;
        $total_discounts_w_approval = 0;
        $total_discounts_wo_approval= 0;
        $other_discounts            = 0;
        $total_refund_amount        = 0;
        $total_taxvat               = 0;
        $total_other_charges        = 0;
        $total_service_charge       = 0;
        $total_net_sales            = 0;
        $total_cash_sales           = 0;
        $total_charge_sales         = 0;
        $total_gcother_values       = 0;
        $total_void_amount          = 0;
        $total_customer_count       = 0;
        $total_sales_transaction    = 0;
        $total_netsales_amount      = 0;
        


        foreach ($data as $key => $dt) {
            
            $total_gross_sales            += (float) $dt["total_gross_sales"];
            $total_nontax_sales           += (float) $dt["total_nontax_sales"];
            $total_sc_discounts           += (float) $dt["total_sc_discounts"];
            $total_pwd_discounts          += (float) $dt["total_pwd_discounts"];
            $total_discounts_w_approval   += (float) $dt["total_discounts_w_approval"];
            $total_discounts_wo_approval  += (float) $dt["total_discounts_wo_approval"];
            $other_discounts              += (float) $dt["other_discounts"];
            $total_refund_amount          += (float) $dt["total_refund_amount"];
            $total_taxvat                 += (float) $dt["total_taxvat"];
            $total_other_charges          += (float) $dt["total_other_charges"];
            $total_service_charge         += (float) $dt["total_service_charge"];
            $total_net_sales              += (float) $dt["total_net_sales"];
            $total_cash_sales             += (float) $dt["total_cash_sales"];
            $total_charge_sales           += (float) $dt["total_charge_sales"];
            $total_gcother_values         += (float) $dt["total_gcother_values"];
            $total_void_amount            += (float) $dt["total_void_amount"];
            $total_customer_count         += (float) $dt["total_customer_count"];
            $total_sales_transaction      += (float) $dt["total_sales_transaction"];
            $total_netsales_amount        += (float) $dt["total_netsales_amount"];
                 
        } 
       

        preg_match('/(?:"[^"]*"|^[^"]*$)/', $data[0]["sales"], $matches);

        $stype = trim(preg_replace('/"/', '', $matches[0]));
        $sales=0;
        $vat = 0.12;
        $total=0;


        if($stype == 'GROSS')
        {
            $total = $total_gross_sales - abs($total_refund_amount);

        }elseif($stype == 'NET'){

            $total = $total_netsales_amount - abs($total_refund_amount);

        }elseif($stype == 'VATABLE SALES'){

            $this->form_validation->set_rules('discounts_w_approval', 'Discount with approval', 'required|numeric');

            if ($this->form_validation->run() === FALSE)
                JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);

            $sales = $total_gross_sales - $total_nontax_sales - (float) $this->input->post('discounts_w_approval');
            $total =  $sales - $total_sc_discounts - abs($total_refund_amount);
        }else{
            JSONResponse(['type'=>'warning', 'msg'=>'Invalid Sales Type!']);
        }

        $sales = $total;

        $data_tms = array(

            'trade_name'                        =>          $trade_name,
            'date_end'                          =>          $filter_date,
            'tenant_type'                       =>          $tenant_type,
            'rental_type'                       =>          $rental_type,
            'old_acctotal'                      =>          $old_acctotal,
            'new_acctotal'                      =>          $new_acctotal,
            'total_gross_sales'                 =>          $total_gross_sales,
            'total_nontax_sales'                =>          $total_nontax_sales,
            'total_sc_discounts'                =>          $total_sc_discounts,
            'total_pwd_discounts'               =>          $total_pwd_discounts,
            'total_discounts_w_approval'        =>          $total_discounts_w_approval,
            'total_discounts_wo_approval'       =>          $total_discounts_wo_approval,
            'other_discounts'                   =>          $other_discounts,
            'total_refund_amount'               =>          $total_refund_amount,
            'total_taxvat'                      =>          $total_taxvat,
            'total_other_charges'               =>          $total_other_charges,
            'total_service_charge'              =>          $total_service_charge,
            'total_net_sales'                   =>          $total_net_sales,
            'total_cash_sales'                  =>          $total_cash_sales,
            'total_charge_sales'                =>          $total_charge_sales,
            'total_gcother_values'              =>          $total_gcother_values,
            'total_void_amount'                 =>          $total_void_amount,
            'total_customer_count'              =>          $total_customer_count,
            'total_sales_transaction'           =>          $total_sales_transaction,
            'total_netsales_amount'             =>          $total_netsales_amount,
            'control_num'                       =>          $control_num,
            'sales_type'                        =>          $sales_type,
            'pos_num'                           =>          $pos_num,
            'tenant_type_code'                  =>          $tenant_type_code,
            'tenant_code'                       =>          $tenant_code,
            'location_code'                     =>          $location_code
        );

        $data_leasing = array(
            'trade_name'                =>          $trade_name,
            'date_end'                  =>          $filter_date,
            'tenant_type'               =>          $tenant_type,
            'tenant_code'               =>          $tenant_code,
            'rental_type'               =>          $rental_type,
            'total_nontax_sales'        =>          $total_nontax_sales,
            'status'                    =>          'Pending',
            'total_netsales_amount'     =>          $sales
        );


        if($result = $this->tsms_model->save_total_sales($tenant_type,$trade_name,$filter_date, $tenant_code))
            JSONResponse(["type"=>"warning", 'msg'=>"Monthly Sale computation already exists!"]);
                       
       
        $this->_DB2->insert('total_monthly_sales', $data_tms);

        $data_leasing['id'] = $this->_DB2->insert_id();
        
        $this->_DB2->insert('data_for_leasing', $data_leasing);

        JSONResponse(["type"=>"success", 'msg'=>"Monthly Sale computation succesfully saved."]);

    }

    public function save_total_sales()
    { 
        
        if ($this->session->userdata('is_logged_in')) 
        {
            
                
            $trade_name_data = $this->input->post('trade_name');
            $tenant_list = $this->input->post('tenant_type');
            $tenant_type_data = $this->input->post('tenant_type');
            $rental_type_data = $this->input->post('rental_type');
            $filter_date = $this->input->post('date');
            $trade_name = $this->input->post('trade_name');
            $tenant_type = $this->input->post('tenant_type');
            $rental_type = $this->input->post('rental_type');
            $old_acctotal = str_replace(',', '', $this->input->post('old_acctotal'));
            $new_acctotal = str_replace(',', '', $this->input->post('new_acctotal'));
            $total_gross_sales = str_replace(',', '', $this->input->post('total_gross_sales'));
            $total_nontax_sales = str_replace(',', '', $this->input->post('total_nontax_sales'));
            $total_sc_discounts = str_replace(',', '', $this->input->post('total_sc_discounts'));
            $total_pwd_discounts = str_replace(',', '', $this->input->post('total_pwd_discounts'));
            $total_discounts_w_approval = str_replace(',', '', $this->input->post('total_discounts_w_approval'));
            $total_discounts_wo_approval = str_replace(',', '', $this->input->post('total_discounts_wo_approval'));
            $other_discounts = str_replace(',', '', $this->input->post('other_discounts'));
            $total_refund_amount = str_replace(',', '', $this->input->post('total_refund_amount'));
            $total_taxvat = str_replace(',', '', $this->input->post('total_taxvat'));
            $total_other_charges = str_replace(',', '', $this->input->post('total_other_charges'));
            $total_service_charge = str_replace(',', '', $this->input->post('total_service_charge'));
            $total_net_sales = str_replace(',', '', $this->input->post('total_net_sales'));
            $total_cash_sales = str_replace(',', '', $this->input->post('total_cash_sales'));
            $total_charge_sales = str_replace(',', '', $this->input->post('total_charge_sales'));
            $total_gcother_values = str_replace(',', '', $this->input->post('total_gcother_values'));
            $total_void_amount = str_replace(',', '', $this->input->post('total_void_amount'));
            $total_customer_count = $this->input->post('total_customer_count');
            $total_sales_transaction = $this->input->post('total_sales_transaction');
            $total_netsales_amount = str_replace(',', '', $this->input->post('total_netsales_amount'));
            $control_num = $this->input->post('control_num');
            $sales_type = $this->input->post('sales_type');
            $pos_num = $this->input->post('pos_num');
            $tenant_type_code = $this->input->post('tenant_type_code');
            $tenant_code = $this->input->post('tenant_code');
            $location_code = $this->input->post('tenant_code');



                $data = array(

                    'trade_name'                        =>          $trade_name,
                    'date_end'                          =>          $filter_date,
                    'tenant_type'                       =>          $tenant_type,
                    'rental_type'                       =>          $rental_type,
                    'old_acctotal'                      =>          $old_acctotal,
                    'new_acctotal'                      =>          $new_acctotal,
                    'total_gross_sales'                 =>          $total_gross_sales,
                    'total_nontax_sales'                =>          $total_nontax_sales,
                    'total_sc_discounts'                =>          $total_sc_discounts,
                    'total_pwd_discounts'               =>          $total_pwd_discounts,
                    'total_discounts_w_approval'        =>          $total_discounts_w_approval,
                    'total_discounts_wo_approval'       =>          $total_discounts_wo_approval,
                    'other_discounts'                   =>          $other_discounts,
                    'total_refund_amount'               =>          $total_refund_amount,
                    'total_taxvat'                      =>          $total_taxvat,
                    'total_other_charges'               =>          $total_other_charges,
                    'total_service_charge'              =>          $total_service_charge,
                    'total_net_sales'                   =>          $total_net_sales,
                    'total_cash_sales'                  =>          $total_cash_sales,
                    'total_charge_sales'                =>          $total_charge_sales,
                    'total_gcother_values'              =>          $total_gcother_values,
                    'total_void_amount'                 =>          $total_void_amount,
                    'total_customer_count'              =>          $total_customer_count,
                    'total_sales_transaction'           =>          $total_sales_transaction,
                    'total_netsales_amount'             =>          $total_netsales_amount,
                    'control_num'                       =>          $control_num,
                    'sales_type'                        =>          $sales_type,
                    'pos_num'                           =>          $pos_num,
                    'tenant_type_code'                  =>          $tenant_type_code,
                    'tenant_code'                       =>          $tenant_code,
                    'location_code'                     =>          $location_code
                       
                );


                $for_leasing_data = array(

                    'trade_name'                =>          $trade_name_data,
                    'date_end'                  =>          $filter_date,
                    'tenant_type'               =>          $tenant_type,
                    'tenant_code'               =>          $tenant_code,
                    'rental_type'               =>          $rental_type,
                    'total_nontax_sales'        =>          $total_nontax_sales,
                    'status'                    =>          'Pending',
                    'total_netsales_amount'     =>          $total_netsales_amount

                );

                if($result = $this->tsms_model->save_total_sales($tenant_list,$trade_name,$filter_date))
                {   

                    $this->session->set_flashdata('message', 'Already Exist');
                    redirect('cntrl_tsms/computing_table_daily/');
                           
                }else{

                    $this->_DB2->insert('total_monthly_sales', $data);
                    $this->_DB2->insert('data_for_leasing', $for_leasing_data);
                    $this->session->set_flashdata('message', 'Added');
                    redirect('cntrl_tsms/computing_table_daily/');
                     
                }
                                     
        }else{
             redirect('cntrl_tsms');
        }
    }
    public function monthly_total($data){

        if ($this->session->userdata('is_logged_in')) 
        {
         
            $data = explode("_", urldecode($data));
            $tenant_list = $data[0];

            $data1 = explode("-", $data[1]);
            unset($data1[2]);
            $filter_date = implode ('-',$data1);
            
            $result = $this->tsms_model->monthly_total($tenant_list,$filter_date);
            JSONResponse($result);
        }

    }

    public function fixed_monthly_total($data){

        $data = explode("_", urldecode($data));

        $tenant_list = $data[0];
        $filter_date = $data[1];
    

        $result = $this->tsms_model->fixed_monthly_total($tenant_list,$filter_date);
        JSONResponse($result);
    }

    public function search_pending_items(){

        if ($this->session->userdata('is_logged_in')) 
        {
         
            $data = explode("_", str_replace("%20"," ", $this->uri->segment(3)));
            $tenant_list = $data[0];

            $data1 = explode("-", $data[1]);
            unset($data1[0]);
            $filter_date = implode ('-',$data1);

            $trade_name = str_replace("%20"," ", $this->uri->segment(4));
           
            
            $result = $this->tsms_model->pending_items($tenant_list,$trade_name,$filter_date);
            echo json_encode($result);

           
           
        }

    }


    public function monthly_report($data, $trade_name){

             
        $data = explode("_", urldecode($data));
        $tenant_list = $data[0];
        $filter_date = $data[1];

        $trade_name = urldecode($trade_name);       
        
        $daily = $this->tsms_model->monthly_report($tenant_list,$trade_name,$filter_date);
        $monthly = $this->tsms_model->get_monthly_total_report($tenant_list, $trade_name, $filter_date);


        JSONResponse(["daily"=>$daily, "monthly" => $monthly]);
    }

    public function get_monthly_total()
   {
        if ($this->session->userdata('is_logged_in')) 
        {
            $id = $this->uri->segment(3);
            $result = $this->tsms_model->get_monthly_total($id);
            echo json_encode($result);
            
        } else {
            redirect('cntrl_tsms/');
        }
    }



    public function update_monthly_total($id_to_update)
    {   
    
        if ($this->session->userdata('user_type') == 'Administrator')
        {
          $id_to_update = urldecode($id_to_update);

          $tenant_code                  = $this->sanitize($this->input->post('tenant_code'));
          $pos_num                      = $this->sanitize($this->input->post('pos_num'));
          $transac_date                 = $this->sanitize($this->input->post('date_end'));
          $old_acctotal                 = $this->sanitize($this->input->post('old_acctotal'));
          $new_acctotal                 = $this->sanitize($this->input->post('new_acctotal'));
          $total_gross_sales            = $this->sanitize($this->input->post('total_gross_sales'));
          $total_nontax_sales           = $this->sanitize($this->input->post('total_nontax_sales'));
          $total_sc_discounts           = $this->sanitize($this->input->post('total_sc_discounts'));
          $other_discounts              = $this->sanitize($this->input->post('other_discounts'));
          $total_pwd_discounts          = $this->sanitize($this->input->post('total_pwd_discounts'));
          $total_refund_amount          = $this->sanitize($this->input->post('total_refund_amount'));
          $total_taxvat                 = $this->sanitize($this->input->post('total_taxvat'));
          $total_other_charges          = $this->sanitize($this->input->post('total_other_charges'));
          $total_service_charge         = $this->sanitize($this->input->post('total_service_charge'));
          $total_net_sales              = $this->sanitize($this->input->post('total_net_sales'));
          $total_cash_sales             = $this->sanitize($this->input->post('total_cash_sales'));
          $total_charge_sales           = $this->sanitize($this->input->post('total_charge_sales'));
          $total_gcother_values         = $this->sanitize($this->input->post('total_gcother_values'));
          $total_void_amount            = $this->sanitize($this->input->post('total_void_amount'));
          $total_customer_count         = $this->sanitize($this->input->post('total_customer_count'));
          $control_num                  = $this->sanitize($this->input->post('control_num'));
          $total_sales_transaction      = $this->sanitize($this->input->post('total_sales_transaction'));
          $sales_type                   = $this->sanitize($this->input->post('sales_type'));
          $total_netsales_amount        = $this->sanitize($this->input->post('total_netsales_amount'));
          $tenant_type                  = $this->sanitize($this->input->post('tenant_type'));
          $rental_type                  = $this->sanitize($this->input->post('rental_type'));
          $trade_name                   = $this->sanitize($this->input->post('trade_name'));
          $tenant_type_code             = $this->sanitize($this->input->post('tenant_type_code'));

          $data = array(

                'old_acctotal'              =>          $old_acctotal,
                'tenant_code'               =>          $tenant_code,
                'pos_num'                   =>          $pos_num,
                'date_end'                  =>          $transac_date,
                'new_acctotal'              =>          $new_acctotal,
                'total_gross_sales'         =>          $total_gross_sales,
                'total_nontax_sales'        =>          $total_nontax_sales,
                'total_sc_discounts'        =>          $total_sc_discounts,
                'other_discounts'           =>          $other_discounts,
                'total_pwd_discounts'       =>          $total_pwd_discounts,
                'total_refund_amount'       =>          $total_refund_amount,
                'total_taxvat'              =>          $total_taxvat,
                'total_other_charges'       =>          $total_other_charges,
                'total_service_charge'      =>          $total_service_charge,
                'total_net_sales'           =>          $total_net_sales,
                'total_cash_sales'          =>          $total_cash_sales,
                'total_charge_sales'        =>          $total_charge_sales,
                'total_gcother_values'      =>          $total_gcother_values,
                'total_void_amount'         =>          $total_void_amount,
                'total_customer_count'      =>          $total_customer_count,
                'control_num'               =>          $control_num,
                'total_sales_transaction'   =>          $total_sales_transaction,
                'sales_type'                =>          $sales_type,
                'total_netsales_amount'     =>          $total_netsales_amount,
                'tenant_type'               =>          $tenant_type,
                'rental_type'               =>          $rental_type,
                'trade_name'                =>          $trade_name,
                'tenant_type_code'          =>          $tenant_type_code,
                'total_netsales_amount'     =>          $total_netsales_amount
               
            );
            

            if($this->tsms_model->update($data, $id_to_update, 'total_monthly_sales'))
            {  
                JSONResponse(['type'=>'success', 'msg'=>'Total Monthly Sale has been updated.']);
              
            }else{
                JSONResponse(['type'=>'warning', 'msg'=>'Unable to update Total Monthly Sale!']);
            }  
    
        } else{
            JSONResponse(['type'=>'success', 'msg'=>'Unauthorize access!']);
        }

    }

    public function delete_monthly_total($id_to_delete)
    {   

         if($this->session->userdata('user_type') != 'Administrator')
            JSONResponse(["type"=>"warning", 'msg'=>'You are unauthorize to perform this action!']);
         
        
        $id_to_delete = urldecode($id_to_delete);

        $data_leasing       = $this->tsms_model->get_leasing_data_to_delete($id_to_delete);

        if(!empty($data_leasing)){
            
            $tenant_type    = $data_leasing["tenant_type"];
            $trade_name     = $data_leasing["trade_name"];
            $date_end       = $data_leasing["date_end"];
            $tenant_code    = $data_leasing["tenant_code"];


            $monthly_sale = (object)$this->tsms_model->save_total_sales($tenant_type, $trade_name, $date_end, $tenant_code)[0];

            if(!empty($monthly_sale))
                $this->tsms_model->delete('total_monthly_sales', 'id', $monthly_sale->id);

            $this->tsms_model->delete('data_for_leasing', 'id', $id_to_delete);

            JSONResponse(["type"=>"success", 'msg'=>'Record has been deleted.']);
        }
            
        JSONResponse(["type"=>"warning", 'msg'=>'Error deleting. Not found!']);
       
    }

    public function update_leasing_data($id_to_update)
    {   

        if($this->session->userdata('user_type') != 'Administrator' && $this->session->userdata('user_type') != 'Supervisor')
            JSONResponse(["type"=>"warning", 'msg'=>'You are unauthorize to perform this action!']);

        $transac_date           = implode (explode(',',$this->sanitize($this->input->post('date_end'))));
        $total_netsales_amount  = implode (explode(',',$this->sanitize($this->input->post('total_netsales_amount'))));
        $tenant_type            = implode (explode(',',$this->sanitize($this->input->post('tenant_type'))));
        $rental_type            = implode (explode(',',$this->sanitize($this->input->post('rental_type'))));
        $trade_name             = implode (explode(',',$this->sanitize($this->input->post('trade_name'))));

        $data = array(
            'date_end'                  =>          $transac_date,
            'tenant_type'               =>          $tenant_type,
            'rental_type'               =>          $rental_type,
            'trade_name'                =>          $trade_name,
            'total_netsales_amount'     =>          $total_netsales_amount
        );
       

        if($this->tsms_model->update($data, $id_to_update, 'data_for_leasing'))
            JSONResponse(["type"=>"success", "msg"=>"Data succesfully updated."]);
          
        
        JSONResponse(["type"=>"warning", "msg"=>"Update failed. No changes has been made."]);

    }
    public function upload_to_leasing($id)
    {
        $id= urldecode($id);

        date_default_timezone_set("Asia/Manila");
        $current_date = date('F j, Y, g:i A ');
        $uploaded_by = $this->session->userdata('name');

        $data_leasing = $this->tsms_model->get_data_for_sales_db($id);
          
        if(empty($data_leasing))
            JSONResponse(["type"=>"warning", 'msg'=>'Data already exists!']);


            
        $data_sales = array(
            'id'                            => $data_leasing['id'],
            'sales'                         => $data_leasing['total_netsales_amount'],
            'total_nontax_sales'            => $data_leasing['total_nontax_sales'], 
            'tenant_type'                   => $data_leasing['tenant_type'],
            'tenant_code'                   => $data_leasing['tenant_code'],
            'rental_type'                   => $data_leasing['rental_type'],
            'trade_name'                    => $data_leasing['trade_name'],
            'date'                          => $data_leasing['date_end'],
            'upload_date'                   => $current_date,
            'uploaded_by'                   => $uploaded_by
        );

        $data_history = array(
            'tenant_code'                   => $data_leasing['tenant_code'],
            'upload_date'                   => $current_date,
            'uploaded_by'                   => $uploaded_by,
            'total_netsales_amount'         => $data_leasing['total_netsales_amount'],
            'tenant_type'                   => $data_leasing['tenant_type'],
            'rental_type'                   => $data_leasing['rental_type'],
            'trade_name'                    => $data_leasing['trade_name'],
            'date'                          => $data_leasing['date_end'],       
        );

        $this->_DB2->insert('sales', $data_sales);
        $this->_DB2->insert('upload_history', $data_history);

        $this->tsms_model->update(['status' => 'Uploaded'], $id, 'data_for_leasing');

        JSONResponse(["type"=>"success", 'msg'=>'Data succesfully uploaded.']);
    }

    public function approve_pending_items()
    {
        
            $id  = $this->uri->segment('3');
            
            $data = array('status' => 'Confirmed' );

            if($this->tsms_model->update($data, $id, 'confirmed_daily_sales'))
             {
                if($this->tsms_model->update($data, $id, 'tenant_daily_sales')){
                    $this->session->set_flashdata('message', 'Approved');
                    redirect('cntrl_tsms/for_approvement');
                }

             }else{
                $this->session->set_flashdata('message', 'Error');
                redirect('cntrl_tsms/for_approvement');
             }   

           

    }


    public function check_hourly_sales()
    {

        $data = array('status' => 'Pending');

        if(isset($_POST['submit'])){

            if(!empty($_POST['checkboxes'])){



                $flag = false;

                foreach($_POST['checkboxes'] as $selected) {

                    if(!$result = $this->tsms_model->update($data, $selected, 'tenant_hourly_sales')){
                        $flag = true;
                        break;
                     }
                 }

                    if(!$flag){

                        $this->session->set_flashdata('message', 'Updated');
                        redirect('cntrl_tsms/tenant_hourly_sales/');
                    } else
                        {
                            $this->session->set_flashdata('message', 'Already Checked');
                            redirect('cntrl_tsms/tenant_hourly_sales/');
                        }
                
            } else{
                $this->session->set_flashdata('message', 'No File');
                redirect('cntrl_tsms/tenant_hourly_sales/');
            }

        }

    }

    public function update_hourly_sales_record()
    {

        $checkboxes = $this->input->post('checkboxes');
        $approved_by = $this->session->userdata('name');
        $count_success = 0;

        if(empty($checkboxes)) 
            JSONResponse(['type'=>'error', 'msg'=>'No data selected!']);

        foreach ($checkboxes as $key => $hsID) {

            if($this->tsms_model->validate_hourly_sales($hsID))
            {   
                
                
                $hourly_sale = (array)$this->tsms_model->get_hourly_sales_to_confirm($hsID);
                
                $query_chs = [
                    'id'                                => $hourly_sale['id'],
                    'tenant_code'                       => $hourly_sale['tenant_code'],
                    'pos_num'                           => $hourly_sale['pos_num'], 
                    'transac_date'                      => $hourly_sale['transac_date'], 
                    'hour_code'                         => $hourly_sale['hour_code'],
                    'netsales_amount_hour'              => $hourly_sale['netsales_amount_hour'],
                    'numsales_transac_hour'             => $hourly_sale['numsales_transac_hour'],
                    'customer_count_hour'               => $hourly_sale['customer_count_hour'],
                    'totalnetsales_amount_hour'         => $hourly_sale['totalnetsales_amount_hour'], 
                    'totalnumber_sales_transac'         => $hourly_sale['totalnumber_sales_transac'], 
                    'total_customer_count_day'          => $hourly_sale['total_customer_count_day'],
                    'status'                            => 'Confirmed',
                    'tenant_type'                       => $hourly_sale['tenant_type'],
                    'rental_type'                       => $hourly_sale['rental_type'],
                    'trade_name'                        => $hourly_sale['trade_name'], 
                    'tenant_type_code'                  => $hourly_sale['tenant_type_code'], 
                    'date_upload'                       => $hourly_sale['date_upload'],
                    'location_code'                     => $hourly_sale['location_code'],
                    'txtfile_name'                      => $hourly_sale['txtfile_name'],
                    'approved_by'                       => $approved_by
                ]; 

                $check_existence = $this->tsms_model->check_confirmed_hourly_existence(
                    $hourly_sale["tenant_type"], 
                    $hourly_sale["trade_name"], 
                    $hourly_sale["location_code"], 
                    $hourly_sale["transac_date"], 
                    $hourly_sale["hour_code"],
                    $hourly_sale["pos_num"]
                );

                if($check_existence == FALSE){
                    if($this->_DB2->insert('confirmed_hourly_sales', $query_chs)){
                        $this->tsms_model->update(['status' => 'Confirmed'], $hsID, 'tenant_hourly_sales');
                        $count_success++;
                    }
                }
            }      
        }


        if($count_success === count($checkboxes))
            JSONResponse(['type'=>'success', 'msg'=>'Hourly sales succesfully confirmed']);

        JSONResponse(['type'=>'warning', 'msg'=>$count_success .'/'.count($checkboxes). " hourly sales has been confirmed"]);
    }

    public function update_unhourly_sales_record()
    {
        $msg='';
        $data = array();
        $check = $this->input->post(['checkboxes']);
        $data1 = array('status' => 'Confirmed',);
        $approved_by = $this->session->userdata('name');

            if(!empty($_POST['checkboxes'])) 
            {
                for ($i=0; $i < count($check['checkboxes']); $i++)
                { 
                    
                    foreach($_POST['checkboxes'] as $selected) {

                        $this->tsms_model->update($data1, $selected, 'tenant_hourly_sales');
                    }

                    for ($i=0; $i < count($check['checkboxes']); $i++)
                    {
                        
                        $result = $this->tsms_model->check_hourly_sales($check['checkboxes'][$i]);

                        foreach ($result as $value) 
                        {
                            $data = array(
                            'id' => $value['id'],
                            'tenant_code' => $value['tenant_code'],
                            'pos_num' => $value['pos_num'], 
                            'transac_date' => $value['transac_date'], 
                            'hour_code' => $value['hour_code'],
                            'netsales_amount_hour' => $value['netsales_amount_hour'],
                            'numsales_transac_hour' => $value['numsales_transac_hour'],
                            'customer_count_hour' => $value['customer_count_hour'],
                            'totalnetsales_amount_hour' => $value['totalnetsales_amount_hour'], 
                            'totalnumber_sales_transac' => $value['totalnumber_sales_transac'], 
                            'total_customer_count_day' => $value['total_customer_count_day'],
                            'status' => $value['status'],
                            'tenant_type' => $value['tenant_type'],
                            'rental_type' => $value['rental_type'],
                            'trade_name' => $value['trade_name'], 
                            'tenant_type_code' => $value['tenant_type_code'], 
                            'date_upload' => $value['date_upload'],
                            'location_code' => $value['location_code'],
                            'txtfile_name' => $value['txtfile_name'],
                            'approved_by'   => $approved_by
      
                            ); 

                            if($this->tsms_model->check_hourly_sales_record($check['checkboxes'][$i])){

                                $InsertData = $this->_DB2->insert('confirmed_hourly_sales', $data, $check['checkboxes'][$i]);

                            }else{
                                $msg['msg']='Data Not Checked';
                                echo json_encode($msg);
                            }
                        }   

                    }

                    if($InsertData){

                        $msg['msg']='Success';
                        echo json_encode($msg);
                    }else{
                        $msh['msg']='Error';
                        echo json_encode($msg);
                    }
                    
                }
                
            } else{
                $msg['msg']='No File';
                echo json_encode($msg);
            }

    }

    public function update_disapprove_hourly()
    {
        $txtfile_name = $this->uri->segment(3);
        $data = array('status' => 'Confirmed');


                $result = $this->tsms_model->approve_hourly_sales2($data, $txtfile_name, 'tenant_hourly_sales');
                $checked = $this->tsms_model->approve_hourly_sales2($data, $txtfile_name, 'confirmed_hourly_sales');
                $done = $this->tsms_model->approve_hourly_sales2($data, $txtfile_name, 'disapproved_data_hourly');

                if($result && $checked){
                    
                    $this->session->set_flashdata('message', 'Updated');
                    redirect('cntrl_tsms/disapproved_hourly_sales/');
                }else{
                    $this->session->set_flashdata('message', 'Already Checked');
                    redirect('cntrl_tsms/disapproved_hourly_sales/');
                    }

    }

    public function update_disapprove_daily()
    {
        $transac_date = $this->uri->segment(3);
        $data = array('status' => 'Confirmed');


                $result = $this->tsms_model->approve_daily_sales2($data, $transac_date, 'tenant_daily_sales');
                $checked = $this->tsms_model->approve_daily_sales2($data, $transac_date, 'confirmed_daily_sales');
                $done = $this->tsms_model->approve_daily_sales2($data, $transac_date, 'disapproved_data_daily');

                if($result && $checked){
                    
                    $this->session->set_flashdata('message', 'Updated');
                    redirect('cntrl_tsms/disapproved_daily_sales/');
                }else{
                    $this->session->set_flashdata('message', 'Already Checked');
                    redirect('cntrl_tsms/disapproved_daily_sales/');
                    }

    }

    public function approve_hourly_sales()
    {

        $data = array('status' => 'Confirmed');

        if(isset($_POST['submit'])){

            if(!empty($_POST['checkboxes'])) {

                $flag = false;

                foreach($_POST['checkboxes'] as $selected) {

                    if(!$result = $this->tsms_model->update($data, $selected, 'tenant_hourly_sales') 
                        && $result = $this->tsms_model->update($data, $selected, 'confirmed_hourly_sales')){
                        $flag = true;
                        break;
                     }
                 }

                    if(!$flag){

                        $this->session->set_flashdata('message', 'Updated');
                        redirect('cntrl_tsms/for_approvement_hourly/');
                    } else
                        {
                            $this->session->set_flashdata('message', 'Already Checked');
                            redirect('cntrl_tsms/for_approvement_hourly/');
                        }
                
            } else{
                $this->session->set_flashdata('message', 'No File');
                redirect('cntrl_tsms/for_approvement_hourly/');
            }

        }

    }

    public function approve_pending_items2()
    {
        $txtfile_name = $this->uri->segment(3);
        $data = array('status' => 'Confirmed');


                $result = $this->tsms_model->approve_hourly_sales2($data, $txtfile_name, 'tenant_hourly_sales');
                $checked = $this->tsms_model->approve_hourly_sales2($data, $txtfile_name, 'confirmed_hourly_sales');

                if($result && $checked){
                    
                    $this->session->set_flashdata('message', 'Updated');
                    redirect('cntrl_tsms/for_approvement_hourly/');
                }else{
                    $this->session->set_flashdata('message', 'Already Checked');
                    redirect('cntrl_tsms/for_approvement_hourly/');
                    }
                

    }

    public function disapprove_pending_items()
    {
        $txtfile_name = $this->uri->segment(3);
        $data = array('status' => 'To be reviewed');
        $disapproved_by = $this->session->userdata('name'); 


            $checked = $this->tsms_model->disapprove_hourly_sales($data, $txtfile_name, 'tenant_hourly_sales');
            $checked1 = $this->tsms_model->disapprove_hourly_sales($data, $txtfile_name, 'confirmed_hourly_sales');
            $result = $this->tsms_model->check_pending_hourly_sales($txtfile_name);


                    if($checked && $checked1){

                            $flag = false;

                                foreach ($result as $value) 
                                        {
                                            $data = array(
                                            'id' => $value['id'],
                                            'tenant_code' => $value['tenant_code'],
                                            'pos_num' => $value['pos_num'], 
                                            'transac_date' => $value['transac_date'], 
                                            'hour_code' => $value['hour_code'],
                                            'netsales_amount_hour' => $value['netsales_amount_hour'],
                                            'numsales_transac_hour' => $value['numsales_transac_hour'],
                                            'customer_count_hour' => $value['customer_count_hour'],
                                            'totalnetsales_amount_hour' => $value['totalnetsales_amount_hour'], 
                                            'totalnumber_sales_transac' => $value['totalnumber_sales_transac'], 
                                            'total_customer_count_day' => $value['total_customer_count_day'],
                                            'status' => $value['status'],
                                            'tenant_type' => $value['tenant_type'],
                                            'rental_type' => $value['rental_type'],
                                            'trade_name' => $value['trade_name'], 
                                            'tenant_type_code' => $value['tenant_type_code'], 
                                            'date_upload' => $value['date_upload'],
                                            'prospect_id' => $value['prospect_id'],
                                            'txtfile_name' => $value['txtfile_name'],
                                            'disapproved_by'   => $disapproved_by
                      
                                            ); 

                                                $this->_DB2->insert('disapproved_data_hourly', $data, $txtfile_name);           

                                        }  
                        
                        $this->session->set_flashdata('message', 'Updated');
                        redirect('cntrl_tsms/for_approvement_hourly/');
                    }else{
                        $this->session->set_flashdata('message', 'Already Checked');
                        redirect('cntrl_tsms/for_approvement_hourly/');
                    }
                

    }

    public function disapprove_pending_items2()
    {
        $id = $this->uri->segment(3);
        $data = array('status' => 'To be reviewed');
        $disapproved_by = $this->session->userdata('name'); 


            $checked = $this->tsms_model->disapprove_daily_sales($data, $id, 'tenant_daily_sales');
            $checked1 = $this->tsms_model->disapprove_daily_sales($data, $id, 'confirmed_daily_sales');
            $result = $this->tsms_model->check_pending_daily_sales($id);

                
                    if($checked && $checked1){

                            $flag = false;

                                foreach ($result as $value) 
                                        {
                                            $data = array(
                                            'id' => $value['id'],
                                            'tenant_code' => $value['tenant_code'],
                                            'pos_num' => $value['pos_num'], 
                                            'transac_date' => $value['transac_date'], 
                                            'old_acctotal' => $value['old_acctotal'],
                                            'new_acctotal' => $value['new_acctotal'],
                                            'total_gross_sales' => $value['total_gross_sales'],
                                            'total_nontax_sales' => $value['total_nontax_sales'],
                                            'total_sc_discounts' => $value['total_sc_discounts'], 
                                            'total_pwd_discounts' => $value['total_pwd_discounts'], 
                                            'other_discounts' => $value['other_discounts'],
                                            'total_refund_amount' => $value['total_refund_amount'],
                                            'total_taxvat' => $value['total_taxvat'],
                                            'total_other_charges' => $value['total_other_charges'],
                                            'total_service_charge' => $value['total_service_charge'],
                                            'total_net_sales' => $value['total_net_sales'], 
                                            'total_cash_sales' => $value['total_cash_sales'], 
                                            'total_charge_sales' => $value['total_charge_sales'],
                                            'total_gcother_values' => $value['total_gcother_values'],
                                            'total_void_amount' => $value['total_void_amount'],
                                            'total_customer_count' => $value['total_customer_count'],
                                            'control_num' => $value['control_num'], 
                                            'total_sales_transaction' => $value['total_sales_transaction'], 
                                            'sales_type' => $value['sales_type'],
                                            'total_netsales_amount' => $value['total_netsales_amount'],
                                            'status' => $value['status'],
                                            'tenant_type' => $value['tenant_type'],
                                            'rental_type' => $value['rental_type'],
                                            'trade_name' => $value['trade_name'], 
                                            'tenant_type_code' => $value['tenant_type_code'], 
                                            'date_upload' => $value['date_upload'],
                                            'prospect_id' => $value['prospect_id'],
                                            'txtfile_name' => $value['txtfile_name'],
                                            'disapproved_by'   => $disapproved_by
                      
                                            ); 

                                                $this->_DB2->insert('disapproved_data_daily', $data, $id);           

                                        }  
                        
                        $this->session->set_flashdata('message', 'Updated');
                        redirect('cntrl_tsms/for_approvement/');
                    }else{
                        $this->session->set_flashdata('message', 'Already Checked');
                        redirect('cntrl_tsms/for_approvement_hourly/');
                    }
                

    }

    public function match_hourly_daily($transac_date, $trade_name, $location_code ="")
    {
        //$transac_date = $this->uri->segment(3);
       // $trade_name = str_replace("%20"," ", $this->uri->segment(4));

        $transac_date       = urldecode($transac_date);
        $trade_name         = urldecode($trade_name);
        $location_code      = urldecode($location_code);

        $result = $this->tsms_model->match_sales($transac_date, $trade_name, $location_code)[0];

       JSONResponse($result);
    }

    public function view_hourly_sales()
    {   

        $this->form_validation->set_rules('date_upload', 'Date Upload', 'required');
        $this->form_validation->set_rules('transac_date', 'Transaction Date', 'required');
        $this->form_validation->set_rules('tenant_code', 'Tenant Code', 'required');
        $this->form_validation->set_rules('pos_num', 'POS Number', 'required');

        if($this->form_validation->run() === FALSE)
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);


        $date_upload        = $this->sanitize($this->input->post('date_upload'));
        $transac_date       = $this->sanitize($this->input->post('transac_date'));
        $tenant_code        = $this->sanitize($this->input->post('tenant_code'));
        $pos_num            = $this->sanitize($this->input->post('pos_num'));


        $result = $this->tsms_model->view_hourly_sales($transac_date,$tenant_code, $date_upload, $pos_num);

        JSONResponse($result);
    }

    public function view_unhourly_sales()
    {
        $transac_date = $this->uri->segment(3);
        $trade_name = str_replace("%20"," ", $this->uri->segment(4));

        $result = $this->tsms_model->view_hourly_sales($transac_date, $tenant_code, $date_upload, $pos_num);

        JSONResponse($result);


    }

    public function view_disapprove_data_hourly()
    {
        $transac_date = $this->uri->segment(3);
        $trade_name = str_replace("%20"," ", $this->uri->segment(4));

        $result = $this->tsms_model->view_disapprove_data_hourly($transac_date, $trade_name);

        echo json_encode($result);


    }

    public function view_disapprove_data_daily()
    {
        $id = $this->uri->segment(3);

        $result = $this->tsms_model->view_disapprove_data_daily($id);

        echo json_encode($result);


    }

    public function delete_hourly_sales_record($tran_date, $tenant_code){

        $tran_date      = urldecode($tran_date);
        $tenant_code    = urldecode($tenant_code);


        $this->form_validation->set_rules('date_upload', 'Date Upload', 'required');
        $this->form_validation->set_rules('pos_num', 'POS Number', 'required');

        if($this->form_validation->run() === FALSE)
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);


        $date_upload    = $this->sanitize($this->input->post('date_upload'));
        $pos_num        = $this->sanitize($this->input->post('pos_num'));


        $store = $this->session->userdata('store_code');
        if(stripos($tenant_code, $store) === false && !empty($store))
            JSONResponse(['type'=>'warning', 'msg'=>'Hourly Sale belongs from different store. Operation not allowed!']);



        $affect_rows  = $this->tsms_model->delete_hourly_sales_record($tran_date, $tenant_code, $date_upload, $pos_num);

        if($affect_rows > 0)
            JSONResponse(['type'=>'success', 'msg'=> 'Hourly Sales has been deleted.']);

        JSONResponse(['type'=>'warning', 'msg' => 'Hourly Sales not found!']);
    }

    public function delete_hourly_by_date()
    {
        

            $transac_date_delete = $this->uri->segment(3);

            $flag = false;

            if(!$this->tsms_model->delete_hourly_by_date('tenant_hourly_sales', 'transac_date', $transac_date_delete)){
                $flag = true;
                break;
            }
                if(!$flag){
                $this->session->set_flashdata('message','Deleted');
                redirect('cntrl_tsms/tenant_hourly_sales');
            
            }else{
                $this->session->set_flashdata('message', 'Error');
                redirect('cntrl_tsms/tenant_hourly_sales/');
            }
            
    }

    public function delete_unhourly_by_date()
    {
       

            $transac_date_delete = $this->uri->segment(3);

            if($this->tsms_model->delete('tenant_hourly_sales', 'transac_date', $transac_date_delete)){

                $this->session->set_flashdata('message','Deleted');
                redirect('cntrl_tsms/unmatched_hourly_sales');
            
            }else{
                $this->session->set_flashdata('message', 'Error');
                redirect('cntrl_tsms/unmatched_hourly_sales/');
            }
            
    }

    public function delete_disapprove_hourly()
    {
       

            $txtfile_name = $this->uri->segment(3);

            $flag = false;

            if(!$this->tsms_model->delete_disapprove_hourly('disapproved_data_hourly', 'txtfile_name', $txtfile_name)){
                $flag = true;
                break;
            }
                if(!$flag){
                $this->session->set_flashdata('message','Deleted');
                redirect('cntrl_tsms/disapproved_hourly_sales');
            
            }else{
                $this->session->set_flashdata('message', 'Error');
                redirect('cntrl_tsms/disapproved_hourly_sales/');
            }
            
    }

    public function delete_disapprove_daily()
    {
       

            $id = $this->uri->segment(3);

            $flag = false;

            if(!$this->tsms_model->delete_disapprove_daily('disapproved_data_daily', 'id', $id)){
                $flag = true;
                break;
            }
                if(!$flag){
                $this->session->set_flashdata('message','Deleted');
                redirect('cntrl_tsms/disapproved_daily_sales');
            
            }else{
                $this->session->set_flashdata('message', 'Error');
                redirect('cntrl_tsms/disapproved_daily_sales/');
            }
            
    }

    public function filter_sales_yearly()
    {
        $this->form_validation->set_rules('tenant_list', 'Tenant Term', 'required');
        $this->form_validation->set_rules('location_code', 'Location Code', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required|callback_date_check');
        $this->form_validation->set_rules('trade_name', 'Trade Name', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);
        }


        
        $tenant_list    = $this->input->post('tenant_list');
        $year           = $this->input->post('year');
        $location_code  = $this->input->post('location_code');
        $trade_name     = $this->input->post('trade_name');
       
        $result = $this->tsms_model->filter_sales_yearly($tenant_list,$trade_name,$year, $location_code);

        JSONResponse($result);

    }


    public function save_computed_yearly_sale(){

        if($_SERVER["REQUEST_METHOD"] != 'POST')
            JSONResponse(["type"=>"warning", "msg"=>"Invalid Request!"]);

        $this->form_validation->set_rules('tenant_list', 'Tenant Term', 'required');
        $this->form_validation->set_rules('location_code', 'Location Code', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required|callback_date_check');
        $this->form_validation->set_rules('trade_name', 'Trade Name', 'required');

        if ($this->form_validation->run() === FALSE)
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);
       


        $tenant_list    = $this->input->post('tenant_list');
        $year           = $this->input->post('year');
        $location_code  = $this->input->post('location_code');
        $trade_name     = $this->input->post('trade_name');

       
        $monthly_sales = $this->tsms_model->filter_sales_yearly($tenant_list,$trade_name,$year, $location_code);


        if(empty($monthly_sales))
            JSONResponse(["type"=>"warning", "msg"=>"No monthly sales record found!"]);


        $old_acctotal                   =0;
        $new_acctotal                   =0;
        $total_gross_sales              =0;
        $total_nontax_sales             =0;
        $total_sc_discounts             =0;
        $total_pwd_discounts            =0;
        $total_discounts_w_approval     =0;
        $total_discounts_wo_approval    =0;
        $other_discounts                =0;
        $total_refund_amount            =0;
        $total_taxvat                   =0;
        $total_other_charges            =0;
        $total_service_charge           =0;
        $total_net_sales                =0;
        $total_cash_sales               =0;
        $total_charge_sales             =0;
        $total_gcother_values           =0;
        $total_void_amount              =0;
        $total_customer_count           =0;
        $total_sales_transaction        =0;
        $total_netsales_amount          =0;


            
        $tenant_code          = $monthly_sales[0]["tenant_code"];
        $pos_num              = $monthly_sales[0]["pos_num"];
        $control_num          = $monthly_sales[0]["control_num"];
        $sales_type           = $monthly_sales[0]["sales_type"];
        $tenant_type          = $monthly_sales[0]["tenant_type"];
        $rental_type          = $monthly_sales[0]["rental_type"];
        $trade_name           = $monthly_sales[0]["trade_name"];
        $location_code        = $monthly_sales[0]["location_code"];
        $tenant_type_code     = $monthly_sales[0]["tenant_type_code"];
        $date_end             = $monthly_sales[0]["date_end"];

        

        foreach ($monthly_sales as  $m_sale) {


            $old_acctotal                       += (float)$m_sale["old_acctotal"];
            $new_acctotal                       += (float)$m_sale["new_acctotal"];
            $total_gross_sales                  += (float)$m_sale["total_gross_sales"];
            $total_nontax_sales                 += (float)$m_sale["total_nontax_sales"];
            $total_sc_discounts                 += (float)$m_sale["total_sc_discounts"];
            $total_pwd_discounts                += (float)$m_sale["total_pwd_discounts"];
            $other_discounts                    += (float)$m_sale["other_discounts"];
            $total_refund_amount                += (float)$m_sale["total_refund_amount"];
            $total_taxvat                       += (float)$m_sale["total_taxvat"];
            $total_other_charges                += (float)$m_sale["total_other_charges"];
            $total_service_charge               += (float)$m_sale["total_service_charge"];
            $total_net_sales                    += (float)$m_sale["total_net_sales"];
            $total_cash_sales                   += (float)$m_sale["total_cash_sales"];
            $total_charge_sales                 += (float)$m_sale["total_charge_sales"];
            $total_gcother_values               += (float)$m_sale["total_gcother_values"];
            $total_void_amount                  += (float)$m_sale["total_void_amount"];
            $total_discounts_w_approval         += (float)$m_sale["total_discounts_w_approval"];
            $total_discounts_wo_approval        += (float)$m_sale["total_discounts_wo_approval"];
            $total_customer_count               += (float)$m_sale["total_customer_count"];
            $total_sales_transaction            += (float)$m_sale["total_sales_transaction"];
            $total_netsales_amount              += (float)$m_sale["total_netsales_amount"];
        }



        $tys_data = array(
            'trade_name'                        =>          $trade_name,
            'tenant_type'                       =>          $tenant_type,
            'rental_type'                       =>          $rental_type,
            'old_acctotal'                      =>          $old_acctotal,
            'new_acctotal'                      =>          $new_acctotal,
            'total_gross_sales'                 =>          $total_gross_sales,
            'total_nontax_sales'                =>          $total_nontax_sales,
            'total_sc_discounts'                =>          $total_sc_discounts,
            'total_pwd_discounts'               =>          $total_pwd_discounts,
            'total_discounts_w_approval'        =>          $total_discounts_w_approval,
            'total_discounts_wo_approval'       =>          $total_discounts_wo_approval,
            'other_discounts'                   =>          $other_discounts,
            'total_refund_amount'               =>          $total_refund_amount,
            'total_taxvat'                      =>          $total_taxvat,
            'total_other_charges'               =>          $total_other_charges,
            'total_service_charge'              =>          $total_service_charge,
            'total_net_sales'                   =>          $total_net_sales,
            'total_cash_sales'                  =>          $total_cash_sales,
            'total_charge_sales'                =>          $total_charge_sales,
            'total_gcother_values'              =>          $total_gcother_values,
            'total_void_amount'                 =>          $total_void_amount,
            'total_customer_count'              =>          $total_customer_count,
            'total_sales_transaction'           =>          $total_sales_transaction,
            'total_netsales_amount'             =>          $total_netsales_amount,
            'control_num'                       =>          $control_num,
            'sales_type'                        =>          $sales_type,
            'pos_num'                           =>          $pos_num,
            'tenant_type_code'                  =>          $tenant_type_code,
            'tenant_code'                       =>          $tenant_code,
            'location_code'                     =>          $location_code,
            'year'                              =>          $year
        );

       

        if($this->tsms_model->verify_yearly_sale($tenant_list,$trade_name,$year, $location_code))
            JSONResponse(["type"=>"warning", "msg"=>"Calculated Yearly Sale already exists!"]);

        $this->_DB2->insert('tenant_yearly_sales', $tys_data);
        JSONResponse(["type"=>"success", "msg"=>"Tenat Yearly Sale succesfully saved!"]);
    }

    function date_check($str){
        if(in_array($str, getValidYears())){
            return TRUE;
        }

        $this->form_validation->set_message('date_check', "The $str on {field} field is not a valid value.");
            return FALSE;
    }


    public function save_yearly_sales(){

            
        $data1 = explode("_", str_replace("%20"," ", $this->uri->segment(3)));
        $tenant_list = $data1[0];
        $year = $data1[1];

        $trade_name = str_replace("%20"," ", $this->uri->segment(4));

        $trade_name = $this->input->post('trade_name');
        $tenant_type = $this->input->post('tenant_type');
        $rental_type = $this->input->post('rental_type');
        $old_acctotal = str_replace(',', '', $this->input->post('old_acctotal'));
        $new_acctotal = str_replace(',', '', $this->input->post('new_acctotal'));
        $total_gross_sales = str_replace(',', '', $this->input->post('total_gross_sales'));
        $total_nontax_sales = str_replace(',', '', $this->input->post('total_nontax_sales'));
        $total_sc_discounts = str_replace(',', '', $this->input->post('total_sc_discounts'));
        $total_pwd_discounts = str_replace(',', '', $this->input->post('total_pwd_discounts'));
        $total_discounts_w_approval = str_replace(',', '', $this->input->post('total_discounts_w_approval'));
        $total_discounts_wo_approval = str_replace(',', '', $this->input->post('total_discounts_wo_approval'));
        $other_discounts = str_replace(',', '', $this->input->post('other_discounts'));
        $total_refund_amount = str_replace(',', '', $this->input->post('total_refund_amount'));
        $total_taxvat = str_replace(',', '', $this->input->post('total_taxvat'));
        $total_other_charges = str_replace(',', '', $this->input->post('total_other_charges'));
        $total_service_charge = str_replace(',', '', $this->input->post('total_service_charge'));
        $total_net_sales = str_replace(',', '', $this->input->post('total_net_sales'));
        $total_cash_sales = str_replace(',', '', $this->input->post('total_cash_sales'));
        $total_charge_sales = str_replace(',', '', $this->input->post('total_charge_sales'));
        $total_gcother_values = str_replace(',', '', $this->input->post('total_gcother_values'));
        $total_void_amount = str_replace(',', '', $this->input->post('total_void_amount'));
        $total_customer_count = $this->input->post('total_customer_count');
        $total_sales_transaction = $this->input->post('total_sales_transaction');
        $total_netsales_amount = str_replace(',', '', $this->input->post('total_netsales_amount'));
        $control_num = $this->input->post('control_num');
        $sales_type = $this->input->post('sales_type');
        $pos_num = $this->input->post('pos_num');
        $tenant_type_code = $this->input->post('tenant_type_code');
        $tenant_code = $this->input->post('tenant_code');
        $location_code = $this->input->post('location_code');


        $data = array(

            'trade_name'                        =>          $trade_name,
            'tenant_type'                       =>          $tenant_type,
            'rental_type'                       =>          $rental_type,
            'old_acctotal'                      =>          $old_acctotal,
            'new_acctotal'                      =>          $new_acctotal,
            'total_gross_sales'                 =>          $total_gross_sales,
            'total_nontax_sales'                =>          $total_nontax_sales,
            'total_sc_discounts'                =>          $total_sc_discounts,
            'total_pwd_discounts'               =>          $total_pwd_discounts,
            'total_discounts_w_approval'        =>          $total_discounts_w_approval,
            'total_discounts_wo_approval'       =>          $total_discounts_wo_approval,
            'other_discounts'                   =>          $other_discounts,
            'total_refund_amount'               =>          $total_refund_amount,
            'total_taxvat'                      =>          $total_taxvat,
            'total_other_charges'               =>          $total_other_charges,
            'total_service_charge'              =>          $total_service_charge,
            'total_net_sales'                   =>          $total_net_sales,
            'total_cash_sales'                  =>          $total_cash_sales,
            'total_charge_sales'                =>          $total_charge_sales,
            'total_gcother_values'              =>          $total_gcother_values,
            'total_void_amount'                 =>          $total_void_amount,
            'total_customer_count'              =>          $total_customer_count,
            'total_sales_transaction'           =>          $total_sales_transaction,
            'total_netsales_amount'             =>          $total_netsales_amount,
            'control_num'                       =>          $control_num,
            'sales_type'                        =>          $sales_type,
            'pos_num'                           =>          $pos_num,
            'tenant_type_code'                  =>          $tenant_type_code,
            'tenant_code'                       =>          $tenant_code,
            'location_code'                     =>          $location_code,
            'year'                              =>          $year
        );



        if($result = $this->tsms_model->save_yearly_sales($tenant_list,$trade_name,$year))
        {   
            $this->session->set_flashdata('message', 'Already Exist');
            redirect('cntrl_tsms/compute_yearly_sales/');

        }else{

            $this->_DB2->insert('tenant_yearly_sales', $data);
            $this->session->set_flashdata('message', 'Added');
            redirect('cntrl_tsms/compute_yearly_sales/'); 
        } 
                                     
        
    }
    
    public function yearly_comparison($tenant, $year, $year1){

        $tenant     = urldecode($tenant); 
        $year       = urldecode($year);
        $year1      = urldecode($year1);

        $sales = $this->tsms_model->yearly_sales($tenant, $year, $year1);

        $data = [];
        foreach ($sales as $sale) {
            $sale = (object) $sale;
            
            $key = array_search($sale->trade_name, array_column($data, 'trade_name'));

            if($key === false){
                $data[] = [
                    'trade_name'    => $sale->trade_name,
                    'year'          => $sale->year == $year ?  (float) $sale->total_netsales_amount : 0,
                    'year1'         => $sale->year == $year1 ? (float) $sale->total_netsales_amount : 0
                ];
            }else{
                $y = $sale->year == $year ? 'year' : 'year1';
                $data[$key][$y]=  (float) $sale->total_netsales_amount;
            }
        }


        foreach ($data as $key => $dt) {
            $dt = (object) $dt;

            if($dt->year == 0){
                $data[$key]['vs'] =   'N/A';
            } else{
                $gain               = round($dt->year1 - $dt->year , 2);
                $vs                 = round($gain/$dt->year * 100, 2);
                $data[$key]['vs']   = ($vs < 0 ? '-': '+')."(".abs($vs)."%)";

            }
        }        

        JSONResponse($data);
    }

    public function input_sales_data(){

        $this->form_validation->set_rules('tenant_list', 'Tenant Term', 'required');
        $this->form_validation->set_rules('trade_name', 'Trade Name', 'required|callback_trade_name_check');
        $this->form_validation->set_rules('rental_type', 'Rental Type', 'required|callback_rental_type_check');
        $this->form_validation->set_rules('location_code', 'Location Code', 'required|callback_location_check');
        $this->form_validation->set_rules('total_gross_sales', 'Total Gross Sales', 'required|numeric');
        $this->form_validation->set_rules('total_netsales_amount', 'Total Net Sales', 'required|numeric');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_check_date');

        if ($this->form_validation->run() === FALSE)
        {
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);
        }

        $tenant_type            = $this->input->post('tenant_list');
        $trade_name             = $this->input->post('trade_name');
        $rental_type            = $this->input->post('rental_type');
        $location_code          = $this->input->post('location_code');
        $total_gross_sales      = $this->input->post('total_gross_sales');
        $total_netsales_amount  = $this->input->post('total_netsales_amount');
        $date                   = $this->input->post('date');


        $data = array(
            'tenant_type'               => $tenant_type,
            'trade_name'                => $trade_name,
            'rental_type'               => $rental_type,
            'location_code'             => $location_code,
            'total_gross_sales'         => $total_gross_sales,
            'total_netsales_amount'     => $total_netsales_amount,
            'date'                      => $date
        );

        if($this->tsms_model->check_input_sales_data($trade_name, $tenant_type, $total_gross_sales, $total_netsales_amount, $date))
        {
            JSONResponse(['type'=>'warning', 'msg'=>'Data already exists!']);

        }else{
            $this->_DB2->insert('input_sales_data', $data);
            JSONResponse(['type'=>'success', 'msg'=>'Sales Data succesfully added.']);
        }
    }

    function rental_type_check($str){
        $location_code = $this->input->post('location_code');
        $rental_type = $this->tsms_model->get_rental_type($location_code)[0]['rental_type'];

        if($str == $rental_type){
            return TRUE;
        }

        $this->form_validation->set_message('rentalTypeCheck', "'$str' on {field} field is not a valid value.");
        return FALSE;
    }

    function trade_name_check($str){
        $flag  = $this->input->post('tenant_list');

        $tenants  = $this->tsms_model->get_fixed_tenants($flag);

        $tenants =  array_map(function($tenant) {
            return $tenant['trade_name'];
        }, $tenants);

        if(in_array($str, $tenants)){
            return TRUE;
        }

        $this->form_validation->set_message('trade_name_check', "'$str' on {field} field is not a valid value.");
        return FALSE;
    }

    function location_check($str){
        $trade_name = $this->input->post('trade_name');
        $locations = $this->tsms_model->get_location_code($trade_name);

        $locations =  array_map(function($tenant) {
            return $tenant['location_code'];
        }, $locations);

        if(in_array($str, $locations)){
            return TRUE;
        }

        $this->form_validation->set_message('location_check', "'$str' on {field} field is not a valid value.");
        return FALSE;
    }

    function check_date($str){

        $date = explode('-', $str);

        $year   = isset($date[0]) ? $date[0] : null;
        $month  = isset($date[1]) ? $date[1] : null;
        $day    = isset($date[2]) ? $date[2] : 1;


        if(checkdate($month, $day, $year)){
            return TRUE;
        }

        $this->form_validation->set_message('check_date', "'$str' on {field} field is not a valid date.");
        return FALSE;

    }



    public function get_input_sales_data(){
        
        if($this->session->userdata('is_logged_in'))
        {
            $result = $this->tsms_model->get_input_sales_data();

            echo json_encode($result);
        }
    }

    public function get_variance(){

        $result = $this->tsms_model->get_variance();
        JSONResponse($result);
    }

    public function update_variance($id){
       
        $id = urldecode($id);

        $this->form_validation->set_rules('variance', 'Variace', 'required|numeric');


        if ($this->form_validation->run() === FALSE)
        {
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);
        }

        $trade_name         = $this->sanitize($this->input->post('trade_name'));
        $tenant_type        = $this->sanitize($this->input->post('tenant_type'));
        $variance           = $this->sanitize($this->input->post('variance'));

        $data = array(
            //'trade_name'     => $trade_name,
            //'tenant_type'    => $tenant_type,
            'variance'       => $variance,
            'status'         => 'reviewed' 
        );

        
        if($this->tsms_model->update($data, $id, 'variance_report'))
        {
           JSONResponse(["type"=>"success", "msg"=>'Variace report has been updated.']);
        }else
        {
           JSONResponse(["type"=>"warning", "msg"=>'Error updating variance report.']);
        }

    }

    public function delete_variance($id)
    {   
        $id = urldecode($id);


        if($this->tsms_model->delete('variance_report', 'id', $id)){
            JSONResponse(["type"=>"success", "msg"=>'Variace report has been deleted.']);
        }

        JSONResponse(["type"=>"warning", "msg"=>'Error deleting variance report.']);
    }

    public function delete_upload_status()
    {
        if(!$this->session->userdata('is_logged_in'))
            redirect('cntrl_tsms/');

        $id_to_delete = $this->uri->segment(3);

        if($this->tsms_model->delete('upload_status', 'id', $id_to_delete)){
            JSONResponse(['type'=>'success', 'msg'=>'Record has been deleted']);
        }
        
        JSONResponse(['type'=>'warning', 'msg'=>'Error deleting record!']);

    }

    public function get_upload_data()
    {
        $result = $this->tsms_model->get_upload_data();
        JSONResponse($result);
    }

    public function getData($table_name, $id){
        $data = $this->tsms_model->getData($table_name, ["id"=> $id]);
        var_dump($data);
    }


    public function get_yearly_sales($tenant_type, $trade_name, $tenant_code){

        $tenant_type    = urldecode($tenant_type);
        $trade_name     = urldecode($trade_name);
        $tenant_code    = urldecode($tenant_code);


        $result = $this->tsms_model->get_yearly_sales($tenant_type, $trade_name, $tenant_code);

        return JSONResponse($result);


    }

    public function delete_yearly_sale($id){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $id = urldecode($id);
        $result = $this->tsms_model->delete('tenant_yearly_sales', "id", $id);

        if($result){
            JSONResponse(['type'=> 'success', 'msg'=>'Yearly Sale has been deleted.']);
        } 

        JSONResponse(['type'=> 'warning', 'msg'=>'Error deleting Yearly Sale record!']);
    }

    public function get_monthly_sales($tenant_type, $trade_name, $tenant_code, $year){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }


        $tenant_type    = urldecode($tenant_type);
        $trade_name     = urldecode($trade_name);
        $tenant_code    = urldecode($tenant_code);
        $year           = urldecode($year);

        $year = $year == 'All' ? '' : $year;

        JSONResponse($this->tsms_model->get_monthly_sales($tenant_type, $trade_name, $tenant_code, $year));
    }

    public function delete_monthly_sale($id){
        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }


        $id = urldecode($id);
        $result = $this->tsms_model->delete('total_monthly_sales', "id", $id);

        if($result){
            JSONResponse(['type'=> 'success', 'msg'=>'Monthly Sale has been deleted.']);
        } 

        JSONResponse(['type'=> 'warning', 'msg'=>'Error deleting Monthly Sale record!']);
    }

    public function get_daily_sales_record($tenant_type, $trade_name, $tenant_code, $date){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $tenant_type    = urldecode($tenant_type);
        $trade_name     = urldecode($trade_name);
        $tenant_code    = urldecode($tenant_code);
        $date           = urldecode($date);

        JSONResponse($this->tsms_model->get_daily_sales_record($tenant_type, $trade_name, $tenant_code, $date));
    }

    public function delete_confirmed_daily_sale($id)
    {   
        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $id = urldecode($id);

        if($this->tsms_model->delete('confirmed_daily_sales', 'id', $id)){
            JSONResponse(['type'=>'success', 'msg'=>'Confirmed daily sale has been deleted!']);
        }else{
            JSONResponse(['type'=>'warning', 'msg'=>'Error deleting confirmed daily sale record!']);
        }
    }

    public function get_hourly_sales_record($tenant_type, $trade_name, $tenant_code, $date){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $tenant_type    = urldecode($tenant_type);
        $trade_name     = urldecode($trade_name);
        $tenant_code    = urldecode($tenant_code);
        $date           = urldecode($date);

        JSONResponse($this->tsms_model->get_hourly_sales_record($tenant_type, $trade_name, $tenant_code, $date));
    }

    public function view_confirmed_hourly_sales()
    {   
        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }


        $this->form_validation->set_rules('date_upload', 'Date Upload', 'required');
        $this->form_validation->set_rules('transac_date', 'Transaction Date', 'required');
        $this->form_validation->set_rules('tenant_code', 'Tenant Code', 'required');
        $this->form_validation->set_rules('pos_num', 'POS Number', 'required');

        if($this->form_validation->run() === FALSE)
            JSONResponse(["type"=>"warning", "msg"=>validation_errors()]);


        $date_upload        = $this->sanitize($this->input->post('date_upload'));
        $transac_date       = $this->sanitize($this->input->post('transac_date'));
        $tenant_code        = $this->sanitize($this->input->post('tenant_code'));
        $pos_num            = $this->sanitize($this->input->post('pos_num'));


        $result = $this->tsms_model->view_confirmed_hourly_sales($transac_date,$tenant_code, $pos_num);

        //$result = $this->tsms_model->view_hourly_sales($transac_date,$tenant_code, $date_upload, $pos_num);

        JSONResponse($result);
    }


    public function delete_confirmed_hourly_sales($tran_date, $tenant_code){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $tran_date      = urldecode($tran_date);
        $tenant_code    = urldecode($tenant_code);

        $affect_rows  = $this->tsms_model->delete_confirmed_hourly_sales($tran_date, $tenant_code);

        if($affect_rows > 0)
            JSONResponse(['type'=>'success', 'msg'=> 'Confirmed Hourly Sales has been deleted.']);

        JSONResponse(['type'=>'warning', 'msg' => 'Confirmed Hourly Sales not found!']);
    }

    public function get_leasing_data_records($tenant_type, $trade_name, $tenant_code){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $tenant_type    = urldecode($tenant_type);
        $trade_name     = urldecode($trade_name);
        $tenant_code    = urldecode($tenant_code);

        JSONResponse($this->tsms_model->get_leasing_data_records($tenant_type, $trade_name, $tenant_code));

    }

    public function delete_leasing_data($id){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $id = urldecode($id);

        if($this->tsms_model->delete('data_for_leasing', 'id', $id)){
            JSONResponse(['type'=>'success', 'msg'=>'Data for Leasing has been deleted!']);
        }else{
            JSONResponse(['type'=>'warning', 'msg'=>'Error deleting Data for Leasing record!']);
        }
    }


    public function delete_upload_history_data($id){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $id = urldecode($id);

        if($this->tsms_model->delete('upload_history', 'id', $id)){
            JSONResponse(['type'=>'success', 'msg'=>'Upload History record has been deleted!']);
        }else{
            JSONResponse(['type'=>'warning', 'msg'=>'Error deleting Upload History record!']);
        }
    }

    public function get_sales_data($tenant_type, $trade_name, $tenant_code){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $tenant_type    = urldecode($tenant_type);
        $trade_name     = urldecode($trade_name);
        $tenant_code    = urldecode($tenant_code);

        JSONResponse($this->tsms_model->get_sales_data($tenant_type, $trade_name, $tenant_code));
    }


    public function delete_sales_data($id){

        if($this->session->userdata('user_type') != 'Administrator'){
            return JSONResponse(['type'=> 'error', 'msg'=>'Authentication error!']);
        }

        $id = urldecode($id);

        if($this->tsms_model->delete('sales', 'id', $id)){
            JSONResponse(['type'=>'success', 'msg'=>'Sales record has been deleted!']);
        }else{
            JSONResponse(['type'=>'warning', 'msg'=>'Error deleting Sales record!']);
        }
    }


    public function test(){

        $result = $this->db->query("
            SELECT * FROM `tenant_hourly_sales`")->result_array();

        foreach($result as $res){

            $pos_num = trim($res["pos_num"]);
            $id = $res["id"];

            $this->db->query("
                UPDATE 
                    tenant_hourly_sales
                SET
                    pos_num = $pos_num
                WHERE
                    id = $id
            ");
        }

    }

    

} //end of tsms_controller

