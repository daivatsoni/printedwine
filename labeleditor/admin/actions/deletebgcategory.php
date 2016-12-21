<?php
	include ("../library/config.php");
	
	$selected_bgcat = $_POST["bgcategoty"];
	$sel_Query = mysql_query("SELECT bg_path FROM background WHERE bgcat_id = $selected_bgcat");
	
	if (mysql_num_rows($sel_Query) > 0)
	{
		while ($result = mysql_fetch_array($sel_Query))
		{
			$m_img_path = "../" . $result['bg_path'];
			unlink($m_img_path);
		}
	}
	
	$delete_Ele = "DELETE FROM background WHERE bgcat_id = $selected_bgcat";
	$run_EleQuery = mysql_query($delete_Ele) or die("ERROR: " . $delete_Ele);

	$delete_Query = "DELETE FROM bg_categories WHERE bgcat_id = $selected_bgcat";
	$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);
	if ($run_Query)
	{
		echo "Category Deleted Successfully.";
	}		
?>