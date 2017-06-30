<?php
	$title = get_field('wine_title','option');
	$tag_line = get_field('wine_subheading','option');
	
	$form_opt = get_field('wine_list_of_options','option');
	
	$memberId = get_current_user_id();
	global $current_user;
    get_currentuserinfo();
 ?>
<?php 


	echo 'Artist Profile';
?>