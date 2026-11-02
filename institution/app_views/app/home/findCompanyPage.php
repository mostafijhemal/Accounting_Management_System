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
							<h1 class="center">Find Company</h1>
							<hr>
							<div class="col-sm-12" style="border: 1px solid #ddd; padding: 20px; border-radius: 5px;">
								<p class="center" style="font-size: 15px; text-transform: capitalize;">Company Registered Mobile, Phone or Email.</p>
								<form method="post" action="<?php echo site_url(); ?>home/findCompanyAction">
									<div class="row">
										<div class="col-sm-8">
											<label class="block clearfix">
												<span class="block input-icon input-icon-right">
													<input class="form-control" placeholder="Mobile, Phone or Email." autocomplete="off" name="email" id="email" required="required" style="font-size: 18px;height: 42px; padding-left: 10px;" type="text">
													<i class="fa " style="position: absolute;right: 7px;top: 10px;color: #458AC7;font-size: 20px;"></i>
												</span>
											</label>
										</div>

										<div class="col-sm-4">
											<label class="block clearfix">
												<input class="form-control" value="Click to find" style=" background: #458AC7; color: #fff; font-size: 18px;height: 42px;" type="submit">
											</label>
										</div>
										<?php if(!empty($comNotExistMes)) { ?>
										<div class="col-sm-12">
											<div id="sectionAlertInPhp" style="right: 20px; top: 50px; background: #e60000; color: #fff;text-align: justify; z-index: 1000;" class="alert alert-success alert-dismissible" role="alert" >
											    <strong>Error! </strong>&nbsp; <?php echo $comNotExistMes; ?>
											</div>
										</div>
										<?php } ?>
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
				//
			});
		</script>

				
	</body>
</html>
