<?php

// Prepare arrays 
if (is_themerex_options_used()) {
	$fonts 				= getThemeFontsList();
	$themes 			= getThemesList();
	$socials 			= getSocialsList();
	$icons 				= getIconsList();
	$categories 		= getCategoriesList();
	$sidebars 			= getSidebarsList();
	$positions_sidebar	= getSidebarsPositions();
	$body_styles		= getBodyStylesList();
	$blog_styles		= getBlogStylesList();
	$sliders 			= getSlidersList();
	$post_info_set		= getInfoSet();
	$gmap_styles 		= getGooglemapStyles();
	$dir 				= getDirectionList();
	$yes_no 			= getYesNoList();
	$on_off 			= getOnOffList();
	$show_hide 			= getShowHideList();
	$sorting 			= getSortingList();
	$ordering 			= getOrderingList();
	$locations 			= getDedicatedLocationsList();
	$font_style 		= getFontsStyleList();

} else {
	$fonts = $themes = $socials = $icons = $categories = $sidebars = $positions = $positions_sidebar = $body_styles = $blog_styles = $sliders = $post_info_set = $gmap_styles = $dir = $yes_no = $on_off = $show_hide = $sorting = $ordering = $locations = $font_style = array();
}
// Theme options arrays
$THEMEREX_options = array();



//###############################
//#### Customization         #### 
//###############################
$THEMEREX_options[] = array( "title" => __('Customization', 'themerex'),
			"id" => "partition_customization",
			"start" => "partitions",
			"override" => "category,post,page",
			"icon" => "iconadmin-cog-alt",
			"divider" => false,
			"type" => "partition");

$THEMEREX_options[] = array( "title" => __('Theme customization parameters', 'themerex'),
			"desc" => __('Select main theme font, menu parameters, site background, etc.', 'themerex'),
			"type" => "info");

/*tab start sidebar top*/
/*tab*/$THEMEREX_options[] = array( "title" => __('General', 'themerex'),
			"id" => 'tab_customization_general',
			"start" => 'customization_general',
			"override" => "category,post,page",
			"icon" => "iconadmin-cog",
			"divider" => false,
			"type" => "tab");


$THEMEREX_options[] = array( "title" => __('Theme color', 'themerex'),
			"id" => "theme_color",
			"desc" => __('Theme accent color', 'themerex'),
			"override" => "category,post,page",
			"std" => "#b4bb6b",
			"type" => "color");

$THEMEREX_options[] = array( "title" => __('Accent color', 'themerex'),
			"id" => "theme_accent_color",
			"desc" => __('Used to set the color for the block of info category', 'themerex'),
			"override" => "category",
			"std" => "#f26248",
			"type" => "color");


