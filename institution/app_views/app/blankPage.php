<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>
		

<!-- view Page Access function   -->
<?php if(userAccessPart(1) != 'NULL') { ?>
	<div class="page-content">
		<div class="page-header">
			<h1>
				Test Page
				<small>
					<i class="fa fa-angle-double-right"></i>
					overview &amp; stats
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

					Welcome to
					<strong class="green">
						Test
						<small>(page)</small>
					</strong>
					, the test page use for data test.
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>
				

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">




					<!-- Do Something here -->





					</div>
				</div>
				<!-- PAGE CONTENT ENDS -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
<?php 
	} else {
		$this->load->view('app/common/pageNotAccessPage');
	}
?>
</div><!-- /.main-content -->
<script type="text/javascript">
	$(document).ready(function(){
		//alert('Ok');
	});
</script>