<?php
/**
 * The Sidebar containing the main widget areas.
 * @package Wine
 */

if (in_array(get_custom_option('show_sidebar_main'), array('sideBarLeft', 'sideBarRight'))) {
?>
	<div id="sidebar_main" class="widget_area sideBar" role="complementary">
		<?php
		global $THEMEREX_CURRENT_SIDEBAR;
		$THEMEREX_CURRENT_SIDEBAR = 'main';
		do_action( 'before_sidebar' );
		if ( ! dynamic_sidebar( get_custom_option('sidebar_main') ) ) { 
			// Put here html if user no set widgets in sidebar
		}
		?>
	</div>
<?php } ?>