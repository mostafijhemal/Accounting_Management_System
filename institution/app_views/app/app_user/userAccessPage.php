<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>

	<!-- view Page Access function -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				User
				<small>
					<i class="fa fa-angle-double-right"></i>
					Create &amp; List
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12  col-sm-12">
				<!-- PAGE CONTENT BEGINS -->

				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>

					<i class="fa fa-check-square-o green"></i>

					User Manage Panel. This Panel Use Only User Create and User Access. 
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>

				<div class="row">
					<div class="col-xs-12  col-sm-12">
				    	<div class="modal-content">
					      	<div class="modal-header">
					        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					        		<!-- <span aria-hidden="true">&times;</span> -->
					        	</button>
					        	<h4 class="modal-title" id="myLargeModalLabel">USER ACCESS MANAGE</h4>
					      	</div>
						    <form enctype="multipart/form-data" action="<?php echo site_url('user/accessSave'); ?>" method="post">
						    	<div class="modal-body">
						        	<div class="row">
										<div class="col-xs-12 col-sm-12">
											<div class="row">
												<?php if ($this->session->userdata("app_user_type_id") == 3) { ?>
												<div class="col-xs-12 col-sm-12">
													<div class="form-group">
														<label for="company_id">Compay List <span class="red">*</span></label>
														<select class="form-control" name="company_id" id="company_id" required>
															<option value="">Select One</option>
															<?php if (isset($comList) && !empty($comList)): ?>
																<?php foreach ($comList as $clv): ?>
																	<option value="<?php echo $clv->id ?>"><?php echo $clv->name ?></option>
																<?php endforeach ?>
															<?php endif ?>
														</select>
													</div>
												</div>
												<?php } ?>
												<div class="col-xs-12 col-sm-12">
													<div class="form-group">
														<label for="user_id">User List <span class="red">*</span></label>
														<select class="form-control" name="user_id" id="user_id" required>
															<option value="">Select One</option>
															<?php if (($this->session->userdata("app_user_type_id") != 3) && isset($userList) && !empty($userList)): ?>
																<?php foreach ($userList as $ulv): ?>
																	<option value="<?php echo $ulv->id ?>"><?php echo $ulv->full_name ?></option>
																<?php endforeach ?>
															<?php endif ?>
														</select>
													</div>
												</div>
											</div>
											
											
											<div class="row">
												<div class="col-xs-12 col-sm-12">
													<div class="table-responsive"> 
														<table id="dynamic-table" class="table table-striped table-bordered table-hover">
															<thead>
																<tr>
																    <th class="text-center" style="width: 50px;">Sl No</th>
																	<th class="text-center">Title</th>
																	<th class="text-center">Detail</th>
																	<th class="text-center" style="width: 100px;">
																		<input type="checkbox" id="checkedAll"> 
																		Access
																	</th>
																</tr>
															</thead>
															<tbody>
																<?php $i = 1; if (isset($controllerList) && !empty($controllerList)): ?>
																	<?php foreach ($controllerList as $clv): ?>
																		<tr>
																			<td class="text-center"><?php echo $i++; ?></td>
																			<td class="text-left">
																				<input type="hidden" name="controller_id[]" value="<?php echo($clv->id) ?>">
																				<?php echo $clv->title_text; ?>
																			</td>
																			<td>
																				<?php echo $clv->detail; ?>
																			</td>
																			<td class="text-center" style="padding: 0;">
																				<select class="form-control access_status" name="access_status[]" required>
																					<option value="No">No</option>
																					<option value="Yes">Yes</option>
																				</select>
																			</td>
																		</tr>
																	<?php endforeach ?>
																<?php endif ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
				              			</div>
									</div>
						      	</div>
						      	<div class="modal-footer accessCreate">
						        	<button class="btn btn-sm" data-dismiss="modal" >
										<i class="ace-icon fa fa-times"></i>
										Cancel
									</button>
									<button class="btn btn-sm btn-primary submitBtn" type="submit" >
										<i class="ace-icon fa fa-check"></i>
										<span class="update">Save</span>
									</button>
						      	</div>
						    </form>
					    </div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->
<script type="text/javascript">
	$(document).on('click', '#checkedAll', function(){
		if($(this).prop('checked')){
			$('.access_status').val('Yes');
		}else {
			$('.access_status').val('No');
		}
	});

	$(document).on('change', '#company_id', function(){
		var company_id = $(this).val();
		$('#user_id').html('');

		$.ajax( {
			url 	: "<?php echo site_url('app_user_manage/getUserList'); ?>",
			type 	: "POST",
			data 	: {company_id:company_id},
			dataType: "html",
			success : function(data){
				$('#user_id').html(data);
			},
	      	error: function (xhr, ajaxOptions, thrownError) {
	        	alert('Something is Wrong...');
				return false;
	        }
		});
	});
</script>