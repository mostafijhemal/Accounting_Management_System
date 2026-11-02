<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class AccVoucher extends CI_Controller {
	const  Title	 = 'App';
	const  InsertMsg = 'Insert Successfully';
	const  UpdateMsg = 'Update Successfully';
	const  DeleteMsg = 'Delete Successfully';
	
	static $model 	 = array('M_crud', 'M_join');
	static $helper   = array('url', 'authentication', 'customfunction');
	static $library  = array('session', 'user_agent', 'numbertowords');
	
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



	public function accountHeadIsExist() {
		$account_id = $this->input->post('account_id');
		$company_id = $this->session->userdata('company_id');

		$data = $this->M_crud->findById('acc_chart_of_accounts', array('account_id' => $account_id, 'company_id' => $company_id));

		echo json_encode($data);
	}

	// Get child ID
	public function get_child_id($account_id, $company_id){
		$query = $this->db->where('company_id', $company_id)->where('status', 'Child')->like('account_id', $account_id, 'after')->get('acc_chart_of_accounts');
		$data = array();
		foreach($query->result() as $rows){
			$data[] = $rows->account_id;
		}
		return $data;
	}


	public function manageVoucherType() {
		$data['title'] = 'Voucher Type Manage';
		if (checkUserAccess()) {
			$data['list'] = $this->M_crud->findAll('acc_voucher_type_list', array(), 'type_name', 'asc');
			$data['content'] = "accounts/voucher/voucherTypeCreatePage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function voucherTypeDataLoadForUpdate() {
		$id = blockScript($this->input->post('id'));
		$data = $this->M_crud->findById('acc_voucher_type_list', array('id' => $id));

		echo json_encode($data);
	}

	public function saveVoucherType() {
		if (checkUserAccess()) {
			$id = blockScript($this->input->post('id'));

			$data['type_name'] 		= blockScript($this->input->post('type_name'));
			$data['type_detail'] 	= blockScript($this->input->post('type_detail'));
			$data['status'] 		= blockScript($this->input->post('status'));

			if(!empty($id)){
				$this->db->update('acc_voucher_type_list', $data, array('id' => $id));
				$this->session->set_userdata(array('success' => 'Success', 'messege' => self::UpdateMsg));
			} else {
				$this->db->insert('acc_voucher_type_list', $data);
				$this->session->set_userdata(array('success' => 'Success', 'messege' => self::InsertMsg));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}
		
		redirect($this->agent->referrer());
	}

	public function journalVoucher(){
		$data['title'] = 'Create Voucher';
		if (checkUserAccess()) {
			$fyYearId = $this->session->userdata('financial_year_auto_id');
			if(!empty($fyYearId)) {
				$fyData = $this->M_crud->findById("financial_year_list", array("id" => $fyYearId));
				if($fyYearId == $fyData->id) {
					$data['success'] 	= $this->session->userdata('success');
					$data['messege'] 	= $this->session->userdata('messege');
									   	  $this->session->set_userdata(array('success' => '', 'messege'=> ''));

					$company_id = $this->session->userdata('company_id');
					$data['workingDay'] = $this->getLastOpenWorkingDay($company_id);
					if(!empty($data['workingDay'])) {
						$data['vTypeList'] 	= $this->M_crud->findAll('acc_voucher_type_list', array("status" => 'Active'), 'type_name', 'asc');
						$data['acHead'] 	= $this->M_crud->findAll('acc_chart_of_accounts', array('status' => 'Child', 'head_status' => 'Enable', 'company_id' => $company_id), 'account_name', 'asc');

						$where  = "(company_id = '$company_id' and voucher_no IS NULL AND check_by IS NULL AND current_station IS NULL) OR (company_id = '$company_id' and voucher_no IS NULL AND check_by IS NULL AND current_station = 'Prepare')";
						$data['list'] = $this->allNewJournalVoucher($where);

						$data['content'] = "accounts/voucher/journalVoucherPage";
					} else {
						$data['content'] = "common/dayOpenAlert";
					}
				} else {
					redirect('user/login');
				}
			} else {
				$data['content'] = "common/companyInformationUpdateAlertPage";
			}
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}


	public function getLastOpenWorkingDay($company_id = 0) {
		$row = $this->db->select("working_date")
			->from("working_day_open_close")
			->where(array("company_id" => $company_id, "status" => "Open"))
			->order_by("working_date desc")
			->get()
			->row('working_date');
		return $row;
	}


	private function allNewJournalVoucher($where) {
		$data = $this->db->select('vi.*')
		->select('SUM(vd.debit) as totalVoucherAmount')
		->select('vtl.type_name')
		->from("acc_voucher_info vi")
        ->join('acc_voucher_details vd', 'vi.id = vd.voucher_info_auto_id', 'left')
        ->join('acc_voucher_type_list vtl', 'vi.voucher_type_auto_id = vtl.id', 'left')
		->where($where)
		->group_by('vi.id')
		->order_by('vi.serial_no', 'desc')
		->get()->result();

		return $data;
	}

	private function getVoucherDetail($id = 0) {
		$company_id = $this->session->userdata('company_id');
		$data = $this->db->select('vd.*')
		->select('ca.account_name')
        ->from("acc_voucher_details vd")
        ->join('acc_chart_of_accounts ca', "vd.account_id = ca.account_id AND ca.company_id = $company_id", 'left')
        ->where(array('vd.voucher_info_auto_id' => $id))
        ->order_by("vd.id asc")
        ->get()->result();
		
		return $data;
	}

	private function getVoucherInfo($id=0) {
		$data = $this->db->select('vi.*')
		->select('SUM(vd.debit) as totalVoucherAmount')
		->select('vtl.type_name')
		->select('com.short_name')
		->from("acc_voucher_info vi")
        ->join('acc_voucher_details vd', 'vi.id = vd.voucher_info_auto_id', 'left')
        ->join('acc_voucher_type_list vtl', 'vi.voucher_type_auto_id = vtl.id', 'left')
        ->join('company_register_table com', 'vi.company_id = com.id', 'left')
		 ->where(array('vi.id' => $id))
		->get()->row();

		return $data;
	}

	public function voucherDataLoadForUpdate() {
		$id = $this->input->post('id');
		$data['info'] 	= $this->getVoucherInfo($id);
		$data['vlist'] 	= $this->getVoucherDetail($id);

		echo json_encode($data);
	}

	public function journalVoucherSave() {
		if (checkUserAccess()) {
			$this->db->trans_start();
			$company_id 			= $this->session->userdata('company_id');
			$data['company_id'] 	= $company_id;

			$data['prepare_by'] 	= $this->session->userdata('app_userid');
			$data['current_station']= NULL;

			$id = $this->input->post('id');

			$data["voucher_type_auto_id"] 	= blockScript($this->input->post('voucher_type_auto_id'));
			$userType 	= $this->session->userdata('app_user_type_id');
			if($userType != 1) {
				$voucher_date 				= $this->getLastOpenWorkingDay($company_id);
			} else {
				$voucher_date 				= blockScript($this->input->post('voucher_date'));
			}
			$data['voucher_date'] 			= $voucher_date;
			$data['voucher_detail'] 		= blockScript($this->input->post('voucher_detail'));
			$data['system_date']			= date("Y-m-d H:i:s");
			$data["financial_year_auto_id"] = $this->session->userdata("financial_year_auto_id");

			if(empty($id)) {
				$maxRow = $this->M_crud->findMax("acc_voucher_info", array('company_id' => $company_id), 'serial_no');
				if(isset($maxRow) && !empty($maxRow)) {
					$serial_no = ($maxRow->serial_no + 1);
				} else {
					$serial_no = 1;
				}
				$data['serial_no'] 	= $serial_no;

				$lastId = $this->M_crud->save("acc_voucher_info", $data);
				$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::InsertMsg));
			} else {
				$vData = $this->M_crud->findById("acc_voucher_info", array('id' => $id));
				if($vData->check_by == NULL) {
					$lastId = $id;
					$this->db->update("acc_voucher_info", $data, array('id' => $id));
					$this->db->delete("acc_voucher_details", array('voucher_info_auto_id' => $id));
					$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::UpdateMsg));
				} else {
					$this->session->set_userdata(array('success' => 'Success', 'messege' => "Some things is Wrong Data Cannot be deleted"));
					$lastId = '';
				}
			}

			$debitHeadList 			= $this->input->post('debitHead');
			$amountDebitList 		= $this->input->post('amountDebit');
			$amountCreditList 		= $this->input->post('amountCredit');
			$narrationList 			= $this->input->post('narration');

			$j = 0;
			if($lastId != '') {
				foreach ($debitHeadList as $i => $value) {
					$data2[$j]['voucher_info_auto_id'] 	= $lastId;
					$data2[$j]['account_id'] 			= blockScript($debitHeadList[$i]);
					if(!empty($amountDebitList[$i])) {
						$data2[$j]['debit'] 			= blockScript($amountDebitList[$i]);
					} else {
						$data2[$j]['debit'] 			= NULL;
					}
					if(!empty($amountCreditList[$i])) {
						$data2[$j]['credit'] 			= blockScript($amountCreditList[$i]);
					} else {
						$data2[$j]['credit'] 			= NULL;
					}
					$data2[$j]['narration'] 			= blockScript($narrationList[$i]);

					$j++;
				}
				$this->db->insert_batch('acc_voucher_details', $data2);
			}
			
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			    $this->session->set_userdata(array('success' => 'Success', 'messege' => "Some things is Wrong Data Cannot be Insert"));
			} else {
				$this->db->trans_complete();
				if(empty($id)) {
					$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::InsertMsg));
				} else {
					if($lastId != '') {
						$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::UpdateMsg));
					}
				}
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}

		redirect($this->agent->referrer());
	}

	public function deleteVoucher($id = 0) {
		if (checkUserAccess()) {
			$data = $this->M_crud->findById("acc_voucher_info", array('id' => $id));
			if($data->check_by == NULL) {
				$this->db->delete("acc_voucher_details", array('voucher_info_auto_id' => $id));
				$this->db->delete("acc_voucher_info", array('id' => $id));
			} else {
				$this->session->set_userdata(array('success' => 'Success', 'messege' => "Some things is Wrong Data Cannot be deleted"));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}
		redirect($this->agent->referrer());
	}

	//Voucher report
    public function voucher($id = 0){
    	$data['title'] 	= 'Voucher Report';
		if (checkUserAccess()) {
			$data['info'] 	= $this->getVoucherInfo($id);
			$data['list'] 	= $this->getVoucherDetail($id);
			// get voucher date
			$data['date'] = date('d-M-Y', strtotime($data['info']->voucher_date));

			if(!empty($data['info']->voucher_no)) {
				$data['voucherN'] = "Voucher No : ".$data['info']->short_name.'-'.$data['info']->voucher_no;
			} else {
				$data['voucherN'] = "Serial No : ".$data['info']->short_name.'-'.$data['info']->serial_no;
			}

			$data['title'] 	= $data['info']->type_name." Report";
			$data['view'] 	= 'journalVoucherReportPage';				
		} else {
			$data['view'] 	= 'journalVoucherReportPage';
		}

		$this->load->view('app/accounts/report/reportsTemplate',$data);
    }

	public function openingDataEntry(){
		$data['title'] = 'Opening Data Entry';
		$company_id = $this->session->userdata('company_id');
		if (checkUserAccess()) {
			$data['success'] 	= $this->session->userdata('success');
			$data['messege'] 	= $this->session->userdata('messege');
							   	  $this->session->set_userdata(array('success' => '', 'messege'=> ''));

			$data['acHead'] 	= $this->M_crud->findAll('acc_chart_of_accounts', array('status' => 'Child', 'head_status' => 'Enable', 'company_id' => $company_id), 'account_name', 'asc');

			$data['list'] = $this->M_join->findAllSingleEntryDate($company_id);

			$data['content'] = "accounts/voucher/openingEntryPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function openingDataSave(){
		if (checkUserAccess()) {
			$lastData 					= 0;
			$id 						= $this->input->post('id');
			$data['company_id'] 		= $this->session->userdata('company_id');
			$fullHead 					= blockScript($this->input->post('head'));
			$headArr 					= explode('-', $fullHead);
			$lastData 					= (sizeof($headArr) - 1);
			$data['account_id'] 		= trim($headArr[$lastData]);
			$data['voucher_date'] 		= blockScript($this->input->post('voucher_date'));
			$data['system_date'] 		= date('Y-m-d H:i:s');
			$data["financial_year_auto_id"] = $this->session->userdata("financial_year_auto_id");

			$debit 	= blockScript($this->input->post('debit'));
			$credit = blockScript($this->input->post('credit'));

			$data['debit'] 	= $debit?$debit:0;
			$data['credit'] = $credit?$credit:0;

			if($fullHead == "") {
				$this->session->set_userdata(array('success' => 'Error', 'messege' => "Account Head is Empty."));
				redirect($this->agent->referrer());
			}

			if($data['debit'] == 0 && $data['credit'] == 0) {
				$this->session->set_userdata(array('success' => 'Error', 'messege' => "Debit and Credit Both are 0."));
				redirect($this->agent->referrer());
			}
			$data['narration'] = blockScript($this->input->post('narration'));
			
			if(empty($id)) {
				$this->M_crud->save("acc_ledger_data", $data);
				$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::InsertMsg));
			} else {
				$this->db->update("acc_ledger_data", $data, array('id' => $id));
				$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::UpdateMsg));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}
		redirect($this->agent->referrer());
	}

	public function openingDataApprove() {
		if (checkUserAccess()) {
			$id = $this->input->post('id');

			$row = $this->M_crud->findById("acc_ledger_data", array('id' => $id));
			if($row->opening_approve == 1) {
				$company_id = $row->company_id;
				$data['opening_approve'] = 2; // Opening Approve
				$this->db->update("acc_ledger_data", $data, array('id' => $id));
				
				
				$aftWhere = array("status" => "Active", "company_id" => $company_id, "account_id" => $row->account_id);
				$fTData   = $this->M_crud->findById("acc_finance_table", $aftWhere);
				$insertData = date('Y-m-d');
				if(!empty($fTData)) {
					if($fTData->insert_date == $insertData) {
						$update = true;
					} else {
						$update = false;
					}
				} else {
					$update = false;
				}

				$debit 	= $row->debit;
				$credit = $row->credit;
				
				if($update) {
					$upfData['total_debit'] 	= ($debit + $fTData->total_debit);
					$upfData['total_credit'] 	= ($credit + $fTData->total_credit);
					$this->db->update("acc_finance_table", $upfData, array('id' => $fTData->id));
				} else {
					if(!empty($fTData)) {
						if($insertData != $fTData->insert_date) {
							$this->db->update("acc_finance_table", array("status" => "Inactive"), $aftWhere);
						}

						if(!empty($fTData->total_debit)) {
							$day_opening_debit = $fTData->total_debit;
						} else {
							$day_opening_debit = 0;
						}

						if(!empty($fTData->total_credit)) {
							$day_opening_credit = $fTData->total_credit;
						} else {
							$day_opening_credit = 0;
						}
						$fData['year_opening_debit'] 	= $fTData->year_opening_debit;
						$fData['year_opening_credit'] 	= $fTData->year_opening_credit;
						$fData['day_opening_debit'] 	= $day_opening_debit;
						$fData['day_opening_credit'] 	= $day_opening_credit;

						$totalDebit  = $fTData->total_debit;
						$totalCredit = $fTData->total_credit;
					} else {
						$totalDebit  = 0;
						$totalCredit = 0;
					}
					// $this->session->userdata("financial_year_auto_id");
					$fData['company_id'] 			= $row->company_id;
					$fData['financial_year_auto_id']= $row->financial_year_auto_id;
					$fData['insert_date'] 			= $insertData;
					$fData['account_id'] 			= $row->account_id;
					$fData['total_debit'] 			= ($debit + $totalDebit);
					$fData['total_credit'] 			= ($credit + $totalCredit);
					$this->db->insert("acc_finance_table", $fData);
				}
				$this->session->set_userdata(array('success' => 'Success', 'messege' => "Opening Approve Successfully"));
			} else {
				$this->session->set_userdata(array('success' => 'Success', 'messege' => "Some things is Wrong Data Cannot be Approve"));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}
		echo "data";
	}

	public function getOpeningDataForEdit() {
		$id 	= blockScript($this->input->post('id'));
		$data 	= $this->getOpeningData($id);
		echo json_encode($data);
	}

	public function getOpeningData($id = 0) {
		$company_id = $this->session->userdata('company_id');
		$row = $this->db->select("ald.id,ald.voucher_date,ald.debit,ald.credit,ald.narration")
			->select("CONCAT(ca.account_name, ' - ', ald.account_id) as acc_name")
			->from("acc_ledger_data ald")
			->join("acc_chart_of_accounts ca", "ca.account_id = ald.account_id AND ca.company_id = $company_id")
			->where("ald.id", $id)
			->get()->row();

		return $row;
	}

	public function checkVoucher() {
		$data['title'] = 'Voucher List For Check';
		if (checkUserAccess()) {
			$data['success'] 	= $this->session->userdata('success');
			$data['messege'] 	= $this->session->userdata('messege');
							   	  $this->session->set_userdata(array('success' => '', 'messege'=> ''));

			$company_id = $this->session->userdata('company_id');
			$where  = "(company_id = '$company_id' and voucher_no IS NULL AND check_by IS NULL AND current_station IS NULL) OR (company_id = '$company_id' and voucher_no IS NULL AND check_by IS NULL AND current_station = 'Check')";
			$data['list'] = $this->allNewJournalVoucher($where);

			$data['content'] = "accounts/voucher/checkVoucherPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function checkVoucherAction($id) {
		if (checkUserAccess()) {
			$data = $this->M_crud->findById("acc_voucher_info", array('id' => $id));
			if($data->check_by == NULL) {
				$data = array(
					'check_by' => $this->session->userdata('app_userid'),
					'current_station' => 'Approve'
				);
				$this->db->update("acc_voucher_info", $data, array('id' => $id));
			} else {
				$this->session->set_userdata(array('success' => 'Success', 'messege' => "Some things is Wrong Data Cannot be Check"));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}
		redirect($this->agent->referrer());
	}

	public function voucherReturnToCreateAction($id) {
		if (checkUserAccess()) {
			$data = $this->M_crud->findById("acc_voucher_info", array('id' => $id));
			if($data->check_by == NULL) {
				$data = array(
					'check_by' => NULL,
					'current_station' => 'Prepare'
				);
				$this->db->update("acc_voucher_info", $data, array('id' => $id));
			} else {
				$this->session->set_userdata(array('success' => 'Success', 'messege' => "Some things is Wrong Data Cannot be Check"));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}

		redirect($this->agent->referrer());
	}

	public function approveVoucher() {
		$data['title'] = 'Voucher List For Approve';
		if (checkUserAccess()) {
			$data['success'] 	= $this->session->userdata('success');
			$data['messege'] 	= $this->session->userdata('messege');
							   	  $this->session->set_userdata(array('success' => '', 'messege'=> ''));

			$company_id = $this->session->userdata('company_id');
			$where  = "company_id = '$company_id' and voucher_no IS NULL AND check_by IS NOT NULL AND current_station = 'Approve'";
			$data['list'] = $this->allNewJournalVoucher($where);

			$data['content'] = "accounts/voucher/approveVoucherPage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function approveVoucherAction($id) {
		if (checkUserAccess()) {
			$data = $this->M_crud->findById("acc_voucher_info", array('id' => $id));
			if($data->current_station == "Approve") {
				$this->db->trans_start();
				$company_id = $this->session->userdata('company_id');
				$maxRow = $this->M_crud->findMax("acc_voucher_info", array('company_id' => $company_id), 'voucher_no');
				if(isset($maxRow) && !empty($maxRow)) {
					$voucher_no = ($maxRow->voucher_no + 1);
				} else {
					$voucher_no = 1;
				}
				$data = array(
					'voucher_no' 		=> $voucher_no,
					'approve_by' 		=> $this->session->userdata('app_userid'),
					'current_station' 	=> NULL
				);
				$this->db->update("acc_voucher_info", $data, array('id' => $id));
				$voucherData = $this->getAllDataInAVoucher($id);
				
				$i = 0;
				$sysDate = date("Y-m-d H:i:s");
				foreach ($voucherData as $v) {
					$lData[$i]['company_id'] 			= $v->company_id;
					$lData[$i]['financial_year_auto_id']= $v->financial_year_auto_id;
					$lData[$i]['voucher_info_auto_id'] 	= $v->voucher_info_auto_id;
					$lData[$i]['voucher_no'] 			= $v->voucher_no;
					$lData[$i]['voucher_date'] 			= $v->voucher_date;
					$lData[$i]['system_date'] 			= $sysDate;
					$lData[$i]['account_id'] 			= $v->account_id;
					$lData[$i]['debit'] 				= $v->debit ?: 0;
					$lData[$i]['credit'] 				= $v->credit ?: 0;
					$lData[$i]['narration'] 			= $v->narration;
					$i++;
				}

				$this->db->insert_batch("acc_ledger_data", $lData);

				$insertData 	= date('Y-m-d', strtotime($sysDate));
				$getLedgerData 	= $this->M_crud->findAll("acc_ledger_data", array("voucher_info_auto_id" => $id, "company_id" => $company_id), 'id', 'asc');
				
				foreach ($getLedgerData as $lv) {
					$aftWhere = array("status" => "Active", "company_id" => $company_id, "account_id" => $lv->account_id);
					$fTData   = $this->M_crud->findById("acc_finance_table", $aftWhere);

					if(!empty($fTData)) {
						if($fTData->insert_date == $insertData) {
							$update = true;
						} else {
							$update = false;
						}
					} else {
						$update = false;
					}

					$debit 	= $lv->debit;
					$credit = $lv->credit;
					
					if($update) {
						$upfData['total_debit'] 	= ($debit + $fTData->total_debit);
						$upfData['total_credit'] 	= ($credit + $fTData->total_credit);
						$this->db->update("acc_finance_table", $upfData, array('id' => $fTData->id));
					} else {
						if(!empty($fTData)) {
							if($insertData != $fTData->insert_date) {
								$this->db->update("acc_finance_table", array("status" => "Inactive"), $aftWhere);
							}

							if(!empty($fTData->total_debit)) {
								$day_opening_debit = $fTData->total_debit;
							} else {
								$day_opening_debit = 0;
							}

							if(!empty($fTData->total_credit)) {
								$day_opening_credit = $fTData->total_credit;
							} else {
								$day_opening_credit = 0;
							}
							$fData['year_opening_debit'] 	= $fTData->year_opening_debit;
							$fData['year_opening_credit'] 	= $fTData->year_opening_credit;
							$fData['day_opening_debit'] 	= $day_opening_debit;
							$fData['day_opening_credit'] 	= $day_opening_credit;

							$totalDebit  = $fTData->total_debit;
							$totalCredit = $fTData->total_credit;
						} else {
							$totalDebit  = 0;
							$totalCredit = 0;
						}
						// $this->session->userdata("financial_year_auto_id");
						$fData['company_id'] 			= $lv->company_id;
						$fData['financial_year_auto_id']= $lv->financial_year_auto_id;
						$fData['insert_date'] 			= $insertData;
						$fData['account_id'] 			= $lv->account_id;
						$fData['total_debit'] 			= ($debit + $totalDebit);
						$fData['total_credit'] 			= ($credit + $totalCredit);
						$this->db->insert("acc_finance_table", $fData);

						$fTData = null;
					}
				}
				
				if($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
				    $this->session->set_userdata(array('success' => 'Success', 'messege' => "Some things is Wrong Data Cannot be Approve"));
				} else {
					$this->db->trans_complete();
					$this->session->set_userdata(array('success' => 'Success', 'messege' => "Voucher Approve Successfully"));
				}
			} else {
				$this->session->set_userdata(array('success' => 'Success', 'messege' => "Some things is Wrong Data Cannot be Approve"));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}

		redirect($this->agent->referrer());
	}

	public function getAllDataInAVoucher($id = 0) {
		$result = $this->db->select("acc_voucher_details.*")
			->select("acc_voucher_info.company_id,financial_year_auto_id,voucher_no,voucher_date")
			->from("acc_voucher_details")
			->join("acc_voucher_info", "acc_voucher_details.voucher_info_auto_id = acc_voucher_info.id", "left")
			->where(array('acc_voucher_details.voucher_info_auto_id' => $id))
			->order_by("acc_voucher_details.id asc")
			->get()->result();

		return $result;
	}

	public function voucherReturnToCheckAction($id) {
		if (checkUserAccess()) {
			$data = $this->M_crud->findById("acc_voucher_info", array('id' => $id));
			if($data->current_station == "Approve") {
				$data = array(
					'check_by' 			=> NULL,
					'approve_by' 		=> NULL,
					'current_station' 	=> 'Check'
				);
				$this->db->update("acc_voucher_info", $data, array('id' => $id));
			} else {
				$this->session->set_userdata(array('success' => 'Success', 'messege' => "Some things is Wrong Data Cannot be Return To Check"));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}

		redirect($this->agent->referrer());
	}

	public function dayOpenOrClosePage($onset = 0) {
		$this->load->library('pagination');
		$data['title'] = 'Day Open Or Close Page';
		if (checkUserAccess()) {
			$data['success'] 	= $this->session->userdata('success');
			$data['messege'] 	= $this->session->userdata('messege');
							   	  $this->session->set_userdata(array('success' => '', 'messege'=> ''));

			$company_id 	= $this->session->userdata('company_id');
			$where 			= array("working_day_open_close.company_id" => $company_id);
			$data['list'] 	= $this->M_join->getAllWorkingDayList($where, $onset, 50);

			$data['onset'] 			= $onset;
			$config['base_url'] 	= base_url('acc/dayOpenClose/');
			$config['total_rows'] 	= $this->M_crud->countAll('working_day_open_close', $where);
			$config['uri_segment'] 	= 3;
			$config['per_page'] 	= 50;
			$config['num_links'] 	= 7;
			$config['first_link']	= FALSE;
			$config['last_link'] 	= FALSE;
			$config['prev_link']	= 'Prev';
			$config['next_link'] 	= 'Next'; 
			$this->pagination->initialize($config);

			$data['content'] = "accounts/voucher/dayOpenOrClosePage";
		} else {
			$data['content'] = "common/pageNotAccessPage";
		}
		$this->load->view('app/dashboardPage', $data);
	}

	public function dayOpenOrCloseSaveAction() {
		if (checkUserAccess()) {
			$id = blockScript($this->input->post('id'));

			$data["company_id"] 			= $this->session->userdata('company_id');
			$data["admin_id"] 				= $this->session->userdata('app_userid');
			$data["working_date"] 			= blockScript($this->input->post('working_date'));
			$data["permanent_close_date"] 	= blockScript($this->input->post('permanent_close_date'));
			$data["status"] 				= blockScript($this->input->post('status'));

			if(empty($id)) {
				$data['system_date'] = date("Y-m-d");
				$this->M_crud->save("working_day_open_close", $data);
				$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::InsertMsg));
			} else {
				$this->db->update("working_day_open_close", $data, array('id' => $id));
				$this->session->set_userdata(array('success' => 'Success', 'messege'=> self::UpdateMsg));
			}
		} else {
			$this->session->set_userdata(array('success' => 'Success', 'messege' => "We are really sorry this action is not allowed for you"));
		}

		redirect($this->agent->referrer());
	}

	public function getDayOpenCloseDataForEdit() {
		$id = blockScript($this->input->post("id"));

		$data = $this->M_crud->findById("working_day_open_close", array("id" => $id));
		echo json_encode($data);
 	}







}
