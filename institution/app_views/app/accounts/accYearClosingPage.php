<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>
		

<!-- view Page Access function   -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				Financial Year Closing
				<small>
					<i class="fa fa-angle-double-right"></i>
					overview &amp; status
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

					Financial Year Closing Panel
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>
				

				<div class="row">
					<div class="col-xs-12 col-sm-12">
					<?php 
						$from 	= date('d-M-Y', strtotime($instituteData->financial_year_from)); 
						$to 	= date('d-M-Y', strtotime($instituteData->financial_year_end)); 
						$fyYear = $from.' To '.$to;

						// One Day befour
						$prevDay= date('d-M-Y', strtotime('-1 days', strtotime($instituteData->financial_year_from)));
					 ?>

		<div class="page-content-inner">
			<div class="row">
				<div class="col-xs-12 col-sm-12">
					<!-- BEGIN VALIDATION STATES-->
					<div class="portlet light portlet-fit portlet-form">
						<div class="portlet-title row" style="margin-bottom: 0px; border-bottom: hidden;">
							<div class="col-xs-12 col-sm-12">
								<div style="background: #438EB9 !important;overflow: hidden;padding: 12px 0;font-size: 18px;color: #fff;">
									<div class="caption col-xs-6 col-sm-6">
										<i class="fa fa-building font-green"></i>
										<span class="caption-subject font-green sbold uppercase">Current Financial Year Closing</span>
									</div>
									<div class="actions col-xs-6 col-sm-6 text-right">
										<span class="caption-subject font-green sbold uppercase">
											Financial Year : <?php echo $fyYear; ?>	
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="portlet-body">
							<!-- BEGIN FORM-->
							<!-- Hidden input start -->
							<input type="hidden" id="id" value="<?php echo $instituteData->company_id; ?>">
							<input type="hidden" id="financial_year_from" value="<?php echo $instituteData->financial_year_from; ?>">
							<input type="hidden" id="site_url" value="<?php echo site_url(); ?>">
							<!-- Hidden input end -->
							<!-- REPORT OR ENTRY SYSTEM STRART -->						
							<div class="col-xs-12 col-sm-12">
								<div class="row panel panel-default">
									<div id="closingMess" class="panel-body" style="height:400px;">
										<?php 
											if($instituteData->financial_year_from < date('Y-m-d')){
										 ?>
										<div class="row">
											<div class="col-xs-12 col-sm-4">
											</div>											
											<div class="col-xs-12 col-sm-4">
												<br> <br> <br> <br> <br> <br>
												<button id="closing" class="form-control input-sm btn" style="background: #438EB9 !important;padding: 10px 0;height: 42px;text-transform: uppercase;" onclick="closing();">Year Closing</button>

											</div>
											<div class="col-xs-12 col-sm-4">
											</div>
										</div>
										<?php } else { ?>
										<div class="row">
											<div class="col-xs-12 col-sm-12 text-center">
												<h1 style="font-size: 33px;font-weight: 100;line-height: 64px;">
													Financial Year Already Closed on 
													<u><?php echo $prevDay; ?></u>. 
													You can Close Next Financial Year Between 
													<u><?php echo $fyYear; ?></u>
												</h1>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<!-- REPORT OR ENTRY SYSTEM END -->
					        <!-- END FORM-->
						</div>
					</div>
				</div>
			</div>
		</div>





					</div>
				</div>
				<!-- PAGE CONTENT ENDS -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->

</div><!-- /.main-content -->
<script type="text/javascript">
	$(document).ready(function(){
		//alert('Ok'); site_url
	});

	function closing() {
		if(confirm("Are You Sure to Financial Year Closing?")) {
			if(confirm("If You Click Ok The Financial Year will Close Permanently, Can't Back Next Time. So be careful.")) {
				$('#closing').attr('disabled', 'disabled');
				var financial_year_from = $('#financial_year_from').val();
				var site_url 			= $('#site_url').val();
				var id 		 			= $('#id').val();
				
				/*$('#closingMess').html('<div class="row">\
						<div class="col-xs-12 col-sm-12 text-center">\
							<h1 style="font-size: 33px;font-weight: 100;line-height: 64px;">\
							Please do not turn off this Computer or do not disconnect the internet connection Because Financial Year Closing Process is Running.\
							</h1>\
						</div>\
					</div>');*/
				$.ajax( {
					url 	: site_url+'accYearClosing/yearClosingAction',
					type 	: "POST",
					data 	: {id:id, financial_year_from:financial_year_from},
					dataType: "html",
					success : function(data){
						console.log();
						location.reload();
					},
			      	error: function (xhr, ajaxOptions, thrownError) {
			        	alert('Something is Wrong...');
						return false;
			        }
				});
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
</script>