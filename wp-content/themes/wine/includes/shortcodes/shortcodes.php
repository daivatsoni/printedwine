<?php
/**
 * ThemeREX Shortcodes
*/

require_once( 'shortcodes_settings.php' );

if (class_exists('WPBakeryShortCode')) {
	require_once( 'vc/shortcodes_vc.php' );
}


// ---------------------------------- [toggles / accordion] ---------------------------------------

// [trx_toggles type ="toggles|accordion" id="sc_toggles|accordion_ID" initial="1-num" style="1|2|3" icon="left|right|off" ]
// 		[trx_toggles_item title="Et adipiscing integer, scelerisque pid"] toggle text [/toggles_item]
// 		[trx_toggles_item title="A pulvinar ut, parturient enim porta"] toggle text [/toggles_item]
// 		[trx_toggles_item title="Duis sociis, elit odio dapibus nec"] toggle text [/toggles_item]
// 		[trx_toggles_item title="Nec purus, cras tincidunt rhoncus"] toggle text [/toggles_item]
// [/trx_toggles]

add_shortcode('trx_toggles', 'sc_toggles');

$THEMEREX_sc_toggle_counter = 0;
$THEMEREX_sc_toggle_style = 1;
$THEMEREX_sc_toggle_show_counter = false;
function sc_toggles($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"type" => "toggles",
		"style" => "1",
		"counter" => "off",
		"initial" => "1",
		"icon" => "right",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
    $counter_position = (($counter != 'off' && $icon != 'off') ? $icon == 'left' ? 'right' : 'left' : '');
    $initial = max(0, (int) $initial);
	$c = 'sc_'.$type.'_init'
		.' sc_toggl'
		.' sc_toggl_style_'.$style
		.($icon != 'off' ? ' sc_toggl_icon_show sc_toggl_icon_'.$icon : '')
		.($counter != 'off' ? ' sc_toggl_counter_show sc_toggl_counter_'.$counter_position : '');
	$s = ($top !== '' ? ' margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? ' margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? ' margin-left:'.$left.'px;' : '')
		.($right !== '' ? ' margin-right:'.$right.'px;' : '');
	global $THEMEREX_sc_toggle_counter, $THEMEREX_sc_toggle_type, $THEMEREX_sc_toggle_style,  $THEMEREX_sc_toggle_show_counter;
	$THEMEREX_sc_toggle_counter = 0;
	$THEMEREX_sc_toggle_type = $type;
	$THEMEREX_sc_toggle_style = max(1, min(3, $style));
	$THEMEREX_sc_toggle_show_counter = sc_param_is_on($counter);
	if($type == 'toggles'){
		themerex_enqueue_script('jquery-effects-slide', false, array('jquery','jquery-effects-core'), null, true);
	} else if($type == 'accordion') {
		themerex_enqueue_script('jquery-ui-accordion', false, array('jquery','jquery-ui-core'), null, true);
	}

	return '<div'.($id ? ' id="sc_'.$type.'_'.$id.'"' : '').($c!='' ? ' class="'.$c. '"' : '').($s!='' ? ' style="'.$s.'"' : '').' data-active="'.($initial-1).'" >'
			.do_shortcode($content)
			.'</div>';
}


add_shortcode('trx_toggles_item', 'sc_toggles_item');

//[trx_toggles_item]
function sc_toggles_item($atts, $content=null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts( array(
		"id" => "",
		"title" => "",
		"open" => ""
	), $atts));
	global $THEMEREX_sc_toggle_counter, $THEMEREX_sc_toggle_show_counter, $THEMEREX_sc_toggle_type;
	$THEMEREX_sc_toggle_counter++;
	$c = ($THEMEREX_sc_toggle_counter % 2 == 1 ? ' odd' : ' even') 
		.($THEMEREX_sc_toggle_counter == 1 ? ' first' : '');
	return '<div'.($id ? ' id="sc_'.$THEMEREX_sc_toggle_type.'_'.$id.'"' : '').' class="sc_toggl_item'.(sc_param_is_on($open) && $THEMEREX_sc_toggle_type == 'toggles' ? ' sc_active' : '').$c.'">'
				. '<h6 class="sc_toggl_title">'
				. ($THEMEREX_sc_toggle_show_counter ? '<span class="sc_items_counter">'.$THEMEREX_sc_toggle_counter.'</span>' : '').$title 
				. '</h6>'
				. '<div class="sc_toggl_content"'.(sc_param_is_on($open) ? ' style="display:block;"' : '').'>' 
				. do_shortcode($content) 
				. '</div>'
			. '</div>';
}
// ---------------------------------- [/toggles / accordion] ---------------------------------------



// ---------------------------------- [br] ---------------------------------------

// [trx_br clear="left|right|both"]

add_shortcode("trx_br", "sc_br");

function sc_br($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"clear" => ""
    ), $atts));
	return '<br'.(in_array($clear, array('left', 'right', 'both')) ? ' clear="'.$clear.'"' : '').' />';
}
// ---------------------------------- [/br] ---------------------------------------



// ---------------------------------- [blogger] ---------------------------------------

// [trx_blogger id="unique_id" ids="comma_separated_list" cat="category_id" orderby="date|views|comments" order="asc|desc" count="5" descr="0" dir="horizontal|vertical" style="regular|date|image_large|image_medium|image_small|accordion|list" border="0"]

add_shortcode('trx_blogger', 'sc_blogger');

$THEMEREX_sc_blogger_busy = false;
$THEMEREX_sc_blogger_counter = 0;
function sc_blogger($atts, $content=null){	
	if (in_shortcode_blogger(true)) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "regular",
		"filters" => "no",
		"ids" => "",
		"cat" => "",
		"indent" => "yes",
		"count" => "3",
		"visible" => "",
		"offset" => "",
		"orderby" => "date",
		"order" => "desc",
		"descr" => "0",
		"readmore" => "",
		"location" => "default",
		"dir" => "horizontal",
		"scroll" => "no",
		"rating" => "no",
		"info" => "yes",
		"ajax" => "yes",
		"width" => "-1",
		"height" => "-1",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
    $count = max(1,$count);
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '')
		.($width > 0 ? 'width:'.$width.$ed.';' : '')
		.($height > 0 ? 'height:'.$height.'px;' : '');

	$c = ' sc_blogger_'.($dir=='vertical' ? 'vertical' : 'horizontal')
		.' style_'.(in_array($style, array('accordion_1', 'accordion_2', 'accordion_3')) ? 'accordion' : (themerex_strpos($style, 'image')!==false ? 'image style_' : '').$style)
		.(in_array($style, array('accordion_1', 'accordion_2', 'accordion_3')) ? ' sc_toggl sc_accordion_init sc_toggl_icon_show sc_toggl_icon_right' : '')
		.($style == 'accordion_1' ? ' sc_toggl_style_1' : '')
		.($style == 'accordion_2' ? ' sc_toggl_style_2' : '')
		.($style == 'accordion_3' ? ' sc_toggl_style_3' : '')
		.(themerex_strpos($style, 'masonry')!==false || themerex_strpos($style, 'classic')!==false ? ' masonryWrap' : '')
		.(themerex_strpos($style, 'portfolio')!==false ? ' portfolioWrap' : '')
		.($style=='related' ? ' relatedPostWrap' : '')
		.($indent=='yes' ? ' sc_blogger_indent' : '');
	
	global $THEMEREX_sc_blogger_busy, $THEMEREX_sc_blogger_counter, $post;

	$THEMEREX_sc_blogger_busy = true;
	$THEMEREX_sc_blogger_counter = 0;

	if (!in_array($style, array('regular','date','image_large','image_medium','image_small','image_tiny','accordion_1','accordion_2','accordion_3','list','classic','masonry','excerpt','related',in_array(themerex_substr($style, 0, 7), array('portfol')))))
		$style='regular';	
	if (!empty($ids)) {
		$posts = explode(',', str_replace(' ', '', $ids));
		$count = count($posts);
	}
	if (in_array($style, array('accordion_1', 'accordion_2', 'accordion_3', 'list')))
		$dir = 'vertical';
	if ($visible <= 0) $visible = $count;

	if (sc_param_is_on($scroll) && empty($id)) $id = 'sc_blogger_'.str_replace('.', '', mt_rand());
	
	$output = ($style=='list' ? '<ul' : '<div')
			 .($id ? ' id="sc_blogger_'.$id.'"' : '') 
			 .' class="sc_blogger'.$c.'"'
			 .($s!='' ? ' style="'.$s.'"' : '')
		.'>'
		.($dir!='vertical' &&  $count>1 && !in_array(themerex_substr($style, 0, 7), array('portfol')) ? '<div class="sc_columns_'.$visible.($indent=='yes' ? ' sc_columns_indent' : '').($style == 'related' ? ' postBox' : '').' ">' : '')
		.(sc_param_is_on($scroll) 
			? '<div id="'.$id.'_scroll" class="sc_scroll sc_scroll_'.$dir.' swiper-container scroll-container"'
				.' style="'.($dir=='vertical' ? 'height:'.($height > 0 ? $height : "230").'px;' : 'width:'.($width > 0 ? $width.'px;' : "100%;")).'"'
				.'>'
				.'<div class="sc_scroll_wrapper swiper-wrapper">' 
			: '');
	if (themerex_strpos($style, 'masonry')!==false || themerex_strpos($style, 'classic')!==false) {
		$output .= '<section class="masonry '.(sc_param_is_on($filters) ? 'isotope' : 'isotopeNOamin').'" data-columns="'.themerex_substr($style, -1).'">';
	}

	//portfolio
	if ( in_array(themerex_substr($style, 0, 7), array('portfol')) ) {
		$folio_size = array(
			'portfolio_mini' => '300', 
			'portfolio_medium' => '450', 
			'portfolio_big' => '600'
		);

		$output .= '<div class="masonryWrap"><section class="masonryStyle isotopeWrap '.($ajax == 'yes' ? ' singeAjaxLoad ' : '').$style.'" data-foliosize="'.$folio_size[$style].'">';
		$output .= sc_param_is_on($filters) ? '<div class="isotopeFiltr"></div>' : '';
	}


	$args = array(
		'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
		'posts_per_page' => $count,
		'ignore_sticky_posts' => 1,
		'order' => $order=='asc' ? 'asc' : 'desc',
		'orderby' => 'date',
	);

	if ($offset > 0 && empty($ids)) {
		$args['offset'] = $offset;
	}

	$args = addSortOrderInQuery($args, $orderby, $order);
	$args = addPostsAndCatsInQuery($args, $ids, $cat);

	$query = new WP_Query( $args );

	while ( $query->have_posts() ) { 
		$query->the_post();
		$THEMEREX_sc_blogger_counter++;
		$output .= showPostLayout(
			array(
				'layout' => in_array(themerex_substr($style, 0, 7), array('classic', 'masonry', 'portfol', 'excerpt', 'related')) ? themerex_substr($style, 0, 7) : 'blogger',
				'show' => false,
				'number' => $THEMEREX_sc_blogger_counter,
				'add_view_more' => false,
				'posts_on_page' => $count,
				"reviews" => sc_param_is_on($rating),
				'thumb_size' => $style,
				'thumb_crop' => themerex_strpos($style, 'masonry')===false,
				'strip_teaser' => false,
				// Additional options to layout generator
				"location" => $location,
				"descr" => $descr,
				"readmore" => $readmore,
				"dir" => $dir,
				"scroll" => sc_param_is_on($scroll),
				"info" => sc_param_is_on($info),
				"orderby" => $orderby,
				"posts_visible" => $visible,
				"categories_list" => in_array($style, array('excerpt','related')),
				"tags_list" => false
			)
		);

	}

	wp_reset_postdata();

	if (themerex_strpos($style, 'masonry')!==false || themerex_strpos($style, 'classic')!==false) {
		$output .= '</section>';
	}

	if ( in_array(themerex_substr($style, 0, 7), array('portfol')) ) {
		$output .= '</section></div>';
	}

	$output	.= (sc_param_is_on($scroll) ? '</div><div id="sc_blogger_'.$id.'_scroll_bar" class="sc_scroll_bar sc_scroll_bar_'.$dir.' '.$id.'_scroll_bar"></div></div>' : '')
		. ($dir!='vertical' &&  $count>1 && !in_array(themerex_substr($style, 0, 7), array('portfol'))  ? '</div>' : '')
		. ($style == 'list' ? '</ul>' : '</div>');
	if (in_array($style, array('accordion_1', 'accordion_2'))) {
		themerex_enqueue_script('jquery-ui-accordion', false, array('jquery','jquery-ui-core'), null, true);
	}
	
	$THEMEREX_sc_blogger_busy = false;
	
	return $output;
}

function in_shortcode_blogger($from_blogger = false) {
	if (!$from_blogger) return false;
	global $THEMEREX_sc_blogger_busy;
	return $THEMEREX_sc_blogger_busy;
}
// ---------------------------------- [/blogger] ---------------------------------------



// ---------------------------------- [button] ---------------------------------------

// [trx_button skin="dark" style="line" size="mini" fullsize="yes" icon="icon-flaticon_11101" align="center" popup="no"][/button]

add_shortcode('trx_button', 'sc_button');

function sc_button($atts, $content = null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		'text' => "Button",
		"skin" => "dark",
		"style" => "bg",
		"size" => "medium",
		"title" => "",
		"fullsize" => "0",
		"icon" => "",
		"background" => "",
		"color" => "",
		"link" => "",
		"target" => "",
		"align" => "",
		"rel" => "",
		"popup" => "no",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
    $s = ($background !== '' ? ' background-color:'.$background.';' : '')
    	.($color !== '' ? ' color:'.$color.';' : '')
    	.($top !== '' ? ' margin-top:'.$top.'px;' : '')
		.($left !== '' ? ' margin-left:'.$left.'px;' : '')
		.($bottom !== '' ? ' margin-bottom:'.$bottom.'px;' : '')
		.($right !== '' ? ' margin-right:'.$right.'px;' : '')
		.($width !== '' ? ' width:'.$width.'px;' : '')
    	.($height !== '' ? ' height:'.$height.'px;' : '');
    $style_batton = $s ? ' style="'.$s.'" ': '';

    $c = ($skin = ' sc_button_skin_'.$skin)
    	.($style = ' sc_button_style_'.$style)
    	.($size = ' sc_button_size_'.$size)
    	.($align && $align!='none' ? ' align_'.$align : '')
    	.(sc_param_is_on($fullsize) ? ' sc_button_full_size' : '')
    	.(sc_param_is_on($popup) ? ' user-popup-link' : '')
    	.($icon!='' ? ' ico '.$icon : '');
    $class_batton = $c ? ' class="sc_button '.$c.'" ' : '';

    return ($align == 'center' ? '<div class="sc_button_wrap">' : '').'<a'.($id ? ' id="'.$id.'"' : '').($title ? ' title="'.$title.'"' : '').' href="'.(empty($link) ? '#' : ($popup == 'yes' ? '#sc_popup_'.$link : $link)).'" '.$style_batton.$class_batton.(sc_param_is_on($target) ? ' target="_blank"' : '').(!empty($rel) ? ' rel="'. $rel.'"' : '').'>'.$text.'</a>'.($align == 'center' ? '</div>' : '');

}