/*tab*/$THEMEREX_options[] = array( "title" => __('User', 'themerex'),
			"id" => "tab_customization_user",
			"icon" => "iconadmin-user",
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Show user menu', 'themerex'),
			"desc" => __('Show user menu on top of page', 'themerex'),
			"id" => "show_user_menu",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Show currency selector', 'themerex'),
			"desc" => __('Show currency selector in the user menu', 'themerex'),
			"id" => "show_currency",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

if ( function_exists('icl_get_languages')) {
	//WPML
$THEMEREX_options[] = array( "title" => __('Show language selector', 'themerex'),
			"desc" => __('Show language selector in user menu, plugin <a href="http://wpml.org/">WPML</a>', 'themerex'),
			"id" => "show_languages",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");
}

if( function_exists('is_woocommerce') ){
	//woocommerce
$THEMEREX_options[] = array( "title" => __('Show cart button', 'themerex'),
			"desc" => __('Show cart button in the user menu', 'themerex'),
			"id" => "show_cart",
			"override" => "category,post,page",
			"std" => "shop",
			"options" => array(
				'always' => __('Always', 'themerex'),
				'shop' => __('Only on shop pages', 'themerex'),
				'no' =>  __('Hide', 'themerex'),
			),
			"type" => "checklist");
}

$THEMEREX_options[] = array( "title" => __('Show Login/Logout buttons', 'themerex'),
			"desc" => __('Show Login and Logout buttons', 'themerex'),
			"id" => "show_login",
			"divider" => false,
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

/*tab Logo parameters*/
/*tab*/$THEMEREX_options[] = array( "title" => __('Logo', 'themerex'),
			"id" => 'tab_customization_logo',
			"icon" => "iconadmin-rocket",
			"override" => "category",
			"divider" => false,
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __("Logo type", 'themerex'),
			"desk" => "Logo display type used",
			"id" => "logo_type",
			"override" => "category",
			"std" => "logoImage",
			"options" => array(
				'logoImage' => __('Image logo', 'themerex'),
				'logoText' => __('Text logo', 'themerex'),
			),
			"type" => "radio");


$THEMEREX_options[] = array( "title" => __('Background for the logo', 'themerex'),
			"desc" => __('Use background under the logo', 'themerex'),
			"id" => "logo_background",
			"override" => "category",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Width of the logo block', 'themerex'),
			"desc" => __("Sets width of the logo block", 'themerex'),
			"id" => "logo_block_width",
			"override" => "category",
			"std" => 300,
			"min" => 50,
			"max" => 400,
			"increment" => 1,
			"divider" => false,
			"type" => "spinner");

/*toggle*/$THEMEREX_options[] = array( "title" => __('Customization logo type font', 'themerex'),
			"id" => 'customization_logo_text',
			"icon" => 'iconadmin-fontsize',
			"override" => "category",
			"padding" => true,
			"divider" => false,
			"closed" => true,
			"type" => "toggle");

$THEMEREX_options[] = array( "title" => __('Logo text', 'themerex'),
			"desc" => __('The text will be used as logo when switching on the parameter "Text logo".', 'themerex'),
			"override" => "category",
			"id" => "title_logo",
			"std" => "Wine",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Sub title', 'themerex'),
			"desc" => __('Text under the logo', 'themerex'),
			"override" => "category",
			"id" => "sub_title_logo",
			"std" => "MULTIPURPOSE WP THEME",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Show sub title', 'themerex'),
			"id" => 'sub_title_logo_show',
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Logo font', 'themerex'),
			"desc" => __('Select logo main font', 'themerex'),
			"id" => "logo_font",
			"options" => $fonts,
			"std" => "Laila",
			"type" => "fonts");

$THEMEREX_options[] = array( "title" => __('Logo font style', 'themerex'),
			"id" => "logo_font_style",
			"divider" => false,
			"options" =>  array("normal"=>__("Normal", 'themerex'), "italic"=>__("Italic", 'themerex')),
			"std" => "normal",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Logo font weight', 'themerex'),
			"id" => "logo_font_weight",
			"desc" => "Sets the font as bold <br /> <i>In case this option is not applied for the font used, the most similar will be used</i>",
			"divider" => false,
			"options" =>  $font_style,
			"std" => "300",
			"type" => "radio");


$THEMEREX_options[] = array( "title" => __('Logo font size', 'themerex'),
			"id" => "logo_font_size",
			"divider" => false,
			"std" => "40",
			"min" => 5,
			"max" => 150,
			"type" => "spinner");


/*toggle*/$THEMEREX_options[] = array( 
			"end" => true,
			"override" => "category",
			"type" => "toggle");

/*toggle*/$THEMEREX_options[] = array( "title" => __('Customization logo type images', 'themerex'),
			"id" => 'customization_logo_images',
			"override" => "category",
			"padding" => true,
			"divider" => false,
			"closed" => true,
			"icon" => 'iconadmin-leaf',
			"type" => "toggle");


$THEMEREX_options[] = array( "title" => __('Logo image', 'themerex'),
			"desc" => __('Logo image for header', 'themerex'),
			"override" => "category",
			"id" => "logo_image",
			"std" => "",
			"type" => "media");

$THEMEREX_options[] = array( "title" => __('Logo image for footer', 'themerex'),
			"desc" => __('Logo image for footer', 'themerex'),
			"override" => "category",
			"id" => "logo_image_footer",
			"std" => "",
			"divider" => false,
			"type" => "media");


/*toggle*/$THEMEREX_options[] = array( 
			"end" => true,
			"override" => "category",
			"type" => "toggle");

/*Menu*/
/*tab*/$THEMEREX_options[] = array( "title" => __('Menu', 'themerex'),
			"id" => "tab_customization_mainmenu",
			"override" => "category,post,page",
			"icon" => "iconadmin-menu",
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Show main menu', 'themerex'),
			"id" => 'main_menu_show',
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Main menu position', 'themerex'),
			"desc" => __('Attach main menu to top of window then page scroll down', 'themerex'),
			"id" => "menu_position",
			"override" => "category,post,page",
			"std" => "Fixed",
			"options" => array("Fixed"=>__("Fix menu position", 'themerex'), "none"=>__("Don't fix menu position", 'themerex')),
			"dir" => "vertical",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Menu display', 'themerex'),
			"desc" => __('Display menu type', 'themerex'),
			"id" => "menu_display",
			"override" => "category,post,page",
			"std" => "visible",
			"options" => array(
				"hide"=>__("Hidden menu", 'themerex'), 
				"visible"=>__("Visible menu", 'themerex')
			),
			"dir" => "vertical",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Menu style', 'themerex'),
			"desc" => __('Sets top menu style', 'themerex'),
			"id" => "menu_style",
			"override" => "category,post,page",
			"std" => "1",
			"options" => array(
				"1" => get_template_directory_uri().'/admin/images/icons/menu1.png',
				"2" => get_template_directory_uri().'/admin/images/icons/menu2.png',
			),
			"style" => "list",
			"type" => "images");

$THEMEREX_options[] = array( "title" => __('Smart scroll menu', 'themerex'),
			"desc" => __('Shows menu when scrolling to top (works with fixed menu when it\'s visible)', 'themerex'),
			"id" => "menu_smart_scroll",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Submenu width', 'themerex'),
			"desc" => __('Width for dropdown menus in main menu', 'themerex'),
			"id" => "menu_width",
			"override" => "category,post,page",
			"increment" => 5,
			"std" => "180",
			"min" => 180,
			"max" => 300,
			"mask" => "?999",
			"type" => "spinner");

$THEMEREX_options[] = array( "title" => __('Max width for responsive menu', 'themerex'),
			"desc" => __('Use responsive menu, if window width less then value in this field', 'themerex'),
			"id" => "responsive_menu_width",
			"override" => "category,post,page",
			"divider" => false,
			"std" => "800",
			"mask" => "?9999",
			"type" => "text");

/*Slider*/
/*tab*/$THEMEREX_options[] = array( "title" => __('Slider', 'themerex'),
			"id" => "tab_customization_slider",
			"icon" => "iconadmin-picture",
			"override" => "category,page,post",
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Main slider parameters', 'themerex'),
			"desc" => __('Select parameters for main slider (you can override it in each category and page)', 'themerex'),
			"override" => "category,page,post",
			"type" => "info");
			
$THEMEREX_options[] = array( "title" => __('Show Slider', 'themerex'),
			"desc" => __('Do you want to show slider on each page (post)', 'themerex'),
			"id" => "slider_show",
			"override" => "category,page,post",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");
			
$THEMEREX_options[] = array( "title" => __('Slider display', 'themerex'),
			"desc" => __('How display slider: fixed width or fullscreen width', 'themerex'),
			"id" => "slider_display",
			"override" => "category,page,post",
			"std" => "none",
			"options" => array(
				"fixed"=>__("Fixed width", 'themerex'),
				"fullscreen"=>__("Fullscreen", 'themerex')
			),
			"size" => "big",
			"type" => "switch");
			
$THEMEREX_options[] = array( "title" => __('Slider engine', 'themerex'),
			"desc" => __('What engine use to show slider?', 'themerex'),
			"id" => "slider_engine",
			"override" => "category,page,post",
			"std" => "swiper",
			"options" => $sliders,
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Revolution Slider alias or Royal Slider ID', 'themerex'),
			"desc" => __("Revolution Slider alias or Royal Slider ID (see in slider settings on plugin page)", 'themerex'),
			"id" => "slider_alias",
			"override" => "category,page,post",
			"std" => "",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Slider: Category to show', 'themerex'),
			"desc" => __('Select category to show in Slider (ignored for Revolution and Royal sliders)', 'themerex'),
			"id" => "slider_category",
			"override" => "category,page,post",
			"std" => "",
			"options" => themerex_array_merge(array(0 => __('- Any category -', 'themerex')), $categories),
			"type" => "select",
			"multiple" => true,
			"style" => "list");

$THEMEREX_options[] = array( "title" => __('Slider: Number posts or comma separated posts list', 'themerex'),
			"desc" => __("How many recent posts display in slider or comma separated list of posts ID (in this case selected category ignored)", 'themerex'),
			"override" => "category,page,post",
			"id" => "slider_posts",
			"std" => "5",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __("Slider: Post's order by", 'themerex'),
			"desc" => __("Posts in slider ordered by date (default), comments, views, author rating, users rating, random or alphabetically", 'themerex'),
			"override" => "category,page,post",
			"id" => "slider_orderby",
			"std" => "date",
			"options" => $sorting,
			"type" => "select");

$THEMEREX_options[] = array( "title" => __("Slider: Post's order", 'themerex'),
			"desc" => __('Select the desired ordering method for posts', 'themerex'),
			"id" => "slider_order",
			"override" => "category,page,post",
			"std" => "desc",
			"options" => $ordering,
			"size" => "big",
			"type" => "switch");
			
$THEMEREX_options[] = array( "title" => __("Slider: Show post's infobox", 'themerex'),
			"desc" => __("Do you want to show post's title, reviews rating and description on slides in slider", 'themerex'),
			"id" => "slider_info_box",
			"override" => "category,page,post",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __("Slider: Show slider controls", "themerex"),
			"desc" => __("Show arrows inside slider", "themerex"),
			"id" => "slider_controls",
			"override" => "category,page,post",
			"std" => "yes",
			"type" => "switch",
			"options" => $yes_no);

$THEMEREX_options[] = array( "title" => __("Slider: Show slider pagination", "themerex"),
			"desc" => __("Show bullets for slide switch", "themerex"),
			"id" => "slider_pagination",
			"std" => "yes",
			"type" => "switch",
			"options" => $yes_no);
			
$THEMEREX_options[] = array( "title" => __("Slider: Infobox fixed", 'themerex'),
			"desc" => __("Do you want to fix infobox on slides in slider or hide it in hover", 'themerex'),
			"id" => "slider_info_fixed",
			"override" => "category,page,post",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");
			
$THEMEREX_options[] = array( "title" => __("Slider: Show post's category", 'themerex'),
			"desc" => __("Do you want to show post's category on slides in slider", 'themerex'),
			"id" => "slider_info_category",
			"override" => "category,page,post",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");
			
$THEMEREX_options[] = array( "title" => __("Slider: Show post's reviews rating", 'themerex'),
			"desc" => __("Do you want to show post's reviews rating on slides in slider", 'themerex'),
			"id" => "slider_reviews",
			"override" => "category,page,post",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");
			
$THEMEREX_options[] = array( "title" => __("Review mark style", 'themerex'),
			"desc" => __("Review block display option", 'themerex'),
			"id" => "slider_reviews_style",
			"override" => "category,page,post",
			"std" => "rev_full",
			"options" => array(
				'rev_short' => __('Short review block', 'themerex'),
				'rev_full' => __('Full review block', 'themerex')
			),
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __("Slider: Show post's descriptions", 'themerex'),
			"desc" => __("Do you want to show post's description on slides in slider", 'themerex'),
			"id" => "slider_descriptions",
			"override" => "category,page,post",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __("Slider: height", "themerex"),
			"desc" => __("Specifies the height of the slider", "themerex"),
			"id" => "slider_height",
			"override" => "category,page,post",
			"std" => "500",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __("Slider:Navigation color scheme", "themerex"),
			"desc" => __("Is a tool to change color scheme in the slider", "themerex"),
			"id" => "slider_nav_theme",
			"override" => "category,page,post",
			"divider" => false,
			"std" => "dark",
			"type" => "switch",
			"size" => "big",
			"options" => array(
				'dark' => __('Dark', 'themerex'),
				'light' => __('Light', 'themerex')
			));


/*Media*/
/*tab*/$THEMEREX_options[] = array( "title" => __('Media', 'themerex'),
			"id" => "tab_customization_media",
			"override" => "category,post,page",
			"icon" => "iconadmin-picture",
			"type" => "tab");

$THEMEREX_theme_options[] = array( "name" => __('Media settings', 'themerex'),
			"std" => __('Media elements settings', 'themerex'),
			"override" => "category,post,page",
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Pop-up\'s opening effect', 'themerex'),
			"desc" => __('Sets the effect when opening a pop-up window', 'themerex'),
			"id" => "popup_effect",
			"override" => "category,post,page",
			"std" => "mfp-zoom-in",
			"options" => array(
				'mfp-zoom-in' 		=>'Zoom',
				'mfp-newspaper' 	=>'Newspaper',
				'mfp-move-from-top' =>'Horizontal move',
				'Move from top' 	=>'Move from top',
				'mfp-3d-unfold' 	=>'3d unfold',
				'mfp-zoom-out' 		=>'Zoom-out'
			),
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Substitute standard Wordpress gallery', 'themerex'),
			"desc" => __('Substitute standard Wordpress gallery with our theme-styled gallery', 'themerex'),
			"id" => "substitute_gallery",
			"override" => "category,post,page",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Theme-styled Standard Wordpress gallery', 'themerex'),
			"desc" => __('Substitute standard Wordpress gallery with our theme-styled gallery', 'themerex'),
			"id" => "substitute_gallery_layout",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");
			
$THEMEREX_options[] = array( "title" => __('Substitute audio tags', 'themerex'),
			"desc" => __('Substitute audio tag with source from soundclound to embed player', 'themerex'),
			"id" => "substitute_audio",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Substitute video tags', 'themerex'),
			"desc" => __('Substitute video tags to embed players', 'themerex'),
			"id" => "substitute_video",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Use Media Element script for audio and video tags', 'themerex'),
			"desc" => __('Do you want use the Media Element script for all audio and video tags on your site?', 'themerex'),
			"id" => "use_mediaelement",
			"divider" => false,
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

/*Body style*/
/*tab*/$THEMEREX_options[] = array( "title" => __('Body style', 'themerex'),
			"id" => "tab_customization_background",
			"override" => "category,post,page",
			"icon" => "iconadmin-picture-1",
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Background parameters', 'themerex'),
			"desc" => __('This parameters only for fixed body style. Use only background image (if selected), else use background pattern', 'themerex'),
			"override" => "category,post,page",
			"type" => "info");
			
$THEMEREX_options[] = array( "title" => __('Body style', 'themerex'),
			"desc" => __('Use wide or boxed body style', 'themerex'),
			"id" => "body_style",
			"override" => "category,post,page",
			"std" => "wide",
			"options" => $body_styles,
			"style" => "list",
			"type" => "images");

$THEMEREX_options[] = array( "title" => __('Background color', 'themerex'),
			"desc" => __('Body background color', 'themerex'),
			"id" => "bg_color",
			"override" => "category,post,page",
			"std" => "",
			"type" => "color");

$THEMEREX_options[] = array( "title" => __('Background predefined pattern', 'themerex'),
			"desc" => __('Select theme background pattern (first case - without pattern)', 'themerex'),
			"id" => "bg_pattern",
			"override" => "category,post,page",
			"std" => "",
			"options" => array(
				0 => get_template_directory_uri().'/admin/images/spacer.png',
				1 => get_template_directory_uri().'/images/bg/pattern_1_thumb.png',
				2 => get_template_directory_uri().'/images/bg/pattern_2_thumb.png',
				3 => get_template_directory_uri().'/images/bg/pattern_3_thumb.png',
				4 => get_template_directory_uri().'/images/bg/pattern_4_thumb.png',
				5 => get_template_directory_uri().'/images/bg/pattern_5_thumb.png',
			),
			"style" => "list",
			"type" => "images");


$THEMEREX_options[] = array( "title" => __('Background predefined image', 'themerex'),
			"desc" => __('Select theme background image (first case - without image)', 'themerex'),
			"id" => "bg_image",
			"override" => "category,post,page",
			"std" => "",
			"options" => array(
				0 => get_template_directory_uri().'/admin/images/spacer.png',
				1 => get_template_directory_uri().'/images/bg/image_1_thumb.jpg',
				2 => get_template_directory_uri().'/images/bg/image_2_thumb.jpg',
				3 => get_template_directory_uri().'/images/bg/image_3_thumb.jpg',
			),
			"style" => "list",
			"type" => "images");

$THEMEREX_options[] = array( "title" => __('Background custom image', 'themerex'),
			"desc" => __('Select or upload background custom image', 'themerex'),
			"id" => "bg_custom_image",
			"override" => "category,post,page",
			"std" => "",
			"type" => "media");

$THEMEREX_options[] = array( "title" => __('Background custom image position for horizontal display', 'themerex'),
			"desc" => __('Select custom image position for horizontal display', 'themerex'),
			"id" => "bg_custom_image_position_x",
			"override" => "category,post,page",
			"std" => "left",
			"options" => array(
				'left' => __('Left', 'themerex'),
				'center' => __('Center', 'themerex'),
				'right' => __('Right', 'themerex'),
			),
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Background custom image position for vertical display', 'themerex'),
			"desc" => __('Select custom image position for vertical display', 'themerex'),
			"id" => "bg_custom_image_position_y",
			"override" => "category,post,page",
			"std" => "top",
			"options" => array(
				'top' => __('Top', 'themerex'),
				'center' => __('Center', 'themerex'),
				'bottom' => __('Bottom', 'themerex'),
			),
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Background custom image repeat', 'themerex'),
			"desc" => __('Select custom image position repeat', 'themerex'),
			"id" => "bg_custom_image_repeat",
			"override" => "category,post,page",
			"std" => "no-repeat",
			"options" => array(
				'no-repeat' => __('No repeat', 'themerex'),
				'repeat' => __('Repeat', 'themerex'),
				'repeat-x' => __('Repeat X', 'themerex'),
				'repeat-y' => __('Repeat Y', 'themerex'),
			),
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Background custom image position', 'themerex'),
			"desc" => __('Select custom image position', 'themerex'),
			"id" => "bg_custom_image_attachment",
			"override" => "category,post,page",
			"std" => "scroll",
			"options" => array(
				'scroll' => __('Not fixed', 'themerex'),
				'fixed' => __('Fixed', 'themerex'),
			),
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __("Show user's header", 'themerex'),
			"desc" => __("Select display options for the user's header area. 'Grey' and 'Global' - theme styled variants, 'Custom' - you must put all style properties in the inserted html-code and shortcodes", 'themerex'),
			"id" => "show_user_header",
			"divider" => false,
			"override" => "category,page,post",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('User\'s header content background color', 'themerex'),
			"id" => "user_header_bg",
			"divider" => false,
			"desc" => __('Used to set the background color for the user\'s header', 'themerex'),
			"override" => "category,page",
			"std" => "",
			"type" => "color");	

$THEMEREX_options[] = array( "title" => __("User's header content", 'themerex'),
			"desc" => __('Put header html-code and/or shortcodes here. You can use any html-tags and shortcodes', 'themerex'),
			"id" => "user_header_content",
			"override" => "category,page,post",
			"std" => "",
			"rows" => "10",
			"type" => "editor");

$THEMEREX_options[] = array( "title" => __('Your CSS code', 'themerex'),
			"desc" => __('Put here your css code to correct main theme styles', 'themerex'),
			"id" => "custom_css",
			"override" => "category,post,page",
			"divider" => false,
			"cols" => 80,
			"rows" => 20,
			"std" => "",
			"type" => "textarea");


/*tab start Typography parameters*/
/*tab*/$THEMEREX_options[] = array( "title" => __('Typography', 'themerex'),
			"id" => 'tab_customization_typography',
			"icon" => "iconadmin-fontsize",
			"divider" => false,
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Theme font', 'themerex'),
			"desc" => __('Select theme main font', 'themerex'),
			"id" => "theme_font",
			"std" => "Laila",
			"options" => $fonts,
			"type" => "fonts");

$THEMEREX_options[] = array( "title" => __('Heading font', 'themerex'),
			"desc" => __('Select heading main font', 'themerex'),
			"id" => "header_font",
			"options" => $fonts,
			"divider" => false,
			"std" => "Laila",
			"type" => "fonts");

/*tab Heading H1-H6*/
	$typography = array(
		"h1" => array( "size"=>72, "uppercase"=>"no", "style"=>"normal", "weight"=>"500", "lheight"=>"120%", "spacing"=>"-0.01em"),
		"h2" => array( "size"=>60, "uppercase"=>"no", "style"=>"normal", "weight"=>"500", "lheight"=>"120%", "spacing"=>"-0.01em"),
		"h3" => array( "size"=>48, "uppercase"=>"no", "style"=>"normal", "weight"=>"500", "lheight"=>"120%", "spacing"=>"-0.01em"),
		"h4" => array( "size"=>30, "uppercase"=>"no", "style"=>"normal", "weight"=>"500", "lheight"=>"120%", "spacing"=>"0"),
		"h5" => array( "size"=>18, "uppercase"=>"no", "style"=>"normal", "weight"=>"500", "lheight"=>"120%", "spacing"=>"-0.01em"),
		"h6" => array( "size"=>16, "uppercase"=>"no", "style"=>"normal", "weight"=>"500", "lheight"=>"120%", "spacing"=>"0")
	);
$i_heading = 1;
while( $i_heading <= 6 ){

if( $i_heading == 1) {
$THEMEREX_options[] = array( "title" => 'Heading H'.$i_heading,
			"id" => "typography_header".$i_heading."_stream",
			"start" => "typography_header_parameters",
			"type" => "tab");
} else {
$THEMEREX_options[] = array( "title" => 'Heading H'.$i_heading,
			"id" => "typography_header".$i_heading."_stream",
			"type" => "tab");
}

$THEMEREX_options[] = array( "title" => 'Font size H'.$i_heading,
			"id" => "header_font_size_h".$i_heading,
			"std" => $typography['h'.$i_heading]['size'],
			"type" => "text");

$THEMEREX_options[] = array( "title" => 'Uppercase text H'.$i_heading,
			"id" => "header_font_uppercase_h".$i_heading,
			"std" => $typography['h'.$i_heading]['uppercase'],
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => 'Font style H'.$i_heading,
			"id" => "header_font_style_h".$i_heading,
			"options" =>  array("normal"=>__("Normal", 'themerex'), "italic"=>__("Italic", 'themerex')),
			"std" => $typography['h'.$i_heading]['style'],
			"type" => "radio");

$THEMEREX_options[] = array( "title" => 'Font weight H'.$i_heading,
			"id" => "header_font_weight_h".$i_heading,
			"options" =>  $font_style,
			"std" => $typography['h'.$i_heading]['weight'],
			"type" => "radio");

$THEMEREX_options[] = array( "title" => 'Line height H'.$i_heading,
			"id" => "header_line_height_h".$i_heading,
			"std" => $typography['h'.$i_heading]['lheight'],
			"type" => "text");

$THEMEREX_options[] = array( "title" => 'Font spacing H'.$i_heading,
			"id" => "header_font_spacing_h".$i_heading,
			"divider" => false,
			"std" => $typography['h'.$i_heading]['spacing'],
			"type" => "text");
$i_heading++;
}

//###############################
//####Sidebars               #### 
//###############################
$THEMEREX_options[] = array( "title" => __('Sidebars', 'themerex'),
			"id" => "partition_sidebars",
			"icon" => "iconadmin-menu",
			"override" => "category,post,page",
			"divider" => false,
			"type" => "partition");

$THEMEREX_options[] = array( "title" => __('Custom sidebars', 'themerex'),
			"desc" => __('In this section you can create unlimited sidebars', 'themerex'),
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Custom sidebars', 'themerex'),
			"desc" => __('Manage custom sidebars. You can use it with each category (page, post) independently', 'themerex'),
			"id" => "custom_sidebars",
			"divider" => false,
			"std" => "",
			"cloneable" => true,
			"type" => "text");

/*tab start sidebar top*/
/*tab*/$THEMEREX_options[] = array( "title" => __('Main', 'themerex'),
			"id" => 'tabsidebar_main',
			"start" => 'tabsidebar_top_parameters',
			"override" => "category,post,page",
			"icon" => "iconadmin-columns",
			"divider" => false,
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Show main sidebar', 'themerex'),
			"desc" => __('Select main sidebar position on blog page', 'themerex'),
			"id" => 'show_sidebar_main',
			"override" => "category,post,page",
			"std" => "sideBarRight",
			"divider" => false,
			"options" => $positions_sidebar,
			"style" => "list",
			"type" => "images");


$THEMEREX_options[] = array( "title" => __('Select main sidebar', 'themerex'),
			"desc" => __('Select main sidebar for blog page', 'themerex'),
			"id" => "sidebar_main",
			"override" => "category,post,page",
			"divider" => false,
			"std" => "sidebar-main",
			"options" => $sidebars,
			"type" => "select");

/*tab*/$THEMEREX_options[] = array( "title" => __('Top', 'themerex'),
			"id" => 'tabsidebar_top',
			"override" => "category,post,page",
			"icon" => "iconadmin-columns",
			"divider" => false,
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Show top sidebar', 'themerex'),
			"desc" => __('Show top sidebar on blog page', 'themerex'),
			"id" => 'show_sidebar_top',
			"override" => "category,post,page",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Select top sidebar', 'themerex'),
			"desc" => __('Select top sidebar for blog page', 'themerex'),
			"id" => "sidebar_top",
			"override" => "category,post,page",
			"std" => "sidebar-top",
			"options" => $sidebars,
			"type" => "select");

$THEMEREX_options[] = array( "title" => __('Number of columns in widgets', 'themerex'),
			"desc" => __("Sets the number of columns in widgets for footer", 'themerex'),
			"id" => "widget_columns_top",
			"divider" => false,
			"override" => "category,post,page",
			"std" => "4",
			"min" => 1,
			"max" => 6,
			"increment" => 1,
			"type" => "spinner");

/*tab*/$THEMEREX_options[] = array( "title" => __('Footer', 'themerex'),
			"id" => "tabsidebar_footer",
			"override" => "category,post,page",
			"icon" => "iconadmin-columns",
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Show footer sidebar', 'themerex'),
			"desc" => __('Show footer sidebar', 'themerex'),
			"id" => "show_sidebar_footer",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Select footer sidebar', 'themerex'),
			"desc" => __('Select footer sidebar for blog page', 'themerex'),
			"id" => "sidebar_footer",
			"override" => "category,post,page",
			"std" => "sidebar-footer",
			"options" => $sidebars,
			"type" => "select");

$THEMEREX_options[] = array( "title" => __('Number of columns in widgets', 'themerex'),
			"desc" => __("Sets the number of columns in widgets for footer", 'themerex'),
			"id" => "widget_columns_footer",
			"override" => "category,post,page",
			"std" => "4",
			"min" => 1,
			"max" => 6,
			"increment" => 1,
			"type" => "spinner");


$THEMEREX_options[] = array( "title" => __('Show copyright', 'themerex'),
			"desc" => __('Show copyright in footer', 'themerex'),
			"id" => 'show_copyright',
			"override" => "category,post,page",
			"std" => "no",
			"options" => $yes_no,
			"divider" => false,
			"type" => "switch");
			

$THEMEREX_options[] = array( "title" => __('Footer copyright', 'themerex'),
			"desc" => __("Copyright text to show in footer area (bottom of site) <br> [year] - <i>Current year</i>", 'themerex'),
			"id" => "footer_copyright",
			"divider" => false,
			"override" => "category,post,page",
			"std" => "<a href='http://themerex.net'>ThemeREX</a> &copy; [year] All Rights Reserved",
			"type" => "text");



//###############################
//#### Blog                  #### 
//###############################


/*tab*/$THEMEREX_options[] = array( "title" => __('Blog', 'themerex'),
			"id" => "partition_blog",
			"icon" => "iconadmin-docs",
			"override" => "category,post,page",
			"divider" => false,
			"type" => "partition");

/*tab*/$THEMEREX_options[] = array( "title" => __('General', 'themerex'),
			"id" => "blog_tab_general",
			"start" => 'blog_tab_start',
			"icon" => "iconadmin-docs",
			"override" => "category,post,page",
			"divider" => false,
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Show post format icon', 'themerex'),
			"desc" => __('Shows an icon of a post format', 'themerex'),
			"id" => "show_post_icon",
			"override" => "category,page,post",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Show post title', 'themerex'),
			"desc" => __('Show area with post title', 'themerex'),
			"id" => "show_post_title",
			"override" => "category,page,post",
			"divider" => false,
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Show post info', 'themerex'),
			"desc" => __('Show area with post info on single pages)', 'themerex'),
			"override" => "category,page,post",
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Show post info', 'themerex'),
			"id" => "show_post_info",
			"override" => "category,page,post",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Post info set', 'themerex'),
			"desc" => __('Builds the set of elements displayed in post info <br> Edit options are only available in single page', 'themerex'),
			"id" => "set_post_info",
			"override" => "category,page,post",
			"std" => "comments,category,author,date,tags,review,br1,editor,sticky",
			"options" => $post_info_set,
			"divider" => false,
			'multiple' => true,
			"type" => "checklist");


/*tab*/$THEMEREX_options[] = array( "title" => __('Stream page', 'themerex'),
			"id" => 'blog_tab_stream',
			"icon" => "iconadmin-docs",
			"divider" => false,
			"override" => "category,page,post",
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Blog streampage parameters', 'themerex'),
			"desc" => __('Select desired blog streampage parameters (you can override it in each category)', 'themerex'),
			"override" => "category,page",
			"type" => "info");


$THEMEREX_options[] = array( "title" => __('Blog style', 'themerex'),
			"desc" => __('Select desired blog style', 'themerex'),
			"id" => "blog_style",
			"override" => "category",
			"std" => "excerpt_style1",
			"options" => $blog_styles,
			"style" => "list",
			"type" => "images");


$THEMEREX_options[] = array( "title" => __('Portfolio item size', 'themerex'),
			"desc" => __('By default post display will look like a cube.  Rectangle will be 2x bigger.', 'themerex'),
			"id" => "portfolio_item_style",
			"override" => "page,post",
			"std" => "cube_1_1",
			"options" => array(
				'cube_1_1' => get_template_directory_uri().'/admin/images/icons/cube_1_1.png',
				'cube_2_1' => get_template_directory_uri().'/admin/images/icons/cube_2_1.png'
			),
			"style" => "list",
			"type" => "images");

$THEMEREX_options[] = array( "title" => __('Post item style', 'themerex'),
			"desc" => __('Predetermines blog stream page item\'s style for each post', 'themerex'),
			"id" => "blog_item_style",
			"override" => "category,post",
			"std" => "excerpt_style1",
			"options" => array(
				'excerpt_style1' => get_template_directory_uri().'/admin/images/icons/layout_s1.png',
				'excerpt_style2' => get_template_directory_uri().'/admin/images/icons/layout_s2.png',
				'excerpt_style3' => get_template_directory_uri().'/admin/images/icons/layout_s3.png'
			),
			"style" => "list",
			"type" => "images");

$THEMEREX_options[] = array( "title" => __('Post\'s background color', 'themerex'),
			"desc" => __('This option will only work for blog style = Cube', 'themerex'),
			"id" => "cube_color",
			"override" => "category,post",
			"std" => "",
			"type" => "color");

$THEMEREX_options[] = array( "title" => __('Single page Ajax loading', 'themerex'),
			"desc" => __('Enables page loading with Ajax (works with style=cube)', 'themerex'),
			"id" => "cube_ajax",
			"override" => "category",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");


$THEMEREX_options[] = array( "title" => __('Dedicated location', 'themerex'),
			"desc" => __('Select location for the dedicated content or featured image in the "excerpt" blog style', 'themerex'),
			"id" => "dedicated_location",
			"override" => "category,page",
			"std" => "inherit",
			"options" => $locations,
			"type" => "select");

$THEMEREX_options[] = array( "title" => __('Info block of category', 'themerex'),
			"desc" => __('Displays info block of Category with description', 'themerex'),
			"id" => "description_lable_show",
			"override" => "category",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Info block style', 'themerex'),
			"desc" => __('set info block style, works together with option (Info block of category)', 'themerex'),
			"id" => "description_lable_style",
			"override" => "category",
			"std" => 1,
			"options" => array(
				1 => __('Style 1', 'themerex'),
				2 => __('Style 2', 'themerex'),
			),
			"type" => "checklist");


$THEMEREX_options[] = array( "title" => __('Show Breadcrumbs', 'themerex'),
			"desc" => __('Show path to current category (post, page)', 'themerex'),
			"id" => "show_breadcrumbs",
			"override" => "category,post,page",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Show filters', 'themerex'),
			"desc" => __('Show filter buttons (only for Blog style = Portfolio, Masonry, Classic)', 'themerex'),
			"id" => "show_filters",
			"override" => "category,page",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Use as filter keywords', 'themerex'),
			"desc" => __('Select taxonomy that will be used as a filter for portfolio elements', 'themerex'),
			"id" => "filter_taxonomy",
			"override" => "category",
			"std" => "tags",
			"options" => array(
				'tags' => __('Tags', 'themerex'),
				'categories' => __('Categories', 'themerex')
			),
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Blog posts sorted by', 'themerex'),
			"desc" => __('Select the desired sorting method for posts', 'themerex'),
			"id" => "blog_sort",
			"override" => "category,page",
			"std" => "date",
			"options" => $sorting,
			"dir" => "vertical",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Blog posts order', 'themerex'),
			"desc" => __('Select the desired ordering method for posts', 'themerex'),
			"id" => "blog_order",
			"override" => "category,page",
			"std" => "desc",
			"options" => $ordering,
			"size" => "big",
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Blog posts per page', 'themerex'),
			"desc" => __('How many posts display on blog pages for selected style. If empty or 0 - inherit system wordpress settings', 'themerex'),
			"id" => "posts_per_page",
			"override" => "category,page",
			"std" => "12",
			"mask" => "?99",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Post excerpt maxlength', 'themerex'),
			"desc" => __('How many characters from post excerpt are display in blog streampage (only for Blog style = Excerpt). 0 - do not trim excerpt.', 'themerex'),
			"id" => "post_excerpt_maxlength",
			"std" => "250",
			"mask" => "?9999",
			"type" => "text");


$THEMEREX_options[] = array( "title" => __('Single Post link (Read more)', 'themerex'),
			"desc" => __('If the option is off, read more and single post link will not be displayed', 'themerex'),
			"id" => "show_single_link",
			"override" => "category,post",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Show text before "Read more" tag', 'themerex'),
			"desc" => __('Show text before "Read more" tag on single pages', 'themerex'),
			"id" => "show_text_before_readmore",
			"std" => "yes",
			"divider" => false,
			"options" => $yes_no,
			"type" => "switch");


/*tab*/$THEMEREX_options[] = array( "title" => __('Single page', 'themerex'),
			"id" => 'blog_tab_single',
			"icon" => "iconadmin-doc",
			"divider" => false,
			"override" => "category,post,page",
			"type" => "tab");


$THEMEREX_options[] = array( "title" => __('Single (detail) pages parameters', 'themerex'),
			"desc" => __('Select desired parameters for single (detail) pages (you can override it in each category and single post (page))', 'themerex'),
			"override" => "category,post,page",
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Frontend editor', 'themerex'),
			"desc" => __("Allow authors to edit their posts in frontend area)", 'themerex'),
			"id" => "allow_editor",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch"); 

$THEMEREX_options[] = array( "title" => __('Show featured image before post', 'themerex'),
			"desc" => __("Show featured image (if selected) before post content on single pages", 'themerex'),
			"id" => "show_featured_image",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Show post title on links, chat, quote, status', 'themerex'),
			"desc" => __('Show area with post title on single and blog pages in specific post formats: links, chat, quote, status', 'themerex'),
			"id" => "show_post_title_on_quotes",
			"override" => "category,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Show post author details', 'themerex'),
			"desc" => __("Show post author information block on single post page", 'themerex'),
			"id" => "show_post_author",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Shows social icons in the author\'s block', 'themerex'),
			"desc" => __("Enables a display option for social icons in the author's block in single posts <br> <i>active if the option is enabled (Show post author details)</i>", 'themerex'),
			"id" => "show_post_author_socicon",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");


$THEMEREX_options[] = array( "title" => __('Show post counters', 'themerex'),
			"desc" => __("Show counters block on single post page", 'themerex'),
			"id" => "show_post_counters",
			"override" => "category,page,post",
			"divider" => false,
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");


/*toggle*/$THEMEREX_options[] = array( "title" => __('Related post', 'themerex'),
			"id" => 'related_toggle',
			"icon" => 'iconadmin-list-bullet',
			"override" => "category,page,post",
			"closed" => true,
			"type" => "toggle");

$THEMEREX_options[] = array( "title" => __('Show related posts', 'themerex'),
			"desc" => __("Show related posts block on single post page", 'themerex'),
			"id" => "show_post_related",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Related posts number', 'themerex'),
			"desc" => __("How many related posts showed on single post page", 'themerex'),
			"id" => "post_related_count",
			"override" => "category,post,page",
			"std" => "4",
			"increment" => 1,
			"min" => 2,
			"max" => 6,
			"type" => "spinner");

$THEMEREX_options[] = array( "title" => __('Related posts order', 'themerex'),
			"desc" => __('Select the desired ordering method for related posts', 'themerex'),
			"id" => "post_related_order",
			"override" => "category,page",
			"std" => "desc",
			"options" => $ordering,
			"size" => "big",
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Related posts sorted by', 'themerex'),
			"desc" => __('Select the desired sorting method for related posts', 'themerex'),
			"id" => "post_related_sort",
			"override" => "category,page",
			"divider" => false,
			"std" => "date",
			"options" => $sorting,
			"type" => "select");


/*toggle*/$THEMEREX_options[] = array( 
			"end" => true,
			"override" => "category,post,page",
			"type" => "toggle");

/*toggle*/$THEMEREX_options[] = array( "title" => __('Comments post', 'themerex'),
			"id" => 'comments_toggle',
			"override" => "category,post,page",
			"icon" => 'iconadmin-comment',
			"divider" => false,
			"padding" => true,
			"closed" => true,
			"type" => "toggle");

$THEMEREX_options[] = array( "title" => __('Show comments', 'themerex'),
			"desc" => __("Show comments block on single post page", 'themerex'),
			"id" => "show_post_comments",
			"override" => "category,post,page",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Show avatar', 'themerex'),
			"desc" => __("Show avatars in comments", 'themerex'),
			"id" => "show_avatar_comments",
			"override" => "category,post,page",
			"divider" => false,
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

/*toggle*/$THEMEREX_options[] = array( 
			"end" => true,
			"override" => "category,post,page",
			"type" => "toggle");



/*tab*/$THEMEREX_options[] = array( "title" => __('Other parameters', 'themerex'),
			"id" => 'blog_tab_other',
			"override" => "category",
			"icon" => "iconadmin-newspaper",
			"divider" => false,
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('General Blog parameters', 'themerex'),
			"desc" => __('Select excluded categories, substitute parameters, etc.', 'themerex'),
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Exclude categories', 'themerex'),
			"desc" => __('Select categories, which posts are exclude from blog page', 'themerex'),
			"id" => "exclude_cats",
			"std" => "",
			"options" => $categories,
			"multiple" => true,
			"style" => "list",
			"type" => "select");

$THEMEREX_options[] = array( "title" => __('Blog pagination style', 'themerex'),
			"desc" => __('Select pagination style on blog streampages', 'themerex'),
			"id" => "blog_pagination",
			"override" => "category",
			"std" => "pages",
			"options" => array(
				'pages'    => __('Standard page numbers', 'themerex'),
				'viewmore' => __('"View more" button', 'themerex'),
				'infinite' => __('Infinite scroll', 'themerex')
			),
			"dir" => "vertical",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Blog counters', 'themerex'),
			"desc" => __('Select counters, displayed near the post title', 'themerex'),
			"id" => "blog_counters",
			"std" => "views",
			"options" => array(
				'none' => __("Don't show any counters", 'themerex'),
				'views' => __('Show views number', 'themerex'),
				'comments' => __('Show comments number', 'themerex')
			),
			"dir" => "vertical",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __("Post's category announce", 'themerex'),
			"desc" => __('What category display in announce block (over posts thumb) - original or nearest parental', 'themerex'),
			"id" => "close_category",
			"std" => "parental",
			"options" => array(
				'parental' => __('Nearest parental category', 'themerex'),
				'original' => __("Original post's category", 'themerex')
			),
			"dir" => "vertical",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Show post date after', 'themerex'),
			"desc" => __('Show post date after N days (before - show post age)', 'themerex'),
			"id" => "show_date_after",
			"divider" => false,
			"std" => "30",
			"mask" => "?99",
			"type" => "text");




//###############################
//#### Google map            #### 
//###############################
$THEMEREX_options[] = array( "title" => __('Google map', 'themerex'),
			"id" => "partition_googlemap",
			"icon" => "iconadmin-globe-1",
			"divider" => false,
			"override" => "category,page,post",
			"type" => "partition");

$THEMEREX_options[] = array( "title" => __('Google map parameters', 'themerex'),
			"desc" => __('Select parameters for Google map (you can override it in each category and page)', 'themerex'),
			"override" => "category,page,post",
			"type" => "info");
			
$THEMEREX_options[] = array( "title" => __('Show Google Map', 'themerex'),
			"desc" => __('Do you want to show Google map on each page (post)', 'themerex'),
			"id" => "googlemap_show",
			"override" => "category,page,post",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Zoom with mouse wheel', 'themerex'),
			"desc" => __('Map\'s zoom with mouse wheel', 'themerex'),
			"id" => "googlemap_scroll",
			"override" => "category,page,post",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Address to show on map', 'themerex'),
			"desc" => __("Enter address to show on map center", 'themerex'),
			"id" => "googlemap_address",
			"override" => "category,page,post",
			"std" => "",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Latitude and Longtitude to show on map', 'themerex'),
			"desc" => __("Enter coordinates (separated by comma) to show on map center (instead of address)", 'themerex'),
			"id" => "googlemap_latlng",
			"override" => "category,page,post",
			"std" => "",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Google map initial zoom', 'themerex'),
			"desc" => __("Enter desired initial zoom for Google map", 'themerex'),
			"id" => "googlemap_zoom",
			"override" => "category,page,post",
			"std" => 16,
			"min" => 1,
			"max" => 20,
			"increment" => 1,
			"type" => "spinner");

$THEMEREX_options[] = array( "title" => __('Google map style', 'themerex'),
			"desc" => __("Select style to show Google map", 'themerex'),
			"id" => "googlemap_style",
			"override" => "category,page,post",
			"std" => 'style1',
			"options" => $gmap_styles,
			"type" => "select");

$THEMEREX_options[] = array( "title" => __('Google map marker', 'themerex'),
			"desc" => __("Select or upload png-image with Google map marker", 'themerex'),
			"override" => "category,page,post",
			"id" => "googlemap_marker",
			"std" => '',
			"type" => "media");




//###############################
//#### Reviews               #### 
//###############################
$THEMEREX_options[] = array( "title" => __('Reviews', 'themerex'),
			"id" => "partition_reviews",
			"icon" => "iconadmin-star",
			"divider" => false,
			"override" => "category",
			"type" => "partition");

$THEMEREX_options[] = array( "title" => __('Reviews criterias', 'themerex'),
			"desc" => __('Set up list of reviews criterias. You can override it in any category.', 'themerex'),
			"override" => "category",
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Show reviews block', 'themerex'),
			"desc" => __("Show reviews block on single post page and average reviews rating after post's title in stream pages", 'themerex'),
			"id" => "show_reviews",
			"override" => "category",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Max reviews level', 'themerex'),
			"desc" => __("Maximum level for reviews marks", 'themerex'),
			"id" => "reviews_max_level",
			"std" => "5",
			"options" => array(
				'5'=>__('5 stars', 'themerex'), 
				'10'=>__('10 stars', 'themerex'), 
				'100'=>__('100%', 'themerex')
			),
			"type" => "radio",
			);

$THEMEREX_options[] = array( "title" => __('Show rating as', 'themerex'),
			"desc" => __("Show rating marks as text or as stars/progress bars.", 'themerex'),
			"id" => "reviews_style",
			"std" => "stars",
			"options" => array(
				'text' => __('As text (7.5 / 10)', 'themerex'), 
				'stars' => __('As stars or bars (<span class="icon-star"></span><span class="icon-star"></span><span class="icon-star"></span><span class="icon-star"></span><span class="icon-star"></span>)', 'themerex'),
				'text_stars' => __('As text & bars (7.5 / 10 <span class="icon-star"></span><span class="icon-star"></span><span class="icon-star"></span><span class="icon-star"></span><span class="icon-star"></span>)', 'themerex')

			),
			"dir" => "vertical",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Reviews Criterias Levels', 'themerex'),
			"desc" => __('Words to mark criterials levels. Just write the word and press "Enter". Also you can arrange words.', 'themerex'),
			"id" => "reviews_criterias_levels",
			"std" => __("bad,poor,normal,good,great", 'themerex'),
			"type" => "tags");

$THEMEREX_options[] = array( "title" => __('Show first reviews', 'themerex'),
			"desc" => __("What reviews will be displayed first: by author or by visitors. Also this type of reviews will display under post's title.", 'themerex'),
			"id" => "reviews_first",
			"std" => "author",
			"options" => array(
				'author' => __('By author', 'themerex'),
				'users' => __('By visitors', 'themerex')
				),
			"dir" => "horizontal",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Review block\'s position', 'themerex'),
			"id" => "reviews_float",
			"std" => "right",
			"options" => array(
				'left' => __('Left', 'themerex'),
				'right' => __('Right', 'themerex')
				),
			"dir" => "horizontal",
			"type" => "radio");


$THEMEREX_options[] = array( "title" => __('Hide second reviews', 'themerex'),
			"desc" => __("Do you want hide second reviews tab in widgets and single posts?", 'themerex'),
			"id" => "reviews_second",
			"std" => "show",
			"options" => $show_hide,
			"size" => "medium",
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('What visitors can vote', 'themerex'),
			"desc" => __("What visitors can vote: all or only registered", 'themerex'),
			"id" => "reviews_can_vote",
			"std" => "all",
			"options" => array(
				'all'=>__('All visitors', 'themerex'), 
				'registered'=>__('Only registered', 'themerex')
			),
			"dir" => "horizontal",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Description Length', 'themerex'),
			"desc" => __("Specify the length of description for Review block", 'themerex'),
			"id" => "reviews_length",
			"override" => "category,page,post",
			"std" => -1,
			"min" => 20,
			"max" => 500,
			"increment" => 1,
			"type" => "spinner");

$THEMEREX_options[] = array( "title" => __('Reviews criterias', 'themerex'),
			"desc" => __('Add default reviews criterias.', 'themerex'),
			"id" => "reviews_criterias",
			"override" => "category",
			"divider" => false,
			"std" => "",
			"cloneable" => true,
			"type" => "text");





//###############################
//#### Social                #### 
//###############################
$THEMEREX_options[] = array( "title" => __('Social', 'themerex'),
			"id" => "partition_socials",
			"icon" => "iconadmin-users-1",
			"divider" => false,
			"type" => "partition");

$THEMEREX_options[] = array( "title" => __('Social networks', 'themerex'),
			"desc" => __("Social networks list for site footer and Social widget", 'themerex'),
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Social networks', 'themerex'),
			"desc" => __('Select icon and write URL to your profile in desired social networks.', 'themerex'),
			"id" => "social_icons",
			"std" => array(array('url'=>'', 'icon'=>'')),
			"divider" => false,
			"options" => $socials,
			"cloneable" => true,
			"size" => "small",
			"style" => 'images',
			"type" => "socials");
/*
$THEMEREX_options[] = array( "title" => __('Share buttons', 'themerex'),
			"desc" => __("Add button's code for each social share network.<br>In share url you can use next macro:<br><b>{url}</b> - share post (page) URL,<br><b>{title}</b> - post title,<br><b>{image}</b> - post image,<br><b>{descr}</b> - post description (if supported)<br>For example:<br><b>Facebook</b> share string: <em>http://www.facebook.com/sharer.php?u={link}&amp;t={title}</em><br><b>Delicious</b> share string: <em>http://delicious.com/save?url={link}&amp;title={title}&amp;note={descr}</em>", 'themerex'),
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Show social share buttons', 'themerex'),
			"desc" => __("Show social share buttons block", 'themerex'),
			"id" => "show_share",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");


$THEMEREX_options[] = array( "title" => __('Show share counters', 'themerex'),
			"desc" => __("Show share counters after social buttons", 'themerex'),
			"id" => "show_share_counters",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");
$THEMEREX_options[] = array( "title" => __('Share buttons block direction', 'themerex'),
			"desc" => __("Select direction for the social share buttons block", 'themerex'),
			"id" => "share_direction",
			"std" => "horizontal",
			"options" => $dir,
			"style" => "horizontal",
			"type" => "radio");

$THEMEREX_options[] = array( "title" => __('Share block caption', 'themerex'),
			"desc" => __('Caption for the block with social share buttons', 'themerex'),
			"id" => "share_caption",
			"std" => __('Share this post', 'themerex'),
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Share buttons', 'themerex'),
			"desc" => __('Select icon and write share URL for desired social networks.<br><b>Important!</b> If you leave text field empty - internal theme link will be used (if present).', 'themerex'),
			"id" => "share_buttons",
			"std" => array(array('url'=>'', 'icon'=>'')),
			"divider" => false,
			"options" => $socials,
			"cloneable" => true,
			"size" => "small",
			"style" => 'images',
			"type" => "socials");
*/


//###############################
//#### Contact info          #### 
//###############################
$THEMEREX_options[] = array( "title" => __('Contact info', 'themerex'),
			"id" => "partition_contacts",
			"icon" => "iconadmin-mail-1",
			"type" => "partition");

$THEMEREX_options[] = array( "title" => __('Contact information', 'themerex'),
			"desc" => __('Company address, phones and e-mail', 'themerex'),
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Contact form email', 'themerex'),
			"desc" => __('E-mail for send contact form and user registration data', 'themerex'),
			"id" => "contact_email",
			"divider" => false,
			"std" => "",
			"before" => array('icon'=>'iconadmin-mail-1'),
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Company address (part 1)', 'themerex'),
			"desc" => __('Company country, post code and city', 'themerex'),
			"id" => "contact_address_1",
			"std" => "",
			"before" => array('icon'=>'iconadmin-home'),
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Company address (part 2)', 'themerex'),
			"desc" => __('Street and house number', 'themerex'),
			"id" => "contact_address_2",
			"std" => "",
			"before" => array('icon'=>'iconadmin-home'),
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Phone 1', 'themerex'),
			"id" => "contact_phone_1",
			"divider" => false,
			"std" => "",
			"before" => array('icon'=>'iconadmin-phone'),
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Phone 2', 'themerex'),
			"id" => "contact_phone_2",
			"desc" => __('Phone number', 'themerex'),
			"std" => "",
			"before" => array('icon'=>'iconadmin-phone'),
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Fax', 'themerex'),
			"desc" => __('Fax number', 'themerex'),
			"id" => "contact_fax",
			"std" => "",
			"before" => array('icon'=>'iconadmin-fax'),
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Web site', 'themerex'),
			"desc" => __('You web site', 'themerex'),
			"id" => "contact_website",
			"divider" => false,
			"std" => "",
			"before" => array('icon'=>'iconadmin-globe-1'),
			"type" => "text");


//###############################
//#### Service               #### 
//###############################
$THEMEREX_options[] = array( "title" => __('Service', 'themerex'),
			"id" => "partition_general",
			"override" => "category,post,page",
			"icon" => "iconadmin-wrench",
			"divider" => false,
			"type" => "partition");

$THEMEREX_options[] = array( "title" => __('General parameters', 'themerex'),
			"desc" => __('Select (or upload) logo and favicon, advertisement parameters, etc.', 'themerex'),
			"override" => "category,post,page",
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Show Theme customizer', 'themerex'),
			"desc" => __('Show theme customizer', 'themerex'),
			"id" => "show_theme_customizer",
			"override" => "category,post,page",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Notify about new registration', 'themerex'),
			"desc" => __('Send E-mail with new registration data to address above or to site admin e-mail', 'themerex'),
			"id" => "notify_about_new_registration",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Enable Dummy Data Installer', 'themerex'),
			"desc" => __('Show "Install Dummy Data" in the menu "Appearance". <b>Attention!</b> When you install dummy data all content of your site will be replaced!', 'themerex'),
			"id" => "admin_dummy_data",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Use update notifier in admin panel', 'themerex'),
			"desc" => __('Show update notifier in admin panel (can delay dashboard)', 'themerex'),
			"id" => "admin_update_notifier",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");


$THEMEREX_options[] = array( "title" => __('Favicon', 'themerex'),
			"desc" => __('Upload a 16px x 16px image that will represent your website\'s favicon.<br /><br /><em>To ensure cross-browser compatibility, we recommend converting the favicon into .ico format before uploading. (<a href="http://www.favicon.cc/">www.favicon.cc</a>)</em>', 'themerex'),
			"id" => "favicon",
			"std" => "",
			"type" => "media");


$THEMEREX_options[] = array( "title" => __('Image dimensions', 'themerex'),
			"desc" => __('What dimensions use for uploaded image: Original or "Retina ready" (twice enlarged)', 'themerex'),
			"id" => "retina_ready",
			"std" => "1",
			"options" => array("1"=>__("Original", 'themerex'), "2"=>__("Retina", 'themerex')),
			"type" => "checklist");
			
$THEMEREX_options[] = array( "title" => __('Responsive Layouts', 'themerex'),
			"desc" => __('Do you want use responsive layouts on small screen or still use main layout?', 'themerex'),
			"id" => "responsive_layouts",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");
			
$THEMEREX_options[] = array( "title" => __('Additional filters in admin panel', 'themerex'),
			"desc" => __('Show additional filters (on post format and tags) in admin panel page "Posts"', 'themerex'),
			"id" => "admin_add_filters",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Enable Emailer in admin panel (menu Tools)', 'themerex'),
			"desc" => __('Allow to use ThemeREX Emailer for mass-volume e-mail distribution and management of mailing lists', 'themerex'),
			"id" => "admin_emailer",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Enable PO Composer in the admin panel', 'themerex'),
			"desc" => __('Allow to use "PO Composer" for edit language files in this theme (in the "Appearance - PO Composer")', 'themerex'),
			"id" => "admin_po_composer",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Use AJAX post views counter', 'themerex'),
			"desc" => __('Use javascript for post views count (if site work under the caching plugin) or increment views count in single page template', 'themerex'),
			"id" => "use_ajax_views_counter",
			"std" => "yes",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Compose scripts and styles in single file', 'themerex'),
			"desc" => __('Do you want to compose theme scripts and styles in single file (for speed up page loading)', 'themerex'),
			"id" => "compose_scripts",
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Custom scroller animation.', 'themerex'),
			"desc" => __('Remolds standard page scroll', 'themerex'),
			"id" => "custom_scroll",
			"divider" => false,
			"std" => "no",
			"options" => $yes_no,
			"type" => "switch");

$THEMEREX_options[] = array( "title" => __('Clear Wordpress cache', 'themerex'),
			"desc" => __('For example, it recommended after activating the WPML plugin - in the cache are incorrect data about the structure of categories and your site may display "white screen". After clearing the cache usually the performance of the site is restored.', 'themerex'),
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Clear cache', 'themerex'),
			"desc" => __('Clear Wordpress cache data', 'themerex'),
			"id" => "clear_cache",
			"divider" => false,
			"icon" => "iconadmin-trash-1",
			"action" => "clear_cache",
			"type" => "button");



//require_once('theme-settings-examples.php');


// Load current values for all theme options
load_theme_options();




//----------------------------------------------------------------------------------
// Load all theme options
//----------------------------------------------------------------------------------
function load_theme_options() {
	global $THEMEREX_options;
	$options = get_option('themerex_options', array());
	foreach ($THEMEREX_options as $k => $item) {
		if (isset($item['std'])) {
			if (isset($options[$item['id']]))
				$THEMEREX_options[$k]['val'] = $options[$item['id']];
			else
				$THEMEREX_options[$k]['val'] = $item['std'];
		}
	}
}


//----------------------------------------------------------------------------------
// Get custom options arrays (from current category, post, page, shop)
//----------------------------------------------------------------------------------
function load_custom_options() {
	// Theme custom settings from current post and category
	global $THEMEREX_cat_options, $THEMEREX_post_options, $THEMEREX_custom_options, $THEMEREX_shop_options, $wp_query;
	// Current post & category custom options
	$THEMEREX_post_options = $THEMEREX_cat_options = $THEMEREX_custom_options = $THEMEREX_shop_options = array();
	if (is_woocommerce_page() && ($page_id=get_option('woocommerce_shop_page_id'))>0)
		$THEMEREX_shop_options = get_post_meta($page_id, 'post_custom_options', true);
	if (is_category()) {
		$cat = (int) get_query_var( 'cat' );
		if (empty($cat)) $cat = get_query_var( 'category_name' );
		$THEMEREX_cat_options = get_category_inherited_properties($cat);
	} else if ((is_day() || is_month() || is_year()) && ($page_id=getTemplatePageId('archive'))>0) {
		$THEMEREX_post_options = get_post_meta($page_id, 'post_custom_options', true);
	} else if (is_search() && ($page_id=getTemplatePageId('search'))>0) {
		$THEMEREX_post_options = get_post_meta($page_id, 'post_custom_options', true);
	} else if (is_404() && ($page_id=getTemplatePageId('404'))>0) {
		$THEMEREX_post_options = get_post_meta($page_id, 'post_custom_options', true);
	} else if (function_exists('is_bbpress') && is_bbpress() && ($page_id=getTemplatePageId('bbpress'))>0) {
		$THEMEREX_post_options = get_post_meta($page_id, 'post_custom_options', true);
	} else if (function_exists('is_buddypress') && is_buddypress() && ($page_id=getTemplatePageId('buddypress'))>0) {
		$THEMEREX_post_options = get_post_meta($page_id, 'post_custom_options', true);
	} else if (is_attachment() && ($page_id=getTemplatePageId('attachment'))>0) {
		$THEMEREX_post_options = get_post_meta($page_id, 'post_custom_options', true);
	} else if (is_single() || is_page() || is_singular() || $wp_query->is_posts_page==1) {
		// Current post custom options
		$page_id = is_single() || is_page() ? get_the_ID() : (isset($wp_query->queried_object_id) ? $wp_query->queried_object_id : getTemplatePageId('blog'));
		$THEMEREX_post_options = get_post_meta($page_id, 'post_custom_options', true);
		$THEMEREX_cat_options = get_categories_inherited_properties(getCategoriesByPostId($page_id));
	}
}


//==========================================================================================
// Check option for inherit value
//==========================================================================================
function is_inherit_option($value) {
	while (is_array($value)) {
		foreach ($value as $val) {
			$value = $val;
			break;
		}
	}
	return themerex_strtolower($value)=='inherit';	//in_array(themerex_strtolower($value), array('default', 'inherit'));
}


//==========================================================================================
// Get theme option. If not exists - try get site option. If not exist - return default
//==========================================================================================
function get_theme_option($option_name, $default = false, $options = null) {
	global $THEMEREX_options;
	$val = false;
	if (is_array($options)) {
		foreach($options as $option) {
			if (isset($option['id']) && $option['id'] == $option_name) {
				$val = $option['val'];
				break;
			}
		}
	} else if (isset($THEMEREX_options)) {
		foreach($THEMEREX_options as $option) {
			if (isset($option['id']) && $option['id'] == $option_name) {
				$val = $option['val'];
				break;
			}
		}
	} else {
		$options = get_option('themerex_options', array());
		if (isset($options[$option_name])) {
			$val = $options[$option_name];
		}
	}
	if ($val === false) {
		if (($val = get_option($option_name, false)) !== false) {
			return $val;
		} else {
			return $default;
		}
	} else {
		return $val;
	}
}

//================================================================================================
// Return theme option attribute
//================================================================================================
function get_theme_options_attribute($option_id,$atribute){
	global $THEMEREX_options;
	$result = false;
	if (isset($THEMEREX_options)) {
		foreach($THEMEREX_options as $option) {
			if (isset($option['id']) && $option['id'] == $option_id) {
				$result = $option[$atribute];
				break;
			}
		}
		return $result;
	}
}


//================================================================================================
// Return property value from request parameters < post options < category options < theme options
//================================================================================================
function get_custom_option($name, $defa=null, $post_id=0, $cat_id=0) {
	if (isset($_GET[$name]))
		$rez = $_GET[$name];
	else {
		if ($cat_id > 0) {
			$rez = get_category_inherited_property($cat_id, $name);
			if ($rez=='') $rez = get_theme_option($name, $defa);
		} else if ($post_id > 0) {
			$rez = get_theme_option($name, $defa);
			$custom_options = get_post_meta($post_id, 'post_custom_options', true);
			if (isset($custom_options[$name]) && !is_inherit_option($custom_options[$name]))
				$rez = $custom_options[$name];
			else {
				if (is_category()) {
					$categories = array();
					$categories[] = get_queried_object();
				} else
					$categories =  getCategoriesByPostId($post_id);
				$tmp = '';
				for ($cc = 0; $cc < count($categories) && (empty($tmp) || is_inherit_option($tmp)); $cc++) {
					$tmp = get_category_inherited_property(is_object($categories[$cc]) ? $categories[$cc]->term_id : $categories[$cc]['term_id'], $name);
				}
				if ($tmp!='') $rez = $tmp;
			}
		} else {
			global $THEMEREX_post_options, $THEMEREX_cat_options, $THEMEREX_custom_options, $THEMEREX_shop_options;
			if (isset($THEMEREX_custom_options[$name])) {
				$rez = $THEMEREX_custom_options[$name];
			} else {
				$rez = get_theme_option($name, $defa);
				if (is_woocommerce_page() && isset($THEMEREX_shop_options[$name]) && !is_inherit_option($THEMEREX_shop_options[$name])) {
					$rez = is_array($THEMEREX_shop_options[$name]) ? $THEMEREX_shop_options[$name][0] : $THEMEREX_shop_options[$name];
				}
				if (!is_single() && isset($THEMEREX_post_options[$name]) && !is_inherit_option($THEMEREX_post_options[$name])) {
					$rez = is_array($THEMEREX_post_options[$name]) ? $THEMEREX_post_options[$name][0] : $THEMEREX_post_options[$name];
				}
				if (isset($THEMEREX_cat_options[$name]) && !is_inherit_option($THEMEREX_cat_options[$name])) {
					$rez = $THEMEREX_cat_options[$name];
				}
				if (is_single() && isset($THEMEREX_post_options[$name]) && !is_inherit_option($THEMEREX_post_options[$name])) {
					$rez = is_array($THEMEREX_post_options[$name]) ? $THEMEREX_post_options[$name][0] : $THEMEREX_post_options[$name];
				}
				if (get_theme_option('show_theme_customizer') == 'yes') {
					$tmp = getValueGPC($name, $rez);
					if (!is_inherit_option($tmp))
						$rez = $tmp;
				}
				$THEMEREX_custom_options[$name] = $rez;
			}
		}
	}
	return $rez;
}



//==========================================================================================
// Check if theme options are now used
//==========================================================================================
function is_themerex_options_used() {
	return is_admin() && (
		(isset($_REQUEST['action']) && $_REQUEST['action']=='themerex_options_save') ||
		(themerex_strpos($_SERVER['REQUEST_URI'], 'themerex_options')!==false) ||
		(themerex_strpos($_SERVER['REQUEST_URI'], 'post-new.php')!==false) ||
		(themerex_strpos($_SERVER['REQUEST_URI'], 'post.php')!==false) ||
		(themerex_strpos($_SERVER['REQUEST_URI'], 'edit-tags.php')!==false && themerex_strpos($_SERVER['REQUEST_URI'], 'taxonomy=category')!==false)
	);
}


//-----------------------------------------------------------------------------------
// Add 'Theme options' in Admin Interface
//-----------------------------------------------------------------------------------
add_action('admin_menu', 'themerex_options_admin_menu_item');
function themerex_options_admin_menu_item() {
	// In this case menu item "T-REX Options" add in root admin menu level
	//$tt_page = add_menu_page(__('T-REX Options', 'themerex'), __('<span class="iconadmin-cog-alt"></span> T-REX Options', 'themerex'), 'manage_options', 'themerex_options', 'themerex_options_page');

	// In this case menu item "T-REX Options" add in admin menu 'Appearance'
	$tt_page = add_theme_page(__('T-REX Options', 'themerex'), __('<span class="iconadmin-cog-alt"></span> T-REX Options', 'themerex'), 'edit_theme_options', 'themerex_options', 'themerex_options_page');

	// In this case menu item "Theme Options" add in admin menu 'Settings'
	//$tt_page = add_options_page(__('ThemeREX Options', 'themerex'), __('<span class="iconadmin-cog-alt"></span> ThemeREX Options', 'themerex'), 'manage_options', 'themerex_options', 'themerex_options_page');
}
?>
