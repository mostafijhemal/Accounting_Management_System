<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	This Function return session Data
*/
if(!function_exists('userId')){
	function userId(){
		$_CI  = &get_instance();
		$data = $_CI->session->userdata('userid');
		return $data;
	}
}

/*
	This Function return session Data
*/
if(!function_exists('sessionData')){
	function sessionData($data){
		$_CI  = &get_instance();
		$data = $_CI->session->userdata($data);
		return $data;
	}
}

/*
	This Function use for Get Data from Url
*/
if(!function_exists('fileProtect')){
	function fileProtect() {
		/*function GetVolumeLabel($drive) {
			if(preg_match('#Volume Serial Number is (.*)\n#i', shell_exec('dir '.$drive.':'), $m)) {
				$volname = ' ('.$m[1].')';
		   	} else {
				$volname = '';
		   	}
		   	return $volname;
		}
	   	$cdir = str_replace("(","",str_replace(")","",GetVolumeLabel("c")));
	   	$edir = str_replace("(","",str_replace(")","",GetVolumeLabel("e")));
	   	$fdir = str_replace("(","",str_replace(")","",GetVolumeLabel("f")));
	   	
	   	if($cdir != ' FC52-7DBF' && $edir != ' 6451-D479' && $fdir != ' A26E-E699'){
	   		redirect('app_login/notValidUser');
	   	}*/
	}
}


/*
	This Function use for valid input
	and avoid invalid script
	and unnecessary space 
	and avoid html special characters
*/
if(!function_exists('inputFunction')){
	function inputFunction($data) {
		$_CI  = &get_instance();
		
	  $data = $_CI->input->post($data);
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
}


/*
	This Function use for Get Data from Url
*/
if(!function_exists('inputGetFunction')){
	function inputGetFunction($data) {
		$_CI  = &get_instance();
		
	  $data = $_CI->input->get($data);
	  return $data;
	}
}


if(!function_exists('sum_formate')){
	function sum_formate($amount = 0) {
		if($amount < 0) {
			return '('.number_format(abs($amount), 2).')'; 
		} 
		return number_format($amount, 2);
	}
}



/*
	intager to word converter
*/
if (!function_exists('convert_number_to_words')) {
	function convert_number_to_words($number) {
		$_CI = &get_instance();
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ' ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
		0                   => 'zero',
		1                   => 'one',
		2                   => 'two',
		3                   => 'three',
		4                   => 'four',
		5                   => 'five',
		6                   => 'six',
		7                   => 'seven',
		8                   => 'eight',
		9                   => 'nine',
		10                  => 'ten',
		11                  => 'eleven',
		12                  => 'twelve',
		13                  => 'thirteen',
		14                  => 'fourteen',
		15                  => 'fifteen',
		16                  => 'sixteen',
		17                  => 'seventeen',
		22                  => 'eighteen',
		19                  => 'nineteen',
		20                  => 'twenty',
		30                  => 'thirty',
		40                  => 'fourty',
		50                  => 'fifty',
		60                  => 'sixty',
		70                  => 'seventy',
		80                  => 'eighty',
		90                  => 'ninety',
		100                 => 'hundred',
		1000                => 'thousand',
		1000000             => 'million',
		1000000000          => 'billion',
		1000000000000       => 'trillion',
		1000000000000000    => 'quadrillion',
		1000000000000000000 => 'quintillion'
		);
		
		if (!is_numeric($number)) {
			return false;
		}
		
		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error('convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
			return false;
		}
		
		if ($number < 0) {
			return $negative . convert_number_to_words(abs($number));
		}
		
		$string = $fraction = null;
		
		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}
		
		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
			break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
			break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . convert_number_to_words($remainder);
				}
			break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= convert_number_to_words($remainder);
				}
			break;
		}
		
		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}
		
		return $string;
	}
}


// account intigration
// Get Accounting VoucherId
if ( ! function_exists('getAccVoucherId')) {
	function getAccVoucherId() {
	    $_CI = &get_instance();
		$lTable = $_CI->M_default_setup->ledger_table_name();

		$maxRow = $_CI->M_crud->findMax($lTable, array(), 'voucher_id');
		if(isset($maxRow) && !empty($maxRow->voucher_id)) {
			$voucher_id = ($maxRow->voucher_id + 1);
		} else {
			$voucher_id = 1;
		}
		return $voucher_id;
	}
}


