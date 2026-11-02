 
 
 <!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $title; ?></title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />


		<?php $this->load->view('app/common/appCssLinkPage'); ?>
	</head>

	<body class="login-layout blur-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3" style="margin-top:10%">
						<div class="" style="background: #fff; height: ; border-radius: 5px; overflow: hidden; padding: 10px;">
							<h1 class="center">Set A New Password</h1>
							<hr>
							<div class="col-sm-12" style="border: 1px solid #ddd; padding: 20px; border-radius: 5px;">
								<p class="center" style="font-size: 15px; text-transform: capitalize;">Set a new Password Permanently</p>
								<form method="post" action="<?php echo site_url(); ?>app_login/appUserChangePasswordAction">
									<div class="row">
										<?php 
											$tocken = $this->input->get('tocken');
											$id = substr($tocken, 0, -32);  // Last 32 Character cancel
										 ?>
										<input type="hidden" name="userId" value="<?php echo $id; ?>">
										<div class="col-sm-6">
											<label class="block clearfix">
												<span class="block input-icon input-icon-right">
													<input class="form-control" placeholder="New Password" autocomplete="off" name="new_pass" id="new_pass" required="required" style="font-size: 18px;height: 42px;border-radius: 5px !important;padding-left: 10px;" type="password">
													<i class="ace-icon fa fa-lock" style="position: absolute;right: 7px;top: 10px;color: #aaa;font-size: 20px;"></i>
												</span>
											</label>
										</div>
										<div class="col-sm-6">
											<label class="block clearfix">
												<span class="block input-icon input-icon-right">
													<input class="form-control" placeholder="Re-enter New Password" autocomplete="off" id="re_new_pass" required="required" style="font-size: 18px;height: 42px;border-radius: 5px !important;padding-left: 10px;" type="password">
													<i class="ace-icon fa fa-lock" style="position: absolute;right: 7px;top: 10px;color: #aaa;font-size: 20px;"></i>
												</span>
											</label>
										</div>
										<div class="col-sm-12">
											<label class="block clearfix">
												<input class="form-control" id="changePassBtn" disabled value="Change Password" style=" background: #458AC7; color: #fff; font-size: 18px;height: 42px;border-radius: 5px !important;" type="submit">
											</label>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="<?php echo base_url("data/js/jquery-3.2.1.min.js"); ?>"></script>

		<!-- <![endif]-->

		<!--[if IE]>
			<script src="<?php echo base_url() ?>data/js/jquery-1.10.2.min.js"></script>
		<![endif]-->

		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url("data/js/jquery.mobile.custom.min.js"); ?>'>"+"<"+"/script>");
		</script>

		<script type="text/javascript">
			$(document).on('blur', '#re_new_pass', function(){
				var new_pass 	= $('#new_pass').val();
				var re_new_pass = $(this).val();

				if(new_pass == re_new_pass){
					$('#changePassBtn').removeAttr('disabled');
				} else {
					$('#changePassBtn').attr('disabled', 'disabled');
				}
			});
		</script>

				
	</body>
</html>
