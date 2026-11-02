<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InstituteInfo extends CI_Controller {
	const  InsertMsg = 'Insert Successfully';
	const  UpdateMsg = 'Update Successfully';
	
	static $model 	 = array('M_crud', 'M_join');
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

	public function index(){
		$data['title'] 		= 'Company Information Update';
		if (checkUserAccess()) {
			$data['success'] 	= sessionData('success');
			$data['messege'] 	= sessionData('messege');
							   	  $this->session->set_userdata(array('success' => '','messege'=> ''));

			$data['comData'] 	= $this->M_crud->findById('company_register_table', array('id' => $this->session->userdata('company_id')));
			$data['country_list'] 	= $this->M_crud->findAll('country_list', array(), 'country_name', 'asc');

			$data['content'] = "instituteInfo/institute_info_content";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function instituteInfoSave() {
		$this->load->library('upload');

		//$id = inputFunction('id');
		$id = $this->session->userdata("company_id");

		$data['company_name'] 				= inputFunction('company_name');
		$data['short_name'] 				= inputFunction('short_name');
		$data['address'] 					= inputFunction('address');
		$data['email'] 						= inputFunction('email');
		$data['email_or_phone'] 			= inputFunction('email_or_phone');
		$data['phone_no'] 					= inputFunction('phone_no');
		$data['chif_name'] 					= inputFunction('chif_name');
		$data['a_chif_name'] 				= inputFunction('a_chif_name');
		$data['country_id'] 				= inputFunction('country_id');

		$ledgerDataExist = $this->M_join->ledgerDataExist();
		if(empty($ledgerDataExist)) {
			$data['financial_year_from'] 	= inputFunction('financial_year_from');
			$data['financial_year_end'] 	= inputFunction('financial_year_end');
			$data2 = array(
				"company_id" 			=> $this->session->userdata("company_id"),
				"financial_year_from" 	=> $data['financial_year_from'],
				"financial_year_end" 	=> $data['financial_year_end'],
				"user_id" 				=> $this->session->userdata('app_userid')
			); 
			$fyList = $this->M_crud->findAll("financial_year_list", array("company_id" => $id), 'id', 'asc');
			if(empty($fyList)) {
				$this->db->insert("financial_year_list", $data2);
			} else {
				$this->db->update("financial_year_list", $data2, array("company_id" => $id));
			}
		} 

		// File upload system Start
		$config['upload_path'] 		= 'data/img/common/';
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '0';
		$config['file_name']		= time();
		$file_field					= 'logo';
		
		$this->upload->initialize($config);
		if($this->upload->do_upload($file_field)) {
		    $uploadData 		= $this->upload->data();
		    $data['logo'] 		= $uploadData['file_name'];
		    $data['fab_icon'] 	= $uploadData['file_name'];

		    if(!empty($id)){
				if($data['logo']) {
	                $userImageData = $this->M_crud->findById('company_register_table', array('id' =>$id)); 
					if(!empty($userImageData->logo)) {
						unlink('data/img/common/'.$userImageData->logo);
					}
	            }
	        }
		}
		// File upload system End
		
		if(!empty($id)){
			$this->db->update('company_register_table', $data, array('id' => $id));
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::UpdateMsg));
		} else {
		    $last_insert_id = $this->db->insert('company_register_table', $data);
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::InsertMsg));
		}
		redirect($this->agent->referrer());
		//redirect("user/login");
	}

	public function createCompany($onset = 0) {
		$this->load->library('pagination');

		$data['title'] 		= 'New Company Create';
		$data['success'] 	= sessionData('success');
		$data['messege'] 	= sessionData('messege');
						   	  $this->session->set_userdata(array('success' => '','messege'=> ''));

		//$data['comData'] 	= $this->M_crud->findById('company_register_table', array('id' => $this->session->userdata('company_id')));
		$data['country_list'] 	= $this->M_crud->findAll('country_list', array(), 'country_name', 'asc');

		$data['list'] 	= $this->M_crud->findAllForPagination("company_register_table", array(), "id", "desc", $onset, 20);

		$data['onset'] 			= $onset;
		$config['base_url'] 	= base_url('instituteInfo/createCompany/');
		$config['total_rows'] 	= $this->M_crud->countAll('company_register_table', array());
		$config['uri_segment'] 	= 3;
		$config['per_page'] 	= 20;
		$config['num_links'] 	= 7;
		$config['first_link']	= FALSE;
		$config['last_link'] 	= FALSE;
		$config['prev_link']	= 'Prev';
		$config['next_link'] 	= 'Next'; 
		$this->pagination->initialize($config);

		$data['content'] = "instituteInfo/companyCreatePage";
		$this->load->view('app/dashboardPage', $data);	
	}

	public function getCompanyData($id = 0) {
		$data = $this->M_crud->findById("company_register_table", array('id' => $id));

		echo json_encode($data);
	}

	public function newCompanySave() {
		$this->load->library('upload');

		$id = inputFunction('id');

		$data['company_name'] 				= inputFunction('company_name');
		$data['short_name'] 				= inputFunction('short_name');
		$data['address'] 					= inputFunction('address');
		$data['email'] 						= inputFunction('email');
		$data['email_or_phone'] 			= inputFunction('email_or_phone');
		$data['phone_no'] 					= inputFunction('phone_no');
		$data['chif_name'] 					= inputFunction('chif_name');
		$data['a_chif_name'] 				= inputFunction('a_chif_name');
		$data['country_id'] 				= inputFunction('country_id');

		$ledgerDataExist = $this->M_join->ledgerDataExist();
		if(empty($ledgerDataExist)) {
			$data['financial_year_from'] 	= inputFunction('financial_year_from');
			$data['financial_year_end'] 	= inputFunction('financial_year_end');
			$data2 = array(
				"company_id" 			=> $this->session->userdata("company_id"),
				"financial_year_from" 	=> $data['financial_year_from'],
				"financial_year_end" 	=> $data['financial_year_end'],
				"user_id" 				=> $this->session->userdata('app_userid')
			); 
			$fyList = $this->M_crud->findAll("financial_year_list", array("company_id" => $id), 'id', 'asc');
			if(empty($fyList)) {
				$this->db->insert("financial_year_list", $data2);
			} else {
				$this->db->update("financial_year_list", $data2, array("company_id" => $id));
			}
		} 

		// File upload system Start
		$config['upload_path'] 		= 'data/img/common/';
		$config['allowed_types'] 	= '*';
		$config['max_size']			= '0';
		$config['file_name']		= time();
		$file_field					= 'logo';
		
		$this->upload->initialize($config);
		if($this->upload->do_upload($file_field)) {
		    $uploadData 		= $this->upload->data();
		    $data['logo'] 		= $uploadData['file_name'];
		    $data['fab_icon'] 	= $uploadData['file_name'];

		    if(!empty($id)){
				if($data['logo']) {
	                $userImageData = $this->M_crud->findById('company_register_table', array('id' =>$id)); 
					if(!empty($userImageData->logo)) {
						unlink('data/img/common/'.$userImageData->logo);
					}
	            }
	        }
		}
		// File upload system End
		
		if(!empty($id)){
			$this->db->update('company_register_table', $data, array('id' => $id));
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::UpdateMsg));
		} else {
		    $last_insert_id = $this->db->insert('company_register_table', $data);
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::InsertMsg));
		}
		redirect($this->agent->referrer());
		//redirect("user/newUserAdd");
	}
	

	
	
}
