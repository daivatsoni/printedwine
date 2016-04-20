<?php
/*
 * The template for displaying one article of blog streampage with style "Excerpt"
 * 
 * @package Wine
*/

global $THEMEREX_ajaxcrop;

$post_classes = get_post_class('blogStreampage'.
					($opt['number']%2==0 ? ' even' : ' odd').
					($opt['number']==1 ? ' first' : '').
					($opt['number']==$opt['posts_on_page']? ' last' : '').
					($opt['add_view_more'] ? ' viewmore' : '').
					(get_custom_option('show_post_icon',null,$post_data['post_id']) == 'no' ? ' emptyPostFormatIcon' : '').
					(get_custom_option('show_post_title',null,$post_data['post_id']) == 'no' || !$post_data['post_title']? ' emptyPostTitle' : '').
					(get_custom_option('show_post_info',null,$post_data['post_id']) == 'no' ? ' emptyPostInfo' : ''));

$body_style = get_custom_option('body_style');
$blog_item_style = get_custom_option('blog_item_style',null,$post_data['post_id']);
$blog_style = $blog_item_style != '' ? $blog_item_style : get_custom_option('blog_style');
$side_bar = get_custom_option('show_sidebar_main');
$fullwidth = get_custom_option('show_sidebar_main') == 'fullWidth' || is_singular();
$streampage_columns = $blog_style == 'excerpt_style1' || $blog_style == 'excerpt_style2' && !is_singular();
$layout_isotope = !empty($opt['layout_isotope']) ? $opt['layout_isotope'] : false;
$main_div = ($body_style == 'wide' && $side_bar == 'fullWidth') || ($body_style == 'boxed' && $side_bar == 'fullWidth') && !$layout_isotope;
$post_icon = sc_param_is_on(get_custom_option('show_post_icon',null,$post_data['post_id']));
$show_title = get_custom_option('show_post_title', null, $post_data['post_id'])=='yes' && (get_custom_option('show_post_title_on_quotes')=='yes' || !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote')));
$post_info = sc_param_is_on(get_custom_option('show_post_info',null,$post_data['post_id'])); 
$read_more = sc_param_is_on(get_custom_option('show_single_link',null,$post_data['post_id']));

	if (in_shortcode_blogger(true)) { ?>
<div class="class="<?php echo join(' ',$post_classes).(!in_array('post', $post_classes) ? ' post' : ''); ?>" ">
<?php } else { 
	if( $layout_isotope ){ ?>
	<span class="isotopeNav isoPrev icon-left-open-big" data-nav-id=""></span>
	<span class="isotopeNav isoNext icon-right-open-big" data-nav-id=""></span>
<?php } 

	//post ARRAY
	$post_array = array();

	//icon post format
	$post_array['icon'] = '';
	if( $post_icon ){
		$post_array['icon'] .= '<div class="postFormatIcon '.getPostFormatIcon($post_data['post_format']).'"></div>';
	}

	//title
	$post_array['title'] = '';
	if ($show_title && $post_data['post_title']) { 
		$showsingleLink = sc_param_is_on(get_custom_option('show_single_link',null,$post_data['post_id'])); 
		$post_array['title'] = ('<h3 class="postTitle">')
							  .($showsingleLink ? '<a href="'.esc_url($post_data['post_link']).'">' : '')
							  .($post_data['post_title'])
							  .($showsingleLink ? '</a>' : '')
							  .('</h3>');
	} 

	//postinfo
	$post_array['postinfo'] = '';
	$post_array['postinfo'] .= getPostInfo(get_custom_option('set_post_info',null,$post_data['post_id']),$post_data,false);
		
	
	//thumb
	$post_array['thumb'] = '';
	if (!$post_data['post_protected'] && get_custom_option('show_featured_image',null,$post_data['post_id']) == 'yes' ) {
		if ($post_data['post_gallery']) {
			$post_array['thumb'] .= $post_data['post_gallery'];
		} else if ($post_data['post_video']) {
			$post_thumb = $post_data['post_thumb'] != '' ? $post_data['post_thumb'] : getVideoImgCode($post_data['post_video_url']);
			$post_array['thumb'] .= getVideoFrame($post_data['post_video'], $post_thumb);
		} else if ( $post_data['post_audio'] ){
			$post_array['thumb'] .= $post_data['post_audio'];
		} else if ($post_data['post_thumb'] && $post_data['post_format'] == 'image')  { 
			$post_array['thumb'] .=	('<div class="postThumb thumbZooom">')
								    .('<a href="'.$post_data['post_attachment'].'" data-image="'.$post_data['post_attachment'].'"><span class="icon-search thumb-ico"></span>'.$post_data['post_thumb'].'</a>')
									.('</div>');
		} else if ($post_data['post_thumb'] && $post_data['post_format'] != 'quote' && $post_data['post_format'] != 'aside') { 
			$post_array['thumb'] .= '<div class="postThumb">';
				if ($post_data['post_format']=='link' && $post_data['post_url']!='')
					$post_array['thumb'] .= '<a href="'.$post_data['post_url'].'"'.($post_data['post_url_target'] ? ' target="'.$post_data['post_url_target'].'"' : '').'>'.$post_data['post_thumb'].'</a>';
				else if ($post_data['post_link']!='')
					$post_array['thumb'] .= '<a href="'.$post_data['post_link'].'">'.$post_data['post_thumb'].'</a>';
				else
					$post_array['thumb'] .= $post_data['post_thumb']; 
			$post_array['thumb'] .= '</div>';
		} 
	}
	
	//excerpt
	$post_array['excerpt'] = '';
	if ($post_data['post_protected']) {
		$post_array['excerpt'] .= $post_data['post_excerpt']; 
	} else {
		if ($post_data['post_excerpt'] && $post_data['post_format'] == 'link') { 
			$post_array['excerpt'] .= '<a href="'.esc_url($post_data['post_link']).'"><strong>'.$post_data['post_excerpt'].'</strong></a>';
		} else if($post_data['post_excerpt']) { 
			$post_array['excerpt'] .= '<div class="post '.themerex_strtoproper($post_data['post_format']).'">';
					//excerpt
					if (($more_pos = themerex_strpos($post_data['post_content_plain'], '<span id="more-'))!==false && $THEMEREX_ajaxcrop == false) {
						$post_array['excerpt'] .= do_shortcode( themerex_substr($post_data['post_content_plain'], 0, $more_pos) );
					} else {
						$post_array['excerpt'] .= $post_data['post_excerpt']; 
					}
			$post_array['excerpt'] .= '</div>';
		}
	}


	//read more
	$post_array['more'] = '';
	$show_all = !isset($postinfo_buttons) || !is_array($postinfo_buttons  );
	$show_button_format = $post_data['post_format'] != 'aside' && $post_data['post_format'] != 'chat' && $post_data['post_format'] != 'link' && $post_data['post_format'] != 'quote';
	if (($show_all || in_array('more', $postinfo_buttons)) && !$post_data['post_protected'] && $show_button_format && $read_more) { 
		$post_array['more'] .= '<div class="readMore">'.do_shortcode('[trx_button skin="dark" style="bg" size="big" fullsize="no" link="'.$post_data['post_link'].'" text="'.__('Read more', 'themerex').'"]').'</div>';
	} 

?>
<article class="<?php echo join(' ',$post_classes).(!in_array('post', $post_classes) ? ' post' : ''); ?>">
<?php }  


//main block
echo $main_div ? '<div class="main">' : '' ;

	$columns = ($fullwidth && $streampage_columns) || $layout_isotope && ($show_title || $post_info || $post_icon);
	$columns_before = $columns ? '<div class="sc_columns_2 sc_columns_indent blogStreampageColumns"> <div class="sc_columns_item">' : '';
	$columns_sep = $columns ? '</div><div class="sc_columns_item">' : '';
	$columns_after = $columns ? '</div><!--/.sc_columns-->' : '';

	//style1
	if( $blog_style == 'excerpt_style1'){
		echo $columns_before;
		echo $post_array['icon'].$post_array['title'].$post_array['postinfo'];
		echo $columns_sep;
		echo $post_array['thumb'].$post_array['excerpt'].$post_array['more'];
		echo $columns_after;
	}

	//style2
	if( $blog_style == 'excerpt_style2'){
		echo $columns_before;
		echo $post_array['thumb'];
		echo $columns_sep;
		echo $post_array['icon'].$post_array['title'].$post_array['postinfo'].$post_array['excerpt'].$post_array['more'];
		echo $columns_after;
	}
	//style2
	if( $blog_style == 'excerpt_style3'){
		echo $post_array['icon'].$post_array['title'].$post_array['postinfo'].$post_array['thumb'].$post_array['excerpt'].$post_array['more'];
	}
	//event
	if( $blog_style == 'excerpt_event'){
		echo "@@@@@";
		echo $post_array['icon'].$post_array['title'].$post_array['postinfo'].$post_array['thumb'].$post_array['excerpt'].$post_array['more'];
	}




//main block
echo $main_div ? '</div><!-- /.main -->' : '' ;
	

	if (in_shortcode_blogger(true)) { ?>
		</div><?php 
	} else { ?>
</article>
<?php } ?>
