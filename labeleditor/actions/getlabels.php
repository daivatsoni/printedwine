<?php
   	header("Pragma-directive: no-cache");
    header("Cache-directive: no-cache");
    header("Cache-control: no-cache");
    header("Pragma: no-cache");
    header("Expires: 0");
	include ("../library/config.php");
?>
	<style type="text/css">
      .label-upload > input {
            display: none;
      }
	</style>
<?php
	$result=mysql_query("SELECT count(*) as total from user_templates");
	$data=mysql_fetch_assoc($result);
	if($data['total']==12 || 12 < $data['total']) {
		$query = "SELECT * FROM user_templates";
		$runQuery = mysql_query($query);
		if(mysql_num_rows($runQuery) > 0){
		?>
			<div id='label_gallery' class="gallery clearfix">
			<?php
			$counter = 1;
			while($row = mysql_fetch_array($runQuery))
			{
			?>
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<span><?php echo $counter; ?></span>

					<?php if($row['canvas_thumbnail'] && $row['label_path'] !='') {?>

 					<img class="labelimg" src="<?php echo $row['canvas_thumbnail'].'?dummy='.rand(); ?>" data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> alt=""  width="127px" height=""/>
					<p>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Edit" class="labelImage" data-labelsrc=<?php echo $row['canvas_thumbnail']; ?> data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> >Edit</a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Copy" id="<?php echo $row['template_id']; ?>" class="copyimage"> Copy </a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Delete" class='deleteLabel' data-labelid=<?php echo $row['template_id']; ?>>Delete</a>
					</p>

					<?php } else if($row['label_path'] !='') {?>

 					<img class="labelimg" src="<?php echo $row['label_path'].'?rand='.dummy(); ?>" data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?>  alt=""  width="127px" height=""/>
					<p>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Edit" class="labelImage" data-labelsrc=<?php echo $row['label_path']; ?> data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> >Edit</a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Copy" id="<?php echo $row['template_id']; ?>" class="copyimage"> Copy </a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Delete" class='deleteLabel' data-labelid=<?php echo $row['template_id']; ?>>Delete</a>
					</p>

					<?php } else if(isset($row['canvas_thumbnail'])) { ?>

 					<img class="labelimg" src="<?php echo $row['canvas_thumbnail'].'?dummy='.rand(); ?>" data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?>  alt=""  width="127px" height=""/>
					<p>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Edit" class="labelImage" data-labelsrc=<?php echo $row['canvas_thumbnail']; ?> data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> >Edit</a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Copy" id="<?php echo $row['template_id']; ?>" class="copyimage"> Copy </a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Delete" class='deleteLabel' data-labelid=<?php echo $row['template_id']; ?>>Delete</a>
					</p>

					<?php } else { ?>

 					<img class="labelimg" src="<?php echo $row['canvas_thumbnail'].'?dummy='.rand(); ?>" data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?>  alt=""  width="127px" height=""/>
					<p>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Edit" class="labelImage" data-labelsrc=<?php echo $row['canvas_thumbnail']; ?> data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> >Edit</a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Copy" id="<?php echo $row['template_id']; ?>" class="copyimage"> Copy </a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Delete" class='deleteLabel' data-labelid=<?php echo $row['template_id']; ?>>Delete</a>
					</p>

				<?php } ?>
				</div>
				<?php
			$counter++;
			}
		}

	} else {
		$query = "SELECT * FROM user_templates";
		$runQuery = mysql_query($query);
		if(mysql_num_rows($runQuery) > 0)
		{
		?>
			<div id='label_gallery' class="gallery clearfix">
			<?php
			$counter = 1;
			while($row = mysql_fetch_array($runQuery))
			{
			?>
				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
					<span><?php echo $counter; ?></span>

					<?php if($row['canvas_thumbnail'] && $row['label_path'] !='') {?>

 					<img class="labelimg" src="<?php echo $row['canvas_thumbnail'].'?dummy='.rand(); ?>" data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> alt=""  width="127px" height="">
					<p>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Edit" class="labelImage" data-labelsrc=<?php echo $row['canvas_thumbnail']; ?> data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> >Edit</a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Copy" id="<?php echo $row['template_id']; ?>" class="copyimage"> Copy </a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Delete" class='deleteLabel' data-labelid=<?php echo $row['template_id']; ?>>Delete</a>
					</p>

					<?php } else if($row['label_path'] !='') {?>

 					<img class="labelimg" src="<?php echo $row['label_path'].'?dummy='.rand(); ?>" data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?>  alt=""  width="127px" height="">
					<p>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Edit" class="labelImage" data-labelsrc=<?php echo $row['label_path']; ?> data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> >Edit</a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Copy" id="<?php echo $row['template_id']; ?>" class="copyimage"> Copy </a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Delete" class='deleteLabel' data-labelid=<?php echo $row['template_id']; ?>>Delete</a>
					</p>

					<?php } else if(isset($row['canvas_thumbnail'])) { ?>

 					<img class="labelimg" src="<?php echo $row['canvas_thumbnail'].'?dummy='.rand(); ?>" data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?>  alt=""  width="127px" height="">
					<p>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Edit" class="labelImage" data-labelsrc=<?php echo $row['canvas_thumbnail']; ?> data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> >Edit</a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Copy" id="<?php echo $row['template_id']; ?>" class="copyimage"> Copy </a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Delete" class='deleteLabel' data-labelid=<?php echo $row['template_id']; ?>>Delete</a>
					</p>

					<?php } else { ?>

 					<img class="labelimg" src="<?php echo $row['canvas_thumbnail'].'?dummy='.rand(); ?>" data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?>  alt=""  width="127px" height="">
					<p>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Edit" class="labelImage" data-labelsrc=<?php echo $row['canvas_thumbnail']; ?> data-labelid=<?php echo $row['template_id']; ?> data-countid=<?php echo $counter; ?> >Edit</a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Copy" id="<?php echo $row['template_id']; ?>" class="copyimage"> Copy </a>
						<a href="#" data-toggle="tooltip" data-placement="left" title="Delete" class='deleteLabel' data-labelid=<?php echo $row['template_id']; ?>>Delete</a>
					</p>

				<?php } ?>
				</div>
			<?php
			$counter++;
			}
			?>
			<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
				<span></span>
				<img src="uploads/user_1/product_1/img11.jpg" alt="" class="img-responsive">
				<p>
					<!--<form id="upload" class="label-upload" action="uploadlabel.php" method="POST" enctype="multipart/form-data" style="margin-bottom: 0px;">
					   <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="1000000" />
					   <label data-toggle="tooltip" data-placement="left" title="Add Image" for="labelselect" style="cursor: pointer; font-weight:normal;">Add Image</label>
					   <input id="labelselect" type="file" name="labelselect[]" />
					</form>-->
					<a href="#" data-toggle="tooltip" data-placement="left" title="Add Image from Social Media or Drive" id="AddImage1" >Add Image</a>
					<a href="#" data-toggle="tooltip" data-placement="left" title="Artist Library" >Artist Library</a>
				</p>
			</div>
		<?php
		}

	}
?>
<script src="js/labeldrag.js" type="text/javascript"></script>
		<script type="text/javascript">

			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();
			});
		</script>
