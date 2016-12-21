<?php
	require("../library/config.php");

	if (isset($_POST['elementid']) && $_POST['elementid'] != '')
	{
		$sel_Query = mysql_query("SELECT element_path FROM element WHERE id IN (".$_POST['elementid'].")");
		if (mysql_num_rows($sel_Query) > 0)
		{
			while ($result = mysql_fetch_array($sel_Query))
			{
				$m_img_path = "../".$result['element_path'];
				unlink($m_img_path);
			}
		}
	
		$delete_Query = "DELETE FROM element WHERE id IN (".$_POST['elementid'].")";
		$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);
		if ($run_Query)
		{
			echo "Element(s) Deleted Successfully.";
		}
	}

?>
