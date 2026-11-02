<?php

	class M_join extends CI_Model {
	
		const TABLE	= '';
	
		public function __construct() {
			parent::__construct();
		}

		// Accounting use accVoucher Controller function name is singleEntry
		public function findAllSingleEntryDate($company_id) {
			$query = $this->db->query("SELECT ld.id, CONCAT(ca.account_name, ' - ', ld.`account_id`) accountName, ld.narration, IFNULL(ld.debit, 0) debit, IFNULL(ld.credit, 0) credit, ld.opening_approve
				FROM acc_ledger_data ld 
				INNER JOIN acc_chart_of_accounts ca ON ca.account_id = ld.`account_id` AND ca.company_id = ld.`company_id`
				WHERE ld.`voucher_info_auto_id` IS NULL AND ld.`voucher_no` IS NULL AND ld.`company_id` = $company_id 
				ORDER BY ld.id ASC");

			return $query->result();
		}

		
	


		/*
		Sample Pass Data for joinOneTable
		$requireData = 'class_wise_info.*, class_list_manage.class_name', $where = array('class_wise_auto_id' => $cls->class_wise_auto_id), $orderBy = 'class_year', 'asc', $joinLeft1 = 'class_wise_info.class_id', $joinRight1 = 'class_list_manage.id',$return = 'row', $groupBy = "",  $limit = ""
		*/
		public function joinOneTable($requireData, $where, $orderBy, $serialized, $joinLeft1, $joinRight1, $return, $groupBy = "",  $limit = "")
		{
			
			$explode	= explode('.',$requireData);
			$explode1	= explode('.',$joinRight1);
			$table	= $explode[0];
			$table1	= $explode1[0];
			$this->db->select($requireData);
			$this->db->join($table1, $joinLeft1. ' = ' .$joinRight1, 'left');
			$this->db->from($table);
			$this->db->where($where);
			if($groupBy != "") $this->db->group_by($groupBy);
			if($limit != "") $this->db->limit($limit, 0); 
			$this->db->order_by($orderBy, $serialized);
			$query = $this->db->get();
			return $query->$return();
		}


		


		public function getRows() {
	        //Create a subquery and render it to a stirng
	        $sub = $this->db->select('number')->from('numbers')->where('numberID', 2)->_compile_select();
	        //Clear the data from the CI Arrays
	        $this->db->_reset_select();
	        //Build the main query passing in the sub-query and disabling backticks
	        $this->db->select("word,(" . $sub . ")", false)->where('wordID', 3);
	        //Get the results
	        $result = $this->get("words");
	    }


	    public function dashboardSammery($companyId='') {
	    	/*$row = $this->db->query("SELECT (
	    		SELECT ifnull(sum(ifnull(total_debit,0) - ifnull(total_credit,0)), 0) cashValue from acc_finance_table where account_id = 1010101 and company_id = $companyId and status = 'Active' ORDER BY id desc) totalCash, (
	    		SELECT ifnull(sum(ifnull(total_debit,0) - ifnull(total_credit,0)), 0) bankValue from acc_finance_table where substr(account_id,1,7) = 1010102 and company_id = $companyId and status = 'Active' ORDER BY id desc ) totalBank, (
	    		SELECT ifnull(sum(ifnull(total_debit,0) - ifnull(total_credit,0)), 0) expenseValue from acc_finance_table where substr(account_id,1,1) = 4 and substr(account_id,1,3) != 409 and company_id = $companyId and status = 'Active' ORDER BY id desc ) totalExpense, (
	    		SELECT ifnull(sum(ifnull(total_debit,0) - ifnull(total_credit,0)), 0) incomeValue from acc_finance_table where substr(account_id,1,1) = 3 and company_id = $companyId and status = 'Active' ORDER BY id desc ) totalIncome")
	    		->row();*/
	    		
	    	$row = $this->db->query("SELECT (
	    		SELECT ifnull(sum(ifnull(year_opening_debit,0) - ifnull(year_opening_credit,0)) +  sum(ifnull(total_debit,0) - ifnull(total_credit,0)), 0) cashValue from acc_finance_table where account_id = 1010101 and company_id = $companyId and status = 'Active' ORDER BY id desc) totalCash, (
	    		SELECT ifnull(sum(ifnull(year_opening_debit,0) - ifnull(year_opening_credit,0)) +  sum(ifnull(total_debit,0) - ifnull(total_credit,0)), 0) bankValue from acc_finance_table where substr(account_id,1,7) = 1010102 and company_id = $companyId and status = 'Active' ORDER BY id desc ) totalBank, (
	    		SELECT ifnull(sum(ifnull(year_opening_debit,0) - ifnull(year_opening_credit,0)) +  sum(ifnull(total_debit,0) - ifnull(total_credit,0)), 0) expenseValue from acc_finance_table where substr(account_id,1,1) = 4 and substr(account_id,1,3) != 409 and company_id = $companyId and status = 'Active' ORDER BY id desc ) totalExpense, (
	    		SELECT ifnull(sum(ifnull(year_opening_debit,0) - ifnull(year_opening_credit,0)) +  sum(ifnull(total_debit,0) - ifnull(total_credit,0)), 0) incomeValue from acc_finance_table where substr(account_id,1,1) = 3 and company_id = $companyId and status = 'Active' ORDER BY id desc ) totalIncome")
	    		->row();

	    	return $row;
	    }



	    public function ledgerDataExist() {
	    	$row = $this->db->select('id')
	    		->from("acc_ledger_data")
	    		->where("company_id", $this->session->userdata("company_id"))
	    		->order_by("id asc")
	    		->get()
	    		->row();

	    	return $row;
	    }

	    public function getRunningFinancialYear($company_id) {
	    	$row = $this->db->select('financial_year_from as from, financial_year_end as to,id')
	    		->from("financial_year_list")
	    		->where(array("company_id" => $company_id, 'status' => 'Active'))
	    		->order_by("id asc")
	    		->get()
	    		->row();

	    	return $row;
	    }

	    public function findAllUserPagination($where, $orderBy, $onset, $limit) {
			$this->db->select('app_user.*');
			$this->db->select('company_register_table.company_name');
			$this->db->from("app_user");
			$this->db->join("company_register_table", "app_user.company_id = company_register_table.id", "left");
			$this->db->where($where);
			$this->db->order_by($orderBy);
			$this->db->limit($limit, $onset);
			$query = $this->db->get();
			return $query->result();
		}

	    public function getFinancialYearList() {
	    	$row = $this->db->select("concat(financial_year_from,'_',financial_year_end) as yearList, status")
	    		->from("financial_year_list")
	    		->where("company_id", $this->session->userdata("company_id"))
	    		->order_by("id asc")
	    		->get()
	    		->result();

	    	return $row;
	    }


	    public function getAllVoucherList($where, $onset, $limit) {
	    	$result = $this->db->select('acc_voucher_info.*')
				->select('SUM(acc_voucher_details.debit) as totalVoucherAmount')
				->select('acc_voucher_type_list.type_name')
				->from("acc_voucher_info")
		        ->join('acc_voucher_details', 'acc_voucher_info.id = acc_voucher_details.voucher_info_auto_id', 'left')
		        ->join('acc_voucher_type_list', 'acc_voucher_info.voucher_type_auto_id = acc_voucher_type_list.id', 'left')
				->where($where)
				->group_by('acc_voucher_info.id')
				->order_by('acc_voucher_info.serial_no', 'asc')
				->limit($limit, $onset)
				->get()->result();

			return $result;
	    }


	    public function getSearchingVoucherList($where) {
	    	$result = $this->db->select('acc_voucher_info.*')
				->select('SUM(acc_voucher_details.debit) as totalVoucherAmount')
				->select('acc_voucher_type_list.type_name')
				->from("acc_voucher_info")
		        ->join('acc_voucher_details', 'acc_voucher_info.id = acc_voucher_details.voucher_info_auto_id', 'left')
		        ->join('acc_voucher_type_list', 'acc_voucher_info.voucher_type_auto_id = acc_voucher_type_list.id', 'left')
				->where($where)
				->group_by('acc_voucher_info.id')
				->order_by('acc_voucher_info.serial_no', 'asc')
				->get()->result();

			return $result;
	    }


	    public function lastVoucherList() {
	    	$result = $this->db->select('acc_voucher_info.*')
				->select('SUM(acc_voucher_details.debit) as totalVoucherAmount')
				->select('acc_voucher_type_list.type_name')
				->from("acc_voucher_info")
		        ->join('acc_voucher_details', 'acc_voucher_info.id = acc_voucher_details.voucher_info_auto_id', 'left')
		        ->join('acc_voucher_type_list', 'acc_voucher_info.voucher_type_auto_id = acc_voucher_type_list.id', 'left')
				->where(array("company_id" => $this->session->userdata("company_id"), 'approve_by !=' => NULL))
				->group_by('acc_voucher_info.id')
				->order_by('acc_voucher_info.voucher_no', 'desc')
				->limit(10, 0)
				->get()->result();

			return $result;
	    }


	    public function getLedgerReport($where = array()) {
	    	$result = $this->db->select('acc_ledger_data.*')
				->select('acc_chart_of_accounts.account_name')
				->from("acc_ledger_data")
		        ->join('acc_chart_of_accounts', 'acc_ledger_data.account_id = acc_chart_of_accounts.account_id AND `acc_ledger_data`.`company_id` = `acc_chart_of_accounts`.`company_id`', 'left')
				->where($where)
				//->like('acc_ledger_data.account_id', $account_id, 'after')
				->order_by('acc_ledger_data.voucher_date asc, acc_ledger_data.id asc')
				->get()->result();

			return $result;
	    }

	    public function getDayBookReport($where = array()) {
	    	$result = $this->db->select('acc_ledger_data.*')
				->select("concat(acc_chart_of_accounts.account_name, ' [',acc_ledger_data.account_id,']') accountName")
				->from("acc_ledger_data")
		        ->join('acc_chart_of_accounts', 'acc_ledger_data.account_id = acc_chart_of_accounts.account_id AND `acc_ledger_data`.`company_id` = `acc_chart_of_accounts`.`company_id`', 'left')
				->where($where)
				->order_by('acc_ledger_data.voucher_date asc, acc_ledger_data.id asc')
				->get()->result();

			return $result;
	    }


	    public function getLedgerOpeningReport($where = array(), $date) {
	    	$company_id = $this->session->userdata('company_id');
	    	$row = $this->db->select('sum(acc_ledger_data.debit) as debit, sum(acc_ledger_data.credit) as credit')
				->select("concat(acc_chart_of_accounts.account_name, ' [', acc_chart_of_accounts.account_id, ']' ) as accountName")
				->select("'$date' as upToDate")
				->from("acc_ledger_data")
		        ->join('acc_chart_of_accounts', "acc_ledger_data.account_id = acc_chart_of_accounts.account_id and acc_chart_of_accounts.company_id = $company_id", 'left')
				->where($where)
				//->like('acc_ledger_data.account_id', $account_id, 'after')
				->get()->row();

			return $row;
	    }


		public function debitSide($where = array(), $fromDate = '', $toDate = '', $company_id = 0) {
			$data = $this->db->select('acc_chart_of_accounts.account_id,account_name,acc_chart_of_accounts.status,length(acc_chart_of_accounts.account_id) as accIdLength')
				->select("(SELECT distinct (year_opening_debit - year_opening_credit) FROM acc_finance_table WHERE account_id = acc_chart_of_accounts.account_id and insert_date <= '$toDate' and company_id = $company_id and status = 'Active' order by insert_date desc limit 1 ) as openingDebitAmount")
				->select("(SELECT distinct (total_debit - total_credit) FROM acc_finance_table WHERE account_id = acc_chart_of_accounts.account_id and insert_date <= '$toDate' and company_id = $company_id and status = 'Active' order by insert_date desc limit 1 ) as debitAmount")
				->select("'$fromDate' as fromDate, '$toDate' as toDate")
				->from('acc_chart_of_accounts')
				->where($where)
				->order_by('acc_chart_of_accounts.account_id asc')
				->group_by('acc_chart_of_accounts.account_id')
				->get()->result();
				//echo $this->db->last_query(); exit();
			return $data;
		}


		public function creditSide($where = array(), $fromDate = '', $toDate = '', $company_id = 0) {
			$data = $this->db->select('acc_chart_of_accounts.account_id,account_name,status,length(acc_chart_of_accounts.account_id) as accIdLength')
				->select("(SELECT distinct (year_opening_credit - year_opening_debit) FROM acc_finance_table WHERE account_id = acc_chart_of_accounts.account_id and insert_date <= '$toDate' and company_id = $company_id and status = 'Active' order by insert_date desc limit 1 ) as openingCreditAmount")
				->select("(SELECT distinct (total_credit - total_debit) FROM acc_finance_table WHERE account_id = acc_chart_of_accounts.account_id and insert_date <= '$toDate' and company_id = $company_id and status = 'Active' order by insert_date desc limit 1 ) as creditAmount")
				->select("'$fromDate' as fromDate, '$toDate' as toDate")
				->from('acc_chart_of_accounts')
				->where($where)
				->order_by('acc_chart_of_accounts.account_id asc')
				->group_by('acc_chart_of_accounts.account_id')
				->get()->result();

			return $data;
		}


	    public function getAllWorkingDayList($where, $onset, $limit) {
	    	$result = $this->db->select('working_day_open_close.*')
				->select('app_user.full_name,login_name')
				->from("working_day_open_close")
		        ->join('app_user', 'working_day_open_close.admin_id = app_user.id', 'left')
				->where($where)
				->order_by('working_day_open_close.id', 'desc')
				->limit($limit, $onset)
				->get()->result();

			return $result;
	    }

		


}
