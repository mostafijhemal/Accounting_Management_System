<table class="tableDesign">
	<tbody>
		<tr class="tableHeaderFooter">
			<th>SL</th>
			<th>Date and Time </th>	
			<td>Narration</td>
			<th>Voucher ID &amp; Type</th>
			<th align="right">Amount</th>
			<th>User Name</th>			
		</tr>
		<?php 
			if(isset($voucherList) && !empty($voucherList)){
				$i = 1;
				foreach ($voucherList as $v) {
		 ?>
		<tr>
			<td><?php echo $i++; ?> </td>
			<td><?php echo date('d-M-Y H:i:s', strtotime($v->sys_date)); ?> </td>	
			<td align="left"><?php echo $v->narration; ?></td>
			<td>
				<a target="_blank" href="<?php echo site_url('accReport/voucher/'.$v->flag.'/'.$v->voucher_id); ?>" > 
					<?php 
						if($v->flag == 'DR'){
							$v_type = 'Debit';
						} else if($v->flag == 'CR'){
							$v_type = 'Credit';
						} else if($v->flag == 'JR'){
							$v_type = 'Journal';
						} else if($v->flag == 'CT'){
							$v_type = 'Contra';
						}
						echo $v->voucher_id.' '.$v_type; 
					?> 
				</a>
			</td>				
			<td align="right">
				<?php 
					echo $this->M_crud->sum($table, array('voucher_id' => $v->voucher_id), 'debit');
				?>
			</td>
			<td style="text-transform: capitalize;"><?php echo $this->session->userdata('app_login_name'); ?> </td>			
		</tr>
		<?php }} ?>
	</tbody>
</table>

<script type="text/javascript">
		//document.getElementById('pageBody').classList.add("portrait");
		document.getElementById('pageBody').classList.add("landscape");
</script>