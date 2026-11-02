
<style>
.borderBottom {
	border-bottom:1px solid #000000;
}
</style>	
<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/bootstrap.min.css" />	
<link rel="stylesheet" href="<?php echo base_url(); ?>data/font-awesome/4.7.0/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>data/css/style.css" />

<?php 
   $basicInfo = $this->M_crud->findById('company_register_table', array('id' => 1));
?>

<div class="text-center col-md-12">
	<table width="100%" border="0">
	  <tr>
		<td width="20%"></td>
		<td width="60%" align="center" valign="top"><div class="text-center" style="">
		<h4 class="marginZero" style="padding-top:10px"><?php echo $basicInfo->full_name ?></h4>
		<address class="marginZero"><?php echo $basicInfo->head_office ?>
		</address>
		<address style="margin-bottom: 5px !important"><strong>Tel :</strong> <?php echo $basicInfo->phone_no ?></address>
	</div></td>
		<td width="20%">&nbsp;</td>
	  </tr>
	</table>

	
		
	
	

</div>

