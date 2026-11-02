 
 
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
						<div class="login-container" >
							<div class="position-relative slideInDown animated">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Please Enter Your Information
											</h4>

											<div class="space-6"></div>
											<?php if(!empty($msg)) { ?>
											<div class="alert alert-warning alert-dismissible" role="alert">
											  <button type="button" class="close" data-dismiss="alert" ></button>
											  <strong>Warning !</strong> <?php echo $msg; ?>.
											</div>
											<?php } ?>

											<form action="<?php echo site_url('app_login/authenticate'); ?>" method="post">
												<fieldset>
													
                                                    <label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" class="form-control" placeholder="Username"  autocomplete="off" 
                                                            name="login_name" id="login_name" required = "required"/>
															<i class="ace-icon fa fa-user" style="position: absolute;right: 7px;top: 10px;color: #aaa;"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" class="form-control" placeholder="password" 
                                                             name="password" id="password" autocomplete="off" required = "required" />
															<i class="ace-icon fa fa-lock" style="position: absolute;right: 7px;top: 10px;color: #aaa;"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">													

														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">Login</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
										</div>

										<div style="text-align: center;padding: 10px 0;" class="toolbar clearfix">
											
											<a style="color: #fff;" href="<?php echo site_url(); ?>app_login/appUserForgotPassword"><i class="fa fa-lock" aria-hidden="true"></i> Forgot Password</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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
