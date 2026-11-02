<div class="main-content">
	<!-- Menu Path Page -->
	<?php $this->load->view('app/common/breadcrumbPage'); ?>


	<!-- view Page Access function   -->
	<div class="page-content">
		<div class="page-header">
			<h1>
				Dashboard
				<small>
					<i class="fa fa-angle-double-right"></i>
					overview &amp; stats
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

					Welcome to Practical Action 
					<?php $this->load->view('app/pageLoadTime'); ?>
				</div>

				<?php 
					//echo "<br>";
					
					/*function GetVolumeLabel($drive) {
					   if (preg_match('#Volume Serial Number is (.*)\n#i', 
					   shell_exec('dir '.$drive.':'), $m)) {
					   $volname = ' ('.$m[1].')';
					   } else {
					   $volname = '';
					   }
					   return $volname;
					}
				   	$cdir = str_replace("(","",str_replace(")","",GetVolumeLabel("c")));
				   	$edir = str_replace("(","",str_replace(")","",GetVolumeLabel("e")));
				   	$fdir = str_replace("(","",str_replace(")","",GetVolumeLabel("f")));
				   	echo $fdir;
				   	echo "<br>";
				   	if($cdir == ' FC52-7DBF' && $edir == ' 6451-D479' && $fdir == ' A26E-E699'){
				   		echo "Ok";
				   	} else {
				   		echo "Not Ok";
				   	}*/
				   	//echo readfile("test.txt");
				   //	echo "<br>";

				   	/*$hostname = NULL;
					$ip = NULL;
					$var = gethostname();
					if ($var === FALSE) {
					  $var = NULL;
					} else {
					  $hostname = $var;
					  $ip   = gethostbyname($var);
					}
					echo $ip;

					echo "<br>";
					if($ip == '192.168.4.118') {
						echo "OK";
					} else {
						echo "No";
					}*/
				 ?>
				<?php if (sessionData('app_user_type_id') == 1 || sessionData('app_user_type_id') == 3): ?>
				<style type="text/css">
					.accSingleStyle {
						padding: 15px;
						border: 1px solid;
						background: #438EB9;
						margin-bottom: 10px;
						color: #fff;
					}
					.accSingleStyle h4 {
						margin: 0;
						font-size: 25px;
						text-transform: uppercase;
						text-align: center;
						margin-bottom: 15px;
					}
					.accSingleStyle div div i {
						font-size: 65px;
					}
					.widget-thumb-body {
						margin-top: 5px;
					}
					.widget-thumb-subtitle {
						font-weight: bold;
					}
					.widget-thumb-body-stat {
						font-weight: bold;
						font-size: 20px;
					}
				</style>
				<div class="row">
					<div class="col-xs-12 col-md-3">
						<!-- BEGIN WIDGET THUMB -->
						<div class="accSingleStyle">
							<h4 class="">Cash Amount</h4>
							<div class="row">
								<div class="col-md-4 col-xs-4">
									<i class="fa fa-money"></i>
								</div>
								<div class="col-md-8 col-xs-8">
									<div class="widget-thumb-body">
										<span class="widget-thumb-subtitle">BDT</span> <br>
										<span class="widget-thumb-body-stat" id="cashAmountSet">0</span>
										<span class="widget-thumb-body-stat">.00</span>
									</div>
								</div>
							</div>
						</div>
						<!-- END WIDGET THUMB -->
					</div>
					<div class="col-xs-12 col-md-3">
						<!-- BEGIN WIDGET THUMB -->
						<div class="accSingleStyle">
							<h4 class="">Bank Amount</h4>
							<div class="row">
								<div class="col-md-4 col-xs-4">
									<i class="fa fa-bank"></i>
								</div>
								<div class="col-md-8 col-xs-8">
									<div class="widget-thumb-body">
										<span class="widget-thumb-subtitle">BDT</span> <br>
										<span class="widget-thumb-body-stat" id="bankAmountSet">0</span>
										<span class="widget-thumb-body-stat">.00</span>
									</div>
								</div>
							</div>
						</div>
						<!-- END WIDGET THUMB -->
					</div>
					<div class="col-xs-12 col-md-3">
						<!-- BEGIN WIDGET THUMB -->
						<div class="accSingleStyle">
							<h4 class="">Expenditure</h4>
							<div class="row">
								<div class="col-md-4 col-xs-4">
									<i class="fa fa-shopping-cart"></i>
								</div>
								<div class="col-md-8 col-xs-8">
									<div class="widget-thumb-body">
										<span class="widget-thumb-subtitle">BDT</span> <br>
										<span class="widget-thumb-body-stat" id="expenditureAmountSet">0</span>
										<span class="widget-thumb-body-stat">.00</span>
									</div>
								</div>
							</div>
						</div>
						<!-- END WIDGET THUMB -->
					</div>
					<div class="col-xs-12 col-md-3">
						<!-- BEGIN WIDGET THUMB -->
						<div class="accSingleStyle">
							<h4 class="">Income</h4>
							<div class="row">
								<div class="col-md-4 col-xs-4">
									<i class="fa fa-hand-paper-o"></i>
								</div>
								<div class="col-md-8 col-xs-8">
									<div class="widget-thumb-body">
										<span class="widget-thumb-subtitle">BDT</span> <br>
										<span class="widget-thumb-body-stat" id="incomeAmountSet">00</span>
										<span class="widget-thumb-body-stat">.00</span>
									</div>
								</div>
							</div>
						</div>
						<!-- END WIDGET THUMB -->
					</div>
				</div>
				<div class="hr hr32 hr-dotted"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						// cash amount start
						var cashAmountSet = '<?php echo $cashAmount; ?>';
						var padding_zeros = '';
						for(var i = 0, l = cashAmountSet.toString().length; i < l; i++) {
						    padding_zeros += '0';
						}

						var cash_amount_padded_now, cash_amount_set = function(now, tween) {
						    var target = $(tween.elem),
						        rounded_now = Math.round(now);

						    var rounded_now_string = rounded_now.toString()
						    cash_amount_padded_now = padding_zeros + rounded_now_string;
						    cash_amount_padded_now = cash_amount_padded_now.substring(rounded_now_string.length);

						    target.prop('number', rounded_now).text(cash_amount_padded_now);
						};

					    $('#cashAmountSet').animateNumber({
					      	number: 		 cashAmountSet,
					      	cash_amount_set: cash_amount_set
					    }, 1000);
					    // cash amount end

					    // bank amount start
						var bankAmountSet = '<?php echo $bankAmount; ?>';
						var padding_zeros = '';
						for(var i = 0, l = bankAmountSet.toString().length; i < l; i++) {
						    padding_zeros += '0';
						}
						
						var bank_amount_padded_now, bank_amount_set = function(now, tween) {
						    var target = $(tween.elem),
						        rounded_now = Math.round(now);

						    var rounded_now_string = rounded_now.toString()
						    bank_amount_padded_now = padding_zeros + rounded_now_string;
						    bank_amount_padded_now = bank_amount_padded_now.substring(rounded_now_string.length);

						    target.prop('number', rounded_now).text(bank_amount_padded_now);
						};

					    $('#bankAmountSet').animateNumber({
					      	number: 		 bankAmountSet,
					      	bank_amount_set: bank_amount_set
					    }, 1000);
					    // bank amount end

					    // expenditure amount start
						var expenditureAmountSet = '<?php echo $expAmount; ?>';
						var padding_zeros = '';
						for(var i = 0, l = expenditureAmountSet.toString().length; i < l; i++) {
						    padding_zeros += '0';
						}
						
						var exp_ampuntpadded_now, exp_ampunt_set = function(now, tween) {
						    var target = $(tween.elem),
						        rounded_now = Math.round(now);

						    var rounded_now_string = rounded_now.toString()
						    exp_ampuntpadded_now   = padding_zeros + rounded_now_string;
						    exp_ampuntpadded_now   = exp_ampuntpadded_now.substring(rounded_now_string.length);

						    target.prop('number', rounded_now).text(exp_ampuntpadded_now);
						};

					    $('#expenditureAmountSet').animateNumber({
					      	number: 		expenditureAmountSet,
					      	exp_ampunt_set: exp_ampunt_set
					    }, 1000);
					    // expenditure amount end

					    // income amount start
						var incomeAmountSet = '<?php echo $incomeAmount; ?>';
						var padding_zeros = '';
						for(var i = 0, l = incomeAmountSet.toString().length; i < l; i++) {
						    padding_zeros += '0';
						}
						
						var income_amount_padded_now, income_amount_set = function(now, tween) {
						    var target = $(tween.elem),
						        rounded_now = Math.round(now);

						    var rounded_now_string   = rounded_now.toString()
						    income_amount_padded_now = padding_zeros + rounded_now_string;
						    income_amount_padded_now = income_amount_padded_now.substring(rounded_now_string.length);

						    target.prop('number', rounded_now).text(income_amount_padded_now);
						};

					    $('#incomeAmountSet').animateNumber({
					      	number: 		   incomeAmountSet,
					      	income_amount_set: income_amount_set
					    }, 1000);
					    // income amount end
					});
				</script>
				<?php endif ?>

				
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="table-header uppercase">
							LAST TEN VOUCHER
						</div>
						<?php if(isset($lastVoucherList) && !empty($lastVoucherList)){ ?>
						<div class="table-responsive"> 
							<table id="dynamic-table" class="table table-striped table-bordered table-hover text-center">
								<thead>
									<tr>
										<th class="text-center">SL</th>
										<th class="text-center">Voucher No</th>
										<th class="text-center">Voucher Type</th>
										<th class="text-center">Amount</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$i = 1; 
										foreach ($lastVoucherList as $vou_id) {
									 ?>
									<tr>
										<td><?php echo $i++; ?></td>
										<td><?php echo $vou_id->voucher_no; ?></td>
										<td>
											<?php echo $vou_id->type_name; ?>
										</td>
										<td class="text-right"><?php echo number_format($vou_id->totalVoucherAmount, 2); ?></td>
										<td>
											<a href="<?php echo site_url('accReport/voucher/'.$vou_id->id); ?>" target="_blank"><i class="fa fa-share"></i> View </a>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<?php } ?>
					</div>
					<div class="col-xs-12 col-md-6">
						<!-- <div class="table-header">
							Institute Informaton 
						</div> -->
					</div>
				</div>

				

				<!-- PAGE CONTENT ENDS -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.page-content -->
</div><!-- /.main-content -->