<div class="sidebar" id="sidebar">
	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
	</script>
	<?php
		$file_name 	= $this->router->fetch_class();
		$function 	= $this->router->fetch_method();
	 ?>
	<ul class="nav nav-list">
		<?php if(ENVIRONMENT == 'development'): ?>
			<li class="<?php if($file_name == 'app_menu' && $function == 'menu') echo 'active'; ?>" >
				<a href="<?php echo site_url().'app_menu/menu/NULL'; ?>">
					<i class="icon-list fa fa-bars"></i>
					<span class="menu-text"> Menu </span>
				</a>
			</li>
			<li class="<?php if($file_name == 'app_menu' && $function == 'controller') echo 'active'; ?>" >
				<a href="<?php echo site_url().'app_menu/controller'; ?>">
					<i class="icon-list fa fa-bars"></i>
					<span class="menu-text"> Controller </span>
				</a>
			</li>
		<?php endif; ?>
		<?php if ($this->session->userdata("app_user_type_id") == 3): ?>
			<li class="<?php if($file_name == 'instituteInfo' && $function == 'createCompany') echo 'active'; ?>" >
				<a href="<?php echo site_url().'instituteInfo/createCompany'; ?>">
					<i class="icon-list fa fa-industry"></i>
					<span class="menu-text"> Create Company </span>
				</a>
			</li>
			<li class="<?php if($file_name == 'app_user_manage' && $function == 'systemUserCreate') echo 'active'; ?>" >
				<a href="<?php echo site_url().'user/newUserAdd'; ?>">
					<i class="icon-list fa fa-user"></i>
					<span class="menu-text"> Create User </span>
				</a>
			</li>
		<?php endif ?>
		<?php 
			$menudata = $this->M_crud->findAll('menu_list', array('menu_id' => NULL, 'status' => 'active'), 'order', 'asc');
			if(isset($menudata)){
				function multi_sub_menu($subMenuId = 0) {
					$_CI = &get_instance();
					//$file_name 	= $_CI->router->fetch_class();
					//$function 	= $_CI->router->fetch_method();
					$link 		= uri_string();
					$menu_list2 = $_CI->M_crud->findAll('menu_list', array('menu_id' => $subMenuId, 'status' => 'active'), 'order', 'asc');
					echo '<ul class="submenu">';
						foreach ($menu_list2 as $v) {
							if($v->menu_link != '#' || $v->menu_link != NULL) {
								/*$linkExoad = explode('/', $v->menu_link); 
								if(empty($linkExoad[1])){
									$get_fun_name = 'index';
								} else {
									$get_fun_name = $linkExoad[1];
								}*/
								//if($file_name == $linkExoad[0] && $function == $get_fun_name) {
								if($link == $v->menu_link) {
									$active = 'active';
								} else {
									$active = '';
								}
							}

							if(!empty($v->target) || $v->target != NULL){
								$target = $v->target;
							} else {
								$target = '';
							}

							if($v->menu_link == '#' || $v->menu_link == NULL) {
								$menuLink = '#';
							} else { 
								$menuLink = site_url().$v->menu_link;
							}

							$menu_list3 = $_CI->M_crud->findAll('menu_list', array('menu_id' => $v->id, 'status' => 'active'), 'order', 'asc');

							if (!empty($menu_list3)) {
								$dropdown_toggle = 'dropdown-toggle';
							} else {
								$dropdown_toggle = '';
							}
							echo '<li class="'.$active.'" >';
								echo '<a target="'.$target.'" href="'.$menuLink.'" class="'.$dropdown_toggle.'">';
									echo '<i class="fa fa-caret-right"></i> ';
									echo $v->menu_name;
									if (!empty($menu_list3)) {
										echo '<b class="arrow fa fa-angle-down"></b>';
									}
								echo '</a>';
								multi_sub_menu($v->id);
							echo '</li>';
						}
					echo '</ul>';
				}
				
				foreach ($menudata as $menu_v_1) {
					if($menu_v_1->menu_link != '#' || $menu_v_1->menu_link != NULL) {
						$linkExoad = explode('/', $menu_v_1->menu_link); 
						if(empty($linkExoad[1])){
							$get_fun_name = 'index';
						} else {
							$get_fun_name = $linkExoad[1];
						}

						if($file_name == $linkExoad[0] && $function == $get_fun_name) {
							$active = 'active';
						} else {
							$active = '';
						}
					}
					if(!empty($menu_v_1->target) || $menu_v_1->target != NULL){
						$target = $menu_v_1->target;
					} else {
						$target = '';
					}
		 ?>
		 	<li class="<?php echo $active; ?>" >
		 		<?php 
					if($menu_v_1->menu_link == '#' || $menu_v_1->menu_link == NULL) {
						$menuLink = '#';
					} else { 
						$menuLink = site_url().$menu_v_1->menu_link;
					}

					$submenu_1_list = $this->M_crud->findAll('menu_list', array('menu_id' => $menu_v_1->id, 'status' => 'active'), 'order', 'asc');
					if (!empty($submenu_1_list)) {
						$dropdown_toggle = 'dropdown-toggle';
					} else {
						$dropdown_toggle = '';
					}

					
				?>
				<a target="<?php echo $target; ?>" href="<?php echo $menuLink; ?>" class="<?php echo $dropdown_toggle; ?>">
					<i class="icon-user <?php if($menu_v_1->menu_icon != NULL || !empty($menu_v_1->menu_icon)) echo $menu_v_1->menu_icon; else echo ' fa fa-bars'; ?>"></i>

					<span class="menu-text"> <?php echo $menu_v_1->menu_name; ?> </span>
					<?php
						if (!empty($submenu_1_list)) {
							echo '<b class="arrow fa fa-angle-down"></b>';
						}
					?>
				</a>
				<?php 
					multi_sub_menu($menu_v_1->id); 
				?>
			</li>
		<?php }} ?> 
	</ul><!-- /.nav-list -->

	<!-- <div class="sidebar-collapse" id="sidebar-collapse">
		<i class="icon-double-angle-left fa fa-angle-double-left" data-icon1="icon-double-angle-left fa fa-angle-double-left" data-icon2="icon-double-angle-right fa fa-angle-double-right"></i>
	</div> -->

	<script type="text/javascript">
		try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
	</script>
</div>