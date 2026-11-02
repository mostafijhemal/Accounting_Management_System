<!-- basic styles -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/datepicker.css" />
		<?php 
			$file_name 	= $this->router->fetch_class();
			$function 	= $this->router->fetch_method();
			if($file_name == 'app' && $function == 'index'): 
		?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/font-awesome.min.css" />
		<?php endif; ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>data/font-awesome/4.7.0/css/font-awesome.min.css" />

		<!--[if IE 7]>
		  <link rel="stylesheet" href="<?php echo base_url(); ?>data/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->

		<!-- fonts -->

		<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/ace-fonts.css" />

		<!-- ace styles -->

		<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/ace.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/ace-skins.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/chosen.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="<?php echo base_url(); ?>data/css/ace-ie.min.css" />
		<![endif]-->
		<?php 
			if(isset($include_css)):
				foreach ($include_css as $value):
		 ?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('data/css/'.$value); ?>">
		<?php endforeach; endif; ?>
		<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/style.css" />
		<!-- inline styles related to this page -->