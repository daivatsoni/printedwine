<?php

/**
 * Theme functions and definitions
 *
 * @package Wine
 */
/**
 * Enqueue scripts and styles
 */
add_action('wp_enqueue_scripts', 'themerex_scripts');
if (!function_exists('themerex_scripts')) {

    function themerex_scripts() {
        global $concatenate_scripts;
        $concatenate_scripts = get_theme_option('compose_scripts') == 'yes';

        //custom fonts
        $fonts = getThemeFontsList(false);

        $fontArray = array('theme_font', 'header_font', 'logo_font');
        $fontUsed = array();
        foreach ($fontArray as $fnt) {
            $fnt = get_custom_option($fnt);
            if (!in_array($fnt, $fontUsed)) {
                $fontUsed[] = $fnt;

                if (isset($fonts[$fnt]) && isset($fonts[$fnt]['ext'])) {
                // do code for custom fonts.

                } else {
                    $theme_font_link = !empty($fonts[$fnt]['link']) ? $fonts[$fnt]['link'] : str_replace(' ', '+', $fnt) . '		:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic';
                    themerex_enqueue_style('theme-font-' . str_replace(' ', '_', $fnt), 'http://fonts.googleapis.com/css?family=' . $theme_font_link . '&subset=latin,cyrillic-ext,latin-ext,cyrillic', array(), null);
                }
            }
        }

        themerex_enqueue_style('fontello', get_template_directory_uri() . '/includes/fontello/css/fontello.css', array(), null);
        themerex_enqueue_style('animation', get_template_directory_uri() . '/includes/fontello/css/animation.css', array(), null);
        // Main stylesheet
        themerex_enqueue_style('main-style', get_stylesheet_uri(), array(), null);
        themerex_enqueue_style('second-style', get_stylesheet_directory_uri() . '/css/secondstyle.css', array(), null);
        // Shortcodes
        themerex_enqueue_style('shortcodes', get_template_directory_uri() . '/includes/shortcodes/shortcodes.css', array('main-style'), null);
        // Customizer
        wp_add_inline_style('shortcodes', prepareThemeCustomStyles());
        // Responsive
        if (get_theme_option('responsive_layouts') == 'yes') {
            themerex_enqueue_style('responsive', get_template_directory_uri() . '/css/responsive.css', array('main-style'), null);
        }
        // WooCommerce customizer
        if (function_exists('is_woocommerce')) {
            themerex_enqueue_style('woo-style', get_template_directory_uri() . '/css/woo-style.css', array('main-style'), null);
        }

        // Load scripts	
        themerex_enqueue_script('jquery', false, array(), null, true);
        themerex_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array('jquery'), null, true);
        themerex_enqueue_script('jquery-easing', get_template_directory_uri() . '/js/jquery.easing.js', array('jquery'), null, true);
        themerex_enqueue_script('jquery-autosize', get_template_directory_uri() . '/js/jquery.autosize.js', array('jquery'), null, true);

        themerex_enqueue_script('jquery-ui-core', false, array(), null, true);
        themerex_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);

        themerex_enqueue_script('jquery-effects-core', false, array(), null, true);
        themerex_enqueue_script('jquery-effects-fade', false, array('jquery', 'jquery-effects-core'), null, true);

        themerex_enqueue_script('superfish', get_stylesheet_directory_uri() . '/js/superfish.js', array('jquery'), null, true);

        themerex_enqueue_script('_utils', get_template_directory_uri() . '/js/_utils.js', array(), null, true);
        themerex_enqueue_script('_front', get_template_directory_uri() . '/js/_front.js', array(), null, true);

        themerex_enqueue_script('shortcodes-init', get_template_directory_uri() . '/includes/shortcodes/shortcodes_init.js', array(), null, true);

        themerex_enqueue_style('magnific-style', get_template_directory_uri() . '/js/magnific-popup/magnific-popup.css', array(), null);
        themerex_enqueue_script('magnific', get_template_directory_uri() . '/js/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), null, true);

        themerex_enqueue_style('swiperslider-style', get_template_directory_uri() . '/js/swiper/idangerous.swiper.css', array(), null);
        themerex_enqueue_script('swiperslider', get_template_directory_uri() . '/js/swiper/idangerous.swiper-2.1.js', array('jquery'), null, true);
        themerex_enqueue_style('swiperslider-scrollbar-style', get_template_directory_uri() . '/js/swiper/idangerous.swiper.scrollbar.css', array(), null);
        themerex_enqueue_script('swiperslider-scrollbar', get_template_directory_uri() . '/js/swiper/idangerous.swiper.scrollbar-2.1.js', array('jquery'), null, true);

        // Shortcodes
        themerex_enqueue_style('shortcodes', get_template_directory_uri() . '/includes/shortcodes/shortcodes.css', array('main-style'), null);
        themerex_enqueue_script('shortcodes-init', get_template_directory_uri() . '/includes/shortcodes/shortcodes_init.js', array(), null, true);

        // Media elements library
        if (get_theme_option('use_mediaelement') == 'yes') {
            if (floatval(get_bloginfo('version')) > "3.6") {
                themerex_enqueue_style('mediaelement');
                themerex_enqueue_style('wp-mediaelement');
                themerex_enqueue_script('mediaelement');
                themerex_enqueue_script('wp-mediaelement');
            } else {
                global $wp_scripts, $wp_styles;
                $wp_styles->done[] = 'mediaelement';
                $wp_styles->done[] = 'wp-mediaelement';
                $wp_scripts->done[] = 'mediaelement';
                $wp_scripts->done[] = 'wp-mediaelement';
                themerex_enqueue_script('mediaplayer', get_template_directory_uri() . '/js/mediaelement/mediaelement.min.js', array(), null, true);
                themerex_enqueue_style('mediaplayer-style', get_template_directory_uri() . '/js/mediaelement/mediaelement.css', array(), null);
            }

            themerex_enqueue_style('mediaelement-custom', get_template_directory_uri() . '/js/mediaelement/mediaplayer_custom.css', array(), null);
        } else {
            global $wp_scripts, $wp_styles;
            $wp_styles->done[] = 'mediaelement';
            $wp_styles->done[] = 'wp-mediaelement';
            $wp_scripts->done[] = 'mediaelement';
            $wp_scripts->done[] = 'wp-mediaelement';
        }

        themerex_enqueue_script('hover-dir', get_template_directory_uri() . '/js/hover/jquery.hoverdir.js', array(), null, true);
        themerex_enqueue_script('hover-intent', get_template_directory_uri() . '/js/hover/hoverIntent.js', array(), null, true);

        themerex_enqueue_script('isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array(), null, true);
        themerex_enqueue_script('isotope-pkgd', get_template_directory_uri() . '/js/jquery.isotope.pkgd.js', array(), null, true);

        themerex_enqueue_script('parallax', get_template_directory_uri() . '/js/parallax.js', array(), null, true);

        if (get_theme_option('custom_scroll') == 'yes') {
            themerex_enqueue_script('smooth-scroll', get_template_directory_uri() . '/js/SmoothScroll.js', array(), null, true);
        }

        themerex_enqueue_script('diagram-chart', get_template_directory_uri() . '/js/diagram/chart.min.js', array(), null, true);
        themerex_enqueue_script('diagram-raphael', get_template_directory_uri() . '/js/diagram/diagram.raphael.js', array(), null, true);

        if (is_singular() && get_theme_option('show_share') == 'yes') {
            themerex_enqueue_script('social-share', get_template_directory_uri() . '/js/social/social-share.js', array(), null, true);
        }

        if (get_custom_option('show_login') == 'yes') {
            themerex_enqueue_script('form-login', get_template_directory_uri() . '/js/_form_login.js', array(), null, true);
        }

        if (is_singular() && comments_open() && get_option('thread_comments')) {
            themerex_enqueue_script('comment-reply', false, array(), null, true);
            themerex_enqueue_script('form-comments', get_template_directory_uri() . '/js/_form_comments.js', array(), null, true);
        }

        if (get_theme_option('allow_editor') == 'yes' && ((is_single() && current_user_can('edit_posts', get_the_ID())) || (is_page() && current_user_can('edit_pages', get_the_ID())))) {
            themerex_enqueue_style('frontend-editor-style', get_template_directory_uri() . '/js/editor/_editor.css', array('main-style'), null);
            themerex_enqueue_script('frontend-editor', get_template_directory_uri() . '/js/editor/_editor.js', array(), null, true);
        }
        themerex_enqueue_style('messages-style', get_template_directory_uri() . '/js/messages/_messages.css', array('main-style'), null);
        themerex_enqueue_script('messages', get_template_directory_uri() . '/js/messages/_messages.js', array(), null, true);

        if (get_theme_option('show_theme_customizer') == 'yes') {
            themerex_enqueue_script('jquery-ui-draggable', false, array('jquery', 'jquery-ui-core'), null, true);
            themerex_enqueue_script('_customizer', get_template_directory_uri() . '/js/_customizer.js', array(), null, true);
        }
    }

}

