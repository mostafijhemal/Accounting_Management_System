<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('loginUser')) {
	function loginUser() {
		$_CI = &get_instance();
		
		$login_name		 = blockScript($_CI->input->post('login_name'));
		$password		 = md5(blockScript($_CI->input->post('password')));
		
		$userData	 = $_CI->M_admin->findByUserName('app_user', array('login_name' =>$login_name));
		if(!empty($userData) && ($userData->password == $password) && ($userData->status == 'active')){
			$_CI->load->model("M_join");
			// Get Current Financial Year 
			$fyYear = $_CI->M_join->getRunningFinancialYear($userData->company_id);
			if(isset($fyYear) && !empty($fyYear)) {
				$fyId 		= $fyYear->id;
				$from_date 	= $fyYear->from;
				$to_date 	= $fyYear->to;
			} else {
				$fyId 		= NULL;
				$from_date 	= NULL;
				$to_date 	= NULL;
			}
			// TO SET DATA IN SESSION FIELD 
			setUserData($userData->id, $userData->user_type_id, $userData->designition, $userData->full_name, $userData->login_name, $userData->company_id, $fyId, $from_date, $to_date);
			//exit(); 
			redirect('dashboard/summary');
		} else {
			$data['msg']   = 'You Are Not Valid User';
			$data['title'] = 'Login Panel';
			$_CI->load->view('app/login/loginPage', $data);
			//$_CI->load->view('app/home/homePage', $data);
		}
	}
}

// TO SET DATA IN UserName SESSION FIELD
if ( ! function_exists('setUserData')) {
	function setUserData($userid, $admin_type ,$designition, $fullName, $loginName, $company_id, $fyId, $from_date, $to_date) {
		$_CI = &get_instance();
		$userData = array(
						'app_userid' 			=> $userid, 
						'app_user_type_id'  	=> $admin_type,
						'app_user_designition'  => $designition, 
						'app_user_full_name'  	=> $fullName, 
						'app_login_name'  		=> $loginName,
						'company_id'  			=> $company_id,
						'financial_year_auto_id'=> $fyId,
						'from_year'  			=> $from_date,
						'to_year'  				=> $to_date,
					);
		$_CI->session->set_userdata($userData);
	}
}


if ( ! function_exists('getUserName')) {
	function getUserName() {
		$_CI = &get_instance();
		return $_CI->session->userdata('app_userid');
	}
}


if ( ! function_exists('invalidUserData')) {
	function invalidUserData() {
		setUserData(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
	}
}


if ( ! function_exists('isActiveUser')) {
	function isActiveUser() {
		return getUserName() != NULL;
	}
}

if ( ! function_exists('isAuthenticate')) {
	function isAuthenticate() {
		if(!isActiveUser()) {
			redirect('user/login');	
		} else {
			return true;	
		}
	}
}


if (!function_exists('logoutUser')) {
	function logoutUser() {
		invalidUserData();
		if(!isActiveUser()){
			redirect('');
		}
	}
}



if(!function_exists('blockScript')){
	function blockScript($data) {
		$_CI  = &get_instance();
		
	  	$data = trim($data);
	  	$data = stripslashes($data);
	  	$data = htmlspecialchars($data);
	  	return $data;
	}
}








// ------------------------------------------------------------------------
/* End of file authentication_helper.php */
/* Location: ./application/helpers/authentication_helper.php */
