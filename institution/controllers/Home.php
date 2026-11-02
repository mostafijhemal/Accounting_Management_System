<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
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
		$data['title'] = 'Accounting Management';
		$this->load->view('app/home/homePage', $data);
	}

	public function create_company() {
		$data['company_name'] 	= blockScript($this->input->post('company_name'));
		$data['email_or_phone'] = blockScript($this->input->post('email_or_phone'));
		$data['address'] 		= blockScript($this->input->post('address'));

		$loatId = $this->M_crud->save('company_register_table', $data);
		//$this->session->set_userdata(array('register_company_id' => $loatId));

		redirect('setup/newUser/'.$loatId);
	}

	public function findCompany() {
		$data['title'] 			= 'Accounting Management';
		$data['comNotExistMes'] = $this->session->userdata('companySetupMsg');
		$this->session->set_userdata(array('companySetupMsg' => NULL));

		$this->load->view('app/home/findCompanyPage', $data);
	}

	public function findCompanyAction() {
		$email_or_phone = blockScript($this->input->post('email'));
		$comRow 		= $this->M_crud->findById('company_register_table', array('email_or_phone' => $email_or_phone));
		$userRow 		= $this->M_crud->findById('app_user', array('company_id' => $comRow->id));

		if(isset($comRow) && !empty($comRow)) {
			if(isset($userRow) && !empty($userRow)) {
				$this->session->set_userdata(array('companySetupMsg' => 'Setup Already Complete. You Can Login Your Company'));
				redirect('setup/findYourCompany');
			} else {
				redirect('setup/newUser/'.$comRow->id);
			}
		} else {
			$this->session->set_userdata(array('companySetupMsg' => 'Company Not Found'));
			redirect('setup/findYourCompany');
		}
	}

	public function createNewUser($id) {
		$data['title'] = 'Create First User';
		$data['contCreateUser'] = $this->session->userdata("contCreateUser");
		$this->session->set_userdata(array('contCreateUser' => NULL));
		
		$data['company_id'] = $id;
		$this->load->view('app/home/firstUserPage', $data);
	}


	public function saveFirstUserData() {
		$data['login_name'] 		= blockScript($this->input->post("login_name"));
		$data['company_id'] 		= blockScript($this->input->post("company_id"));
		$dataExist = $this->M_crud->findById("app_user", array('login_name' => $data['login_name']));
		if(isset($dataExist) && !empty($dataExist)) {
			$this->session->set_userdata(array('contCreateUser' => 'Login Username Already Exist.'));
			redirect('setup/newUser/'.$data['company_id']);
		} else {
			$data['password'] 			= md5(blockScript($this->input->post("password")));
			$data['full_name'] 			= blockScript($this->input->post("full_name"));
			$data['designition'] 		= blockScript($this->input->post("designition"));
			$data['present_address'] 	= blockScript($this->input->post("present_address"));
			$data['permanent_address'] 	= blockScript($this->input->post("permanent_address"));
			$data['user_type_id'] 		= 1;
			$loatId = $this->M_crud->save('app_user', $data);
			redirect('');
		}
	}






	/*public function firstUserCreate() {
		$data['email_or_phone'] 	= blockScript($this->input->post('email_or_phone'));
		$data['password'] 			= blockScript($this->input->post('password'));
		$data['full_name'] 			= blockScript($this->input->post('full_name'));
		$data['designation'] 		= blockScript($this->input->post('designation'));
		$data['present_address'] 	= blockScript($this->input->post('present_address'));
		$data['permanent_address'] 	= blockScript($this->input->post('permanent_address'));

		$loatId = $this->M_crud->save('company_register_table', $data);
		$this->session->set_userdata(array('register_company_id' => $loatId));

		redirect('');
	}*/




}



