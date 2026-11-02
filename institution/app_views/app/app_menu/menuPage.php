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
			<li class="active">Menu</li>
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
							MENU LIST
							<div  class="pull-right" > 
							    <a href="#" role="button" class="label label-xlg label-light arrowed-in-right blue" data-toggle="modal" style="text-decoration:none;" data-target="#menuModal">
							    	<i title="Add New" class="fa fa-plus" style="line-height: 20px;"></i>	 
                                </a> 
                            </div>	 
						</div>
						<!-- div.table-responsive -->
						<?php if(!empty($menuInfo)): ?> <!-- data table view condation Start -->
						<div id="listView" class="table-responsive"> 
							<table id="dynamic-table" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
									    <th class="center" width="5%">Sl No</th>
										<th width="15%">Menu Name</th>
										<th width="15%">Link</th>
										<th class="text-center" width="15%">Status</th>
										<th class="text-center" width="5%">Order</th>
										<th class="text-center" width="15%">Action</th>
									</tr>
								</thead>
								<tbody>
								 <?php 
								     $i = 1;
								     foreach($menuInfo as $v){ 
								  ?>
									<tr>
										<td class="center">
											<?php echo $i++ ?>
										</td>
										<td><?php echo $v->menu_name ?></td>
										<td><?php echo $v->menu_link ?></td>
										<td class="text-center"><?php echo $v->status ?></td>
										<td class="text-center"><?php echo $v->order ?></td>
										<td class="text-center">
											<div class="btn-group">
											   	<a href="#" class="green" data-id="<?php echo $v->id ?>">
													<button class="btn btn-xs btn-info" data-rel="tooltip" title="Edit" data-placement="bottom">
														<i class="ace-icon fa fa-pencil bigger-120"></i>						
													</button>
												</a>
												<?php 
													$exist_menu = $this->M_crud->findAll('menu_list', array('menu_id' => $v->id), '', '');
													if(empty($exist_menu)){ 
												?>
                                               	<a href="<?php echo site_url('app_menu/delete/'.$v->id); ?>" class="red">
													<button class="btn btn-xs btn-danger"   
													    data-rel="tooltip" title="Delete" data-placement="bottom">
													    <i class="ace-icon fa fa-trash-o bigger-120"></i>								
													</button>
											   	</a>
												<?php } if($v->menu_link == '#'){ ?>
												<a href="<?php echo site_url('app_menu/menu/'.$v->id); ?>">
													<button class="btn btn-xs btn-success" data-id="<?php echo $v->id; ?>"  
														data-rel="tooltip" title="layer" data-placement="bottom">
													   Next Layer								
													</button>
												</a>
											    <?php } ?>
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
	        	<h4 class="modal-title" id="myModalLabel">MENU MANAGE</h4>
	      	</div>
		    <form id="addForm" action="<?php echo site_url('app_menu/menuStore'); ?>" method="post">
		    	<input type="hidden" name="editId" id="editId" value="" /> 
				<input type="hidden" name="menu_id" id="menu_id" value="<?php if(!empty($menu_id)) echo $menu_id; ?>" />
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
										<label for="order">Menu Order <span class="red">*</span></label>
										<input class="form-control" name="order" onkeyup="this.value=this.value.replace(/[^\d]/,'')" id="order" required tabindex="1" />
									</div>
								</div>
									
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="menu_name">Menu Name <span class="red">*</span></label>
										<input class="form-control" name="menu_name" id="menu_name" placeholder="Menu Name*" required tabindex="2" />
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-xs-12 col-sm-12">
									<div class="form-group">
										<label for="menu_link">Menu Link <span class="red">*</span></label>
										<input class="form-control" name="menu_link" id="menu_link" placeholder="Menu Link*" required tabindex="3" />
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-12 col-sm-12">
								  	<div class="form-group">
										<label for="target">Link Target</label>
										<div>
											<select class="form-control" id="target" name="target" tabindex="7" >
		                                        <option selected value="">Select Target </option>
												<option value="_blank">Always New Tab </option>
												<option value="blank">Always Same New Tab </option>
		                                        <option value="framename">Framename </option>
		                                        <option value="_parent">_parent </option>
		                                        <option value="_self">_self </option>
		                                        <option value="_top">_top </option>
		                                    </select>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="menu_icon">Icon Class</label>
										<input class="form-control" name="menu_icon" id="menu_icon" placeholder="Icon Class"  tabindex="4" />
									</div>
								</div>
								<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label for="status">Status <span class="red">*</span></label>
										<div>
											<select class="form-control" id="status" name="status"  tabindex="5" required>
		                                        <option selected="selected" value="">Select Status </option>
		                                        <option value="active" selected="selected">Active </option>
												<option value="inactive">In Active </option>
		                                    </select>
										</div>
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
	var formURL = "<?php echo site_url('app_menu/menuDataLoadForEdit'); ?>";
	
	$.ajax( {
		url : formURL,
		type: "POST",
		data : {id: id},
		dataType: "json",
		success:function(data){
			$('#menuModal').modal('show');
			$('#editId').val(data.menuData.id);
			$('#menu_id').val(data.menuData.menu_id);
			$('#order').val(data.menuData.order);
			$('#menu_name').val(data.menuData.menu_name);
			if(data.menu_exist != ''){
				$('#menu_link').attr('disabled', 'disabled');
				$('#menu_link').val(data.menuData.menu_link);
			} else {
				$('#menu_link').removeAttr('disabled');
				$('#menu_link').val(data.menuData.menu_link);
			}

			$('#menu_icon').val(data.menuData.menu_icon);
			$('#target').val(data.menuData.target);
			$('#status').val(data.menuData.status);
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
	//$("#addForm input[type='text'], #addForm input[name='editId']").val("");
	$("#order").val("");
	$("#menu_name").val("");
	$("#menu_link").val("");
	$("#target").val("");
	$("#menu_icon").val("");
	$("#status").val("active");
	$('.update').text("Save");
});

</script>