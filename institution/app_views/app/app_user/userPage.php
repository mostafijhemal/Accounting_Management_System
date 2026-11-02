<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>

	<!-- view Page Access function   -->
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
						<div class="table-header">
							USER LIST
							<div  class="pull-right accessCreate" > 
							    <a href="#" role="button" class="label label-xlg label-light arrowed-in-right blue" data-toggle="modal" style="text-decoration:none;" data-target="#modal_one">
							    	<i title="Add New" class="fa fa-plus" style="line-height: 20px;"></i>	 
                                </a> 
                            </div>	 
						</div>
						<!-- div.table-responsive -->
						<?php if(!empty($user_data)): ?> <!-- data table view condation Start -->
						<div class="table-responsive"> 
							<table id="dynamic-table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
									    <th class="center" width="8%">Sl No</th>
										<th class="text-center" width="15%">User Full Name</th>
										<th class="text-center" width="15%">Username</th>
										<th class="text-center" width="5%">E-mail</th>
										<th class="text-center" width="5%">Mobile</th>
										<th class="text-center" width="15%">Status</th>
										<th class="text-center" width="15%">Image</th>
										<th class="text-center" width="15%">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								    $i = 1;
								    foreach($user_data as $v){ 
								?>
									<tr>
										<td class="center">
											<?php echo $i++ ?>
										</td>
										<td><?php if(!empty($v->full_name)) echo $v->full_name ?></td>
										<td class="text-center"><?php if(!empty($v->login_name)) echo $v->login_name ?></td>
										<td class="text-center"><?php if(!empty($v->email)) echo $v->email ?></td>
										<td class="text-center"><?php if(!empty($v->cell)) echo $v->cell ?></td>
										<td class="text-center"><?php if(!empty($v->status)) echo $v->status ?></td>
										<td class="text-center">
											<?php 
												if(!empty($v->image)){
													echo '<img src="'.base_url().'data/images/upload/app_user/'.$v->image.'" style="width: 35px;margin: auto;" class="img-responsive img-rounded" alt="Image">';
												} else {
													echo '<i class="fa fa-user" aria-hidden="true"></i>';
												}
											 ?>
										</td>
										<td class="text-center">
											<div class="btn-group">
										   		<a href="#" class="green" data-id="<?php echo $v->id ?>">
													<button class="btn btn-xs btn-info" data-rel="tooltip" title="Edit" data-placement="bottom">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</button>
												</a>
											   	<!-- <span class="accessDelete">
	                                               	<a href="<?php //echo site_url('app_user_manage/delete/'.$v->id); ?>" class="red">
														<button class="btn btn-xs btn-danger"   
														    data-rel="tooltip" title="Delete" data-placement="bottom">
														    <i class="ace-icon fa fa-trash-o bigger-120"></i>
														</button>
												   	</a>
											   	</span> -->
											</div>													
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table> 
						</div>
						<?php endif; ?> <!-- data table view condation end -->
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->



<!-- view Page Access function   -->
<!-- Modal -->
<div id="modal_one" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		<span aria-hidden="true">&times;</span>
	        	</button>
	        	<h4 class="modal-title" id="myLargeModalLabel">USER MANAGE</h4>
	      	</div>
		    <form id="addForm" enctype="multipart/form-data" action="<?php echo site_url('user/save'); ?>" method="post">
		    	<input type="hidden" name="id" id="id">
		    	<div class="modal-body">
		        	<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="full_name">User Full Name <span class="red">*</span></label>
										<input class="form-control" name="full_name" id="full_name" placeholder="User Full Name *" required  />
									</div>
								</div>
									
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="login_name">Login Username <span class="red">*</span></label>
										<input class="form-control" name="login_name" id="login_name" placeholder="Login Username*" required  />
									</div>
								</div>
							</div>

							
							<div class="row" >
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="password">Password <span class="red">*</span></label>
										<input type="password" class="form-control" name="password" id="password" placeholder="Password *"   />
									</div>
								</div>
									
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="re_password">Re-enter Password <span class="red">*</span></label>
										<input type="password" class="form-control" id="re_password" placeholder="Re-enter Password *"   />
									</div>
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="designition">Designition </label>
										<input type="text" class="form-control" name="designition" id="designition" placeholder="Designition "  />
									</div>
								</div>
									
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="email">E-mail <span class="red">*</span></label>
										<input type="email" class="form-control" name="email" id="email" placeholder="E-mail *" required  />
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="cell">Cell </label>
										<input type="text" class="form-control" name="cell" id="cell" placeholder="Cell "  />
									</div>
								</div>

								<div class="col-xs-12 col-sm-6">
									<label for="user_type_id">Admin Type <span class="red">*</span></label>
									<div>
										<select class="form-control" id="user_type_id" name="user_type_id"   required>
	                                        <option value="">Select Type </option>
	                                        <?php if(isset($user_type)): foreach ($user_type as $admin_type_v): ?>
											<option value="<?php echo $admin_type_v->id; ?>"><?php echo $admin_type_v->type_name; ?> </option>
											<?php endforeach; endif; ?>
	                                    </select>
									</div>
								</div>

								<!-- <div class="col-xs-12 col-sm-3">
									<label for="profile_id">Employee ID </label>
									<div>
										<input type="text" class="form-control profile_id" name="profile_id" id="profile_id" placeholder="Employee ID *"   value="<?php //if(!empty($each_user_data->profile_id)) echo $each_user_data->profile_id; ?>" />
									</div>
								</div>

								<div class="col-xs-12 col-sm-3">
									<label for="warehouse_auto_id">Warehouse </label>
									<div>
										<select class="form-control" name="warehouse_auto_id" id="warehouse_auto_id">
											<option>Select Warehouse</option>
											<?php 
												/*if(isset($warehouse_list) && !empty($warehouse_list)) {
													foreach ($warehouse_list as $wv) {*/
											?> 
											<option value="<?php //echo $wv->id; ?>">
											 	<?php //echo $wv->warehouse_name; ?>
											</option>
											<?php //}} ?>
										</select>
									</div>
								</div> -->
							</div>
							
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="present_address">Present Address <span class="red">*</span></label>
										<textarea class="form-control" name="present_address" id="present_address" placeholder="Present Address *" required ></textarea>
									</div>
								</div>

								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="permanent_address">Permanent Address  <span class="red">*</span></label>
										<textarea class="form-control" name="permanent_address" id="permanent_address" placeholder="Permanent Address *" required  ></textarea>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-12 col-sm-12">
									<div class="fix" style="border: 1px solid #ddd;">
										<div class="col-xs-12 col-sm-6">
											<label for="status">status <span class="red">*</span></label>
											<div>
												<select class="form-control" id="status" name="status"   required>
			                                        <option value="">Select Status </option>
			                                        <option value="active" selected="selected">Active </option>
													<option value="inactive">In Active </option>
			                                    </select>
											</div>
										</div>

										<div class="col-xs-12 col-sm-6">
											<style type="text/css">
												.parentUploadImg {position: relative;width: 100px;height: 100px;}
												.uploadImg {width: 100%;height: 100%;border: 1px solid;cursor: pointer;}
												#removeImage{position:absolute;top: 0;right: 0;}
												#removeImage p {
													//background: #000;
													border-radius: 5px;
													color: #fff;
													cursor: pointer;
													margin: 0;
													padding: 0 5px 5px;
												}
											</style>
											<div class="col-xs-12 col-sm-12">&nbsp;</div>
											<div class="parentUploadImg">
												<img id = "select_file" class="uploadImg span3 img-responsive" src="<?php echo base_url(); ?>data/img/common/upload.png" alt="Upload Image" />
												<input accept=".jpg, .png, .gif" class="span3" type="file" name="image" id="image_file" style="display: none;" />
												<div id="removeImage"></div>
											</div>
											<br><br>
										</div>
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
					<button class="btn btn-sm btn-primary submitBtn" disabled type="submit" >
						<i class="ace-icon fa fa-check"></i>
						<span class="update">Save</span>
					</button>
		      	</div>
		    </form>
	    </div>
  	</div>
