<?php
	require("library/config.php");

		$limit = $_GET['limit'];
		$last_ele_id = $_GET['offset'];

	if(isset($_GET['category']) && $_GET['category'] != '') {
		$query = "SELECT * FROM element WHERE cat_id = ".$_GET['category']." AND id > $last_ele_id ORDER BY id ASC LIMIT $limit";
	} else {
		$query = "SELECT * FROM element WHERE id > $last_ele_id ORDER BY id ASC LIMIT $limit";
	}
	$runQuery = mysql_query($query);
	if(mysql_num_rows($runQuery) > 0)
	{
	  while($row = mysql_fetch_array($runQuery))
		{
?>
<?php if($row['element_json'] != '') { ?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $row['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="javascript:loadElement(<?php echo $row["id"]; ?>);" style="margin-bottom: 0;">
			<img class="img-responsive" data-imgsrc="<?php echo $row['element_path']; ?>" src="<?php echo $row['element_path']; ?>" alt="" style="height:125px; width:200px; ">
		  </a><input type="checkbox" class="catimg-checkbox" id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" />
	   </div>

<?php } else { ?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php echo $row['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="#" style="margin-bottom: 0;">
			<img class="catImage img-responsive" data-imgsrc="<?php echo $row['element_path']; ?>" src="<?php echo $row['element_path']; ?>" alt="" style="height:125px; width:200px; ">
		  </a><input type="checkbox" class="catimg-checkbox" id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" />
	   </div>
<?php } ?>

<?php
	  }
	} 
?>
