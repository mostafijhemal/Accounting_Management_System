<?php
class M_default_setup extends CI_Model {
	
	const TABLE	= '';

	public function __construct() {
		parent::__construct();
	}
	
	/* The function use to App Controler */
	public function defaultMenu() {
		$current_date_time = date("Y-m-d h:i:s");
		$query = "INSERT INTO `menu_list` (`order`, `menu_id`, `menu_name`, `menu_link`, `menu_icon`, `status`, `position_status`, `create_at`) 
		VALUES
		(1, NULL, 'Dashboard', 'app/', 'fa fa-tachometer', 'active', 'child', '$current_date_time'), 
		(2, NULL, 'Institute Info', 'instituteInfo/', 'fa fa-industry', 'active', 'child', '$current_date_time'), 
		(3, NULL, 'User', 'app_user_manage/', 'fa fa-users', 'active', 'child', '$current_date_time')";
		$this->db->query($query);
	}

	/* 
		Any Time Edit 
		The function use to ChartOfAccounts Controler
	*/
	public function defaultChartOfAccount($company_id) {
		$query = "INSERT INTO `acc_chart_of_accounts` (`company_id`, `acc_class_id`, `p_id`, `account_id`, `account_name`, `status`, `head_status`, `required_status`) 
		VALUES
		('$company_id', 1, 0, 1, 'ASSETS', 'Parent', 'Enable', 'No'), 
			('$company_id', 1, 1, 101, 'CURRENT ASSETS', 'Parent', 'Enable', 'No'),  
				('$company_id', 1, 101, 10101, 'CASH & CASH EQUIVALENT', 'Parent', 'Enable', 'No'), 
					('$company_id', 1, 10101, 1010101, 'CASH IN HAND', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10101, 1010102, 'CASH AT BANK', 'Child', 'Enable', 'No'),  
				('$company_id', 1, 101, 10102, 'ADVANCE DEPOSIT & PREPAYMENT', 'Parent', 'Enable', 'No'), 
					('$company_id', 1, 10102, 1010201, 'HOUSE RENT - ADVANCE', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10102, 1010202, 'SECURITY DEPOSIT', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10102, 1010203, 'LOANS & ADVANCE', 'Child', 'Enable', 'No'), 
				('$company_id', 1, 101, 10103, 'BILLS RECEIVABLES', 'Child', 'Enable', 'No'), 
				('$company_id', 1, 101, 10104, 'INVENTORY', 'Child', 'Enable', 'No'), 
				('$company_id', 1, 101, 10105, 'PRELIMINARY EXPENSES', 'Child', 'Enable', 'No'), 
			('$company_id', 1, 1, 102, 'NON CURRENT ASSETS', 'Parent', 'Enable', 'No'), 
				('$company_id', 1, 102, 10201, 'PROPERTY, PLANT & EQUIPMENT', 'Parent', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020101, 'INTELLECTUAL ASSETS', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020102, 'FURNITURE & FIXTURES', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020103, 'AIR CONDITION', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020104, 'ASSETS & OTHERS', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020105, 'GENERATOR', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020106, 'COMPUTER & MONITOR', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020107, 'ACCESSORIES', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020108, 'LAPTOP COMPUTER', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020109, 'PRINTER & PHOTOCOPY', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020110, 'PROJECTOR', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020111, 'IPS', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020112, 'VEHICLES', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020113, 'MOTORCYCLE', 'Child', 'Enable', 'No'), 

		('$company_id', 2, 0, 2, 'LIABILITIES', 'Parent', 'Enable', 'No'), 
			('$company_id', 2, 2, 201, 'CURRENT LIABILITIES', 'Parent', 'Enable', 'No'), 
				('$company_id', 2, 201, 20101, 'LIABILITIES FOR EXPENSES', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 201, 20102, 'BILLS PAYABLES', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 201, 20103, 'TRADE CREDITORS, SALARIES & OTHER PAYABLES', 'Parent', 'Enable', 'No'), 
					('$company_id', 2, 20103, 2010301, 'PAYABLE - SALARY', 'Child', 'Enable', 'No'), 
					('$company_id', 2, 20103, 2010302, 'HOUSE RENT - PAYABLE', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 201, 20104, 'LOAN FROM OTHERS', 'Child', 'Enable', 'No'), 
			('$company_id', 2, 2, 202, 'NON CURRENT LIABILITIES', 'Parent', 'Enable', 'No'), 
				('$company_id', 2, 202, 20201, 'SECURED LOAN', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 202, 20202, 'UNSECURED LOAN', 'Parent', 'Enable', 'No'), 
					('$company_id', 2, 20202, 2020201, 'DIRECTORES LOAN', 'Child', 'Enable', 'No'), 
			('$company_id', 2, 2, 203, 'CAPITALS & OWNERS EQUITY', 'Parent', 'Enable', 'No'), 
				('$company_id', 2, 203, 20301, 'SHARE CAPITALS', 'Parent', 'Enable', 'No'), 
					('$company_id', 2, 20301, 2030101, 'MANAGING DIRECTOR', 'Child', 'Enable', 'No'), 
					('$company_id', 2, 20301, 2030102, 'PROFIT CAPITAL', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 203, 20302, 'RETAINED EARNINGS', 'Child', 'Enable', 'No'), 

		('$company_id', 3, 0, 3, 'INCOME', 'Parent', 'Enable', 'No'),
			('$company_id', 3, 3, 301, 'REVENUE FROM SALES', 'Parent', 'Enable', 'No'),
				('$company_id', 3, 301, 30101, 'SALES', 'Child', 'Enable', 'No'),
			('$company_id', 3, 3, 302, 'REVENUE FROM OTHERS', 'Child', 'Enable', 'No'),
			('$company_id', 3, 3, 303, 'NON OPERATING REVENUE', 'Parent', 'Enable', 'No'),
				('$company_id', 3, 303, 30301, 'MISCELLANEOUS INCOME', 'Parent', 'Enable', 'No'),
					('$company_id', 3, 30301, 3030101, 'GAIN ON DISPOSAL OF FIXED ASSETS', 'Parent', 'Enable', 'No'),
						('$company_id', 3, 3030101, 303010101, 'FURNITURE & FIXTURE', 'Child', 'Enable', 'No'),
			('$company_id', 3, 3, 304, 'INCOME SUMMARY', 'Child', 'Enable', 'No'),

		('$company_id', 4, 0, 4, 'EXPENSE', 'Parent', 'Enable', 'No'), 
			('$company_id', 4, 4, 401, 'CONVEYANCE', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 402, 'ENTERTAINMENT', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 403, 'PRINTING & STATIONERY', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 404, 'MISCELLENEOUS', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 405, 'HOUSE RENT - EXPENSE', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 406, 'ADJUSTMENTS & OTHERS', 'Parent', 'Enable', 'No'),
				('$company_id', 4, 406, 40601, 'LOSS ON DISPOSAL OF FIXED ASSETS', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 406, 40602, 'BROKEN,DAMAGED & REPLACEMENT', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 406, 40603, 'BAD DEBT EXPENSES', 'Parent', 'Enable', 'No'), 
					('$company_id', 4, 40603, 4060301, 'BAD DEBTS', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 406, 40604, 'VAT ADJUSTMENTS', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 407, 'SALARY & PAY', 'Parent', 'Enable', 'No'), 
				('$company_id', 4, 407, 40701, 'SALARY EXPENSE', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 407, 40702, 'FESTIVAL BONUS', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 407, 40703, 'PROFIT BONUS', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 408, 'EXPENSE FOR GOOD SOLD', 'Child', 'Enable', 'No'),
			('$company_id', 4, 4, 409, 'WITHDRAW', 'Child', 'Enable', 'No')
		";

		$this->db->query($query);
	}