// ---------------------------------- [/button] ---------------------------------------



// ---------------------------------- [chat] ---------------------------------------

add_shortcode('trx_chat', 'sc_chat');

function sc_chat($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"title" => "",
		"link" => "",
		"width" => "-1",
		"height" => "-1",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '')
		.($width > 0 ? 'width:'.$width.$ed.';' : '')
		.($height > 0 ? 'height:'.$height.'px;' : '')
		;
	$title = $title=='' ? $link : $title;
	$content = do_shortcode($content);
	if (themerex_substr($content, 0, 2)!='<p') $content = '<p>'.$content.'</p>';
	return '<div'.($id ? ' id="sc_chat_'.$id.'"' : '').' class="sc_chat"'.($s ? ' style="'.$s.'"' : '').'>'
		.($title == '' ? '' : ('<div class="sc_quote_title">'.($link!='' ? '<a href="'.$link.'">' : '').$title.':'.($link!='' ? '</a>' : '').'</div>'))
		.'<div class="sc_chat_content">'.$content.'</div>'
		.'</div>';
}
// ---------------------------------- [/chat] ---------------------------------------




// ---------------------------------- [columns] ---------------------------------------

// [trx_columns id="unique_id" count="number" indent="yes|no" top="" right="" bottom="" left="" ]
// 		[trx_column_item] columns content [/column_item]
// 		[trx_column_item] columns content [/column_item]
// 		[trx_column_item] columns content [/column_item]
// 		[trx_column_item] columns content [/column_item]
// [/trx_columns]

add_shortcode('trx_columns', 'sc_columns');

function sc_columns($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"columns" => "2",
		"indent" => "yes",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

	global $THEMEREX_sc_columns, $THEMEREX_sc_columns_count, $THEMEREX_sc_columns_prefix, $THEMEREX_sc_columns_after;

    $prefix = ' sc_columns';
    $columns = max(1, min(12, (int) $columns));
    $THEMEREX_sc_columns = $columns;
    $THEMEREX_sc_columns_count = 1;
    $THEMEREX_sc_columns_after = '';
    $THEMEREX_sc_columns_prefix = $prefix;

	$s = ($top !== '' ? ' margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? ' margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? ' margin-left:' . $left . 'px;' : '')
		.($right !== '' ? ' margin-right:' . $right . 'px;' : '');

	$c = ($prefix.'_'.$columns)
		.($indent === 'yes' ? $prefix.'_indent' : '');

	return '<div'.($id ? ' id="'.$prefix.'_'.$id.'"' : '').' class="'.$prefix.' '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '').'>'.do_shortcode($content).'</div>';
}


//[column_item id="unique_id" colspan="2..11"]

add_shortcode('trx_column_item', 'sc_column_item');

function sc_column_item($atts, $content=null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts( array(
		"id" => "",
		"colspan" => "1"
	), $atts));
	global $THEMEREX_sc_columns, $THEMEREX_sc_columns_count, $THEMEREX_sc_columns_prefix, $THEMEREX_sc_columns_after;
	$prefix = $THEMEREX_sc_columns_prefix;
	$colspan = max(1, min(11, (int) $colspan));
	$c = ($prefix.'_item_coun_'.$THEMEREX_sc_columns_count)
		.($colspan > 1 ? ' colspan_'.$colspan : '')
		.(!empty($THEMEREX_sc_columns_after) ? $THEMEREX_sc_columns_after : '' )
		.($THEMEREX_sc_columns_count % 2 == 1 ? ' odd' : ' even')
		.($THEMEREX_sc_columns_count == 1 ? ' first' : '');
	
	$THEMEREX_sc_columns_count += 1 ;
	$THEMEREX_sc_columns_after = $colspan > 1 ? ' colspan_'.$colspan.'_after' : '';

	return '<div'.($id ? ' id="'.$prefix.'_item_'.$id.'"' : '').' class="'.$prefix.'_item '.$c.'">'.do_shortcode($content).'</div>';

}

// ---------------------------------- [/columns] ---------------------------------------





// ---------------------------------- [Contact form] ---------------------------------------

//[trx_contact_form id="unique_id" title="Contact Form" description="Mauris aliquam habitasse magna a arcu eu mus sociis? Enim nunc? Integer facilisis, et eu dictumst, adipiscing tempor ultricies, lundium urna lacus quis."]

add_shortcode('trx_contact_form', 'sc_contact_form');

function sc_contact_form($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"id" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '')
		;
	themerex_enqueue_script( 'form-contact', get_template_directory_uri().'/js/_form_contact.js', array('jquery'), null, true );
	global $THEMEREX_ajax_nonce, $THEMEREX_ajax_url;
	return '<div '.($id ? ' id="sc_contact_form_'.$id.'"' : '').'class="sc_form" data-formtype="contact" '.($s!='' ? ' style="'.$s.'"' : '') .'>'
			.'<form'.($id ? ' id="'.$id.'"' : '').' method="post" action="'.$THEMEREX_ajax_url.'">'
				.'<div class="sc_columns_3 sc_columns_indent">'
					.'<div class="sc_columns_item sc_form_username">'
						.'<label class="required" for="sc_form_contact_username">'.__('Name', 'themerex').'</label><input id="sc_form_contact_username" type="text" name="username">'
					.'</div>'
					.'<div class="sc_columns_item sc_form_email">'
						.'<label class="required" for="sc_form_contact_email">'.__('E-mail', 'themerex').'</label><input id="sc_form_contact_email" type="text" name="email">'
					.'</div>'
					.'<div class="sc_columns_item sc_form_subj">'
						.'<label for="sc_form_contact_subj">'.__('Subject', 'themerex').'</label><input id="sc_form_contact_subj" type="text" name="subject">'
					.'</div>'
				.'</div>'
				.'<div class="sc_form_message">'
					.'<label class="required" for="sc_form_contact_message">'.__('Your Message', 'themerex').'</label><textarea id="sc_form_contact_message" class="textAreaSize" name="message"></textarea>'
				.'</div>'
				.'<div class="sc_form_button">'
					.do_shortcode('[trx_button skin="dark" style="bg" link="#" size="medium" fullsize="no" target="no" popup="no" text="'.__('Send Message', 'themerex').'"]')
				.'</div>'
				.'<div class="sc_result sc_infobox sc_infobox_closeable"></div>'
			.'</form>'
		.'</div>';
}
// ---------------------------------- [/Contact form] ---------------------------------------




// ---------------------------------- [Contact info] ---------------------------------------


add_shortcode('trx_contact_info', 'sc_contact_info');

function sc_contact_info($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"id" => "",
		"contact_list" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '');

 	$contact_list  = explode(',', $contact_list);

 	$list_title = array(
 		"email" 	=> __('Email','themerex'),
 		"address_1" => __('Adress','themerex'),
 		"address_2" => __('Adress','themerex'),
 		"phone_1" 	=> __('Phone','themerex'),
 		"phone_2" 	=> __('Phone','themerex'),
 		"fax" 		=> __('Fax','themerex'),
 		"website" 	=> __('Website','themerex')
 	);

 	$list_data = '';
	foreach ( $contact_list as $contact_lists  ) {
		$list_data .= '<div class="sc_contact_info_item sc_contact_'.$contact_lists.'">
			<h5 class="sc_contact_info_lable">'.$list_title[$contact_lists].':</h5><b>'
			.get_theme_option('contact_'.$contact_lists).'</b></div>';
	}

	return '<div '.($id ? ' id="sc_contact_info_'.$id.'"' : '').'class="sc_contact_info" '.($s!='' ? ' style="'.$s.'"' : '') .'>'
			.'<div class="sc_contact_info_wrap">'.$list_data.'</div>'
		.'</div>';
}
// ---------------------------------- [/Contact info] ---------------------------------------



// ---------------------------------- [Countdown] ---------------------------------------

// [trx_countdown date="" time=""]

add_shortcode('trx_countdown', 'sc_countdown');

function sc_countdown($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"id" => "",
		"date" => "",
		"time" => "",
		"align" => "",
		"style" => "round",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '')
		.($width > 0 ? 'width:'.$width.$ed.';' : '')
		.($height > 0 ? 'height:'.$height.'px;' : '');
	$c = ($align && $align!='none' ? ' align'.$align : '')
		.($style == 'flip' ? ' sc_countdown_flip' : ' sc_countdown_round');

	if($style == 'flip'){
		themerex_enqueue_style( 'flipclock-style', get_template_directory_uri().'/js/flipclock/flipclock.css', array(), null );
		themerex_enqueue_script( 'flipclock', get_template_directory_uri().'/js/flipclock/flipclock.custom.js', array(), null, true );
	} else {
		themerex_enqueue_script( 'countdown-plugin', get_template_directory_uri().'/js/countdown/jquery.countdown-plugin.min.js', array(), null, true );
		themerex_enqueue_script( 'countdown', get_template_directory_uri().'/js/countdown/jquery.countdown.min.js', array(), null, true );
		
	}

	return '<div '.($id ? ' id="sc_countdown_'.$id.'"' : '').'class="sc_countdown'.$c.'"'.($s ? ' style="'.$s.'"' : '').'><div class="sc_countdown_counter" data-style="'.($style == 'flip' ? 'flip' : 'round').'" data-date="'.$date.'" data-time="'.$time.'"></div></div>';
}
// ---------------------------------- [/Countdown] ---------------------------------------





// ---------------------------------- [dropcaps] ---------------------------------------

//	[trx_dropcaps id="unique_id" style="1-4"]paragraph text[/dropcaps]

add_shortcode('trx_dropcaps', 'sc_dropcaps');

function sc_dropcaps($atts, $content=null){
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"style" => "1"
    ), $atts));

	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '');		

	$style = min(4, max(1, $style));
	$content = do_shortcode($content);

	return '<p'.($id ? ' id="sc_dropcaps_'.$id.'"' : '').' class="sc_dropcaps sc_dropcaps_style_'.$style.'" '.($s ? ' style="'.$s.'"' : '').'>' 
			.'<span class="sc_dropcap">'.themerex_substr($content, 0, 1).'</span>'.themerex_substr($content, 1)
			.'</p>';
}
// ---------------------------------- [/dropcaps] ---------------------------------------





// ---------------------------------- [E-mail collector] ---------------------------------------

//[trx_emailer group=""]

add_shortcode('trx_emailer', 'sc_emailer');

function sc_emailer($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"id" => "",
		"group" => "",
		"align" => "",
		"top" => "",
		"open" => "no",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '')
		.($width > 0 ? 'width:' . $width . $ed . ';' : '');

	return '<div '.($id ? ' id="sc_emailer_'.$id.'"' : '').' class="sc_emailer '.($align && $align!='none' ? ' sc_align_'.$align : '').'">'
			.'<form class="sc_eform_form '.(sc_param_is_on($open) ? ' sc_eform_opened sc_eform_show' : ' sc_eform_hide').'" data-type="emailer">'
			.'<a href="#" class="sc_eform_button sc_button sc_button_skin_dark sc_button_style_bg sc_button_size_medium ico icon-mail" title="'.__('Submit', 'themerex').'" data-group="'.($group ? $group : __('E-mail collector group', 'themerex')).'"></a>'
			.'<div class="sc_eform_wrap"><input type="text" class="sc_eform_input" name="email" value="" placeholder="'.__('Please, enter you email address.', 'themerex').'"></div>'
			.'</form></div>';
}
// ---------------------------------- [/E-mail collector] ---------------------------------------



// ---------------------------------- [Search collector] ---------------------------------------

add_shortcode('trx_search', 'sc_searchform');

function sc_searchform($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"id" => "",
		"align" => "",
		"top" => "",
		"open" => "no",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '')
		.($width > 0 ? 'width:' . $width . $ed . ';' : '');


	return '<div '.($id ? ' id="sc_searchform_'.$id.'"' : '').' class="sc_searchform '.($align && $align!='none' ? ' sc_align_'.$align : '').'"'.($s!='' ? ' style="'.$s.'"' : '').'>'
			.'<form class="sc_eform_form '.(sc_param_is_on($open) ? ' sc_eform_opened sc_eform_show' : ' sc_eform_hide').'" data-type="search"  action="'.home_url().'" method="get">'
			.'<a href="#" class="sc_eform_button sc_button sc_button_skin_dark sc_button_style_bg sc_button_size_medium ico icon-search" title="'.__('Submit', 'themerex').'"></a>'
			.'<div class="sc_eform_wrap"><input type="text" class="sc_eform_input" name="s" value="" placeholder="'.__('Please, enter you email address.', 'themerex').'"></div>'
			.'</form></div>';
}
// ---------------------------------- [/Search collector] ---------------------------------------




// --------------------- [Gallery] - only filter, not shortcode ------------------------

add_filter('post_gallery', 'sc_gallery_filter', 10, 2);

function sc_gallery_filter($prm1, $atts) {
	if ( in_shortcode_blogger() ) return ' ';
	if ( get_custom_option('substitute_gallery_layout', null,  get_the_ID()) =='no') return '';
	extract(shortcode_atts(array(
		"columns" => 3,
		"order" => "asc",
		"orderby" => "",
		"link" => "attachment",
		"include" => "",
		"exclude" => "",
		"ids" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts));

	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '')
		.($width > 0 ? 'width:' . $width . $ed . ';' : '')
		.($height > 0 ? 'height:' . $height . 'px;' : '');

	$post = get_post();

	static $instance = 0;
	$instance++;
	
	$post_id = $post ? $post->ID : 0;
	
	if (empty($orderby)) $orderby = 'post__in';
	else $orderby = sanitize_sql_orderby( $orderby );

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $post_id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if (empty($columns) || $columns<2)
		$columns = count($attachments);

	$thumb_columns = max(2, min(4, intval($columns)));

	$thumb_sizes = getThumbSizes(array(
		'thumb_size' => getThumbColumns('cub',$thumb_columns),
		'thumb_crop' => true,
		'sidebar' => false
	));
	
	

	$output = '<div id="sc_gallery_'.$instance.'" class="sc_gallery sc_columns_'.$columns.'" '.($s ? ' style="'.$s.'"' : '').'>';
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$thumb = getResizedImageTag(-$id, $thumb_sizes['w'], $thumb_sizes['h']);
		$full = wp_get_attachment_url($id);
		$url = $link!='file' ? get_permalink($id) : esc_attr($full);
		$output .= '
			<div class="sc_columns_item sc_gallery_item">
				<div class="thumb">'.$thumb.'</div>
				<a class="sc_gallery_info_wrap" href="'.$url.'" data-image="'.esc_attr($full).'" title="'.esc_attr($attachment->post_excerpt).'">
					<span class="sc_gallery_info">'
						.(esc_attr($attachment->post_excerpt)!='' ? '<h5>'.esc_attr($attachment->post_excerpt).'</h5>' : '')
						.'<span class="sc_gallery_href '.($link=='file' ? 'icon-search' : 'icon-link').'"></span>
					</span>
				</a>
			</div>';
	}
	$output .= '</div>';

	return $output;
	
}
// ---------------------------------- [/Gallery] ---------------------------------------




