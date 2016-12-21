<?php
	session_start();
	
	require("library/config.php");

	$user_check=$_SESSION['email'];
	 
	$ses_sql=mysql_query("SELECT username FROM adminuser WHERE username='$user_check'");
	 
	$row=mysql_fetch_array($ses_sql);
	 
	$login_session=$row['username'];
	 
	if(!isset($login_session))
	{
		header("Location: login.php");
	}
?>