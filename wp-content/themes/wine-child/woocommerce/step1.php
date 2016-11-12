<?php 
/* Template Name: Product Step1 Template */
get_header(); 

$counters = get_theme_option("blog_counters");
//$allow_editor = get_theme_option("allow_editor")=='yes';
$page_style = 'single-standard';
while ( have_posts() ) { the_post();

	// Move setPostViews to the javascript - counter will work under cache system
	if (get_theme_option('use_ajax_views_counter')=='no') {
		setPostViews(get_the_ID());
	}

	//clear_dedicated_content();

	showPostLayout(
		array(
			'layout' => $page_style,
			'thumb_size' => 'image_large',
			'thumb_crop' => false,
			'sidebar' => !in_array(get_custom_option('show_sidebar_main'), array('none', 'fullwidth'))
		)
	);

}

get_footer();