// ---------------------------------- [Google maps] ---------------------------------------

//[trx_googlemap id="unique_id" address="your_address" width="width_in_pixels_or_percent" height="height_in_pixels"]

add_shortcode('trx_googlemap', 'sc_google_map');

function sc_google_map($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"id" => "",
		"width" => "100%",
		"height" => "250",
		"address" => "San Francisco, CA 94102, US",
		"latlng" => "",
		"scroll" => "",
		"zoom" => 10,
		"style" => '',
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	if ((int) $width < 100 && $ed != '%') $width='100%';
	if ((int) $height < 50) $height='100';
	$width = (int) str_replace('%', '', $width);

	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '')
		.($width >= 0 ? 'width:'.$width.$ed.';' : '')
		.($height >= 0 ? 'height:'.$height.'px;' : '');

	themerex_enqueue_script( 'googlemap', 'http://maps.google.com/maps/api/js?sensor=false', array(), null, true );
	themerex_enqueue_script( 'googlemap_init', get_template_directory_uri().'/js/_googlemap_init.js', array(), null, true );

	return '<div id="sc_googlemap_'.($id != '' ? $id : mt_rand(0, 1000)).'" class="sc_googlemap"'.($s!='' ? ' style="'.$s.'"' : '') 
		.' data-address="'.esc_attr($address).'"'
		.' data-latlng="'.esc_attr($latlng).'"'
		.' data-zoom="'.esc_attr($zoom).'"'
		.' data-style="'.esc_attr($style).'"'
		.' data-scroll="'.esc_attr($scroll).'"'
		.' data-point="'.esc_attr(get_custom_option('googlemap_marker')).'"'
		.'></div>';
}
// ---------------------------------- [/Google maps] ---------------------------------------





// ---------------------------------- [hide] ---------------------------------------

// [trx_hide selector="unique_id"]

add_shortcode('trx_hide', 'sc_hide');

function sc_hide($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"selector" => ""
    ), $atts));
	$selector = trim(chop($selector));
	return $selector == '' ? '' : 
		'<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("'.$selector.'").hide();
			});
		</script>';
}
// ---------------------------------- [/hide] ---------------------------------------



// ---------------------------------- [highlight] ---------------------------------------

// [trx_highlight id="unique_id" color="fore_color's_name_or_#rrggbb" backcolor="back_color's_name_or_#rrggbb" style="custom_style"]text[/highlight]

add_shortcode('trx_highlight', 'sc_highlight');

function sc_highlight($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"color" => "",
		"backcolor" => "",
		"style" => "",
		"type" => "1"
    ), $atts));
	$s = ($color != '' ? 'color:'.$color.';' : '')
		.($backcolor != '' ? 'background-color:'.$backcolor.';' : '')
		.($style != '' ? $style : '');
	return '<span'.($id ? ' id="sc_highlight_'.$id.'"' : '').' class="sc_highlight'.($type>0 ? ' sc_highlight_style_'.$type : '').'"'.($s!='' ? ' style="'.$s.'"' : '').'>'.do_shortcode($content) . '</span>';
}
// ---------------------------------- [/highlight] ---------------------------------------








// ---------------------------------- [image] ---------------------------------------

// [trx_image id="unique_id" src="image_url" width="width_in_pixels" height="height_in_pixels" title="image's_title" align="left|right"]

add_shortcode('trx_image', 'sc_image');

function sc_image($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"url" => "",
		"src" => "",
		"title" => "",
		"align" => "",
		"link" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$url = getAttachmentID($url);
	$image = $image_full = $src!='' ? $src : $url;

	$href = $link != '' ? $link : $image_full;
	
	//image crop
	$no_crop = getThumbSizes(array(
				'thumb_size' => 'image_large',
				'thumb_crop' => true,
				'sidebar' => false ));
	$crop = array(
		"w" => $width != '' && $ed != '%' ? $width : $no_crop['w'],
		"h" => $height != '' && $ed != '%' ? $height : null
		);
	$image = getResizedImageURL($image, $crop['w'], $crop['h']);

	$s = ($top > 0 ? 'margin-top:' . $top . 'px !important;' : '')
		.($bottom > 0 ? 'margin-bottom:' . $bottom . 'px !important;' : '')
		.($left > 0 ? 'margin-left:' . $left . 'px !important;' : '')
		.($right > 0 ? 'margin-right:' . $right . 'px !important;' : '')
		.($width > 0 ? 'width:' . $width . $ed . ';' : '');
		//.($height > 0 ? 'height:' . $height . 'px;' : '');

	return '<div '.($id ? ' id="sc_image_'.$id.'"' : '').($s!='' ? ' style="'.$s.'"' : '').' class="sc_image '.($align != 'none' ? 'align'.$align : '').'"><a href="'.$href.'"><img  src="'.$image.'" alt="'.($title != '' ? $title : '' ).'" /></a>'
		.($title != '' ? '<div class="sc_image_caption">'.$title.'</div>' : '' )
		.'</div>';

}

// ---------------------------------- [/image] ---------------------------------------



// ---------------------------------- [infobox] ---------------------------------------

// [trx_infobox id="unique_id" style="regular|info|success|error|result"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/infobox]

add_shortcode('trx_infobox', 'sc_infobox');

function sc_infobox($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "regular",
		"title" => "",
		"closeable" => "no",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '');
	$c = ('sc_infobox_style_'.$style)
		.(sc_param_is_on($closeable) ? ' sc_infobox_closeable' : '')
		.(sc_param_is_on($title) ? ' sc_infobox_title_show' : '');

	return '<div'.($id ? ' id="sc_infobox_'.$id.'"' : '').' class="sc_infobox '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '').'>'
		.($title !== "" ? '<h5 class="sc_infobox_title">'.$title.'</h5>' : '')
		.do_shortcode($content) 
		.'</div>';
}

// ---------------------------------- [/infobox] ---------------------------------------





// ---------------------------------- [line] ---------------------------------------

// [trx_line id="unique_id" style="solid|dashed|dotted" top="" bottom="" width="width_in_pixels_or_percent" height="line_thickness_in_pixels" color="#rrggbb"]

add_shortcode('trx_line', 'sc_line');

function sc_line($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "solid",
		"color" => "",
		"width" => "-1",
		"height" => "-1",
		"align" => "",
		"sep" => "no",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '')
		.($width >= 0 ? 'max-width:' . $width . $ed . ';' : '')
		.($height >= 0 ? 'border-bottom-width:' . $height . 'px;' : '')
		.($color != '' ? 'border-bottom-color:' . $color . ';' : '');

	$c = ($style != '' ? ' sc_line_style_'.$style : '')
		.($align != '' ? ' sc_line_align_'.$align : '')
		.($sep == 'yes' ? ' sc_line_sep' : '');


	return '<div'.($id ? ' id="sc_line_'.$id.'"' : '').' class="sc_line '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '').'></div>';
}

// ---------------------------------- [/line] ---------------------------------------





// ---------------------------------- [list] ---------------------------------------

// [trx_list id="unique_id" style="regular|check|mark|error" ]
// 		[trx_list_item id="unique_id" title="title_of_element"]Et adipiscing integer.[/list_item]
// 		[trx_list_item]A pulvinar ut, parturient enim porta ut sed, mus amet nunc, in.[/list_item]
// 		[trx_list_item]Duis sociis, elit odio dapibus nec, dignissim purus est magna integer.[/list_item]
// 		[trx_list_item]Nec purus, cras tincidunt rhoncus proin lacus porttitor rhoncus.[/list_item]
// [/trx_list]

add_shortcode('trx_list', 'sc_list');

$THEMEREX_sc_list_icon = '';
$THEMEREX_sc_list_style = '';
$THEMEREX_sc_list_counter = 0;
function sc_list($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "ul",
		"marked" => "",
		"icon" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

	global $THEMEREX_sc_list_counter, $THEMEREX_sc_list_icon, $THEMEREX_sc_list_style, $THEMEREX_sc_list_marked;

	$icon =  trim($style) == 'iconed' && trim($icon) != '' ? $icon : 'icon-right-open-micro';
	$THEMEREX_sc_list_counter = 0;
	$THEMEREX_sc_list_icon = $icon;
	$THEMEREX_sc_list_style = $style;
	$THEMEREX_sc_list_marked = $marked == 'yes';

	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '');
	$c = (' sc_list_style_'.$style)
		.($marked != 'no' && $marked != '' ? ' sc_list_marked_'.$marked : '');

	return '<'.($style=='ol' ? 'ol' : 'ul').($id ? ' id="sc_list_'.$id.'"' : '').' class="sc_list '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '').'>'
			.do_shortcode($content) 
			.'</'.($style=='ol' ? 'ol' : 'ul').'>';
}


add_shortcode('trx_list_item', 'sc_list_item');

//[trx_list_item]

function sc_list_item($atts, $content=null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts( array(
		"id" => "",
		"marked" => "",
		"icon" => "",
		"title" => ""
	), $atts));
	global $THEMEREX_sc_list_counter, $THEMEREX_sc_list_icon, $THEMEREX_sc_list_style, $THEMEREX_sc_list_marked;
	$THEMEREX_sc_list_counter++;
	$icon = $icon != '' && $icon != 'none' ? $icon : $THEMEREX_sc_list_icon ;
	$c = ($icon!='' ? ' '.$icon : '') 
		.($THEMEREX_sc_list_counter % 2 == 1 ? ' odd' : ' even') 
		.($THEMEREX_sc_list_counter == 1 ? ' first' : '')
		.($marked != '' ? ' sc_list_marked_'.$marked : '');

	return '<li'.($id ? ' id="sc_list_item_'.$id.'"' : '').' class="sc_list_item '.$c.'"'.($title ? ' title="'.$title.'"' : '').'>' 
		.do_shortcode($content)
		.'</li>';
}

// ---------------------------------- [/list] ---------------------------------------


// ---------------------------------- [trx_parallax] ---------------------------------------


add_shortcode('trx_parallax', 'sc_parallax');

/*
[trx_parallax id="unique_id" style="light|dark" dir="up|down" image="" color='']Content for parallax block[/trx_parallax]
*/
function sc_parallax($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"class" => "",
		"gap" => "no",
		"style" => "light",
		"dir" => "up",
		"speed" => 0.3,
		"video" => "",
		"video_ratio" => "16:9",
		"image" => "",
		"image_x" => "",
		"image_y" => "",
		"color" => "",
		"overlay" => "",
		"texture" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts));
	$image = getAttachmentID($image);

	if ($video!='') {
		$info = pathinfo($video);
		$ext = !empty($info['extension']) ? $info['extension'] : 'mp4';
		$video_ratio = empty($video_ratio) ? "16:9" : str_replace(array('/','\\','-'), ':', $video_ratio);
	}

	$image_x = $image_x!='' ? str_replace('%', '', $image_x).'%' : "50%";
	$image_y = $image_y!='' ? str_replace('%', '', $image_y).'%' : "50%";
	$speed = ($dir=='down' ? -1 : 1) * abs($speed);
	if ($overlay > 0) {
		if ($color=='') $color = apply_filters('theme_skin_get_theme_bgcolor', '#ffffff');
		$rgb = hex2rgb($color);
	}

	$s = ($width > 0 ? 'width:'.$width.'px;' : '')
		.($height > 0 ? 'height:'.$height.'px;' : '')
		.($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '')
		.($color !== '' && $overlay=='' ? 'background-color:' . $color . ';' : '');

	return (sc_param_is_on($gap) ? sc_gap_start() : '')
		.'<div' . ($id ? ' id="' . $id . '"' : '').' class="sc_parallax' . ($video!='' ? ' sc_parallax_with_video' : '') . ($style!='' ? ' '.$style : '') . (!empty($class) ? ' '.$class : '') . '"' 
		. ($s!='' ? ' style="'.$s.'"' : '')
		. ' data-parallax-speed="'.$speed.'"'
		. ' data-parallax-x-pos="'.$image_x.'"'
		. ' data-parallax-y-pos="'.$image_y.'"'
		. '>'
		. ($video!='' ? '<div class="sc_video_bg_wrapper"><video class="sc_video_bg" width="1280" height="720" data-width="1280" data-height="720" preload="metadata" autoplay="autoplay" loop="loop" src="'.esc_attr($video).'" data-ratio="'.esc_attr($video_ratio).'" data-frame="no"><source src="'.$video.'" type="video/'.$ext.'"></source></video></div>' : '')
		. '<div class="sc_parallax_content" style="'.($image !== '' ? 'background-image:url(' . $image . '); background-position:'.$image_x.' '.$image_y.';' : '').'">'
		. ($overlay > 0 || $texture>0 ? '<div class="sc_parallax_overlay'.($texture!='' ? ' texture_bg_'.$texture : '').'" style="'.($overlay>0 ? 'background-color:rgba('.$rgb['r'].','.$rgb['g'].','.$rgb['b'].','.min(1, max(0, $overlay)).');' : '').'">' : '')
		. do_shortcode($content)
		. ($overlay > 0 || $texture>0 ? '</div>' : '')
		. '</div>'
		. '</div>'
		. (sc_param_is_on($gap) ? sc_gap_end() : '');
}
// ---------------------------------- [/trx_parallax] ---------------------------------------


// ---------------------------------- [trx_gap] ---------------------------------------

add_shortcode("trx_gap", "sc_gap");
						
//[trx_gap]Fullwidth content[/trx_gap]

function sc_gap($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	return sc_gap_start() . do_shortcode($content) . sc_gap_end();
	//return closeAllWrappers(false) . do_shortcode($content) . openAllWrappers(false);
}

function sc_gap_start() {
	return '<!-- #TRX_GAP_START# -->';
}

function sc_gap_end() {
	return '<!-- #TRX_GAP_END# -->';
}

function sc_gap_wrapper($str) {
	// Move VC row and column and wrapper inside gap
	$str_new = preg_replace('/(<div\s+class="vc_row[^>]*>)[\r\n\s]*(<div\s+class="vc_col[^>]*>)[\r\n\s]*(<div\s+class="wpb_wrapper[^>]*>)[\r\n\s]*('.sc_gap_start().')/i', '\\4\\1\\2\\3', $str);
	if ($str_new != $str) $str = preg_replace('/('.sc_gap_end().')[\r\n\s]*(<\/div>)[\r\n\s]*(<\/div>)[\r\n\s]*(<\/div>)/i', '\\2\\3\\4\\1', $str_new);
	// Gap layout
	return str_replace(
			array(sc_gap_start(), sc_gap_end()),
			array(closeAllWrappers(false).'<div class="sc_gap">', '</div>'.openAllWrappers(false)),
			$str
			); 
}
// ---------------------------------- [/trx_gap] ---------------------------------------


