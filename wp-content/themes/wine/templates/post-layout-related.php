<article class="sc_columns_item postBoxItem <?php echo !$post_data['post_thumb'] ? 'noneThumb' : '' ?>">

	<?php 
	$show_single = sc_param_is_on(get_custom_option('show_single_link',null,$post_data['post_id']));

	//thumb
	if ($post_data['post_video']) {
		echo getVideoFrame($post_data['post_video'], $post_data['post_thumb'], false);
	} else if ($post_data['post_thumb']) { ?>
		<div class="postThumb" data-image="<?php echo esc_url($post_data['post_attachment']); ?>" data-title="<?php echo esc_attr($post_data['post_title']); ?>">
		<?php echo $post_data['post_thumb']; ?>
		</div> <?php
	} else if ($post_data['post_gallery']) {
		echo $post_data['post_gallery'];
	} else {?>
		<div class="postThumb" data-title="<?php echo esc_attr($post_data['post_title']); ?>">
			<img src="<?php echo get_template_directory_uri(); ?>/images/none_thumb.png" alt="">
			<span class="iconThumb icon-gallery"></span>
		</div> <?php
	} ?>

	<div class="postBoxInfoWrap">
		<span class="postBoxInfo">
			<h5><?php 
				echo $show_single ? '<a href="'.esc_url($post_data['post_link']).'">' : '';
				echo getShortString($post_data['post_title'],50);
				echo $show_single ? '</a>' : '';
			?></h5>
			<?php echo $post_data['post_categories_links'] !='' ? '<span class="postBoxCategory hoverUnderline">'.$post_data['post_categories_links'].'</span>'  : ''; ?>
		</span>
	</div>
	
</article>