<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	function __construct(){
    	

        parent::__construct();
        $this->load->helper(array('form', 'url', 'my'));
        $this->load->library('form_validation');
        $this->load->model('tsms_model');
        $this->load->library('upload','acl','jquery');
        $this->_DB1 = $this->load->database('cyril', TRUE);
        $this->_DB2 = $this->load->database('austin', TRUE);
		

        if (!$this->session->userdata('is_logged_in')) 
            redirect('cntrl_tsms/');

        ini_set('max_file_uploads', 1000);
    }
	
	public function upload(){
	if (isset($_POST['btn-upload'])) {

        $file = rand(1000, 100000) . "-" . $_FILES['file']['name'];
        $file_loc = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $folder = "../upload/";
        $location = $_FILES['file'];


        $new_size = $file_size / 1024; // new file size in KB
        $new_file_name = strtolower($file);
        $final_file = str_replace(' ', '-', $new_file_name); // make file name in lower case

        if (move_uploaded_file($file, $folder . $final_file)) {

            //Prepare upload data
            $upload_data = Array(
                'file'  => $final_file,
                'type'  => $file_type,
                'size'  => $new_size
            );
            //Insert into tbl_uploads
            $this->db->insert('abenson', $upload_data);

            $handle = fopen("C:/wamp/www/AGC-TSMS/upload/", "r");

            if ($handle) {
                while (($line = fgets($handle)) !== false) {

                    $lineArr = explode("\t", $line);
                    // instead assigning one by onb use php list -> http://php.net/manual/en/function.list.php
                    list($date, $tom, $pos, $num) = $lineArr;

                    $daily_data = Array(
                        'date'       => $date,
                        'tom'       => $tom,
                        'pos'     => $pos,
                        'num'       => $num
                    );
                    	var_dump($daily_data);

                    $this->db->insert('abenson', $daily_data);
                }
                fclose($handle);
            }
            //Alert success redirect to ?success
            $this->alert('successfully uploaded', 'index.php?success');
            } else {
                //Alert error
                $this->alert('error while uploading file', 'index.php?fail');
            }
        }
    }

    protected function alert($text, $location) {
        return "<script> alert('".$text."'); window.location.href='".$location."'; </script>";

    }

    public function get_pic(){

    	$date = new DateTime();
        $timeStamp = $date->getTimestamp();


    	$targetPath = getcwd() . '/upload/'; 
                        $tmpFilePath = $_FILES['file']['tmp_name'];
                        //Make sure we have a filepath
                        if ($tmpFilePath != "") 
                        {
                            //Setup our new file path
                            $filename = $timeStamp . $_FILES['file']['name'];
                            $newFilePath = $targetPath . $filename;
                            //Upload the file into the temp dir
                            move_uploaded_file($tmpFilePath, $newFilePath);

                   }
	}

	public function upload_multi_daily_sales(){
		//initialize dates
		date_default_timezone_set("Asia/Manila");

		//get form inputs value
		$inputs 	= (object) [
			'tenant_type' 		=> $this->input->post('tenant_list'),
			'rental_type' 		=> $this->input->post('rental_type'),
			'trade_name' 		=> $this->input->post('trade_name'),
			'location_code' 	=> $this->input->post('location_code'),
			'new_date'			=> date('F j, Y, g:i:s A '),
			'up_date'			=> date('Y-m-d')
		];

		$inputs->tenant_type_code = $inputs->tenant_type == 'Long Term Tenants' ? 1 : 2;
		
		//validate location code
		if(!$this->tsms_model->validate_location_code($inputs->location_code))
			JSONResponse(["type"=>"warning", "msg"=>'Invalid Location Code']);


		$files = getUploadFiles('files');
	
		if(empty($files) || empty($files[0]['name']))
			JSONResponse(["type"=>"warning", "msg"=>'Files are missing!']);

		$grouped = array_group_by($files, function($file){
			$exp_name = explode('.', $file['name']);
			unset($exp_name[0]);
			$name = implode('.', $exp_name);
			return $name;
		});


		$errors = [];

		$grouped_pairs = [];

		foreach ($grouped as $key => $files) {

			/*if(count($files) < 2){
				$errors[] = createUploadError($files[0]['name'], 'No pair found');
				continue;
			}*/

			$pairs = $this->getPairs($files, $inputs->location_code, $errors);

			if(empty($pairs->file_day) && empty($pairs->file_hour))
				continue;

			if(empty($pairs->file_day) && !empty($pairs->file_hour)) {
				$errors[] = createUploadError($pairs->file_hour['name'], 'No pair found');
				continue;
			} elseif(empty($pairs->file_hour) && !empty($pairs->file_day)) {
				$errors[] = createUploadError($pairs->file_day['name'], 'No pair found');
				continue;
			}

			$grouped_pairs[] = $pairs;
		}

		if(empty($grouped_pairs))
			JSONResponse(["type"=>"warning", "msg"=>'Error uploading sales textfiles.', 'errors'=>$errors]);


		$valid_data = [];
		foreach ($grouped_pairs as $key => $pair) {
			$data = $this->validateUploadedFiles($pair, $inputs, $errors);
			if(!empty($data))
				$valid_data[] = $data;
		}

		if(empty($valid_data))
			JSONResponse(["type"=>"warning", "msg"=>'Textfiles are invalid!', 'errors'=>$errors]);

		foreach ($valid_data as $data) {
			$success[] = $this->saveUploadedFile($data->day_lines, $data->hour_lines, $inputs, $data->day, $data->hour);
		}

		JSONResponse(["type"=>"success", "msg"=>'Uploading successfull.', 'errors'=>$errors, 'success'=>$success]);
	}


	function getPairs($files, $location_code, &$errors){
		$file_day 	= null;
		$file_hour 	= null;

		foreach ($files as $key => $file) {

			$exp_name = explode('.', $file['name']);

			if(!isset($exp_name[0]) || ($exp_name[0] != 'D' &&  $exp_name[0] != 'H')){
				$errors[] = createUploadError($file['name'], 'Invalid file');
				continue;
			}


			if(!isset($exp_name[1]) || $exp_name[1] != $location_code){
				$errors[] =  createUploadError($file['name'], 'Invalid file for this location code');
				continue;
			}

			if($exp_name[0] == 'D'){
				$file_day = $file;
			}
			elseif($exp_name[0] == 'H'){
				$file_hour = $file;
			}
			else{
				$errors[] = createUploadError($file['name'], 'Invalid file');
				continue;
			}

			
		}

		return (object) ['file_day'=>$file_day, 'file_hour'=>$file_hour];
	}

	function validateUploadedFiles($pair, $inputs, &$errors){

		$day	= (object)$pair->file_day;
		$hour 	= (object)$pair->file_hour;


		//open file and check if file can be open
    	$fday 	= fopen($day->tmp_name,'r');
    	$fhour 	= fopen($hour->tmp_name, 'r');

		if (!$fday){
			$errors[] =  createUploadError($day->name, 'Can\'t open file.');
			return;
		}

		if (!$fhour){
			$errors[] =  createUploadError($hour->name, 'Can\'t open file.');
			return;
		} 


		$file = $this->tsms_model->validate_upload_file($day->name);
		if(!empty($file)){
			$errors[] =  createUploadError($day->name, 'Text file already exists!');
			return;
		}
			
		
		$fday_lines 		= explode("\n", fread($fday, filesize($day->tmp_name)));
		$fday_lines	= array_values(array_filter($fday_lines, function($ln){
			$ln = trim($ln);
			return strlen($ln) > 0;
		}));
		$day_lines 			= array_map('trim',substr_replace($fday_lines," ",0,2));	
		$day_lines 			= str_replace('"!', "", $day_lines);


		//clean data for H file
		$fhour_lines 		= explode("\n", fread($fhour, filesize($hour->tmp_name)));
		$fhour_lines 		= array_values(array_filter($fhour_lines, function($ln){
			$ln = trim($ln);
			return strlen($ln) > 0;
		}));
		$hour_lines 		= array_map('trim',substr_replace($fhour_lines, " ",0,2));
		$day_lines 			= str_replace('"!', "", $day_lines);


		//validate day fields 
		if(count($day_lines) !== 26){
			$errors[] =  createUploadError($day->name, 'Invalid file content. Number of lines doesn\'t matched the expected value' );
			return;
		}

		//validate hour fields
		if(count($hour_lines) !== 102){
			$errors[] =  createUploadError($hour->name, 'Invalid file content. Number of lines doesn\'t matched the expected value');
			return;
		}

		//check if matched location code
		if($day_lines[0] != $inputs->location_code){
			$errors[] =  createUploadError($day->name, 'File\'s Location Code doesn\'t  mactched the selected tenant\'s location code.');
			return;
		}

		//check if matched location code
		if($hour_lines[0] != $inputs->location_code){
			$errors[] =  createUploadError($hour->name, 'File\'s Location Code doesn\'t  mactched the selected tenant\'s location code.');
			return;
		}

		//check if matched pos number
		if($day_lines[1] != $hour_lines[1]){
			$errors[] =  createUploadError($day->name, 'Doesn\'t matched with hour text file\'s POS No.');
			return;
		}

		//check day's date is valid
		if(!validDate($day_lines[2])){
			$errors[] =  createUploadError($day->name, 'Transaction date doesn\'t matched expected date format.');
			return;
		}

		//check hour's date is valid
		if(!validDate($hour_lines[2])){
			$errors[] =  createUploadError($hour->name, 'Transaction date doesn\'t matched expected date format.');
			return;
		}

		//check if matched transaction date
		if($day_lines[2] != $hour_lines[2]){
			$errors[] =  createUploadError($day->name, 'Doesn\'t matched with hour text file\'s Transaction date.');
			return;
		}

		//check if day's Total Number of Sales Transaction matches hour's
		if($day_lines[23] != $hour_lines[100]){
			$errors[] =  createUploadError($day->name, 'Doesn\'t matched with hour text file\'s Total Number of Sales Transaction.');
			return;
		}

		//check if day's Total Customer Count matches hour's
		if($day_lines[21] != $hour_lines[101]){
			$errors[] =  createUploadError($day->name, 'Doesn\'t matched with hour text file\'s Total Customer Count.');
			return;
		}


		//check if day's fields if natural number
		foreach ($day_lines as $key => $line) {
			if($key <= 2)
				continue;

			if(!isInteger($line)){
				$errors[] =  createUploadError($day->name, "Field No. ". sprintf("%02d", $key + 1). " expects integer value. Gets ".$line);
				return;
			}
		}

		//check if day's fields if natural number
		foreach ($hour_lines as $key => $line) {
			if($key <= 2)
				continue;

			if(!isInteger($line)){
				$errors[] =  createUploadError($hour->name, "Line No. ". sprintf("%02d", $key + 1). " expects  integer value. Gets ".$line);
				return;
			}
		}

		fclose($fday);
		fclose($fhour);


		return (object) ['day_lines'=>$day_lines, 'hour_lines' => $hour_lines, 'day' => $day, 'hour'=>$hour];
	}

	function saveUploadedFile($day_lines, $hour_lines, $inputs, $day, $hour){

		$this->_DB2->trans_start();

		$count= 0;
		$total_netsales_amount_hour=0;

		for ($i=3; $i < count($hour_lines)-3; $i++)
		{	
			if($i > 98)
				continue;

			$count++;
			if($count===2)
				$total_netsales_amount_hour += $hour_lines[$i];
			
			if($count===4)
				$count=0;
		}

		$variance_amount 	= $day_lines[16] - $total_netsales_amount_hour;
		$variance 			= toDecimal($variance_amount);

		$status = (float) $variance == 0 ? 'Unconfirmed' : 'Unmatched';

		$query_tds = array(										
			'tenant_code'					=>		$day_lines[0],
			'pos_num' 						=>		$day_lines[1],
			'transac_date'					=>		$day_lines[2],
			'old_acctotal'					=>		toDecimal($day_lines[3]),
			'new_acctotal'					=>		toDecimal($day_lines[4]),
			'total_gross_sales'				=>		toDecimal($day_lines[5]),
			'total_nontax_sales'			=>		toDecimal($day_lines[6]),
			'total_sc_discounts'			=>		toDecimal($day_lines[7]),
			'total_pwd_discounts'			=>		toDecimal($day_lines[8]),
			'total_discounts_w_approval'	=>		toDecimal($day_lines[9]),
			'total_discounts_wo_approval'	=>		toDecimal($day_lines[10]),
			'other_discounts'				=>		toDecimal($day_lines[11]),
			'total_refund_amount'			=>		toDecimal($day_lines[12]),
			'total_taxvat'					=>		toDecimal($day_lines[13]),
			'total_other_charges'			=>		toDecimal($day_lines[14]),
			'total_service_charge'			=>		toDecimal($day_lines[15]),
			'total_net_sales'				=>		toDecimal($day_lines[16]),
			'total_cash_sales'				=>		toDecimal($day_lines[17]),
			'total_charge_sales'			=>		toDecimal($day_lines[18]),
			'total_gcother_values'			=>		toDecimal($day_lines[19]),
			'total_void_amount'				=>		toDecimal($day_lines[20]),
			'total_customer_count'			=>		$day_lines[21],
			'control_num' 					=>		$day_lines[22],
			'total_sales_transaction'		=>		$day_lines[23],
			'sales_type'					=>		$day_lines[24],
			'total_netsales_amount' 		=>		toDecimal($day_lines[25]),
			'status'						=>		$status,
			'tenant_type'					=>		$inputs->tenant_type,
			'rental_type'					=>		$inputs->rental_type,
			'trade_name'					=>		$inputs->trade_name,
			'tenant_type_code'				=>		$inputs->tenant_type_code,
			'date_upload'					=>		$inputs->new_date,
			'location_code'					=>		$inputs->location_code,
			'txtfile_name'					=>		$day->name
		);

		//var_dump($query_tds);
				
		$this->_DB2->insert('tenant_daily_sales', $query_tds);



		//SAVE IN HOURLY TABLE



		$tenant_code 	= $hour_lines[0];
		$pos_num 		= $hour_lines[1];
		$date 			= $hour_lines[2];

		$counter = 0;

		$hc 	= "";
		$nsah 	= "";
		$nsth 	= "";
		$cch 	= "";

		$total_nsah = 0;
		$total_nsth = 0;
		$total_cch 	= 0;


		$totalnetsales_day 			= toDecimal($hour_lines[99]);
		$totalnumber_sales_transac 	= $hour_lines[100];
		$total_customer_count_day 	= $hour_lines[101];


		for ($o=3; $o < count($hour_lines)-3; $o++)
		{	
			if($o > 98)
				continue;

			$counter++;

			if($counter===1)
			{
				$hc = $hour_lines[$o];
			}
			
			if($counter===2)
			{
				$nsah 			=  toDecimal($hour_lines[$o]);
				$total_nsah 	+= (float) $nsah;
			}

			if($counter===3)
			{
				$nsth 			= $hour_lines[$o];
				$total_nsth 	+= (int) $hour_lines[$o];
			}

			if($counter===4)
			{
				$cch 		=  $hour_lines[$o];
				$total_cch 	+= (int) $hour_lines[$o];
			
				$query_ths = array(
					'tenant_code'						=>		$tenant_code,
					'pos_num'							=>		$pos_num,
					'transac_date'						=>		$date,
					'hour_code'							=>		$hc,
					'netsales_amount_hour'				=>		$nsah,
					'numsales_transac_hour'				=>		$nsth,
					'customer_count_hour'				=>		$cch,
					'totalnetsales_amount_hour'			=>		$totalnetsales_day,
					'totalnumber_sales_transac'			=>		$totalnumber_sales_transac,
					'total_customer_count_day'			=>		$total_customer_count_day,
					'status'							=>		$status,
					'tenant_type'						=>		$inputs->tenant_type,
					'rental_type'						=>		$inputs->rental_type,
					'trade_name'						=>		$inputs->trade_name,
					'tenant_type_code'					=>		$inputs->tenant_type_code,
					'date_upload'						=>		$inputs->new_date,
					'location_code'						=>		$inputs->location_code,
					'txtfile_name'						=>		$hour->name
				);

				$this->_DB2->insert('tenant_hourly_sales', $query_ths);

				//var_dump($query_ths);

				$counter=0;	 
			}
		}


		//LOG DATA TO UPLOAD STATUS TABLE

		$query_upstat = array(
			'tenant_name'			=>		$inputs->trade_name,
			'date_upload'			=>		$inputs->up_date,
			'location_code'			=>		$inputs->location_code,
			'txtfile_name'			=>		$day->name
		);

		//var_dump($query_upstat);

		$this->_DB2->insert('upload_status',$query_upstat);
				

		if((float) $variance != 0)
		{
 			$query_var_report = array(
				'trade_name'				=>		$inputs->trade_name,
				'tenant_code'				=>		$day_lines[0],
				'tenant_type'				=>		$inputs->tenant_type,
				'variance'					=>		$variance,
				'date'						=>		$day_lines[2],
				'date_upload'				=>		$inputs->new_date,
				'status'					=>		'Pending'
			);

			$this->_DB2->insert('variance_report', $query_var_report);

			//var_dump($query_var_report);
	 	}

		$this->_DB2->trans_complete();

		if($this->_DB2->trans_status() === FALSE)
		{
			$this->_DB2->trans_rollback();
			return ['file'=>$day->name, 'status'=>'error', 'description'=>'Error saving data in database.'];
		}


		if((float) $variance == 0)
			return ["file"=>$day->name, "status"=>"Matched", "description"=>'Data Match and Uploaded.'];
		
		return ["file"=>$day->name, "status"=>"Unmatched", "description"=>'Sales dont match but uploaded. View Variance Report.'];
	}
	
  
	public function upload_daily_sales()
	{	
		//check if logged in if ! redirect
		if (!$this->session->userdata('is_logged_in')) 
			redirect('admin/index');

		//initialize dates
		date_default_timezone_set("Asia/Manila");
		$new_date = date('F j, Y, g:i:s A ');
		$up_date = date('Y-m-d');

		
		$tenant_type 	= 	$this->input->post('tenant_list');
		$rental_type 	= 	$this->input->post('rental_type');
		$trade_name 	= 	$this->input->post('trade_name');
		$location_code 	= 	$this->input->post('location_code');

		if($tenant_type == 'Long Term Tenants'){
			$tenant_type_code = '1';
		}else{
			$tenant_type_code = '2';
		}

		if (!isset($_FILES["file"]) || !isset($_FILES["file1"]) || empty($_FILES["file"]["name"][0]) || empty($_FILES["file1"]["name"][0]))
			JSONResponse(["type"=>"warning", "msg"=>'Missing File']);


		//get data name
        $file_day_name = $_FILES["file"]["name"][0];
        $file_day_path = $_FILES["file"]['tmp_name'][0];

        //get data path
        $file_hour_name = $_FILES["file1"]["name"][0];
        $file_hour_path = $_FILES["file1"]['tmp_name'][0];

        
        //get file extension and validate after
    	$ext1 = pathinfo($file_day_name, PATHINFO_EXTENSION);
    	$ext2 = pathinfo($file_hour_name, PATHINFO_EXTENSION);

        /*if ($ext1 != 'txt' || $ext2 != 'txt' ) 
        	JSONResponse(["type"=>"warning", "msg"=>'File Type Incorrect']);*/


        //open file and check if file can be open
    	$fday 	= fopen($file_day_path,'r');
    	$fhour 	= fopen($file_hour_path, 'r');

		if (!$fday || !$fhour) 
			JSONResponse(["type"=>"warning", "msg"=>'Cannot open file']);
		


		$file_day_exp 		= explode(".", $file_day_name);
		$file_day_type		= $file_day_exp[0];
		$file_day_tenant 	= $file_day_exp[1];
		unset($file_day_exp[0]);
		$file_day_match 	= implode('.', array_map('trim', $file_day_exp));



		$file_hour_exp 		= explode(".", $file_hour_name);
		$file_hour_type 	= $file_hour_exp[0];
		$file_hour_tenant 	= $file_hour_exp[1];
		unset($file_hour_exp[0]);
		$file_hour_match 	= implode('.', array_map('trim', $file_hour_exp));


		


		if($file_day_type != 'D' || $file_hour_type != 'H' || $file_day_tenant != $file_hour_tenant || $file_day_match != $file_hour_match)
			JSONResponse(["type"=>"warning", "msg"=>'Incorrect File']);	
		
		if($this->tsms_model->validate_tenant_name($location_code) != $file_day_tenant)
			JSONResponse(["type"=>"warning", "msg"=>'Incorrect file for the tenant']);

		$files = $this->tsms_model->validate_upload_file($file_day_name);

		if(!empty($files))
			JSONResponse(["type"=>"warning", "msg"=>'Data Already Exist']);

			
		//clean data for D file
		$fday_lines 		= explode("\n", fread($fday, filesize($file_day_path)));
		$fday_lines_clean 	= array_map('trim',substr_replace($fday_lines," ",0,2));	
		$day_lines 			= str_replace('"!', "", $fday_lines_clean);


		//clean data for H file
		$fhour_lines 		= explode("\n", fread($fhour, filesize($file_hour_path)));
		$fhour_lines 		= array_values(array_filter($fhour_lines, function($ln){
			$ln = trim($ln);
			return strlen($ln) > 0;
		}));
		$hour_lines 		= array_map('trim',substr_replace($fhour_lines, " ",0,2));
		//$hour_lines 		= str_replace('"!', "", $arr_data);


		
		$this->db->trans_start();

		$count= 0;
		$total_netsales_amount_hour=0;

		for ($i=3; $i < count($hour_lines)-3; $i++)
		{				
			$count++;
			if($count===2)
				$total_netsales_amount_hour += $hour_lines[$i];
			
			if($count===4)
				$count=0;
		}

		$variance_amount = $day_lines[16] - $total_netsales_amount_hour;

		$variance = substr_replace($variance_amount,".",-2,0);
		$variance = number_format((float)$variance, 2, '.', '');

		$status = (float) $variance == 0 ? 'Unconfirmed' : 'Unmatched';
		
			
		$query_tds = array(										
			'tenant_code'					=>		$day_lines[0],
			'pos_num' 						=>		$day_lines[1],
			'transac_date'					=>		$day_lines[2],
			'old_acctotal'					=>		number_format((float)substr_replace($day_lines[3],".",-2,0), 2, '.', ''),
			'new_acctotal'					=>		number_format((float)substr_replace($day_lines[4],".",-2,0), 2, '.', ''),
			'total_gross_sales'				=>		number_format((float)substr_replace($day_lines[5],".",-2,0), 2, '.', ''),
			'total_nontax_sales'			=>		number_format((float)substr_replace($day_lines[6],".",-2,0), 2, '.', ''),
			'total_sc_discounts'			=>		number_format((float)substr_replace($day_lines[7],".",-2,0), 2, '.', ''),
			'total_pwd_discounts'			=>		number_format((float)substr_replace($day_lines[8],".",-2,0), 2, '.', ''),
			'total_discounts_w_approval'	=>		number_format((float)substr_replace($day_lines[9],".",-2,0), 2, '.', ''),
			'total_discounts_wo_approval'	=>		number_format((float)substr_replace($day_lines[10],".",-2,0), 2, '.', ''),
			'other_discounts'				=>		number_format((float)substr_replace($day_lines[11],".",-2,0), 2, '.', ''),
			'total_refund_amount'			=>		number_format((float)substr_replace($day_lines[12],".",-2,0), 2, '.', ''),
			'total_taxvat'					=>		number_format((float)substr_replace($day_lines[13],".",-2,0), 2, '.', ''),
			'total_other_charges'			=>		number_format((float)substr_replace($day_lines[14],".",-2,0), 2, '.', ''),
			'total_service_charge'			=>		number_format((float)substr_replace($day_lines[15],".",-2,0), 2, '.', ''),
			'total_net_sales'				=>		number_format((float)substr_replace($day_lines[16],".",-2,0), 2, '.', ''),
			'total_cash_sales'				=>		number_format((float)substr_replace($day_lines[17],".",-2,0), 2, '.', ''),
			'total_charge_sales'			=>		number_format((float)substr_replace($day_lines[18],".",-2,0), 2, '.', ''),
			'total_gcother_values'			=>		number_format((float)substr_replace($day_lines[19],".",-2,0), 2, '.', ''),
			'total_void_amount'				=>		number_format((float)substr_replace($day_lines[20],".",-2,0), 2, '.', ''),
			'total_customer_count'			=>		$day_lines[21],
			'control_num' 					=>		$day_lines[22],
			'total_sales_transaction'		=>		$day_lines[23],
			'sales_type'					=>		$day_lines[24],
			'total_netsales_amount' 		=>		number_format((float)substr_replace($day_lines[25],".",-2,0), 2, '.', ''),
			'status'						=>		$status,
			'tenant_type'					=>		$tenant_type,
			'rental_type'					=>		$rental_type,
			'trade_name'					=>		$trade_name,
			'tenant_type_code'				=>		$tenant_type_code,
			'date_upload'					=>		$new_date,
			'location_code'					=>		$location_code,
			'txtfile_name'					=>		$file_day_name
		);
				
		$this->_DB2->insert('tenant_daily_sales', $query_tds);


		$tenant_code 	= $hour_lines[0];
		$pos_num 		= $hour_lines[1];
		$date 			= $hour_lines[2];

		$counter = 0;

		$hc 	= "";
		$nsah 	= "";
		$nsth 	= "";
		$cch 	= "";

		$total_nsah = 0;
		$total_nsth = 0;
		$total_cch 	= 0;


		$totalnetsales_day 			= number_format((float)substr_replace($hour_lines[count($hour_lines) -3],".",-2,0), 2, '.', '');
		$totalnumber_sales_transac 	= $hour_lines[count($hour_lines) -2];
		$total_customer_count_day 	= $hour_lines[count($hour_lines) -1];


		for ($o=3; $o < count($hour_lines)-3; $o++)
		{
			$counter++;

			if($counter===1)
			{
				$hc = $hour_lines[$o];
			}
			
			if($counter===2)
			{
				$nsah 			=  number_format((float)substr_replace($hour_lines[$o],".",-2,0), 2, '.', '');
				$total_nsah 	+= $nsah;
			}

			if($counter===3)
			{
				$nsth 			= $hour_lines[$o];
				$total_nsth 	+= $hour_lines[$o];
			}

			if($counter===4)
			{
				$cch 		=  $hour_lines[$o];
				$total_cch 	+= $hour_lines[$o];
			
				$query_ths = array(
					'tenant_code'						=>		$tenant_code,
					'pos_num'							=>		$pos_num,
					'transac_date'						=>		$date,
					'hour_code'							=>		$hc,
					'netsales_amount_hour'				=>		$nsah,
					'numsales_transac_hour'				=>		$nsth,
					'customer_count_hour'				=>		$cch,
					'totalnetsales_amount_hour'			=>		$totalnetsales_day,
					'totalnumber_sales_transac'			=>		$totalnumber_sales_transac,
					'total_customer_count_day'			=>		$total_customer_count_day,
					'status'							=>		$status,
					'tenant_type'						=>		$tenant_type,
					'rental_type'						=>		$rental_type,
					'trade_name'						=>		$trade_name,
					'tenant_type_code'					=>		$tenant_type_code,
					'date_upload'						=>		$new_date,
					'location_code'						=>		$location_code,
					'txtfile_name'						=>		$file_hour_name
				);

				$this->_DB2->insert('tenant_hourly_sales', $query_ths);

				$counter=0;	 
			}
		}	

		//LOG DATA TO UPLOAD STATUS TABLE
		$query_upstat = array(
			'tenant_name'			=>		$trade_name,
			'date_upload'			=>		$up_date,
			'location_code'			=>		$location_code,
			'txtfile_name'			=>		$file_day_name
		);

		$this->_DB2->insert('upload_status',$query_upstat);
				

		if((float) $variance != 0)
		{
 			$query_var_report = array(
				'trade_name'				=>		$trade_name,
				'tenant_code'				=>		$day_lines[0],
				'tenant_type'				=>		$tenant_type,
				'variance'					=>		$variance,
				'date'						=>		$day_lines[2],
				'date_upload'				=>		$new_date,
				'status'					=>		'Pending'
			);

			$this->_DB2->insert('variance_report', $query_var_report);
	 	}

		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
		}
			
		fclose($fday);
		fclose($fhour);


		if((float) $variance == 0)
			JSONResponse(["type"=>"success", "msg"=>'Data Match and Uploaded.']);
		
		JSONResponse(["type"=>"warning", "msg"=>'Sales dont match but uploaded. View Variance Report.']);
	}


	public function upload_hourly_sales()
	{
		date_default_timezone_set("Asia/Manila");
		$new_date = date('F j, Y, g:i A ');
		

		if ($this->session->userdata('is_logged_in')) 
		{
			$tenant_type = $this->input->post('tenant_list');
			$rental_type = $this->input->post('rental_type');
			$trade_name = $this->input->post('trade_name');
			$location_code = $this->input->post('location_code');
						if($tenant_type == 'Long Term Tenants'){
							$tenant_type_code = '1';
						}else{
							$tenant_type_code = '2';
						}

						if ($_FILES['file']['error'][0]===4) {
							echo json_encode("error");
						}

				if (!empty($_FILES))
				{
					for($i=0; $i < count($_FILES["file"]["name"]); $i++)
					{
		                $file_names = $_FILES["file"]["name"][$i];
		                $file_paths = $_FILES['file']['tmp_name'][$i];


		                if ($file_names == '') {
		                	$this->session->set_flashdata('message', 'No File');
		                	redirect('cntrl_tsms/upload_files');
		                			
		                	} else 
		                	{

			                		$ext = pathinfo($file_names, PATHINFO_EXTENSION);
				                	if ($ext == 'txt') 
				                	{
				                	
					                	
					                		$fh = fopen($file_paths,'r');

												if ($fh) 
												{
													$data = explode(".", $file_names);
													$file_tenant_id = $data[2];
													$file_type = $data[1];
													$result = $this->tsms_model->validate_tenant_name($location_code);
																	
														
														if($result == $file_tenant_id)
														{

																if($file_type == 'H')
																{
																		if($this->tsms_model->validate_upload_file_hourly($file_names)){
																			$this->session->set_flashdata('message', 'Already Exist');
																			redirect('cntrl_tsms/upload_files');

																			}else
																			{
																				$this->db->trans_begin();
																					try {


																							$this->db->query(
																								"INSERT INTO

																								`upload_status_hourly`
																								(
																									`tenant_name`,
																									`date_upload`,
																									`location_code`,
																									`txtfile_name`

																								)VALUES
																								(

																									'" . $trade_name . "',
																									'" . $new_date . "',
																									'" . $location_code . "',
																									'" . $file_names . "'

																								)"

																								);
																						
																					} catch (Exception $e) {
																						var_dump($e->getMessage());
																					}

																					$lines0 = explode("\n", fread($fh, filesize($file_paths)));
																					$linedata = "";
																					$counter = 0;

																					$arr_data = [];



																					for ($x=0; $x < count($lines0); $x++)
																					{
																						$arr_data[] = substr_replace($lines0[$x]," ",0,2);
																					}

																					//var_dump($arr_data);

																					$d1 = "";
																					$d2 = "";
																					$d3 = "";
																					$d4 = "";

																					for ($i=0; $i < count($arr_data) -4; $i++)
																					{

																							
																						if($i == 0){

																							$tenant_code = $arr_data[0];
																						}

																						if($i == 1){

																							$pos_num = $arr_data[1];
																						}

																						if($i == 2){

																							$date = $arr_data[2];
																						}

																					
																						if($i > 2)
																						{
																								$counter++;
																								if($counter===1)
																								{
																									$d1 = $arr_data[$i];
																								}
																								
																								if($counter===2)
																								{
																									$d2 = $arr_data[$i];
																								}
																								if($counter===3)
																								{
																									$d3 = $arr_data[$i];
																								}
																								if($counter===4)
																								{
																									$d4 = $arr_data[$i];
																								}


																								$totalnetsales_day = $arr_data[count($arr_data) -4];
																								$totalnumber_sales_transac = $arr_data[count($arr_data) -3];
																								$total_customer_count_day = $arr_data[count($arr_data) -2];



																									if($counter===4)
																									{
																										

																											try {

																											

																													$query =$this->db->query(
																													"INSERT INTO 
																														`tenant_hourly_sales`
																														(
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
																															`txtfile_name`
																															
																														
																														
																														) VALUES 
																														(
																															'" . $tenant_code . "',
																															'" . $pos_num . "',
																															'" . $date . "',
																															'" . $d1 . "',
																															'" . substr_replace($d2, ".", -3, 0) . "',
																															'" . $d3 . "',
																															'" . $d4 . "',
																															'" . substr_replace($totalnetsales_day, ".", -3, 0) . "',
																															'" . $totalnumber_sales_transac . "',
																															'" . $total_customer_count_day . "',
																															'Not Checked',
																															'" . $tenant_type . "',
																											 				'" . $rental_type . "',
																											 				'" . $trade_name . "',
																											 				'" . $tenant_type_code . "',
																															'" . $new_date ."',
																											 				'" . $location_code . "',
																											 				'" . $file_names . "'
																													
																													
																																)"
																															);


																												} catch (Exception $e) {
																													var_dump($e->getMessage());
																														}


																												$counter=0;
																									}



																						}

																					}

																					
																				$trans_complete = $this->db->trans_complete();
             
																	             if($trans_complete){
																				 	$this->session->set_flashdata('message', 'Uploaded');
																				 	redirect('cntrl_tsms/upload_files');
																			 		}
																								

																			}
																
																}else{
																	$this->session->set_flashdata('message', 'Incorrect');
																	redirect('cntrl_tsms/upload_files');
																}
														}else{
																	$this->session->set_flashdata('message', 'Not Match');
																	redirect('cntrl_tsms/upload_files');
																}
												}

											fclose($fh);
										
					                }else{

				                	$this->session->set_flashdata('message', 'Invalid File');
			                		redirect('cntrl_tsms/upload_files');
				                		}
                			}

   					}

	            } else {
	            	$this->session->set_flashdata('message', 'No Files');
	                redirect('cntrl_tsms/upload_files');

	            }


		} else {
			redirect('admin/index');
		}
	}	

	
}