</div>


<script type="text/javascript">
	<?php if($this->input->get('popup') == 1) { ?>
		$('#editMenuModal').modal('show');
	<?php } ?>

	/* Check Login Name For Unic */
	$('#login_name').on('blur', function(e){
	//$(document).on("blur", "#login_name", function(e) {
		var login_name 	= $(this).val();
		var id 			= $('#id').val();

		$('.submitBtn').attr('disabled', 'disabled');
		var formURL = "<?php echo site_url('app_user_manage/checkLoginNameForUnic'); ?>";
		
		$.ajax( {
			url 	: formURL,
			type 	: "POST",
			data 	: {id: id, login_name : login_name},
			dataType: "json",
			success :function(data){
				if(data == null){
					$('.submitBtn').removeAttr('disabled');
				} else {
					//alert('This Login Name Already  Exist....');
				}
			}
		});
		e.preventDefault();
	});


	/* Check E-mail For Unic */
	$('#email').on('blur', function(e){
	//$(document).on("blur", "#email", function(e) {
		var thisFild= $(this);
		var email 	= $(this).val();
		var id 		= $('#id').val();

		$('.submitBtn').attr('disabled', 'disabled');
		var formURL = "<?php echo site_url('app_user_manage/checkEmailForUnic'); ?>";
		
		$.ajax( {
			url 	: formURL,
			type 	: "POST",
			data 	: {id: id, email : email},
			dataType: "json",
			success :function(data){
				if(data == null){
					$('.submitBtn').removeAttr('disabled');
				} else {
					//alert('This Login Name Already  Exist....');
				}
			}
		});
		e.preventDefault();
	});


	$(document).on('blur', '#re_password', function(){
		var password 	= $('#password').val();
		var re_password = $(this).val();

		if(password != re_password){
			alert('Password and Re-enter Password are not Equal. Please Enter Same Value...');
			$('#re_password').val('');
			$('#password').val('').focus();
			return false;
		} else {
			return true;
		}
	});

	$(document).on('click', '#superAccess', function(){
		if($(this).prop('checked')){
			if($('.allAccess').prop('checked') != true){
				$('.allAccess').trigger('click');
				$('.allAccess').prop('checked', true);
			}
		}else {
			if($('.allAccess').prop('checked')){
				$('.allAccess').trigger('click');
			}
		}
	});

	/*$(document).on('click', '', function(){
		if($(this).prop('checked')){
			if($('.allAccess').prop('checked')){
				console.log();
			} else {
				$('.allAccess').trigger('click');
				$('.allAccess').prop('checked', true);
			}
		}else {
			if($('.allAccess').prop('checked')){
				$('.allAccess').trigger('click');
			}
		}
	});*/

	//update data by ajax
	$(document).on("click", ".green", function(e) {
		var id 		= $(this).attr("data-id");
		var formURL = "<?php echo site_url('app_user_manage/controllerDataLoadForEdit'); ?>";
		
		$.ajax( {
			url : formURL,
			type: "POST",
			data : {id: id},
			dataType: "json",
			success:function(data){
				$('#modal_one').modal('show');

				$('#id').val(data.id);
				$('#full_name').val(data.full_name);
				$('#login_name').val(data.login_name);
				$('#designition').val(data.designition);
				$('#email').val(data.email);
				$('#cell').val(data.cell);
				$('#user_type_id').val(data.user_type_id);
				$('#present_address').val(data.present_address);
				$('#permanent_address').val(data.permanent_address);
				$('#status').val(data.status);

				$('.update').text("Update");
			}
		});
		e.preventDefault();
	});



	$('.blue').on('click', function() {
		$("#id").val("");
		$("#full_name").val("");
		$("#login_name").val("");
		$("#designition").val("");
		$("#email").val("");
		$("#cell").val("");
		$("#user_type_id").val("");
		$("#present_address").val("");
		$("#permanent_address").val("");
		$("#status").val("");

		$('.update').text("Save");
	});



	$(document).on("click", ".red", function(e) {		
		var x = confirm('Are you sure to delete?');
		if(x) {
			var tr =  $(this).parents('tr'); 
			var formURL = $(this).attr('href');
			$.ajax({
				url : formURL,
				type: "POST",
				data : {},
				success:function(data){
					tr.remove();
				}
			});
		} else {
			return false;
		} 
		e.preventDefault();
	});


	/* Upload Image System Start */
		// Create Form
		$('#select_file').click(function(){
			$('#image_file').click();
			$('#image_file').change( function(event) {
				var tmppath = URL.createObjectURL(event.target.files[0]);
				$("#select_file").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
			});
		}); 
		$(document).ready(function(){
			$('.parentUploadImg').mouseenter(function(){
				var checkImageData = $('#image_file').val();
				if(checkImageData != ''){
					$('#removeImage').append('<p><i style="margin-top : 5px;" class="fa fa-times" aria-hidden="true"></i></p>');
					return false;
				} else {
					$('#removeImage').html('');
					$('#image_file').val('');
					return false;
				}
			});
			$('.parentUploadImg').mouseleave(function(){
				$('#removeImage').html('');
				return false;
			});
		});
		$('#removeImage').click(function(){
			$('#select_file').attr('src', '');
			$('#select_file').attr('src', '<?php echo base_url(); ?>data/img/common/upload.png');
			$('#image_file').val('');
			$(this).html('');
			return false;
		});

		// Update Form
		$('#select_file2').click(function(){
			$('#image_file2').click();
			$('#image_file2').change( function(event) {
				var tmppath = URL.createObjectURL(event.target.files[0]);
				$("#select_file2").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
			});
		}); 
		$(document).ready(function(){
			$('.parentUploadImg').mouseenter(function(){
				var checkImageData = $('#image_file2').val();
				if(checkImageData != ''){
					$('#removeImage2').append('<p><i style="margin-top : 5px;" class="fa fa-times" aria-hidden="true"></i></p>');
					return false;
				} else {
					$('#removeImage2').html('');
					$('#image_file2').val('');
					return false;
				}
			});
			$('.parentUploadImg').mouseleave(function(){
				$('#removeImage2').html('');
				return false;
			});
		});
		$('#removeImage2').click(function(){
			$('#select_file2').attr('src', '');
			$('#select_file2').attr('src', '<?php echo base_url(); ?>data/img/common/upload.png');
			$('#image_file2').val('');
			$(this).html('');
			return false;
		});
	/* Upload Image System End */
</script>