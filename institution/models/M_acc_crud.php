<?php
class M_acc_crud extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	public function save($table, $data) {
		$this->db->insert($table, $data); 
		return $this->db->insert_id(); 
	}

	public function update($table, $data, $where) {
		$this->db->update($table, $data, $where);        
	}

	public function destroy($table, $where) {
		$this->db->delete($table, $where);        
	}
	
	public function findAll($table, $where = array(), $orderBy = 'id', $serialized = 'asc') {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy, $serialized);
		$query = $this->db->get();
		return $query->result();
	}

	public function findAllColumn($column, $table, $where, $orderBy='', $serialized='') {
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy, $serialized);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function findAllLimit($table, $where, $orderBy, $serialized, $limit) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy, $serialized);
		$this->db->limit($limit, 0); 
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function findAllColumnLimit($column, $table, $where, $orderBy, $serialized, $limit) {
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy, $serialized);
		$this->db->limit($limit, 0); 
		$query = $this->db->get();
		return $query->result();
	}
	
	public function findAllLimitGroupBy($table, $where, $orderBy, $serialized, $limit, $groupBy) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy, $serialized);
		$this->db->group_by($groupBy);
		$this->db->limit($limit, 0); 
		$query = $this->db->get();
		return $query->result();
	}

	public function findAllGroup($table, $where=array(), $groupBy, $orderBy='', $serialized='') {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->group_by($groupBy);
		$this->db->order_by($orderBy, $serialized);
		$query = $this->db->get();
		return $query->result();
	}

	public function findAllColumnGroup($column, $table, $where=array(), $groupBy, $orderBy='', $serialized='') {
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->group_by($groupBy);
		$this->db->order_by($orderBy, $serialized);
		$query = $this->db->get();
		return $query->result();
	}

	public function findAllGroupLimit($table, $where, $groupBy, $orderBy, $serialized, $limit) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->group_by($groupBy);
		$this->db->order_by($orderBy, $serialized);
		$this->db->limit($limit, 0); 
		$query = $this->db->get();
		return $query->result();
	}
	
	public function findById($table,$where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function columnFindById($column, $table, $where) {
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row();
	}

	public function findLastData($table, $where = array(), $orderBy, $serialized = 'desc') {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy, $serialized);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	public function findMax($table, $where, $fieldName) {
		$this->db->select_max($fieldName);
		$this->db->where($where);
		$result = $this->db->get($table); 
		return $result->row();
	}
	
	
	public function findAllForPagination($table, $where, $orderBy, $serialized, $onset, $limit) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy, $serialized);
		$this->db->limit($limit, $onset);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function countAll($table, $where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);			
		return $this->db->count_all_results();
	}
	

	public function findLastInsert($table, $where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->insert_id();
	}
	
	public function findTotal($table, $where) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();			
		return $query->num_rows();
	}


	public function sum($table, $where, $sumField) {
	   $this->db->select_sum($sumField);
	   $this->db->from($table);
	   $this->db->where($where);
	   $query = $this->db->get();
	   return $query->row()->$sumField;
	}




	

		

		
	}
