<?php
//###############################
//#### Fields examples       #### 
//###############################
$THEMEREX_options[] = array( "title" => __('EXAMPLES', 'themerex'),
			"id" => "partition_examples",
			"type" => "partition");

$THEMEREX_options[] = array( "title" => __('Standard input fields', 'themerex'),
			"start" => "example_tabs",
			"id" => "example_standard",
			"icon" => "iconadmin-edit",
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Input fields', 'themerex'),
			"desc" => __('Examples for standard html input fields', 'themerex'),
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Date picker (popup)', 'themerex'),
			"id" => "field_datepicker",
			"std" => "14-12-01",
			"format" => "yy-mm-dd",
			"type" => "date");

$THEMEREX_options[] = array( "title" => __('Date picker (inline)', 'themerex'),
			"id" => "field_datepicker2",
			"std" => "01.12.2014",
			"format" => "dd.mm.yy",
			"months" => 3,
			"style" => "inline",
			"type" => "date");

$THEMEREX_options[] = array( "title" => __('Text field (standard)', 'themerex'),
			"id" => "field_text",
			"divider" => false,
			"std" => "",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Text field (masked)', 'themerex'),
			"id" => "field_text_mask",
			"divider" => false,
			"mask" => "(999) 999-99-99",
			"std" => "",
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Text field (iconed)', 'themerex'),
			"id" => "field_text_icon_1",
			"std" => "",
			"divider" => false,
			"before" => array('icon'=>'iconadmin-cog'),
			"type" => "text");

$THEMEREX_options[] = array(
			"id" => "field_text_icon_2",
			"std" => "",
			"divider" => false,
			"before" => array('icon'=>'iconadmin-info'),
			"after" => array('icon'=>'iconadmin-heart-1'),
			"type" => "text");

$THEMEREX_options[] = array(
			"desc" => __('Standard text fields', 'themerex'),
			"id" => "field_text_icon_3",
			"std" => "",
			"before" => array('icon'=>'iconadmin-comment'),
			"after" => array('title'=>__('Choose image', 'themerex')),
			"type" => "text");

$THEMEREX_options[] = array( "title" => __('Spinner field', 'themerex'),
			"desc" => __('Spinner field', 'themerex'),
			"id" => "field_spinner",
			"std" => "",
			"increment" => 5,
			"min" => 0,
			"max" => 55,
			"type" => "spinner");

$THEMEREX_options[] = array( "title" => __('Text area', 'themerex'),
			"id" => "field_textarea",
			"std" => "",
			"rows" => 8,
			"cols" => 50,
			"type" => "textarea");

$THEMEREX_options[] = array( "title" => __('Tags field', 'themerex'),
			"desc" => __('Tags field (autoadd tags buttons)', 'themerex'),
			"id" => "field_tags",
			"std" => "vasya, petya",
			"type" => "tags");

$THEMEREX_options[] = array( "title" => __('Select field', 'themerex'),
			"desc" => __('Substitute standard select field', 'themerex'),
			"id" => "example_select",
			"std" => "excerpt",
			"type" => "select",
			"options" => $blog_styles);

$THEMEREX_options[] = array( "title" => __('List field', 'themerex'),
			"desc" => __('Substitute standard list field', 'themerex'),
			"id" => "example_list",
			"std" => "one",
			"type" => "list",
			"options" => array('one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten'));

$THEMEREX_options[] = array( "title" => __('List field with range values', 'themerex'),
			"desc" => __('Substitute standard range field', 'themerex'),
			"id" => "example_list_range",
			"std" => "5",
			"type" => "list",
			"style" => "list",
			"multiple" => true,
			"step" => 3,
			"from" => 3,
			"to" => 33);

$THEMEREX_options[] = array( "title" => __('Range field', 'themerex'),
			"desc" => __('Range Selector', 'themerex'),
			"id" => "example_range",
			"type" => "range",
			"std" => "55,80",
			"step" => 1,
			"min" => 50,
			"max" => 100);

$THEMEREX_options[] = array( "title" => __('Checkbox', 'themerex'),
			"id" => "field_checkbox1",
			"std" => "",
			"label" => __('Pinapple', 'themerex'),
			"type" => "checkbox");

$THEMEREX_options[] = array( "title" => __('Radio buttons', 'themerex'),
			"desc" => __('Standard radio buttons', 'themerex'),
			"id" => "field_radio",
			"std" => "val2",
			"type" => "radio",
			"options" => array('val1'=>'Title 1', 'val2'=>'Title 2', 'val3'=>'Title 3'));

$THEMEREX_options[] = array( "title" => __('Radio buttons (vertical)', 'themerex'),
			"desc" => __('Standard radio buttons with vertical direction', 'themerex'),
			"id" => "field_radio2",
			"std" => "val3",
			"type" => "radio",
			"dir" => "vertical",
			"options" => array('val1'=>'Title 1', 'val2'=>'Title 2', 'val3'=>'Title 3'));

