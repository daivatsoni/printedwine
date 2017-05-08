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
    $priceFilters = get_field("pw_price_filters", "options");
    $labelEditorUrl = get_field("lebel_editor_url", "options");
    ob_start(); 
    ?>
    <form action="<?php echo $labelEditorUrl;?>" method="post">
        <div class="vc_col-sm-12">
                <div class="vc_col-sm-12 pw-price-select">
                    <div class="vc_col-sm-3 vc_col-xs-12">1. PRICE OF WINES *</div>
                    <?php if(count($priceFilters)) {
                        foreach($priceFilters as $filter ) { ?>
                        <div class="vc_col-sm-3 vc_col-xs-12">
                            <div class="checkbx extended"><input id="cb<?php echo $filter['filter_code'] ?>" value="<?php echo $filter['filter_code'] ?>"  name="wine_range" type="checkbox"><label for="cb<?php echo $filter['filter_code'] ?>"><span class="cbimg"></span><span><?php echo $filter['filter_label'] ?></span><span class="tip">From $<?php echo $filter['starts_from'] ?> a Case</span></label></div>
                        </div>                
                    <?php }                
                    } ?>
                    <?php /*
                    <div class="vc_col-sm-3 vc_col-xs-12">
                        <div class="checkbx extended"><input id="cb2" value="mid"  name="wine_range" type="checkbox"><label for="cb2"><span class="cbimg"></span><span>Mid Range $$</span><span class="tip">From $<?php echo the_field("mid_range_starts_from", "options"); ?> a Case</span></label></div>
                    </div>
                    <div class="vc_col-sm-3 vc_col-xs-12">
                        <div class="checkbx extended"><input id="cb3" value="premium"  name="wine_range" type="checkbox"><label for="cb3"><span class="cbimg"></span><span>Premium $$$</span><span class="tip">From $<?php echo the_field("premium_range_starts_from", "options"); ?> a Case</span></label></div>
                    </div>
                     * 
                     */ ?>
                </div>
                <div class="col-12 pw-wine-select">
                    <div class="vc_col-sm-3 vc_col-xs-12">2. TYPE OF WINES * <span class="tip">* Required</span><span class="tip">You can select only one type of wine per case.</span></div>
                    <div class="vc_col-sm-9 vc_col-xs-12" id="wine-selector">Select Price Range first</div>
                </div>    
        </div>
        <div class="col-12">
            <button type="submit" id="btnStep1" name="btnStep1" class="button" style="display:none;">Make label for your wine</button>
        </div>    
    </form>
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

