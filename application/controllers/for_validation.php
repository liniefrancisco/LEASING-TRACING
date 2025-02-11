<?php defined('BASEPATH') OR exit('No direct script access allowed');

class For_validation extends CI_Controller {

    
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('tsms_model');
        $this->load->library('upload');
        $this->_user_group = $this->session->userdata('user_group');
        $this->_user_id = $this->session->userdata('id');
    }

      public function insert($tbl_name, $data)
    {
         $this->db->insert($tbl_name, $data);
    }


    public function restricted (){

		$this->load->view('restricted');
	}

	public function login_validation(){

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required|trim|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|md5|trim');

		if ($this->form_validation->run()){

			$data = array (
					'username' => $this->input->post('username'),
					'is_logged_in' => 1

				);
					$this->session->set_userdata($data);

				redirect('index.php/main/members');
		} else {

			$this->load->view('login');
		}

	}

	public function signup_validation(){

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email' ,'required|trim|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|trim|matches[password]');

		$this->form_validation->set_message('is_unique', "That email address already exists.");

		if ($this->form_validation->run()){
			//austinfawerz@gmail.com

			//generate a random key
			$key = md5(uniqid());

			$this->load->library('email', array('mailtype'=>'html'));
			$this->load->model('tsms_model');		

			$this->email->from('austinfawerz@gmail.com', "Austin");
			$this->email->to($this->input->post('email'));
			$this->email->subject("Confirm your account.");

			$message = "<p>	Thank you for signung up! </p>";
			$message = "<p> <a href='".base_url()."index.php/main/register_users/$key'>Click here</a>
			to confirm your account</p>";

			$this->email->message($message);

			//send an email to the users
			if ($this->tsms_model->add_temp_user($key)) {

				if ($this->email->send()){
				echo "The email has been sent!";
			} else echo "Failed. Could not send the email.";
			} else echo "problem adding to database";

			
		

			//add them to the temp_users db
			

			
		} else {
			
			$this->load->view('signup');
		}
	}

	/*public function validate_credentials(){
		$this->load->model('tsms_model');
		
		if($this->tsms_model->for_login()){

			return true;

		} else {
			$this->form_validation->set_message('validate_credentials', 'Incorrect username/password.');
			return false;
		} 
	}

	public function logout(){

		$this->session->sess_destroy();
		redirect('index.php/main/login');
	}*/






	// public function verify_username($username){

	// 	$result = $this->db->query(" SELECT id FROM add_users WHERE username ='$username'");
	// 	if ($result->num_rows()>0){
	// 		echo true;

	// 	} else {
	// 		echo false;
	// 	}
	// }

	public function verifyandupdate_username(){
		$data = explode("_", $data);
		$username = $data[0];
		$id = $data[1];

		$result = $this->db->query("SELECT id FROM add_users WHERE username ='$username' AND id <> '$id'");
		if ($result->num_rows()>0){
			echo true;
		} else {
			echo false;
		}
	}

}