<?php
/**
 * WooCommerce Social Login
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Social Login to newer
 * versions in the future. If you wish to customize WooCommerce Social Login for your
 * needs please refer to http://docs.woothemes.com/document/woocommerce-social-login/ for more information.
 *
 * @package   WC-Social-Login/Templates
 * @author    SkyVerge
 * @copyright Copyright (c) 2014-2016, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

/**
 * Renders any linked social profiles on my account page.
 *
 * @param array $linked_profiles Profiles that are already linked to the current user's account
 * @param string $available_providers All available social login providers
 * @param string $return_url
 *
 * @version 1.8.0
 * @since 1.1.0
 */
?>

<div class="wc-social-login-profile">

	<h2><?php esc_html_e( 'Signing In', 'woocommerce-social-login' ); ?></h2>

	<?php if ( $linked_profiles ) : ?>

		<?php
		$add_more_link = '';
		if ( count( $linked_profiles ) < count( $available_providers ) ) {
			/* translators: Placeholders: %1$s - <a> tag, %2$s - </a> tag */
			$add_more_link = ' ' . sprintf( __( '%1$sAdd more...%2$s', 'woocommerce-social-login' ), '<a href="#" class="js-show-available-providers">', '</a>' );
		}
		?>

		<p><?php echo esc_html__( 'Your account is connected to the following social login providers.', 'woocommerce-social-login' ) . $add_more_link; ?></p>
                <ul>
                    <?php foreach ( $linked_profiles as $provider_id => $profile ) :
                        $formatedProfile = $profile->get_formatted_profile();
                        $provider = wc_social_login()->get_provider( $provider_id );
                        $login_timestamp = get_user_meta( get_current_user_id(), '_wc_social_login_' . $provider_id . '_login_timestamp', true );
                    ?>
                    <li>
                        <p><img src="<?php echo $formatedProfile['image'];?>" width="75" /></p>
                        <p><?php printf( '<span class="social-badge social-badge-%1$s">Connected</span> ', esc_attr( $provider->get_id() ) ); ?></p>
                        <p><a href="<?php echo esc_url( wp_nonce_url( $provider->get_auth_url( $return_url, 'unlink' ), 'unlink' ) ); ?>" class="">
                            <?php /* translators: This is an action: unlink account from a social profile */ esc_html_e( 'Click here to disconnect', 'woocommerce-social-login' ); ?>
                        </a></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
	<?php else : ?>

		<p>
		<?php
			/* translators: Placeholders: %1$s - <a> tag, %2$s - </a> tag */
			printf( esc_html__( 'You have no social login profiles connected. %1$sConnect one now%2$s', 'woocommerce-social-login' ), '<a href="#" class="js-show-available-providers">', '</a>' );
		?>
		</p>

	<?php endif; ?>

	<div class="wc-social-login-available-providers" style="display:none;">

		<p><?php esc_html_e( 'You can link your account to the following providers:', 'woocommerce-social-login' ); ?></p>

		<?php woocommerce_social_login_link_account_buttons( SV_WC_Plugin_Compatibility::is_wc_version_gte_2_6() ? wc_customer_edit_account_url() : null ); ?>

	</div>

</div>

<?php