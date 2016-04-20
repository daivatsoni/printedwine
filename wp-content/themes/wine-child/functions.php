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
        /*
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
        */

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


?>