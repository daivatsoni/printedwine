<?php
if($_SERVER['HTTP_HOST']=="localhost") {
	// Report all PHP errors
	error_reporting(E_ALL ^ E_DEPRECATED);

	$mysql_ip = 'localhost';
	$mysql_user = 'root';
	$mysql_pass = '';
	$mysql_db = 'daiva1l1_kpom';
} else if($_SERVER['HTTP_HOST']=="demomyurl.com") {
	error_reporting(E_ALL ^ E_DEPRECATED);

	$mysql_ip = 'localhost';
	$mysql_user = 'demourl_pwine';
	$mysql_pass = 'm!fmw7pHb*{L';
	$mysql_db = 'demourl_pwine';
}
	
	/*$mysql_user = 'daiva1l1_kpom';
	$mysql_pass = '2f?37ziv1g7B+t@HRA';
	$mysql_db = 'daiva1l1_kpom';*/

	// Report simple running errors
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	//$mysql_user = 'root';
	//$mysql_pass = '';
	//$mysql_db = 'labeleditor';
	//$item_per_page = 20;

	$conn = mysql_connect ($mysql_ip, $mysql_user, $mysql_pass) or die ("I cannot connect to the database because: " . mysql_error());
	mysql_select_db ($mysql_db) or die ("I cannot select the database '$dbname' because: " . mysql_error());
	date_default_timezone_set('GMT');
?>
