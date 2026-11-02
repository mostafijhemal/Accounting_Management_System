<div class="main-content">
	<div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>

		<ul class="breadcrumb">
			<li>
				<i class="home-icon fa fa-home"></i>
				<a href="#">Home</a>
			</li>
			<li class="active">Controller</li>
		</ul><!-- .breadcrumb -->

		<!-- nav-search -->
		<?php //$this->load->view('app/common/appSearchPage'); ?>
		<div class="nav-search" id="nav-search">
			<form class="form-search">
				<span class="input-icon">
					<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
					<i class="icon-search nav-search-icon fa fa-search"></i>
				</span>
			</form>
		</div>
	</div>

	<div class="page-content">
		<div class="page-header">
			<h1>
				Menu
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

					Menu Manage Panel. This Panel Use Only (Site or Application) Programmer. 
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>


				<div class="row">
					<div class="col-xs-12  col-sm-12">
						<div class="table-header">
							CONTROLLER LIST
							<div  class="pull-right" > 
							    <a href="#" role="button" class="label label-xlg label-light arrowed-in-right blue" data-toggle="modal" style="text-decoration:none;" data-target="#menuModal">
							    	<i title="Add New" class="fa fa-plus" style="line-height: 20px;"></i>	 
                                </a> 
                            </div>	 
						</div>
						<!-- div.table-responsive -->
						<?php if(!empty($list)): ?> <!-- data table view condation Start -->
						<div id="listView" class="table-responsive"> 
							<table id="dynamic-table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
									    <th class="center" width="5%">Sl No</th>
										<th class="center" width="15%">Title</th>
										<th class="center" width="15%">Controller Name</th>
										<th class="center" width="15%">Function Name</th>
										<th class="center" width="15%">Url Link</th>
										<th class="center" width="15%">Action</th>
									</tr>
								</thead>
								<tbody>
								 <?php 
								     $i = 1;
								     foreach($list as $v){ 
								  ?>
									<tr>
										<td class="center">
											<?php echo $i++ ?>
										</td>
										<td><?php echo $v->title_text ?></td>
										<td><?php echo $v->controller_name ?></td>
										<td><?php echo $v->function_name ?></td>
										<td><?php echo $v->url_link ?></td>
										<td class="text-center">
											<div class="btn-group">
											   	<a href="#" class="green" data-id="<?php echo $v->id ?>">
													<button class="btn btn-xs btn-info" data-rel="tooltip" title="Edit" data-placement="bottom">
														<i class="ace-icon fa fa-pencil bigger-120"></i>
													</button>
												</a>
                                               	<a href="<?php echo site_url('app_menu/controllerDelete/'.$v->id); ?>" class="red">
													<button class="btn btn-xs btn-danger"   
													    data-rel="tooltip" title="Delete" data-placement="bottom">
													    <i class="ace-icon fa fa-trash-o bigger-120"></i>
													</button>
											   	</a>
											</div>													
										</td>
									</tr>
									<?php } ?>
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


<!-- Modal -->
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        		<span aria-hidden="true">&times;</span>
	        	</button>
	        	<h4 class="modal-title" id="myModalLabel">CONTROLLER CREATE</h4>
	      	</div>
		    <form id="addForm" action="<?php echo site_url('app_menu/controllerStore'); ?>" method="post">
		    	<input type="hidden" name="id" id="id"/> 
		    	<div class="modal-body">
			    	<?php if($this->input->get('status') == 'success') { ?>
	                    <div class="alert alert-success alert-dismissible" role="alert">
	                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                        <strong>Success!</strong> Save Successfull.
	                    </div>
	                <?php } ?>
		        	<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="controller_name">Controller Name <span class="red">*</span></label>
										<input class="form-control" name="controller_name" id="controller_name" placeholder="Controller Name *" required tabindex="1" />
									</div>
								</div>
									
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="function_name">Function Name <span class="red">*</span></label>
										<input class="form-control" name="function_name" id="function_name" placeholder="Function Name *" required tabindex="2" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-12">
									<div class="form-group">
										<label for="url_link">Url Link <span class="red">*</span></label>
										<input class="form-control" name="url_link" id="url_link" placeholder="Url Link *" required tabindex="3" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-12">
									<div class="form-group">
										<label for="title_text">Title <span class="red">*</span></label>
										<input class="form-control" name="title_text" id="title_text" placeholder="Title *" required tabindex="4" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-12">
									<div class="form-group">
										<label for="detail">Detail</label>
										<textarea class="form-control" name="detail" id="detail" placeholder="Detail"  tabindex="5"></textarea>
									</div>
								</div>
							</div>
              			</div>
					</div>
		      	</div>
		      	<div class="modal-footer">
		        	<button class="btn btn-sm" data-dismiss="modal" tabindex="10">
						<i class="ace-icon fa fa-times"></i>
						Cancel
					</button>
					<button class="btn btn-sm btn-primary" type="submit" tabindex="9">
						<i class="ace-icon fa fa-check"></i>
						<span class="update">Save</span>
					</button>
		      	</div>
		    </form>
	    </div>
  	</div>
</div>



<script type="text/javascript">

<?php if($this->input->get('popup') == 1) { ?>
	$('#menuModal').modal('show');
<?php } ?>

 
//update data by ajax
$(document).on("click", ".green", function(e) {
	var id 		= $(this).attr("data-id");
	var formURL = "<?php echo site_url('app_menu/controllerDataLoadForEdit'); ?>";
	
	$.ajax( {
		url : formURL,
		type: "POST",
		data : {id: id},
		dataType: "json",
		success:function(data){
			$('#menuModal').modal('show');

			$('#id').val(data.id);
			$('#controller_name').val(data.controller_name);
			$('#function_name').val(data.function_name);
			$('#url_link').val(data.url_link);
			$('#title_text').val(data.title_text);
			$('#detail').val(data.detail);

			$('.update').text("Update");
		}
	});
	e.preventDefault();
});

$(document).on("click", ".red", function(e) {		
	var x = confirm('Are you sure to delete?');
	if(x) {
		var tr =  $(this).parents('tr'); 
		var formURL = $(this).attr('href');
		$.ajax({
			url : formURL,
			type: "POST",
			data : {},
			success:function(data){
				tr.remove();
				alertMessageFunction('Success ! ', 'Delete Successfully');
			}
		});
	} else {
		return false;
	} 
	e.preventDefault();
});



$('.blue').on('click', function() {
	$("#id").val("");
	$("#controller_name").val("");
	$("#function_name").val("");
	$("#url_link").val("");
	$("#title_text").val("");
	$("#detail").val("");

	$('.update').text("Save");
});

</script>