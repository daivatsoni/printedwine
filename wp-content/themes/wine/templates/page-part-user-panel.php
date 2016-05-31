<?php if (get_custom_option('show_user_menu')=='yes') { ?>
<ul class="usermenuList">

	<?php if (get_custom_option('show_currency')=='yes') { ?>
	<li class="usermenuCurrency">
		<a href="#">$</a>
		<ul>
			<li><a href="#"><b>$</b> Dollar</a></li>
			<li><a href="#"><b>€</b> Euro</a></li>
			<li><a href="#"><b>£</b> Pounds</a></li>
		</ul>
	</li>
	<?php } ?>

	<?php if (function_exists('is_woocommerce') && (is_woocommerce_page() && get_custom_option('show_cart')=='shop' || get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) { 
		global $THEMEREX_usermenu_show; ?>
		<li class="usermenuCart">
			<a href="#" class="cart_button"><span><?php if ($THEMEREX_usermenu_show) _e('Cart', 'themerex'); ?></span> <b class="cart_total"><?php echo WC()->cart->get_cart_subtotal(	); ?></b></a>
				<ul class="widget_area sidebar_cart sidebar"><li>
					<?php
					do_action( 'before_sidebar' );
					global $THEMEREX_CURRENT_SIDEBAR;
					$THEMEREX_CURRENT_SIDEBAR = 'cart';
					if ( ! dynamic_sidebar( 'sidebar-cart' ) ) { 
						the_widget( 'WC_Widget_Cart', 'title=&hide_if_empty=1' );
					}
					?>
				</li></ul>
		</li>
	<?php } ?>

	<?php if (get_custom_option('show_languages')=='yes' && function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=0');
		if (!empty($languages)) {
			$lang_list = '';
			$lang_active = '';
			foreach ($languages as $lang) {
				$lang_title = esc_attr($lang['translated_name']);	//esc_attr($lang['native_name']);
				$lang_img = '<img src="' . $lang['country_flag_url'] . '" alt="' . $lang_title . '" title="' . $lang_title . '" />';
				if ($lang['active']) {
					$lang_active = $lang_img;
				}
				$lang_list .= "\n".'<li><a rel="alternate" hreflang="' . $lang['language_code'] . '" href="' . apply_filters('WPML_filter_link', $lang['url'], $lang) . '">'
					. $lang_img
					. $lang_title
					.'</a></li>';
			}
			?>
			<li class="usermenuLanguage">
				<a href="#"><span><?php echo $lang_active; ?></span></a>
				<ul><?php echo $lang_list; ?></ul>
			</li>
	<?php
		}
	}
	?>

	<?php if (get_custom_option('show_login')=='yes') { 

		if( !is_user_logged_in() ) { ?>
			<li class="usermenuLogin"><a href="#user-popUp" class="user-popup-link"><?php _e('Login','themerex') ?></a></li>
		<?php } else { 
			$current_user = wp_get_current_user(); ?>
			<li class="usermenuControlPanel">
				<a href="#"><span><?php echo $current_user->display_name; ?></span></a>
				<ul>
					<?php if (current_user_can('publish_posts')) { ?>
					<li><a href="<?php echo esc_url(home_url()); ?>/wp-admin/post-new.php?post_type=post" class="icon icon-doc-inv"><?php _e('New post','themerex') ?></a></li>
					<?php } ?>
					<li><a href="<?php echo get_edit_user_link(); ?>" class="icon icon-cog-1"><?php _e('Settings','themerex') ?></a></li>
					<li><a href="<?php echo wp_logout_url(home_url()); ?>" class="icon icon-logout"><?php _e('Log out','themerex') ?></a></li>
				</ul>
			</li>
		<?php } 
	} ?>
</ul>
<?php } ?>
