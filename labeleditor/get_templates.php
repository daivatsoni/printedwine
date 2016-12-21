<?php
	require("library/config.php");
	$limit = $_GET['limit'];
	$last_temp_id = $_GET['offset'];

	if(isset($_GET['catid']) && $_GET['catid'] != '') {
		//$query = "SELECT * FROM user_templates WHERE cat_id = ".$_GET['catid']." AND template_id > $last_temp_id ORDER BY template_id ASC LIMIT $limit";
		$query = "SELECT * FROM user_templates WHERE cat_id = ".$_GET['catid']." AND template_id > $last_temp_id ORDER BY template_id ASC LIMIT $limit";
	} else {
		$query = "SELECT * FROM user_templates";
			//	$query = "SELECT * FROM user_templates WHERE cat_id > $last_temp_id ORDER BY text_id ASC LIMIT $limit";
				$query = "SELECT * FROM user_templates";

	}
	$runQuery = mysql_query($query);
	if(mysql_num_rows($runQuery) > 0)
	{
	  	while($row = mysql_fetch_array($runQuery))
		{
?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $row['template_id']; ?>">
		  <a class="thumbnail" title="<?php /* echo $row['template_name']; */ ?>" href='javascript:loadTemplate(<?php echo $row["template_id"]; ?>);' style="margin-bottom: 0px;">
			<?php
				//read the file get content
				$templatespath = $row['canvas_json'];	
				$json = file_get_contents($templatespath);
				$json_array = json_decode($json, true);
				$json = $json_array[0];
				$json_array = json_decode($json, true);
				$width = $json_array['width'] / 96;
				$height = $json_array['height'] / 96;
				//display size
				echo "<span class='badge' style='font-size:10px; position: absolute; bottom: 10px; right: 10px; background-color:#fff; color:#777;'>$width x $height</span>";
			?>		  	
			<?php
				if(isset($_GET['refresh']) && $_GET['refresh'] == true && $row['template_id'] == $_GET['tempid']) {
			?>
			 
			<img class="tempImage img-responsive" src="<?php echo $row['canvas_thumbnail']; ?>" alt="" style="">

			<?php 
				} else {
			?>
			<img class="tempImage img-responsive" src="<?php echo $row['canvas_thumbnail']; ?>" alt="" style="">
			<?php 
				}
			?>
			<span class="thumb-overlay">
				<h3><?php echo $row['template_name']; ?></h3>
			</span>
		  </a>
		  <input type="checkbox" class="templateimg-checkbox" id="<?php echo $row['template_id']; ?>" value="<?php echo $row['template_id']; ?>" />
	   </div>
<?php
	  }
	} 
?>