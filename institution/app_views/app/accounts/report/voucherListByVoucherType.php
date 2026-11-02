<table class="tableDesign">
	<tbody>
		<tr class="tableHeaderFooter">
			<th>SL</th>
			<th>Date</th>
			<th>Voucher ID</th>
			<th align="right">Amount</th>
			<th>User Name</th>		
			<th>Transaction Date and Time </th>		
		</tr>
		<?php 
			if(isset($voucherList) && !empty($voucherList)){
				$i = 1;
				foreach ($voucherList as $v) {
		 ?>
		<tr>
			<td><?php echo $i++; ?> </td>
			<td><?php echo date('d-M-Y', strtotime($v->voucher_date)); ?></td>
			<td>
				<a target="_blank" href="<?php echo site_url('accReport/voucher/'.$v->flag.'/'.$v->voucher_id); ?>" > <?php echo $v->voucher_id; ?> </a>
			</td>				
			<td align="right">
				<?php 
					echo $this->M_crud->sum($table, array('voucher_id' => $v->voucher_id), 'debit');
				?>
			</td>
			<td style="text-transform: capitalize;"><?php echo $this->session->userdata('app_login_name'); ?> </td>
			<td><?php echo date('d-M-Y H:i:s', strtotime($v->sys_date)); ?> </td>				
		</tr>
		<?php }} ?>
	</tbody>
</table>
<script type="text/javascript">
		document.getElementById('pageBody').classList.add("portrait");
		//document.getElementById('pageBody').classList.add("landscape");
</script>