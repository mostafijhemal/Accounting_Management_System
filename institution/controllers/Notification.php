<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {
	static $model 	 = array('M_crud');
	static $helper   = array('url');
	static $library  = array('session');
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(self::$library);
		$this->load->model(self::$model);
		$this->load->helper(self::$helper);

		date_default_timezone_set('Asia/Dhaka');
	}

	/*
		This Controler Use for NotiFication count & NotiFication List Show
	*/
	

	public function messageNotification() {
		$user_id = $this->session->userdata('app_userid');
		$data['total_message'] = $this->M_crud->countAll('invox_table', array('receive_user_id' => $user_id, 'email_notifi_status' => 'no'));
		$data['message_list'] = $this->M_crud->findAllLimit('invox_table', array('receive_user_id' => $user_id), 'invox_id', 'desc', 5);
		$this->load->view('app/notification/messageNotificationPage', $data);
	}




}
