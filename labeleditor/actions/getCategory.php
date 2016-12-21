<?php
	include ("../library/config.php");
	$res = mysql_query("SELECT * FROM element_categories");

	if (mysql_num_rows($res))
	{
		echo "<option value=''>Select Category</option>";
		while ($category = mysql_fetch_assoc($res))
		{
			echo "<option value=" . $category["category_id"] . ">" . $category["category"] . "</option>";
		}
	}
	else
	{
		echo "<div style='padding:8px;'>No categories</div>";
	} 

?>