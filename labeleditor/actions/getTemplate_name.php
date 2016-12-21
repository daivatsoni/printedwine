<?php
	include ("../library/config.php");
	$res = mysql_query("SELECT template_id, template_name FROM template");

	if (mysql_num_rows($res))
	{
		echo "<option value=''>Select Template</option>";
		while ($category = mysql_fetch_assoc($res))
		{
			echo "<option value=" . $category["template_id"] . ">" . $category["template_name"] . "</option>";
		}
	}
	else
	{
		echo "<div style='padding:8px;'>No Template</div>";
	} 

?>