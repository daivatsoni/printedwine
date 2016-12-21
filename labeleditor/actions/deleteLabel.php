<?php
	include ("../library/config.php");
	
	$selected_label = $_POST["labelid"];
	$sel_Query = mysql_query("SELECT label_path FROM user_templates WHERE template_id = $selected_label");
	
	/*if (mysql_num_rows($sel_Query) > 0)
	{
		while ($result = mysql_fetch_array($sel_Query))
		{
			$m_img_path = "../" . $result['label_path'];
			unlink($m_img_path);
		}
	}*/
	
	$delete_Ele = "DELETE FROM user_templates WHERE template_id = $selected_label";
	$run_EleQuery = mysql_query($delete_Ele) or die("ERROR: " . $delete_Ele);
	if ($run_EleQuery)
	{
		echo "Label Deleted Successfully.";
	}		
?>
