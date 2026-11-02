<?php
class M_crud extends CI_Model {
	const TABLE	= '';

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
	public function findAllGroupByColumn($column, $table, $where, $groupBy, $orderBy, $serialized) {
		$this->db->select($column);
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($orderBy, $serialized);
		$this->db->group_by($groupBy);
		$query = $this->db->get();
		return $query->result();
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

	public function sumWithMultiplication($table, $where, $sumField, $multiField) {
		$this->db->select('sum('.$sumField.'*'.$multiField.') as totalValue', FAlSE);
		$this->db->from($table);
		$this->db->where($where);
		$query = $this->db->get();
		return $query->row()->totalValue;
	}






	
	/* Inventory query start */


	public function findAllWarehouseWiseItemInfo($table, $where, $orderBy, $serialized, $onset, $limit) {
		$info = $this->findAllForPagination($table, $where, $orderBy, $serialized, $onset, $limit);
		foreach ($info as $v) {
			$v->productList  = $this->M_join->warehouseProductJoin('in_warehouse_item_manage', $where = array('warehouse_id' => $v->id, 'in_warehouse_item_manage.company_id' => $v->company_id), 'pro_id', 'asc');
		}
		
		return $info;
	}



	public function findAllPurPaymentInfo($table, $where, $orderBy, $serialized) {
		$info = $this->findAll($table, $where, $orderBy, $serialized);
		foreach ($info as $v) {
			$v->paidAmount  = $this->sum('in_pur_order_bill_payment', $where = array('pur_id' => $v->id, 'bill_status !=' => 'canceled'), 'paid_amount');
		}
		
		return $info;
	}

	public function findAllPurPaymentEditInfo($table, $where, $orderBy, $serialized, $bill_no) {
		$info = $this->findAll($table, $where, $orderBy, $serialized);
		foreach ($info as $v) {
			$v->paidAmount  	= $this->sum('in_pur_order_bill_payment', $where = array('pur_id' => $v->id, 'bill_no !=' => $bill_no, 'bill_status !=' => 'canceled'), 'paid_amount');
			$v->paidEditAmount  = $this->sum('in_pur_order_bill_payment', $where = array('pur_id' => $v->id, 'bill_no' => $bill_no, 'bill_status !=' => 'canceled'), 'paid_amount');
		}
		
		return $info;
	}

	public function findAllSellPaymentColEditInfo($table, $where, $orderBy, $serialized, $bill_no) {
		$info = $this->findAll($table, $where, $orderBy, $serialized);
		foreach ($info as $v) {
			$v->paidAmount  	= $this->sum('in_party_paid_info', $where = array('sell_id' => $v->id, 'bill_no !=' => $bill_no, 'bill_status !=' => 'canceled'), 'paid_amount');
			$v->paidEditAmount  = $this->sum('in_party_paid_info', $where = array('sell_id' => $v->id, 'bill_no' => $bill_no, 'bill_status !=' => 'canceled'), 'paid_amount');
		}
		
		return $info;
	}





	public function findByIdMultiOrder($table, $where, $order)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where, NULL, FALSE);
		$this->db->order_by($order);
		$query = $this->db->get();
		return $query->row();
	}

	public function findByIdWithOrder($table, $where, $order)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($where);
		$this->db->order_by($order);
		$query = $this->db->get();
		return $query->row();
	}


	public function findAllSellPaymentInfo($table, $where, $orderBy, $serialized) {
		$info = $this->findAll($table, $where, $orderBy, $serialized);
		foreach ($info as $v) {
			$v->paidAmount  = $this->sum('in_party_paid_info', $where = array('sell_id' => $v->id, 'bill_status !=' => 'canceled'), 'paid_amount');
		}
		
		return $info;
	}


  // party ledger report 

	public function findPartyLedger($where, $party_type, $party_id, $fromDate, $toDate, $serialized = 'invoice_date asc')
	{

		$warehouse_id           = $this->session->userdata('warehouse_auto_id');
		$company_id             = $this->session->userdata('company_id');
		$userTypeId             = $this->session->userdata('app_user_type_id'); 

		// sell info data
		
		$where1                  = "party_type = '$party_type' AND party_id = '$party_id'  AND company_id='$company_id' AND invoice_date >= '$fromDate' AND invoice_date <= '$toDate' AND sell_status != 'cancel'";
		if($userTypeId !=1)     $where1  .= " AND (warehouse_id ='$warehouse_id' OR warehouse_id IS NULL)";
	
		$this->db->select("'INV' as prefix_inv, sell_status as status, invoice_no, invoice_date, 'in_sell_manage' as table_name, net_total, id as unique_id, note as remarks");
		$this->db->from('in_sell_manage');
		$this->db->where($where1);
		$this->db->get(); 
		$query1 = $this->db->last_query();
		
		
		// sell return  

		$where2     = $where;

		if($fromDate) $where2['return_date >=']	= $fromDate;
		if($toDate)   $where2['return_date <=']	= $toDate;
		$this->db->select("'RN' as prefix_inv, 'return_status' as status, return_no as invoice_no, return_date as invoice_date, 'in_sell_return_info' as table_name, return_amount as net_total, id as unique_id, remarks");
		$this->db->from('in_sell_return_info');
		$this->db->where($where2);
		$this->db->get(); 
		$query2 = $this->db->last_query();

		// payment info  

		$where3                  = "party_type = '$party_type' AND party_id = '$party_id'  AND company_id='$company_id' AND collection_date >= '$fromDate' AND collection_date <= '$toDate' AND bill_status = 'approved'";
		if($userTypeId !=1)     $where3  .= " AND (warehouse_id ='$warehouse_id' OR warehouse_id IS NULL)";
		
		$this->db->select("'BC' as prefix_inv, bill_status as status, bill_no as invoice_no, collection_date as invoice_date, 'in_party_paid_info' as table_name, 	paid_amount as net_total, bill_no as unique_id, paid_purpose as remarks");
		$this->db->from('in_party_paid_info');
		$this->db->where($where3);
	    $this->db->group_by('bill_no');
		$this->db->get();
		$query3 =  $this->db->last_query();


		//  return collection

		$where4     = $where;

		if($fromDate) $where4['payment_date >=']	= $fromDate;
		if($toDate)   $where4['payment_date <=']	= $toDate;
		$this->db->select("'PN' as prefix_inv, 'payment_status' as status, pay_no as invoice_no, payment_date as invoice_date, 'in_return_amount_payment_info' as table_name, paid_amount as net_total, id as unique_id, remarks");
		$this->db->from('in_return_amount_payment_info');
		$this->db->where($where4);
		$this->db->get(); 
		$query4 = $this->db->last_query();

		
		$query = $this->db->query($query1." UNION ALL ".$query2." UNION ALL ".$query3." UNION ALL ".$query4." order by ".$serialized);
		
		return $query->result();
	}

	// vendor ledger report

	public function findVendorLedger($where, $vendor_id, $fromDate, $toDate, $serialized = 'invoice_date asc')
	{

		$warehouse_id           = $this->session->userdata('warehouse_auto_id');
		$company_id             = $this->session->userdata('company_id');
		$userTypeId             = $this->session->userdata('app_user_type_id'); 


		// purchase info 
		$where1                  = "vendor_id = '$vendor_id' AND company_id='$company_id' AND pur_date >= '$fromDate' AND pur_date <= '$toDate' AND order_status != 'cancel'";

		if($userTypeId !=1)     $where1  .= " AND (warehouse_id ='$warehouse_id' OR warehouse_id IS NULL)";
		
		
		$this->db->select("'PO' as prefix_inv, order_status as status,  pur_no as invoice_no, pur_date as invoice_date, 'in_purchase_info' as table_name, net_amount, id as unique_id, note as remarks");
		$this->db->from('in_purchase_info');
		$this->db->where($where1);
		$this->db->get(); 
		$query1 = $this->db->last_query();


		// purchase return info 

		$where2	= $where;
		if($fromDate) $where2['return_date >=']	= $fromDate;
		if($toDate) $where2['return_date <=']	= $toDate;
		
		$this->db->select("'RN' as prefix_inv, 'return_status' as status, return_no as invoice_no, return_date as invoice_date, 'in_purchase_return_info' as table_name, return_amount as net_amount, id as unique_id, remarks");
		$this->db->from('in_purchase_return_info');
		$this->db->where($where2);
		$this->db->get(); 
		$query2 = $this->db->last_query();

		// purchase bill payment

		$where3                  = "vendor_id = '$vendor_id' AND company_id='$company_id' AND bill_date >= '$fromDate' AND bill_date <= '$toDate' AND bill_status = 'approved'";

		if($userTypeId !=1)     $where3  .= " AND (warehouse_id ='$warehouse_id' OR warehouse_id IS NULL)";

		
		$this->db->select("'BP' as prefix_inv, bill_status as status,  bill_no as invoice_no, bill_date as invoice_date, 'in_pur_order_bill_payment' as table_name, paid_amount as net_amount,  bill_no as unique_id, paid_purpose as remarks");
		$this->db->from('in_pur_order_bill_payment');
		$this->db->where($where3);
	    $this->db->group_by('bill_no');
		$this->db->get();
		$query3 =  $this->db->last_query();

		// purchase refund collection 

		$where4	= $where;
		if($fromDate) $where4['ref_collection_date >=']	= $fromDate;
		if($toDate) $where4['ref_collection_date <=']	= $toDate;
		
		$this->db->select("'BC' as prefix_inv, 'collection_status' as status, collection_no as invoice_no, ref_collection_date as invoice_date, 'in_refund_amount_collection' as table_name, ref_collection_amount as net_amount, id as unique_id, remarks");
		$this->db->from('in_refund_amount_collection');
		$this->db->where($where4);
		$this->db->get(); 
		$query4 = $this->db->last_query();

		
		$query = $this->db->query($query1." UNION ALL ".$query2." UNION ALL ".$query3." UNION ALL ".$query4." order by ".$serialized);
		
		return $query->result();
	}












		








































			
		public function sendMessageProcessBB($receiver_phone, $message = "", $reciver_name = "", $humanType = "", $module_name = "") {
			$length	= strlen($receiver_phone);
			if($length == 10) {
				$mobile	= '880'.$receiver_phone;
			} else if($length == 11){
				$mobile	= '88'.$receiver_phone;
			} else {
				$mobile	= $receiver_phone;
			}
			
			
			$soapClient = new SoapClient("https://api2.onnorokomsms.com/sendsms.asmx?wsdl");
			$paramArray = array(
			'userName'=>"01677543665",
			'userPassword'=>"96831",
			'mobileNumber'=> $mobile,
			'smsText'=>$message,
			'type'=>"TEXT",
			'maskName'=> "Medhakunja",
			'campaignName'=>'Medhakunja',
			);
			$value = $soapClient->__call("OneToOne", array($paramArray));
			
			$response	= explode("||", $value->OneToOneResult);
			//print_r($response);
			$responseCode	= $response[0];
			if($responseCode == 1900) {
					$returnMessage	= array('message' => "Message Send Successfully");
					$data['send_status']		= "Success ";
					$feedback					= 1;
			} else {
					$returnMessage	= array('message' => "Message Send Failed");
					$data['send_status']		= "Failed ";
					$feedback					= 0;
			}
			
			$data['message']			= $message;
			$data['reciver_name']		= $reciver_name;
			$data['human_type']			= $humanType;
			$data['reciever_phone_no']	= $mobile;
			$data['module_name']		= $module_name;
			$data['message_date']		= date('Y-m-d');
			$data['date_time']			= date('Y-m-d H:i:s');
			$this->db->insert('message', $data);
			return $feedback;
		}
		
		
		public function sendMessageProcess($receiver_phone, $message = "", $reciver_name = "", $humanType = "", $module_name = "") {
			$length	= strlen($receiver_phone);
			if($length == 10) {
				$mobile	= '880'.$receiver_phone;
			} else if($length == 11){
				$mobile	= '88'.$receiver_phone;
			} else {
				$mobile	= $receiver_phone;
			}
			
			$postUrl = "http://193.105.74.159/api/sendsms/xml";
      
			$xmlString =
			"<SMS>
			 <authentification>
			 <username>SAWEBSOFT</username>
			 <password>E6lQqr8M</password>
			 </authentification>
			 <message>
			 <sender>Medhakunja</sender>
			 <text>".$message."</text>
			 </message>
			 <recipients>
			 <gsm>".$mobile."</gsm>
			 </recipients>
			 </SMS>";    
		  
		   $fields = "XML=" . urlencode($xmlString); 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $postUrl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields); 
		
			$response = curl_exec($ch);
			
			$responseBody = json_decode($response);
			curl_close($ch);
   
			$data['message']			= $message;
			$data['reciver_name']		= $reciver_name;
			$data['human_type']			= $humanType;
			$data['reciever_phone_no']	= $mobile;
			$data['module_name']		= $module_name;
			$data['send_status']		= "";
			$data['message_date']		= date('Y-m-d');
			$data['date_time']			= date('Y-m-d H:i:s');
			$this->db->insert('message', $data);
			
			return $response;
		}

		public function calCulateSum($table, $where, $sumField)
		{
			$this->db->select_sum($sumField);
			$this->db->from($table);
			$this->db->where($where);
			$query = $this->db->get();
			return $query->row()->$sumField;
		}

		
	}
