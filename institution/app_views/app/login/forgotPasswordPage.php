 
 
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
							<h1 class="center">What's My Password?</h1>
							<hr>
							<div class="col-sm-12" style="border: 1px solid #ddd; padding: 20px; border-radius: 5px;">
								<p class="center" style="font-size: 15px; text-transform: capitalize;">If you have forgotten your password you can reset it here</p>
								<?php if(!empty($messege)): ?>
								<label class="block clearfix">
									<span class="block input-icon input-icon-right">
										<div class="center" style="border: 1px solid #ddd; color : red; font-size: 18px; border-radius: 5px !important; padding: 10px;">
											Verify Code Doesn't Exist. Please Re-send Mail
										</div>
									</span>
								</label>
								<?php endif; ?>
								<form method="post" action="<?php echo site_url(); ?>app_login/sandEmailForAppUserChangePassword">
									<label class="block clearfix">
										<span class="block input-icon input-icon-right">
											<input class="form-control" placeholder="E-mail Address" autocomplete="off" name="email_address" id="email_address" required="required" style="font-size: 18px;height: 42px;border-radius: 5px !important;padding-left: 10px;" type="email">
											<i class="ace-icon fa fa-at" style="position: absolute;right: 7px;top: 10px;color: #aaa;font-size: 20px;"></i>
										</span>
									</label>

									<div id="existngAlert"> <!-- Alert Load Here by jQuery --> </div>

									<label class="block clearfix">
										<input class="form-control" id="sandMailBtn" disabled value="Send Mail" style=" background: #458AC7; color: #fff; font-size: 18px;height: 42px;border-radius: 5px !important;" type="submit">
									</label>
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
			$(document).on('blur', '#email_address', function(e){
				var email_address = $(this).val();

				$('#existngAlert').html('');
				$('#sandMailBtn').attr('disabled', 'disabled');

				$.ajax( {
					url : "<?php echo site_url(); ?>app_login/testUserEmailIsExist",
					type: "POST",
					data : {email_address : email_address},
					dataType: "json",
					success:function(data){
						if(data != null) {
							$('#existngAlert').html('<label class="block clearfix"><span class="block input-iconinput-icon-right"> <div style="border: 1px solid #ddd; font-size: 18px; border-radius: 5px !important; padding: 10px;"> <ul> <li>Your Full Name is '+ data.full_name +'</li> <li>Login Name is '+ data.login_name +'</li> </ul> </div> </span> </label>');
							$('#sandMailBtn').removeAttr('disabled');
						} else {
							$('#existngAlert').html('<label class="block clearfix"><span class="block input-iconinput-icon-right"> <div style="border: 1px solid #ddd; font-size: 18px; border-radius: 5px !important; padding: 10px;"> <p style="color : red;margin : 0;">'+ email_address +' Dose Not Exist !</p> </div> </span> </label>');
							$('#email_address').val('').focus();
							$('#sandMailBtn').attr('disabled', 'disabled');
						}
					}
				});
				e.preventDefault();
			});
		</script>

				
	</body>
</html>
