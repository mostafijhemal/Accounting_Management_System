<div style="width: 100%; position: relative; overflow: auto;">
	<!-- Left -->
	<div style="float: left; width: 50%">
		<table class="tableDesign">
			<?php 
				$_CI = &get_instance();

				$from_date 	= $this->input->get('from_date');
				$to_date 	= $this->input->get('to_date');	

				if(!empty($from_date)) 	$where['voucher_date >='] = $from_date;
				if(!empty($to_date)) 	$where['voucher_date <='] = $to_date;
    									$where['approve_id !=']   = NULL;
			 ?>
			<tbody>
				<tr class="tableHeaderFooter">
					<th>EXPENDITURE (DEBIT)</th>
					<th>AMOUNT</th>
				</tr>
				<?php 
					$totalExp = 0;
					if(isset($expenceHead) && !empty($expenceHead)){
						foreach ($expenceHead as $ex_v) {
				 ?>
				<tr>
					<td style="text-align: left; font-weight: bold; padding-left: 10px;">
						<?php 
							echo $ex_v->account_id.' - '.$ex_v->account_name;
						 ?>
					</td>
					<td style="text-align: right;">
						<?php 
							$expense_child 	= $_CI->get_child_id($ex_v->account_id, 1); 
							$totalExpAmount = 0;
							if(isset($expense_child) && !empty($expense_child)){
								foreach ($expense_child as $ceck1_v) {
									$where['account_id'] = $ceck1_v;

									$expenseAmount= $this->M_crud->sum($table, $where, 'debit');
									$totalExpAmount += $expenseAmount;
								}
							}
							if($totalExpAmount != 0 && $ex_v->status == 'Child') {
								if($totalExpAmount < 0) {
									echo '('.number_format(abs($totalExpAmount), 2).')'; 
								} else {
									echo number_format($totalExpAmount, 2); 
								}
							}
						?>
					</td>
				</tr>
				<?php 
					$totalExp += $totalExpAmount;
					if($totalExpAmount != 0) {
						$_CI->classification($ex_v->account_id, 20, $table, 'debit', $from_date, $to_date); 
					}
				?>
				<?php }} ?>
			</tbody>
		</table>
	</div>

	<!-- Right -->
	<div style="float: right; width: 50%">
		<table class="tableDesign">
			<tbody>
				<tr class="tableHeaderFooter">
					<th>INCOME (CREDIT)</th>
					<th>AMOUNT</th>
				</tr>
				<?php 
					$totalIn = 0;
					if(isset($incomeHead) && !empty($incomeHead)){
						foreach ($incomeHead as $in_v) {
				 ?>
				<tr>
					<td style="text-align: left; font-weight: bold; padding-left: 10px;">
						<?php 
							echo $in_v->account_id.' - '.$in_v->account_name;
						 ?>
					</td>
					<td>
						<?php 
							$income_child 	= $_CI->get_child_id($in_v->account_id, 1); 
							$totalInAmount = 0;
							if(isset($income_child) && !empty($income_child)){
								foreach ($income_child as $ceck2_v) {
									$where['account_id'] = $ceck2_v;

									$expenseAmount= $this->M_crud->sum($table, $where, 'credit');
									$totalInAmount += $expenseAmount;
								}
							}
							if($totalInAmount != 0 && $in_v->status == 'Child'){
								if($totalInAmount < 0) {
									echo '('.number_format(abs($totalInAmount), 2).')'; 
								} else {
									echo number_format($totalInAmount, 2); 
								}
							}
						 ?>
					</td>
				</tr>
				<?php 
					$totalIn += $totalInAmount;
					if($totalInAmount != 0) {
						$_CI->classification($in_v->account_id, 20, $table, 'credit', $from_date, $to_date); 
					}
				?>
				<?php }} ?>
			</tbody>
		</table>
	</div>

	<!-- Footer -->
	<div style="width: 100%; position: relative; overflow: auto;">
		<table style="width: 100%;">
			<tbody>
				<tr class="tableHeaderFooter">
					<td style="text-align: center; width: 25%;">
						<strong>Total</strong>
					</td>
					<td style="text-align: right; width: 25%; padding-right: 10px;">
						<strong><?php if($totalExp != 0) echo number_format($totalExp, 2); else echo "0.00"; ?></strong>
					</td>
					<td style="text-align: center; width: 25%;">
						<strong>Total</strong>
					</td>
					<td style="text-align: right; width: 25%;">
						<strong><?php if($totalIn != 0) echo number_format($totalIn, 2); else echo "0.00"; ?></strong>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
		document.getElementById('pageBody').classList.add("portrait");
		//document.getElementById('pageBody').classList.add("landscape");
</script>