/*
 * Register widgetized area and update sidebar with default widgets
 */
add_action('widgets_init', 'themerex_widgets_init');
if (!function_exists('themerex_widgets_init')) {

    function themerex_widgets_init() {
        if (function_exists('register_sidebar')) {
            register_sidebar(array(
                'name' => __('Main Sidebar', 'themerex'),
                'id' => 'sidebar-main',
                'before_widget' => '<aside id="%1$s" class="widgetWrap %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h5 class="title">',
                'after_title' => '</h5>',
            ));
            register_sidebar(array(
                'name' => __('Top Sidebar', 'themerex'),
                'id' => 'sidebar-top',
                'before_widget' => '<aside id="%1$s" class=" widgetWrap %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h5 class="title">',
                'after_title' => '</h5>',
            ));
            register_sidebar(array(
                'name' => __('Footer Sidebar', 'themerex'),
                'id' => 'sidebar-footer',
                'before_widget' => '<aside id="%1$s" class="widgetWrap %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h5 class="heading">',
                'after_title' => '</h5>',
            ));
            // Custom sidebars
            $sidebars = get_theme_option('custom_sidebars');
            if (is_array($sidebars) && count($sidebars) > 0) {
                foreach ($sidebars as $i => $sb) {
                    if (trim(chop($sb)) == '')
                        continue;
                    register_sidebar(array(
                        'name' => $sb,
                        'id' => 'custom-sidebar-' . $i,
                        'before_widget' => '<aside id="%1$s" class="widgetWrap %2$s">',
                        'after_widget' => '</aside>',
                        'before_title' => '<h5 class="title">',
                        'after_title' => '</h5>',
                    ));
                }
            }
        }
    }

}