// Get Accounting Serial no
if ( ! function_exists('getAccSerialNo')) {
	function getAccSerialNo() {
	    $_CI = &get_instance();
		$lTable = $_CI->M_default_setup->ledger_table_name();

		$maxRow = $_CI->M_crud->findMax($lTable, array(), 'serial_no');
		if(isset($maxRow) && !empty($maxRow->serial_no)) {
			$serial_no = ($maxRow->serial_no + 1);
		} else {
			$serial_no = 1;
		}
		return $serial_no;
	}
}

// Check User Access Validation
if ( ! function_exists('checkUserAccess')) {
	function checkUserAccess() {
	    $_CI = &get_instance();
	    $_CI->load->model('M_admin');

	    $uTypeId = $_CI->session->userdata('app_user_type_id');
	    if($uTypeId == 1 || $uTypeId == 3) {
	    	return true;
	    } else {
	    	$class  = $_CI->router->fetch_class();
			$method = $_CI->router->fetch_method();
			$userId = $_CI->session->userdata('app_userid');
			//$link   = uri_string();

			$rowData= $_CI->M_admin->getUserAccessData(array('access_list.user_id' => $userId, 'controller_list.controller_name' => $class, 'controller_list.function_name' => $method));
			if(isset($rowData) && !empty($rowData) && $rowData->access_status == 'Yes') {
				return true;
			} else {
				return false;
			}
	    }
	    /*if($uTypeId != 1) {
	    	$class  = $_CI->router->fetch_class();
			$method = $_CI->router->fetch_method();
			$userId = $_CI->session->userdata('app_userid');
			//$link   = uri_string();

			$rowData= $_CI->M_admin->getUserAccessData(array('access_list.user_id' => $userId, 'controller_list.controller_name' => $class, 'controller_list.function_name' => $method));
			if(isset($rowData) && !empty($rowData) && $rowData->access_status == 'Yes') {
				return true;
			} else {
				return false;
			}
	    } else {
	    	return true;
	    }*/
	}
}

if ( ! function_exists('inventoryAccountIntigration')) {
	function inventoryAccountIntigration($company_id = 0, $serial_no = 0, $voucher_id = 0, $enalisis_code = '', $reverse_head = 0, $account_id = 0, $debit = 0, $credit = 0, $narration = '', $voucherType = '') {

	    $_CI 		  = &get_instance();
		$voucher_date = date('Y-m-d');

		$lTable = $_CI->M_default_setup->ledger_table_name();
		
		$data['company_id'] 		= $company_id;
		$data['serial_no'] 			= $serial_no;
		$data['voucher_id'] 		= $voucher_id;
		$data['enalisis_code'] 		= $enalisis_code;
		$data['reverse_head'] 		= $reverse_head;
		$data['account_id'] 		= $account_id;
		$data['debit'] 				= $debit;
		$data['credit'] 			= $credit;
		$data['narration'] 			= $narration; 
		if($voucherType == 'DR') {
			if($debit != 0) {
				$data['list_sum'] 	= 'L';
			} else {
				$data['list_sum'] 	= 'S';
			}
			$data['flag'] 			= 'DR';
		} else if($voucherType == 'CR') {
			if($debit != 0) {
				$data['list_sum'] 	= 'S';
			} else {
				$data['list_sum'] 	= 'L';
			}
			$data['flag'] 			= 'CR';
		}  else if($voucherType == 'JR') {
			$data['list_sum'] 		= 'L';
			$data['flag'] 			= 'JR';
		}  else if($voucherType == 'CT') {
			$data['list_sum'] 		= 'L';
			$data['flag'] 			= 'CT';
		} 
			
		$data['voucher_date'] 		= $voucher_date;
		$data['sys_date'] 			= date('Y-m-d H:i:s');
        $data['create_id'] 			= $_CI->session->userdata('app_userid');
        $data['check_id'] 			= $_CI->session->userdata('app_userid');
        $data['approve_id'] 		= $_CI->session->userdata('app_userid');

		$_CI->M_crud->save($lTable, $data); 
	}
}


// ------------------------------------------------------------------------
/* End of file customfunction_helper.php */
/* Location: ./application/helpers/customfunction_helper.php */