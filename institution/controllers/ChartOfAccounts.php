<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ChartOfAccounts extends CI_Controller {
	const  Title	 = 'App';
	const  InsertMsg = 'Insert Successfully';
	const  UpdateMsg = 'Update Successfully';
	const  DeleteMsg = 'Delete Successfully';
	
	static $model 	 = array('M_crud', 'M_join', 'M_default_setup');
	static $helper   = array('url', 'authentication', 'customfunction');
	static $library  = array('session', 'user_agent');
	
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


	public function index() {
		$data['title'] 		= 'Chart Of Accounts List & Manage';
		if (checkUserAccess()) {
			$data['success'] 	= $this->session->userdata('success');
			$data['messege'] 	= $this->session->userdata('messege');
							   	  $this->session->set_userdata(array('success' => '', 'messege'=> ''));

			$company_id = $this->session->userdata('company_id');
			$dataExist = $this->M_crud->findLastData('acc_chart_of_accounts', array('company_id' => $company_id), 'id', 'desc');
			if(!isset($dataExist) || empty($dataExist)){
				$this->M_default_setup->defaultChartOfAccount($company_id); // Create Default Chart Of Accounts
			}
			// Parent Layer
			$data['layer']	= $this->M_crud->findAll('acc_chart_of_accounts', array('p_id' => 0, 'company_id' => $company_id), 'id', 'asc');
			//$data['le'] 	= $this->M_crud->findAll('acc_chart_of_accounts', array('p_id' => 1), 'id', 'asc');

			$data['content']= "accounts/chartOfAccountsPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	//Get child ID
	public function get_child_id($account_id, $company_id){
		$query = $this->db->where('company_id', $company_id)->where('status', 'Child')->like('account_id', $account_id, 'after')->get('acc_chart_of_accounts');
		$data = array();
		foreach($query->result() as $rows){
			$data[] = $rows->account_id;
		}
		return $data;
	}

	public function chartOfAccountDataForUpdate() {
		$id = inputFunction('id');

		$data = $this->M_crud->findById('acc_chart_of_accounts', array('id' => $id));
		echo json_encode($data);
	}

	public function saveChartOfAccount() {
		$company_id = $this->session->userdata('company_id');
		if (checkUserAccess()) {
			$id 		= inputFunction('id');
			$p_id 		= inputFunction('p_id');
			$account_id = inputFunction('account_id');

			if(empty($id)) {
				$thisRowData = $this->M_crud->findById('acc_chart_of_accounts', array('account_id' => $account_id, 'company_id' => $company_id));

				$data['company_id'] 		= $company_id;
				$data['acc_class_id'] 		= $thisRowData->acc_class_id;
				// Get current account_id and set p_id for new head
				$data['p_id'] 				= $account_id;

				// Find Last Data for create new account hea code
				$dataExist = $this->M_crud->findLastData('acc_chart_of_accounts', array('p_id' => $account_id, 'company_id' => $company_id), 'id', 'desc');

				if(!empty($dataExist->account_id)) {
					$lastCode 		= $dataExist->account_id;
					$newAccountId 	= ($lastCode + 1);
				} else {
					$newAccountId 	= $account_id.'01';
					$data2['status']= 'Parent';  // 'Parent', 'Child'
					$this->db->update('acc_chart_of_accounts', $data2, array('account_id' => $account_id, 'company_id' => $company_id));
				}
				$data['account_id'] 		= $newAccountId;
				$data['status'] 			= 'Child';  // 'Parent', 'Child'
			}
			
			$data['account_name'] 		= inputFunction('account_name');
			$data['head_status'] 		= inputFunction('head_status'); // 'Enable', 'Disable'
			$data['required_status'] 	= inputFunction('required_status'); // 'No', 'Yes'

			if(empty($id)) {
				$this->M_crud->save('acc_chart_of_accounts', $data);
				$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::InsertMsg));
			} else {
				$this->M_crud->update('acc_chart_of_accounts', $data, array('id' => $id));
				$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::UpdateMsg));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege'=> "We are really sorry this Action is not allowed for you"));
		}

		redirect($this->agent->referrer());
	}


	public function deleteChartOfAccount() {
		$company_id = $this->session->userdata('company_id');
		$p_id = inputFunction('p_id');
		$id   = inputFunction('id');

		$this->db->delete('acc_chart_of_accounts', array('id' => $id));
		$totalRow = $this->db->query("SELECT count(id) totalRow from acc_chart_of_accounts where p_id = $p_id AND company_id = $company_id")->row()->totalRow;
		if($totalRow == 0) {
			$this->db->update('acc_chart_of_accounts', array('status' => 'Child'), array('account_id' => $p_id, 'company_id' => $company_id));
		}
		$this->session->set_userdata(array('success' => 'Success', 'messege'=> 'Data Delete Successfully'));
		echo "data";
	}



}
