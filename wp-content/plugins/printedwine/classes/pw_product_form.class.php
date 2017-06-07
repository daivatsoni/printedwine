<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if(!class_exists('PW_Product_Form')) {

    class PW_Product_Form {

        private $form_views = null;
        private $remove_watermark = false;

        public function __construct() {
            add_action( 'woocommerce_before_single_product_summary', array( &$this, 'add_product_designer'), 15 );
            //add additional form fields to cart form
            add_action( 'woocommerce_before_add_to_cart_button', array( &$this, 'add_product_designer_form') );
        }

        //the additional form fields
        public function add_product_designer_form() {
            ?>

            <input type="hidden" value="" name="pw_product" />
            <input type="hidden" value="0" name="pw_product_price" />
            <input type="hidden" value="" name="pw_product_thumbnail" />
            <input type="hidden" value="<?php echo isset($_GET['cart_item_key']) ? $_GET['cart_item_key'] : ''; ?>" name="pw_remove_cart_item" />
            <?php
        }

        
        //the actual product designer will be added
        public function add_product_designer() {
            global $post;
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    $selector = jQuery('#<?php echo $selector; ?>');
                    $productWrapper = jQuery('.post-<?php echo $post->ID; ?>');
                    $cartForm = jQuery('[name="pw_product"]:first').parents('form:first');
                    
                    //fill custom form with values and then submit
                    $cartForm.on('click', ':submit', function(evt) {

                        evt.preventDefault();

                        $cartForm.find('input[name="pw_product"]').val(JSON.stringify("product1"));
                        $cartForm.find('input[name="pw_product_thumbnail"]').val("dataurl1");
                        $cartForm.submit();
                    });
                });
            </script>

            <?php
        }

        
        
    } // end of class 
} // end if
new PW_Product_Form();
