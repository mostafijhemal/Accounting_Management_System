<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>
		

	<!-- view Page Access function   -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				Chart Of Accounts
				<small>
					<i class="fa fa-angle-double-right"></i>
					List &amp; Print
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12 col-sm-12">
				<!-- PAGE CONTENT BEGINS -->

				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>
					<i class="fa fa-check-square-o green"></i>
					Chart Of Accounts List
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>
				

				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<?php 
							function chartOfAccountsRecFun($account_id = 0) {
								$_CI = &get_instance();
								$company_id = $_CI->session->userdata('company_id');
								$ac_list2 = $_CI->M_crud->findAll('acc_chart_of_accounts', array('p_id' => $account_id, 'head_status' => 'Enable', 'company_id' => $company_id), 'account_id', 'asc');
								echo '<ul>';
									foreach ($ac_list2 as $v) {
										echo '<li style="margin-left: 40px;">';
											echo '<span>'.$v->account_name.' - '.$v->account_id.'</span>';
											chartOfAccountsRecFun($v->account_id);
										echo '</li>';
									}
								echo '</ul>';
							}
						?>
						<ul style="font-size: 14px; color: #000 !important;">
							<?php
								if(isset($ac_list)){
									foreach ($ac_list as $value) {
							 ?>
						 	<li>
								<span><?php echo $value->account_name.' - '.$value->account_id; ?></span>
								
								<?php 
									chartOfAccountsRecFun($value->account_id); 
								?>
							</li>
						 	<?php }} ?>
						</ul>
					</div>
				</div>
				<!-- PAGE CONTENT ENDS -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->
<script type="text/javascript">
	$(document).ready(function(){
		//alert('Ok');
	});
</script>