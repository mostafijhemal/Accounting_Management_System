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
						<form method="post" action="<?php echo site_url('acc/vTypeSave'); ?>">
							<div class="table-header uppercase">
								Voucher Type Manage
							</div>
							<input type="hidden" name="id" id="id" >
							<div class="border_ddd">
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-4">
											<label for="type_name">Type Name</label>
											<input type="text" class="form-control" name="type_name" id="type_name" >
										</div>
										<div class="col-xs-12 col-sm-6">
											<label for="type_detail">Detail</label>
											<input type="text" class="form-control" name="type_detail" id="type_detail" >
										</div>
										<div class="col-xs-12 col-sm-2">
											<label for="status">Status</label>
											<select class="form-control" name="status" id="status">
												<option value="Active">Active</option>
												<option value="Inactive">Inactive</option>
											</select>
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


						<?php 
							if (isset($list) && !empty($list)) {
							
						 ?>
						<div>&nbsp;</div>
						<div id="listView" class="table-responsive"> 
						 	<div class="table-header uppercase">
								Voucher Type List
							</div>
							<table id="dynamic-table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr class="uppercase">
										<th class="text-center">#</th>
										<th class="text-center">Type Name</th>
										<th class="text-center">Detail</th>
										<th class="text-center">Status</th>
										<th style="width: 100px;" class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i = 1;
										foreach ($list as $vtlv) {
									 ?>


									<tr>
										<td class="text-center"><?php echo $i++; ?></td>
										<td class="text-center">
											<?php echo $vtlv->type_name; ?>
										</td>
										<td class="text-left">
											<?php echo $vtlv->type_detail; ?>
										</td>
										<td class="text-center">
											<?php echo $vtlv->status; ?>
										</td>
										<td class="text-center">
											<div class="btn-group">
											   	<table>
													<tbody>
														<tr>
															<td style="padding: 0 5px;">
														   		<a href="<?php echo $vtlv->id; ?>" class="green">
																	<button class="btn btn-xs btn-info" data-rel="tooltip" title="Edit" data-placement="bottom">
																		<i class="ace-icon fa fa-pencil bigger-120"></i>
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
	$(document).on('click', '.green', function(e){
		startLoading();
		var id = $(this).attr("href");
		$('#save').val("Save");

		$.ajax( {
			url 	: "<?php echo site_url('acc/vTypeDataforUpdate'); ?>",
			type 	: "POST",
			data 	: {id:id},
			dataType: "json",
			success : function(data){
				$('#id').val(data.id);
				$('#type_name').val(data.type_name);
				$('#type_detail').val(data.type_detail);
				$('#status').val(data.status);

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
</script>