function getMyCategoryChildsFull( $parent_id, $pos, $array, $level, &$dropdown ) {

    for ( $i = $pos; $i < count( $array ); $i ++ ) {
        if ( $array[ $i ]->category_parent == $parent_id ) {
            $name = str_repeat( "- ", $level ) . $array[ $i ]->name;
            $value = $array[ $i ]->slug;
            $dropdown[] = array( 'label' => $name, 'value' => $value );
            getMyCategoryChildsFull( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
        }
    }
}

$order_by_values = array(
    '',
    __( 'Date', 'js_composer' ) => 'date',
    __( 'ID', 'js_composer' ) => 'ID',
    __( 'Author', 'js_composer' ) => 'author',
    __( 'Title', 'js_composer' ) => 'title',
    __( 'Modified', 'js_composer' ) => 'modified',
    __( 'Random', 'js_composer' ) => 'rand',
    __( 'Comment count', 'js_composer' ) => 'comment_count',
    __( 'Menu order', 'js_composer' ) => 'menu_order',
);

$order_way_values = array(
    '',
    __( 'Descending', 'js_composer' ) => 'DESC',
    __( 'Ascending', 'js_composer' ) => 'ASC',
);


if (taxonomy_exists('product_cat')) {
    $categories1 = get_terms( 'product_cat', array(
        'orderby'    => 'count',
        'hide_empty' => 0
    ) );
} else {
    register_taxonomy("product_cat", "product");
    $categories1 = get_terms( 'product_cat', array(
        'orderby'    => 'count',
        'hide_empty' => 0
    ) );
}

$product_categories_dropdown = array();
getMyCategoryChildsFull( 0, 0, $categories1, 0, $product_categories_dropdown );

vc_map(array(
    'name' => __('Product Slider', 'js_composer'),
    'base' => 'product_slider',
    'icon' => 'icon-wpb-woocommerce',
    'category' => __('WooCommerce', 'js_composer'),
    'description' => __('Show slider of multiple products in a category', 'js_composer'),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __('Total products', 'js_composer'),
            'value' => 12,
            'save_always' => true,
            'param_name' => 'per_page',
            'description' => __('How many items to show', 'js_composer'),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __('Order by', 'js_composer'),
            'param_name' => 'orderby',
            'value' => $order_by_values,
            'save_always' => true,
            'description' => sprintf(__('Select how to sort retrieved products. More at %s.', 'js_composer'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __('Sort order', 'js_composer'),
            'param_name' => 'order',
            'value' => $order_way_values,
            'save_always' => true,
            'description' => sprintf(__('Designates the ascending or descending order. More at %s.', 'js_composer'), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>')
        ),
        array(
            'type' => 'dropdown',
            'heading' => __('Category', 'js_composer'),
            'value' => $product_categories_dropdown,
            'param_name' => 'category',
            'save_always' => true,
            'description' => __('Product category list', 'js_composer'),
        ),
    )
));

add_shortcode("product_slider", "product_slider", 1);

function product_slider( $atts ) {
    
    wp_enqueue_style("owl-carousel", get_stylesheet_directory_uri()."/css/owl.carousel.css");
    wp_enqueue_script("owl-carousel", get_stylesheet_directory_uri()."/js/owl.carousel.min.js", array('jquery'));
    
    $atts = shortcode_atts( array(
            'per_page' => '12',
            'orderby'  => 'title',
            'order'    => 'desc',
            'category' => '',  // Slugs
            'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
    ), $atts );

    if ( ! $atts['category'] ) {
            return '';
    }

    $ordering_args = WC()->query->get_catalog_ordering_args( $atts['orderby'], $atts['order'] );
    $meta_query    = WC()->query->get_meta_query();
    $query_args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'slug',
                'terms' => $atts['category']
            )
        ),
        'orderby'             => $ordering_args['orderby'],
        'order'               => $ordering_args['order'],
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => $atts['per_page'],
        'meta_query'          => $meta_query
    );
    $loop = new WP_Query($query_args);
    
    ob_start();
    
    if ($loop->have_posts()) {
        
        do_action( "woocommerce_shortcode_before_product_cat_loop" );

        woocommerce_product_loop_start();

            while ( $loop->have_posts() ) : $loop->the_post();

                wc_get_template_part( 'content', 'product' );

            endwhile; // end of the loop.

        woocommerce_product_loop_end();

        do_action( "woocommerce_shortcode_after_product_cat_loop" );

    } else {
        
        echo __('No products found');
        
    }
    woocommerce_reset_loop();
    wp_reset_postdata();

    ?>
    <script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery(".product-slider .products").owlCarousel({
            items: 3,
            loop: true,
            center: true,
            nav: true,
            autoplay: true,
            responsive: {
                0 : {
                    items: 1
                },
                // breakpoint from 480 up
                480 : {
                    items: 1
                },
                // breakpoint from 768 up
                768 : {
                    items: 2
                },
                1024 : {
                    items: 3
                }
            }
        });
    });
    </script>
    <?php
    return '<div class="woocommerce product-slider">' . ob_get_clean() . '</div>';
