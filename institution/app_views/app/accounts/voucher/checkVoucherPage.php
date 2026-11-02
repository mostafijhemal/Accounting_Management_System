<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>
		

<!-- view Page Access function   -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				Test Page
				<small>
					<i class="fa fa-angle-double-right"></i>
					overview &amp; stats
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

					Welcome to
					<strong class="green">
						Test
						<small>(page)</small>
					</strong>
					, the test page use for data test.
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>
				

				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<?php if (isset($list) && !empty($list)): ?>
						<div id="listView" class="table-responsive"> 
						 	<div class="table-header uppercase">
								Voucher List For Check
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
												if($vlv->current_station == 'Check'){
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
														   		<a class="voucherCheck" href="<?php echo site_url('acc/voucherCheckAction/'.$vlv->id); ?>" class="green">
																	<button class="btn btn-xs btn-info" data-rel="tooltip" title="Check" data-placement="bottom">
																		<i class="ace-icon fa fa-check bigger-120"></i>
																	</button>
																</a>
															</td>
															<td style="padding: 0 5px;">
				                                               	<a class="returnVoucher" href="<?php echo(site_url('acc/voucherReturnToPrepare/'.$vlv->id)); ?>" class="red">
																	<button class="btn btn-xs btn-danger" data-rel="tooltip" title="Return" data-placement="bottom">
																	    <i class="ace-icon fa fa-undo bigger-120"></i>
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
						<?php endif ?>
					</div>
				</div>
				<!-- PAGE CONTENT ENDS -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->

<script type="text/javascript">
	$(document).ready(function(){
		//alert('Ok');
	});

	$(document).on('click', '.voucherCheck', function(e){
		if(confirm('Are you sure to Chack this Voucher... ?')) {
			return true;
		} else {
			return false;
		}
		e.preventDefault();
	});

	$(document).on('click', '.returnVoucher', function(e){
		if(confirm('Are you sure to Return this Voucher... ?')) {
			return true;
		} else {
			return false;
		}
		e.preventDefault();
	});
</script>