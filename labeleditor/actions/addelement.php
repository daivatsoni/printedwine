<?php
	include("../library/config.php");
		$reselementName = $_POST["elementName"];
		$reselement = $_POST["element"];
		$elementCategoty = $_POST["elementCategoty"];
		$elename = str_replace("C:\\fakepath\\", "", $reselement);
		
		$insert_Query = "INSERT INTO element(id,cat_id,element_name,element_path,element_json) values ('','$elementCategoty','$reselementName','$elename','')";
		$run_Query = mysql_query($insert_Query) or die("ERROR: " . $insert_Query);
		if($run_Query)
		{
			echo "New Element Added Successfully.";
		}
		
?>