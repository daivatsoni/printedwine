<?php
$show_title = get_custom_option('show_post_title', null, $post_data['post_id'])=='yes' && (get_custom_option('show_post_title_on_quotes')=='yes' || !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote')));


$item_style = explode('_', get_custom_option('portfolio_item_style',null,$post_data['post_id']));

$thumb_crop = array( 'portfolio_big' => '1','portfolio_medium' => '2','portfolio_mini' => '3');
$thumb_sizes = getThumbSizes(array(
	'thumb_size' => themerex_substr($post_data['post_layout'], 0, 7) == 'portfol' ? getThumbColumns('cub',$thumb_crop[$post_data['post_layout']]) : '',
	'thumb_crop' => true,
	'sidebar' => false
));
$thumb_sizes['w'] = $thumb_sizes['w'] * $item_style[1];
$thumb_sizes['h'] = $thumb_sizes['h'] * $item_style[2];
$thumb_img = getResizedImageURL($post_data['post_attachment'], $thumb_sizes['w'], $thumb_sizes['h']);

?>

	<article class="isotopeItem <?php 
		$itemBG = get_custom_option('cube_color',null,$post_data['post_id']); 
		echo 'post_format_'.$post_data['post_format'] 
			.(' isw_'.$item_style[1])
			.($opt['number']%2==0 ? ' even' : ' odd') 
			.($opt['number']==0 ? ' first' : '') 
			.($opt['number']==$opt['posts_on_page'] ? ' last' : '')
			.($opt['add_view_more'] ? ' viewmore' : '') 
			.($itemBG !='' && !$post_data['post_thumb'] != '' ? ' showBG' : '')
			.(get_custom_option('show_filters')=='yes' 
				? ' flt_'.join(' flt_', get_custom_option('filter_taxonomy')=='categories' ? $post_data['post_categories_ids'] : $post_data['post_tags_ids'])
				: '');
		?>" data-postid="<?php echo (int) $post_data['post_id'] ?>" data-wdh="<?php echo (int) $thumb_sizes['w'] ?>" data-hgt="<?php echo (int) $thumb_sizes['h'] ?>" data-incw="<?php echo  $item_style[1] ?>" data-inch="<?php echo  $item_style[2] ?>"
			<?php echo $itemBG !='' && !$post_data['post_thumb'] != '' ? 'style="background-color: '.esc_attr($itemBG).';"' : '' ; ?>>
		<div class="isotopeItemWrap">
			
			<?php 
			//thumb
			if ($post_data['post_thumb']) { ?>
				<div class="thumb">
					<?php echo $post_data['post_format']  == 'video' ? '<span class="cube_icon icon-play-line"></span>' : ''; ?>
					<img src="<?php echo esc_url($thumb_img); ?>" alt="<?php echo $post_data['post_title'] ?>">
				</div><?php
			} 

			//review
			if( $post_data['post_reviews_author'] ){
				$avg_author = $post_data['post_reviews_'.(get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
				$rating_max = get_custom_option('reviews_max_level');
				$reviews_style = get_custom_option('reviews_style'); 
				$review_title = sprintf($rating_max<100 ? __('Rating: %s from %s', 'themerex') : __('Rating: %s', 'themerex'), number_format($avg_author,1).($rating_max < 100 ? '' : '%'), $rating_max.($rating_max < 100 ? '' : '%'));?>

				<div class="isotopeRating" title="<?php echo $review_title; ?>"><span class="rInfo"><?php echo $avg_author; ?></span><span class="rDelta"><?php echo $rating_max < 100 ? '<span class="icon-star"></span>' : '%'; ?></span></div>
			<?php } 
			if( $post_data['post_thumb'] ){ ?>
				<div class="isotopeMore icon-down-open-big"></div>
				<div class="isotopeContentWrap">
					<div class="isotopeContent">
						<h4 class="isotopeTitle">
							<?php $showsingleLink = false;//sc_param_is_on(get_custom_option('show_single_link',null,$post_data['post_id'])); 
								echo $showsingleLink ? '<a href="'.esc_url($post_data['post_link']).'">' : '';
								echo getShortString($post_data['post_title'],35);
								echo $showsingleLink ? '</a>' : '';
							?>
						</h4>
						<?php echo $post_data['post_excerpt'] ? '<div class="isotopeExcerpt">'.getShortString(strip_tags($post_data['post_excerpt']), 70 ).'</div>' : ''; 
						//postinfo
						echo getPostInfo(get_custom_option('set_post_info',null,$post_data['post_id']),$post_data,false); 
						?>
					</div>
				</div>
			<?php } else { ?>
				<div class="isotopeMore icon-down-open-big"></div>
				<div class="isotopeStatickWrap">
					<div class="isotopeStatick">
						<div class="postFormatIcon <?php echo getPostFormatIcon($post_data['post_format']) ?>"></div>
						<?php if ($post_data['post_format']  != 'link') { ?>
						<h5 class="isotopeTitle">
							<?php $showsingleLink = sc_param_is_on(get_custom_option('show_single_link',null,$post_data['post_id'])); 
								echo $showsingleLink ? '<a href="'.esc_url($post_data['post_link']).'">' : '';
								echo getShortString($post_data['post_title'],25);
								echo $showsingleLink ? '</a>' : '';
							?>
						</h5>
						<?php } else {
							echo '<a class="isotopeLinks" href="'.$post_data['post_link'].'">'.getShortString($post_data['post_title'],35).'</a>';
						}
						//postinfo
						echo $post_data['post_format']  != 'link'  ? getPostInfo(get_custom_option('set_post_info',null,$post_data['post_id']),$post_data,false) : ''; 
						echo $post_data['post_excerpt'] && $post_data['post_format']  != 'quote' && $post_data['post_format']  != 'link' ? '<div class="isotopeExcerpt">'.getShortString(strip_tags($post_data['post_excerpt']), 110 ).'</div>' : ''; ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</article>