// ---------------------------------- [popup] ---------------------------------------

// [trx_popup id="unique_id" class="class_name" style="css_styles" width="" height=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/popup]

add_shortcode('trx_popup', 'sc_popup');

function sc_popup($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"class" => "",
		"style" => "",
		"width" => "-1",
		"height" => "-1",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
    $ed_w = themerex_substr($width, -1)=='%' ? '%' : 'px';
    $ed_h = themerex_substr($height, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$height = (int) str_replace('%', '', $height);
	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($width > 0 ? 'width:'.$width.$ed_w.'; max-width:'.$width.$ed_w.';' : '')
		.($height > 0 ? 'height:'.$height.$ed_h.'; max-height:'.$height.$ed_h.';' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '')
		.$style;
	return '<div' . ($id ? ' id="sc_popup_'.$id.'"' : '').' class="sc_popup sc_popup_light mfp-with-anim mfp-hide'.($class ? ' '.$class : '').'"'.($s!='' ? ' style="'.$s.'"' : '').'>' 
			.do_shortcode($content) 
			.'</div>';
}

// ---------------------------------- [/popup] ---------------------------------------






// ---------------------------------- [price] ---------------------------------------

// [trx_price id="unique_id" currency="$" money="29.99" period="monthly"]

add_shortcode('trx_price', 'sc_price');

function sc_price($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"money" => "",
		"currency" => "$",
		"period" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$output = '';
	if (!empty($money)) {
		$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
			.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
			.($left !== '' ? 'margin-left:'.$left.'px;' : '')
			.($right !== '' ? 'margin-right:'.$right.'px;' : '');
		$m = explode('.', str_replace(',', '.', $money));
		if (count($m)==1) $m[1] = '';
		$output = '
			<div '.($id ? ' id="sc_price_'.$id.'"' : '').' class="sc_price_item"'.($s != '' ? ' style="'.$s.'"' : '').'>
				<span class="sc_price_currency">'.$currency.'</span>
				<span class="sc_price_money">'.$m[0].'</span>
				<span class="sc_price_penny">.'.$m[1].'</span>
				<span class="sc_price_period">'.$period.'</span>
			</div>
		';
	}
	return $output;
}

// ---------------------------------- [/price] ---------------------------------------



// ---------------------------------- [price_table] ---------------------------------------

// [trx_price_table id="unique_id" align="left|right|center"]
// 	[trx_price_item id="unique_id"]
// 		[trx_price_data id="unique_id" type="title|price|footer|united"]Et adipiscing integer.[/price_data]
// 		[trx_price_data id="unique_id" type="title|price|footer"]Et adipiscing integer.[/price_data]
// 		[trx_price_data id="unique_id" type="title|price|footer"]Et adipiscing integer.[/price_data]
// 	[/trx_price_item]
// 	[trx_price_item]
// 		[trx_price_data id="unique_id" type="title|price|footer"]Et adipiscing integer.[/price_data]
// 		[trx_price_data id="unique_id" type="title|price|footer"]Et adipiscing integer.[/price_data]
// 		[trx_price_data id="unique_id" type="title|price|footer"]Et adipiscing integer.[/price_data]
// 	[/trx_price_item]
// [/trx_price_table]

add_shortcode('trx_price_table', 'sc_price_table');

$THEMEREX_sc_price_table_columns = 0;
function sc_price_table($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"align" => "",
		"count" => 1,
		"style" => "1",
		"indent" => "no",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '');

	$c = ($align && $align!='none' ? ' sc_align_'.themerex_strtoproper($align) : '')
		.($style != '' ? ' sc_pricing_table_style_'.$style : ' sc_pricing_table_style_1');

	global $THEMEREX_sc_price_table_columns;
	$THEMEREX_sc_price_table_columns = $count = max(1, min(12,$count));
	return '<div'.($id ? ' id="sc_price_table_'.$id.'"' : '').' class="sc_pricing_table'.$c.'"'.($s != '' ? ' style="'.$s.'"' : '').'>'
			.'<div class="sc_columns_'.($count).($indent == 'yes' ? ' sc_columns_indent' : '').'">'
			.do_shortcode($content)
			.'</div>'
		.'</div>';
}


add_shortcode('trx_price_item', 'sc_price_item');

//[trx_price_item]
function sc_price_item($atts, $content=null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts( array(
		"id" => "",
		"animation" => "yes"
	), $atts));
	return '<div class="sc_pricing_item sc_columns_item " ><ul'.(sc_param_is_on($animation) ? ' class="sc_columns_animate"' : '').($id ? ' id="'.$id.'"' : '') . '>'
		.do_shortcode($content) 
		.'</ul></div>';
}


add_shortcode('trx_price_data', 'sc_price_data');

//[trx_price_data]
function sc_price_data($atts, $content=null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts( array(
		"id" => "",
		"type" => "",
		"image" => "",
		"money" => "",
		"currency" => "$",
		"period" => ""
	), $atts));

	global $THEMEREX_sc_price_table_columns;

	if (!in_array($type, array('title', 'price', 'footer', 'united', 'image'))) $type="";
	if ($type=='price' && $money!='') {
		$m = explode('.', str_replace(',', '.', $money));
		if (count($m)==1) $m[1] = '';
		$content = '
			<div class="sc_price_item">
				<span class="sc_price_currency">'.$currency.'</span>
				<span class="sc_price_money">'.$m[0].'</span>
				<span class="sc_price_penny">.'.$m[1].'</span>
				<span class="sc_price_period">/'.$period.'</span>
			</div>
		';
	} else if ($type=='image' && $image!='') {
		//image crop
		$columns = max(1, min(4, $THEMEREX_sc_price_table_columns ));
		$crop = getThumbSizes(array(
				'thumb_size' => getThumbColumns('cub',$columns),
				'thumb_crop' => true,
				'sidebar' => false ));
		$image = getResizedImageURL($image, $crop['w'], $crop['h']);

		$type = 'title_img';
		$content = '<img src="'.$image.'" border="0" alt="" />';
	} else {
		$content = do_shortcode($content);
	}
	$c = ($type!='' ? ' sc_pricing_'.$type : '');
	return '<li'.($id ? ' id="sc_price_data_'.$id.'"' : '').' class="sc_pricing_data'.$c.'">'.$content.'</li>';
}

// ---------------------------------- [/price_table] ---------------------------------------



// ---------------------------------- [table] ---------------------------------------


add_shortcode('trx_table', 'sc_table');


//	[trx_table id="unique_id" style="1|2|3" align="left|center|right|justify"]
//		Table content, generated on one of many public internet resources, for example: http://www.impressivewebs.com/html-table-code-generator/
//	[/trx_table]

function sc_table($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "1",
		"align" => "center",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$s = ($top !== '' ? ' margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? ' margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? ' margin-left:'.$left.'px;' : '')
		.($right !== '' ? ' margin-right:'.$right.'px;' : '');

	$c = ($style !== '' ? ' sc_table_style_'.$style : '') 
		.($align !== '' ? ' sc_table_align_'.$align : '');

	$content = str_replace(
				array('<p><table', 'table></p>', '><br />'),
				array('<table', 'table>', '>'),
				html_entity_decode($content, ENT_COMPAT, 'UTF-8'));
	return '<div'.($id ? ' id="sc_table_'.$id.'"' : '').' class="sc_table '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '') .'>' 
			. do_shortcode($content) 
			. '</div>';
}

// ---------------------------------- [/table] ---------------------------------------


// ---------------------------------- [quote] ---------------------------------------

// [trx_quote id="unique_id" style="1|2" cite="url" title=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/quote]

add_shortcode('trx_quote', 'sc_quote');

function sc_quote($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "1",
		"author" => "",
		"link" => ""
    ), $atts));
	$content = do_shortcode($content);
	$c = ' sc_quote_style_'.$style;
	if (themerex_substr($content, 0, 2)!='<p') $content = '<p>'.$content.'</p>';
	return '<blockquote'.($id ? ' id="sc_quote_'.$id.'"' : '').' class="sc_quote'.$c.'">'
		.$content
		.($author != '' ?  ('<div class="sc_quote_title">'.($link!='' ? '<a href="'.$link.'">' : '').' — '.$author.($link!='' ? '</a>' : '').'</div>') : '')
		.'</blockquote>';
}

// ---------------------------------- [/quote] ---------------------------------------



// ---------------------------------- [trx_content] ---------------------------------------

add_shortcode('trx_content', 'sc_content');

/*
[trx_content id="unique_id" class="class_name" style="css-styles"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_content]
*/

function sc_content($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"class" => "",
		"style" => "",
		"top" => "",
		"bottom" => "",
		"width" => ""
    ), $atts));


	$s = ($top !== '' ? ' margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? ' margin-bottom:'.$bottom.'px;' : '')
		.($width !== '' ? ' width:'.$width.'px;' : '');

	$output = '<div'.($id ? ' id="' . $id . '"' : '') 
		.' class="sc_content mainWrap' . ($class ? ' ' . $class : '') . '"'
		.($s!='' || $style !='' ? ' style="'.$s.$style.'"' : '').'>' 
		.do_shortcode($content) 
		.'</div>';

	return $output;
}
// ---------------------------------- [/trx_content] ---------------------------------------



// ---------------------------------- [section] and [block] ---------------------------------------

// [trx_section id="unique_id" class="class_name" style="css-styles" dedicated="yes|no"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/section]

add_shortcode('trx_section', 'sc_section');
add_shortcode('trx_block', 'sc_section');

$THEMEREX_sc_section_dedicated = '';

function sc_section($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"class" => "",
		"style" => "",
		"align" => "none",
		"columns" => "none",
		"dedicated" => "no",
		"scroll" => "no",
		"dir" => "horizontal",
		"width" => "-1",
		"height" => "-1",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';

	$width = (int) str_replace('%', '', $width);

	$s = ($width >= 0 ? 'width:'.$width.$ed.'; ' : '')
		.($height >= 0 ? 'height:'.$height.'px; ' : '')
		.($top !== '' ? 'margin-top:'.$top.'px; ' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px; ' : '')
		.($left !== '' ? 'margin-left:'.$left.'px; ' : '')
		.($right !== '' ? 'margin-right:'.$right.'px; ' : '')
		.$style;

	$c = ($class ? ' '.$class : '') 
		.($align != 'none' && $align != 'center'? ' sc_float_'.$align : ($align == 'center' ? ' sc_align_'.$align : '')) 
		.(!empty($columns) && $columns!='none' ? ' sc_columns_'.$columns : '')
		.($dedicated == 'yes' ? ' sc_dedicated' : '');

	if (sc_param_is_on($scroll) && empty($id)) $id = 'sc_section_'.str_replace('.', '', mt_rand());

	$output = '<div'.($id ? ' id="sc_section_'.$id.'"' : '').' class="sc_section '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '').'>' 
		.(sc_param_is_on($scroll) ? 
				'<div id="'.$id.'_scroll" class="sc_scroll sc_scroll_'.$dir.' swiper-container scroll-container"'
				.' style="'.($dir == 'vertical' ? 'min-height:'.($height > 0 ? $height : "100").'px;' : 'width:'.($width > 0 ? $width.'px;' : "100%;")).'"'
				.'>'
				.'<div class="sc_scroll_wrapper swiper-wrapper">' 
				.'<div class="sc_scroll_slide swiper-slide">' 
			: '')
		.do_shortcode($content) 
		.(sc_param_is_on($scroll) ? '</div></div><div id="'.$id.'_scroll_bar" class="sc_scroll_bar sc_scroll_bar_'.$dir.' '.$id.'_scroll_bar"></div></div>' : '')
		.'</div>';
	if (sc_param_is_on($dedicated)) {
		global $THEMEREX_sc_section_dedicated;
		if (empty($THEMEREX_sc_section_dedicated)) {
			$THEMEREX_sc_section_dedicated = $output;
		}
		$output = '';
	}
	return $output;
}

function clear_dedicated_content() {	
	global $THEMEREX_sc_section_dedicated;
	$THEMEREX_sc_section_dedicated = '';
}

function get_dedicated_content() {	
	global $THEMEREX_sc_section_dedicated;
	return $THEMEREX_sc_section_dedicated;
}
// ---------------------------------- [/section] ---------------------------------------





// ---------------------------------- [/sidebar] ---------------------------------------
add_shortcode('trx_sidebar', 'sc_trex_sidebar');

// [themerex_sidebar name="sc_trex_sidebar" columns="3"]

function sc_trex_sidebar($atts, $content=null){
	extract(shortcode_atts(array(
		"name" => "",
		"columns" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"layout" => "",
		"right" => ""
	), $atts));

	$columns = max(1,min(6,$columns));

	$s = ($top != '' ? 'padding-top:'.$top.'px;' : '')
		.($bottom != '' ? 'padding-bottom:'.$bottom.'px;' : '')
		.($left != '' ? 'padding-left:'.$left.'px;' : '')
		.($right != '' ? 'padding-right:'.$right.'px;' : '');

	global $THEMEREX_CURRENT_SIDEBAR, $THEMEREX_SIDEBAR_COLUMNS;
	$THEMEREX_CURRENT_SIDEBAR = 'shortcode'; 
	$THEMEREX_SIDEBAR_COLUMNS = $columns; 


	if(!empty($name)) {
		ob_start();
		dynamic_sidebar($name);
		$sidebar_content = ob_get_contents();
		ob_end_clean();
	}


	return '<div class="sc_sidebar_selector"'.($s != '' ? ' style="'.$s.'"' : '').'><div class="sc_columns_'.$columns.' sc_columns_indent"><div class="widget_area">'.$sidebar_content.'</div></div></div>';
}
// ---------------------------------- [/sidebar] ---------------------------------------



// ---------------------------------- [/cube] ---------------------------------------

add_shortcode('trx_cube', 'sc_cube');

$THEME_cube_style = '';

function sc_cube($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "mini",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

	$s = ($top !== '' ? ' margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? ' margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? ' margin-left:'.$left.'px;' : '')
		.($right !== '' ? ' margin-right:'.$right.'px;' : '');

	global $THEME_cube_style;
	$THEME_cube_style = $style;

	$folio_size = array(
		'mini' => '300', 
		'medium' => '450', 
		'large' => '600'
	);
	
	$folio_style = array(
		'mini' => 'portfolio_mini', 
		'medium' => 'portfolio_medium', 
		'large' => 'portfolio_big'
	);

	return '<div'.($id ? ' id="sc_cube_'.$id.'"' : '').' class="masonryWrap "'.($s!='' ? ' style="'.$s.'"' : '').'>
			<section class="masonryStyle isotopeWrap '.$folio_style[$style].'" data-foliosize="'.(int)$folio_size[$style].'">'.do_shortcode($content).'</section>
			</div>';
}


