<?php
/*
Plugin Name: Create Case
Plugin URI: http://www.daivat.com/
Description: HTML5 Product Designer for Wordpress and WooCommerce. Create and sell customizable products.
Version: 1.0.0
Author: Daivat Soni
Author URI: http://www.daivat.com
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action("woocommerce_before_single_product_summary", "create_case");

if(!function_exists("create_case")) {
    function create_case() {
        wp_enqueue_style("create-case", plugin_dir_url( __FILE__ )."css/createcase.css");
        wp_enqueue_script("create-case", plugin_dir_url( __FILE__ )."js/createcase.js", array("jquery") );
        ?>
        <div class="content">
            <div class="component">
                <div class="overlay">
                    <div class="overlay-inner">
                    </div>
                </div>
                <!-- This image must be on the same domain as the demo or it will not work on a local file system -->
                <!-- http://en.wikipedia.org/wiki/Cross-origin_resource_sharing -->
                <img class="resize-image" src="<?php echo plugin_dir_url( __FILE__ )."img/PlaceHolder.jpg"; ?>" alt="Upload Your Image">
                <button class="btn-crop js-crop">Crop<img class="icon-crop" src="<?php echo plugin_dir_url( __FILE__ )."img/crop.svg"; ?>"></button>
            </div>
            <div class="a-tip">
                    <p><strong>Hint:</strong> hold <span>SHIFT</span> while resizing to keep the original aspect ratio.</p>
            </div>
        </div>
        <ul>
            <li>Label 1</li>
            <li>Edit Text</li>
            <li>Choose Photo</li>
            <li>Save</li>
        </ul>

        <div class="fpd-module" data-module="text" data-moduleicon="fpd-icon-text-secondary" data-defaulttext="Add Text" data-title="Add Text">
            <textarea data-defaulttext="Enter some text" placeholder="Enter some text"></textarea>
            <div class="fpd-btn"><span data-defaulttext="Add Text">Add Text</span> <span class="fpd-price"></span></div>
        </div>

        <div class="fpd-module-tabs-content">
            <div data-context="upload">
                <form class="fpd-upload-form" enctype="multipart/form-data" method="POST">
                    <div class="fpd-upload-zone">
                        <div>
                            <span class="fpd-icon-file-upload"></span>
                            <span data-defaulttext="Click or drop images here">Click or drop images here</span>
                        </div>
                    </div>
                    <input type="file" multiple="multiple" class="fpd-input-image" name="files[]" />
                </form>
                <div class="fpd-scroll-area">
                    <div class="fpd-grid fpd-grid-cover fpd-photo-grid"></div>
                </div>
            </div>
            <div data-context="facebook">
                <div class="fpd-head">
                    <div class="fpd-facebook-login">
                        <fb:login-button data-max-rows="1" data-show-faces="false" data-scope="user_photos"></fb:login-button>
                    </div>
                    <div class="fpd-facebook-albums fpd-dropdown fpd-search fpd-on-loading">
                        <input type="text" class="fpd-dropdown-current"  data-defaulttext="Select An Album" placeholder="Select An Album" />
                        <div class="fpd-dropdown-arrow"><span class="fpd-icon-arrow-dropdown"></span></div>
                        <div class="fpd-dropdown-list"></div>
                    </div>
                </div>
                <div class="fpd-scroll-area">
                    <div class="fpd-grid fpd-grid-cover fpd-photo-grid"></div>
                </div>
            </div>
            <div data-context="instagram">
                <!--<div class="fpd-head">
                        <div class="fpd-module-tabs">
                                 <div class="fpd-insta-recent-images" data-defaulttext="My Recent Photos">My Recent Photos</div>
                        <div class="fpd-insta-liked-images" data-defaulttext="My Liked Photos">My Liked Photos</div>
                            </div>
                </div>-->
                <div class="fpd-scroll-area">
                    <div class="fpd-grid fpd-grid-cover fpd-photo-grid"></div>
                </div>
            </div>
        </div>
        <?php
    }
}

add_action("woocommerce_after_add_to_cart_form", "check_add_to_cart");
function check_add_to_cart() {
    
}