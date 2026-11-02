<script type="text/javascript">
	var js_min_link = '<?php echo base_url(); ?>data';
	window.jQuery || document.write("<script src='"+js_min_link+"/js/jquery-3.2.1.min.js'>"+"<"+"/script>");
</script>


<script>
$('.window_print_button').on('click', function() {
	$(this).hide();
	window.print();
	$(this).show();
});

</script>