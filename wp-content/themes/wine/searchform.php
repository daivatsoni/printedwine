<?php
/*
 * The template for displaying search forms
 * @package Wine
 */
?>
	<form method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
		<div class="searchFormWrap">
			<div class="searchSubmit"><input class="sc_button sc_button_skin_dark sc_button_style_bg sc_button_size_mini" type="submit" id="searchsubmit" value="<?php _e( 'Search', 'themerex' ); ?>" /></div>
			<div class="searchField"><input class="" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" placeholder="<?php _e( 'Search &hellip;', 'themerex' ); ?>" /></div>
		</div>
	</form>