add_shortcode('trx_cube_item', 'sc_cube_item');

//[trx_toggles_item]
function sc_cube_item($atts, $content=null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts( array(
		"id" => "",
		"title" => "",
		"desc" => "",
		"size" => "1_1",
		"bg" => "",
		"link" => "",
		"image" => "",
	), $atts));

	if ($image > 0) {
		$attach = wp_get_attachment_image_src( $image, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$image = $attach[0];
	}
	$item_style = explode('_', $size);

	global $THEME_cube_style;
	$style_size = array( 'large' => '1', 'medium' => '2', 'mini' => '3' );
	
	$thumb_sizes = getThumbSizes(array(
		'thumb_size' => getThumbColumns('cub',(int)$style_size[$THEME_cube_style]),
		'thumb_crop' => true,
		'sidebar' => false
	));

	$thumb_sizes['w'] = $thumb_sizes['w'] * $item_style[0];
	$thumb_sizes['h'] = $thumb_sizes['h'] * $item_style[1];
	$image = getResizedImageURL($image, $thumb_sizes['w'], $thumb_sizes['h']);

	if( !empty($image) ){
		$data = '<div class="isotopeItemWrap">
					<div class="thumb">
						<img src="'.$image.'" alt="'.$title.'">
					</div>
					<div class="isotopeContentWrap">
						<div class="isotopeContent">
							<h4 class="isotopeTitle">'.$title.'</h4>
							<div class="isotopeExcerpt">'.getShortString(strip_tags($desc), 70 ).'</div>
						</div>
					</div>
				</div>';
	} else {
		$data = '<div class="isotopeStatickWrap">
					<div class="isotopeStatick">
						<h5 class="isotopeTitle">'.$title.'</h5>
						<div class="isotopeExcerpt">'.getShortString(strip_tags($desc), 150 ).'</div>
					</div>
				</div>';
	}

	return '<article'.($id ? ' id="sc_cubeitem_'.$id.'"' : '').' class="isotopeItem'.(empty($image) ? ' post_format_standard' : '').'" data-wdh="'.$thumb_sizes['w'].'" data-hgt="'.$thumb_sizes['h'].'" data-incw="'.$item_style[0].'" data-inch="'.$item_style[1].'" '.($bg != '' ? 'style="background-color:'.$bg.';"' : '' ).( $link != '' ? ' onClick="document.location=\''.$link.'\'"' : '' ).' >
			<div class="isotopeItemWrap">'
			.$data
			.'</div>
		</article>';
}
// ---------------------------------- [/cube] ---------------------------------------



// ---------------------------------- [Table Reservation] ---------------------------------------


add_shortcode('trx_reservation', 'sc_reservation');

function sc_reservation($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"id" => "",
		"image1" => "",
		"image2" => "",
		"title" => "",
		"number" => "",
		"link" => "",
		"width" => "-1",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

    $image1 = getAttachmentID($image1);
    $image2 = getAttachmentID($image2);

	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);

	$s = ($width >= 0 ? 'width:' . $width . $ed . ';' : '')
		.($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '')
;
 	return '<div '.($id ? ' id="sc_reservation_'.$id.'"' : '').'class="sc_reservation'.( $link != '' ? ' sc_reservation_link' : '').'" '.($s!='' ? ' style="'.$s.'"' : '') .' '.( $link != '' ? ' onClick="document.location=\''.$link.'\'"' : '' ).'>'
 		.( $title != '' ? '<div class="sc_reservation_title">'.$title.'</div>' : '')
 		.( $image1 != '' ? '<div class="sc_reservation_img">'.( $image2 != '' ? '<div class="sc_reservation_hover"><img src="'.$image2.'" alt=""></div>' : '').( $number != '' ? '<div class="sc_reservation_number">'.$number.'</div>' : '').'<img src="'.$image1.'" alt=""></div>' : '')
		.'</div>';
}
// ---------------------------------- [/Table Reservation] ---------------------------------------




// ---------------------------------- [skills] ---------------------------------------

// [trx_skills id="unique_id" type="bar|pie|arc|counter" dir="horizontal|vertical" layout="rows|columns" count="" maximum="100" align="left|right"]
// 		[trx_skills_item title="Scelerisque pid" level="50%"]
// 		[trx_skills_item title="Scelerisque pid" level="50%"]
// 		[trx_skills_item title="Scelerisque pid" level="50%"]
// [/trx_skills]

add_shortcode('trx_skills', 'sc_skills');

$THEMEREX_sc_skills_counter = 0;
$THEMEREX_sc_skills_columns = 0;
$THEMEREX_sc_skills_height = 0;
$THEMEREX_sc_skills_max = 100;
$THEMEREX_sc_skills_dir = '';
$THEMEREX_sc_skills_type = '';
$THEMEREX_sc_skills_color = '';
$THEMEREX_sc_skills_legend = '';
$THEMEREX_sc_skills_data = '';
$THEMEREX_sc_skills_style = '';
function sc_skills($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"type" => "bar",
		"dir" => "",
		"layout" => "",
		"count" => "",
		"align" => "",
		"color" => "",
		"style" => "1",
		"maximum" => "100",
		"title" => "",
		"width" => "-1",
		"height" => "-1",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$s = ($width >= 0 ? 'width:' . $width . $ed . ';' : '')
		.($height >= 0 ? 'height:' . $height . 'px;' : '')
		.($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '')
		.($align != '' && $align != 'none' ? 'float:' . $align . ';' : '');

	$c = (' sc_skills_'.$type)
		.($type=='bar' ? ' sc_skills_'.$dir : '')
		.($layout=='columns' ? ' sc_skills_columns' : '');

	global $THEMEREX_sc_skills_counter, $THEMEREX_sc_skills_columns, $THEMEREX_sc_skills_height, $THEMEREX_sc_skills_max, $THEMEREX_sc_skills_dir, $THEMEREX_sc_skills_type, $THEMEREX_sc_skills_color, $THEMEREX_sc_skills_legend, $THEMEREX_sc_skills_data, $THEMEREX_sc_skills_style;
	$THEMEREX_sc_skills_counter = 0;
	$THEMEREX_sc_skills_columns = 0;
	$THEMEREX_sc_skills_height = 0;
	$THEMEREX_sc_skills_type = $type;
	$THEMEREX_sc_skills_color = $color;
	$THEMEREX_sc_skills_legend = '';
	$THEMEREX_sc_skills_data = '';
	if ($type!='arc') {
		if ($layout=='' || ($layout=='columns' && $count<1)) $layout = 'rows';
		if ($layout=='columns') $THEMEREX_sc_skills_columns = $count;
		if ($type=='bar') {
			if ($dir=='') $dir = 'horizontal';
			if ($dir == 'vertical') {
				if ($height < 1) $height = 300;
			}
		}
	} else {
		if (empty($id)) $id = 'sc_skills_diagram_'.str_replace('.','',mt_rand());
	}
	if ($maximum < 1) $maximum = 100;
	if ($style) $THEMEREX_sc_skills_style = $style = max(1, min(4, $style));
	$THEMEREX_sc_skills_max = $maximum;
	$THEMEREX_sc_skills_dir = $dir;
	$THEMEREX_sc_skills_height = $height;
	$content = do_shortcode($content);
	return ($type!='
		' && $title!='' ? '<h2>'.$title.'</h2>' : '')
			.'<div'.($id ? ' id="sc_skills_' . $id . '"' : '').' class="sc_skills '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '')
				.' data-type="'.$type.'"'
				.($type=='bar' ? ' data-dir="'.$dir.'"' : '')
			.'>'
				.($layout == 'columns' ? '<div class="sc_columns_'.$count.' sc_columns_indent sc_skills_'.$layout.'">' : '')
				.($type=='arc' 
					? ('<div class="sc_skills_legend">'.($title!='' ? '<h2>'.$title.'</h2>' : '').'<ul>'.$THEMEREX_sc_skills_legend.'</ul></div>'
						.'<div id="'.$id.'_diagram" class="sc_skills_arc_canvas"></div>'
						.'<div class="sc_skills_data" style="display:none;">'
						.$THEMEREX_sc_skills_data
						.'</div>'
					  )
					: '')
				. $content
				. ($layout == 'columns' ? '</div>' : '')
			. '</div>';
}


add_shortcode('trx_skills_item', 'sc_skills_item');

//[trx_skills_item]
function sc_skills_item($atts, $content=null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts( array(
		"id" => "",
		"title" => "",
		"level" => "",
		"color" => "",
		"style" => ""
	), $atts));
	global $THEMEREX_sc_skills_counter, $THEMEREX_sc_skills_columns, $THEMEREX_sc_skills_height, $THEMEREX_sc_skills_max, $THEMEREX_sc_skills_dir, $THEMEREX_sc_skills_type, $THEMEREX_sc_skills_color, $THEMEREX_sc_skills_legend, $THEMEREX_sc_skills_data, $THEMEREX_sc_skills_style, $THEMEREX_sc_skills_title;
	$THEMEREX_sc_skills_counter++;
	$ed = themerex_substr($level, -1)=='%' ? '%' : '';
	$level = (int) str_replace('%', '', $level);
	$percent = round($level / $THEMEREX_sc_skills_max * 100);
	$start = 0;
	$stop = $ed == '%' ? max(0,min($level,100)) : $level;
	$steps = 100;
	$step = max(1, round($THEMEREX_sc_skills_max/$steps));
	$speed = mt_rand(10,40);
	$animation = round(($stop - $start) / $step * $speed);
	$title_block = '<div class="sc_skills_info">'.$title.'</div>';
	if (empty($color)) $color = $THEMEREX_sc_skills_color;
	if ($style) $style = max(1, min(4, $style));
	if (empty($style)) $style = $THEMEREX_sc_skills_style;
	$style = max(1, min(4, $style));
	$output = '';
	if ($THEMEREX_sc_skills_type=='arc') {
		if (empty($color)) $color = get_custom_option('theme_color');
		$THEMEREX_sc_skills_legend .= '<li style="background-color:'.$color.'">'.$title.'</li>';
		$THEMEREX_sc_skills_data .= '<div class="arc"><input type="hidden" class="percent" value="'.$percent.'" /><input type="hidden" class="color" value="'.$color.'" /></div>';
	} else {
		$output .= ($THEMEREX_sc_skills_columns > 0 ? '<div class="sc_columns_item ">' : '')
				.'<div'.($id ? ' id="sc_skills_item_'.$id.'"' : '').' class="sc_skills_item'.($style ? ' sc_skills_style_'.$style : '').($THEMEREX_sc_skills_counter % 2 == 1 ? ' odd' : ' even').($THEMEREX_sc_skills_counter == 1 ? ' first' : '').'"'
					.($THEMEREX_sc_skills_height > 0 ? ' style="height: '.$THEMEREX_sc_skills_height.'px;"' : '')
				.'>';
		if (in_array($THEMEREX_sc_skills_type, array('bar', 'counter'))) {
			$output .= '<div class="sc_skills_count"' . ($THEMEREX_sc_skills_type=='bar' && $color ? ' style="background-color:' . $color . '"' : '') . '>'
						.'<div class="sc_skills_total"'
							.' data-start="'.$start.'"'
							.' data-stop="'.$stop.'"'
							.' data-step="'.$step.'"'
							.' data-max="'.$THEMEREX_sc_skills_max.'"'
							.' data-speed="'.$speed.'"'
							.' data-duration="'.$animation.'"'
							.' data-ed="'.$ed.'">'
							.'<span>'
							.$start.$ed
							.'</span>'
						.'</div>'
					.'</div>';
		} else if ($THEMEREX_sc_skills_type=='pie') {
			if (empty($color)) $color = get_custom_option('theme_color');
			if (empty($id)) $id = 'sc_skills_canvas_'.str_replace('.','',mt_rand());
			$output .= '<canvas id="'.$id.'"></canvas>'
				.'<div class="sc_skills_total"'
					.' data-start="'.$start.'"'
					.' data-stop="'.$stop.'"'
					.' data-step="'.$step.'"'
					.' data-steps="'.$steps.'"'
					.' data-max="'.$THEMEREX_sc_skills_max.'"'
					.' data-speed="'.$speed.'"'
					.' data-duration="'.$animation.'"'
					.' data-color="'.$color.'"'
					.' data-easing="easeOutCirc"'
					.' data-ed="'.$ed.'">'
					.'<span>'
					.$start.$ed
					.'</span>'
				.'</div>';
		}
		$output .= ($THEMEREX_sc_skills_type=='counter' ? $title_block : '')
				.'</div>'
				.($THEMEREX_sc_skills_type == 'bar' && $THEMEREX_sc_skills_dir == 'horizontal' ? $title_block : '')
				.($THEMEREX_sc_skills_type == 'bar' && $THEMEREX_sc_skills_dir == 'vertical' || $THEMEREX_sc_skills_type == 'pie' ? $title_block : '')
				.($THEMEREX_sc_skills_columns > 0 ? '</div>' : '');
	}
	return $output;
}

// ---------------------------------- [/skills] ---------------------------------------



// ---------------------------------- [slider] ---------------------------------------

//	[trx_slider id="unique_id" engine="swiper|revo|royal" alias="revolution_slider_alias|royal_slider_id" titles="no|slide|fixed" cat="category_id or slug" count="posts_number" ids="comma_separated_id_list" offset="" width="" height="" align="" top="" bottom=""]
//	[trx_slider_item src="image_url"]
//	[/trx_slider]


add_shortcode('trx_slider', 'sc_slider');

$THEMEREX_sc_slider_engine = '';
$THEMEREX_sc_slider_width = 0;
$THEMEREX_sc_slider_height = 0;
$THEMEREX_sc_slider_links = false;

