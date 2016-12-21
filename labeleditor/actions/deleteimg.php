<?php

	require("../library/config.php");

	if (isset($_POST['imgid']) && $_POST['imgid'] != '')

	{	

		$delete_Query = "DELETE FROM user_labels WHERE label_id IN (".$_POST['imgid'].")";
 
		$run_Query = mysql_query($delete_Query) or die("ERROR: " . $delete_Query);

		if ($run_Query)

		{

			echo "Image(s) Deleted Successfully.";

		}

	}

?>

