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
						<form method="post" action="<?php echo site_url('acc/dayOpenCloseSaveAction'); ?>">
							<div class="table-header uppercase">
								Day Open or Close
							</div>
							<input type="hidden" name="id" id="id" >
							<div class="border_ddd">
								<div class="row">
									<div class="col-xs-12 col-sm-12">
										<div class="col-xs-12 col-sm-4">
											<label for="working_date">Select Working Date <span class="red">*</span></label>
											<input type="text" class="form-control date-picker" name="working_date" id="working_date" placeholder="2018-01-01" required >
										</div>
										<!-- <div class="col-xs-12 col-sm-3">
											<label for="permanent_close_date">Permanent Close Date <span class="red">*</span></label>
											<input type="text" class="form-control date-picker" name="permanent_close_date" id="permanent_close_date" placeholder="2018-01-01" required >
										</div> -->
										<div class="col-xs-12 col-sm-4">
											<label for="status">Status <span class="red">*</span></label>
											<select class="form-control" name="status" id="status" required>
												<option value="Open">Open</option>
												<option value="Close">Close</option>
											</select>
										</div>
										<div class="col-xs-12 col-sm-4">
											<label for="">&nbsp;</label>
											<input type="submit" id="save" class="form-control btn btn-primary" value="Submit">
										</div>
									</div>
									<div class="col-xs-12 col-sm-12">&nbsp;</div>
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
										<th class="text-center">Working Date</th>
										<!-- <th class="text-center">Permanent Close Date</th> -->
										<th class="text-center">Admin </th>
										<th class="text-center">Status</th>
										<th style="width: 100px;" class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i = $onset + 1;
										foreach ($list as $vtlv) {
									 ?>


									<tr>
										<td class="text-center"><?php echo $i++; ?></td>
										<td class="text-center">
											<?php echo $vtlv->working_date; ?>
										</td>
										<!-- <td class="text-center">
											<?php //echo $vtlv->permanent_close_date; ?>
										</td> -->
										<td class="text-center">
											<?php echo $vtlv->full_name.'('.$vtlv->login_name.')'; ?>
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
									<tr>
									    <th colspan="7">
											<ul class="pager pull-right">
												<li class="activePagi">
													<?php echo $this->pagination->create_links(); ?>
												</li>
											</ul>
										</th>
									</tr>
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
			url 	: "<?php echo site_url('acc/dayOpenCloseEdit'); ?>",
			type 	: "POST",
			data 	: {id:id},
			dataType: "json",
			success : function(data){
				$('#id').val(data.id);
				$('#working_date').val(data.working_date);
				//$('#permanent_close_date').val(data.permanent_close_date);
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

	$(document).on('click', 'li.activePagi a', function(e) {
		var uristring = $(this).attr("href");

		var arrVal = uristring.split("/");
		if(arrVal[arrVal.length-1] == '') {
			location.replace(uristring+"0");
		} else {
			location.replace(uristring);
		}
		e.preventDefault();
	});
</script>