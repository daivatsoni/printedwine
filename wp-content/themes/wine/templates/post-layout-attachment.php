<?php
$post_data['post_views']++;
?>

<section id="attachment_section" <?php post_class('attachmentSection'); ?>>
	<div class="attachmentThumb">
		
		<?php 
			$thumb_sizes = getThumbSizes(array(
				'thumb_size' => 'image_large',
				'thumb_crop' => true,
				'sidebar' => false
			));
			$thumb_img = getResizedImageURL($post_data['post_attachment'], $thumb_sizes['w'], $thumb_sizes['h']);
		?>
		<a href="<?php echo esc_url($post_data['post_attachment']); ?>" class="attachmentImg"><img alt="" src="<?php echo esc_url($thumb_img); ?>"></a>
		<?php
		$post = get_post();
		$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
		foreach ( $attachments as $k => $attachment ) {
			if ( $attachment->ID == $post->ID )
				break;
		} 

		//navigation
		if(  $attachments[ $k-1 ] ||  $attachments[ $k+1 ]){ ?>
		<div class="attcWrap">
			<span class="attcPosition">
			<?php 
			if ( isset( $attachments[ $k-1 ] ) ) { ?>
				<?php
				$link = get_permalink( $attachments[ $k-1 ]->ID ).'#top_of_page';
				$desc = getShortString(!empty($attachments[ $k-1 ]->post_excerpt) ? strip_tags($attachments[ $k-1 ]->post_excerpt) : $attachments[ $k-1 ]->post_title, 30);
				?>
				<a class="attcNav attcPrev" href="<?php echo esc_url($link); ?>">
					<span class="attcIcon icon-left-open-big"></span>				
					<span class="attcInf">
						<span class="attcHead"><?php _e('Previous item', 'themerex'); ?></span>
						<?php echo $desc ? '<span class="attcDesc">'.$desc.'</span>' : ''; ?>
					</span>
				</a>
				<?php
			}
			if ( isset( $attachments[ $k+1 ] ) ) {
				$link = get_permalink( $attachments[ $k+1 ]->ID ).'#top_of_page';
				$desc = getShortString(!empty($attachments[ $k+1 ]->post_excerpt) ? strip_tags($attachments[ $k+1 ]->post_excerpt) : $attachments[ $k+1 ]->post_title, 30);
				?>
				<a class="attcNav attcNext" href="<?php echo esc_url($link); ?>">
					<span class="attcInf">
						<span class="attcHead"><?php _e('Next item', 'themerex'); ?></span>
						<?php echo $desc ? '<span class="attcDesc">'.$desc.'</span>' : ''; ?>
					</span>
					<span class="attcIcon icon-right-open-big"></span>
				</a>
				<?php
			} ?>
			</span>
		</div>
	<?php }?>
	</div>

	<h1 class="post_title"><?php echo !empty($post_data['post_excerpt']) ? getShortString(strip_tags($post_data['post_excerpt']),100) : $post_data['post_title']; ?></h1>
	<?php echo getPostInfo(get_custom_option('set_post_info',null,$post_data['post_id']),$post_data); ?>

	<div class="post_text_area">
		<?php
		// Post content
		if ($post_data['post_protected']) { 
			echo $post_data['post_excerpt']; 
		} else {
			echo $post_data['post_content']; 
			wp_link_pages( array( 
				'before' => '<div class="nav_pages_parts"><span class="pages">' . __( 'Pages:', 'themerex' ) . '</span>', 
				'after' => '</div>',
				'link_before' => '<span class="page_num">',
				'link_after' => '</span>'
			) ); 
		} 
		?>
	</div>
</section>

<?php	
if (!$post_data['post_protected']) {
	require(get_template_directory() . '/templates/page-part-comments.php');
}
require(get_template_directory() . '/templates/page-part-views-counter.php'); ?>
