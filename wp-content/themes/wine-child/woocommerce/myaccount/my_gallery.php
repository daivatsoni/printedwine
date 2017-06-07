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
		<h1>My Gallery</h1>
	</div>
	
	<div class="col-lg-9">
	
		<a href="#" id="createAlubm">Create Alubm</a>
		
		<p id="resultMsg"></p>
		   
	</div>	
</div>