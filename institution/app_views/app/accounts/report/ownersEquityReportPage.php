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
					<th colspan="4">DEBIT</th>
				</tr>
				<tr>
					<th width="32%">Account Head</th>
					<th width="12%">Opening</th>
					<th width="12%">Current</th>
					<th width="12%">Balance</th>
				</tr>

				<tr>
					<th colspan="4" align="left" style="padding-left: 10px;">CAPITAL</th>
				</tr>
				<?php 
					$cap_totalOpening = 0; $cap_totalCurrent = 0; $cap_totalBalance = 0; 
					if (!empty($capital)): 
				?>
					<?php foreach ($capital as $cvl): ?>
						<tr>
							<td align="left" style="padding-left: 30px;">
								<form target="_blank" method="post" action="<?php echo(site_url("accReport/getLedgerReport")) ?>">
								 	<input type="hidden" name="from_date" value="<?php echo($cvl->fromDate); ?>" >
								 	<input type="hidden" name="to_date" value="<?php echo($cvl->toDate); ?>" >
								 	<input type="hidden" name="selectHead" value="<?php echo($cvl->account_id); ?>" >
								 	<input type="submit" value="<?php echo($cvl->account_id.' - '.$cvl->account_name); ?>" style="border: none;background: none;cursor: pointer;font-weight: normal;">
								</form>
							</td>
							<td align="right">
								<?php 
									if($cvl->totalCapitalOpening != 0) {
										if($cvl->totalCapitalOpening < 0) {
											echo '('.number_format(abs($cvl->totalCapitalOpening), 2).')'; 
										} else {
											echo number_format($cvl->totalCapitalOpening, 2); 
										}
										$cap_totalOpening += $cvl->totalCapitalOpening;
									} else {
										echo "0.00";
									}
								?>
							</td>
							<td align="right">
								<?php 
									if($cvl->totalCapitalCurrent != 0) {
										if($cvl->totalCapitalCurrent < 0) {
											echo '('.number_format(abs($cvl->totalCapitalCurrent), 2).')'; 
										} else {
											echo number_format($cvl->totalCapitalCurrent, 2); 
										}
										$cap_totalCurrent += $cvl->totalCapitalCurrent;
									}
								?>
							</td>
							<td align="right">
								<?php 
									$totalBalance = ($cvl->totalCapitalOpening + $cvl->totalCapitalCurrent);
									if($totalBalance != 0) {
										if($totalBalance < 0) {
											echo '('.number_format(abs($totalBalance), 2).')'; 
										} else {
											echo number_format($totalBalance, 2); 
										}
										$cap_totalBalance += $totalBalance;
									}
									$totalBalance = 0;
								?>
							</td>
						</tr>
					<?php endforeach ?>
				<?php endif ?>
				<tr>
					<th align="left" style="padding-left: 38px;">NET PROFIT/LOSS</th>
					<td align="right">
						<?php 
							if($profitLoass['openingPLV'] != 0) {
								if($profitLoass['openingPLV'] < 0) {
									echo '('.number_format(abs($profitLoass['openingPLV']), 2).')'; 
								} else {
									echo number_format($profitLoass['openingPLV'], 2); 
								}
								$cap_totalOpening += $profitLoass['openingPLV'];
							} else {
								echo "0.00";
							}
						 ?>
					</td>
					<td align="right">
						<?php 
							if($profitLoass['currentPLV'] != 0) {
								if($profitLoass['currentPLV'] < 0) {
									echo '('.number_format(abs($profitLoass['currentPLV']), 2).')'; 
								} else {
									echo number_format($profitLoass['currentPLV'], 2); 
								}
								$cap_totalCurrent += $profitLoass['currentPLV'];
							} else {
								echo "0.00";
							}
						 ?>
					</td>	
					<td align="right">
						<?php 
							$totalBalance = ($profitLoass['openingPLV'] + $profitLoass['currentPLV']);
							if($totalBalance != 0) {
								if($totalBalance < 0) {
									echo '('.number_format(abs($totalBalance), 2).')'; 
								} else {
									echo number_format($totalBalance, 2); 
								}
								$cap_totalBalance += $totalBalance;
							}
							$totalBalance = 0;
						?>
					</td>	
				</tr>
				<tr>
					<th align="right">
						TOTAL CAPITAL (A)
					</th>
					<th align="right">
						<?php echo number_format($cap_totalOpening, 2); ?>
					</th>
					<th align="right">
						<?php echo number_format($cap_totalCurrent, 2); ?>
					</th>
					<th align="right">
						<?php echo number_format($cap_totalBalance, 2); ?>
					</th>
				</tr>

				<tr>
					<th colspan="4" align="Left" style="padding-left: 10px;">WITHDRAW</th>
				</tr>

				<?php 
					$wd_totalOpening = 0; $wd_totalCurrent = 0; $wd_totalBalance = 0; 
					if (!empty($withdraw)): 
				?>
					<?php foreach ($withdraw as $wdvl): if(!empty($wdvl->account_name)): ?>
						<tr>
							<td align="left" style="padding-left: 30px;">
								<form target="_blank" method="post" action="<?php echo(site_url("accReport/getLedgerReport")) ?>">
								 	<input type="hidden" name="from_date" value="<?php echo($wdvl->fromDate); ?>" >
								 	<input type="hidden" name="to_date" value="<?php echo($wdvl->toDate); ?>" >
								 	<input type="hidden" name="selectHead" value="<?php echo($wdvl->account_id); ?>" >
								 	<input type="submit" value="<?php echo($wdvl->account_id.' - '.$wdvl->account_name); ?>" style="border: none;background: none;cursor: pointer;font-weight: normal;">
								</form>
							</td>
							<td align="right">
								<?php 
									if($wdvl->totalWithdrawOpening != 0) {
										if($wdvl->totalWithdrawOpening < 0) {
											echo '('.number_format(abs($wdvl->totalWithdrawOpening), 2).')'; 
										} else {
											echo number_format($wdvl->totalWithdrawOpening, 2); 
										}
										$wd_totalOpening += $wdvl->totalWithdrawOpening;
									} else {
										echo "0.00";
									}
								?>
							</td>
							<td align="right">
								<?php 
									if($wdvl->totalWithdrawCurrent != 0) {
										if($wdvl->totalWithdrawCurrent < 0) {
											echo '('.number_format(abs($wdvl->totalWithdrawCurrent), 2).')'; 
										} else {
											echo number_format($wdvl->totalWithdrawCurrent, 2); 
										}
										$wd_totalCurrent += $wdvl->totalWithdrawCurrent;
									}
								?>
							</td>
							<td align="right">
								<?php 
									$totalBalance = ($wdvl->totalWithdrawOpening + $wdvl->totalWithdrawCurrent);
									if($totalBalance != 0) {
										if($totalBalance < 0) {
											echo '('.number_format(abs($totalBalance), 2).')'; 
										} else {
											echo number_format($totalBalance, 2); 
										}
										$wd_totalBalance += $totalBalance;
									}
									$totalBalance = 0;
								?>
							</td>
						</tr>
					<?php endif; endforeach ?>
				<?php endif ?>

				<tr>
					<th align="right">
						TOTAL WIDTHDRAW (B)
					</th>
					<th align="right">
						<?php echo number_format($wd_totalOpening, 2); ?>
					</th>
					<th align="right">
						<?php echo number_format($wd_totalCurrent, 2); ?>
					</th>
					<th align="right">
						<?php echo number_format($wd_totalBalance, 2); ?>
					</th>
				</tr>

				<tr>
					<th align="left">
						OWNER'S EQUITY (A - B)
					</th>
					<th align="right">
						<?php echo number_format($cap_totalOpening - $wd_totalOpening, 2); ?>
					</th>
					<th align="right">
						<?php echo number_format($cap_totalCurrent - $wd_totalCurrent, 2); ?>
					</th>
					<th align="right">
						<?php echo number_format($cap_totalBalance + $wd_totalBalance, 2); ?>
					</th>
				</tr>
			</tbody>
		</table>
	</div>
<div>
<script type="text/javascript">
	//document.getElementById('pageBody').classList.add("portrait");
	document.getElementById('pageBody').classList.add("landscape");
</script>