<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class App_menu extends CI_Controller {
	const  Title	 = 'App';
	const  InsertMsg = 'Insert Successfully';
	const  UpdateMsg = 'Update Successfully';
	const  DeleteMsg = 'Delete Successfully';
	
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
		/*$data['title'] 				= self::Title.' - Dashboard';
		$data['meta_description'] 	= '';
		$data['meta_keywords'] 		= '';
		$data['content'] = "dashboard_content";
		$this->load->view('dashboardPage', $data);*/
	}

	public function menu($menuId = ''){
		$data['title'] 		= 'Menu Manage';
		$data['success'] 	= sessionData('success');
		$data['messege'] 	= sessionData('messege');
						   	  $this->session->set_userdata(array('success' => '','messege'=> ''));

		//$where = array('status' => "active");
        if($menuId != 'NULL'){
           $where['menu_id'] 	= $menuId; 
           $data['menu_id']  	= $menuId; 
        }else{
        	$where['menu_id'] 	= NULL;
            $data['menu_id']  	= NULL; 
        } 
        
		$data['menuInfo'] 	= $this->M_crud->findAll('menu_list', $where, 'order', 'asc');
		$data['msg']		= $this->session->userdata('msg');
		$this->session->set_userdata(array('msg' => ""));

		$data['content'] = "app_menu/menuPage";
		$this->load->view('app/dashboardPage', $data);
	}



	public function menuStore() {
        $editId		= $this->input->post('editId');

        $menu_id    = $this->input->post('menu_id');

        if(!empty($menu_id)){
        	echo $data['menu_id'] = $menu_id;        	
        } else {
        	echo $data['menu_id'] = NULL;
        }
		
		$data['order'] 		= $this->input->post('order');
		$data['menu_name'] 	= $this->input->post('menu_name');

		$menu_link 			= $this->input->post('menu_link');
		if($menu_link == ''){
			$link = '#';
		} else if($menu_link == '#') {
			$link = '#';
		} else {
			$exploadMenuLink = explode('/', $menu_link);
			if(empty($exploadMenuLink[1])){
				$link = $exploadMenuLink[0].'/';
			} else {
				$link = $menu_link;
			}
		}
		$data['menu_link'] 	= $link;

		if($link == '#'){
			$data['position_status'] 	= 'parents';
		} else {
			$data['position_status'] 	= 'child';
		}
		
		$data['menu_icon'] 	= $this->input->post('menu_icon');
		$data['status'] 	= $this->input->post('status');
		$data['target'] 	= $this->input->post('target');

		

		if(!empty($editId)){
			$data['update_at']   = date("Y-m-d h:i:s");
			$this->db->update('menu_list', $data, array('id' => $editId));
		    $lastMenuId 		= $editId;
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::UpdateMsg));
			//$this->session->set_userdata(array('msg' => self::UpdateMsg));
			//redirect('app_menu/menu/'.$listId.'?updatestatus=success');
		} else {
			$data['create_at'] 	= date("Y-m-d h:i:s");
		    $lastMenuId 		= $this->M_crud->save('menu_list', $data);
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::InsertMsg));
			//$this->session->set_userdata(array('msg' => self::InsertMsg));
			//redirect('app_menu/menu/'.$listId.'?popup=1&status=success');
		}

		redirect($this->agent->referrer());

	}

	public function menuDataLoadForEdit() {
		$id = inputFunction('id');
		$menuData 		= $this->M_crud->findById('menu_list', array('id' => $id));
		$menu_exist = $this->M_crud->findAllColumn(array('id'), 'menu_list', array('menu_id' =>$menuData->id), 'order', 'asc');

		$data = array('menuData' => $menuData, 'menu_exist' => $menu_exist);
		echo json_encode($data);
	}

	public function delete($id) {
		$this->db->delete('menu_list', array('id' => $id));
	}

	public function controller(){
		$data['title'] 		= 'Controller Create Page';
		$data['success'] 	= sessionData('success');
		$data['messege'] 	= sessionData('messege');
						   	  $this->session->set_userdata(array('success' => '','messege'=> ''));
        
		$data['list'] 	= $this->M_crud->findAll('controller_list', array(), 'controller_name', 'asc');

		$data['content'] = "app_menu/controllerCreatePage";
		$this->load->view('app/dashboardPage', $data);
	}

	public function controllerStore() {
		$id = blockScript($this->input->post('id'));


		$data['controller_name']= blockScript($this->input->post('controller_name'));
		$data['function_name'] 	= blockScript($this->input->post('function_name'));
		$data['url_link'] 		= blockScript($this->input->post('url_link'));
		$data['title_text'] 	= blockScript($this->input->post('title_text'));
		$data['detail'] 		= blockScript($this->input->post('detail'));

		if(!empty($id)){
			$this->db->update('controller_list', $data, array('id' => $id));
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::UpdateMsg));
		} else {
		    $this->M_crud->save('controller_list', $data);
			$this->session->set_userdata(array('success' => 'Success', 'messege' => self::InsertMsg));
		}

		redirect($this->agent->referrer());
	}

	public function controllerDataLoadForEdit() {
		$id = blockScript($this->input->post('id'));

		$data = $this->M_crud->findById('controller_list', array('id' => $id));

		echo json_encode($data);
	}

	public function controllerDelete($id = 0) {
		$this->db->delete('controller_list', array('id' => $id));
	}











}
