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
						Company Information Update Required
					</h1>

					<hr />
					<h3 class="lighter smaller">
						We are really sorry this page is not Ready for Data Entry. Please update Company Information to 
						<i class="fa fa-wrench icon-animated-wrench bigger-125"></i>
						Ready This Page for Data Insert.
					</h3>

					<div class="space"></div>

					<div>
						<h4 class="lighter smaller">Required Field is:</h4>

						<ul class="list-unstyled spaced inline bigger-110 margin-15">
							<li>
								<i class="fa fa-hand-o-right blue"></i>
								Company Short Name
							</li>
							<li>
								<i class="fa fa-hand-o-right blue"></i>
								E-mail 
							</li>
							<li>
								<i class="fa fa-hand-o-right blue"></i>
								Financial year From
							</li>
							<li>
								<i class="fa fa-hand-o-right blue"></i>
								Financial year End
							</li>
						</ul>
					</div>

					<hr />
					<div class="space"></div>

					<div class="center">
						<a href="#" onclick="window.history.back();" class="btn btn-grey">
							<i class="fa fa-arrow-left"></i>
							Go Back
						</a>

						<a href="<?php echo site_url(); ?>company/information" class="btn btn-primary">
							<!-- <i class="fa fa-building"></i> -->
							Company Info 
							<i class="fa fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->