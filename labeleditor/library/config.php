<?php
	// Report all PHP errors
	error_reporting(E_ALL);

	$mysql_ip = 'localhost';
	$mysql_user = 'demourl_pwine';
	$mysql_pass = 'm!fmw7pHb*{L';
	$mysql_db = 'demourl_pwine';

	//$mysql_user = 'daiva1l1_kpom';
	//$mysql_pass = '2f?37ziv1g7B+t@HRA';
	//$mysql_db = 'daiva1l1_kpom';

	$conn = mysql_connect ($mysql_ip, $mysql_user, $mysql_pass) or die ("I cannot connect to the database because: " . mysql_error());
	mysql_select_db ($mysql_db) or die ("I cannot select the database '$dbname' because: " . mysql_error());
	date_default_timezone_set('GMT');
?>