	/*
	Backup function for Use Afer Some Time
	public function defaultChartOfAccount() {
		$company_id = 1;
		$query = "INSERT INTO `acc_chart_of_accounts` (`company_id`, `acc_class_id`, `p_id`, `account_id`, `account_name`, `status`, `head_status`, `required_status`) 
		VALUES
		('$company_id', 1, 0, 1, 'ASSETS', 'Parent', 'Enable', 'No'), 
			('$company_id', 1, 1, 101, 'CURRENT ASSETS', 'Parent', 'Enable', 'No'),  
				('$company_id', 1, 101, 10101, 'CASH & CASH EQUIVALENT', 'Parent', 'Enable', 'No'), 
					('$company_id', 1, 10101, 1010101, 'CASH IN HAND', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10101, 1010102, 'CASH AT BANK', 'Child', 'Enable', 'No'),  
				('$company_id', 1, 101, 10102, 'ADVANCE DEPOSIT & PREPAYMENT', 'Parent', 'Enable', 'No'), 
					('$company_id', 1, 10102, 1010201, 'HOUSE RENT - ADVANCE', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10102, 1010202, 'SECURITY DEPOSIT', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10102, 1010203, 'LOANS & ADVANCE', 'Child', 'Enable', 'No'), 
				('$company_id', 1, 101, 10103, 'BILLS RECEIVABLES', 'Child', 'Enable', 'No'), 
				('$company_id', 1, 101, 10104, 'INVENTORY', 'Child', 'Enable', 'No'), 
				('$company_id', 1, 101, 10105, 'PRELIMINARY EXPENSES', 'Child', 'Enable', 'No'), 
			('$company_id', 1, 1, 102, 'NON CURRENT ASSETS', 'Parent', 'Enable', 'No'), 
				('$company_id', 1, 102, 10201, 'PROPERTY, PLANT & EQUIPMENT', 'Parent', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020101, 'INTELLECTUAL ASSETS', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020102, 'FURNITURE & FIXTURES', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020103, 'AIR CONDITION', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020104, 'ASSETS & OTHERS', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020105, 'GENERATOR', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020106, 'COMPUTER & MONITOR', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020107, 'ACCESSORIES', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020108, 'LAPTOP COMPUTER', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020109, 'PRINTER & PHOTOCOPY', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020110, 'PROJECTOR', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020111, 'IPS', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020112, 'VEHICLES', 'Child', 'Enable', 'No'), 
					('$company_id', 1, 10201, 1020113, 'MOTORCYCLE', 'Child', 'Enable', 'No'), 

		('$company_id', 2, 0, 2, 'LIABILITIES', 'Parent', 'Enable', 'No'), 
			('$company_id', 2, 2, 201, 'CURRENT LIABILITIES', 'Parent', 'Enable', 'No'), 
				('$company_id', 2, 201, 20101, 'LIABILITIES FOR EXPENSES', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 201, 20102, 'BILLS PAYABLES', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 201, 20103, 'TRADE CREDITORS, SALARIES & OTHER PAYABLES', 'Parent', 'Enable', 'No'), 
					('$company_id', 2, 20103, 2010301, 'PAYABLE - SALARY', 'Child', 'Enable', 'No'), 
					('$company_id', 2, 20103, 2010302, 'HOUSE RENT - PAYABLE', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 201, 20104, 'LOAN FROM OTHERS', 'Child', 'Enable', 'No'), 
			('$company_id', 2, 2, 202, 'NON CURRENT LIABILITIES', 'Parent', 'Enable', 'No'), 
				('$company_id', 2, 202, 20201, 'SECURED LOAN', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 202, 20202, 'UNSECURED LOAN', 'Parent', 'Enable', 'No'), 
					('$company_id', 2, 20202, 2020201, 'DIRECTORES LOAN', 'Child', 'Enable', 'No'), 
			('$company_id', 2, 2, 203, 'CAPITALS & OWNERS EQUITY', 'Parent', 'Enable', 'No'), 
				('$company_id', 2, 203, 20301, 'SHARE CAPITALS', 'Child', 'Enable', 'No'), 
				('$company_id', 2, 203, 20302, 'RETAINED EARNINGS', 'Child', 'Enable', 'No'), 

		('$company_id', 3, 0, 3, 'INCOME', 'Parent', 'Enable', 'No'),
			('$company_id', 3, 3, 301, 'REVENUE FROM SALES', 'Parent', 'Enable', 'No'),
				('$company_id', 3, 301, 30101, 'SALES', 'Child', 'Enable', 'No'),
			('$company_id', 3, 3, 302, 'REVENUE FROM OTHERS', 'Child', 'Enable', 'No'),
			('$company_id', 3, 3, 303, 'NON OPERATING REVENUE', 'Parent', 'Enable', 'No'),
				('$company_id', 3, 303, 30301, 'MISCELLANEOUS INCOME', 'Parent', 'Enable', 'No'),
					('$company_id', 3, 30301, 3030101, 'GAIN ON DISPOSAL OF FIXED ASSETS', 'Parent', 'Enable', 'No'),
						('$company_id', 3, 3030101, 303010101, 'FURNITURE & FIXTURE', 'Child', 'Enable', 'No'),

		('$company_id', 4, 0, 4, 'EXPENSE', 'Parent', 'Enable', 'No'), 
			('$company_id', 4, 4, 401, 'CONVEYANCE', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 402, 'ENTERTAINMENT', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 403, 'PRINTING & STATIONERY', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 404, 'MISCELLENEOUS', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 405, 'HOUSE RENT - EXPENSE', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 406, 'ADJUSTMENTS & OTHERS', 'Parent', 'Enable', 'No'),
				('$company_id', 4, 406, 40601, 'LOSS ON DISPOSAL OF FIXED ASSETS', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 406, 40602, 'BROKEN,DAMAGED & REPLACEMENT', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 406, 40603, 'BAD DEBT EXPENSES', 'Parent', 'Enable', 'No'), 
					('$company_id', 4, 40603, 4060301, 'BAD DEBTS', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 406, 40604, 'VAT ADJUSTMENTS', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 407, 'SALARY & PAY', 'Parent', 'Enable', 'No'), 
				('$company_id', 4, 407, 40701, 'SALARY EXPENSE', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 407, 40702, 'FESTIVAL BONUS', 'Child', 'Enable', 'No'), 
				('$company_id', 4, 407, 40703, 'PROFIT BONUS', 'Child', 'Enable', 'No'), 
			('$company_id', 4, 4, 408, 'EXPENSE FOR GOOD SOLD', 'Child', 'Enable', 'No')
			('$company_id', 4, 4, 409, 'WITHDRAW', 'Child', 'Enable', 'No')
		";

		$this->db->query($query);
	}
	*/


	/* Use for find information table auto id */
	public function findActionTable($table='', $encode='') {
		if(!empty($encode)){
			if($table == 'pa_farmer_info'){
				$dataFind = $this->M_crud->columnFindById(array('farmer_info_id', 'farmer_unic_id'), 'pa_farmer_info', array('farmer_unic_id' => $encode));
				if(isset($dataFind) && !empty($dataFind)) {
					$arr = array('table' => $table, 'auto_id' => $dataFind->farmer_info_id, 'contacts_id' => $dataFind->farmer_unic_id);
				} else {
					$arr = '';
				}
			}
			if($table == 'pa_cows_profile'){
				$dataFind = $this->M_crud->columnFindById(array('cows_info_id', 'cows_id'), 'pa_cows_profile', array('cows_id' => $encode));
				if(isset($dataFind) && !empty($dataFind)) {
					$arr = array('table' => $table, 'auto_id' => $dataFind->cows_info_id, 'contacts_id' => $dataFind->cows_id);
				} else {
					$arr = '';
				}
			}

			if(isset($arr) && !empty($arr)) {
				return $arr;
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
	
		
}
