<style>
	/*Now the CSS*/
	* {margin: 0; padding: 0;}

	.tree {width:103% !important;}
	.tree ul {padding-top: 20px; position: relative;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;}
	.tree li {float: left; text-align: center;list-style-type: none;position: relative;padding: 20px 5px 0 5px;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;}

	/*We will use ::before and ::after to draw the connectors*/
	.tree li::before, .tree li::after{content: '';position: absolute; top: 0; right: 50%;border-top: 1px solid #ccc;width: 50%; height: 20px;}
	.tree li::after{right: auto; left: 50%;border-left: 1px solid #ccc;}

	/*We need to remove left-right connectors from elements without 
	any siblings*/
	.tree li:only-child::after, .tree li:only-child::before {display: none;}

	/*Remove space from the top of single children*/
	.tree li:only-child{ padding-top: 0;}

	/*Remove left connector from first child and 
	right connector from last child*/
	.tree li:first-child::before, .tree li:last-child::after{border: 0 none;}
	/*Adding back the vertical connector to the last nodes*/
	.tree li:last-child::before{border-right: 1px solid #ccc;border-radius: 0 5px 0 0;-webkit-border-radius: 0 5px 0 0;-moz-border-radius: 0 5px 0 0;}
	.tree li:first-child::after{border-radius: 5px 0 0 0;-webkit-border-radius: 5px 0 0 0;-moz-border-radius: 5px 0 0 0;}

	/*Time to add downward connectors from parents*/
	.tree ul ul::before{content: '';position: absolute; top: 0; left: 50%;border-left: 1px solid #ccc;width: 0; height: 20px;}

	.tree li a{border: 1px solid #ccc;
		padding: 5px 10px;
		text-decoration: none;
		color: #666;
		font-family: arial, verdana, tahoma;
		font-size: 11px;
		display: inline-block;
		
		border-radius: 5px;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		
		transition: all 0.5s;
		-webkit-transition: all 0.5s;
		-moz-transition: all 0.5s;
	}

	/*Time for some hover effects*/
	/*We will apply the hover effect the the lineage of the element also*/
	.tree li a:hover, .tree li a:hover+ul li a { background: #c8e4f8; color: #000; border: 1px solid #94a0b4; }
	/*Connector styles on hover*/
	.tree li a:hover+ul li::after, 
	.tree li a:hover+ul li::before, 
	.tree li a:hover+ul::before, 
	.tree li a:hover+ul ul::before{
		border-color:  #94a0b4;
	}

	/*Thats all. I hope you enjoyed it.
	Thanks :)*/

	.treeLayer, .treeLayer ul { margin:0; padding:0; list-style:none }
	.treeLayer ul {  margin-left:1em; position:relative }
	.treeLayer ul ul { margin-left:.5em }
	.treeLayer ul:before { content:""; display:block; width:0; position:absolute; top:0; bottom:0; left:0; border-left:1px solid; }
	.treeLayer li { margin:0; padding:0 1em; line-height:2em; color:#000000; font-weight:100; position:relative; width:100%; }
	.treeLayer ul li:before { content:""; display:block; width:10px; height:0; border-top:1px solid; margin-top:-1px; position:absolute; top:1em; left:0 }
	.treeLayer ul li:last-child:before { background:#fff; height:auto; top:1em; bottom:0; }
	.indicator { margin-right:5px; }
	.treeLayer li a { text-decoration: none; color:#000000; }
	.treeLayer li button, .treeLayer li button:active, .treeLayer li button:focus { text-decoration: none; color:#369; border:none; background:transparent; margin:0px 0px 0px 0px; padding:0px 0px 0px 0px; outline: 0; }
	.chart_of_ac_btn {background: #000;margin-right: 5px;color: #fff !important;font-size: 10px;padding: 2px 5px 4px 7px;}
</style>

<div class="main-content">
	<!-- Menu Path Page -->
	<?php 
		$company_id = $this->session->userdata('company_id');
		$this->load->view('app/common/breadcrumbPage'); 
	?>
		

	<!-- view Page Access function   -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				Chart Of Accounts
				<small>
					<i class="fa fa-angle-double-right"></i>
					Create &amp; Update
				</small>
			</h1>
		</div><!-- /.page-header -->

		<div class="row">
			<div class="col-xs-12">
				<!-- PAGE CONTENT BEGINS -->

				<div class="alert alert-block alert-success">
					<button type="button" class="close" data-dismiss="alert">
						<i class="fa fa-times"></i>
					</button>

					<i class="fa fa-check-square-o green"></i>

					Chart Of Accounts Panel 
					
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>
				

				<div class="row">
					<div class="col-xs-12 col-sm-12">
						<?php
						   	function salesAgentTreeLayer($parenstId) {
								$_CI   = &get_instance();
								$comId = $_CI->session->userdata('company_id');
								$info  = $_CI->M_crud->findAll('acc_chart_of_accounts', array('p_id' => $parenstId, 'company_id' => $comId), 'id', 'asc');
								
								if($info) {
									echo '<ul style="text-t">';
									foreach($info as $fn_v) {
										if($fn_v->status == 'Parent'){
											$cursor = 'pointer';
										} else {
											$cursor = 'cursor_pointer';
										}
										echo '<li class="uppercase '.$cursor.'">';
										echo  $fn_v->account_id.' - '.$fn_v->account_name.'&nbsp;&nbsp;&nbsp;'; 

										// get this accounts ids chils id
										//$chi = $_CI->get_child_id($fn_v->account_id, 1);  
										// get this head data from current ledger table 
										$ledgerData = $_CI->M_crud->columnFindById(array('account_id'), "acc_ledger_data", array('account_id' => $fn_v->account_id, 'company_id' => $comId));
										/* 
											if have any data into the ledger table
											the accounts id can not update 
											and can not add new accounts head under this head
										 */
										if(!isset($ledgerData) && empty($ledgerData)) {
											echo ' <a data-toggle="modal" data-target="#firstModal" p-id="'.$fn_v->p_id.'" account-id="'.$fn_v->account_id.'" class="chart_of_ac_btn add_head capitalize" href="#">Add</a>';
										}

										/*
											if have a child in this accounts head
											the accounts id can not update
										*/
										//if(!empty($chi) && isset($chi)) {
											//if($fn_v->account_id == $chi[0]){ 
												echo ' <a data-toggle="modal" data-target="#firstModal" data-id="'.$fn_v->id.'" p-id="'.$fn_v->p_id.'" account-id="'.$fn_v->account_id.'" class="chart_of_ac_btn update_head capitalize" href="#">Update</a>';
												
											//}
										//}
										if(!isset($ledgerData) && empty($ledgerData) && $fn_v->status == 'Child') {
											echo ' <a data-id="'.$fn_v->id.'" p-id="'.$fn_v->p_id.'" account-id="'.$fn_v->account_id.'" class="chart_of_ac_btn delete_head capitalize" href="#">Delete</a>';
										}
										
										salesAgentTreeLayer($fn_v->account_id);
										echo'</li>';
									}
									echo '</ul>';
								}
							}
						?>

						<div class="anotherTree">
							<div class="row">
								<div class="col-xs-12 col-sm-12">
									<ul id="treeLayer1" class="black">
										<?php foreach($layer as $v) { ?>
										<li class="uppercase">
											<a href="#"><?php echo $v->account_id.' - '.$v->account_name; ?>&nbsp;&nbsp;&nbsp;</a> 
											<a 
												p-id="<?php echo $v->p_id; ?>" 
												account-id="<?php echo $v->account_id; ?>" 
												class="chart_of_ac_btn add_head capitalize" 
												href="#">Add
											</a> 
											<!-- <a 
												data-toggle="modal" 
												data-target="#firstModal" 
												data-id="<?php //echo $v->id; ?>" 
												p-id="<?php //echo $v->p_id; ?>" 
												account-id="<?php //echo $v->account_id; ?>" 
												class="chart_of_ac_btn update_head capitalize" 
												href="#">Update
											</a> 
											<a 
												data-id="<?php //echo $v->id; ?>" 
												class="chart_of_ac_btn delete_head capitalize" 
												href="#">Delete
											</a> -->

											<?php salesAgentTreeLayer($v->account_id); ?>
										</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>	



						<!--  Modal  -->
						<div id="firstModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
						  	<div class="modal-dialog modal-sm" role="document">
							    <div class="modal-content">
							      	<div class="modal-header">
							        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							        		<span aria-hidden="true">&times;</span>
							        	</button>
							        	<h4 class="modal-title" id="myModalLabel">CREATE HEAD</h4>
							      	</div>
								    <form id="addForm" action="<?php echo site_url('acc/chartAccSave'); ?>" method="post">
								    	<div class="modal-body">
								        	<div class="row">
												<div class="col-xs-12 col-sm-12 hide">
													<div class="form-group">
								    					<input type="" name="id" id="id" />
								    					<input type="" name="p_id" id="p_id" />
								    					<input type="" name="account_id" id="account_id" />
													</div>
												</div>
												<div class="col-xs-12 col-sm-12">
													<div class="form-group">
														<label for="account_name">Head Name <span class="red">*</span></label>
														<input class="form-control focusField" name="account_name" id="account_name" placeholder="Head Name *" required tabindex="1" />
													</div>
												</div>
												<div id="existingAlert"></div>
												<div class="col-xs-12 col-sm-12">
													<div class="form-group">
														<label for="head_status">Head Status <span class="red">*</span></label>
														<select class="form-control" name="head_status" id="head_status" required tabindex="1">
															<option value="Enable">Enable</option>
															<option value="Disable">Disable</option>
														</select>
													</div>
												</div>
												<div id="requiredArea" class="col-xs-12 col-sm-12 hide">
													<div class="form-group">
														<label for="required_status">Required <span class="red">*</span></label>
														<select class="form-control" name="required_status" id="required_status" tabindex="1">
															<option value="No">No</option>
															<option value="Yes">Yes</option>
														</select>
													</div>
												</div>
											</div>
								      	</div>
								      	<div class="modal-footer accessCreate">
								        	<button class="btn btn-sm" data-dismiss="modal" tabindex="4">
												<i class="ace-icon fa fa-times"></i>
												Cancel
											</button>
											<button class="btn btn-sm btn-primary disabledBtn" type="submit" tabindex="3">
												<i class="ace-icon fa fa-check"></i>
												<span class="update">Save</span>
											</button>
								      	</div>
								    </form>
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
		
	});

	$('.add_head').click(function(){
		var p_id 		= $(this).attr('p-id');
		var account_id 	= $(this).attr('account-id');

		$('#p_id').val(p_id);
		$('#account_id').val(account_id);

		$('#firstModal').modal('show');
		return false;
	});

	$('.update_head').click(function(e){
		startLoading();
		var id 	= $(this).attr('data-id');

		//$('#id').val(id);
		$('.update').text("Save");

		$.ajax( {
			url : "<?php echo site_url('acc/chartAccDataGetForUpdate'); ?>",
			type: "POST",
			data : {id:id},
			dataType: "json",
			success:function(data){
				$('#id').val(data.id);
				$('#p_id').val(data.p_id);
				$('#account_id').val(data.account_id);
				$('#account_name').val(data.account_name);
				$('#head_status').val(data.head_status);
				$('#required_status').val(data.required_status);
				
				$('#firstModal').modal('show');
				$('.update').text("Update");
				stopLoading();
			}
		});
		e.preventDefault();

		$('#firstModal').modal('show');
		return false;
	});

	$('.delete_head').click(function(e){
		if(confirm("Are you sure to delete?")) {
			var data_id = $(this).attr('data-id');
			var p_id = $(this).attr('p-id');
			var account_id = $(this).attr('account-id');
			//console.log(data_id+' '+p_id+' '+account_id);

			var Linkhref = '<?php echo site_url('chartOfAccounts/deleteChartOfAccount'); ?>';
			$.ajax( {
				url 		: Linkhref,
				type 		: "POST",             	
				data 		: {id:data_id, p_id:p_id}, 
				dataType 	: "html",
				success 	:function(data){
					location.reload();
				}
			});
		} else {
			return false;
		}
		e.preventDefault();
	});
	
	/*$("#firstModal").submit(function(e) {
		startLoading();

		var Linkhref = '<?php //echo site_url('chartOfAccounts/saveChartOfAccount'); ?>';
		$.ajax( {
			url 		: Linkhref,
			type 		: "POST",             	
			data 		: new FormData(this), 	
			contentType : false,
			cache 		: false,
			processData : false,
			async 		: false,
			dataType 	: "html",
			success 	:function(data){
				location.reload();
				stopLoading();
				return false;
			}
		});
		e.preventDefault();
	});*/
</script>

<script>
	$.fn.extend({
	    treeLayerd: function (o) {
	      
	      var openedClass = 'fa fa-minus';
	      var closedClass = 'fa fa-plus';
	      
	      	if (typeof o != 'undefined'){
	        	if (typeof o.openedClass != 'undefined'){
	        		openedClass = o.openedClass;
	        	}
	        	if (typeof o.closedClass != 'undefined'){
	        		closedClass = o.closedClass;
	        	}
	      	}
	      
	        //initialize each of the top levels
	        var treeLayer = $(this);
	        treeLayer.addClass("treeLayer");
	        treeLayer.find('li').has("ul").each(function () {
	            var branch = $(this); //li with children ul
	            branch.prepend("<i class='indicator glyphicon " + openedClass + "'></i>");
	            branch.addClass('branch');
	            branch.on('click', function (e) {
	                if (this == e.target) {
	                    var icon = $(this).children('i:first');
	                    icon.toggleClass(closedClass + " " +openedClass );
	                    $(this).children().children().toggle();
	                }
	            });
	            branch.children().children();  // Open Tree
	            //branch.children().children().toggle();   // Close Tree
	        });
	        //fire event from the dynamically added icon
		    treeLayer.find('.branch .indicator').each(function(){
		        $(this).on('click', function () {
		            $(this).closest('li').click();
		        });
		    });
	        //fire event to open branch if the li contains an anchor instead of text
	        treeLayer.find('.branch>a').each(function () {
	            $(this).on('click', function (e) {
	                $(this).closest('li').click();
	                e.preventDefault();
	            });
	        });
	        //fire event to open branch if the li contains a button instead of text
	        treeLayer.find('.branch>button').each(function () {
	            $(this).on('click', function (e) {
	                $(this).closest('li').click();
	                e.preventDefault();
	            });
	        });
	    }
	});
	//Initialization of treeLayerviews
	$('#treeLayer1').treeLayerd();
</script>