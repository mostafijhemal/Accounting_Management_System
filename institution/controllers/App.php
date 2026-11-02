<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
	const  Title	 = 'App';
	const  InsertMsg = 'Insert Successfully';
	const  UpdateMsg = 'Update Successfully';
	const  DeleteMsg = 'Deleted Successfully';
	
	static $model 	 = array('M_crud', 'M_join', 'M_default_setup');
	static $helper   = array('url', 'html', 'text', 'authentication', 'customfunction');
	static $library  = array('session', 'form_validation');
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library(self::$library);
		$this->load->model(self::$model);
		$this->load->helper(self::$helper);

		date_default_timezone_set('Asia/Dhaka');
		isAuthenticate();
		fileProtect();
	}

	/*
		sessionData('app_userid')
		sessionData('app_user_type_id')
		sessionData('app_user_designition')
		sessionData('app_user_full_name')
		sessionData('app_login_name')
		sessionData('employee_id')
	*/

	//Get child ID
	public function get_child_id($account_id, $company_id){
		$query = $this->db->where('company_id', $company_id)->where('status', 'Child')->like('account_id', $account_id, 'after')->get('acc_chart_of_accounts');
		$data = array();
		foreach($query->result() as $rows){
			$data[] = $rows->account_id;
		}
		return $data;
	}

	public function index(){
		//$data['title'] = self::Title.' - Dashboard';
		$data['title'] 				= 'Dashboard';
		if (checkUserAccess()) {
			//$data['include_css'][]	= ''; // After data/css/
			//$data['include_js'][]		= ''; // After data/js/

			$data['include_js'][]		= 'mycustom/jquery.animateNumber.min.js';
			$data['include_js'][]		= 'graph/jquery.canvasjs.min.js';

			/*$menu_data_exist = $this->M_crud->findMax('menu_list', array(), 'id');
			if(empty($menu_data_exist->id)){
				$this->M_default_setup->defaultMenu();
			}*/
			$currentSum = $this->M_join->dashboardSammery($this->session->userdata("company_id"));
			
			$data['cashAmount'] 	= $currentSum->totalCash;
			$data['bankAmount'] 	= $currentSum->totalBank;
			$data['expAmount'] 		= $currentSum->totalExpense;
			$data['incomeAmount'] 	= $currentSum->totalIncome;


			$data['lastVoucherList'] = $this->M_join->lastVoucherList();

			$data['content'] = "dashboard_content";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	
	

	
	
}
