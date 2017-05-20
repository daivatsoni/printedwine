<?php
	$title = get_field('wine_title','option');
	$tag_line = get_field('wine_subheading','option');
	
	$form_opt = get_field('wine_list_of_options','option');
	
	$memberId = get_current_user_id();
	global $current_user;
      get_currentuserinfo();
 ?>

<div class="row">
	<div class="col-lg-9">
	<?php if(!empty($title) && $title != '') : ?>
		<h1><?php echo $title; ?></h1>
	<?php endif; ?>
	</div>
	
	<div class="col-lg-9">
		<?php if(!empty($tag_line) && $tag_line != '') : ?>
			<?php echo $tag_line; ?>
		<?php endif; ?>
	</div>
	
	<div class="col-lg-9" id="resultMsg">
		<form name="wineandart" method="post" id="wineandart">
			<?php 
				if(!empty($form_opt)){ $i = 1;
					foreach($form_opt as $opt) { ?>
						
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<h5><?php echo $opt['wine_option_heading']; ?></h5>
									<p><?php echo $opt['wine_option_label']; ?></p>
								</div>
								<div class="col-lg-2">
									<input type="checkbox" class="chimpoptions" name="chimpoptions[]" value="<?php echo $opt['list_id']; ?>" class="form-control">
									<input type="hidden" name="user_id" value="<?php echo $memberId; ?>" class="user_id">
									<input type="hidden" name="listIndex[]" value="<?php echo $opt['list_id']; ?>" class="listIndex">
									<input type="hidden" name="user_email" value="<?php echo $current_user->user_email; ?>" class="user_email">
									<input type="hidden" name="user_firstname" value="<?php echo  $current_user->user_firstname; ?>" class="user_firstname">
									<input type="hidden" name="user_lastname" value="<?php echo  $current_user->user_lastname; ?>" class="user_lastname">
								</div>
							</div>
						</div>
		
					<?php  $i++; } ?>
					
					<div class="form-group">
						<div class="row">
							<input type="button" name="submit" value="save" id="wineandartAct">
						</div>
					</div>
					
				<?php 	
					
				}
			?>
			
		</form>
		
	</div>
	
	<!-- 
		Let's chat Options
	-->
	
	<?php 
	
		$art_title = get_field('art_preferance_title','option');
		$art_tag_line = get_field('art_preferance_subheading','option');
		
		$art_form_opt = get_field('art_list_of_options','option');
	?>
	
	<div class="col-lg-9">
		<h4><?php if(!empty($art_title)) : ?><?php echo $art_title; ?><?php endif; ?></h4>
	</div>
	
	<div class="col-lg-9" id="letcchat">
		<form name="letschat" method="post" id="letschat">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-6">
						<?php if(!empty($art_tag_line)) : ?><?php echo $art_tag_line; ?><?php endif; ?>
					</div>
					
					<form name="chat" method="post">
						<div class="form-group">
							<h5>Please select your Art preferances so we can tailor your inbox</h5>
							<p>You can select multiple categories</p>
							<select name="art_category" class="form-control">
								<option value="default">By Category</option>
							</select>
							<select name="art_subject" class="form-control">
								<option value="default">By Subject</option>
							</select>
							<select name="art_medium" class="form-control">
								<option value="default">By Medium</option>
							</select>
						</div>
						
						<?php if($art_form_opt) : ?>
							<?php foreach($art_form_opt as $art_opt) { ?>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-6">
										<h5><?php echo $art_opt['art_option_heading']; ?></h5>
										<p><?php echo $art_opt['art_option_label']; ?></p>
									</div>
									<div class="col-lg-2">
										<input type="checkbox" class="art_wine" name="art_wine[]" value="<?php echo $art_opt['art_list_id']; ?>" class="form-control">
									</div>
							
							</div>
							<?php } ?>
						<?php endif; ?>
												
						<input type="hidden" name="user_id" value="<?php echo $memberId; ?>" class="user_id">
						<input type="hidden" name="user_email" value="<?php echo $current_user->user_email; ?>" class="user_email">
						<input type="hidden" name="user_firstname" value="<?php echo  $current_user->user_firstname; ?>" class="user_firstname">
						
						<div class="form-control">
							<input type="submit" name="submit" value="SAVE" id="lets_chat">
						</div>
					</form>
					
				</div>
			</div>						
		</form>
	</div>
	
</div>