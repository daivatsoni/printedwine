<?php
	require('../library/config.php');
	if (isset($_POST['id']) && $_POST['id'] != '')
	{	
		$delete_Query = "DELETE FROM user_templates WHERE template_id = ".$_POST['id']."";
		$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);

		if ($run_Query)
		{
			echo "Flyer deleted Successfully.";
		}
	}
?>

