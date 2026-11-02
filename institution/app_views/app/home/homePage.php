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
						<div class="col-xs-12 col-sm-6 col-md-6" style="border-right: 1px solid;">
							<p style="font-weight: bold;font-size: 20px;">This App Helps To Make Simple Business Life.</p>
							<img src="<?php echo(base_url('data/img/common/baner.jpg')); ?>" class="img-responsive" alt="">
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6">
							<form action="<?php echo site_url('home/create_company'); ?>" method="post">
								<h3>Create an account </h3>
								<p>It's free and always will be.</p>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<label class="block clearfix"> Company Name
											<span class="block input-icon input-icon-right">
												<input type="text" class="form-control" placeholder="Company Name" autocomplete="off" 
				                                name="company_name" id="company_name" required = "required"/>
											</span>
										</label>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12">
										<label class="block clearfix"> Mobile, Phone or Email 
											<span style="font-size: 10px;">(A Mobile, Phone or Email Use Only One Time)</span>
											<span class="block input-icon input-icon-right">
												<input type="text" class="form-control" placeholder="Mobile, Phone or Email" autocomplete="off" 
				                                name="email_or_phone" id="email_or_phone" required = "required"/>
											</span>
										</label>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12">
										<label class="block clearfix"> Address (Max:255)
											<span class="block input-icon input-icon-right">
												<input type="text" class="form-control" placeholder="Address" autocomplete="off" 
				                                name="address" id="address" required = "required"/>
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
									<div class="col-xs-12 col-sm-12 col-md-12">&nbsp;</div>
									<div class="col-xs-12 col-sm-12 col-md-12 text-center">
										<a href="<?php echo site_url() ?>setup/findYourCompany">Already have a Company?</a>&nbsp;&nbsp;&nbsp;
										<a href="<?php echo site_url() ?>setup/findYourCompany"><b>User guide</b></a>
									</div>

								</div>
							</form>
						</div>
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
