<?php

	class M_admin extends CI_Model {
	
		const TABLE	= '';
	
		public function __construct() {
			parent::__construct();
		}
		
		public function findByUserName($table, $where) {
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->row();
		}

		public function getUserAccessData($where) {
			$data = $this->db->select('access_list.*')
				->select('controller_list.controller_name,function_name')
				->from('access_list')
				->join('controller_list', 'access_list.controller_id = controller_list.id', 'left')
				->where($where)
				->get()->row();
				
			return $data;
		}

		public function getAllControllerList($where = array()) {
			$result = $this->db->select("controller_list.*")
				->from("controller_list")
				->where($where)
				->order_by("controller_list.controller_name, controller_list.function_name, controller_list.title_text")
				->get()->result();

			return $result;
		}

		public function getAllAUserAccessList($where = array()) {
			$result = $this->db->select("controller_list.*")
				->select("access_list.access_status")
				->from("controller_list")
				->join('access_list', 'controller_list.id = access_list.controller_id', 'left')
				->where($where)
				->order_by("controller_list.controller_name, controller_list.function_name, controller_list.title_text")
				->get()->result();

			return $result;
		}


		
			
	}
