<?php

/**
 * Plugin Name: Select2 Dropdown
 * Plugin URI: 
 * Description: Adds select2 to any screens
 * Version: 1.0
 * Author: Bhumika Trivedi
 * Author URI: 
 * License: GPL2
 */

function enqueue_select2_jquery() {
    wp_register_style( 'select2css', 'http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.css', false, '1.0', 'all' );
    wp_register_script( 'select2', 'http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_style( 'select2css' );
    wp_enqueue_script( 'select2' );
    }
add_action( 'admin_enqueue_scripts', 'enqueue_select2_jquery' );

function select2jquery_inline() {
    ?>
<style type="text/css">
.select2-container {margin: 0 2px 0 2px;}
.tablenav.top #doaction, #doaction2, #post-query-submit {margin: 0px 4px 0 4px;}
</style>        
<script type='text/javascript'>
jQuery(document).ready(function ($) {
   $("select").select2(); 
   $( document.body ).on( "click", function() {
        $("select").select2(); 
     });
});
</script>   
    <?php
 }
add_action( 'admin_head', 'select2jquery_inline' ); 