//    return WC_Shortcodes::product_category($atts);

}

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png);
            padding-bottom: 30px;
            background-size: 200px;
            width: 200px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

add_filter( 'woocommerce_account_menu_items', 'pw_change_account_navigation_items', 10, 1);
function pw_change_account_navigation_items($items) {
    $mySort = array(
        'dashboard'       => __( 'Dashboard', 'woocommerce' ),
        'edit-account'    => __( 'Account Details', 'woocommerce' ),
        'edit-address'    => __( 'Addresses', 'woocommerce' ),
        'orders'          => __( 'Purchase History', 'woocommerce' ),
        'downloads'       => __( 'Downloads', 'woocommerce' ),
        'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
        'customer-logout' => __( 'Logout', 'woocommerce' ),
    );
    $newItems = array();
    
    foreach($mySort as $endpoint => $value) {
        if(isset($items[$endpoint]))
            $newItems[$endpoint] = $mySort[$endpoint];
    }
    
    return $newItems;
}

function pw_social_login_facebook_new_user_data($arrUserData) {
    if(isset($arrUserData['role']) && $arrUserData['role']=='customer') {
        $arrUserData['role'] = "subscriber";
    }
    return $arrUserData;
}
add_filter( 'wc_social_login_facebook_new_user_data', 'pw_social_login_facebook_new_user_data');

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'PrintedWine Settings',
        'menu_title'	=> 'PrintedWine Settings',
        'menu_slug' 	=> 'printedwine-settings',
        'capability'	=> 'edit_posts',
        'redirect'	=> false
    ));
}

