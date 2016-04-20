<?php
/*
 * The template for displaying "No posts found"
 * 
 * @package Wine
*/
?>
<section>
	<article>
		<div class="noPost">
			<h3 class="titleNoPost"><?php _e('No posts found', 'themerex'); ?></h3>
			<h2 class="subTitleNoPost"><?php _e('Sorry, but nothing matched your search criteria', 'themerex'); ?></h2>
			<p>
				<?php echo sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'themerex'), home_url(), get_bloginfo()); ?>
				<br>
				<b><?php _e('Please report any broken links to our team.', 'themerex'); ?></b>
			</p>
			<?php echo do_shortcode('[trx_search top="60"]'); ?>
		</div>
	</article>
</section>