function sc_slider($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"engine" => "swiper",
		"alias" => "",
		"ids" => "",
		"theme" => "dark",
		"cat" => "",
		"count" => "0",
		"offset" => "",
		"orderby" => "date",
		"order" => 'desc',
		"controls" => "no",
		"pagination" => "no",
		"titles" => "no",
		"links" => "no",
		"rev_style" => "rev_full",
		"align" => "",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));


	global $THEMEREX_sc_slider_engine, $THEMEREX_sc_slider_width, $THEMEREX_sc_slider_height, $THEMEREX_sc_slider_links;
	$THEMEREX_sc_slider_engine = $engine;
	$THEMEREX_sc_slider_width = $width;
	$THEMEREX_sc_slider_height = $height;
	$THEMEREX_sc_slider_links = sc_param_is_on($links);

	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '')
		.(!empty($width) ? 'width:'.$width.(themerex_strpos($width, '%')!==false ? '' : 'px').';' : '')
		.(!empty($height) ? 'height:'.$height.(themerex_strpos($height, '%')!==false ? '' : 'px').';' : '');
	
	$c = ' sc_slider_'.$engine
		.(sc_param_is_on($controls) ? ' sc_slider_controls' : '')
		.(sc_param_is_on($pagination) ? ' sc_slider_pagination' : '')
		.($align!='' && $align!='none' ? ' sc_float_'.$align : '')
		.($engine=='swiper' ? ' swiper-container' : '');

	$output = '<div'.($id ? ' id="sc_slider_'.$id.'"' : '').' class="sc_slider '.$c.'" ' .($s!='' ? ' style="'.$s.'"' : '').'>';

	if ($engine=='revo') {
		if (revslider_exists() && !empty($alias))
			$output .= do_shortcode('[rev_slider '.$alias.']');
		else
			$output = '';
	} else if ($engine=='royal') {
		if (royalslider_exists() && !empty($alias))
			$output .= do_shortcode('[[new_royalslider id="'.$alias.'"]');
		else
			$output = '';
	} else if ( $engine=='swiper') {
		
		$output .= '<ul class="slides'.($engine=='swiper' ? ' swiper-wrapper' : '').'">';

		$content = do_shortcode($content);
		
		if ($content) {
			$output .= $content;
		} else {
			global $post;
	
			if (!empty($ids)) {
				$posts = explode(',', $ids);
				$count = count($posts);
			}
		
			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => $count,
				'ignore_sticky_posts' => 1,
				'order' => $order=='asc' ? 'asc' : 'desc',
			);
	
			if ($offset > 0 && empty($ids)) {
				$args['offset'] = $offset;
			}
	
			$args = addSortOrderInQuery($args, $orderby, $order, true);
			$args = addPostsAndCatsInQuery($args, $ids, $cat);
	
			$query = new WP_Query( $args );
	
			while ( $query->have_posts() ) { 
				$query->the_post();
				$post_id = get_the_ID();
				$post_link = get_permalink();
				$post_attachment = wp_get_attachment_url(get_post_thumbnail_id($post_id));
				$post_accent_color = '';
				$post_category = '';
				$post_category_link = '';
				$post_title = getPostTitle($post_id);

				$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
				//image crop
				$no_crop = getThumbSizes(array(
						'thumb_size' => 'image_large',
						'thumb_crop' => true,
						'sidebar' => false ));
				$crop = array(
					"w" => $width != '' && $ed != '%' ? $width : $no_crop['w'],
					"h" => $height != '' && $ed != '%' ? $height : null
					);
				$post_attachment = getResizedImageURL($post_attachment, $crop['w'], $crop['h']);

				$output .= '<li'.($engine=='swiper' ? ' class="swiper-slide"' : '').' data-theme="'.( $theme != '' ? $theme : 'dark' ).'" style="background-image:url('.$post_attachment . ');'.(!empty($width) ? ' width:' . $width . (themerex_strpos($width, '%')!==false ? '' : 'px').';' : '').(!empty($height) ? ' height:' . $height . (themerex_strpos($height, '%')!==false ? '' : 'px').';' : '').'">' . (sc_param_is_on($links) ? '<a href="'.$post_attachment.'" title="'.htmlspecialchars($post_title).'">' : '');
				if (!sc_param_is_off($titles)) {
					$post_hover_bg  = get_custom_option('theme_color', null, $post_id);
					$post_bg = '';
					if ($post_hover_bg!='' && !is_inherit_option($post_hover_bg)) {
						$rgb = Hex2RGB($post_hover_bg);
						$post_hover_ie = str_replace('#', '', $post_hover_bg);
						$post_bg = "background-color: rgba({$rgb['r']},{$rgb['g']},{$rgb['b']},0.8);";
					}
					$output .= '<div class="sc_slider_info' . ($titles=='fixed' ? ' sc_slider_info_fixed' : '') . ($engine=='swiper' ? ' content-slide' : '') . '"><div class="sc_slider_main">';
					$post_descr = getPostDescription();
					//reviews
					if (get_custom_option('show_reviews')=='yes' && get_custom_option('slider_reviews')=='yes') {
						$output_reviews = '';
						$rating_max = get_custom_option('reviews_max_level');
						$avg_author = marksToDisplay(get_post_meta($post_id, 'reviews_avg'.((get_theme_option('reviews_first')=='author' && $orderby != 'users_rating') || $orderby == 'author_rating' ? '' : '2'), true));
						$review_title = sprintf($rating_max<100 ? __('Rating: %s from %s', 'themerex') : __('Rating: %s', 'themerex'), number_format($avg_author,1).($rating_max < 100 ? '' : '%'), $rating_max.($rating_max < 100 ? '' : '%'));

						if( $avg_author > 0 && get_custom_option('slider_reviews_style')=='rev_short' ){
							$output .= '<div class="sc_slider_reviews_short" title="'.$review_title.'"><span class="rInfo">'.$avg_author.'</span><span class="rDelta">'.($rating_max < 100 ? '<span class="icon-star"></span>' : '%').'</span></div>';
						} else if ($avg_author > 0 && get_custom_option('slider_reviews_style')=='rev_full') {
							$output_reviews .= '<div class="sc_slider_reviews reviews_summary blog_reviews" title="'.$review_title.'">'
								.'<div class="criteria_summary criteria_row">' . getReviewsSummaryStars($avg_author) . '</div>'
								.'</div>';
						}
						$output .= $output_reviews;
					}
					//category
					if (get_custom_option("slider_info_category")=='yes') { // || empty($cat)) {
						// Get all post's categories
						$post_categories = getCategoriesByPostId($post_id);
						$post_categories_str = '';
						for ($i = 0; $i < count($post_categories); $i++) {
							if ($post_category=='') {
								if (get_theme_option('close_category')=='parental') {
									$parent_cat_id = 0;//(int) get_custom_option('category_id');
									$parent_cat = getParentCategory($post_categories[$i]['term_id'], $parent_cat_id);
									if ($parent_cat) {
										$post_category = $parent_cat['name'];
										$post_category_link = $parent_cat['link'];
										if ($post_accent_color=='') $post_accent_color = get_category_inherited_property($parent_cat['term_id'], 'theme_color');
									}
								} else {
									$post_category = $post_categories[$i]['name'];
									$post_category_link = $post_categories[$i]['link'];
									if ($post_accent_color=='') $post_accent_color = get_category_inherited_property($post_categories[$i]['term_id'], 'theme_color');
								}
							}
							if ($post_category!='' && $post_accent_color!='') break;
						}
						if ($post_category=='' && count($post_categories)>0) {
							$post_category = $post_categories[0]['name'];
							$post_category_link = $post_categories[0]['link'];
							if ($post_accent_color=='') $post_accent_color = get_category_inherited_property($post_categories[0]['term_id'], 'theme_color');
						}
						if ($post_category!='') {
							$output .= '<div class="sc_slider_category"'.(themerex_substr($post_accent_color, 0, 1)=='#' ? ' style="background-color: '.$post_accent_color.'"' : '').'><a href="'.$post_category_link.'">'.$post_category.'</a></div>';
						}
					}
					//title
					$output .= '<h2 class="sc_slider_subtitle"><a href="'.$post_link.'">'.$post_title.'</a></h2>';
					//descriptions
					if (get_custom_option('slider_descriptions')=='yes') {
						$output .= '<div class="sc_slider_descr">'.$post_descr.'</div>';
					}
					$output .= '</div></div>';
				}
				$output .= (sc_param_is_on($links) ? '</a>' : '' ) . '</li>';
			}
			wp_reset_postdata();
		}
	
		$output .= '</ul>';
		if ($engine=='swiper') {
			if (sc_param_is_on($controls))
				$output .= '
					<ul class="slider-control-nav">
						<li class="slide-prev"><a class="icon-left-open-big" href="#"></a></li>
						<li class="slide-next"><a class="icon-right-open-big" href="#"></a></li>
					</ul>';
			if (sc_param_is_on($pagination))
				$output .= '
					<div class="slider-pagination-nav"></div>
				';
		}
	
	} else
		$output = '';

	$output .= !empty($output) ? '</div>' : '';
	return $output;
}

add_shortcode('trx_slider_item', 'sc_slider_item');

//[trx_slider_item]
function sc_slider_item($atts, $content=null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts( array(
		"id" => "",
		"src" => "",
		"url" => "",
		"theme" => ""
	), $atts));

	global $THEMEREX_sc_slider_engine, $THEMEREX_sc_slider_width, $THEMEREX_sc_slider_height, $THEMEREX_sc_slider_links;
	
	$width = $THEMEREX_sc_slider_width;
	$height = $THEMEREX_sc_slider_height;
	$image = $src ? $src : $url;

	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	//image crop
	$no_crop = getThumbSizes(array(
			'thumb_size' => 'image_large',
			'thumb_crop' => true,
			'sidebar' => false ));
	$crop = array(
		"w" => $width != '' && $ed != '%' ? $width : $no_crop['w'],
		"h" => $height != '' && $ed != '%' ? $height : null
		);
	$image = getResizedImageURL($image, $crop['w'], $crop['h']);

	$c = ($THEMEREX_sc_slider_engine=='swiper' ? ' swiper-slide' : '');

	return '<li'.($id ? ' id="sc_slider_item_'.$id.'"' : '').' class="'.$c.'"'
			.' data-theme="'.( $theme != '' ? $theme : 'dark' ).'"'
			.' style="background-image:url('.$image.');'
			.(!empty($THEMEREX_sc_slider_width) ? 'width:'.$THEMEREX_sc_slider_width.(themerex_strpos($THEMEREX_sc_slider_width, '%')!==false ? '' : 'px').';' : '')
			.(!empty($THEMEREX_sc_slider_height) ? ' height:'.$THEMEREX_sc_slider_height.(themerex_strpos($THEMEREX_sc_slider_height, '%')!==false ? '' : 'px').';' : '')
		.'">' 
		.(sc_param_is_on($THEMEREX_sc_slider_links) ? '<a href="'.($src ? $src : $url).'"></a>' : '')
		.'</li>';
}

// ---------------------------------- [/slider] ---------------------------------------



// ---------------------------------- [tabs] ---------------------------------------

// [trx_tabs id="unique_id" tab_names="Planning|Development|Support" style="1|2" initial="1-num"]
// 		[trx_tab] text [/tab]
// 		[trx_tab] text [/tab]
// 		[trx_tab] text [/tab]
// [/trx_tabs]

add_shortcode("trx_tabs", "sc_tabs");

$THEMEREX_sc_tab_counter = 0;
$THEMEREX_sc_tab_scroll = "no";
$THEMEREX_sc_tab_height = 0;
$THEMEREX_sc_tab_id = '';
$THEMEREX_sc_tab_titles = array();
function sc_tabs($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"style" => "1",
		"tab_names" => "",
		"initial" => "1",
		"effects" => "no",
		"scroll" => "no",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));


	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '')
		.(!empty($width) ? 'width:'.$width.(themerex_strpos($width, '%')!==false ? '' : 'px').';' : '');

	$c = 'sc_tabs sc_tabs_style_'.$style
		.($scroll == 'yes' ? ' sc_tabs_scroll_show' : '')
		.($effects == 'yes' ? ' sc_tabs_effects' : '');

	global $THEMEREX_sc_tab_counter, $THEMEREX_sc_tab_id, $THEMEREX_sc_tab_scroll, $THEMEREX_sc_tab_height,$THEMEREX_sc_tab_titles;
	$THEMEREX_sc_tab_counter = 0;
	$THEMEREX_sc_tab_scroll = $scroll;
	$THEMEREX_sc_tab_height = $height;
	$THEMEREX_sc_tab_id = $id ? $id : 'sc_tab_'.str_replace('.', '', mt_rand());
	$THEMEREX_sc_tab_titles = array();
	if (!empty($tab_names)) {
		$title_chunks = explode("|", $tab_names);
		for ($i = 0; $i < count($title_chunks); $i++) {
			$THEMEREX_sc_tab_titles[] = array(
				'id' => $THEMEREX_sc_tab_id.'_'.($i+1),
				'title' => $title_chunks[$i]
			);
		}
	}
	$content = do_shortcode($content);
	$initial = max(1, min(count($THEMEREX_sc_tab_titles), (int) $initial));
	$tabs_output = '<div'.($id ? ' id="'.$id.'"' : '').' class="'.$c.'"'.($s!='' ? ' style="'.$s.'"' : '').' data-active='.($initial-1).'>'
					.'<ul class="sc_tabs_titles">';
	$titles_output = '';
	for ($i = 0; $i < count($THEMEREX_sc_tab_titles); $i++) {
		$classes = array('tab_names');
		if ($i == 0) $classes[] = 'first';
		else if ($i == count($THEMEREX_sc_tab_titles) - 1) $classes[] = 'last';
		$titles_output .= '<li class="'.join(' ', $classes).'"><a href="#'.$THEMEREX_sc_tab_titles[$i]['id'].'" class="theme_button" id="'.$THEMEREX_sc_tab_titles[$i]['id'].'_tab">' . $THEMEREX_sc_tab_titles[$i]['title'] . '</a></li>';
	}

	themerex_enqueue_script('jquery-ui-tabs', false, array('jquery','jquery-ui-core'), null, true);
	if($effects == 'yes') themerex_enqueue_script( 'jquery-effects-slide', false, array('jquery','jquery-effects-core'), null, true);


	$tabs_output .= $titles_output
		. '</ul><div class="sc_tabs_array">' 
		. $content 
		.'</div></div>';


	return $tabs_output;
}

//[trx_tab id="tab_id"]

add_shortcode('trx_tab', 'sc_tab');

function sc_tab($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"class" => "",
		"tab_id" => "",		// get it from VC
		"title" => ""		// get it from VC
    ), $atts));
	global $THEMEREX_sc_tab_counter, $THEMEREX_sc_tab_id, $THEMEREX_sc_tab_scroll, $THEMEREX_sc_tab_height, $THEMEREX_sc_tab_titles;
	$THEMEREX_sc_tab_counter++;
	$id = $THEMEREX_sc_tab_id . '_' . $THEMEREX_sc_tab_counter;

	if (empty($id))
		$id = !empty($tab_id) ? $tab_id : $THEMEREX_sc_tab_id.'_'.$THEMEREX_sc_tab_counter;
	if (isset($THEMEREX_sc_tab_titles[$THEMEREX_sc_tab_counter-1])) {
		$THEMEREX_sc_tab_titles[$THEMEREX_sc_tab_counter-1]['id'] = $id;
		if (!empty($title))
			$THEMEREX_sc_tab_titles[$THEMEREX_sc_tab_counter-1]['title'] = $title;
	} else {
		$THEMEREX_sc_tab_titles[] = array(
			'id' => $id,
			'title' => $title
		);
	}
	return '<div id="'.$id.'" class="sc_tabs_content' . ($THEMEREX_sc_tab_counter % 2 == 1 ? ' odd' : ' even') . ($THEMEREX_sc_tab_counter == 1 ? ' first' : '') . (!empty($class) ? ' '.$class : '') .'">' 
		. (sc_param_is_on($THEMEREX_sc_tab_scroll) ? '<div id="'.$id.'_scroll" class="sc_scroll sc_scroll_vertical" style="height:'.($THEMEREX_sc_tab_height > 0 ? $THEMEREX_sc_tab_height : 230).'px;"><div class="sc_scroll_wrapper swiper-wrapper"><div class="sc_scroll_slide swiper-slide">' : '')
		. do_shortcode($content) 
		. (sc_param_is_on($THEMEREX_sc_tab_scroll) ? '</div></div><div id="'.$id.'_scroll_bar" class="sc_scroll_bar sc_scroll_bar_vertical '.$id.'_scroll_bar"></div></div>' : '')
		. '</div>';
}


