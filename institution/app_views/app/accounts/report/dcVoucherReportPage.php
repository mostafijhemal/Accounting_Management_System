<div>
	<div style="float:left;">&nbsp;</div>
	<div style="float:right;">Date : <?php echo $date; ?></div>
</div>
<table class="tableDesign custom-border" border="1">
	<tr>
		<th rowspan="2">SL</th>
		<th rowspan="2" align="left">Head</th>
		<th rowspan="2" align="left">Narration</th>
		<th colspan="2">Amount</th>
	</tr>
	<tr>
		<th>Debit</th>
		<th>Credit</th>	
	</tr>

	<?php 
		$_CI = &get_instance(); $sumValue = 0;
		if(isset($list)){
			$i = 1;
			foreach ($list as $v) {
	 ?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td align="left">
			<?php
				echo $_CI->accountName($v->account_id).' <b>['.$v->account_id.']</b>';
			 ?>
		</td>				
		<td align="left"><?php if(!empty($v->narration)) echo $v->narration; ?></td>
		<td align="right">
			<?php 
				if(!empty($v->debit)) {
					$sumValue += $v->debit;
					echo number_format($v->debit, 2);
				}
			 ?>
		</td>
		<td align="right"><?php if(!empty($v->credit)) echo number_format($v->credit, 2); ?> </td>				
	</tr>
	<?php }} ?>

	<?php if (isset($rowData) && !empty($rowData)): ?>
	<tr>
		<td>&nbsp; </td>
		<td align="left"> 
			<?php 
				echo $_CI->accountName($rowData->account_id).' <b>['.$rowData->account_id.']</b>';
			?>
		</td>
		<td>&nbsp; </td> 	
		<td align="right">
			<?php 
				if($rowData->debit != 0) {
					$sumValue = $rowData->debit;
					echo number_format($rowData->debit, 2); 
				} else {
					echo "0.00";
				}
			 ?>
		</td>
		<td align="right">
			<?php 
				if($rowData->credit != 0) {
					$sumValue = $rowData->credit;
					echo number_format($rowData->credit, 2); 
				} else {
					echo "0.00";
				}
			 ?>
		</td>
	</tr>
	<?php endif; ?>

	<tr>
		<td colspan="3" align="right">
			<strong>Total Amount</strong>
		</td>
		<td align="right">
			<strong><?php if($sumValue != 0) echo number_format($sumValue, 2); else echo "0.00"; ?></strong>
		</td>
		<td align="right">
			<strong>
				<?php 
					if($sumValue != 0) {
						$totalSum = $sumValue; 
						echo number_format($sumValue, 2); 
					} else {
						echo $totalSum = "0.00"; 
					}
				?>
			</strong>
		</td>
	</tr>
</table>
<br />
<span style="float:left;">Amount in Word : <?php echo $this->numbertowords->convert_number($totalSum); ?> taka only.</span>
<br />
<br />
<br /> 
<table class="tableDesign" style="border:none">
	<tr>
		<td class="sign_field"> ........................ <br /> Received by </td>
		<td class="sign_field"> ........................ <br /> Prepared by </td>
		<td class="sign_field"> ........................ <br /> Head of Accounts </td>
		<td class="sign_field"> ........................ <br /> Approved by </td>
	</tr>
</table>
<script type="text/javascript">
		document.getElementById('pageBody').classList.add("portrait");
		//document.getElementById('pageBody').classList.add("landscape");
</script>