<?php
//===================================== Related posts =====================================
if (get_custom_option("show_post_related") == 'yes') {

	$show_title = true;	
	$columns = max(2, min(6, get_custom_option('post_related_count', null, $post_data['post_id'])));

	$args = array( 
		'numberposts' => get_custom_option('post_related_count'),
		'post_type' => is_page() ? 'page' : 'post', 
		'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
		'post__not_in' => array($post_data['post_id']) 
	);
	if ($post_data['post_categories_links']) {
		$args['category__in'] = $post_data['post_categories_ids'];
	}
	
	// Uncomment this section if you want filter related posts on post formats
	if ($post_data['post_format'] != '' && $post_data['post_format'] != 'standard') {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'field' => 'slug',
				'terms' => 'post-format-' . $post_data['post_format']
			)
		);
	}
	
	$args = addSortOrderInQuery($args, get_custom_option('post_related_sort'), get_custom_option('post_related_order'));
	$recent_posts = wp_get_recent_posts( $args, OBJECT );
	if (is_array($recent_posts) && count($recent_posts) > 0) {
	?>
		<section class="related">
			<h2><?php _e('Related posts', 'themerex'); ?></h2>
			<div class="sc_columns_<?php echo esc_attr($columns); ?> postBox">
				<?php
				$i=0;
				foreach( $recent_posts as $recent ) {
					$i++;
					showPostLayout(
						array(
							'layout' => 'related',
							'number' => $i,
							'add_view_more' => false,
							'posts_on_page' => get_custom_option('post_related_count')
						),
						getPostData(
							array(
								'thumb_size' => getThumbColumns('cub',$columns),
								'strip_teaser' => false,
								'sidebar' => !in_array(get_custom_option('show_sidebar_main'), array('none', 'fullwidth')),
								'categories_list' => true
							),
							$recent
						)
					);
				}
				?>
			</div>
		</section>
		<?php
	}
}
?>
