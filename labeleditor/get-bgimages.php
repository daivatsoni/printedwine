<?php
	require("library/config.php");
	$limit = $_GET['limit'];
	$last_bg_id = $_GET['offset'];
	
	if(isset($_GET['category']) && $_GET['category'] != '') {
		$query = "SELECT * FROM background WHERE bgcat_id = ".$_GET['category']." AND id > $last_bg_id ORDER BY id ASC LIMIT $limit";
	} else {
		$query = "SELECT * FROM background WHERE id > $last_bg_id ORDER BY id ASC LIMIT $limit";
	}

	$runQuery = mysql_query($query);
	
	if(mysql_num_rows($runQuery) > 0){
	 while($row = mysql_fetch_array($runQuery)){ ?>
	   <div class="col-lg-6 col-md-8 col-xs-12 thumb" id="<?php  echo $row['id']; ?>" style="padding:5px;">
		  <a class="thumbnail" href="#" style="margin-bottom: 0;">
  		  <?php if (file_exists('http://demomyurl.com/printedwine/labeleditor/'.$row['bg_path'])) { ?>
			<img class="bgImage img-responsive" data-imgsrc="<?php  echo $row['bg_path']; ?>" src="<?php  echo $row['bg_path']; ?>" alt="" style="height:125px; width:200px; ">
     	  <?php } else { ?>
			<img class="bgImage img-responsive" data-imgsrc="admin/<?php  echo $row['bg_path']; ?>" src="admin/<?php  echo $row['bg_path']; ?>" alt="" style="height:125px; width:200px; ">
		  <?php } ?>
			<!--<img class="bgImage img-responsive" data-imgsrc="<?php  //echo $row['bg_path']; ?>" src="<?php  //echo $row['bg_path']; ?>" alt="" style="height:125px; width:200px; ">-->
		  </a><input type="checkbox" class="bgimg-checkbox" id="<?php  echo $row['id']; ?>" value="<?php  echo $row['id']; ?>" />
	   </div>
<?php
 }} ?>