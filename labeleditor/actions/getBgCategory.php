<?php
	include ("../library/config.php");
	$res = mysql_query("SELECT * FROM bg_categories");

	if (mysql_num_rows($res))
	{
		echo "<option value=''>Select Category</option>";
		while ($category = mysql_fetch_assoc($res))
		{
			echo "<option value=" . $category["bgcat_id"] . ">" . $category["bgcat_name"] . "</option>";
		}
	}
	else
	{
		echo "<div style='padding:8px;'>No categories</div>";
	} 

?>