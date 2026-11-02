<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>

	<!-- view Page Access function -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				User
				<small>
					<i class="fa fa-angle-double-right"></i>
					Create &amp; List
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12  col-sm-12">
				<!-- PAGE CONTENT BEGINS -->

				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>

					<i class="fa fa-check-square-o green"></i>

					User Manage Panel. This Panel Use Only User Create and User Access. 
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>

				<div class="row">
					<div class="col-xs-12  col-sm-12">
				    	<div class="modal-content">
					      	<div class="modal-header">
					        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					        		<!-- <span aria-hidden="true">&times;</span> -->
					        	</button>
					        	<h4 class="modal-title" style="text-transform: uppercase;">"<?php echo $userData->full_name; ?>" ACCESS LIST</h4>
					      	</div>
					    	<div class="modal-body">
								<div class="table-responsive"> 
									<table id="dynamic-table" class="table table-striped table-bordered table-hover">
										<thead>
											<tr>
											    <th class="text-center" style="width: 50px;">Sl No</th>
												<th class="text-center">Title</th>
												<th class="text-center">Detail</th>
												<th class="text-center">
													Access Status
												</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; if (isset($controllerList) && !empty($controllerList)): ?>
												<?php foreach ($controllerList as $clv): ?>
													<tr>
														<td class="text-center"><?php echo $i++; ?></td>
														<td class="text-left">
															<?php echo $clv->title_text; ?>
														</td>
														<td>
															<?php echo $clv->detail; ?>
														</td>
														<td class="text-center">
															<?php echo $clv->access_status; ?>
														</td>
													</tr>
												<?php endforeach ?>
											<?php endif ?>
										</tbody>
									</table>
								</div>
					      	</div>
					    </div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->