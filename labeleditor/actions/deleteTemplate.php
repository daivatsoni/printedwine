<?php

	require("../library/config.php");



	if (isset($_POST['templateid']) && $_POST['templateid'] != '')

	{	

		$delete_Query = "DELETE FROM user_templates WHERE template_id = ".$_POST['templateid']."";

		$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);

		if ($run_Query)

		{

			echo "Template Deleted.";

		}

	}



?>

