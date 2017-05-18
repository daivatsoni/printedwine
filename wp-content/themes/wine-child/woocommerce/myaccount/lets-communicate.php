<?php
	$title = get_field('section_title','option');
	$tag_line = get_field('tag_line_','option');
	
	$form_opt = get_field('list_of_options','option');
	
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
		<form name="commnunicate" method="post" id="commnunicate">
			<?php 
				if(!empty($form_opt)){ $i = 1;
					foreach($form_opt as $opt) { ?>
						
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<h5><?php echo $opt['option_heading']; ?></h5>
									<p><?php echo $opt['option_label']; ?></p>
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
							<input type="button" name="submit" value="save" id="lets_communicate">
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
		//Get Option Field Values
		$chat_title = get_field('section_chat_title','option'); 
		$chat_subtitle = get_field('chat_subheading','option');
		
		//Mailchimp List Id for chat list
		$chimp_chat_list_id = get_field('chat_list_id','option');
	?>
		
	<div class="col-lg-9">
		<?php if(!empty($chat_title) && $chat_title != '') : ?>
			<h4><?php echo $chat_title; ?></h4>
		<?php endif; ?>
	</div>
	
	<div class="col-lg-9" id="letcchat">
		<form name="letschat" method="post" id="letschat">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-6">
						<?php if(!empty($chat_subtitle)): ?>
							<?php echo $chat_subtitle; ?>
						<?php endif; ?>
					</div>
					
					<form name="chat" method="post">
						<div class="form-group">
							<h5>Primary Phone/Mobile number</h5>
							<input type="text" placeholder="Ïnclude Area Code" name="primary_phone" 
							class="form-control primary_phone">		
						</div>
						
						<div class="form-group">
							<h5>Out of hours number(Optional)</h5>
							<input type="text" placeholder="" name="contact_hours" class="form-control contact_hours">		
						</div>
						
						<div class="form-control">
							<h5>Contact time(optional)</h5>
							<p>When would you like us to contact you?</p>
							
							<input type="text" name="contact_day" placeholder="Day" class="contact_day">
							<input type="text" name="contact_time" placeholder="Time" class="contact_time">
						</div>
						
						<input type="hidden" name="chat_list_id" value="<?php echo $chimp_chat_list_id; ?>" class="chat_list_id">
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