add_action( 'wp_ajax_pw_filter_wines', 'pw_filter_wines_callback' );
add_action( 'wp_ajax_nopriv_pw_filter_wines', 'pw_filter_wines_callback' );
function pw_filter_wines_callback() {
    global $wpdb; // this is how you get access to the database
    $priceFilters = get_field("pw_price_filters", "options");
    if(count($priceFilters)) {
        $priceRange = array();
        for($i=0; $i<count($priceFilters); $i++) {
            if(isset($priceFilters[$i+1])) {
                $priceRange[$priceFilters[$i]['filter_code']] = array(
                    'min' => $priceFilters[$i]['starts_from'],
                    'max' => $priceFilters[$i+1]['starts_from'],
                );
            } else {
                $priceRange[$priceFilters[$i]['filter_code']] = array(
                    'min' => $priceFilters[$i]['starts_from'],
                );
            }
        }
    }
    $level = $_GET['level'];

    $matched_products = array();
    $min = floatval($priceRange[$level]['min']);
    $max = (isset($priceRange[$level]['max'])) ? floatval($priceRange[$level]['max']) : false;

    if($max) {
        $matched_products_query = apply_filters( 'woocommerce_price_filter_results', $wpdb->get_results( $wpdb->prepare("
            SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta ON ID = post_id
            WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish' AND meta_key = %s AND meta_value >= %d AND meta_value < %d order by meta_value ASC
        ", '_price', $min, $max ), OBJECT_K ), $min, $max );
    } else {
        $matched_products_query = apply_filters( 'woocommerce_price_filter_results', $wpdb->get_results( $wpdb->prepare("
            SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta ON ID = post_id
            WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish' AND meta_key = %s AND meta_value >= %d order by meta_value ASC
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
            $price = $objProduct->get_price();
            $currency = get_option('woocommerce_currency');
            $currency = get_woocommerce_currency_symbol( $currency );
            $postData = $objProduct->get_post_data();
            $objCategories = get_the_terms($productId, 'product_cat');
            if(count($objCategories)) {
                foreach($objCategories as $term) {
                    switch($term->slug) {
                        case "red-dozen":
                            $arrRedDozen[] = array(
                                'id' => $postData->ID,
                                'title' => $postData->post_title,
                                'price' => $currency.$price
                            );
                            break;
                        case "white-dozen":
                            $arrWhiteDozen[] = array(
                                'id' => $postData->ID,
                                'title' => $postData->post_title,
                                'price' => $currency.$price
                            );
                            break;
                        case "mixed-dozen":
                            $arrMixedDozen[] = array(
                                'id' => $postData->ID,
                                'title' => $postData->post_title,
                                'price' => $currency.$price
                            );
                            break;
                    }
                }
            }

        }
    } 

    ob_start();
    ?>
    <div class="vc_col-sm-4 vc_col-xs-12">
        <div class="checkbx extended"><input class="wine-chkbx" id="chk-red-dozen" value="1" name="chk-red-dozen" type="checkbox"><label for="chk-red-dozen"><span class="cbimg"></span></label></div>
        <select name="wine" id="red-dozen" class="selWine">
            <option value="">Red Dozen</option>
            <?php 
            if(count($arrRedDozen)) {
                foreach($arrRedDozen as $wine ) { ?>
                    <option value="<?php echo $wine['id']; ?>"><?php echo $wine['title']; ?> ( <?php echo $wine['price'] ?> ) </option>
            <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="vc_col-sm-4 vc_col-xs-12">
        <div class="checkbx extended"><input class="wine-chkbx" id="chk-white-dozen" value="1" name="chk-white-dozen" type="checkbox"><label for="chk-white-dozen"><span class="cbimg"></span></label></div>
        <select name="wine" id="white-dozen" class="selWine">
            <option value="">White Dozen</option>
            <?php 
            if(count($arrWhiteDozen)) {
                foreach($arrWhiteDozen as $wine ) { ?>
                    <option value="<?php echo $wine['id']; ?>"><?php echo $wine['title']; ?> ( <?php echo $wine['price'] ?> ) </option>
            <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="vc_col-sm-4 vc_col-xs-12">
        <div class="checkbx extended"><input class="wine-chkbx" id="chk-mixed-dozen" value="1" name="chk-mixed-dozen" type="checkbox"><label for="chk-mixed-dozen"><span class="cbimg"></span></label></div>
        <select name="wine" id="mixed-dozen" class="selWine">
            <option value="">Mixed Dozen</option>
            <?php 
            if(count($arrMixedDozen)) {
                foreach($arrMixedDozen as $wine ) { ?>
                    <option value="<?php echo $wine['id']; ?>"><?php echo $wine['title']; ?> ( <?php echo $wine['price'] ?> ) </option>
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

add_filter('acf/validate_value/name=starts_from', 'validate_starts_from_func', 10, 4);
function validate_starts_from_func($valid, $value, $field, $input) {
    if (!$valid) {
        return $valid;
    }
    $repeater_key = 'field_582b12567333e';
    $start_key = 'field_582b128373340';
    // extract row from input
    if(count($_POST['acf'][$repeater_key]) < 2) 
        return $valid;
    
    // collect array keys
    $arrKeys = array_keys($_POST['acf'][$repeater_key]);
    
    $row = preg_replace('/^\s*acf\[[^\]]+\]\[([^\]]+)\].*$/', '\1', $input);
    
    $currentIndex = array_search($row, $arrKeys);
    $previousIndex = $currentIndex-1;

    $lower_value = $_POST['acf'][$repeater_key][$arrKeys[$previousIndex]][$start_key];
    $current_value = $value;
    if ($current_value < $lower_value) {
          $valid = 'Start value must be greater than previous start value';
    }
    $oldRowId = $row;
    return $valid;
}

function mc_subscribe($email, $fname, $lname, $debug, $apikey, $listid, $server) {	
	
		// MailChimp API credentials
		$apiKey = $apikey;
        $listID = $listid;
        
        // MailChimp API URL
        $memberID = md5(strtolower($email));
        $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listID . '/members/' . $memberID;
	
		// member information
		$data = array(
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => array(
                'FNAME'     => $fname,
				'LNAME'		=> $lname
            )
        );
		$json = json_encode($data);
        
        // send a HTTP POST request with curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

		print_r($json);

		// store the status message based on response code
        if ($httpCode == 200) {
             $msg = '<p style="color: #34A853">You have successfully subscribed to CodexWorld.</p>';
        } else {
            switch ($httpCode) {
                case 214:
                    $msg = 'You are already subscribed.';
                    break;
                default:
                    $msg = 'Some problem occurred, please try again.';
                    break;
            }
           $msg = '<p style="color: #EA4335">'.$msg.'</p>';
        }	
		
		return $msg;
}
add_action( 'wp_ajax_lets_communicate', 'lets_communicate' );

function lets_communicate(){
	
	$msg = '';
	$form_opt = get_field('list_of_options','option');
	$ids = $_POST['list_ids'];
	$user_id =  $_POST['user_id'];
	$email = $_POST['user_email'];
	$fname = $_POST['user_firstname'];
	$apikey = get_field('api_key','option');
	$server = 'us12';
	
	// Check none is selected or not 
	
	// Check in array , if in array 
	if(in_array('none',$ids)){
		
		//Fetch all List Ids 		
		foreach($form_opt as $opt) {
			$allIds[] = $opt['list_id']; 
		}
				
		//loop to unsubscribe all list 
		$unsubscribeLists = array_diff($allIds,$ids);
		
		//Unset none index from $ids
		unset($ids['none']);
		
		$msg = 'unsubscribe';	
	}
	
	// Check Length of ids, check numbers of ids available
	if(count($ids)){
		
		//print_r($ids);
		foreach($ids as $id){
			mc_subscribe($email, $fname, $lname, false, $apikey, $id, $server);
		}
		
		$msg = 'subscribe';
	}
	
	return $msg;
}