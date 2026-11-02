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
						<form method="post" target="_blank" action="<?php echo site_url('accReport/balanceSheetReport'); ?>">
							<div class="table-header uppercase">
								Balance Sheet
							</div>
							<div class="border_ddd">
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-4">
											<label for="financialYear">Financial Year List</label>
											<select class="form-control" id="financialYear">
												<?php if (isset($fyYearList) && !empty($fyYearList)): ?>
													<?php foreach ($fyYearList as $fylv): ?>
														<option <?php if($fylv->status == 'Active') echo "selected"; ?> value="<?php echo($fylv->yearList); ?>"><?php if($fylv->status == 'Active') echo "Current Financial Year"; else echo($fylv->yearList); ?></option>
													<?php endforeach ?>
												<?php endif ?>
											</select>
										</div>
										<div class="col-xs-12 col-sm-4">
											<label for="from_date">From Date</label>
											<input type="text" class="form-control date-picker" name="from_date" id="from_date" value="<?php if(!empty($from_year)) echo($from_year); ?>" >
										</div>
										<div class="col-xs-12 col-sm-4">
											<label for="to_date">To Date</label>
											<input type="text" class="form-control date-picker" name="to_date" id="to_date" value="<?php if(!empty($to_year)) echo($to_year); ?>" >
										</div>
									</div>
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-12">&nbsp;</div>
										<div class="col-xs-12 col-sm-10">
										</div>
										<div class="col-xs-12 col-sm-2">
											<input type="submit" id="save" class="form-control btn btn-primary" value="Submit">
										</div>
										<div class="col-xs-12 col-sm-12">&nbsp;</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- PAGE CONTENT ENDS -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->
<script type="text/javascript">
	$(document).on('change', '#financialYear', function() {
		var year = $(this).val();
		var arrYear = year.split("_");
		$("#from_date").val(arrYear[0]);
		$("#to_date").val(arrYear[1]);
	});
</script>