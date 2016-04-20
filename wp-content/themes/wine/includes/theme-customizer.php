<?php
// Redefine colors in styles
$THEMEREX_custom_css = "";
$res_layouts = get_theme_option('responsive_layouts') == 'yes';

function getThemeCustomStyles() {
	global $THEMEREX_custom_css;
	return $THEMEREX_custom_css;
}

function addThemeCustomStyle($style) {
	global $THEMEREX_custom_css;
	$THEMEREX_custom_css .= " {$style} \r\n";
}


function prepareThemeCustomStyles() {

	// Custom font
	$fonts = getThemeFontsList(false);
	$theme_font = get_custom_option('theme_font');
	$header_font = get_custom_option('header_font');

	$theme_color = get_custom_option('theme_color');
	$theme_accent_color = get_custom_option('theme_accent_color');
	$background_color = get_custom_option('bg_color');

	$logo_widht = get_custom_option('logo_block_width');

	//theme fonts
	if (isset($fonts[$theme_font])) {
		addThemeCustomStyle('
			body, button, input, select, textarea { font-family: \''.$theme_font.'\', '.$fonts[$theme_font]['family'].'; }'); 
	}
	// heading fonts
	if (isset($fonts[$header_font])) {
		addThemeCustomStyle(
			(get_theme_option('show_theme_customizer') == 'yes' ? '.custom_options .co_label, .custom_options .co_header span, ' : '').
			'h1, h2, h3, h4, h5, h6,
			.h1,.h2,.h3,.h4,.h5,.h6,
			#header,
			.logoHeader, .subTitle,
			.widget_calendar table caption,
			.sc_button,
			.widget_calendar,
			.widget_search .searchFormWrap .searchSubmit,
			.sc_video_frame .sc_video_frame_info_wrap .sc_video_frame_info .sc_video_frame_player_title,
			.widget_popular_posts .ui-tabs-nav li a,
			.sc_quote.sc_quote_style_2,
			.sc_tabs ul.sc_tabs_titles li a,
			.sc_testimonials_item_quote,
			.sc_testimonials_item_user,
			.sc_price_item,
			.sc_pricing_table .sc_pricing_item ul li.sc_pricing_title,
			.sc_skills_arc .sc_skills_legend li,
			.sc_skills_counter,
			.sc_countdown_flip .flip-clock-wrapper ul,
			.sc_countdown_round .countdown-amount,
			.subCategory .categoryDescription{ font-family: \''.$header_font.'\',\''.$theme_font.'\', '.$fonts[$header_font]['family'].'; }'); 
	}
	

	//Custom heading H1-H6
	function typography_header( $width='', $cutter=1){
	
		$header_size = array(
			1 => array( 1=>1, 2=>1, 3=>1, 4=>1, 5=>1, 6=>1),
			2 => array( 1=>1.5, 2=>1.5, 3=>1.5, 4=>1.5, 5=>1.1, 6=>1),
			3 => array( 1=>2.5, 2=>2.5, 3=>2.5, 4=>2, 5=>1.1, 6=>1.1)
		);
		$media = $width != '';
		$hCounter = 1;
		$media ? addThemeCustomStyle('@media (max-width: '.$width.'px) {') : '' ;
		while( $hCounter <= 6 ){
			$heading_array = array();
			$heading_array[] = 'font-size:'.getCssValue( get_custom_option('header_font_size_h'.$hCounter)/$header_size[$cutter][$hCounter]).'; ';
			$heading_array[] = (get_custom_option('header_font_spacing_h'.$hCounter) != '' ? 'letter-spacing:'.getCssValue(get_custom_option('header_font_spacing_h'.$hCounter)).'; ' : '' );
			$heading_array[] = get_custom_option('header_font_uppercase_h'.$hCounter) == 'yes' ? 'text-transform: uppercase;' : 'text-transform: capitalize;';
			$heading_array[] = 'font-style:'.get_custom_option('header_font_style_h'.$hCounter).';';
			$heading_array[] = 'font-weight:'.get_custom_option('header_font_weight_h'.$hCounter).';';
			$heading_array[] = 'line-height:'.getCssValue(get_custom_option('header_line_height_h'.$hCounter)).';'; 
	
			$extra_h2 = $hCounter == 4 ? ', .sc_video_frame .sc_video_frame_info_wrap .sc_video_frame_info .sc_video_frame_player_title' : '';
	
			addThemeCustomStyle('h'.$hCounter.$extra_h2.'{ '.( !empty($heading_array) ? join(' ', $heading_array) : '').' }');
			$hCounter++;
		}	
		$media ? addThemeCustomStyle('}') : '' ;
	}
	typography_header();
	typography_header(1015,2);
	typography_header(449,3);
		

	//Custom logo style
	if( get_custom_option('logo_type') == 'logoImage'){
		//images style
		addThemeCustomStyle('
			.wrap.logoImageStyle .logoHeader{ width:'.$logo_widht.'px; }
			.wrap.logoImageStyle .logo_bg_size{ border-width: 45px '.($logo_widht/2).'px 0 '.($logo_widht/2).'px; }
			.logoSeparator .wrapTopMenu .topMenu #mainmenu{ padding: 70px '.($logo_widht/2+15).'px 0 0; }
			.logoSeparator .wrapTopMenu .topMenu #mainmenu_right { padding: 70px 0 0 '.($logo_widht/2+15).'px;}' );
	} else {
		//logo text style
		$style_logo_array  = array();
		$style_logo_array[] = 'font-family:"'.get_custom_option('logo_font').'";'; 
		$style_logo_array[] = 'font-style:'.get_custom_option('logo_font_style').';'; 
		$style_logo_array[] = 'font-weight:'.get_custom_option('logo_font_weight').';'; 
		$style_logo_array[] = 'font-size:'.get_custom_option('logo_font_size').'px;'; 
		$style_logo_array[] = 'line-height:'.get_custom_option('logo_font_size').'px;'; 
		addThemeCustomStyle('
			.wrap.logoTextStyle .logoHeader{ width:'.$logo_widht.'px; '.(!empty($style_logo_array) ? join(' ', $style_logo_array) : '').' }
			.wrap.logoTextStyle .logo_bg_size{ border-width: 45px '.($logo_widht/2).'px 0 '.($logo_widht/2).'px; }
			.logoSeparator .wrapTopMenu .topMenu #mainmenu{ padding: 0 '.($logo_widht/2+15).'px 0 0; }
			.logoSeparator .wrapTopMenu .topMenu #mainmenu_right { padding: 0 0 0 '.($logo_widht/2+15).'px;}' );
	}

	//background custom style
	if( get_custom_option('body_style') == 'boxed'){
				$style_custom_array  = array();
		get_custom_option('bg_color') != '' ? $style_custom_array[] = get_custom_option('bg_color') : '';
		if ( get_custom_option('bg_custom_image') != ''){
			$body_image = 'url('.get_custom_option('bg_custom_image').')' ;
			$body_image_x = get_custom_option('bg_custom_image_position_x');
			$body_image_y = get_custom_option('bg_custom_image_position_y');
			$body_image_r = get_custom_option('bg_custom_image_repeat');
			$body_image_a = get_custom_option('bg_custom_image_attachment');
			addThemeCustomStyle('
			body{ 
				background: '.$body_image.';
				background-position-x: '.$body_image_x.';
				background-position-y: '.$body_image_y.';
				background-repeat: '.$body_image_r.';
				background-attachment: '.$body_image_a.';
			;}
			
			');
		}
		addThemeCustomStyle('
			.wrap{ background-color: '.(!empty($style_custom_array) ? join(' ', $style_custom_array) : '').';}');

	}

	//theme color
	if($theme_color != ''){
		addThemeCustomStyle('
		/*color*/
		a, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover,
		.h1 a:hover,.h2 a:hover,.h3 a:hover,.h4 a:hover,.h5 a:hover,.h6 a:hover,
		.logoHeader .logoImg,
		#header .rightTop a,
		.menuStyle2 .wrapTopMenu .topMenu > ul > li > ul li.sfHover > a,
		.menuStyle2 .wrapTopMenu .topMenu > ul > li > ul li a:hover,
		.menuStyle2 .wrapTopMenu .topMenu > ul > li > ul li.menu-item-has-children:after,
		.widgetWrap ul > li,
		.widgetWrap ul > li a:hover,
		.widget_recent_comments ul > li a,
		.widget_twitter ul > li:before,
		.widget_twitter ul > li a,
		.widget_rss ul li a,
		.widget_trex_post .ui-tabs-nav li a,
		.widget_top10 .ui-tabs-nav li a,
		.nav_pages ul li a:hover,
		.postFormatIcon:before,
		.comments .commentModeration .icon,
		.sc_button.sc_button_skin_dark.sc_button_style_line:hover,
		.sc_button.sc_button_skin_global.sc_button_style_line,
		.sc_quote, blockquote,
		.sc_toggl.sc_toggl_style_1 .sc_toggl_item .sc_toggl_title:hover,
		.sc_toggl.sc_toggl_style_2 .sc_toggl_item .sc_toggl_title:hover,
		.sc_dropcaps.sc_dropcaps_style_3 .sc_dropcap,
		.sc_highlight.sc_highlight_style_2 ,
		.sc_pricing_table.sc_pricing_table_style_1 .sc_pricing_price,
		.sc_pricing_table.sc_pricing_table_style_2 .sc_pricing_price,
		.sc_tabs.sc_tabs_style_2 ul li a,
		.sc_tabs.sc_tabs_style_3 ul li.ui-tabs-active a,
		.sc_tabs.sc_tabs_style_3 ul.sc_tabs_titles li.ui-tabs-active a,
		.sc_blogger.style_list li a:hover,
		.sc_testimonials .sc_testimonials_item_author .sc_testimonials_item_user,
		.sc_reservation .sc_reservation_title,
		ul.sc_list.sc_list_style_iconed li:before,
		ul.sc_list.sc_list_style_iconed.sc_list_marked_yes li,
		ul.sc_list.sc_list_style_iconed li.sc_list_marked_yes ,
		.sc_button.sc_button_skin_global.sc_button_style_line,
		.sc_dropcaps.sc_dropcaps_style_3 .sc_dropcap,
		.sc_team.sc_team_item_style_1 .sc_team_item_title,
		.sc_team.sc_team_item_style_2 .sc_team_item_position,
		.sc_countdown .flip-clock-wrapper ul li a div div.inn,
		.sc_contact_info .sc_contact_info_wrap .sc_contact_info_lable,
		.isotopeWrap .fullItemWrap .fullItemClosed:hover,
		.postInfo .postReview .revBlock .ratingValue,
		.reviewBlock .reviewTab .revTotalWrap .revTotal .revRating,
		.reviewBlock .reviewTab .revWrap .revBlock .ratingValue,
		.isotopeWrap .isotopeItem .isotopeContent .isotopeTitle a:hover,
		.postBox .postBoxItem .postBoxInfo h5 a:hover {color: '.$theme_color.';}

		input[type="search"]::-webkit-search-cancel-button{color: '.$theme_color.';}

		/*border*/
		.nav_pages ul li a:hover,
		.wrapTopMenu .topMenu > ul > li > ul,
		.menuStyle1 .wrapTopMenu .topMenu > ul > li > ul > li ul,
		.menuStyle2 .wrapTopMenu .topMenu > ul > li > ul > li ul,
		.widget_trex_post .ui-tabs-nav li a,
		.widget_top10 .ui-tabs-nav li a,
		.sc_button.sc_button_skin_dark.sc_button_style_line:hover,
		.sc_button.sc_button_skin_global.sc_button_style_line,
		.sc_tooltip,
		.sc_tooltip .sc_tooltip_item,
		.sc_tabs.sc_tabs_style_2 ul li a,
		.sc_tabs.sc_tabs_style_2 ul li + li a,
		.sc_tabs.sc_tabs_style_2 ul.sc_tabs_titles li.ui-tabs-active a,
		.sc_tabs.sc_tabs_style_3 ul.sc_tabs_titles li.ui-tabs-active a,
		.sc_tabs.sc_tabs_style_2 .sc_tabs_array,
		.sc_tabs.sc_tabs_style_3 ul li.ui-tabs-active a,
		.sc_tabs.sc_tabs_style_3 .sc_tabs_array,
		.sc_blogger.style_date .sc_blogger_item .sc_blogger_date,
		.sc_banner:before,
		.sc_button.sc_button_skin_global.sc_button_style_line{ border-color: '.$theme_color.'; }

		.sc_tooltip .sc_tooltip_item:before,
		.logoStyleBG .logoHeader .logo_bg_size,
		.isotopeWrap .isotopeItem .isotopeRating:after { border-color: '.$theme_color.' transparent transparent transparent; }

		.menuStyle1 #header ul > li > ul:before,
		.buttonScrollUp { border-color: transparent transparent '.$theme_color.' transparent ; }

		.widget_recent_reviews .post_item .post_wrapper .post_info .post_review:after{ border-color: transparent transparent transparent '.$theme_color.'; }

		.sc_testimonials.sc_testimonials_style_1 .sc_testimonials_item_author_show .sc_testimonials_item_quote:after { border-left-color: '.$theme_color.'; }

		.widget_calendar table tbody td#today { outline: 1px solid '.$theme_color.'; }

		/*background*/
		.logoStyleBG .logoHeader .logoImg,
		.userMenuArea .openUserArea,
		.userMenuArea .openUserArea:before,
		.userMenuArea .openUserArea:after,
		.userMenuArea .userMenuWrap,
		#header .openTopMenu,
		.openMobileMenu,
		.menuStyle1 .wrapTopMenu .topMenu > ul > li > ul,
		.menuStyle1 .wrapTopMenu .topMenu > ul > li > ul > li ul,
		.menuStyle2 .wrapTopMenu .topMenu > ul > li > ul li a:before,
		.menuStyle1 #header ul > li > ul,
		.menuStyle1 #header ul > li > ul > li ul,
		.menuStyle2 #header ul > li > ul:before,
		.widget_calendar table tbody td a:before,
		.widget_calendar table tbody td a:hover, 
		.widget_tag_cloud a:hover,
		.widget_trex_post .ui-tabs-nav li.ui-state-active a,
		.widget_recent_reviews .post_item .post_wrapper .post_info .post_review .post_review_number,
		.widget_recent_reviews .post_item .post_wrapper .post_info .post_review .review_icon,
		.widget_top10 .ui-tabs-nav li.ui-state-active a,
		.nav_pages ul li span,
		.sc_button.sc_button_skin_global.sc_button_style_bg,
		.sc_video_frame.sc_video_active:before,
		.sc_toggl.sc_toggl_style_2.sc_toggl_icon_show .sc_toggl_item .sc_toggl_title:after,
		.sc_toggl.sc_toggl_style_3 .sc_toggl_item .sc_toggl_title ,
		.sc_dropcaps.sc_dropcaps_style_1 .sc_dropcap,
		.sc_tooltip .sc_tooltip_item,
		.sc_table.sc_table_style_2 table thead tr th,
		.sc_highlight.sc_highlight_style_1,
		.sc_pricing_table.sc_pricing_table_style_2 .sc_pricing_item ul li.sc_pricing_title,
		.sc_pricing_table.sc_pricing_table_style_3 .sc_pricing_item ul,
		.sc_pricing_table.sc_pricing_table_style_3 .sc_pricing_item ul li.sc_pricing_title,
		.sc_scroll .sc_scroll_bar .swiper-scrollbar-drag,
		.sc_skills_bar .sc_skills_item .sc_skills_count ,
		.sc_skills_bar.sc_skills_vertical .sc_skills_item .sc_skills_count ,
		.sc_icon.sc_icon_box,
		.sc_icon.sc_icon_box_circle,
		.sc_icon.sc_icon_box_square,
		.sc_tabs.sc_tabs_style_2 ul.sc_tabs_titles li.ui-tabs-active a,
		.sc_slider.sc_slider_dark .slider-pagination-nav span.swiper-active-switch ,
		.sc_slider.sc_slider_light .slider-pagination-nav span.swiper-active-switch,
		.sc_testimonials.sc_testimonials_style_1 .sc_testimonials_item_quote,
		.sc_testimonials.sc_testimonials_style_2 .sc_testimonials_title:after,
		.sc_testimonials.sc_testimonials_style_2 .sc_slider_swiper.sc_slider_pagination .slider-pagination-nav span.swiper-active-switch,
		.sc_blogger.style_date .sc_blogger_item:before,
		.sc_button.sc_button_skin_global.sc_button_style_bg,
		.sc_video_frame.sc_video_active:before,
		.sc_loader_show:before,
		.sc_toggl.sc_toggl_style_2.sc_toggl_icon_show .sc_toggl_item .sc_toggl_title:after ,
		.sc_toggl.sc_toggl_style_3 .sc_toggl_item .sc_toggl_title ,
		.sc_dropcaps.sc_dropcaps_style_1 .sc_dropcap,
		.sc_team .sc_team_item .sc_team_item_socials ul li a:hover,
		.postInfo .postReview .revBlock.revStyle100 .ratingValue,
		.reviewBlock .reviewTab .revWrap .revBlock.revStyle100 .ratingValue,
		.post-password-required .post-password-form input[type="submit"]:hover,
		.sc_button.sc_button_skin_dark.sc_button_style_bg:hover, 
		.sc_button.sc_button_skin_global.sc_button_style_bg,
		.sc_blogger.style_date .sc_blogger_item .sc_blogger_date,
		.sc_countdown.sc_countdown_round .sc_countdown_counter .countdown-section .countdown-amount,
		.sc_skills_counter .sc_skills_item.sc_skills_style_3 .sc_skills_count,
		.sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_count,
		.sc_skills_counter .sc_skills_item.sc_skills_style_4 .sc_skills_info,
		.isotopeWrap .isotopeItem .isotopeRating span.rInfo,
		.header_contact,
		.header_booking,
		.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current,
		.mejs-controls .mejs-time-rail .mejs-time-current { background-color: '.$theme_color.'; }


		::selection { color: #fff; background-color:'.$theme_color.';}
		::-moz-selection { color: #fff; background-color:'.$theme_color.';}
		a.sc_icon:hover{ background-color: '.$theme_color.' !important;}
		');
	}


	if( $theme_accent_color != ''){
		addThemeCustomStyle('
			.topTitle.subCategoryStyle1 .subCategory,
			.themeDark .isotopeFiltr ul li.active a,
			.isotopeFiltr ul li a{ background-color: '.$theme_accent_color.' }');
	}

	if( $background_color != ''){
		addThemeCustomStyle('{ background-color: '.$background_color.' }');
	}
	
	// Custom menu
	if (get_theme_option('menu_colored')=='yes') {
		$menu_name = 'mainmenu';
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			if (is_object($menu) && $menu) {
				$menu_items = wp_get_nav_menu_items($menu->term_id);
				$menu_styles = '';
				$menu_slider = get_theme_option('menu_slider')=='yes';
				if (count($menu_items) > 0) {
					foreach($menu_items as $k=>$item) {
		//				if ($item->menu_item_parent==0) {
							$cur_accent_color = '';
							if ($item->type=='taxonomy' && $item->object=='category') {
								$cur_accent_color = get_category_inherited_property($item->object_id, 'theme_accent_color');
							}
							if ((empty($cur_accent_color) || is_inherit_option($cur_accent_color)) && isset($item->classes[0]) && !empty($item->classes[0])) {
								$cur_accent_color = (themerex_substr($item->classes[0], 0, 1)!='#' ? '#' : '').$item->classes[0];
							}
							if (!empty($cur_accent_color) && !is_inherit_option($cur_accent_color)) {
								$menu_styles .= ($item->menu_item_parent==0 ? "#header_middle_inner #mainmenu li.menu-item-{$item->ID}.current-menu-item > a," : '')
									. "
									#header_middle_inner #mainmenu li.menu-item-{$item->ID} > a:hover,
									#header_middle_inner #mainmenu li.menu-item-{$item->ID}.sfHover > a { background-color: {$cur_accent_color} !important; }
									#header_middle_inner #mainmenu li.menu-item-{$item->ID} ul { background-color: {$cur_accent_color} !important; } ";
							}
							if ($menu_slider && $item->menu_item_parent==0) {
								$menu_styles .= "
									#header_middle_inner #mainmenu li.menu-item-{$item->ID}.blob_over:not(.current-menu-item) > a:hover,
									#header_middle_inner #mainmenu li.menu-item-{$item->ID}.blob_over.sfHover > a { background-color: transparent !important; } ";
							}
		//				}
					}
				}
				if (!empty($menu_styles)) {
					addThemeCustomStyle($menu_styles);
				}
			}
		}
	}
	
	//main menu responsive width
	
	$menu_responsive = get_theme_option('responsive_menu_width').'px';
	addThemeCustomStyle("
		@media (max-width: {$menu_responsive}) { 
			.openMobileMenu{ display: block; }
			.menuStyleFixed #header.fixedTopMenuShow .menuFixedWrap{ position: static !important; }
			.wrapTopMenu .topMenu { width: 100%;  }
			.wrapTopMenu .topMenu > ul{ display: none; border-top: 1px solid #fff;  clear:both; }
			.wrapTopMenu .topMenu > ul li{ display: block; clear:both;}
			.wrapTopMenu .topMenu > ul li a{ }
			.wrapTopMenu .topMenu > ul li ul{ position: static !important; width:auto !important; margin:0 !important; border: none !important; text-align:center; background-color: rgba(255,255,255,0.2) !important; }
			.wrapTopMenu .topMenu > ul > li > ul:before{ display:none;}
			.openTopMenu{ display: none; }
			.wrapTopMenu .topMenu > ul > li.sfHover > a:before,
			.wrapTopMenu .topMenu > ul > li > a{ line-height: 45px !important; color: #fff !important; opacity:1 !important; height: auto !important; }
			.wrapTopMenu .topMenu > ul > li > a:hover:before{ left:10px; right:10px; }
			.hideMenuDisplay .wrapTopMenu{ min-height: 45px !important; height: auto !important;}
			.hideMenuDisplay .usermenuArea > ul li a{ color: #fff !important; }

			.logoSeparator .wrapTopMenu{ background-color: $theme_color !important; }
		}
	");



	// Main menu height
	$menu_height = (int) get_theme_option('menu_height');
	if ($menu_height > 20) {
		addThemeCustomStyle("
			#mainmenu > li > a { height: {$menu_height}px !important; line-height: {$menu_height}px !important; }
			#mainmenu > li ul { top: {$menu_height}px !important; }
			#header_middle { min-height: {$menu_height}px !important; } ");
	}
	// Submenu width
	$menu_width = (int) get_custom_option('menu_width');
	if ($menu_width > 50) {
		addThemeCustomStyle('
			.wrapTopMenu .topMenu > ul > li > ul { width: '.($menu_width).'px; margin: 0 0 0 -'.(($menu_width+30)/2).'px; }
			#mainmenu > li:nth-child(n+6) ul li ul { left: -'.($menu_width).'px; } ');
	}

	//woocommerce
	if( function_exists('is_woocommerce') ){
	addThemeCustomStyle('
		/*wooc bg*/
		.woocommerce #content input.button, 
		.woocommerce #respond input#submit, 
		.woocommerce a.button, 
		.woocommerce button.button, 
		.woocommerce input.button, 
		.woocommerce-page #content input.button, 
		.woocommerce-page #respond input#submit, 
		.woocommerce-page a.button, 
		.woocommerce-page button.button, 
		.woocommerce-page input.button,
		.woocommerce #content div.product .woocommerce-tabs ul.tabs li,
		.woocommerce div.product .woocommerce-tabs ul.tabs li,
		.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li,
		.woocommerce-page div.product .woocommerce-tabs ul.tabs li {font-family: \''.$header_font.'\',\''.$theme_font.'\', '.$fonts[$header_font]['family'].'; }

		.woocommerce #content input.button:hover, 
		.woocommerce #respond input#submit:hover, 
		.woocommerce a.button, 
		.woocommerce button.button, 
		.woocommerce input.button, 
		.woocommerce-page #content input.button:hover, 
		.woocommerce-page #respond input#submit:hover, 
		.woocommerce .woocommerce-pagination ul.page-numbers li span.current,
		.woocommerce-page .woocommerce-pagination ul.page-numbers li span.current{ background-color: '.$theme_color.' !important; }


		.woocommerce .woocommerce-pagination ul.page-numbers li a:hover,
		.woocommerce-page .woocommerce-pagination ul.page-numbers li a:hover,
		.woocommerce ul.products li.product .price,
		.woocommerce-page ul.products li.product .price,
		.woocommerce #content div.product p.price,
		.woocommerce #content div.product span.price,
		.woocommerce div.product p.price,
		.woocommerce div.product span.price,
		.woocommerce-page #content div.product p.price,
		.woocommerce-page #content div.product span.price,
		.woocommerce-page div.product p.price,
		.woocommerce-page div.product span.price { color: '.$theme_color.' !important;}

		.woocommerce .woocommerce-pagination ul.page-numbers li a:hover, 
		.woocommerce-page .woocommerce-pagination ul.page-numbers li a:hover,
		.woocommerce ul.products li.product:hover a img,
		.woocommerce-page ul.products li.product:hover a img,
		.woocommerce a.button, 
		.woocommerce button.button, 
		.woocommerce input.button { border-color: '.$theme_color.' !important;}


		.woocommerce .star-rating span:before,
		.woocommerce-page .star-rating span:before,
		.woocommerce p.stars a:after,
		.woocommerce-page p.stars a:after{ color: '.$theme_accent_color.' !important; }


		.woocommerce span.onsale,
		.woocommerce-page span.onsale{  background-color: '.$theme_accent_color.' !important; }

	');
	}

	// Custom css from theme options
	$css = get_custom_option('custom_css');
	if (!empty($css)) {
		addThemeCustomStyle($css);
	}
	
	return getThemeCustomStyles();
};
?>