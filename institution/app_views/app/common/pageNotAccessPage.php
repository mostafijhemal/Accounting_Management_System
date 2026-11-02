<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>
	<div class="page-content">
		<div class="row">
			<!-- PAGE CONTENT BEGINS -->
			<div class="error-container">
				<div class="well">
					<h1 class="grey lighter smaller">
						<span class="blue bigger-125">
							<i class="icon-random fa fa-lock"></i>
							HTTP 403 ERROR 
						</span>
						Permission Required
					</h1>

					<hr />
					<h3 class="lighter smaller">
						We are really sorry this page is not allowed for you. please contact an administrator for 
						<i class="fa fa-wrench icon-animated-wrench bigger-125"></i>
						permission.
					</h3>

					<div class="space"></div>

					<div>
						<h4 class="lighter smaller">Meanwhile, try one of the following:</h4>

						<ul class="list-unstyled spaced inline bigger-110 margin-15">
							<li>
								<i class="fa fa-hand-o-right blue"></i>
								Read the faq
							</li>
							<?php 
								$ins_data = $this->M_crud->findById('company_register_table', array('id' => $this->session->userdata('company_id')));
								if(isset($ins_data)):
							 ?>
							<?php if(!empty($ins_data->email)){ ?>
							<li>
								<i class="fa fa-hand-o-right blue"></i>
								Give us a E-mail <a href="mailto:<?php echo $ins_data->email; ?>"><?php echo $ins_data->email; ?></a>
							</li>
							<?php } ?>
							<?php if(!empty($ins_data->mobile_no)){ ?>
							<li>
								<i class="fa fa-hand-o-right blue"></i>
								Call head office cell phone <?php echo $ins_data->mobile_no; ?></a>
							</li>
							<?php } ?>
							<?php if(!empty($ins_data->phone_no)){ ?>
							<li>
								<i class="fa fa-hand-o-right blue"></i>
								Call head office land phone <?php echo $ins_data->phone_no; ?></a>
							</li>
							<?php } ?>
							<?php endif; ?>
						</ul>
					</div>

					<hr />
					<div class="space"></div>

					<div class="center">
						<a href="#" onclick="window.history.back();" class="btn btn-grey">
							<i class="fa fa-arrow-left"></i>
							Go Back
						</a>

						<a href="<?php echo site_url(); ?>dashboard/summary" class="btn btn-primary">
							<i class="fa fa-tachometer"></i>
							Dashboard
						</a>
					</div>
				</div>
			</div>
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->