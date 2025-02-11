<?php 
function JSONResponse($data){
	header('Content-Type: application/json');
	die(json_encode($data));
}

function getValidYears(){
	$valid_years = [];
	for ($i=2017; $i <= date('Y') ;  $i++) { 
        $valid_years[] = $i;
    }

    return $valid_years;
}

function records_url($view){
	return base_url().'cntrl_tsms/records/'.$view;
}

function array_group_by(array $arr, callable $key_selector) {
  $result = array();
  foreach ($arr as $i) {
    $key = call_user_func($key_selector, $i);
    $result[$key][] = $i;
  }  
  return $result;
}

function dd(){
	$args = func_get_args();
	foreach ($args as  $arg) {
		var_dump($arg);
	}
	die();
}

function getUploadFiles($name){

	if(!isset($_FILES[$name]) || empty($_FILES[$name]['name']) || empty($_FILES[$name]['tmp_name']))
		return null;

	$files = $_FILES[$name];



	if(gettype($files['name']) == 'string')
		return $files;

	$arranged = [];
	foreach ($files as $key => $fields) {
		foreach ($fields as $index => $value) {
			$arranged[$index][$key] = $value;
		}
	}

	return $arranged;

}


function createUploadError($file, $description){
	return compact('file', 'description');
}


function isNaturalNumber($str){
	return  preg_match('/^[0-9]+$/', $str) ? true : false;
}

function isInteger($str){
	return preg_match('/(^)[-+]?\d+$/', trim($str)) ? true :false;
}


function validDate($date){
	return preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date) ?  true : false;
}

function toDecimal($numeric){
	return number_format((float)substr_replace($numeric,".",-2,0), 2, '.', '');
}

function arrayToString( array &$row_fields, $delimiter = ',', $enclosure = '"', $encloseAll = false, $eol = PHP_EOL, $nullToMysqlNull = false ) {
    $delimiter_esc = preg_quote($delimiter, '/');
    $enclosure_esc = preg_quote($enclosure, '/');

    $output = array();
    foreach ($row_fields as $fields) {
    	$row = array();
	    foreach ( $fields as $field ) {
	        if ($field === null && $nullToMysqlNull) {
	            $row[] = 'NULL';
	            continue;
	        }

	        // Enclose fields containing $delimiter, $enclosure or whitespace
	        if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc})/", $field ) ) {
	            $row[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
	        }
	        else {
	            $row[] = $field;
	        }
	    }

	    $output[] = implode( $delimiter, $row );
    }
    
    return implode($eol, $output).$eol;
}

function writeNewFile($dir, $data){
	$file = fopen($dir, "w");
    fwrite($file, $data);
    fclose($file);
}

function download_send_headers($filename, $data = null) {
	ob_clean();
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");


   echo $data;
}

if(!function_exists('load_view')){

  function load_view($view, $vars=array(), $output = false){
    $CI = &get_instance();
    return $CI->load->view($view, $vars, $output);
  }
}