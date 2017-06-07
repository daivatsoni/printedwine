<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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

do_action( 'woocommerce_before_edit_account_form' ); ?>

<?php 
	
	$user_id = get_current_user_id();
	$user = get_userdata( $user_id );
	
	$birthdate = get_user_meta( $user_id, 'user_profile_image', true );
	
	$api = LOU_ACF_API::instance();

	// fetch the list of groups that belong on the top of the my account page
	$field_groups = $api->get_field_groups();
	
?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post">

	<h1>Profile</h1>
	
	<h5>General Information about your account:</h5>
	<p>You can red our privacy plociy <a href=''>here.</a> if you would like to close your account you can do this <a href='#'>here.</a></p>
	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
		
	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
		<label for="account_first_name">Your Name<span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
		name="account_first_name" id="account_first_name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="First Name" />
	</p>
	<p class="woocommerce-FormRow woocommerce-FormRow--last form-row form-row-last">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" 
		id="account_last_name" value="<?php echo esc_attr( $user->last_name ); ?>" placeholder="Last Name" />
	</p>
	<div class="clear"></div>
	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">	
		<label>Date of Birth</label>
		<input type="text" class="input-text" name="billing_birthdate" id="reg_billing_birthdate" gldp-id="mydate" value="<?php if ( ! empty( $_POST['billing_birthdate'] ) ) esc_attr_e( $_POST['billing_birthdate'] ); ?>" />
		<small>We believe in Happy Birthdays</small>
	</p>

	
	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
		<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" 
		name="account_email" id="account_email" value="<?php echo esc_attr( $user->user_email ); ?>" placeholder="Email" />
	</p>

	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
		<label for=""><?php _e( 'Invite URL', 'woocommerce' ); ?> <span class="required">*</span></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" 
		name="invite_url" id="invite_url" value="" placeholder="https://printedwine.com" style="width:35% !important;"  />
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" style="width:35% !important;"
		name="account_your_name" id="account_your_name" value="<?php echo esc_attr( $user->first_name ); ?>" placeholder="Your Name" />
	
		<small>It's easy to invite your friends tojoin Printedwine by using this URL. When they signup, you will get points and they will get a discount. Win Win! So share the love
		abd tell your Artist friends to contribute art, tell your tribe about the great deals we have and enjoy the benefits!</small>
	</p>
	
	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
		<label for="account_gender"><?php _e( 'Gender', 'woocommerce' ); ?> <span>(Optional)</span></label>
		<select name="gender" style="width:40% !important;">
		</select>
	</p>
         
	<?php _e( 'Password', 'woocommerce' ); ?>
	<p>
		<small>
		<?php _e('You can change and update your password here. Please note, you can also
		use Facebook authentication to login to your account if you"d prefer that.', 'woocommerce');?>
		</small>
	</p>
	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
			<label for="password_1"><?php _e( 'New Password', 'woocommerce' ); ?></label>
	</p>
	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
			<label for="password_current"><?php _e( 'Current Password', 'woocommerce' ); ?></label>
	</p>

		<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
			
			<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" />
		</p>
		<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
					<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" />
		</p>
		
		<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details' ); ?>
		<input type="submit" class="woocommerce-Button button" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
		<input type="hidden" name="action" value="save_account_details" />
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