// ---------------------------------- [/tabs] ---------------------------------------






// ---------------------------------- [team] ---------------------------------------


// [trx_team id="unique_id" style="normal|big"]
// 	[trx_team_item user="user_login"]
// [/trx_team]


add_shortcode('trx_team', 'sc_team');


$THEMEREX_sc_team_columns = 0;
$THEMEREX_sc_team_counter = 0;
function sc_team($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"columns" => 0,
		"indent" => "yes",
		"info" => "yes",
		"rounding" => "yes",
		"style" => "1",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

	$style = $style != '' ? max(1,min(2,$style)) : '1';

	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . ((int) $left > 0 ? 'px' : '') . ';' : '')
		.($right !== '' ? 'margin-right:' . $right . ((int) $right > 0 ? 'px' : '') . ';' : '');
	$c = (sc_param_is_on($rounding) ? ' sc_team_item_avatar_rounding' : '')
		.(' sc_team_item_style_'.$style);

	global $THEMEREX_sc_team_columns, $THEMEREX_sc_team_counter, $THEMEREX_sc_team_info;
	$THEMEREX_sc_team_columns = $columns = max(1, min(6, $columns));
	$THEMEREX_sc_team_counter = 0;
	$THEMEREX_sc_team_info = $info;
	$content = do_shortcode($content);
	return '<div' . ($id ? ' id="sc_team_'.$id.'"' : '').' class="sc_team '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '') .'>'
				. '<div class="sc_columns_'.$columns.(sc_param_is_on($indent) ? ' sc_columns_indent' : '').'">'
					. $content
				. '</div>'
			. '</div>';
}


add_shortcode('trx_team_item', 'sc_team_item');

//[trx_team_item]
function sc_team_item($atts, $content=null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts( array(
		"id" => "",
		"user" => "",
		"name" => "",
		"position" => "",
		"photo" => "",
		"email" => "",
		"socials" => ""
	), $atts));
	global $THEMEREX_sc_team_counter, $THEMEREX_sc_team_columns, $THEMEREX_sc_team_info;
	$info = $THEMEREX_sc_team_info;
	$THEMEREX_sc_team_counter++;
	$descr = do_shortcode($content);
	if (!empty($user) && $user!='none' && ($user_obj = get_user_by('login', $user)) != false) {
		$meta = get_user_meta($user_obj->ID);
		if (empty($email))		$email = $user_obj->data->user_email;
		if (empty($name))		$name = $user_obj->data->display_name;
		if (empty($position))	$position = isset($meta['user_position'][0]) ? $meta['user_position'][0] : '';
		if (empty($descr))		$descr = isset($meta['description'][0]) ? $meta['description'][0] : '';
		if (empty($socials))	$socials = showUserSocialLinks(array('author_id'=>$user_obj->ID, 'echo'=>false, 'before'=>'<li>', 'after' => '</li>', 'style' => 'icons'));
	} else {
		global $THEMEREX_user_social_list;
		$allowed = explode('|', $socials);
		$socials = '';
		for ($i=0; $i<count($allowed); $i++) {
			$s = explode('=', $allowed[$i]);
			if (!empty($s[1]) && array_key_exists($s[0], $THEMEREX_user_social_list)) {
				$img = get_template_directory_uri().'/images/socials/'.$s[0].'.png';
				$socials .= '<li><a href="'.$s[1].'" class="social_icons social_'.$s[0].' '.$s[0] . '" target="_blank" style="background-image: url('.$img.');">'
						. '<span style="background-image: url('.$img.');"></span>'
						. '</a></li>';
			}
		}
	}

	$photo_sizes = getThumbSizes(array(
		'thumb_size' => getThumbColumns('cub',$THEMEREX_sc_team_columns),
		'thumb_crop' => true,
		'sidebar' => false
	));

	if (empty($photo)) {
		if (!empty($email)) $photo = get_avatar($email, $photo_sizes['w']);
	} else {
		$photo = getResizedImageTag($photo, $photo_sizes['w'], $photo_sizes['h']);
	}
	if ( !empty($photo) ) {
		return '<div class="sc_columns_item">'
				.'<div'.($id ? ' id="sc_team_item_'.$id.'"' : '').' class="sc_team_item sc_team_item_'.$THEMEREX_sc_team_counter.($THEMEREX_sc_team_counter % 2 == 1 ? ' odd' : ' even').($THEMEREX_sc_team_counter == 1 ? ' first' : '').'">'
					.'<div class="sc_team_item_avatar_wrap">'
						.'<div class="sc_team_item_avatar">'.$photo.'</div>'
						.(!empty($socials) ? '<div class="sc_team_item_socials"><ul>'.$socials.'</ul></div>' : '')						
					.'</div>'
					.((!empty($name) || !empty($position)) && sc_param_is_on($info) ?  
						 ($name != '' ? '<h5 class="sc_team_item_title">'.$name.'</h5>' : '')
						.($position != '' ? '<div class="sc_team_item_position">'.$position.'</div>' : '')
						.($descr != '' ? '<div class="sc_team_item_description">'.$descr.'</div>' : '')
					: '')
				.'</div>'
			.'</div>';
	}
	return '';
}


// ---------------------------------- [/team] ---------------------------------------


// ---------------------------------- [testimonials] ---------------------------------------


add_shortcode('trx_testimonials', 'sc_testimonials');

$THEMEREX_sc_testimonials_count = 0;
$THEMEREX_sc_testimonials_width = 0;
$THEMEREX_sc_testimonials_height = 0;
function sc_testimonials($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"title" => "",
		"style" => "1",
		"controls" => "yes",
		"pagination" => "yes",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

    $style = $style != '' ? $style : 1;

	$s = ($top !== '' ? 'margin-top:' . $top . 'px;' : '')
		.($bottom !== '' ? 'margin-bottom:' . $bottom . 'px;' : '')
		.($left !== '' ? 'margin-left:' . $left . 'px;' : '')
		.($right !== '' ? 'margin-right:' . $right . 'px;' : '');

	$s2 = (!empty($width) ? 'width:' . $width . (themerex_strpos($width, '%')!==false ? '' : 'px').';' : '')
		.(!empty($height) ? 'height:' . $height . (themerex_strpos($height, '%')!==false ? '' : 'px').';' : '');

	$c = (' sc_testimonials_style_'.$style );

	$c2 = ($height == '' ? ' sc_slider_swiper_autoheight' : '')
		 .(sc_param_is_on($controls) ? ' sc_slider_controls' : '')
		 .(sc_param_is_on($pagination) ? ' sc_slider_pagination' : '');

	$control_nav = (sc_param_is_on($controls) ? '<ul class="slider-control-nav"><li class="slide-prev"><a class="icon-left-open-big" href="#"></a></li><li class="slide-next"><a class="icon-right-open-big" href="#"></a></li></ul>' : '');
	$pagination_nav = (sc_param_is_on($pagination) ? '<div class="slider-pagination-nav"></div>' : '');


	global $THEMEREX_sc_testimonials_count, $THEMEREX_sc_testimonials_width, $THEMEREX_sc_testimonials_height;
	$THEMEREX_sc_testimonials_count = 0;
	$THEMEREX_sc_testimonials_width = $width;
	$THEMEREX_sc_testimonials_height = $height;
	$content = do_shortcode($content);

	return '<div' . ($id ? ' id="sc_testimonials_' . $id . '"' : '') . ' class="sc_testimonials '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '').'>'
			.($title ? '<h4 class="sc_testimonials_title">'.$title.'</h4>' : '')
			.($THEMEREX_sc_testimonials_count>1 ? '<div class="sc_slider sc_slider_swiper swiper-container'.$c2.'"'.($s2 ? ' style="'.$s2.'"' : '').'>' : '')
				.'<ul class="sc_testimonials_items'.($THEMEREX_sc_testimonials_count>1 ? ' slides swiper-wrapper' : '').'">'
				.$content
				.'</ul>'
			.($THEMEREX_sc_testimonials_count>1 ? $control_nav.$pagination_nav.'</div>' : '')
		.'</div>';
}


add_shortcode('trx_testimonials_item', 'sc_testimonials_item');

function sc_testimonials_item($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"name" => "",
		"position" => "",
		"photo" => "",
		"email" => ""
    ), $atts));
	global $THEMEREX_sc_testimonials_count, $THEMEREX_sc_testimonials_width, $THEMEREX_sc_testimonials_height;
	$THEMEREX_sc_testimonials_count++;
	if (empty($photo)) {
		if (!empty($email))
			$photo = get_avatar($email, 50);
	} else {
		$photo = getResizedImageTag($photo, 50, 50);
	}

	$author_show = $name.$position.$photo.$email != ''; 

	$s = (!empty($THEMEREX_sc_testimonials_width) ? 'width:'.$THEMEREX_sc_testimonials_width.(themerex_strpos($THEMEREX_sc_testimonials_width, '%')!==false ? '' : 'px').';' : '').(!empty($THEMEREX_sc_testimonials_height) ? 'height:'.$THEMEREX_sc_testimonials_height.(themerex_strpos($THEMEREX_sc_testimonials_height, '%')!==false ? '' : 'px').';' : '');

	$c = ( $author_show ? ' sc_testimonials_item_author_show' : '');

	//if (empty($photo)) $photo = '<img src="'.get_template_directory_uri().'/images/no-ava.png" alt="">';

	return '<li'.($id ? ' id="sc_testimonials_item_'.$id.'"' : '').' class="sc_testimonials_item swiper-slide'.$c.'" '.($s != '' ? 'style="'.$s.'"' : '').'>'
				.'<div class="sc_testimonials_item_content">'
					.'<div class="sc_testimonials_item_quote"><span class="sc_testimonials_item_text"><span class="sc_testimonials_item_text_before">'.do_shortcode(strip_tags($content)).'</span></span></div>'
					.($author_show ? 
					'<div class="sc_testimonials_item_author">'
						.($photo != '' ? '<div class="sc_testimonials_item_avatar">'.$photo.'</div>' : '' )
						.'<div class="sc_testimonials_item_user">'
							.($name != ''? '<span class="sc_testimonials_item_name">'.$name.'</span>' : '')
							.($position != '' ? '<span class="sc_testimonials_item_position">'.$position.'</span>' : '')
						.'</div>'
					.'</div>' : '')
				.'</div>'
			.'</li>';
}

// ---------------------------------- [/testimonials] ---------------------------------------


// ---------------------------------- [icon] ---------------------------------------

//[trx_icon id="unique_id" style='round|square' icon='' color="" bg_color="" size="" weight=""]

add_shortcode('trx_icon', 'sc_icon');

function sc_icon($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"icon" => "",
		"size" => "20",
		"color" => "",
		"weight" => "",
		"link" => "",
		"box_style" => "none",
		"bg_color" => "",
		"align" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

    $size = max(5,min(250,$size));


	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '')
		.($weight != '' ? 'font-weight:'. $weight.';' : '')
		.((int) $size > 0 ? 'font-size:'.$size.'px;' : '')
		.($color !== '' ? 'color:'.$color.';' : '')
		.($bg_color !== '' ? 'background-color:'.$bg_color.';' : '')
		.('font-size: '.$size.'px;')
		.('line-height: '.$size.'px;')
		.('width: '.$size.'px;')
		.('height: '.$size.'px;')
		.($link != '' ? 'border-width:'.round(max(1, $size/25)).'px;' : '');

	$c = $icon
		.($align !== ''? ' sc_icon_'.$align : '')
		.($box_style !=='none' || $bg_color !== '' ? ' sc_icon_box sc_icon_box_'.$box_style : '' );

	$href = ' href="'.($link != '' || $link == '#' ? $link : '' ).'" ';
	$block = empty($link) ? 'span' : 'a';

	return $icon!='' ? '<'.$block.$href.' '.($id ? ' id="sc_icon_'.$id.'"' : '').' class="sc_icon '.$c.'"'.($s != '' ? ' style="'.$s.'"' : '').'></'.$block.'>' : '';
}

// ---------------------------------- [/icon] ---------------------------------------




// ---------------------------------- [title] ---------------------------------------

//[trx_title type="1|2|3|4|5|6" weight="100|300|400"700 align="left|center|right" color="#" size="small|medium|inherit|large|huge" position="left|top"right box_style="circle|square" bg_color="#" icon="" icon_image="" image_url="(url)" top="" right="" bottom="" left="" id=""]Title[/trx_title]

add_shortcode('trx_title', 'sc_title');

