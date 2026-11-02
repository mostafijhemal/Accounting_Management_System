<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	<ul class="breadcrumb">
		<li>
			<i class="home-icon fa fa-home"></i>
			<a href="<?php echo site_url('dashboard/summary'); ?>">Home</a>
		</li>
		<?php 
			function breadcrumb_list($patent_menu_id = 0) {
				$_CI = &get_instance();
				$patent_menu = $_CI->M_crud->columnFindById(array('id', 'menu_id', 'menu_name'), 'menu_list', array('id' => $patent_menu_id));
				if(isset($patent_menu)) {
					$patent_menu_1 = $_CI->M_crud->columnFindById(array('id', 'menu_id', 'menu_name'), 'menu_list', array('id' => $patent_menu->menu_id));
					if(isset($patent_menu_1)) {
						$patent_menu_2 = $_CI->M_crud->columnFindById(array('id', 'menu_id', 'menu_name'), 'menu_list', array('id' => $patent_menu_1->menu_id));
							if(isset($patent_menu_2)) {
								$patent_menu_3 = $_CI->M_crud->columnFindById(array('id', 'menu_id', 'menu_name'), 'menu_list', array('id' => $patent_menu_2->menu_id));
								if(isset($patent_menu_3)) {
									if(!empty($patent_menu_3->menu_name)){
			    					 	echo '<li class="active"> .... </li>';
			    					}
								}
								if(!empty($patent_menu_2->menu_name)){
		    					 	echo '<li class="active"> '.$patent_menu_2->menu_name.' &nbsp;</li>';
		    					}
							}
						if(!empty($patent_menu_1->menu_name)){
						 	echo '<li class="active"> '.$patent_menu_1->menu_name.' &nbsp;</li>';
						}
					}
					if(!empty($patent_menu->menu_name)){
					 	echo '<li class="active"> '.$patent_menu->menu_name.' &nbsp;</li>';
					}
				}
			}
		 ?>
		 <?php 
		 	if(!empty(uri_string())) {
				$get_uri_string = uri_string();
				$explode_uri_string = explode('/', $get_uri_string);

				if(empty($explode_uri_string[1])) {
					$uri_string = $get_uri_string.'/';
				} else {
					$uri_string = $get_uri_string;
				}
			 	$menuNameForHead = $this->M_crud->columnFindById(array('id', 'menu_id', 'menu_name'), 'menu_list', array('menu_link' => $uri_string));
				if(isset($menuNameForHead)){
					if(!empty($menuNameForHead->menu_id)){
						breadcrumb_list($menuNameForHead->menu_id);
					} 
					echo '<li class="active"> '.$menuNameForHead->menu_name.' </li>';
				} 
			}
		?>
	</ul><!-- .breadcrumb -->
	
	<!-- nav-search -->
	<!-- <div class="nav-search" id="nav-search">
		<form class="form-search">
			<span class="input-icon">
				<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
				<i class="icon-search nav-search-icon fa fa-search"></i>
			</span>
		</form>
	</div> -->
</div>