<?php
include("library/config.php"); //include config file

$results = mysql_query("SELECT * FROM user_labels");

//output results from database

	  while($row = mysql_fetch_array($results))
		{	

		echo "<div class='thumb' style='padding:5px;'>";
		echo "<a class='thumbnail' href='#' style='margin-bottom: 0;'>";
		echo "<img class='addImage img-responsive' data-imgsrc='".$row['label_path']."'. src='".$row['label_path']."' alt='' width='80px'>";
		echo "</a>";
		echo "<i class='fa fa-trash-o deleteUploadImg' id='".$row['label_id']."'></i>";
		echo "</div>";

		}


?>
