<?php
	include ("../library/config.php");
	
	$selected_cat = $_POST["categoty"];
	$sel_Query = mysql_query("SELECT element_path FROM element WHERE cat_id = $selected_cat");
	
	if (mysql_num_rows($sel_Query) > 0)
	{
		while ($result = mysql_fetch_array($sel_Query))
		{
			$m_img_path = "../" . $result['element_path'];
			unlink($m_img_path);
		}
	}
	
	$delete_Ele = "DELETE FROM element WHERE cat_id = $selected_cat";
	$run_EleQuery = mysql_query($delete_Ele) or die("ERROR: " . $delete_Ele);

	$delete_Query = "DELETE FROM element_categories WHERE category_id = $selected_cat";
	$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);
	if ($run_Query)
	{
		echo "Category Deleted Successfully.";
	}		
?>