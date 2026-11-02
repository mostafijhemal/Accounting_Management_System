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
	<?php $email = $this->input->get('email'); ?>
	<body class="login-layout blur-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3" style="margin-top:10%">
						<div class="" style="background: #fff; height: ; border-radius: 5px; overflow: hidden; padding: 10px;">
							<h1 class="center">Mail Verify</h1>
							<hr>
							<div class="col-sm-12" style="border: 1px solid #ddd; padding: 20px; border-radius: 5px;">
								<p class="center" style="font-size: 15px; text-transform: capitalize;">You don't late more than 10 minutes. Because Your Verify code doesn't work after 10 minutes.<br>If mail has not sent <a href="<?php echo site_url('app_login/sandEmailForAppUserChangePassword?email='.$email); ?>">Click here</a> for resend</p>
								<form method="post" action="<?php echo site_url(); ?>app_login/appUserForgotPasswordVerifyCodeCheck">
									<div class="row">
										<div class="col-sm-6">
											<input type="hidden" name="email" value="<?php echo $email; ?>">
											<label class="block clearfix">
												<span class="block input-icon input-icon-right">
													<input class="form-control" placeholder="Enter Verify Code" autocomplete="off" name="verify_code" id="verify_code" required="required"  maxlength="5" style="font-size: 18px;height: 42px; padding-left: 10px;" type="text">
													<i class="fa " style="position: absolute;right: 7px;top: 10px;color: #458AC7;font-size: 20px;"></i>
												</span>
											</label>
										</div>
										<div class="col-sm-6">
											<label class="block clearfix">
												<input class="form-control" disabled id="verify_btn" value="Verify" style=" background: #458AC7; color: #fff; font-size: 18px;height: 42px;" type="submit">
											</label>
										</div>
										<div class="col-sm-12">
											<?php 
												echo $this->session->flashdata('verifyCodeWrongessage');
											?>
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
			$(document).on('keyup', '#verify_code', function(){
				var str = $(this).val();
				/*var intRegex = /^\d+$/;
				var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;

				if(intRegex.test(str) || floatRegex.test(str)) {
				   	if(str.length == 5){
				   		$('.fa').addClass('fa-check');
				   		$('#verify_btn').removeAttr('disabled');
				   	} else {
				   		$('.fa').removeClass('fa-check');
				   		$('#verify_btn').attr('disabled', 'disabled');
				   	}
				} else {
					if(str.length > 0){
						alert('Please, Enter Integer Number');
						$('#verify_code').val('');
						$('.fa').removeClass('fa-check');
						$('#verify_btn').attr('disabled', 'disabled');
				   	}
				}*/
				if(str.length == 5){
			   		$('.fa').addClass('fa-check');
			   		$('#verify_btn').removeAttr('disabled');
			   	} else {
			   		$('.fa').removeClass('fa-check');
			   		$('#verify_btn').attr('disabled', 'disabled');
			   	}
			});

			setInterval(function() {
	     		$.ajax({
	     			url : "<?php echo site_url('app_login/tempVerifyCodeDelete'); ?>",
	     			type: 'post',
	     			dataType: "html",
	     			success:function(data){
	     				$('.messageArea').html(data);
	     			},
	     			error : function(error){
	     				//alert('Data Not Loaded'); awalrobiul70@gmail.com
	     			}
	     		});
			}, 500);
		</script>

				
	</body>
</html>
