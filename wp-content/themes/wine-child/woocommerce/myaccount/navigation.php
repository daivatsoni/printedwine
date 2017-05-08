<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>


<div class="col-md-3">    

	<div class="header_profile">
		<?php //do_action( 'woocommerce_acf_edit_account_form_start' ); // ADDED BY DAIVAT SONI ?>
		<?php 
			$user_id = get_current_user_id();
			$data = get_field('user_profile_image','user_'.$user_id);
		?>
		
		<img data-name="image" src="<?php echo $data['url']; ?>" alt="" class="woocommerce img" width="150px">
			
	</div>

<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
</div>
<?php do_action( 'woocommerce_after_account_navigation' ); ?>
