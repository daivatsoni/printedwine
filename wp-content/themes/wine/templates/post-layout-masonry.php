<?php
$show_title = get_custom_option('show_post_title', null, $post_data['post_id'])=='yes' && (get_custom_option('show_post_title_on_quotes')=='yes' || !in_array($post_data['post_format'], array('aside', 'chat', 'status', 'link', 'quote')));
$columns = max(2, min(4, (int) themerex_substr($opt['style'], -1)));
?>
<article class="isotopeElement <?php 
	echo 'post_format_'.$post_data['post_format'] 
		. ($opt['number']%2==0 ? ' even' : ' odd') 
		. ($opt['number']==0 ? ' first' : '') 
		. ($opt['number']==$opt['posts_on_page'] ? ' last' : '')
		. ($opt['add_view_more'] ? ' viewmore' : '') 
		. (get_custom_option('show_filters')=='yes' 
			? ' flt_'.join(' flt_', get_custom_option('filter_taxonomy')=='categories' ? $post_data['post_categories_ids'] : $post_data['post_tags_ids'])
			: '');
	?>">
	<div class="isotopePadding">
		<?php if ($post_data['post_thumb']) { ?>
		<div class="thumb hoverIncrease" data-image="<?php echo esc_url($post_data['post_attachment']); ?>" data-title="<?php echo esc_attr($post_data['post_title']); ?>"><?php echo $post_data['post_thumb']; ?></div>
		<?php
		} else if ($post_data['post_gallery']) {
			echo $post_data['post_gallery'];
		} else if ($post_data['post_video']) {
			echo getVideoFrame($post_data['post_video'], $post_data['post_thumb'], true);
		}
		?>
		<?php if ($show_title) { ?>
		<h4><a href="<?php echo esc_url($post_data['post_link']); ?>"><?php echo $post_data['post_title']; ?></a></h4>
		<?php } ?>
        <p>
		<?php
		if (!in_array($post_data['post_format'], array('quote', 'link'))) {
			$post_data['post_excerpt'] = strip_tags($post_data['post_excerpt']);
		}
		echo $post_data['post_excerpt'];
		?>
		</p>
		<div class="masonryInfo"><?php _e('Posted ', 'themerex'); ?><a href="<?php echo esc_url($post_data['post_link']); ?>" class="post_date"><?php echo $post_data['post_date']; ?></a></div>
		<div class="masonryMore">
			<?php
			$postinfo_buttons = array('more', 'comments');
			if ($columns < 4)
				$postinfo_buttons[] = 'views';
			if ($columns < 3) {
				$postinfo_buttons[] = 'likes';
				$postinfo_buttons[] = 'share';
				$postinfo_buttons[] = 'rating';
			}
			require(get_template_directory() . '/templates/page-part-postinfo.php'); 
			?>
		</div>
		<span class="inlineShadow"></span>
	<div>
</article>
