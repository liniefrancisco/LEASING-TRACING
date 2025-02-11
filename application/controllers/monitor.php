<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitor extends CI_Controller {

	function __construct(){
    
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('upload','acl');


        $this->db_pms = $this->load->database('pms', TRUE);

        ini_set('max_execution_time', 600);
        
    }

    function sanitize($string){
    
        $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
        $string = trim($string);
        return $string;
    }

    

    public function monitor($id){
    	var_dump($id);
    	$prog_data = $this->session->userdata($id);;

    	var_dump($prog_data);


    }

    function send($id, $data, $event){
        $time = time() * 1000;

        echo "id: 12" . PHP_EOL;
        echo "event: time\n";
        echo "data: $time". PHP_EOL;
        echo PHP_EOL;
        ob_flush();
        flush();
    }



}
