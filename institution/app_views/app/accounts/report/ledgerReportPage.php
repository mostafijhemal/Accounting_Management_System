<table class="tableDesign" border="1">
	<style>
		a {text-decoration: none; color:#000000}
	</style>
	<tbody>
		<!-- <tr class="tableHeaderFooter"> -->
		<tr class="">
			<th>SL</th>
			<th>Date</th>
			<th width="45%" align="left">Narration</th>
			<th align="left">Ledger Name</th>
			<th>Debit</th>
			<th>Credit</th>
			<th>Balance</th>
		</tr>
		<?php 
			$debitTotal = 0;  $creditTotal = 0; $balance = 0.00;
			$i = 1; 
			if($opening->debit != 0 and $opening->credit != 0) {
		 ?>
		<tr> 
			<td><?php echo $i++; ?></td>
			<td align="center" colspan="2">
				<?php 
					if(!empty($opening->upToDate)) 
						echo 'Opening up to '.date('d-M-Y', strtotime($opening->upToDate));
				 ?>
			</td>
			<td align="left">
				<?php echo $opening->accountName;
				 ?>
			</td>
			<td align="right">
				<?php $debitTotal += $opening->debit; echo number_format($opening->debit, 2); ?>
			</td>	
			<td align="right">
				<?php $creditTotal += $opening->credit; echo number_format($opening->credit, 2); ?>
			</td>	
			<td align="right">
				<?php 
					$balance = (($balance + $opening->debit) - $opening->credit);
					if($balance < 0) {
						echo '('.number_format(abs($balance), 2).')'; 
					} else {
						echo number_format($balance, 2); 
					}
				 ?>
			</td>
		</tr>
			
		<?php 
			} 
			if(isset($list) && !empty($list)){
				foreach ($list as $v) {
		 ?>
		<tr> 
			<td><?php echo $i++; ?></td>
			<td><?php if(!empty($v->voucher_date)) echo date('d-M-Y', strtotime($v->voucher_date)); ?></td>
			<td align="left">
				<?php echo $v->narration; ?>
			</td>
			<td align="left">
				<?php 
					if(!empty($v->voucher_info_auto_id)) {
						$voucherLink = 'voucher/'.$v->voucher_info_auto_id;
						echo '<a target="_blank" href="'.$voucherLink.'">'.$v->account_name.' ['.$v->account_id.'] </a>';
					} else {
						echo $v->account_name.' ['.$v->account_id.']';
					}
				 ?>
			</td>
			<td align="right">
				<?php $debitTotal += $v->debit; echo number_format($v->debit, 2); ?>
			</td>	
			<td align="right">
				<?php $creditTotal += $v->credit; echo number_format($v->credit, 2); ?>
			</td>	
			<td align="right">
				<?php 
					$balance = (($balance + $v->debit) - $v->credit);
					if($balance < 0) {
						echo '('.number_format(abs($balance), 2).')'; 
					} else {
						echo number_format($balance, 2); 
					}
				 ?>
			</td>
		</tr>
		<?php }} ?>
		<!-- <tr class="tableHeaderFooter"> -->
		<tr class="">
			<td colspan="4" style="text-align: center;">
				<strong>Total</strong>
			</td>
			<td align="right">
				<strong>
					<?php 
						if($debitTotal < 0) {
							echo '('.number_format(abs($debitTotal), 2).')'; 
						} else {
							echo number_format($debitTotal, 2); 
						}
					 ?>
				</strong>
			</td>
			<td align="right">
				<strong>
					<?php 
						if($creditTotal < 0) {
							echo '('.number_format(abs($creditTotal), 2).')'; 
						} else {
							echo number_format($creditTotal, 2); 
						}
					 ?>
				</strong>
			</td>
			<td align="right">
				<strong>
					<?php 
						if($balance < 0) {
							echo '('.number_format(abs($balance), 2).')';
						} else if($balance > 0){
							echo number_format(abs($balance), 2);
						} else {
							echo "0.00";
						}
					 ?>
				</strong>
			</td>
		</tr>
	</tbody>
</table>
<script type="text/javascript">
	//document.getElementById('pageBody').classList.add("portrait");
	document.getElementById('pageBody').classList.add("landscape");
</script>
