<?php 
	function chartOfAccountsRecFun($account_id = 0) {
		$_CI = &get_instance();
		$ac_list2 = $_CI->M_crud->findAll('acc_chart_of_accounts', array('p_id' => $account_id, 'head_status' => 'Enable'), 'account_id', 'asc');
		echo '<ul>';
			foreach ($ac_list2 as $v) {
				echo '<li style="margin-left: 20px;">';
					echo '<span>'.$v->account_name.' - '.$v->account_id.'</span>';
					chartOfAccountsRecFun($v->account_id);
				echo '</li>';
			}
		echo '</ul>';
	}
?>
<ul style="font-size: 14px; color: #000 !important;text-align: left;font-family: 'Times New Roman', Times, serif;">
	<?php
		if(isset($account_list)){
			foreach ($account_list as $value) {
	 ?>
 	<li>
			<span><?php echo $value->account_name.' - '.$value->account_id; ?></span>
			
			<?php 
				chartOfAccountsRecFun($value->account_id); 
			?>
			
		</li>
 	<?php }} ?>
</ul>
<script type="text/javascript">
		document.getElementById('pageBody').classList.add("portrait");
		//document.getElementById('pageBody').classList.add("landscape");
</script>