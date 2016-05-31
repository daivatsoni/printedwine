<?php
/*
 * The template for displaying "No search results"
 * 
 * @package Wine
*/
?>
<section>
	<article>
		<div class="noSearch">
			<h2 class="subTitleSearch"><?php _e('The requested page cannot be found', 'themerex'); ?></h2>
			<?php echo do_shortcode('[trx_infobox style="info" closeable="no"][trx_icon icon="icon-search" align="left" size="50"]<h4 class="sc_infobox_title">'.__('Search Results for:', 'themerex').'</h4>'.get_search_query().'[/trx_infobox]') ?>
			<p>
				<?php echo sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'themerex'), home_url(), get_bloginfo()); ?>
				<br>
				<b><?php _e('Please report any broken links to our team.', 'themerex'); ?></b>
			</p>
			<?php echo do_shortcode('[trx_search top="60"]'); ?>
		</div>
	</article>
</section>
