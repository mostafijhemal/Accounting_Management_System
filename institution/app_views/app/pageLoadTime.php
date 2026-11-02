<?php 
	echo '<strong>Page generated in ';
	$starttime = explode(' ', microtime());
	$starttime = $starttime[1] + $starttime[0];
	$load = microtime();
	//number_format($load, 2);
	echo '<small class="green"><u>'.number_format(floatval($load), 2, ".", "").'</u></small> seconds.</strong> ';

	//$loadtime = explode(' ', microtime()); 
	//$loadtime = $loadtime[0]+$loadtime[1]-$starttime; 
	//echo 'Peak memory usage: '.round(memory_get_peak_usage()/1048576, 2).' MB';
?>
<!-- <strong> Page Rendered in (<small class="green"><u>{elapsed_time}</u></small>) Seconds.</strong> -->