$THEMEREX_options[] = array( "title" => __('Checklist (horizontal)', 'themerex'),
			"desc" => __('Horizontal checklist', 'themerex'),
			"id" => "field_checklist",
			"std" => "val2",
			"type" => "checklist",
			"options" => array('val1'=>'Title 1', 'val2'=>'Title 2', 'val3'=>'Title 3'));

$THEMEREX_options[] = array( "title" => __('Checklist (vertical)', 'themerex'),
			"desc" => __('Vertical checklist', 'themerex'),
			"id" => "field_checklist2",
			"std" => "val2",
			"dir" => "vertical",
			"multiple" => true,
			"size" => "medium",
			"type" => "checklist",
			"options" => array('val1'=>'Title 1', 'val2'=>'Title 2', 'val3'=>'Title 3'));

$THEMEREX_options[] = array( "title" => __('Switch button', 'themerex'),
			"id" => "field_switch",
			"std" => "",
			"divider" => false,
			"type" => "switch",
			"size" => "small",
			"options" => array('on'=>'ON', 'off'=>'OFF'));

$THEMEREX_options[] = array(
			"id" => "field_switch2",
			"std" => "hide",
			"divider" => false,
			"type" => "switch",
			"size" => "medium",
			"options" => array('show'=>'SHOW', 'hide'=>'HIDE'));

$THEMEREX_options[] = array(
			"desc" => __('Switch button (switcher with two positions)', 'themerex'),
			"id" => "field_switch3",
			"std" => "",
			"type" => "switch",
			"size" => "big",
			"options" => array('slider'=>'SLIDER', 'gallery'=>'GALLERY'));

$THEMEREX_options[] = array( "title" => __('Color selection',  'themerex'),
			"desc" => __('Field for color selection',  'themerex'),
			"id" => "example_color",
			"std" => "#ff5555",
			"type" => "color");



$THEMEREX_options[] = array( "title" => __('Images & icons', 'themerex'),
			"id" => "example_images",
			"icon" => "iconadmin-picture",
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Image selector (as list)',  'themerex'),
			"desc" => __('Select theme background pattern (first case - without pattern)',  'themerex'),
			"id" => "example_images_1",
			"std" => "",
			"type" => "images",
			"style" => "list",
			"multiple" => true,
			"options" => array(
				0 => get_template_directory_uri().'/images/spacer.png',
				1 => get_template_directory_uri().'/images/bg/pattern_1.png',
				2 => get_template_directory_uri().'/images/bg/pattern_2.png',
				3 => get_template_directory_uri().'/images/bg/pattern_3.png',
				4 => get_template_directory_uri().'/images/bg/pattern_4.png',
				5 => get_template_directory_uri().'/images/bg/pattern_5.png',
			));

$THEMEREX_options[] = array( "title" => __('Image selector (as dropdown)',  'themerex'),
			"desc" => __('Select theme background image (first case - without image)',  'themerex'),
			"id" => "example_images_2",
			"std" => "",
			"type" => "images",
			"options" => array(
				0 => get_template_directory_uri().'/images/spacer.png',
				1 => get_template_directory_uri().'/images/bg/image_1_thumb.jpg',
				2 => get_template_directory_uri().'/images/bg/image_2_thumb.jpg',
				3 => get_template_directory_uri().'/images/bg/image_3_thumb.jpg',
			));

$THEMEREX_options[] = array( "title" => __('Social icons (images)',  'themerex'),
			"desc" => __('Select icon for the desired social network',  'themerex'),
			"id" => "example_icons_1",
			"std" => "",
			"type" => "images",
			"size" => "medium",
			"options" => $socials);

$THEMEREX_options[] = array( "title" => __('Social icons (fontello)',  'themerex'),
			"desc" => __('Select icon for the desired social network',  'themerex'),
			"id" => "example_icons_2",
			"std" => "",
			"type" => "icons",
			"options" => $icons);

$THEMEREX_options[] = array( "title" => __('Social links (cloneable)', 'themerex'),
			"desc" => __('Field for social network url and icon', 'themerex'),
			"id" => "example_social",
			"std" => array('url'=>'', 'icon'=>''),
			"style" => 'images',
			"size" => "small",
			"type" => "socials",
			"cloneable" => true,
			"options" => $socials);

$THEMEREX_options[] = array( "title" => __('Upload image', 'themerex'),
			"desc" => __('Field for select image from WP library', 'themerex'),
			"id" => "field_media",
			"std" => "http://fw.wp/wp-content/uploads/2013/12/pics_movies.jpg",
			"before" => array(	'title' => __('Choose image', 'themerex'),
								'action' => 'media_upload',
								'multiple' => false,
								'linked_field' => '',
								'captions' => array('choose' => __( 'Choose Image', 'themerex'),
													'update' => __( 'Select Image', 'themerex')
												)
						),
			"after" => array(	'icon'=>'iconadmin-cancel',
								'action'=>'media_reset'
						),
			"type" => "media");

