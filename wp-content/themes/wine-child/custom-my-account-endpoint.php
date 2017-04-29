<?php
class My_Custom_My_Account_Endpoint {
 /**
  * Custom endpoint name.
  *
  * @var string
  */
 public static $endpoint = 'my-custom-endpoint';
 /**
  * Plugin actions.
  */
 public function __construct() {
  // Actions used to insert a new endpoint in the WordPress.
  add_action( 'init', array( $this, 'add_endpoints' ) );
  add_filter( 'query_vars', array( $this, 'add_query_vars' ), 0 );
  // Change the My Accout page title.
  add_filter( 'the_title', array( $this, 'endpoint_title' ) );
  // Insering your new tab/page into the My Account page.
  add_filter( 'woocommerce_account_menu_items', array( $this, 'new_menu_items' ) );
  add_action( 'woocommerce_account_' . self::$endpoint .  '_endpoint', array( $this, 'endpoint_content' ) );
 }
 /**
  * Register new endpoint to use inside My Account page.
  *
  * @see https://developer.wordpress.org/reference/functions/add_rewrite_endpoint/
  */
 public function add_endpoints() {
  add_rewrite_endpoint( self::$endpoint, EP_ROOT | EP_PAGES );
 }
 /**
  * Add new query var.
  *
  * @param array $vars
  * @return array
  */
 public function add_query_vars( $vars ) {
  $vars[] = self::$endpoint;
  return $vars;
 }
 /**
  * Set endpoint title.
  *
  * @param string $title
  * @return string
  */
 public function endpoint_title( $title ) {
  global $wp_query;
  $is_endpoint = isset( $wp_query->query_vars[ self::$endpoint ] );
  if ( $is_endpoint && ! is_admin() && is_main_query() && in_the_loop() && is_account_page() ) {
   // New page title.
   $title = __( 'My Custom Endpoint', 'woocommerce' );
   remove_filter( 'the_title', array( $this, 'endpoint_title' ) );
  }
  return $title;
 }
 /**
  * Insert the new endpoint into the My Account menu.
  *
  * @param array $items
  * @return array
  */
 public function new_menu_items( $items ) {
  //edit these to be in whatever order you want them to be in
  $new_ordered_items = array(
        'dashboard'       => __( 'Dashboard', 'woocommerce' ),
        'orders'          => __( 'Orders', 'woocommerce' ),
        'subscriptions'   => __( 'Subscriptions', 'woocommerce-subscriptions' ),
        'downloads'       => __( 'Downloads', 'woocommerce' ),
        'edit-address'    => __( 'Addresses', 'woocommerce' ),
        'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
        'edit-account'    => __( 'Account Details', 'woocommerce' ),
        'customer-logout' => __( 'Logout', 'woocommerce' ),
    );
  //loop through the new array and remove any elements that do not exist in the `$items` array
  foreach ( $new_ordered_items as $key => $value ) {
   if ( ! array_key_exists( $key, $items ) ) {
    unset( $new_ordered_items[ $key ] );
   }
  }
  // Remove the logout menu item.
  $logout = $new_ordered_items['customer-logout'];
  unset( $new_ordered_items['customer-logout'] );
  // Insert your custom endpoint.
  $new_ordered_items[ self::$endpoint ] = __( 'My Custom Endpoint', 'woocommerce' );
  // Insert back the logout item.
  $new_ordered_items['customer-logout'] = $logout;
  return $new_ordered_items;
 }
 /**
  * Endpoint HTML content.
  */
 public function endpoint_content() {
  echo '<p>Hello World!</p>';
 }
 /**
  * Plugin install action.
  * Flush rewrite rules to make our custom endpoint available.
  */
 public static function install() {
  flush_rewrite_rules();
 }
}
new My_Custom_My_Account_Endpoint();
// Flush rewrite rules on plugin activation.
register_activation_hook( __FILE__, array( 'My_Custom_My_Account_Endpoint', 'install' ) );