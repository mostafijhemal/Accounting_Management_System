<!-- view Page Access function   -->

<?php if(!empty($success)){ ?>
    <div id="sectionAlertInPhp" style="position: fixed; right: 20px; top: 50px; background: #438eb9; color: #fff;max-width: 83%;text-align: justify; z-index: 1000;" class="alert alert-success alert-dismissible" role="alert" >
    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
	    <strong id=""><?php echo $success = 'Success!'; ?> </strong>&nbsp;&nbsp; <span id=""><?php echo $messege; ?></span>
	   <?php if(!empty($partial)){ ?>
	    <br>
	     <strong class="red"><?php echo $partial; ?> </strong>&nbsp;&nbsp; <span class="red" id=""><?php echo $rowno.' Row fail to update'; ?></span>
	   <?php } ?>
	</div>
<?php } ?>


<?php if(!empty($error)){ ?>
    <div id="sectionAlertInPhp" style="position: fixed; right: 20px; top: 50px; background: #e60000; color: #fff;max-width: 83%;text-align: justify; z-index: 1000;" class="alert alert-success alert-dismissible" role="alert" >
	    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
	    <strong id=""><?php echo $error = 'Error!'; ?> </strong>&nbsp;&nbsp; <span id=""><?php echo $messege; ?></span>
	</div>
<?php } ?>



<!-- js Alert Data -->
<div id="alertAllSection" style="display: none;position: fixed; right: 20px; top: 50px; background: #438eb9; color: #fff;max-width: 83%;text-align: justify; z-index: 1000;" class="alert alert-success alert-dismissible" role="alert">
    <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
    <strong id="allAlertType"> </strong>&nbsp;&nbsp; <span id="allAlertMessage"></span>
</div>

<!-- Pre-loader -->
<div id="loading" style="display: none; position: fixed;top: 0; width: 100%; z-index: 1000000; background: rgba(0,0,0,0.5);height: 100%;">
	<div class="text-center" style="font-size: 60px;height: 70%; margin-top: 20%; color : #fff;" >
		<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>
	</div>
</div>



<script type="text/javascript">
	$(document).ready(function(){
		/* Php Session Alert Hide */
		setTimeout(function () { $('#sectionAlertInPhp').fadeOut(); }, 5000);

	});

	$('.date-picker').datepicker({
		autoclose: true,
		todayHighlight: true,
		format: 'yyyy-mm-dd',
	});

	$(document).on("click", ".addNewBtn", function(e) {
		$('input').val('');
		//$('select').val('');
	});

	/* Delete in Js */
	$(document).on("click", ".deleteData", function(e) {
		var x = confirm('Are you sure to delete?');
		if(x) {
			var formURL = $(this).attr('href');
			$.ajax({
				url : formURL,
				type: "POST",
				data : {},
				success:function(data){
					location.reload();
				}
			  });
		 } else {
		 	return false;
		 } 
		 e.preventDefault();
 	});

 	/* Table Action row hide or show */
	$(document).on('click', '#dataTr', function(){
		var parentsTbody 	= $(this).parents('tbody');
		var className 		= $(this).next().attr('class');
		var showTr 			= parentsTbody.find('tr.showTr');
		var actionTr 		= $(this).next();

		if(className == 'showTr'){
			showTr.removeClass('showTr').addClass('hide');
		} else if(className == 'hide') {
			actionTr.removeClass('hide').addClass('showTr');
			showTr.removeClass('showTr').addClass('hide');
		}
	});

	/* Alert Function in js */
	function alertMessageFunction(alType, alMessage){
		$('#allAlertType').text('');
		$('#allAlertMessage').text('');
		$('#alertAllSection').fadeIn();
		$('#allAlertType').text(alType);
		$('#allAlertMessage').text(alMessage);
		setTimeout(function () { $('#alertAllSection').fadeOut(); }, 5000);
	}

	/* Start Pre-loader */
	function startLoading() {
		$('#loading').css('display', 'block');
	}
	/* Stop Pre-loader */
	function stopLoading() {
		$('#loading').css('display', 'none');
	}
	/* Botton Disabled by onfocus in a fild  */
	$(document).on('focus', '.focusField', function(){
		var disabledBtn = $(this).parents('form').find('.disabledBtn');
		disabledBtn.attr('disabled', true);
	});
	/* Botton Disabled false by onfocus in a fild  */
	$(document).on('blur', '.focusField', function(){
		var disabledBtn = $(this).parents('form').find('.disabledBtn');
		disabledBtn.attr('disabled', false);
	});

	$(document).keypress(function(e) { 
	    //if (e.which == 13) $('.save').click();   // enter (works as expected)
	    if (e.which == 27) $('.cancel').click(); // esc   (does not work)
	});
</script>