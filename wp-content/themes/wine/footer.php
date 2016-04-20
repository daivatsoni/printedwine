<?php
/**
 * The template for displaying the footer.
 * @package Wine
 */

global $logo_footer; 

				$body_style =  get_custom_option('body_style');
				$side_bar = get_custom_option('show_sidebar_main');
				$fstyle = strpos(get_custom_option('blog_style'),'portfolio') !== false;

				echo ($body_style == 'boxed' &&  $side_bar != 'fullWidth' && !$fstyle) ? '</div><!-- /.main -->' : '' ?>
			</div><!-- /.wrapContent > /.content -->
			<?php get_sidebar(); //sidebar ?>
		</div><!-- /.wrapContent > /.wrapWide -->
	</div><!-- /.wrapContent -->

	<?php 
	// ----------------- Google map -----------------------
	if ( get_custom_option('googlemap_show') == 'yes' ) { 
		$map_address = get_custom_option('googlemap_address');
		$map_latlng = get_custom_option('googlemap_latlng');
		$map_zoom = get_custom_option('googlemap_zoom');
		$map_scroll = get_custom_option('googlemap_scroll');
		$map_style = get_custom_option('googlemap_style');
		if (!empty($map_address) || !empty($map_latlng)) { 

			echo do_shortcode('[trx_googlemap id="footer" latlng="'.$map_latlng.'" address="'.$map_address.'" zoom="'.$map_zoom.'" scroll="'.$map_scroll.'" style="'.$map_style.'" width="100%" height="350"]');
		
		} 
	}

	// -------------- footer -------------- 
	$footer_widget = (get_custom_option('show_sidebar_footer') == 'yes' && is_active_sidebar( get_custom_option('sidebar_footer')));
	$copyright = sc_param_is_on(get_custom_option('show_copyright'));
	if( $footer_widget || $copyright){
	?>
	<footer <?php echo $footer_widget ? 'class="footerWidget"' : '' ?>>
		<div class="main">

			<?php  // ---------------- Footer sidebar ----------------------
			if ( $footer_widget  ) { 
				global $THEMEREX_CURRENT_SIDEBAR;
				$THEMEREX_CURRENT_SIDEBAR = 'footer'; 
					do_action( 'before_sidebar' );
					if ( !dynamic_sidebar( get_custom_option('sidebar_footer') ) ) {
						// Put here html if user no set widgets in sidebar
					}
			} 
			$copy_footer = get_theme_option('footer_copyright');
			if ( $copy_footer != '' && $copyright ){
				?><div class="copyright"><?php
				print str_replace('[year]',date('Y'), $copy_footer);
				?></div><?php
			} ?>
		</div><!-- /footer.main -->
	</footer>
	<?php } ?>
</div><!-- /.wrapBox -->
</div><!-- /.wrap -->


<div class="buttonScrollUp upToScroll icon-up-open-micro"></div>



<?php 
require(get_template_directory() . '/templates/page-part-login.php');
require(get_template_directory() . '/templates/page-part-js-messages.php');
require(get_template_directory() . '/templates/page-part-customizer.php');
wp_footer(); 
?>
</body>
</html>
