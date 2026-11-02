<table class="tableDesign" border="1">
	<tbody>
		<!-- <tr class="tableHeaderFooter"> -->
		<tr>
			<th>SL</th>
			<th>Date</th>
			<th align="left">Narration</th>
			<th align="left">Ledger Name</th>
			<th>Debit</th>
			<th>Credit</th>
		</tr>
		<?php 
			$debitTotal = 0;  $creditTotal = 0;
			if(isset($list) && !empty($list)){
				$i = 1; 
				foreach ($list as $v) {
					$debit 	= $v->debit;
					$credit = $v->credit;
		 ?>
		<tr> 
			<td><?php echo $i++; ?></td>
			<td><?php if(!empty($v->voucher_date)) echo date('d-M-Y', strtotime($v->voucher_date)); ?></td>
			<td align="left">
				<?php echo $v->narration; ?>
			</td>
			<td align="left">
				<?php echo $v->accountName; ?>
			</td>
			<td align="right">
				<?php $debitTotal += $debit; echo number_format($debit, 2); ?>
			</td>	
			<td align="right">
				<?php $creditTotal += $credit; echo number_format($credit, 2); ?>
			</td>
		</tr>
		<?php }} ?>
		<!-- <tr class="tableHeaderFooter"> -->
		<tr>
			<td colspan="4" style="text-align: center;">
				<strong>Total</strong>
			</td>
			<td align="right">
				<strong><?php echo number_format($debitTotal, 2); ?></strong>
			</td>
			<td align="right">
				<strong><?php echo number_format($creditTotal, 2); ?></strong>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="text-align: center;">
				<strong>Balance</strong>
			</td>
			<td colspan="2" align="right">
				<strong>
				<?php 
					$balance = ($debitTotal - $creditTotal);
					echo number_format($balance, 2);
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