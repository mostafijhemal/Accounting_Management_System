<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>

	<!-- view Page Access function   -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				Institute Info
				<small>
					<i class="fa fa-angle-double-right"></i>
					Create &amp; Update
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

					Institute Informaton Manage Panel. This Panel Use Only Institute Informaton Create &amp; Update. 
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>

				<div class="row">
					<div class="col-xs-12  col-sm-12">
						<div class="table-header">
							Company Informaton 
						</div>
						<form id="addForm" enctype="multipart/form-data" action="<?php echo site_url('instituteInfo/instituteInfoSave'); ?>" method="post" style="border: 1px solid #ddd;">
							<input type="hidden" name="id" value="<?php if(!empty($comData->id)) echo $comData->id; ?>" >
					    	<div class="modal-body">
					        	<div class="row">
									<div class="col-xs-12 col-sm-12">
										<div class="row">
											<div class="col-xs-12 col-sm-4">
												<div class="form-group">
													<label for="company_name">Company Full Name <span class="red">*</span></label>
													<input class="form-control" name="company_name" id="company_name" placeholder="Company Full Name *" required tabindex="1"  value="<?php if(!empty($comData->company_name)) echo $comData->company_name; ?>" />
												</div>
											</div>
												
											<div class="col-xs-12 col-sm-2">
												<div class="form-group">
													<label for="short_name">Company Short Name <span class="red">*</span></label>
													<input class="form-control" name="short_name" id="short_name" placeholder="Company Short Name *" required tabindex="2"  value="<?php if(!empty($comData->short_name)) echo $comData->short_name; ?>" />
												</div>
											</div>

											<div class="col-xs-12 col-sm-6">
												<div class="form-group">
													<label for="address">Head Office <span class="red">*</span></label>
													<input type="text" class="form-control" name="address" id="address" placeholder="Head Office *" required tabindex="3"  value="<?php if(!empty($comData->address)) echo $comData->address; ?>" />
												</div>
											</div>
										</div>

										
										<div class="row" >
											<div class="col-xs-12 col-sm-4">
												<div class="form-group">
													<label for="email">E-mail <span class="red">*</span></label>
													<input type="email" class="form-control" name="email" id="email" placeholder="E-mail *" required tabindex="4"  value="<?php if(!empty($comData->email)) echo $comData->email; ?>" />
												</div>
											</div>
											
											<div class="col-xs-12 col-sm-4 hide">
												<div class="form-group">
													<label for="email_or_phone">Mobile, Phone or Email </label>
													<input type="text" class="form-control" name="email_or_phone" id="email_or_phone" placeholder="Mobile, Phone or Email " tabindex="5"  value="<?php if(!empty($comData->email_or_phone)) echo $comData->email_or_phone; ?>" />
												</div>
											</div>
												
											<div class="col-xs-12 col-sm-4">
												<div class="form-group">
													<label for="phone_no">Phone No</label>
													<input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone No" tabindex="6"  value="<?php if(!empty($comData->phone_no)) echo $comData->phone_no; ?>" />
												</div>
											</div>
											<div class="col-xs-12 col-sm-4">
												<div class="form-group">
													<label for="chif_name">Chief Name </label>
													<input type="text" class="form-control" name="chif_name" id="chif_name" placeholder="Chief Name " tabindex="5"  value="<?php if(!empty($comData->chif_name)) echo $comData->chif_name; ?>" />
												</div>
											</div>
										</div>
										
										
										<div class="row">
											<div class="col-xs-12 col-sm-3">
												<div class="form-group">
													<label for="a_chif_name">Assistant Chief Name</label>
													<input type="text" class="form-control" name="a_chif_name" id="a_chif_name" placeholder="Assistant Chief Name" tabindex="6"  value="<?php if(!empty($comData->a_chif_name)) echo $comData->a_chif_name; ?>" />
												</div>
											</div>
												
											<div class="col-xs-12 col-sm-3">
												<div class="form-group">
													<label for="country_id">Country Name</label>
													<select class="form-control" name="country_id" id="country_id" tabindex="6">
														<option value="">Select Country</option>
														<?php 
															if(!empty($country_list)){ 
																foreach($country_list as $country_v){
														?>
														<option <?php if(!empty($comData->country_id) && $comData->country_id == $country_v->country_id) echo 'selected="true"'; ?> value="<?php echo $country_v->country_id; ?>"><?php echo $country_v->country_name; ?></option>
														<?php }} ?>
													</select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-3">
												<div class="form-group">
													<label for="financial_year_from">Financial year Start <span class="red">*</span> </label>
													<input type="text" class="form-control date-picker" name="financial_year_from" id="financial_year_from" placeholder="Financial year From *" tabindex="5" value="<?php if(!empty($comData->financial_year_from)) echo $comData->financial_year_from; ?>" />
												</div>
											</div>
											<div class="col-xs-12 col-sm-3">
												<div class="form-group">
													<label for="financial_year_end">Financial year End <span class="red">*</span> </label>
													<input type="text" class="form-control date-picker" name="financial_year_end" id="financial_year_end" placeholder="Financial year End *" tabindex="5" value="<?php if(!empty($comData->financial_year_end)) echo $comData->financial_year_end; ?>" />
												</div>
											</div>
										</div> 
										
										<div class="row">
											<div class="col-xs-12 col-sm-12">
												<div class="fix" style="border: 1px solid #ddd;">
													<div class="col-xs-12 col-sm-6">
														<style type="text/css">
															.parentUploadImg {position: relative;width: 100px;height: 100px;}
															.uploadImg {width: 100%;height: 100%;border: 1px solid;cursor: pointer;}
															#removeImage{position:absolute;top: 18px;right: 0;}
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
															<input accept=".jpg, .png, .gif" class="span3" type="file" name="logo" id="image_file" style="display: none;" />
															<div id="removeImage"></div>
														</div>
														<br><br>
													</div>

													<?php if(!empty($comData->logo)): ?>
													<div class="col-xs-12 col-sm-6">
														<div class="col-xs-12 col-sm-12">&nbsp;</div>
														<div style="float: right; height: 100px;" >
															<img style="width: 100%;height: 100%;border: 1px solid; padding: 5px;" class="uploadImg img-responsive" src="<?php echo base_url('data/img/common/'.$comData->logo); ?>" alt="Upload Image" />
														</div>
														<br><br>
													</div>
													<?php endif; ?>
												</div>
											</div>
										</div>
			              			</div>
								</div>
					      	</div>
					      	<div class="modal-footer accessCreate">
					        	<button class="btn btn-sm resetBtn" type="reset" data-dismiss="modal" tabindex="10">
									<i class="ace-icon fa fa-times"></i>
									Cancel
								</button>
								<button class="btn btn-sm btn-primary submitBtn" type="submit" tabindex="9">
									<i class="ace-icon fa fa-check"></i>
									<span class="update"><?php if(isset($comData)) echo "Update"; else echo "Save"; ?></span>
								</button>
					      	</div>
					    </form>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->



<!-- view Page Access function   -->
<script type="text/javascript">
	/* Check Login Name For Unic */
	$(document).on("blur", "#login_name", function(e) {
		var login_name 	= $(this).val();
		var attrId	 	= $(this).attr('id');
		if(attrId == 'login_name2'){
			var id 		= $('#editId').val();
		} else {
			var id 		= '';
		}

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
					alert('This Login Name Already  Exist....');
				}
			}
		});
		e.preventDefault();
	});

	/* Reset Form Value*/
	$(document).on('click', '.resetBtn', function(){
		$('input').val('');
		$('#select_file').attr('src', '');
		$('#select_file').attr('src', '<?php echo base_url(); ?>data/img/common/upload.png');
		var dataExist = '<?php if(!empty($comData->id)) echo $comData->id; ?>';
		if(dataExist != ''){
			$('input[name="id"]').val(dataExist);
		}
		return false;
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
	/* Upload Image System End */
</script>