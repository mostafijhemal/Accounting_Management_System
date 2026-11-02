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
				<div class="col-xs-12 col-sm-12 col-md-12"></div>
				<div class="row">
					<?php $this->load->view('app/home/loginFormPage'); ?>
					<div class="col-xs-12 col-sm-12 col-md-12"></div>
					<div class="col-xs-12 col-sm-12 col-md-12" style="background: #fff; padding: 20px 50px;">
						<div class="col-xs-12 col-sm-4 col-md-4"></div>
						<form id="newUserFrom" method="post" action="<?php echo(site_url('setup/newUserSave')) ?>">
							<?php 
								$url = $_SERVER['REQUEST_URI'];
								$url = explode("/", $url);
							 ?>
							<div class="col-xs-12 col-sm-4 col-md-4">
								<?php if (!empty($contCreateUser)): ?>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<div class="form-control red"><?php echo $contCreateUser; ?></div>
									<br>
								</div>
								<?php endif ?>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<input type="hidden" name="company_id" value="<?php echo end($url); ?>">
									<label class="block clearfix"> Login Username <span class="red">*</span>
										<span class="block input-icon input-icon-right">
											<input type="text" class="form-control" placeholder="Login Username" autocomplete="off" 
			                                name="login_name" id="login_name" required = "required"/>
										</span>
									</label>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label class="block clearfix"> Password <span class="red">*</span>
										<span class="block input-icon input-icon-right">
											<input type="password" class="form-control" placeholder="Address" autocomplete="off" 
			                                name="password" id="password" required = "required"/>
										</span>
									</label>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label class="block clearfix"> Full Name <span class="red">*</span>
										<span class="block input-icon input-icon-right">
											<input type="text" class="form-control" placeholder="Full Name" autocomplete="off" 
			                                name="full_name" id="full_name" required = "required"/>
										</span>
									</label>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label class="block clearfix"> Designation <span class="red">*</span>
										<span class="block input-icon input-icon-right">
											<input type="text" class="form-control" placeholder="Designation" autocomplete="off" 
			                                name="designition" id="designition" required = "required"/>
										</span>
									</label>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label class="block clearfix"> Present Address <span class="red">*</span>
										<span class="block input-icon input-icon-right">
											<input type="text" class="form-control" placeholder="Present Address" autocomplete="off" 
			                                name="present_address" id="present_address" required = "required"/>
										</span>
									</label>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<label class="block clearfix"> Permanent Address <span class="red">*</span>
										<span class="block input-icon input-icon-right">
											<input type="text" class="form-control" placeholder="Permanent Address" autocomplete="off" 
			                                name="permanent_address" id="permanent_address" required = "required"/>
										</span>
									</label>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12">
									<div class="clearfix">
										<button type="submit" class="form-control pull-right btn btn-sm btn-primary">
											<i class="ace-icon fa fa-key"></i>
											<span class="bigger-110">Sign Up</span>
										</button>
									</div>
								</div>
							</div>
						</form>
						<div class="col-xs-12 col-sm-4 col-md-4"></div>
					</div>
					<?php $this->load->view('app/home/homeFooterPage'); ?>
				</div>
			</div>
		</div>





		<!-- basic scripts -->
		<script src="<?php echo base_url("data/js/jquery-3.2.1.min.js"); ?>"></script>
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url("data/js/jquery.mobile.custom.min.js"); ?>'>"+"<"+"/script>");
		</script>	
	</body>
</html>
