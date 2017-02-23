<?php
if($_SERVER['HTTP_HOST']=="localhost") {
	// Report all PHP errors
	error_reporting(E_ALL ^ E_DEPRECATED);

	$mysql_ip = 'localhost';
	$mysql_user = 'root';
	$mysql_pass = '';
	$mysql_db = 'daiva1l1_kpom';
} else if($_SERVER['SERVER_ADDR']=="103.21.59.174") {
	error_reporting(E_ALL ^ E_DEPRECATED);

	$mysql_ip = 'localhost';
	$mysql_user = 'daiva1l1_pwine';
	$mysql_pass = 'yF^-p-Dt$Tz8';
	$mysql_db = 'daiva1l1_pwine';
}
	/*$mysql_user = 'daiva1l1_kpom';
	$mysql_pass = '2f?37ziv1g7B+t@HRA';
	$mysql_db = 'daiva1l1_kpom';*/

	$conn = mysql_connect ($mysql_ip, $mysql_user, $mysql_pass) or die ("I cannot connect to the database because: " . mysql_error());
	mysql_select_db ($mysql_db) or die ("I cannot select the database '$dbname' because: " . mysql_error());
	date_default_timezone_set('GMT');
?>