$THEMEREX_options[] = array( "title" => __('Combine text with button', 'themerex'),
			"id" => "field_upload_text",
			"divider" => false,
			"std" => "",
			"type" => "textarea");

$THEMEREX_options[] = array( 
			"desc" => __('Field for select image from WP library with separate button', 'themerex'),
			"id" => "field_upload_button",
			'title' => __('Choose images', 'themerex'),
			'action' => 'media_upload',
			'multiple' => true,
			'icon' => 'iconadmin-cog',
			'linked_field' => "field_upload_text",
			'captions' => array('choose' => __( 'Select images', 'themerex'),
								'update' => __( 'Update gallery', 'themerex')
						),
			"type" => "button");



$THEMEREX_options[] = array( "title" => __('Groups', 'themerex'),
			"id" => "example_groups",
			"icon" => "iconadmin-docs",
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Group fields', 'themerex'),
			"start" => "example_group",
			"id" => "example_group_standard",
			"icon" => "iconadmin-cog",
			"divider" => false,
			"type" => "group");

	$THEMEREX_options[] = array( "title" => __('Checkbox', 'themerex'),
				"id" => "example_field_checkbox1",
				"std" => "",
				"divider" => false,
				"label" => __('Pinapple', 'themerex'),
				"type" => "checkbox");
	$THEMEREX_options[] = array(
				"id" => "example_field_checkbox2",
				"std" => "true",
				"divider" => false,
				"label" => __('Orange', 'themerex'),
				"type" => "checkbox");
	$THEMEREX_options[] = array(
				"desc" => __('Standard checkbox field', 'themerex'),
				"id" => "example_field_checkbox3",
				"divider" => false,
				"std" => "",
				"label" => __('Plum', 'themerex'),
				"type" => "checkbox");

$THEMEREX_options[] = array(
			"end" => true,
			"type" => "group");

$THEMEREX_options[] = array( "title" => __('Tab1 title', 'themerex'),
			"start" => 'example_group_tabs',
			"id" => 'example_tab1',
			"icon" => 'iconadmin-window',
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Show Breadcrumbs', 'themerex'),
			"desc" => __('Show path to current category (post, page)', 'themerex'),
			"id" => "example_show_breadcrumbs",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$THEMEREX_options[] = array( "title" => __('Tab2 title', 'themerex'),
			"id" => 'example_tab2',
			"icon" => 'iconadmin-air',
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Blog style', 'themerex'),
			"desc" => __('Select desired blog style', 'themerex'),
			"id" => "example_blog_style",
			"std" => "excerpt",
			"type" => "select",
			"options" => $blog_styles);

$THEMEREX_options[] = array(
			"end" => true,
			"type" => "tab");

$THEMEREX_options[] = array( "title" => __('Accordion 1 title', 'themerex'),
			"start" => 'example_accordion',
			"id" => 'example_accordion1',
			"icon" => 'iconadmin-window',
			"type" => "accordion");

$THEMEREX_options[] = array( "title" => __('Show Breadcrumbs', 'themerex'),
			"desc" => __('Show path to current category (post, page)', 'themerex'),
			"id" => "example_show_breadcrumbs2",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$THEMEREX_options[] = array( "title" => __('Accordion 2 title', 'themerex'),
			"id" => 'example_accordion2',
			"icon" => 'iconadmin-air',
			"type" => "accordion");

$THEMEREX_options[] = array( "title" => __('Blog style', 'themerex'),
			"desc" => __('Select desired blog style', 'themerex'),
			"id" => "example_blog_style2",
			"std" => "excerpt",
			"type" => "select",
			"options" => $blog_styles);

$THEMEREX_options[] = array(
			"end" => true,
			"type" => "accordion");

$THEMEREX_options[] = array( "title" => __('Toggle 1 title', 'themerex'),
			"id" => 'example_toggle1',
			"icon" => 'iconadmin-window',
			"type" => "toggle");

$THEMEREX_options[] = array( "title" => __('Show Breadcrumbs', 'themerex'),
			"desc" => __('Show path to current category (post, page)', 'themerex'),
			"id" => "example_show_breadcrumbs3",
			"std" => "yes",
			"type" => "radio",
			"options" => $yes_no);

$THEMEREX_options[] = array(
			"end" => true,
			"type" => "toggle");

$THEMEREX_options[] = array( "title" => __('Toggle 2 title', 'themerex'),
			"id" => 'example_toggle2',
			"icon" => 'iconadmin-air',
			"closed" => true,
			"type" => "toggle");

$THEMEREX_options[] = array( "title" => __('Blog streampage parameters', 'themerex'),
			"desc" => __('Select desired blog streampage parameters (you can override it in each category)', 'themerex'),
			"type" => "info");

$THEMEREX_options[] = array( "title" => __('Blog style', 'themerex'),
			"desc" => __('Select desired blog style', 'themerex'),
			"id" => "example_blog_style3",
			"std" => "excerpt",
			"type" => "select",
			"options" => $blog_styles);
?>