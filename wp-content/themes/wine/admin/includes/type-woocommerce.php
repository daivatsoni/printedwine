<?php
/* Woocommerce support functions
------------------------------------------------------------------------------- */


// Return true, if current page is any woocommerce page
if ( !function_exists( 'is_woocommerce_page' ) ) {
	function is_woocommerce_page() {
		return function_exists('is_woocommerce') ? is_woocommerce() || is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() : false;
	}
}

// Remove WOOC sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Before main content
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action('woocommerce_before_main_content', 'themerex_wrapper_start', 10);
if ( !function_exists( 'themerex_wrapper_start' ) ) {
	function themerex_wrapper_start() {
		global $THEMEREX_shop_mode;
		?>
		<section class="post shop_mode_<?php echo !empty($THEMEREX_shop_mode) ? $THEMEREX_shop_mode : 'thumbs'; ?>">
			<article class="post_content">
		<?php
	}
}

// After main content
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);		
add_action('woocommerce_after_main_content', 'themerex_wrapper_end', 10);
if ( !function_exists( 'themerex_wrapper_end' ) ) {
	function themerex_wrapper_end() {
	?>
			</article><!-- .post_content -->
		</section>
	<?php
	}
}

// Add list mode buttons
add_action( 'woocommerce_before_shop_loop', 'themerex_woocommerce_before_shop_loop', 10 );
if ( !function_exists( 'themerex_woocommerce_before_shop_loop' ) ) {
	function themerex_woocommerce_before_shop_loop() {
		global $THEMEREX_shop_mode;
		echo '<div class="mode_buttons"><form action="http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'" method="post">'
			. '<input type="hidden" name="themerex_shop_mode" value="'.$THEMEREX_shop_mode.'" />'
			. '<a href="#" class="woocommerce_thumbs icon-th" title="'.__('Show products as thumbs', 'themerex').'"></a>'
			. '<a href="#" class="woocommerce_list icon-th-list" title="'.__('Show products as list', 'themerex').'"></a>'
			. '</form></div>';
	}
}

// Open item wrapper for categories and proiducts in list mode
add_action( 'woocommerce_before_subcategory_title', 'themerex_woocommerce_open_item_wrapper', 20 );
add_action( 'woocommerce_before_shop_loop_item_title', 'themerex_woocommerce_open_item_wrapper', 20 );
if ( !function_exists( 'themerex_woocommerce_open_item_wrapper' ) ) {
	function themerex_woocommerce_open_item_wrapper($cat='') {
		global $THEMEREX_shop_mode;
		if ($THEMEREX_shop_mode == 'list')
			echo '<div class="item_wrapper">';
	}
}

// Close item wrapper for categories and proiducts in list mode
add_action( 'woocommerce_after_subcategory', 'themerex_woocommerce_close_item_wrapper', 20 );
add_action( 'woocommerce_after_shop_loop_item', 'themerex_woocommerce_close_item_wrapper', 20 );
if ( !function_exists( 'themerex_woocommerce_close_item_wrapper' ) ) {
	function themerex_woocommerce_close_item_wrapper($cat='') {
		global $THEMEREX_shop_mode;
		if ($THEMEREX_shop_mode == 'list')
			echo '</div>';
	}
}

// Add excerpt in output for the product in the list mode
add_action( 'woocommerce_after_shop_loop_item_title', 'themerex_woocommerce_after_shop_loop_item_title', 7);
if ( !function_exists( 'themerex_woocommerce_after_shop_loop_item_title' ) ) {
	function themerex_woocommerce_after_shop_loop_item_title() {
		global $THEMEREX_shop_mode;
		if ($THEMEREX_shop_mode == 'list')
			echo '<div class="description">'.apply_filters('the_excerpt', get_the_excerpt()).'</div>';
	}
}

// Add excerpt in output for the product in the list mode
add_action( 'woocommerce_after_subcategory_title', 'themerex_woocommerce_after_subcategory_title', 10 );
if ( !function_exists( 'themerex_woocommerce_after_subcategory_title' ) ) {
	function themerex_woocommerce_after_subcategory_title($category) {
		global $THEMEREX_shop_mode;
		if ($THEMEREX_shop_mode == 'list')
			echo '<div class="description">' . $category->description . '</div>';
	}
}

// Add Product ID for single product
add_action( 'woocommerce_product_meta_end', 'themerex_woocommerce_show_product_id', 10);
if ( !function_exists( 'themerex_woocommerce_show_product_id' ) ) {
	function themerex_woocommerce_show_product_id() {
		global $post, $product;
		echo '<span class="product_id">'.__('Product ID: ', 'themerex') . '<span>' . $post->ID.'</span></span>';
	}
}

// Redefine number of related products
add_filter( 'woocommerce_output_related_products_args', 'themerex_woocommerce_output_related_products_args' );
if ( !function_exists( 'themerex_woocommerce_output_related_products_args' ) ) {
	function themerex_woocommerce_output_related_products_args($args) {
		$ppp = get_custom_option('post_related_count');
		$ppp = $ppp > 0 ? $ppp : 4;
		$args['posts_per_page'] = $ppp;
		$args['columns'] = min(3, $ppp);
		return $args;
	}
}

// Number columns for product thumbnails
add_filter( 'woocommerce_product_thumbnails_columns', 'themerex_woocommerce_product_thumbnails_columns' );
if ( !function_exists( 'themerex_woocommerce_product_thumbnails_columns' ) ) {
	function themerex_woocommerce_product_thumbnails_columns($cols) {
		return 5;
	}
}

// Number columns for shop streampage
add_filter( 'loop_shop_columns', 'themerex_woocommerce_loop_shop_columns' );
if ( !function_exists( 'themerex_woocommerce_loop_shop_columns' ) ) {
	function themerex_woocommerce_loop_shop_columns($cols) {
		return get_custom_option('show_sidebar_main')=='fullWidth' ? 5 : 4;
	}
}

// Search form
add_filter( 'get_product_search_form', 'themerex_woocommerce_get_product_search_form' );
if ( !function_exists( 'themerex_woocommerce_get_product_search_form' ) ) {
	function themerex_woocommerce_get_product_search_form($form) {
		return '
		<form role="search" method="get" class="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
		<div class="searchFormWrap">
			<div class="searchSubmit">
				<input class="sc_button sc_button_skin_dark sc_button_style_bg sc_button_size_mini" type="submit" value="'.__('Search', 'themerex').'">
			</div>
			<div class="searchField">
				<input type="text" placeholder="' . __('Search for products &hellip;', 'themerex') . '" value="' . get_search_query().'" name="s" title="' . __('Search for products:', 'themerex') . '" />
			</div>
		<input type="hidden" name="post_type" value="product" /></div>
		</form>
		';
	}
}

?>