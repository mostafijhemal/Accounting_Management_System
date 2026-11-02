<style type="text/css">
	.tableDesign {border: none}
</style>

<div>
	<!-- Left -->
	<div>
		<table class="tableDesign" border="1">
			<tbody>
				<!-- class="tableHeaderFooter" -->
				<tr>
					<th colspan="4">DEBIT (Expense)</th>
				</tr>
				<tr>
					<th width="32%">Account Head</th>
					<th width="12%">Opening</th>
					<th width="12%">Current</th>
					<th width="12%">Balance</th>
				</tr>
				<?php 
					$d_totalOpening = 0; $d_totalCurrent = 0; $d_totalBalane = 0; 
					if(isset($debitSite) && !empty($debitSite)){
						foreach ($debitSite as $dv) {
							if($dv->status == 'Child') {
								$font_weight = 'normal';
							} else {
								$font_weight = 'bold';
							}
							if($dv->status == 'Child') {
								if($dv->debitAmount != 0 || $dv->openingDebitAmount != 0) {
									$returnDebit = true;
								} else {
									$returnDebit = false;
								}
							} else {
								$returnDebit = true;
							}
							if($returnDebit) {
				 ?>
					<tr>
						<td style="text-align: left; padding-left: <?php echo (($dv->accIdLength * 20) - 60).'px'; ?>;">
							<form target="_blank" method="post" action="<?php echo(site_url("accReport/getLedgerReport")) ?>">
							 	<input type="hidden" name="from_date" value="<?php echo($dv->fromDate); ?>" >
							 	<input type="hidden" name="to_date" value="<?php echo($dv->toDate); ?>" >
							 	<input type="hidden" name="selectHead" value="<?php echo($dv->account_id); ?>" >
							 	<input type="submit" value="<?php echo($dv->account_id.' - '.$dv->account_name); ?>"  style="border: none;background: none;cursor: pointer;font-weight: <?php echo $font_weight; ?>;">
							</form>
						</td>
						<td align="right">
							<?php 
								if($dv->openingDebitAmount != 0 && $dv->status == 'Child') {
									if($dv->openingDebitAmount < 0) {
										echo '('.number_format(abs($dv->openingDebitAmount), 2).')'; 
									} else {
										echo number_format($dv->openingDebitAmount, 2); 
									}
									$d_totalOpening += $dv->openingDebitAmount;
								}
							?>
						</td>
						<td align="right">
							<?php 
								if($dv->debitAmount != 0 && $dv->status == 'Child') {
									if($dv->debitAmount < 0) {
										echo '('.number_format(abs($dv->debitAmount), 2).')'; 
									} else {
										echo number_format($dv->debitAmount, 2); 
									}
									$d_totalCurrent += $dv->debitAmount;
								}
							?>
						</td>
						<td align="right">
							<?php 
								$totalBalance = ($dv->openingDebitAmount + $dv->debitAmount);
								if($totalBalance != 0) {
									if($totalBalance < 0) {
										echo '('.number_format(abs($totalBalance), 2).')'; 
									} else {
										echo number_format($totalBalance, 2); 
									}
								}
								$totalBalance = 0;
							?>
						</td>
					</tr>
				<?php }}} ?>
				<tr>
					<td align="right" style="font-weight: bold; ">
						Total
					</td>
					<td align="right">
						<?php echo number_format($d_totalOpening, 2); ?>
					</td>
					<td align="right">
						<?php echo number_format($d_totalCurrent, 2); ?>
					</td>
					<td align="right">
						<?php echo number_format($d_totalOpening + $d_totalCurrent, 2); ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<div>&nbsp;</div>

	<!-- Right -->
	<div>
		<table class="tableDesign" border="1">
			<tbody>
				<!-- class="tableHeaderFooter" -->
				<tr>
					<th colspan="4">CREDIT (Income)</th>
				</tr>
				<tr>
					<th width="32%">Account Head</th>
					<th width="12%">Opening</th>
					<th width="12%">Current</th>
					<th width="12%">Balance</th>
				</tr>
				<?php 
					$c_totalOpening = 0; $c_totalCurrent = 0; $c_totalBalane = 0;
					if (isset($creditSite) && !empty($creditSite)) {
					 	foreach ($creditSite as $cv) { 
					 		if($cv->status == 'Child') {
								$font_weight = 'normal';
							} else {
								$font_weight = 'bold';
							}
							if($cv->status == 'Child') {
								if($cv->creditAmount != 0 || $cv->openingCreditAmount != 0) {
									$returnCredit = true;
								} else {
									$returnCredit = false;
								}
							} else {
								$returnCredit = true;
							}
							if($returnCredit) {
				?>
					<tr>
						<td style="text-align: left; padding-left: <?php echo (($cv->accIdLength * 20) - 60).'px'; ?>;">
							<form target="_blank" method="post" action="<?php echo(site_url("accReport/getLedgerReport")) ?>">
							 	<input type="hidden" name="from_date" value="<?php echo($cv->fromDate); ?>" >
							 	<input type="hidden" name="to_date" value="<?php echo($cv->toDate); ?>" >
							 	<input type="hidden" name="selectHead" value="<?php echo($cv->account_id); ?>" >
							 	<input type="submit" value="<?php echo($cv->account_id.' - '.$cv->account_name); ?>"  style="border: none;background: none;cursor: pointer;font-weight: <?php echo $font_weight; ?>;">
							</form>
						</td>
						<td align="right">
							<?php 
								if($cv->openingCreditAmount != 0 && $cv->status == 'Child') {
									if($cv->openingCreditAmount < 0) {
										echo '('.number_format(abs($cv->openingCreditAmount), 2).')'; 
									} else {
										echo number_format($cv->openingCreditAmount, 2); 
									}
									$c_totalOpening += $cv->openingCreditAmount;
								}
							?>
						</td>
						<td align="right">
							<?php 
								if($cv->creditAmount != 0 && $cv->status == 'Child') {
									if($cv->creditAmount < 0) {
										echo '('.number_format(abs($cv->creditAmount), 2).')'; 
									} else {
										echo number_format($cv->creditAmount, 2); 
									}
									$c_totalCurrent += $cv->creditAmount;
								}
							?>
						</td>
						<td align="right">
							<?php 
								$totalBalance = ($cv->openingCreditAmount + $cv->creditAmount);
								if($totalBalance != 0) {
									if($totalBalance < 0) {
										echo '('.number_format(abs($totalBalance), 2).')'; 
									} else {
										echo number_format($totalBalance, 2); 
									}
								}
								$totalBalance = 0;
							?>
						</td>
					</tr>
				<?php }}} ?>
				<tr>
					<th align="left">
						&nbsp; PROFIT LOSS A/C
					</th>
					<td align="right">
						<?php 
							$openingPlAc = ($d_totalOpening - $c_totalOpening);
							if($openingPlAc < 0) {
								echo '('.number_format(abs($openingPlAc), 2).')'; 
							} else {
								echo number_format($openingPlAc, 2); 
							}
						?>
					</td>
					<td align="right">
						<?php 
							$currentPlAc = ($d_totalCurrent - $c_totalCurrent);
							if($currentPlAc < 0) {
								echo '('.number_format(abs($currentPlAc), 2).')'; 
							} else {
								echo number_format($currentPlAc, 2); 
							}
						?>
					</td>
					<td align="right">
						<?php 
							$plAcBalance = ($openingPlAc + $currentPlAc);
							if($plAcBalance != 0) {
								if($plAcBalance < 0) {
									echo '('.number_format(abs($plAcBalance), 2).')'; 
								} else {
									echo number_format($plAcBalance, 2); 
								}
							}
						?>
					</td>
				</tr>
				<tr>
					<td align="right" style="font-weight: bold; ">
						Total
					</td>
					<td align="right">
						<?php echo number_format(($c_totalOpening + $openingPlAc), 2); ?>
					</td>
					<td align="right">
						<?php echo number_format(($c_totalCurrent + $currentPlAc), 2); ?>
					</td>
					<td align="right">
						<?php echo number_format((($c_totalOpening + $c_totalCurrent) + $plAcBalance), 2); ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

<script type="text/javascript">
		//document.getElementById('pageBody').classList.add("portrait");
		document.getElementById('pageBody').classList.add("landscape");
</script>