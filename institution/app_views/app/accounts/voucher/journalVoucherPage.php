<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>
		

<!-- view Page Access function   -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				Journal Voucher
				<small>
					<i class="fa fa-angle-double-right"></i>
					Create &amp; Summary
				</small>
			</h1>
		</div><!-- /.page-header -->
		
		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<!-- PAGE CONTENT BEGINS -->

				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>

					<i class="fa fa-check-square-o green"></i>

					Journal Voucher Create Panel
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<form method="post" action="<?php echo site_url('acc/voucherSave'); ?>">
							<div class="table-header uppercase">
								Journal Entry
							</div>
							<div class="border_ddd">
								<div class="row">
									<input type="hidden" name="id" id="id">
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-3">
											<label for="voucher_type_auto_id">Voucher Type <span class="red">*</span></label>
											<select class="form-control" name="voucher_type_auto_id" id="voucher_type_auto_id" required  autocomplete="off">
												<option value="">Select One</option>
												<?php if (isset($vTypeList) && !empty($vTypeList)): ?>
													<?php foreach ($vTypeList as $vtlv): ?>
														<option value="<?php echo $vtlv->id; ?>"><?php echo $vtlv->type_name; ?></option>
													<?php endforeach ?>
												<?php endif ?>
											</select>
										</div>
										<div class="col-xs-12 col-sm-3">
											<label for="voucher_date">Voucher Date <span class="red">*</span></label>
											<?php 
												$userType 	= $this->session->userdata('app_user_type_id');
												if ($userType == 1 || $userType == 3):

											 ?>
												<input type="text" class="form-control date-picker" name="voucher_date" required id="voucher_date" value="<?php if (!empty($rowData->voucher_date) && !empty($rowData)) echo($rowData->voucher_date); else echo $workingDay; ?>">
											
											<?php else: ?>
												<input type="text" class="form-control" name="voucher_date" readonly required id="voucher_date" value="<?php if (!empty($rowData->voucher_date) && !empty($rowData)) echo($rowData->voucher_date); else echo $workingDay; ?>">
											<?php endif ?>
										</div>
										<div class="col-xs-12 col-sm-6">
											<label for="voucher_detail">Voucher Detail</label>
											<textarea style="height: 34px;" class="form-control" name="voucher_detail" id="voucher_detail" ></textarea>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-12">
											<div style="margin-top: 10px; border: 1px solid;padding: 3px 0 12px 0;">
												<div class="row">
													<div class="col-xs-12 col-sm-12">
														<div class="row">
															<div class="col-xs-12 col-sm-12">
																<div class="col-xs-12 col-sm-6">
																	<label for="debitHead">Account Head</label>
																	<input type="text" list="accHeadList" class="form-control" id="debitHead" autocomplete="off">
																	<datalist id="accHeadList">
																		<?php 
																			if(!empty($acHead)) {
																				foreach ($acHead as $v1) {
																					echo '<option value="'.$v1->account_name.' - '.$v1->account_id.'">';
																				}
																			}
																		 ?>
																	</datalist>
																</div>
																<div class="col-xs-12 col-sm-3">
																	<label for="amountDebit">Debit (BDT)</label>
																	<!--  onkeyup="this.value=this.value.replace(/[^\d]/,'')" -->
																	<input type="number" class="form-control text-right" id="amountDebit" >
																</div>
																<div class="col-xs-12 col-sm-3">
																	<label for="amountCredit">Credit (BDT)</label>
																	<!--  onkeyup="this.value=this.value.replace(/[^\d]/,'')" -->
																	<input type="number" class="form-control text-right" id="amountCredit">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-xs-12 col-sm-12">
																<div class="col-xs-12 col-sm-10">
																	<label for="narration">Narration</label>
																	<textarea style="height: 34px;" class="form-control" id="narration" placeholder="Narration"></textarea>
																</div>
																<div class="col-xs-12 col-sm-2">
																	<label for="">&nbsp;</label>
																	<input type="button" class="form-control btn btn-primary" id="addNew" value="Add New">
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-12">&nbsp;</div>
										<div class="col-xs-12 col-sm-12">
											<div style="overflow-x: hidden; height: 300px; margin-top: 10px; border: 1px solid;">
												<div id="listView" class="table-responsive"> 
													<table id="dynamic-table" class="table table-striped table-bordered table-hover">
														<thead>
															<tr class="uppercase">
																<th class="text-center">Account Head</th>
																<th class="text-center">Debit (BDT)</th>
																<th class="text-center">Credit (BDT)</th>
																<th class="text-center">NARRATION</th>
																<th class="text-center">ACTION</th>
															</tr>
														</thead>
														<tbody id="appendTbody">
															<!-- append Tr -->
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-12">&nbsp;</div>
										<div class="col-xs-12 col-sm-9">
											<div class="row">
												<div class="col-xs-12 col-sm-6">
													<div class="form-group">
													    <div class="row">
													    	<label for="" class="col-sm-4 control-label">Total Debit</label>
														    <div class="col-sm-8">
														      	<input readonly class="form-control text-right" id="totalDebitAmount" value="0">
													    	</div>
													    </div>
												  	</div>
												</div>
												<div class="col-xs-12 col-sm-6">
													<div class="form-group">
													    <div class="row">
													    	<label for="" class="col-sm-4 control-label">Total Credit</label>
														    <div class="col-sm-8">
														      	<input readonly class="form-control text-right" id="totalCreditAmount" value="0">
													    	</div>
													    </div>
												  	</div>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-3">
											<input type="submit" id="save" class="form-control btn btn-primary" value="Submit">
										</div>
									</div>
								</div>
							</div>
						</form>


						<?php if (isset($list) && !empty($list)) { ?>
						<div>&nbsp;</div>
						<div id="listView" class="table-responsive"> 
						 	<div class="table-header uppercase">
								New Voucher List
							</div>
							<table id="dynamic-table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr class="uppercase">
										<th class="text-center">#</th>
										<th class="text-center">Type</th>
										<th class="text-center">Serial No</th>
										<th class="text-center">Detail</th>
										<th class="text-center">Amount</th>
										<th class="text-center">Status</th>
										<th style="width: 100px;" class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i = 1;
										foreach ($list as $vlv) {
									 ?>
									<tr>
										<td class="text-center"><?php echo $i++; ?></td>
										<td class="text-center">
											<?php echo $vlv->type_name; ?>
										</td>
										<td class="text-center"><?php echo $vlv->serial_no; ?></td>
										<td><?php echo $vlv->voucher_detail; ?></td>
										<td class="text-right">
											<?php echo number_format($vlv->totalVoucherAmount, 2); ?>
										</td>
										<td class="text-center">
											<?php 
												if($vlv->current_station == 'Prepare'){
													echo '<span class="red">Returned</span>';
												} else {
													echo "Prepare";
												}
											 ?>
										</td>
										<td class="text-center">
											<div class="btn-group">
											   	<table>
													<tbody>
														<tr>
															<td style="padding: 0 5px;">
														   		<a href="<?php echo($vlv->id); ?>" class="green">
																	<button class="btn btn-xs btn-info" data-rel="tooltip" title="Edit" data-placement="bottom">
																		<i class="ace-icon fa fa-pencil bigger-120"></i>
																	</button>
																</a>
															</td>
															<td style="padding: 0 5px;">
				                                               	<a href="<?php echo(site_url('acc/dVoucer/'.$vlv->id)); ?>" class="red">
																	<button class="btn btn-xs btn-danger" data-rel="tooltip" title="Delete" data-placement="bottom">
																	    <i class="ace-icon fa fa-trash-o bigger-120"></i>
																	</button>
															   	</a>
															</td>
															<td style="padding: 0 5px;">
															   	<a target="blank" href="<?php echo site_url("accReport/voucher/$vlv->id"); ?>" style="display: block;">
																	<button class="btn btn-xs btn-info" data-rel="tooltip" title="View" data-placement="bottom">
																	    View
																	</button>
																</a>
															</td>
														</tr>
													</tbody>
												</table>
											</div>													
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<?php } ?>
					</div>
				</div>
				<!-- PAGE CONTENT ENDS -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->
<script type="text/javascript">
	$(document).on('click', '#save', function(e) {
		var totalDebitAmount 	= $('#totalDebitAmount').val();
		var totalCreditAmount 	= $('#totalCreditAmount').val();
		if(totalDebitAmount == 0){
			alert('Data List Empty....');
			return false;
		} 
		if(+totalDebitAmount != +totalCreditAmount) {
			alert("Debit And Credit Amount Must be Equal....");
			return false;
		} else {
			return true;
		}
		
		e.preventDefault();
	});

	$(document).on('blur', '#amountDebit, #amountCredit', function(e) {
		var thisData = $(this);
		var thisVal = thisData.val();
		if(!isNaN(thisVal)) {
			if(thisVal != "") {
				if(+thisVal < 0) {
					alert("Amount cannot be less then 0.");
					thisData.val("").focus();
				}
			} else {
				thisData.val("");
			}
		} else {
			thisData.val("");
		}

		e.preventDefault();
	});

	$(document).on('blur', '#debitHead', function(){
		var debitHead 	= $(this).val();
		if(debitHead == '') {
			return false;
		}
		var arrayHead 	= debitHead.split(' ');
		var lastIndex  = (arrayHead.length - 1);

		$.ajax( {
			url 	: "<?php echo site_url('acc/checkAccHead'); ?>",
			type 	: "POST",
			data 	: {account_id:arrayHead[lastIndex]},
			dataType: "json",
			success : function(data){
				if(data != null){
					$('#amountDebit').focus();
				} else {
					alert('Data Not Match with Chart of Accounts...');
					$('#debitHead').val('').focus();
					return false;
				}
			},
	      	error: function (xhr, ajaxOptions, thrownError) {
	        	alert('Something is Wrong...');
				return false;
	        }
		});
	});

	$(document).on('click', '#addNew', function(){
		//
			var thisElement = $(this);
			thisElement.attr('disabled', true);

			var debitHead  	= $('#debitHead').val();
			var dArrayHead  = debitHead.split(' ');
			var dLastIndex  = (dArrayHead.length - 1);
			if(debitHead == '') {
				alert('Account Head Field is Empty....');
				thisElement.removeAttr('disabled');
				return false;
			}

			var amountDebit 	= $('#amountDebit').val();
			var amountCredit	= $('#amountCredit').val();
			var narration  		= $('#narration').val();

			if((amountDebit == '' && amountCredit == '') || (amountDebit != '' && amountCredit != '')) {
				if(amountDebit == '' && amountCredit == '') {
					alert('Amount Field Both are Empty....');
				} 
				if(amountDebit != '' && amountCredit != '') {
					alert("Amount Field Both aren't Empty....");
				}
				thisElement.removeAttr('disabled');
				return false;
			}
		//

		$('#appendTbody').append('<tr class="listTr">\
			<td class="text-center">\
				<span class="debit_account_head">'+debitHead+'</span>\
				<input type="hidden" name="debitHead[]" value="'+dArrayHead[dLastIndex]+'">\
			</td>\
			<td class="text-right">\
				<span>'+amountDebit+'</span>\
				<input type="hidden" class="amountDebit" name="amountDebit[]" value="'+amountDebit+'">\
			</td>\
			<td class="text-right">\
				<span>'+amountCredit+'</span>\
				<input type="hidden" class="amountCredit" name="amountCredit[]" value="'+amountCredit+'">\
			</td>\
			<td class="text-center">\
				<span>'+narration+'</span>\
				<input type="hidden" class="narration" name="narration[]" value="'+narration+'">\
			</td>\
			<td class="text-center">\
				<a href="#">\
					<i class="editRow fa fa-pencil-square-o"></i>\
				</a>\
				&nbsp;&nbsp;\
				<a href="#">\
					<i class="removeRow fa fa-trash-o" aria-hidden="true"></i>\
				</a>\
			</td>\
		</tr>');

		$('#debitHead').val('');
		$('#amountDebit').val('');
		$('#amountCredit').val('');
		$('#narration').val('');
		sumListAmount();
		thisElement.removeAttr('disabled');
	});

	$(document).on('click', '.editRow', function(e){
		var parentsTr 			= $(this).parents('tr');
		var debit_account_head	= parentsTr.find('.debit_account_head').text();

		var amountDebit 		= parentsTr.find('.amountDebit').val();
		var amountCredit 		= parentsTr.find('.amountCredit').val();
		var Narration 			= parentsTr.find('.narration').val();

		$('#debitHead').val(debit_account_head);
		$('#amountDebit').val(amountDebit);
		$('#amountCredit').val(amountCredit);
		$('#narration').val(Narration);
		parentsTr.remove();

		sumListAmount();
		e.preventDefault();
	});

	$(document).on('click', '.removeRow', function(e){
		var parentsTr 	= $(this).parents('tr');
		parentsTr.remove();

		sumListAmount();

		e.preventDefault();
	});

	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	});

	function sumListAmount() {
		var sum = 0;
	    $('.listTr').each(function(key, element) {
	        sum += Number($(this).find('.amountDebit').val());
	    });
	    $("#totalDebitAmount").val(sum);

		var sum = 0;
	    $('.listTr').each(function(key, element) {
	        sum += Number($(this).find('.amountCredit').val());
	    });
	    $("#totalCreditAmount").val(sum);
	}


	$(document).on('click', '.green', function(e){
		startLoading();
		var id = $(this).attr("href");
		$('#save').val("Save");

		$.ajax( {
			url 	: "<?php echo site_url('acc/getVDataFUpdate'); ?>",
			type 	: "POST",
			data 	: {id:id},
			dataType: "json",
			success : function(data){
				$('#id').val(data.info.id);
				$('#voucher_type_auto_id').val(data.info.voucher_type_auto_id);
				$('#voucher_date').val(data.info.voucher_date);
				$('#voucher_detail').val(data.info.voucher_detail);
				$('#voucher_detail').val(data.info.voucher_detail);
				$("#totalDebitAmount").val(data.info.totalVoucherAmount);
				$("#totalCreditAmount").val(data.info.totalVoucherAmount);

				$.each(data.vlist, function(index, v){
					if(v.debit == null) {
						debit = '';
					} else {
						debit = v.debit;
					}

					if(v.credit == null) {
						credit = '';
					} else {
						credit = v.credit;
					}
					$('#appendTbody').append('<tr class="listTr">\
						<td class="text-center">\
							<span class="debit_account_head">'+v.account_name+' - '+v.account_id+'</span>\
							<input type="hidden" name="debitHead[]" value="'+v.account_id+'">\
						</td>\
						<td class="text-right">\
							<span>'+debit+'</span>\
							<input type="hidden" class="amountDebit" name="amountDebit[]" value="'+debit+'">\
						</td>\
						<td class="text-right">\
							<span>'+credit+'</span>\
							<input type="hidden" class="amountCredit" name="amountCredit[]" value="'+credit+'">\
						</td>\
						<td class="text-center">\
							<span>'+v.narration+'</span>\
							<input type="hidden" class="narration" name="narration[]" value="'+v.narration+'">\
						</td>\
						<td class="text-center">\
							<a href="#">\
								<i class="editRow fa fa-pencil-square-o"></i>\
							</a>\
							&nbsp;&nbsp;\
							<a href="#">\
								<i class="removeRow fa fa-trash-o" aria-hidden="true"></i>\
							</a>\
						</td>\
					</tr>');
				});

				$('#save').val("Update");
				stopLoading();
			},
	      	error: function (xhr, ajaxOptions, thrownError) {
	        	alert('Something is Wrong...');
				return false;
	        }
		});
		e.preventDefault();
	});

	$(document).on('click', '.red', function(e){
		if(confirm('Are you sure to Delete?')) {
			return true;
		} else {
			return false;
		}
		e.preventDefault();
	});
</script>