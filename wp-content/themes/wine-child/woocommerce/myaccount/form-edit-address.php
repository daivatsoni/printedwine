<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
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

$page_title = ( $load_address === 'billing' ) ? __( 'Billing Address', 'woocommerce' ) : __( 'Shipping Address', 'woocommerce' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

	<address>
	
	<?php 
	
		/*$address = apply_filters( 'woocommerce_my_account_my_address_formatted_address', array(
					'first_name'  => get_user_meta( $customer_id, $name . '_first_name', true ),
					'last_name'   => get_user_meta( $customer_id, $name . '_last_name', true ),
					'company'     => get_user_meta( $customer_id, $name . '_company', true ),
					'address_1'   => get_user_meta( $customer_id, $name . '_address_1', true ),
					'address_2'   => get_user_meta( $customer_id, $name . '_address_2', true ),
					'city'        => get_user_meta( $customer_id, $name . '_city', true ),
					'state'       => get_user_meta( $customer_id, $name . '_state', true ),
					'postcode'    => get_user_meta( $customer_id, $name . '_postcode', true ),
					'country'     => get_user_meta( $customer_id, $name . '_country', true )
				), $customer_id, $name );*/
				
	
	add_filter( 'woocommerce_order_formatted_billing_address' , 'woo_custom_order_formatted_billing_address' );

	/**
	 * woo_custom_order_formatted_billing_address
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function woo_custom_order_formatted_billing_address() {
		
		$address = array(
			'first_name'	=> $this->billing_first_name,
			'last_name'		=> $this->billing_last_name,
			'company'		=> $this->billing_company,
			'address_1'		=> $this->billing_address_1,
			'address_2'		=> $this->billing_address_2,
			'city'			=> $this->billing_city,
			'state'			=> $this->billing_state,
			'postcode'		=> $this->billing_postcode,
			'country'		=> $this->billing_country
		);

		return $address;
		
	}
	?>
	
	</address>

<?php if ( ! $load_address ) : ?>
	<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>

	<form method="post">

		<h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></h3>
		
		<h5>Where we send you the good stuff!</h5>
		<p>Edit and update your address(s) at anytime.<br>
		You can read our privacy policy <a href="">here</a>.</p>

		<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>

		<?php foreach ( $address as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>

		<?php endforeach; ?>

		<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>

		<p>
			<input type="submit" class="button" name="save_address" value="<?php esc_attr_e( 'Save Address', 'woocommerce' ); ?>" />
			<?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
			<input type="hidden" name="action" value="edit_address" />
		</p>

	</form>

<?php endif; ?>

<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>

<script>
jQuery(document).ready(function(){
	
		jQuery('#billing_first_name_field').prepend('<label>Your Name</label>');
});

</script>