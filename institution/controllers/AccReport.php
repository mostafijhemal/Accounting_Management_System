<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AccReport extends CI_Controller {
	static $model 	 = array('M_crud', 'M_join', 'M_default_setup');
	static $helper   = array('url', 'authentication', 'customfunction');
	static $library  = array('session', 'numbertowords');
	
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

	public function approveVoucherList($onset = 0) {
		$this->load->library('pagination');
		$data['title'] = 'Approve Voucher List Report';
		if (checkUserAccess()) {
			$data['vType'] = $this->M_crud->findAll("acc_voucher_type_list", array("status" => "Active"), "type_name", "asc");
			$where = array('acc_voucher_info.company_id' => $this->session->userdata('company_id'), 'acc_voucher_info.approve_by !=' => NULL);
			$data['list'] = $this->M_join->getAllVoucherList($where, $onset, 10);

			$data['onset'] 				= $onset;
			$config['base_url'] 		= base_url('accReport/approveVoucherList');
			$config['total_rows'] 		= $this->M_crud->countAll('acc_voucher_info', $where);
			$config['uri_segment'] 		= 3;
			$config['per_page'] 		= 10;
			$config['num_links'] 		= 7;
			$config['first_link']		= FALSE;
			$config['last_link'] 		= FALSE;
			$config['prev_link']		= 'Prev';
			$config['next_link'] 		= 'Next';
			$this->pagination->initialize($config);

			$data['content'] = "accounts/report/voucherListPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function unapproveVoucherList($onset = 0) {
		$this->load->library('pagination');
		$data['title'] = 'Unapprove Voucher List Report';
		if (checkUserAccess()) {
			$data['vType'] = $this->M_crud->findAll("acc_voucher_type_list", array("status" => "Active"), "type_name", "asc");
			$where = array('acc_voucher_info.company_id' => $this->session->userdata('company_id'), 'acc_voucher_info.approve_by' => NULL);
			$data['list'] = $this->M_join->getAllVoucherList($where, $onset, 10);

			$data['onset'] 				= $onset;
			$config['base_url'] 		= base_url('accReport/unapproveVoucherList');
			$config['total_rows'] 		= $this->M_crud->countAll('acc_voucher_info', $where);
			$config['uri_segment'] 		= 3;
			$config['per_page'] 		= 10;
			$config['num_links'] 		= 7;
			$config['first_link']		= FALSE;
			$config['last_link'] 		= FALSE;
			$config['prev_link']		= 'Prev';
			$config['next_link'] 		= 'Next';
			$this->pagination->initialize($config);

			$data['content'] = "accounts/report/voucherListPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function searchVoucher() {
		$id 		= blockScript($this->input->post("id"));
		$from_date 	= blockScript($this->input->post("from_date"));
		$to_date 	= blockScript($this->input->post("to_date"));
		$uriString 	= blockScript($this->input->post("uriString"));

		$where["acc_voucher_info.company_id"] = $this->session->userdata('company_id');
		if(!empty($id)) $where["acc_voucher_info.voucher_type_auto_id"] = $id;
		if($uriString == "accReport/approveVoucherList") {
			$where["acc_voucher_info.approve_by !="] = NULL;
		} else {
			$where["acc_voucher_info.approve_by"] = NULL;
		}
		if(!empty($from_date)) $where["acc_voucher_info.voucher_date >="] = $from_date;
		if(!empty($to_date)) $where["acc_voucher_info.voucher_date <="] = $to_date;

		$list = $this->M_join->getSearchingVoucherList($where);
		
		$i = 1;
		foreach ($list as $v) {
			echo "<tr>
				<td class='text-center'>".$i++."</td>
				<td class='text-center'>
					$v->type_name
				</td>
				<td class='text-center'>$v->serial_no</td>
				<td class='text-center'>$v->voucher_no</td>
				<td>$v->voucher_detail</td>
				<td class='text-right'>
					".number_format($v->totalVoucherAmount, 2)."
				</td>
				<td class='text-center'>
					<div class='btn-group'>
						<table>
							<tbody>
								<tr>
									<td style='padding: 0 5px;'>
									   	<a target='blank' href='".site_url('accReport/voucher/'.$v->id)."' style='display: block;'>
											<button class='btn btn-xs btn-info' data-rel='tooltip' title='View' data-placement='bottom'>
											    View
											</button>
										</a>
									</td>
								</tr>
							</tbody>
						</table>		   	
					</div>
				</td>
			</tr>";
		}
	}

	public function chartOfAccounts(){
		$data['title'] = 'Chart Of Accounts List';
		$company_id = $this->session->userdata('company_id');
		if (checkUserAccess()) {
			$data['ac_list'] = $this->M_crud->findAll('acc_chart_of_accounts', array('p_id' => 0, 'head_status' => 'Enable', 'company_id' => $company_id), 'account_id', 'asc');

			$data['content'] = "accounts/report/chartOfAccountsPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function findLedgerReport() {
		$company_id = $this->session->userdata('company_id');
		$data['title'] = 'Find Ledger';
		if (checkUserAccess()) {
			$data['ac_list'] 	= $this->M_crud->findAll('acc_chart_of_accounts', ['p_id' => 0, 'head_status' => 'Enable', 'company_id' => $company_id], 'account_id', 'asc');
			$data['fyYearList'] 	= $this->M_join->getFinancialYearList();
			$data['from_year'] 		= $this->session->userdata("from_year");
			$data['to_year'] 		= $this->session->userdata("to_year");

			$data['content'] = "accounts/report/findLedgerReportPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function getNextLare() {
		$company_id = $this->session->userdata('company_id');
		$account_id = blockScript($this->input->post('account_id'));

		$data = $this->M_crud->findAll('acc_chart_of_accounts', array('p_id' => $account_id, 'company_id' => $company_id), 'account_id', 'asc');
		
		if(strlen($account_id) == 1) {
			$labelName = "Label Two";
		} else if(strlen($account_id) == 3) {
			$labelName = "Label Three";
		} else if(strlen($account_id) == 5) {
			$labelName = "Label Four";
		} else if(strlen($account_id) == 7) {
			$labelName = "Label Five";
		} else if(strlen($account_id) == 9) {
			$labelName = "Label Six";
		} else if(strlen($account_id) == 11) {
			$labelName = "Label Seven";
		} else if(strlen($account_id) == 13) {
			$labelName = "Label Eight";
		} else if(strlen($account_id) == 15) {
			$labelName = "Label Nine";
		} else if(strlen($account_id) == 17) {
			$labelName = "Label Ten";
		}  else if(strlen($account_id) == 19) {
			$labelName = "Label Eleven";
		}  else if(strlen($account_id) == 21) {
			$labelName = "Label Twelve";
		}  else if(strlen($account_id) == 23) {
			$labelName = "Label Thirteen";
		}  else if(strlen($account_id) == 25) {
			$labelName = "Label Fourteen";
		}  else if(strlen($account_id) == 27) {
			$labelName = "Label Fifteen";
		}  else if(strlen($account_id) == 29) {
			$labelName = "Label Sixteen";
		}  else if(strlen($account_id) == 31) {
			$labelName = "Label Seventeen";
		}  else if(strlen($account_id) == 33) {
			$labelName = "Label Eighteen";
		}  else if(strlen($account_id) == 35) {
			$labelName = "Label Ninteen";
		}  else if(strlen($account_id) == 37) {
			$labelName = "Label Twenty";
		} else {
			$labelName = "Label More than Twenty";
		}

		if(isset($data) && !empty($data)) {
			echo '<select class="form-control selectHead">
				<option value="">'.$labelName.'</option>';
			foreach ($data as $v) {
				echo '<option value="'.$v->account_id.'">'.$v->account_name.' - '.$v->account_id.'</option>';
			}
			echo "</select>";
		}
	}

	public function getLedgerReport() {
		$from_date 	= blockScript($this->input->post('from_date'));
		$to_date 	= blockScript($this->input->post('to_date'));
		$account_id = blockScript($this->input->post('selectHead'));
		$company_id = $this->session->userdata('company_id');

		$date 		= date('d-M-Y', strtotime($from_date)).' To '.date('d-M-Y', strtotime($to_date));
		if(!empty($account_id)){
			$getAccName = $this->M_crud->findById("acc_chart_of_accounts", array("account_id" => $account_id));
			$accName 	= $getAccName->account_name.' ['.$getAccName->account_id.']';
		} else {
			$accName 	= "";
		}

		// Title generate
		if($from_date != '' and $to_date != ''){
			if($from_date != $to_date){
				$data['title'] 	= 'Ledger Report : '.$accName.' From '.$date;
			}else{
				$data['title'] = 'Ledger Report : '.$accName.' Date of '.date('d-M-Y', strtotime($from_date));
			}
		}else{			
			$data['title'] = 'Ledger Report : '.$accName;
		}

		$accIdLength = strlen($account_id);
		if(!empty($account_id)) $where2["substr(acc_ledger_data.account_id,1,$accIdLength)"] = $account_id;
		if(!empty($account_id)) $where["substr(acc_ledger_data.account_id,1,$accIdLength)"]  = $account_id;

		if(!empty($from_date)) 	$where2['acc_ledger_data.voucher_date <'] 	= $from_date;
		if(!empty($company_id)) $where2['acc_ledger_data.company_id'] 		= $company_id;
		$data['opening']= $this->M_join->getLedgerOpeningReport($where2, $from_date);

		if(!empty($from_date)) 	$where['acc_ledger_data.voucher_date >='] 	= $from_date;
		if(!empty($to_date)) 	$where['acc_ledger_data.voucher_date <='] 	= $to_date;
		if(!empty($company_id)) $where['acc_ledger_data.company_id'] 		= $company_id;
		$data['list'] 	= $this->M_join->getLedgerReport($where);
		
		$data['view'] 	= 'ledgerReportPage';
    	$this->load->view('app/accounts/report/reportsTemplate',$data);
	}


	public function findDayBookReport() {
		$data['title'] = 'Find Day Book Report';
		if (checkUserAccess()) {
			$data['ac_list'] 	= $this->M_crud->findAll('acc_chart_of_accounts', array('p_id' => 0, 'head_status' => 'Enable'), 'account_id', 'asc');
			$data['fyYearList'] 	= $this->M_join->getFinancialYearList();
			$data['from_year'] 		= $this->session->userdata("from_year");
			$data['to_year'] 		= $this->session->userdata("to_year");

			$data['content'] = "accounts/report/findDayBookReportPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

    // Get Day book report
    public function getDayBookReport() {
		$from_date 	= blockScript($this->input->post('from_date'));
		$to_date 	= blockScript($this->input->post('to_date'));
		$company_id = $this->session->userdata('company_id');

    	$date = date('d-M-Y', strtotime($from_date)).' To '.date('d-M-Y', strtotime($to_date));
		//Title generate
		if($from_date != '' and $to_date != ''){
			if($from_date != $to_date){
				$data['title'] = 'Day Book Report : From '.$date;
			}else{
				$data['title'] = 'Day Book Report : Date of '.date('d-M-Y', strtotime($from_date));
			}
		}else{			
			$data['title'] = 'Day Book Report';
		}

    	if(!empty($from_date)) 	$where['voucher_date >='] 	= $from_date;
    	if(!empty($to_date)) 	$where['voucher_date <='] 	= $to_date;

		$where['acc_ledger_data.company_id'] 				= $company_id;
		$where['substr(acc_chart_of_accounts.account_id,1,5)']= 10101;

    	$data['list']= $this->M_join->getDayBookReport($where);

    	$data['view'] = 'dayBookPage';
    	$this->load->view('app/accounts/report/reportsTemplate',$data);
    }

	public function findTrialBalanceReport() {
		$data['title'] = 'Find Trial Balance Report';
		if (checkUserAccess()) {
			$data['fyYearList'] = $this->M_join->getFinancialYearList();
			$data['from_year'] 	= $this->session->userdata("from_year");
			$data['to_year'] 	= $this->session->userdata("to_year");

			$data['content'] = "accounts/report/findTrialBalanceReportPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function findIncomeStatementReport() {
		$data['title'] = 'Find Income Statement Report';
		if (checkUserAccess()) {
			$data['fyYearList'] = $this->M_join->getFinancialYearList();
			$data['from_year'] 	= $this->session->userdata("from_year");
			$data['to_year'] 	= $this->session->userdata("to_year");

			$data['content'] = "accounts/report/findIncomeStatementReportPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function getIncomeStatementReport() {
		$from_date 	= blockScript($this->input->post('from_date'));
		$to_date 	= blockScript($this->input->post('to_date'));

		$data['title'] 	= 'Income Statement Report on '.date('d-M-Y', strtotime($to_date));

		$company_id = $this->session->userdata("company_id");
		$where1 = "acc_chart_of_accounts.acc_class_id='4' and acc_chart_of_accounts.account_id != '4' and acc_chart_of_accounts.company_id = $company_id";
    	$data['debitSite'] 	= $this->M_join->debitSide($where1, $from_date, $to_date, $company_id);

    	$where2 = "acc_chart_of_accounts.acc_class_id='3' and acc_chart_of_accounts.account_id != '3' and acc_chart_of_accounts.company_id = $company_id";
    	$data['creditSite'] = $this->M_join->creditSide($where2, $from_date, $to_date, $company_id);

    	$data['view'] 	= 'incomeStatementReportPage';
    	$this->load->view('app/accounts/report/reportsTemplate', $data);
	}

	public function findOwnersEquityReport() {
		$data['title'] = 'Find Owners Equity Report';
		if (checkUserAccess()) {
			$data['fyYearList'] = $this->M_join->getFinancialYearList();
			$data['from_year'] 	= $this->session->userdata("from_year");
			$data['to_year'] 	= $this->session->userdata("to_year");

			$data['content'] = "accounts/report/findOwnersEquityReportPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}


	public function getOwnersEquityReport() {
		$from_date 	= blockScript($this->input->post('from_date'));
		$to_date 	= blockScript($this->input->post('to_date'));

		$data['title'] 	= 'Owner Equity Report on '.date('d-M-Y', strtotime($to_date));

		$company_id = $this->session->userdata("company_id");
		$data['capital'] = $this->db->query("SELECT b.account_name, a.account_id, '$from_date' fromDate, '$to_date' toDate, ifnull(sum(year_opening_credit - year_opening_debit), 0) totalCapitalOpening, ifnull(sum(total_credit - total_debit), 0) totalCapitalCurrent from acc_finance_table a inner join acc_chart_of_accounts b on a.account_id = b.account_id AND b.company_id = $company_id where insert_date = (SELECT MAX(insert_date) dataDate FROM acc_finance_table where SUBSTRING(account_id,1,5) = 20301 and insert_date <= '$to_date' and company_id = $company_id) and substr(a.account_id,1,5) = 20301 and a.company_id = $company_id")->result();

		//echo $this->db->last_query(); exit();
		$income = $this->db->query("SELECT ifnull(sum(year_opening_credit - year_opening_debit), 0) totalIncomeOpening, ifnull(sum(total_credit - total_debit), 0) totalIncomeCurrent from acc_finance_table a where insert_date = (SELECT MAX(insert_date) dataDate FROM acc_finance_table where SUBSTRING(account_id,1,1) = 3 and insert_date <= '$to_date' and company_id = $company_id) and substr(a.account_id,1,1) = 3 and a.company_id = $company_id")->row();
		$expense = $this->db->query("SELECT ifnull(sum(year_opening_debit - year_opening_credit), 0) totalExpenseOpening, ifnull(sum(total_debit - total_credit), 0) totalExpenseCurrent from acc_finance_table a where insert_date = (SELECT MAX(insert_date) dataDate FROM acc_finance_table where SUBSTRING(account_id,1,1) = 4 and insert_date <= '$to_date' and company_id = $company_id) and substr(a.account_id,1,1) = 4 and a.company_id = $company_id
			")->row();

		$data['profitLoass'] = array('openingPLV' => ($income->totalIncomeOpening - $expense->totalExpenseOpening), 'currentPLV' => ($income->totalIncomeCurrent - $expense->totalExpenseCurrent));

		$data['withdraw'] = $this->db->query("SELECT b.account_name, a.account_id, '$from_date' fromDate, '$to_date' toDate, ifnull(sum(year_opening_credit - year_opening_debit), 0) totalCapitalOpening, ifnull(sum(total_credit - total_debit), 0) totalCapitalCurrent from acc_finance_table a inner join acc_chart_of_accounts b on a.account_id = b.account_id where insert_date = (SELECT MAX(insert_date) dataDate FROM acc_finance_table where SUBSTRING(account_id,1,409) = 20301 and insert_date <= '$to_date' and company_id = $company_id) and substr(a.account_id,1,409) = 20301 and a.company_id = $company_id")->result();


    	$data['view'] 	= 'ownersEquityReportPage';
    	$this->load->view('app/accounts/report/reportsTemplate',$data);
	}

	public function getTrialBalanceReport() {
		$from_date 	= blockScript($this->input->post('from_date'));
		$to_date 	= blockScript($this->input->post('to_date'));

    	//$date = date('d-M-Y', strtotime($from_date)).' To '.date('d-M-Y', strtotime($to_date));
		// Title generate
		/*if($from_date != '' and $to_date != ''){
			if($from_date != $to_date){
				$data['title'] 	= 'Trial Balance Report : From '.$date;
			}else{
				$data['title'] = 'Trial Balance Report : Date of '.date('d-M-Y', strtotime($from_date));
			}
		}else{			
			$data['title'] = 'Trial Balance Report';
		}*/

		if($to_date != ''){
			$data['title'] = 'Trial Balance Report : Date of '.date('d-M-Y', strtotime($to_date));
		}else{			
			$data['title'] = 'Trial Balance Report';
		}

		$company_id = $this->session->userdata("company_id");
		$where1 = "(acc_chart_of_accounts.acc_class_id='1' and acc_chart_of_accounts.account_id != '1' and acc_chart_of_accounts.company_id = $company_id) or (acc_chart_of_accounts.acc_class_id='4' and acc_chart_of_accounts.account_id != '4' and acc_chart_of_accounts.company_id = $company_id)";
    	$data['debitSite'] = $this->M_join->debitSide($where1, $from_date, $to_date, $company_id);

    	$where2 = "(acc_chart_of_accounts.acc_class_id='2' and acc_chart_of_accounts.account_id != '2' and acc_chart_of_accounts.company_id = $company_id) or (acc_chart_of_accounts.acc_class_id='3' and acc_chart_of_accounts.account_id != '3' and acc_chart_of_accounts.company_id = $company_id)";
    	$data['creditSite'] = $this->M_join->creditSide($where2, $from_date, $to_date, $company_id);

    	$data['view'] 	= 'trialBalanceReportPage';
    	$this->load->view('app/accounts/report/reportsTemplate',$data);
	}

	public function findBalanceSheet() {
		$data['title'] = 'Find Balance Sheet Report';
		if (checkUserAccess()) {
			$data['fyYearList'] = $this->M_join->getFinancialYearList();
			$data['from_year'] 	= $this->session->userdata("from_year");
			$data['to_year'] 	= $this->session->userdata("to_year");

			$data['content'] = "accounts/report/findBalanceSheetPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}


	public function balanceSheetReport() {
		$company_id = $this->session->userdata("company_id");
		$from_date 	= blockScript($this->input->post('from_date'));
		$to_date 	= blockScript($this->input->post('to_date'));

    	$date = date('d-M-Y', strtotime($from_date)).' To '.date('d-M-Y', strtotime($to_date));
		// Title generate
		if($from_date != '' and $to_date != ''){
			if($from_date != $to_date){
				$data['title'] 	= 'Balance Sheet Report : From '.$date;
			}else{
				$data['title'] = 'Balance Sheet Report : Date of '.date('d-M-Y', strtotime($from_date));
			}
		}else{			
			$data['title'] = 'Balance Sheet Report';
		}

		$company_id = $this->session->userdata("company_id");
		$where1 = "acc_chart_of_accounts.acc_class_id='1' and acc_chart_of_accounts.account_id != '1' and acc_chart_of_accounts.company_id = $company_id";
    	$data['debitSite'] 	= $this->M_join->debitSide($where1, $from_date, $to_date, $company_id);

    	$where2 = "acc_chart_of_accounts.acc_class_id='2' and acc_chart_of_accounts.account_id != '2' and acc_chart_of_accounts.company_id = $company_id";
    	$data['creditSite'] = $this->M_join->creditSide($where2, $from_date, $to_date, $company_id);

    	$data['view'] 	= 'balanceSheetReportPage';
    	$this->load->view('app/accounts/report/reportsTemplate', $data);
	}


	









}
