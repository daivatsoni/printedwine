<?php
	require("../library/config.php");

	if (isset($_POST['bgid']) && $_POST['bgid'] != '')
	{
		$sel_Query = mysql_query("SELECT bg_path FROM background WHERE id IN (".$_POST['bgid'].")");
		if (mysql_num_rows($sel_Query) > 0)
		{
			while ($result = mysql_fetch_array($sel_Query))
			{
				$m_img_path = "../".$result['bg_path'];
				unlink($m_img_path);
			}
		}
	
		$delete_Query = "DELETE FROM background WHERE id IN (".$_POST['bgid'].")";
		$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);
		if ($run_Query)
		{
			echo "Background(s) Deleted Successfully.";
		}
	}

?>
