<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_login extends CI_Controller {

	const  Title	 = 'App';
	
	static $model 	 = array('M_admin', 'M_crud');
	static $helper   = array('url', 'authentication');
	static $library  = array('session', 'email');

	
	public function __construct(){

		parent::__construct();
		$this->load->database();
		$this->load->model(self::$model);
		$this->load->helper(self::$helper);
		$this->load->library(self::$library);

		date_default_timezone_set('Asia/Dhaka');
	}
	
	
	public function index() {
		$data['msg']	= '';
		//$data['title'] 	= self::Title.' - Login Panel';
		$data['title'] 	= 'Login Panel';
		$this->load->view('app/login/loginPage', $data);
	}
	
	public function authenticate() {
		loginUser();
	}
	
	public function logout() {
		logoutUser();
	}








	public function appUserForgotPassword() {
		$data['title'] 	= 'Forgot Password Panel';
		$data['messege']= $this->session->userdata('messege');
						$this->session->set_userdata(array('messege'=> ''));

		$this->load->view('app/login/forgotPasswordPage', $data);
	}

	public function testUserEmailIsExist() {
		$email_address = $this->input->post('email_address');

		$data = $this->M_crud->findById('app_user', array('email' => $email_address));
		echo json_encode($data);
	}





	public function sandEmailForAppUserChangePassword() {
		if($this->input->get('email')){
			$email_address 	= $this->input->get('email');
		}
		if($this->input->post('email_address')){
			$email_address 	= trim($this->input->post('email_address'));
		}
		
		$data['email_address'] 	= $email_address;
		// Make an unic Verify Code Start
			$verifyCode 			= substr(uniqid(), -5);
			$data['verify_code'] 	= $verifyCode;
		// Make an unic Verify Code End

		// Make deleting Time Verify Code Start	
			$currentDateTime = strtotime(date("Y-m-d H:i:s"));
			$futureDateTime = $currentDateTime + (60*10); // Add 10 Minute with current time
			$data['delete_time'] = date("Y-m-d H:i:s", $futureDateTime);
		// Make deleting Time Verify Code End  awalrobiul70@gmail.com

		$save = $this->db->insert('temp_verify_code', $data);

		if($save){
			$nstitute_info = $this->M_crud->findById('company_register_table', array('id' => 1));

			$to_mail 	= $email_address;

			if(!empty($nstitute_info->email)){
				$from_mail 	= ''.$nstitute_info->email.'';
				$reply_mail = ''.$nstitute_info->email.'';
			} else {
				$from_mail 	= 'robiul.ussltd@gmail.com';
				$reply_mail = 'robiul.ussltd@gmail.com';
				
			}
			
			// Email Generate Start
			$user_data 			= $this->M_crud->columnFindById(array('id', 'full_name'), 'app_user', array('email' => $email_address));

			$tocken 			= $user_data->id.md5(uniqid());

			$verifyLinkForEmail = site_url().'app_login/mailVerify?tocken='.$tocken.'&verifyCode='.$verifyCode.'&email='.$email_address;

			$mailMessage 		= 'Your Verify Code is '.$verifyCode.' and Link '.$verifyLinkForEmail.' You can use the Code or Link after 10 minutes for mail verification because after 10 minutes the Code and Link will be dismiss.';
			
			// Email Generate End

			// Send Mail Start
				$message = 'Hi ' . $user_data->full_name.',';
        		$message .= "\r\n";
        		$message .= $mailMessage;
        		$message .= "\r\n";
        		if(isset($nstitute_info)) {
        			$message .= 'Mail Send from : '.$nstitute_info->full_name."\r\n".'Head Office : '.$nstitute_info->head_office."\r\n".'Chif : '.$nstitute_info->chif_name."\r\n".'E-mail : '.$nstitute_info->email;
        			$subject = $nstitute_info->full_name." Mail Verification for Change Password";
        		} else {
        			$subject = "Mail Verification for Change Password";
        		}

				$config['protocol'] = 'sendmail';
		        $config['mailpath'] = '/usr/sbin/sendmail';
		        $config['charset']  = 'iso-8859-1';
		        $config['wordwrap'] = TRUE;
		          
		        $this->email->initialize($config);

		        $this->email->from($from_mail, $user_data->full_name);
		        $this->email->to($to_mail);
		        $this->email->subject($subject);
		        $this->email->message($message);
		        $this->email->reply_to($reply_mail);
		        $this->email->send();
			// Send Mail End  
		}
		redirect('app_login/appUserForgotPasswordVerifyCode?email='.$email_address);
	}

	public function appUserForgotPasswordVerifyCode() {
		$data['title'] 	= 'Mail Verify Panel';
		$this->load->view('app/login/forgotPasswordMailVerifyPage', $data);
	}

	public function tempVerifyCodeDelete() {
		$currentDateTime = date("Y-m-d H:i:s");

		$data = $this->M_crud->findAll('temp_verify_code', array('delete_time <' => $currentDateTime), 'id', 'asc');

		foreach ($data as $value) {
			$this->db->delete('temp_verify_code', array('id' => $value->id));
		}
	}

	public function appUserForgotPasswordVerifyCodeCheck() {
		$verify_code = trim($this->input->post('verify_code'));
		$email 		 = trim($this->input->post('email'));

		$verify_data = $this->M_crud->findById('temp_verify_code', array('verify_code' => $verify_code, 'email_address' => $email));

		if(isset($verify_data)) {
			$user_data = $this->M_crud->columnFindById(array('id'), 'app_user', array('email' => $verify_data->email_address));
			$tocken = md5(uniqid());
			$this->db->delete('temp_verify_code', array('id' => $verify_data->id));
			redirect('app_login/appUserResetPassword?tocken='.$user_data->id.$tocken);
		} else {
			$this->session->set_flashdata('verifyCodeWrongessage', '<div style="border: 1px solid #ddd;height: 42px;color: red;text-align: center;font-size: 22px;">Please Enter A Valid Verify Code...</div>');
			redirect('app_login/appUserForgotPasswordVerifyCode?email='.$email);
		}
	}

	public function appUserResetPassword() {
		$data['title'] 	= 'Reset Password Panel';
		$this->load->view('app/login/appUserResetPasswordPage', $data);
	}

	public function appUserChangePasswordAction() {
		$userId 			= trim($this->input->post('userId'));
		$data['password'] 	= md5(trim($this->input->post('new_pass')));

		$this->db->update('app_user', $data, array('id' => $userId));

		redirect('app_login');
	}

	public function mailVerify() {
		$tocken 	= $this->input->get('tocken');
		$verifyCode = $this->input->get('verifyCode');
		$email 		= $this->input->get('email');

		$userId 	= substr($tocken, 0, -32);

		// Delete Previous Verify Data Start
		$currentDateTime = date("Y-m-d H:i:s");
		$data = $this->M_crud->findAll('temp_verify_code', array('delete_time <' => $currentDateTime), 'id', 'asc');
		foreach ($data as $value) {
			$this->db->delete('temp_verify_code', array('id' => $value->id));
		}
		// Delete Previous Verify Data End

		$verify_data = $this->M_crud->findById('temp_verify_code', array('email_address' => $email, 'verify_code' => $verifyCode));
		if(isset($verify_data) || !empty($verify_data)){
			$linkTocken = $userId.md5(uniqid());
			$this->db->delete('temp_verify_code', array('id' => $verify_data->id));
			redirect('app_login/appUserResetPassword?tocken='.$linkTocken);
		} else {
			$this->session->set_userdata(array('messege'=> 'data'));
			redirect('app_login/appUserForgotPassword');
		}
	}

	public function notValidUser() {

		$this->load->view('app/login/notValidUser');
	}





	













}



