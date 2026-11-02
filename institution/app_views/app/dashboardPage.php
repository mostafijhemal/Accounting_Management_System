<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> -->
		<?php $head_data = $this->M_crud->columnFindById(array('short_name', 'fab_icon'), 'company_register_table', array('id' => $this->session->userdata("company_id"))); ?>

		<title><?php if(!empty($head_data->short_name)) echo $head_data->short_name.' - '.$title; else echo $title; ?></title>
		<meta name="description" content="<?php if(isset($meta_description)) echo $meta_description; ?>" />
		<meta name="keywords" content="<?php if(isset($meta_keywords)) echo $meta_keywords; ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<?php if(!empty($head_data->fab_icon)){ ?>
		<!-- Favicon link -->
		<link rel="icon" href="<?php echo base_url('data/img/common/'.$head_data->fab_icon); ?>" type="image/x-icon" />
		<?php } ?>

		<!-- Css Page load here -->
		<?php $this->load->view('app/common/appCssLinkPage'); ?>

		<!-- ace settings handler -->
		<script src="<?php echo base_url(); ?>data/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="<?php echo base_url(); ?>data/js/html5shiv.js"></script>
		<script src="<?php echo base_url(); ?>data/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<!-- <body onload="startLoading();"> -->
	<body>
		<!-- Header Page load here -->
		<?php $this->load->view('app/common/appHeaderPage'); ?>
		
		
		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>
				
				<!-- Menu load here -->
				<?php $this->load->view('app/common/appMenuPage'); ?>
				
				<!-- Js Lnik Page -->
				<?php $this->load->view('app/common/appJsLinkPage'); ?>
				
				<!-- Content Page load here -->
				<?php
					if(isset($content)){
						$this->load->view('app/'.$content); 
					}
				?>
				
				<!-- ace-settings-container -->
				<?php //$this->load->view('app/common/appSettingsContainerPage'); ?>
			</div><!-- /.main-container-inner -->

			<a style="position: fixed;" href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
		
		<?php $this->load->view('app/common/appFooterPage'); ?>




		<script type="text/javascript">
			$(document).on("click", ".dataDelete", function() {		
				var x = confirm('Are you sure to delete?');

				if(x) {
					var formURL = $(this).attr('data-url');
					$.ajax(
					{
						url : formURL,
						type: "POST",
						data : {},
						success:function(data){
							location.reload();
						}
					});
				} else {
				 	return false;
				} 
			});

			$(document).on("wheel", "input[type=number]", function (e) {
			    $(this).blur();
			});
		   
	
			/*$(window).bind("load", function() { 
				stopLoading();
				setTimeout(function(){ stopLoading(); }, 100);
			});*/
			$(document).ready(function(){
				// Menu Li Element Active 
				$('li.active').parents('li').addClass('active');
			});

			$(document).keyup(function(e) {
			  	//if (e.keyCode === 13) $('.save').click();     // enter
			  	if (e.keyCode === 27) stopLoading();   			// esc
			});

			/*setInterval(function() {
				var siteUrl = "<?php //echo site_url(); ?>";
	     		var currentLocation = $(location).attr('href');
	     		$.ajax({
	     			url : "<?php //echo site_url('notification/messageNotification'); ?>",
	     			type: 'post',
	     			dataType: "html",
	     			success:function(data){
	     				$('#messageNotification').html(data);
	     			}
	     		});
			}, 10000);

			setInterval(function() {
				// Account Closing and session distroy 
	     		$.ajax({
	     			url : "<?php //echo site_url('accYearClosing/accClosingCheck'); ?>",
	     			type: 'post',
	     			dataType: "html",
	     			success:function(data){
	     				console.log('Ok');
	     			}
	     		});
			}, 500);*/
		</script>


		
	</body>
</html>