function sc_title($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"type" => "1",
		"align" => "left",
		"weight" => "inherit",
		"color" => "",
		//icon
		"size" => "inherit",
		"position" => "inline",
		"box_style" => "none",
		"bg_color" => "",
		"icon_color" => "",
		"icon" => "",
		"icon_image" => "",
		"image_url" => "",
		
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

    $factor = array(
		'inherit' => 1,
		'small' => 0.35,
		'medium' => 0.55,
		'large' => 1.2,
		'huge' => 2 );

	$align = $align != 'none' ? $align : '';
	$box_style = $box_style != 'none' ? $box_style : '';
	$icon = $icon != 'none' ? $icon : '';
	$bg_color = $bg_color != 'none' ? $bg_color : '';
	if ($image_url > 0) {
		$attach = wp_get_attachment_image_src( $image_url, 'full' );
		if (isset($attach[0]) && $attach[0]!='')
			$image_url = $attach[0];
	}
	$image_url = $image_url != 'none' ? $image_url : '';
	$icon_image = $icon_image != 'none' ? $icon_image : '';
	$position = $position != 'none' ? $position : '';
	
	 

	$type = min(6, max(1, $type));
	$font_size = get_custom_option('header_font_size_h'.$type) * $factor[$size];
	$style_icon = $icon != '' || $bg_color != '' ? 'icon' : ($image_url != '' || $icon_image != '' ? 'image' : '');
	

	$block_size = getThumbSizes(array(
								'thumb_size' => 'cub_mini',
								'thumb_crop' => true,
								'sidebar' => false ));
	$image_url = $image_url !== ''?	getResizedImageURL($image_url, $block_size['w'], $block_size['h']) : '';

	$s = ($top != '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom != '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left != '' ? 'margin-left:'.$left.'px;' : '')
		.($right != '' ? 'margin-right:'.$right.'px;' : '')
		.($weight && $weight!='inherit' ? 'font-weight:'.$weight .';' : '')
		.($color != '' ? 'color:'.$color.';' : '');

	$c = ($style_icon != '' ? ' sc_title_style_'.$style_icon : '')
		.($align !=''  ? ' sc_title_'.$align : '')
		.($box_style != '' && $style_icon != '' ? ' sc_title_icon_box_'.$box_style : '' );

	$c_ico = (' sc_icon_size_'.$size)
			.($position != '' ?  ' sc_icon_'.$position : ' sc_icon_inline')
			.($box_style != '' || $bg_color != '' ? ' sc_icon_box sc_icon_box_'.$box_style : '')
			.($icon!='' ? ' '.$icon : '');

	$s_ico = ($style_icon == 'icon' ? 'font-size: '.$font_size.'px; line-height: '.$font_size.'px; '.($icon_color != '' ? 'color:'.$icon_color.';' : '') : '')
			.($style_icon == 'image' ? 'background-image:url('.($image_url != '' ? $image_url : ($icon_image !='' ? get_template_directory_uri().'/images/icons/'.$icon_image.'.png' : '' )).');' : ''  )
			.('width: '.$font_size.'px;')
			.('height: '.$font_size.'px;')
			.($bg_color != '' ? 'background-color: '.$bg_color.';' : '');


	$icons = $style_icon != '' ? '<span class="sc_icon '.$c_ico.'" '.($s_ico != '' ? 'style="'.$s_ico.'"' : '').'></span>' : '';	

	$icon_left_top = $icon_right = '';
	if($position == 'left' || $position == 'top' || $position == 'inline' ){
		$icon_left_top = $icons;
	} else if($position == 'right'){
		$icon_right = $icons;
	}

	return '<h'.$type.($id ? ' id="sc_title_'.$id.'"' : '').' class="sc_title '.$c.'"'.($s!='' ? ' style="'.$s.'"' : '').'>'
		.$icon_left_top.do_shortcode($content).$icon_right
		.'</h'.$type.'>';
}

// ---------------------------------- [/title] ---------------------------------------



// ---------------------------------- [tooltip] ---------------------------------------

// [trx_tooltip id="unique_id" title="Tooltip text here"]text[/tooltip]

add_shortcode('trx_tooltip', 'sc_tooltip');

function sc_tooltip($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"title" => ""
    ), $atts));
	return '<span'.($id ? ' id="sc_tooltip_'.$id.'"' : '').' class="sc_tooltip">'.do_shortcode($content).'<span class="sc_tooltip_item">'.$title.'</span></span>';
}
// ---------------------------------- [/tooltip] ---------------------------------------



				
// ---------------------------------- [audio] ---------------------------------------

// [trx_audio id="unique_id" url="http://webglogic.com/audio/AirReview-Landmarks-02-ChasingCorporate.mp3" controls="0|1"]

add_shortcode("trx_audio", "sc_audio");
						
function sc_audio($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"id" => "",
		"title" => "",
		"author" => "",
		"mp3" => "",
		"wav" => "",
		"src" => "",
		"url" => "",
		"image" => "",
		"controls" => "",
		"autoplay" => "",
		"width" => "100%",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));

	$image = getAttachmentID($image);

	if ($src=='' && $url=='' && isset($atts[0])) {
		$src = $atts[0];
	}
	if ($src=='') {
		if ($url) $src = $url;
		else if ($mp3) $src = $mp3;
		else if ($wav) $src = $wav;
	}

	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);

	$s = ($top !== '' ? ' margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? ' margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? ' margin-left:'.$left.'px;' : '')
		.($right !== '' ? ' margin-right:'.$right.'px;' : '')
		.($height !== '' && $height > 120 ? ' min-height:'.$height.'px;' : '')
		.($width !== '' ? ' width:'.$width.$ed.';' : '');

	$data = ($title != '' ? ' data-title="'.$title.'"' : '')
		   .($author != '' ? ' data-author="'.$author.'"' : '')
		   .($image != '' ? ' data-image="'.$image.'"' : '');

	$audio = '<audio' . ($id ? ' id="sc_audio_' . $id . '"' : '').' src="'.$src.'" '.(sc_param_is_on($controls) ? ' controls="controls"' : '').(sc_param_is_on($autoplay) && is_single() ? ' autoplay="autoplay"' : '') .$data.'></audio>';

	return getAudioFrame($audio, $image, $s);
}
// ---------------------------------- [/audio] ---------------------------------------


// ---------------------------------- [video] ---------------------------------------

// [trx_video id="unique_id" url="http://player.vimeo.com/video/20245032?title=0&amp;byline=0&amp;portrait=0" width="" height=""]

add_shortcode('trx_video', 'sc_video');

function sc_video($atts, $content = null) {
	if (in_shortcode_blogger()) return '';
	extract(shortcode_atts(array(
		"id" => "",
		"url" => "",
		"src" => "",
		"image" => "",
		"show_image" => "",
		"title" => "",
		"autoplay" => "off",
		"width" => "",
		"height" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	if ($src=='' && $url=='' && isset($atts[0])) {
		$src = $atts[0];
	}

	$image = getAttachmentID($image);

	$s = ($top !== '' ? 'margin-top:'.$top.'px;' : '')
		.($bottom !== '' ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left !== '' ? 'margin-left:'.$left.'px;' : '')
		.($right !== '' ? 'margin-right:'.$right.'px;' : '');
	$block_size = getThumbSizes(array(
								'thumb_size' => 'image_large',
								'thumb_crop' => true,
								'sidebar' => false ));
	if($show_image!='no'){
		$image_thumb = getResizedImageURL($image, $block_size['w'], $block_size['h']);
		$image_youtube = getVideoImgCode($url);
	}
	$start_frame = $show_image!='no' ? true : false;
	$url = getVideoPlayerURL($src!='' ? $src : $url);
	$output = '';
	$video = '<div class="videoThumb"><video' . ($id ? ' id="sc_video_' . $id . '"' : '') . ' class="sc_video" src="'.$url.'" width="'.$width.'" height="'.$height.'"' . 
		( is_single() ? ( $show_image!='no'  || sc_param_is_on($autoplay) ? ' autoplay="autoplay"' : '') : ($show_image!='no' ? ' autoplay="autoplay"' : '')) . ($s!='' ? ' style="'.$s.'"' : '') . ' controls="controls"></video></div>';

	if( $width == ''){
		$width = $block_size['w'];
		$height = $block_size['h'];
	} else if($width == '' || $width = '100%'){
		$width = $block_size['w'];
		$height = $block_size['h'];
	}

	if ($image && $show_image!='no') {
		$video = substituteVideo($video, $width, $height, $start_frame);
		$output = getVideoFrame($video,  $image_thumb, $title, $autoplay, $s);
		} else if ( $show_image!='no') {
			$video = substituteVideo($video, $width, $height, $start_frame);
			$output = getVideoFrame($video, $image_youtube, $title, $autoplay, $s);
			} else {
				$output = $video;
				}
	return $output;
}
// ---------------------------------- [/video] ---------------------------------------




// ---------------------------------- [zoom] ---------------------------------------

// [trx_zoom id="unique_id" border="none|light|dark"]

add_shortcode('trx_zoom', 'sc_zoom');

function sc_zoom($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"src" => "",
		"url" => "",
		"over" => "",
		"border" => "none",
		"align" => "",
		"width" => "-1",
		"height" => "-1",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => ""
    ), $atts));
	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);

	$s = ($top > 0 ? 'margin-top:' . $top . 'px !important;' : '')
		.($bottom > 0 ? 'margin-bottom:' . $bottom . 'px !important;' : '')
		.($left > 0 ? 'margin-left:' . $left . 'px !important;' : '')
		.($right > 0 ? 'margin-right:' . $right . 'px !important;' : '')
		.($width > 0 ? 'width:' . $width . $ed . ';' : '')
		.($height > 0 ? 'height:' . $height . 'px;' : '');

	if (empty($id)) $id = 'sc_zoom_'.str_replace('.', '', mt_rand());
	themerex_enqueue_script( 'elevate-zoom', get_template_directory_uri() . '/js/jquery.elevateZoom-3.0.4.min.js', array(), null, true );
	return (!sc_param_is_off($border) ? '<div class="sc_border sc_border_'.$border.'">' : '')
				.'<div'.($id ? ' id="sc_zoom_'.$id.'"' : '').' class="sc_zoom"'.($s!='' ? ' style="'.$s.'"' : '').'>'
					.'<img src="'.($src!='' ? $src : $url).'"'.($height > 0 ? ' style="height:'.$height.'px;"' : '').' border="0" data-zoom-image="'.$over.'" alt="" />'
				. '</div>'
			. (!sc_param_is_off($border) ? '</div>' : '');
}
// ---------------------------------- [/zoom] ---------------------------------------



// ---------------------------------- [banner] ---------------------------------------

// [trx_banner id="unique_id" src="image_url" width="width_in_pixels" height="height_in_pixels" title="image's_title" align="left|right"]Banner text[/banner/

add_shortcode('trx_banner', 'sc_banner');

function sc_banner($atts, $content=null){	
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
		"id" => "",
		"src" => "",
		"url" => "",
		"title" => "",
		"link" => "",
		"target" => "",
		"rel" => "",
		"popup" => "no",
		"align" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "",
		"height" => ""
    ), $atts));

	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);
	$image = $src!='' ? $src : $url;

	//image crop
	$no_crop = getThumbSizes(array(
				'thumb_size' => 'image_large',
				'thumb_crop' => true,
				'sidebar' => false ));
	$crop = array(
		"w" => $width != '' && $ed != '%' ? $width : $no_crop['w'],
		"h" => $height != '' && $ed != '%' ? $height : null
		);
	$image = getResizedImageURL($image, $crop['w'], $crop['h']);
	
	
	$s = ($top > 0 ? 'margin-top:'.$top.'px;' : '')
		.($bottom > 0 ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left > 0 ? 'margin-left:'.$left.'px;' : '')
		.($right > 0 ? 'margin-right:'.$right.'px;' : '')
		.($width > 0 ? 'width:'.$width.$ed.';' : '')
		.($height > 0 ? 'height:'.$height.'px;' : '');
	$c = (sc_param_is_on($popup) ? ' user-popup-link' : '')
		.($align && $align!='none' ? ' sc_float_'.$align : '');

	$content = do_shortcode($content);
	return '<a'.($id ? ' id="sc_banner_'.$id.'"' : '').' href="'.($popup == 'yes' ? '#sc_popup_'.$link : $link).'" class="sc_banner '.$c.'"'
		.(!empty($target) ? ' target="'.$target.'"' : '') 
		.(!empty($rel) ? ' rel="'.$rel.'"' : '')
		.($s!='' ? ' style="'.$s.'"' : '')
		.'>'
		.'<img src="'.$image.'" class="sc_banner_image" border="0" alt="" />'
		.(trim($title) ? '<span class="sc_banner_title">'.$title.'</span>' : '')
		.(trim($content) ? '<span class="sc_banner_content">'.$content.'</span>' : '')
		.'</a>';
}

// ---------------------------------- [/banner] ---------------------------------------


// ---------------------------------- [event] ---------------------------------------


add_shortcode('trx_events', 'sc_events');

function sc_events($atts, $content=null){
	if (in_shortcode_blogger()) return '';
    extract(shortcode_atts(array(
    	"id" => "",
    	"ids" => "",
		"count" => "1",
		"cat" 	=> "",
		"style" => "",
		"top" => "",
		"bottom" => "",
		"left" => "",
		"right" => "",
		"width" => "-1",
		"height" => ""
    ), $atts));

	if (!empty($ids)) {
		$posts = explode(',', str_replace(' ', '', $ids));
		$count = count($posts);
	}

	$args = array(
		'post_type' 	 => 'tribe_events',
		'orderby'		 => 'date',
		'order' 		 => 'DESC',
		'post_status' 	 => 'publish',
		'post_password'  => '',
		'posts_per_page' => $count,
		'eventDisplay' 	 => 'custom',
	);

	if( $ids != ''){
		$args['post_in'] = $posts;
	}


	if(!empty($cat)) {
		if((int)$cat > 0) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'tribe_events_cat',
					'field'	=> 'id',
					'terms' => $cat
				)
			);
		}
		else {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'tribe_events_cat',
					'field'	=> 'slug',
					'terms' => $cat
				)
			);
		}
	}
	// The Query
	$THEMEREX_sc_event_counter = 0;
	$query = new WP_Query( $args );
	$output = '';

	$output .= '<div '.($id ? ' id="sc_event_'.$id.'"' : '').' class="sc_event">';

	$ed = themerex_substr($width, -1)=='%' ? '%' : 'px';
	$width = (int) str_replace('%', '', $width);


	$s = ($top > 0 ? 'margin-top:'.$top.'px;' : '')
		.($bottom > 0 ? 'margin-bottom:'.$bottom.'px;' : '')
		.($left > 0 ? 'margin-left:'.$left.'px;' : '')
		.($right > 0 ? 'margin-right:'.$right.'px;' : '')
		.($width > 0 ? 'width:'.$width.$ed.';' : '')
		.($height > 0 ? 'height:'.$height.'px;' : '');

	while ( $query->have_posts() ) { 
		$query->the_post();
		$THEMEREX_sc_event_counter++;
		$query_id = get_the_ID();


		$event_date = $query->post->EventStartDate;
		$temp_date = strtotime($event_date);

		$thumb_sizes = getThumbSizes(array(
			'thumb_size' => 'image_large',
			'thumb_crop' => true,
			'sidebar' => false
		));
		$post_thumb = getResizedImageTag($query_id, $thumb_sizes['w'], $thumb_sizes['h']);
		
		$event_date = date('d F Y @ h:i a', $temp_date);

		$output .= '<div id="sc_event_item_'.$query_id.'" class="sc_event_item" '.($s!='' ? ' style="'.$s.'"' : '').'>';

		$output .= $post_thumb ? '<div class="sc_columns_2 sc_columns_indent"> <div class="sc_columns_item">' : '';

		$output .= '<h2><a href="'.get_permalink().'">'.getPostTitle($query_id).'</a></h2>';
		$output .= '<div class="startDate">'.$event_date.'</div>';
		$output .= '<div class="eventExcerpt">'.$query->post->post_excerpt.'</div>';
		//$output .= '<div>'.wp_get_attachment_url(get_post_thumbnail_id($query_id)).'</div>';
		$output .= '<div class="eventMore">'.do_shortcode('[trx_button skin="dark" style="bg" link="'.get_permalink().'" size="big" fullsize="no" target="no" popup="no" text="'.__('Event details', 'themerex').'"]').'</div>';
		
		$output .= $post_thumb ? '</div> <div class="sc_columns_item">'.$post_thumb.'</div></div>' : '';

		$output .= '</div>';

	}
	$output .= '</div>';

    return $output;
}

// ---------------------------------- [/event] ---------------------------------------
?>
