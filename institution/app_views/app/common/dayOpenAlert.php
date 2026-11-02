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
						Working Day Required
					</h1>

					<hr />
					<h3 class="lighter smaller">
						We are really sorry this page is not allowed Yet. please Open A 
						<i class="fa fa-wrench icon-animated-wrench bigger-125"></i>
						Working Day.
					</h3>

					<!-- <div class="space"></div>

					<div>
						<h4 class="lighter smaller">Meanwhile, try one of the following:</h4>

						<ul class="list-unstyled spaced inline bigger-110 margin-15">
							<li>
								<i class="fa fa-hand-o-right blue"></i>
								Read the faq
							</li>
						</ul>
					</div> -->

					<hr />
					<div class="space"></div>

					<div class="center">
						<a href="#" onclick="window.history.back();" class="btn btn-grey">
							<i class="fa fa-arrow-left"></i>
							Go Back
						</a>

						<a href="<?php echo site_url(); ?>acc/dayOpenClose/0" class="btn btn-primary">
							<!-- <i class="fa fa-tachometer"></i> -->
							Day Open 
							<i class="fa fa-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>
			<!-- PAGE CONTENT ENDS -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->