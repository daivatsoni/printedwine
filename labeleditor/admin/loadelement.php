<?php 
	include("./library/config.php");

	$selQry = "SELECT `element_json` FROM element WHERE id = " . $_GET['id'];
	
	$run_selQry	= mysql_query($selQry) or die(mysql_error());	

	if(mysql_num_rows($run_selQry) > 0)	{
		while($row = mysql_fetch_assoc($run_selQry)) {
			echo $row['element_json'];
			break;
		}
	}
?>