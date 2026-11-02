<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>
		

	<!-- view Page Access function   -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				Debit Voucher
				<small>
					<i class="fa fa-angle-double-right"></i>
					Create  &amp; Summary
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

					Debit Voucher Create Panel
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>
				

				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<form id="formSubmit" method="post" action="<?php echo site_url('acc/saveOpening'); ?>">
							<input type="hidden" name="id" id="id">
							<div class="table-header uppercase">
								Openind Entry
							</div>
							<div class="border_ddd">
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-4">
											<label for="voucher_date">Entry Date</label>
											<input type="text" class="form-control date-picker" name="voucher_date" id="voucher_date" value="<?php echo date('Y-m-d'); ?>">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-12">
											<div style="margin-top: 10px; border: 1px solid;padding: 3px 0 12px 0;">
												<div class="row">
													<div class="col-xs-12 col-sm-12">
														<div class="col-xs-12 col-sm-3">
															<label for="debitHead">Head</label>
															<input type="text" list="accHeadList" class="form-control" id="debitHead" name="head" required="required" autocomplete="off">
															<datalist id="accHeadList">
																<?php 
																	if(isset($acHead)) {
																		foreach ($acHead as $acHeadList) {
																			echo '<option value="'.$acHeadList->account_name.' - '.$acHeadList->account_id.'">';
																		}
																	}
																 ?>
															</datalist>
														</div>
														<div class="col-xs-12 col-sm-5">
															<label for="narration">Narration</label>
															<input type="text" class="form-control" id="narration" name="narration" placeholder="Narration">
														</div>
														<div class="col-xs-12 col-sm-2">
															<label for="debit">Debit (BDT)</label>
															<!-- onkeyup="this.value=this.value.replace(/[^\d]/,'')" -->
															<input type="number" step="any" class="form-control text-right" id="debit" name="debit">
														</div>
														<div class="col-xs-12 col-sm-2">
															<label for="credit">Credit (BDT)</label>
															<input type="number" step="any" class="form-control text-right" id="credit" name="credit">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-12">&nbsp;</div>
										<div class="col-xs-12 col-sm-12">
											<div class="row">
												<div class="col-xs-12 col-sm-8">&nbsp;</div>
												<div class="col-xs-12 col-sm-4">
													<input type="submit" id="save" class="form-control btn btn-primary" value="Submit">
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12">&nbsp;</div>
									</div>
								</div>
							</div>
						</form>
						<div>&nbsp;</div>
						<?php 
							if(isset($list) && !empty($list)) {
						 ?>
						<div class="table-responsive">
						  	<table class="table table-condensed table-hover table-bordered">
							    <thead>
							    	<tr>
							    		<th width="5%" class="text-center">Sl</th>
							    		<th class="text-center">Head Name</th>
							    		<th class="text-center">Narration</th>
							    		<th width="15%" class="text-center">Deit</th>
							    		<th width="15%" class="text-center">Credit</th>
							    		<th width="10%" class="text-center">Action</th>
							    	</tr>
							    </thead>
							    <tbody>
							    	<?php 
							    		$i = 1;
							    		foreach ($list as $v) {
							    	 ?>
							    	<tr>
								    	<td class="text-center"><?php echo $i++; ?></td>
								    	<td class="text-left">
								    		<?php 
								    			echo $v->accountName;
								    		 ?>
								    	</td>
								    	<td class="text-left"><?php echo $v->narration; ?></td>
								    	<td class="text-right"><?php echo number_format($v->debit, 2); ?></td>
								    	<td class="text-right"><?php echo number_format($v->credit, 2); ?></td>
								    	<td class="text-center">
								    		<?php if ($v->opening_approve == 1): ?>
								    		<a class="editSingleEntry" href="<?php echo $v->id ?>">
								    			<button class="btn btn-info" style="border: 0;font-size: 10px;margin: 5px;">
								    				<i class="fa fa-pencil"></i>
								    			</button>
								    		</a> 
								    		<a class="openingApprove" href="<?php echo $v->id ?>">
								    			<button class="btn btn-info" style="border: 0;font-size: 10px;margin: 5px;">
								    				<i class="fa fa-check"></i>
								    			</button>
								    		</a>
								    		<?php else: ?>
								    			N/A
								    		<?php endif ?>
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
					$('#narration').focus();
				} else {
					alert('Data Not Match with Chart of Accounts...');
					$('#debitHead').val('').focus();
					return false;
				}
			},
	      	error: function (xhr, ajaxOptions, thrownError) {
	        	alert('Something is Wrong...');
				thisElement.removeAttr('disabled');
				return false;
	        }
		});
	});


	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});

	$(document).on('click', '.editSingleEntry', function(e){
		var id = $(this).attr('href');
		$('#save').val("Submit");
		$.ajax({
			url 		: "<?php echo site_url('acc/aOpeningData'); ?>",
			type 		: "POST",  
			data 		: {id:id},
			dataType 	: 'json',
			success		: function(data){ 
				$('#id').val(data.id);
				$('#voucher_date').val(data.voucher_date);
				$('#debitHead').val(data.acc_name);
				$('#narration').val(data.narration);
				$('#credit').val(data.credit);
				$('#debit').val(data.debit);

				$('#save').val("Update");
				$('html,body').animate({ scrollTop: 50 }, 'slow');
        		return false; 
			},
			error: function (xhr, status) {
	            alert('Something is wrong');
	        }
		});
		e.preventDefault();
	});

	$(document).on('click', '.openingApprove', function(e){
		if(confirm("Are You Sure to Approve?")) {
			var id = $(this).attr('href');
			$.ajax({
				url 		: "<?php echo site_url('acc/aOpeningDataApprove'); ?>",
				type 		: "POST",  
				data 		: {id:id},
				dataType 	: 'html',
				success		: function(data){ 
					location.reload();
				},
				error: function (xhr, status) {
		            alert(status);
		        }
			});
		}
		e.preventDefault();
	});

</script>