<?php
/*
Plugin Name: PrintedWine
Plugin URI: http://www.daivat.com/
Description: This plugin is required for PrintedWine specific features.
Version: 1.0.0
Author: Daivat Soni
Author URI: http://www.daivat.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$priceRange = array(
    'cleanskin' => array(
        'upper' => 'mid'
    ),
    'mid' => array(
        'upper' => 'premium'
    ),
    'premium' => array(
        'upper' => false
    ),
);


function add_scripts_styles() {
//    if( 'index.php' != $hook ) {
//	// Only applies to dashboard panel
//	return;
//    }
    wp_enqueue_script('pw-scripts', plugins_url( 'assets/js/script.js', __FILE__ ), array('jquery'));
}
add_action( 'wp_enqueue_scripts', 'add_scripts_styles' );

function fn_ds_product_categories() {
    ob_start(); 
    ?>
<div class="vc_col-sm-12">
    <div class="vc_col-sm-12 pw-price-select">
        <div class="vc_col-sm-3 vc_col-xs-12">1. PRICE OF WINES *</div>
        <div class="vc_col-sm-3 vc_col-xs-12">
            <div class="checkbx extended"><input id="cb1" value="cleanskin"  name="wine_range" type="checkbox"><label for="cb1"><span class="cbimg"></span><span>Cleanskins $</span><span class="tip">From $<?php echo the_field("cleanskin_range_starts_from", "options"); ?> a Case</span></label></div>
        </div>
        <div class="vc_col-sm-3 vc_col-xs-123">
            <div class="checkbx extended"><input id="cb2" value="mid"  name="wine_range" type="checkbox"><label for="cb2"><span class="cbimg"></span><span>Mid Range $$</span><span class="tip">From $<?php echo the_field("mid_range_starts_from", "options"); ?> a Case</span></label></div>
        </div>
        <div class="vc_col-sm-3 vc_col-xs-123">
            <div class="checkbx extended"><input id="cb3" value="premium"  name="wine_range" type="checkbox"><label for="cb3"><span class="cbimg"></span><span>Premium $$$</span><span class="tip">From $<?php echo the_field("premium_range_starts_from", "options"); ?> a Case</span></label></div>
        </div>
    </div>
    <div class="col-12 pw-wine-select">
        <div class="vc_col-sm-3 vc_col-xs-12">2. TYPE OF WINES * <span class="tip">* Required</span><span class="tip">You can select only one type of wine per case.</span></div>
        <div class="vc_col-sm-9 vc_col-xs-12" id="wine-selector">Select Price Range first</div>
    </div>    
</div>
<div class="col-12">
    <button type="submit" id="btnStep1" name="btnStep1" class="button" style="display:none;">Make label for your wine</button>
</div>    
<?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode('ds_product_categories', 'fn_ds_product_categories');

vc_map(array(
    "base" => "ds_product_categories",
    "name" => __("Label Step 1", "themerex"),
    "description" => __("Label creation step 1 layout", "themerex"),
    "category" => __('WooCommerce', 'js_composer'),
    'icon' => 'icon_trx_product_categories',
    "class" => "trx_sc_single trx_sc_product_categories",
    "content_element" => true,
    "is_container" => false,
    "show_settings_on_create" => true,
    "params" => array(
        array(
            "param_name" => "number",
            "heading" => __("Number", "themerex"),
            "description" => __("How many categories showed", "themerex"),
            "admin_label" => true,
            "class" => "",
            "value" => "4",
            "type" => "textfield"
        ),
        array(
            "param_name" => "columns",
            "heading" => __("Columns", "themerex"),
            "description" => __("How many columns per row use for categories output", "themerex"),
            "admin_label" => true,
            "class" => "",
            "value" => "4",
            "type" => "textfield"
        ),
        array(
            "param_name" => "orderby",
            "heading" => __("Order by", "themerex"),
            "description" => __("Sorting order for products output", "themerex"),
            "admin_label" => true,
            "class" => "",
            "value" => "date",
            "type" => "textfield"
        ),
        array(
            "param_name" => "hide_empty",
            "heading" => __("Hide empty", "themerex"),
            "description" => __("Hide empty categories", "themerex"),
            "class" => "",
            "value" => array("Hide empty" => "1"),
            "type" => "checkbox"
        ),
        array(
            "param_name" => "parent",
            "heading" => __("Parent", "themerex"),
            "description" => __("Parent category slug", "themerex"),
            "admin_label" => true,
            "class" => "",
            "value" => "date",
            "type" => "textfield"
        ),
        array(
            "param_name" => "ids",
            "heading" => __("IDs", "themerex"),
            "description" => __("Comma separated ID of products", "themerex"),
            "admin_label" => true,
            "class" => "",
            "value" => "",
            "type" => "textfield"
        )
    )
));

function pw_filter_wines_callback() {
	global $wpdb, $priceRange; // this is how you get access to the database

	$level = $_GET['level'];
        $upperLevel = $priceRange[$level]['upper'];
        
        $fromPrice = get_field($level."_range_starts_from", "options");
        $toPrice = get_field($upperLevel."_range_starts_from", "options");

        $matched_products = array();
        $min     = floatval( $fromPrice );
        $max     = floatval( $toPrice );
        
        if($upperLevel) {
            $matched_products_query = apply_filters( 'woocommerce_price_filter_results', $wpdb->get_results( $wpdb->prepare("
                SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
                INNER JOIN $wpdb->postmeta ON ID = post_id
                WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish' AND meta_key = %s AND meta_value BETWEEN %d AND %d
            ", '_price', $min, $max ), OBJECT_K ), $min, $max );
        } else {
            $matched_products_query = apply_filters( 'woocommerce_price_filter_results', $wpdb->get_results( $wpdb->prepare("
                SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
                INNER JOIN $wpdb->postmeta ON ID = post_id
                WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish' AND meta_key = %s AND meta_value >= %d
                ", '_price', $min ), OBJECT_K ), $min );
        }
        
        if ( $matched_products_query ) {
            foreach ( $matched_products_query as $product ) {
                if ( $product->post_type == 'product' )
                    $matched_products[] = $product->ID;
                if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) )
                    $matched_products[] = $product->post_parent;
            }
        }
        
        $arrRedDozen = $arrWhiteDozen = $arrMixedDozen = array();
        if(count($matched_products)) {
            foreach($matched_products as $productId) {
                $objProduct = wc_get_product($productId);
                $postData = $objProduct->get_post_data();
                $objCategories = get_the_terms($productId, 'product_cat');
                if(count($objCategories)) {
                    foreach($objCategories as $term) {
                        switch($term->slug) {
                            case "red-dozen":
                                $arrRedDozen[] = array(
                                    'id' => $postData->ID,
                                    'title' => $postData->post_title,
                                );
                                break;
                            case "white-dozen":
                                $arrWhiteDozen[] = array(
                                    'id' => $postData->ID,
                                    'title' => $postData->post_title
                                );
                                break;
                            case "mixed-dozen":
                                $arrMixedDozen[] = array(
                                    'id' => $postData->ID,
                                    'title' => $postData->post_title
                                );
                                break;
                        }
                    }
                }
                
            }
        } 
        
        ob_start();
        ?>
        <div class="vc_col-sm-4">
            <div class="checkbx extended"><input id="chk-red-dozen" value="1" name="chk-red-dozen" type="checkbox"><label for="chk-red-dozen"><span class="cbimg"></span></label></div>
            <select name="red-dozen" id="red-dozen" class="selWine">
                <option value="">Red Dozen</option>
                <?php 
                if(count($arrRedDozen)) {
                    foreach($arrRedDozen as $wine ) { ?>
                        <option value="<?php echo $wine['id']; ?>"><?php echo $wine['title']; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="vc_col-sm-4">
            <div class="checkbx extended"><input id="chk-white-dozen" value="1"  name="chk-white-dozen" type="checkbox"><label for="chk-white-dozen"><span class="cbimg"></span></label></div>
            <select name="white-dozen" id="white-dozen" class="selWine">
                <option value="">White Dozen</option>
                <?php 
                if(count($arrWhiteDozen)) {
                    foreach($arrWhiteDozen as $wine ) { ?>
                        <option value="<?php echo $wine['id']; ?>"><?php echo $wine['title']; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="vc_col-sm-4">
            <div class="checkbx extended"><input id="chk-mixed-dozen" value="1"  name="chk-mixed-dozen" type="checkbox"><label for="chk-mixed-dozen"><span class="cbimg"></span></label></div>
            <select name="mixed-dozen" id="mixed-dozen" class="selWine">
                <option value="">Mixed Dozen</option>
                <?php 
                if(count($arrMixedDozen)) {
                    foreach($arrMixedDozen as $wine ) { ?>
                        <option value="<?php echo $wine['id']; ?>"><?php echo $wine['title']; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>        
        <?php
        $html = ob_get_clean();
        
        echo $html;
        
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_pw_filter_wines', 'pw_filter_wines_callback' );
add_action( 'wp_ajax_nopriv_pw_filter_wines', 'pw_filter_wines_callback' );
