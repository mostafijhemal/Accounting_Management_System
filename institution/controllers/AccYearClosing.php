<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AccYearClosing extends CI_Controller {
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


	public function yearClosing(){
		$data['title'] = 'Financial Year Closing';
		if (checkUserAccess()) {
			$data['success'] 	= $this->session->userdata('success');
			$data['messege'] 	= $this->session->userdata('messege');
							   	  $this->session->set_userdata(array('success' => '', 'messege'=> ''));

			$company_id 			= $this->session->userdata('company_id');
			$data['company_id'] 	= $company_id;
			$data['prepare_by'] 	= $this->session->userdata('app_userid');
			$data['instituteData']  = $this->M_crud->findById('financial_year_list', array('company_id' => $company_id, 'status' => 'Active'));

			$data['content'] = "accounts/accYearClosingPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}


	/*
	 	1/ Insert data acc_year_closing_check table
	 	2/ Insert Current Financial year and current ledger table Name
	 	3/ update institute_info table only financial_year_from & financial_year_end column
	 	4/ call check_ledger_table_is_exist(); function
	 		1/ get institute_info table only financial_year_from & financial_year_end column
	 		2/ Create new Ledger Table
	 		3/ Update acc_media_table
	 	5/ Insert calcolated Data new Ledger Table
	*/
	public function yearClosingAction() {
		$user_id = $this->session->userdata('app_userid');
		$id 	 = blockScript($this->input->post('id'));
		$financial_year_from 	= blockScript($this->input->post('financial_year_from'));
		
		$log['company_id'] 	= $this->session->userdata('company_id');
		$log['data_name'] 	= 'running';

		// indert data acc_year_closing_check table for session distroy 
		$this->M_crud->save('acc_year_closing_check', $log);

		// Current Date Time
		$dateTime 	= date('Y-m-d H:i:s');
		// Current Date
		$date 		= date('Y-m-d', strtotime($dateTime));

		// Get Media Table data when no create new ledger table
		$mediaData 	= $this->db->update('financial_year_list', array('status' => "Inactive", 'financial_year_end' => $date), array('id' => $log['company_id'], 'status' => "Active"));

		// Update institute_info table only financial_year_from & financial_year_end column
		$nextDate = date('Y-m-d', strtotime('+1 day', strtotime($date)));
		$nextYear = date("Y-m-d", strtotime(date("Y-m-d", strtotime($nextDate)) . " + 1 year"));
		$year_closing_date 	= date('Y-m-d', strtotime('-1 days', strtotime($nextYear)));

		// Data Insert financial_year_list table
		$data['company_id'] 		= $log['company_id'];
		$data['financial_year_from']= $nextDate;
		$data['financial_year_end'] = $year_closing_date;
		$data['status'] 			= "Active";
		$data['user_id'] 			= $user_id;

		// insert data Financial Year closing logs
		$lastId = $this->M_crud->save('financial_year_list', $data);

		// Create A Closing Voucher
		$this->closingVoucherSum($lastId, $date, $dateTime, $nextDate);

		/*$this->db->empty_table('acc_year_closing_check');

		echo "data";*/
	}

	public function closingVoucherSum($lastId, $date, $dateTime, $nextDate) {
		$fyAutoId = $this->session->userdata('financial_year_auto_id');
		$company_id = $this->session->userdata('company_id');

		$profitLoss = $this->db->query("SELECT IFNULL(SUM(a.income - a.expense), 0) profitLoss FROM
			(SELECT 
				(SELECT SUM(b.total_credit - b.total_debit) income FROM acc_finance_table b 
				WHERE SUBSTR(b.account_id,1,1) = 3 AND b.company_id = $company_id) income ,
				(SELECT SUM(a.total_debit - a.total_credit) expense FROM acc_finance_table a 
				WHERE SUBSTR(a.account_id,1,1) = 4 AND a.company_id = $company_id AND SUBSTR(a.account_id,1,3) != 409) expense) a")->row('profitLoss');


		$data['company_id'] 			= $company_id;
		$data['prepare_by'] 			= $this->session->userdata('app_userid');
		$data['current_station'] 		= "Approve";
		$data["voucher_type_auto_id"] 	= 4;
		$data['voucher_date'] 			= $date;
		$data['voucher_detail'] 		= "Closing Profit Loss Balance of ".$date;
		$data['system_date']			= $dateTime;
		$data["financial_year_auto_id"] = $fyAutoId;

		$maxRow = $this->db->query("SELECT MAX(voucher_no) maxVoucherNo, MAX(serial_no) maxSerialNo FROM acc_voucher_info where company_id = $company_id")->row();

		if(isset($maxRow) && !empty($maxRow)) {
			$voucher_no = ($maxRow->maxVoucherNo + 1);
		} else {
			$voucher_no = 1;
		}
		$data['voucher_no'] = $voucher_no;

		//$maxRow = $this->M_crud->findMax("acc_voucher_info", array('company_id' => $company_id), 'serial_no');
		if(isset($maxRow) && !empty($maxRow)) {
			$serial_no = ($maxRow->maxSerialNo + 1);
		} else {
			$serial_no = 1;
		}
		$data['serial_no'] 	= $serial_no;
		$lvid = $this->M_crud->save("acc_voucher_info", $data);

		$narra = $data['voucher_detail'];
		$this->db->query("INSERT INTO acc_voucher_details (voucher_info_auto_id, account_id, debit, credit, narration) 
			VALUES 
			($lvid, 304, $profitLoss, 0, '$narra'),
			($lvid, 2030102, 0, $profitLoss, '$narra')");


		$this->db->query("INSERT INTO acc_ledger_data (company_id, financial_year_auto_id, voucher_info_auto_id, voucher_no, voucher_date, system_date, account_id, debit, credit, narration) 
			VALUES 
			($company_id, $fyAutoId, $lvid, $voucher_no, '$date', '$dateTime', 304, $profitLoss, 0, '$narra'),
			($company_id, $fyAutoId, $lvid, $voucher_no, '$date', '$dateTime', 2030102, 0, $profitLoss, '$narra')");

		$incomeSummaryId = $this->db->query("SELECT * FROM acc_finance_table WHERE account_id = 304 AND status = 'Active'")->row();
		$profitCapitalId = $this->db->query("SELECT * FROM acc_finance_table WHERE account_id = 2030102 AND status = 'Active'")->row();

		if(!empty($incomeSummaryId)) {
			if($date != $incomeSummaryId->insert_date) {
				$this->db->query("UPDATE acc_finance_table SET status = 'Inactive' WHERE id = $incomeSummaryId->id");

				$doDebit 		= $incomeSummaryId->total_debit;
				$doCrebit 		= $incomeSummaryId->total_credit;
				$yoDebit 		= $incomeSummaryId->year_opening_debit;
				$yoCrebit 		= $incomeSummaryId->year_opening_credit;
				$total_debit  	= ($incomeSummaryId->total_debit + $profitLoss);
				$total_credit 	= $incomeSummaryId->total_credit;

				$this->db->query("INSERT INTO acc_finance_table (company_id, financial_year_auto_id, insert_date, account_id, total_debit, total_credit, day_opening_debit, day_opening_credit, year_opening_debit, year_opening_credit) 
				VALUES 
				($company_id, $fyAutoId, '$date', 304, $total_debit, $total_credit, $doDebit, $doCrebit, $yoDebit, $yoCrebit)");
			} else {
				$total_debit  = ($incomeSummaryId->total_debit + $profitLoss);
				$total_credit = $incomeSummaryId->total_credit;
				$this->db->query("UPDATE acc_finance_table SET total_debit = $total_debit, total_credit = $total_credit WHERE id = $incomeSummaryId->id");
			}
		} else {
			$this->db->query("INSERT INTO acc_finance_table (company_id, financial_year_auto_id, insert_date, account_id, total_debit, total_credit, day_opening_debit, day_opening_credit, year_opening_debit, year_opening_credit) 
			VALUES 
			($company_id, $fyAutoId, '$date', 304, $profitLoss, 0, 0, 0, 0, 0)");
		}

		if(!empty($profitCapitalId)) {
			if($date != $profitCapitalId->insert_date) {
				$this->db->query("UPDATE acc_finance_table SET status = 'Inactive' WHERE id = $profitCapitalId->id");

				$doDebit 		= $profitCapitalId->total_debit;
				$doCrebit 		= $profitCapitalId->total_credit;
				$yoDebit 		= $profitCapitalId->year_opening_debit;
				$yoCrebit 		= $profitCapitalId->year_opening_credit;
				$total_debit   	= $profitCapitalId->total_debit;
				$total_credit  	= ($profitCapitalId->total_credit + $profitLoss);
				$this->db->query("INSERT INTO acc_finance_table (company_id, financial_year_auto_id, insert_date, account_id, total_debit, total_credit, day_opening_debit, day_opening_credit, year_opening_debit, year_opening_credit) 
				VALUES 
				($company_id, $fyAutoId, '$date', 2030102, $total_debit, $total_credit, $doDebit, $doCrebit, $yoDebit, $yoCrebit)");
			} else {
				$total_debit   = $profitCapitalId->total_debit;
				$total_credit  = ($profitCapitalId->total_credit + $profitLoss);
				$this->db->query("UPDATE acc_finance_table SET total_debit = $total_debit, total_credit = $total_credit WHERE id = $profitCapitalId->id");
			}
		} else {
			$this->db->query("INSERT INTO acc_finance_table (company_id, financial_year_auto_id, insert_date, account_id, total_debit, total_credit, day_opening_debit, day_opening_credit, year_opening_debit, year_opening_credit) 
			VALUES 
			($company_id, $fyAutoId, '$date', 2030102, 0, $profitLoss, 0, 0, 0, 0)");
		}

		redirect('accYearClosing/closingAction/'.$lastId.'/'.$date.'/'.$dateTime.'/'.$nextDate.'/'.$fyAutoId.'/'.$company_id);
	}

	public function closingAction($lastId, $date, $dateTime, $nextDate, $fyAutoId, $company_id) {
		// $lastId New Finace Year id
		// $fyAutoId Old Finace Year id
		$mainList = $this->db->select("*")
			->from("acc_finance_table")
			->where(array("financial_year_auto_id" => $fyAutoId, "company_id" => $company_id, "status" => "Active"))
			->get()->result();

		$this->db->update('acc_finance_table', array("status" => "Inactive"), array("financial_year_auto_id" => $fyAutoId, "company_id" => $company_id));

		if(!empty($mainList)) {
			$i = 0;
			foreach ($mainList as $v) {
				$d[$i]['company_id'] 			= $company_id;
				$d[$i]['financial_year_auto_id']= $lastId;
				$d[$i]['insert_date'] 			= $nextDate;
				$d[$i]['account_id'] 			= $v->account_id;
				$d[$i]['year_opening_debit'] 	= $v->total_debit;
				$d[$i]['year_opening_credit'] 	= $v->total_credit;
				$d[$i]['day_opening_debit'] 	= 0;
				$d[$i]['day_opening_credit'] 	= 0;
				$d[$i]['total_debit'] 			= 0;//$v->total_debit;
				$d[$i]['total_credit'] 			= 0;//$v->total_credit;
				$d[$i]['status'] 				= "Active";
				$i++;
			}

			$this->db->insert_batch('acc_finance_table', $d);
		}
		$this->session->set_userdata(array('financial_year_auto_id' => $lastId));

		$this->db->empty_table('acc_year_closing_check');
		logoutUser();
		echo "data";
	}


	public function accClosingCheck() {
		$dataExist = $this->M_crud->findById('acc_year_closing_check', array('company_id' => 1));
		if(!empty($dataExist->id)){
	 		$this->session->set_userdata(array('app_userid' => null, 'app_user_type_id'=> null, 'app_user_designition' => null, 'app_user_full_name'=> null, 'app_login_name' => null, 'employee_id'=> null));
		}
	}











}
