<?php 
if (!function_exists('getPostInfo') ) {
	function getPostInfo($arg,$post_data,$alt=true) {

		if ( sc_param_is_on(get_custom_option('show_post_info',null,$post_data['post_id'])) ) { 

			$array_info = explode(',', $arg);

			$array_list = array();

			$array_list['date'] = $post_data['post_date'] ? '<span class="postSpan postDate">'.($alt ? __('Posted ', 'themerex') : '' ).'<a href="'.$post_data['post_link'].'" >'.date('F j | g:i A',$post_data['post_date_stamp']).'</a></span>' : '';
			$array_list['author'] = $post_data['post_author'] ? '<span class="postSpan postAuthor">'.($alt ? __('by ', 'themerex') : '' ).'<a href="'.$post_data['post_author_url'].'">'.$post_data['post_author'].'</a></span>' : '';
			$array_list['category'] = $post_data['post_categories_links']!='' ? '<span class="postSpan postCategory">'.$post_data['post_categories_links'].'</span>' : '' ;
			$array_list['comments'] = $post_data['post_comments'] > 0 ? '<span class="postSpan postComment">'.($alt ? __('Comment ', 'themerex') : '' ).'<a href="'.$post_data['post_comments_link'].'">'.$post_data['post_comments'].'</a></span>' : '';
			$array_list['tags'] = $post_data['post_tags_links']!='' ? '<span class="postSpan postTags">'. ($alt ? __('Tags: ', 'themerex') : '' ).$post_data['post_tags_links'] . '</span>': '';
			$array_list['views'] = $post_data['post_views'] ? '<span class="postSpan postViews">'.($alt ? __('View ', 'themerex') : '' ).$post_data['post_views'].'</span>' : '';
			//review
			$array_list['review'] = '';
			if( $post_data['post_reviews_author'] && sc_param_is_on( get_custom_option('show_reviews',null,$post_data['post_id']) ) ){
				$avg_author = $post_data['post_reviews_'.(get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
				$rating_max = get_custom_option('reviews_max_level');
				$array_list['reviews'] = '<span class="postSpan postReview" title="'.sprintf(__('Rating - %s/%s','themerex'), $avg_author,$rating_max).'">'.getReviewsSummaryStars($avg_author,false,false).'</span>';
			}
			//post edit
			$array_list['editor'] = '';
			if( is_singular() ){
				if ($post_data['post_edit_enable'] || $post_data['post_delete_enable']) {
					if ($post_data['post_edit_enable']) { 
						$array_list['editor'] = do_shortcode('[trx_button id="frontend_editor_icon_edit" skin="dark" style="bg" size="mini" fullsize="no" icon="icon-pencil" target="no" popup="no" text="'.__('Edit', 'themerex').'"]');
					} if ($post_data['post_delete_enable']) { 
						$array_list['editor'] .= do_shortcode('[trx_button id="frontend_editor_icon_delete" skin="global" style="bg" size="mini" fullsize="no" icon="icon-cancel-bold"  target="no" popup="no" left="5" text="'.__('Delete', 'themerex').'"]');
						
					} 
				}
			}

			//sticky
			$array_list['sticky'] = is_sticky() && !is_singular() ? '<div class="stickyPost"><span class="postSticky">'.__('Sticky Post','themerex').'</span></div>' : '';

			//separator
			$array_list['br1'] = '</div><div class="postWrap">';
			$array_list['br2'] = '</div><div class="postWrap">';

			$post_info_html = '';
			foreach ( $array_info as $array_infos ) {
				 $post_info_html .= $array_list[$array_infos];
			}

			return '<div class="postInfo hoverUnderline"><div class="postWrap">'.$post_info_html.'</div></div>';

		}	
	}
}