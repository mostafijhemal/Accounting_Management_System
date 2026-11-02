<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class App_user_manage extends CI_Controller {
	const Title	 	= 'App';
	const InsertMsg = 'Insert Successfully';
	const UpdateMsg = 'Update Successfully';
	const DeleteMsg = 'Deleted Successfully';
	
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
		$data['title'] 		= 'User Manage';
		if (checkUserAccess()) {
			$data['success'] 	= sessionData('success');
			$data['messege'] 	= sessionData('messege');
							   	  $this->session->set_userdata(array('success' => '','messege'=> ''));

			$data['user_type'] = $this->M_crud->findAll('user_type', array('status' => 'active', 'id !=' => 3), 'serial', 'asc');
			$data['user_data'] = $this->M_crud->findAll('app_user', array('company_id' => $this->session->userdata('company_id'), 'user_type_id !=' => 3), 'id', 'desc');
			$data['content'] = "app_user/userPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}


	public function checkLoginNameForUnic() {
		$id 		= inputFunction('id');
		$login_name = inputFunction('login_name');

		$data = $this->M_crud->findById('app_user', array('id !=' => $id, 'login_name' => $login_name));
		echo json_encode($data);
	}


	public function checkEmailForUnic() {
		$id 	= inputFunction('id');
		$email 	= inputFunction('email');

		$data = $this->M_crud->findById('app_user', array('id !=' => $id, 'email' => $email));
		echo json_encode($data);
	}


	public function userDataStore() {
		if (checkUserAccess()) {
			$this->load->library('upload');

	        $id	= $this->input->post('id');

	        $pp = blockScript($this->input->post('password'));
	        if(!empty($id)) {
		        if(empty($pp)) {
		        	$ppData = $this->M_crud->findById('app_user', array('id' => $id))->password;
		        } else {
		        	$ppData = md5($pp);
		        }
	        } else {
	        	$ppData = md5($pp);
	        }
			
			$data['app_user_auto_id'] 	= sessionData('app_userid');
			$data['company_id'] 		= $this->session->userdata('company_id');
			$data['full_name'] 			= blockScript($this->input->post('full_name'));
			$data['login_name'] 		= blockScript($this->input->post('login_name'));
			$data['password'] 			= $ppData;
			$data['designition']		= blockScript($this->input->post('designition'));
			$data['email'] 				= blockScript($this->input->post('email'));
			$data['cell'] 				= blockScript($this->input->post('cell'));
			$data['present_address'] 	= blockScript($this->input->post('present_address'));
			$data['permanent_address'] 	= blockScript($this->input->post('permanent_address'));
			$data['status'] 			= blockScript($this->input->post('status'));
			$data['user_type_id'] 		= blockScript($this->input->post('user_type_id'));

			// File upload system Start
			$config['upload_path'] 		= 'data/images/upload/app_user/';
			$config['allowed_types'] 	= "*";
			$config['max_size']			= "0";
			$config['file_name']		= time();
			$file_field					= 'image';
			
			$this->upload->initialize($config);
			if($this->upload->do_upload($file_field)) {
			    $uploadData = $this->upload->data();
			    $data['image'] = $uploadData['file_name'];

			    if(!empty($editId)){
					if($data['image']) {
		                $userImageData = $this->M_crud->findById('app_user', array('id' =>$editId)); 
						if(!empty($userImageData->image)) {
							unlink('data/images/upload/app_user/'.$userImageData->image);
						}
		            }
		        }
			}
			// File upload system End

			if(!empty($id)){
				$data['update_at']   = date("Y-m-d h:i:s");
				$this->db->update('app_user', $data, array('id' => $id));
				$this->session->set_userdata(array('success' => 'Success', 'messege' => self::UpdateMsg));
			} else {
				$data['create_at']   = date("Y-m-d h:i:s");
				$this->db->insert('app_user', $data);
				$this->session->set_userdata(array('success' => 'Success', 'messege' => self::InsertMsg));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}

		redirect($this->agent->referrer());
	}


	/*public function delete($id) {
		$this->db->delete('app_user', array('id' => $id));
	}*/


	public function controllerDataLoadForEdit() {
		$id = blockScript($this->input->post('id'));

		$data = $this->M_crud->findById('app_user', array('id' => $id));

		echo json_encode($data);
	}


	public function accessRulePageLoad() {
		$this->load->model('M_admin');
		$data['title'] = 'User Access Manage';
		if (checkUserAccess()) {
			$data['success'] = sessionData('success');
			$data['messege'] = sessionData('messege');
							   $this->session->set_userdata(array('success' => '','messege'=> ''));
			

			$data['comList'] = $this->db->query("SELECT id, concat(company_name, ' - ', ifnull(short_name, substr(company_name,1,3))) name from company_register_table where status = 'active'")->result();
			$comId = sessionData('company_id');
			$where = "company_id = $comId and user_type_id != 1 and user_type_id != 3";
			$data['userList']= $this->M_crud->findAll('app_user', $where, 'full_name', 'asc');
			$data['controllerList'] = $this->M_admin->getAllControllerList();
			$data['content'] = "app_user/userAccessPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}


	public function accessRuleDataSave() {
		if (checkUserAccess()) {
			if ($this->session->userdata("app_user_type_id") == 3) {
				$company_id = blockScript($this->input->post('company_id'));
			} else {
				$company_id = $this->session->userdata('company_id');
			}
			$user_id 		= blockScript($this->input->post('user_id'));
			$controller_id 	= $this->input->post('controller_id');
			$access_status 	= $this->input->post('access_status');

			$this->db->delete('access_list', array('user_id' => $user_id));

			$j = 0;
			foreach ($controller_id as $i => $v) {
				$data[$j]['company_id'] 	= $company_id;
				$data[$j]['controller_id'] 	= blockScript($controller_id[$i]);
				$data[$j]['user_id'] 		= $user_id;
				$data[$j]['access_status'] 	= blockScript($access_status[$i]);
				$data[$j]['admin_id'] 		= $this->session->userdata('app_userid');

				$j++;
			}

			$this->db->insert_batch('access_list', $data);
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::InsertMsg));
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this page is not allowed for you"));
		}
		redirect($this->agent->referrer());
	}

	public function allUserAccessList($onset = 0) {
		$this->load->library('pagination');
		$this->load->model('M_admin');

		$comId = $this->session->userdata('company_id');

		$data['title'] = 'User Access List';
		if (checkUserAccess()) {
			$data['success'] = sessionData('success');
			$data['messege'] = sessionData('messege');
							   $this->session->set_userdata(array('success' => '','messege'=> ''));

			$uTypeId = $this->session->userdata('app_user_type_id');
			if($uTypeId == 1 || $uTypeId == 3) {
				if($uTypeId == 1) {
					//$w = array('app_user.status' => 'active', 'app_user.user_type_id !=' => 1, 'app_user.user_type_id !=' => 3, 'app_user.company_id' => $this->session->userdata('company_id'));

					$w = "app_user.status = 'active' and app_user.company_id = $comId and app_user.user_type_id NOT IN (1,3)";
				} else if($uTypeId == 3) {
					//$w = array('app_user.status' => 'active', 'app_user.user_type_id !=' => 1, 'app_user.user_type_id !=' => 3);
					$w = "app_user.status = 'active' and app_user.user_type_id NOT IN (1,3)";
				}
				//$data['user_data'] = $this->M_crud->findAll('app_user', $w, 'full_name', 'asc');

				$data['user_data'] 	= $this->M_join->findAllUserPagination($w, "full_name asc", $onset, 20);

				//echo $this->db->last_query(); exit();

				$data['onset'] 			= $onset;
				$config['base_url'] 	= base_url('app_user_manage/allUserAccessList/');
				$config['total_rows'] 	= $this->M_crud->countAll('app_user', array());
				$config['uri_segment'] 	= 3;
				$config['per_page'] 	= 20;
				$config['num_links'] 	= 7;
				$config['first_link']	= FALSE;
				$config['last_link'] 	= FALSE;
				$config['prev_link']	= 'Prev';
				$config['next_link'] 	= 'Next'; 
				$this->pagination->initialize($config);

				$data['content'] = "app_user/allUserListPage";
			} else {
				$data['userData'] = $this->M_crud->findById('app_user', array('id' => sessionData('app_userid')));
				$data['controllerList'] = $this->M_admin->getAllAUserAccessList(array('user_id' => $this->session->userdata('app_userid')));
				$data['content'] = "app_user/userAccessListPage";
			}
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}


	public function accessListVuew($id=0) {
		$this->load->model('M_admin');
		$data['title'] = 'User Access List';

		$data['userData'] = $this->M_crud->findById('app_user', array('id' => $id));
		$data['controllerList'] = $this->M_admin->getAllAUserAccessList(array('user_id' => $id));
		$data['content'] = "app_user/userAccessListPage";
		$this->load->view('app/dashboardPage', $data);
	}



	public function systemUserCreate($onset = 0) {
		$this->load->library('pagination');

		$data['title'] 		= 'User Create';
		if ($this->session->userdata("app_user_type_id") == 3) {
			$data['success'] 	= sessionData('success');
			$data['messege'] 	= sessionData('messege');
							   	  $this->session->set_userdata(array('success' => '','messege'=> ''));

			$data['user_type'] = $this->M_crud->findAll('user_type', array('status' => 'active'), 'serial', 'asc');
			$data['comList'] = $this->db->query("SELECT id, concat(company_name, ' - ', ifnull(short_name, substr(company_name,1,3))) name from company_register_table where status = 'active'")->result();

			//$data['user_data'] = $this->M_crud->findAll('app_user', array('company_id' => $this->session->userdata('company_id')), 'id', 'desc');

			$data['user_data'] 	= $this->M_join->findAllUserPagination(array(), "id asc", $onset, 20);

			$data['onset'] 			= $onset;
			$config['base_url'] 	= base_url('app_user_manage/systemUserCreate/');
			$config['total_rows'] 	= $this->M_crud->countAll('app_user', array());
			$config['uri_segment'] 	= 3;
			$config['per_page'] 	= 20;
			$config['num_links'] 	= 7;
			$config['first_link']	= FALSE;
			$config['last_link'] 	= FALSE;
			$config['prev_link']	= 'Prev';
			$config['next_link'] 	= 'Next'; 
			$this->pagination->initialize($config);

			$data['content'] = "app_user/systemUserCreatePage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}


	public function userDataStoreBySystem() {
		$this->load->library('upload');

        $id	= $this->input->post('id');
        $pp = blockScript($this->input->post('password'));
        if(!empty($id)) {
	        if(empty($pp)) {
	        	$ppData = $this->M_crud->findById('app_user', array('id' => $id))->password;
	        } else {
	        	$ppData = md5($pp);
	        }
        } else {
        	$ppData = md5($pp);
        }
		
		$data['app_user_auto_id'] 	= sessionData('app_userid');
		$data['company_id'] 		= blockScript($this->input->post('company_id'));
		$data['full_name'] 			= blockScript($this->input->post('full_name'));
		$data['login_name'] 		= blockScript($this->input->post('login_name'));
		$data['password'] 			= $ppData;
		$data['designition']		= blockScript($this->input->post('designition'));
		$data['email'] 				= blockScript($this->input->post('email'));
		$data['cell'] 				= blockScript($this->input->post('cell'));
		$data['present_address'] 	= blockScript($this->input->post('present_address'));
		$data['permanent_address'] 	= blockScript($this->input->post('permanent_address'));
		$data['status'] 			= blockScript($this->input->post('status'));
		$data['user_type_id'] 		= blockScript($this->input->post('user_type_id'));

		// File upload system Start
		$config['upload_path'] 		= 'data/images/upload/app_user/';
		$config['allowed_types'] 	= "*";
		$config['max_size']			= "0";
		$config['file_name']		= time();
		$file_field					= 'image';
		
		$this->upload->initialize($config);
		if($this->upload->do_upload($file_field)) {
		    $uploadData = $this->upload->data();
		    $data['image'] = $uploadData['file_name'];

		    if(!empty($editId)){
				if($data['image']) {
	                $userImageData = $this->M_crud->findById('app_user', array('id' =>$editId)); 
					if(!empty($userImageData->image)) {
						unlink('data/images/upload/app_user/'.$userImageData->image);
					}
	            }
	        }
		}
		// File upload system End

		if(!empty($id)){
			$data['update_at']   = date("Y-m-d h:i:s");
			$this->db->update('app_user', $data, array('id' => $id));
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::UpdateMsg));
		} else {
			$data['create_at']   = date("Y-m-d h:i:s");
			$this->db->insert('app_user', $data);
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::InsertMsg));
		}

		redirect($this->agent->referrer());
	}


	public function getUserList() {
		$company_id = blockScript($this->input->post('company_id'));

		$where = "company_id = $company_id and user_type_id != 1 and user_type_id != 3";
		$list = $this->M_crud->findAll('app_user', $where, 'full_name', 'asc');

		echo '<option value="">Select One</option>';
		if (!empty($list)) {
			foreach ($list as $v) {
				echo '<option value="'.$v->id.'">'.$v->full_name.'</option>';
			}
		}


	}








}
