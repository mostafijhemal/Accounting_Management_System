<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>

	<!-- view Page Access function   -->
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
						<div class="table-header">
							USER LIST 
						</div>
						<!-- div.table-responsive -->
						<?php if(!empty($user_data)): ?> <!-- data table view condation Start -->
						<div class="table-responsive"> 
							<table id="dynamic-table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
									    <th class="center" width="8%">Sl No</th>
										<th class="text-center" width="15%">User Full Name</th>
										<th class="text-center" width="15%">Username</th>
										<th class="text-center" width="15%">Company</th>
										<th class="text-center" width="5%">E-mail</th>
										<th class="text-center" width="5%">Mobile</th>
										<th class="text-center" width="15%">Image</th>
										<th class="text-center" width="15%">Action</th>
									</tr>
								</thead>
								<tbody>
								<?php 
								    $i = $onset + 1; 
								    foreach($user_data as $v){ 
								?>
									<tr>
										<td class="center">
											<?php echo $i++; ?>
										</td>
										<td><?php if(!empty($v->full_name)) echo $v->full_name ?></td>
										<td class="text-center"><?php if(!empty($v->login_name)) echo $v->login_name ?></td>
										<td class="text-center">
											<?php if(!empty($v->company_name)) echo $v->company_name ?>
										</td>
										<td class="text-center"><?php if(!empty($v->email)) echo $v->email ?></td>
										<td class="text-center"><?php if(!empty($v->cell)) echo $v->cell ?></td>
										<td class="text-center">
											<?php 
												if(!empty($v->image)){
													echo '<img src="'.base_url().'data/images/upload/app_user/'.$v->image.'" style="width: 35px;margin: auto;" class="img-responsive img-rounded" alt="Image">';
												} else {
													echo '<i class="fa fa-user" aria-hidden="true"></i>';
												}
											 ?>
										</td>
										<td class="text-center">
											<div class="btn-group">
										   		<a target="_blank" href="<?php echo site_url("user/aUserAccessList/$v->id"); ?>">
													<button class="btn btn-xs btn-info" data-rel="tooltip" title="Edit" data-placement="bottom">
														<i class="ace-icon fa fa-desktop bigger-120"> View Access</i>
													</button>
												</a>
											</div>													
										</td>
									</tr>
									<?php } ?>
									<tr>
									    <th colspan="8">
											<ul class="pager pull-right">
												<li class="activePagi">
													<?php echo $this->pagination->create_links(); ?>
												</li>
											</ul>
										</th>
									</tr>
								</tbody>
							</table> 
						</div>
						<?php endif; ?> <!-- data table view condation end -->
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->

