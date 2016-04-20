<?php

/**
 * Theme functions and definitions
 *
 * @package Wine
 */
/* ========================= Filters and action handlers ============================== */

/* PRE_QUERY - add filter to main query */
add_filter('posts_where', 'themerex_filter_where');
if (!function_exists('themerex_filter_where')) {

    function themerex_filter_where($where = '') {
        global $wpdb, $wp_query;
        if (is_admin() || $wp_query->is_attachment())
            return $where;
        $prv = current_user_can('read_private_pages') && current_user_can('read_private_posts') ? " OR {$wpdb->posts}.post_status='private'" : '';
        if (themerex_strpos($where, 'post_status') === false && (!isset($_REQUEST['preview']) || $_REQUEST['preview'] != 'true'))
            $where .= " AND " . (!empty($prv) ? '(' : '') . "{$wpdb->posts}.post_status='publish'" . (!empty($prv) ? $prv : '') . (!empty($prv) ? ')' : '');
        return $where;
    }

}

/* PRE QUERY - posts per page selector */
add_action('pre_get_posts', 'themerex_posts_per_page_selector');
if (!function_exists('themerex_posts_per_page_selector')) {

    function themerex_posts_per_page_selector($query) {
        if (is_admin() || !$query->is_main_query())
            return;
        $orderby_set = true;
        $orderby = get_theme_option('blog_sort');
        $order = get_theme_option('blog_order');
        // Set posts per page
        $ppp = (int) get_theme_option('posts_per_page');
        $ppp2 = 0;
        if ($query->is_category()) {
            $cat = (int) $query->get('cat');
            if (empty($cat))
                $cat = $query->get('category_name');
            if (!empty($cat)) {
                //$ppp2 = (int) get_category_inherited_property($cat, 'posts_per_page', 0);
                $cat_options = get_category_inherited_properties($cat);
                if (isset($cat_options['posts_per_page']) && !empty($cat_options['posts_per_page']) && !is_inherit_option($cat_options['posts_per_page']))
                    $ppp2 = (int) $cat_options['posts_per_page'];
                if (isset($cat_options['blog_sort']) && !empty($cat_options['blog_sort']) && !is_inherit_option($cat_options['blog_sort']))
                    $orderby = $cat_options['blog_sort'];
                if (isset($cat_options['blog_order']) && !empty($cat_options['blog_order']) && !is_inherit_option($cat_options['blog_order']))
                    $order = $cat_options['blog_order'];
            }
        } else {
            if ($query->get('post_type') == 'product' || $query->get('product_cat') != '' || $query->get('product_tag') != '') {
                $orderby_set = false;
                $page_id = get_option('woocommerce_shop_page_id');
            } else if ($query->is_archive())
                $page_id = getTemplatePageId('archive');
            else if ($query->is_search()) {
                $page_id = getTemplatePageId('search');
            } else if ($query->is_posts_page == 1)
                $page_id = isset($query->queried_object_id) ? $query->queried_object_id : getTemplatePageId('blog');
            else {
                $orderby_set = false;
                $page_id = 0;
            }
            if ($page_id > 0) {
                $post_options = get_post_meta($page_id, 'post_custom_options', true);
                if (isset($post_options['posts_per_page']) && !empty($post_options['posts_per_page']) && !is_inherit_option($post_options['posts_per_page']))
                    $ppp2 = (int) $post_options['posts_per_page'];
                if ($orderby_set) {
                    if (isset($post_options['blog_sort']) && !empty($post_options['blog_sort']) && !is_inherit_option($post_options['blog_sort']))
                        $orderby = $post_options['blog_sort'];
                    if (isset($post_options['blog_order']) && !empty($post_options['blog_order']) && !is_inherit_option($post_options['blog_order']))
                        $order = $post_options['blog_order'];
                }
            }
        }
        if ($ppp2 > 0)
            $ppp = $ppp2;
        if ($ppp > 0)
            $query->set('posts_per_page', $ppp);
        if ($orderby_set)
            addSortOrderInQuery($query, $orderby, $order);
        // Exclude categories
        $ex = get_theme_option('exclude_cats');
        if (!empty($ex))
            $query->set('category__not_in', explode(',', $ex));
    }

}

/* Filter categories list */
add_action('widget_categories_args', 'themerex_categories_args_filter');
add_action('widget_categories_dropdown_args', 'themerex_categories_args_filter');
if (!function_exists('themerex_categories_args_filter')) {

    function themerex_categories_args_filter($args) {
        $ex = get_theme_option('exclude_cats');
        if (!empty($ex)) {
            $args['exclude'] = $ex;
        }
        return $args;
    }

}

/* Exclude post from categories */
add_action('widget_posts_args', 'themerex_posts_args_filter');
if (!function_exists('themerex_posts_args_filter')) {

    function themerex_posts_args_filter($args) {
        $ex = get_theme_option('exclude_cats');
        if (!empty($ex)) {
            $args['category__not_in'] = explode(',', $ex);
        }
        return $args;
    }

}

add_filter('widget_text', 'themerex_widget_text_filter');
if (!function_exists('themerex_widget_text_filter')) {

    function themerex_widget_text_filter($text) {
        return substituteAll($text);
    }

}

// Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
add_filter('wp_page_menu_args', 'themerex_page_menu_args');
if (!function_exists('themerex_page_menu_args')) {

    function themerex_page_menu_args($args) {
        $args['show_home'] = true;
        return $args;
    }

}

// Adds custom classes to the array of body classes.
add_filter('body_class', 'themerex_body_classes');
if (!function_exists('themerex_body_classes')) {

    function themerex_body_classes($classes) {
        // Adds a class of group-blog to blogs with more than 1 published author
        if (is_multi_author()) {
            $classes[] = 'group-blog';
        }

        return $classes;
    }

}

// Filters wp_title to print a neat <title> tag based on what is being viewed.
add_filter('wp_title', 'themerex_wp_title', 10, 2);
if (!function_exists('themerex_wp_title')) {

    function themerex_wp_title($title, $sep) {
        global $page, $paged;
        if (is_feed())
            return $title;
        // Add the blog name
        $title .= get_bloginfo('name');
        // Add the blog description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && ( is_home() || is_front_page() ))
            $title .= " $sep $site_description";
        // Add a page number if necessary:
        if ($paged >= 2 || $page >= 2)
            $title .= " $sep " . sprintf(__('Page %s', 'themerex'), max($paged, $page));
        return $title;
    }

}


// Add class "widget-number-#' for each widget
add_filter('dynamic_sidebar_params', 'themerex_add_widget_number', 10, 1);
if (!function_exists('themerex_add_widget_number')) {

    function themerex_add_widget_number($prm) {
        if (is_admin())
            return $prm;
        static $num = 0, $last_sidebar = '', $last_sidebar_count = 0, $sidebars_widgets = array();
        global $THEMEREX_CURRENT_SIDEBAR, $THEMEREX_SIDEBAR_COLUMNS;

        if ($THEMEREX_CURRENT_SIDEBAR == 'shortcode') {
            
        }

        if (count($sidebars_widgets) == 0)
            $sidebars_widgets = wp_get_sidebars_widgets();
        if ($last_sidebar != $THEMEREX_CURRENT_SIDEBAR) {
            $num = 0;
            $last_sidebar = $THEMEREX_CURRENT_SIDEBAR;
            $last_sidebar_count = count($sidebars_widgets[$prm[0]['id']]);
        }
        $get_columns_sc = $THEMEREX_SIDEBAR_COLUMNS;

        $get_columns = $last_sidebar != 'shortcode' ? get_custom_option('widget_columns_' . $THEMEREX_CURRENT_SIDEBAR) : $get_columns_sc;

        $widget_columns = max(1, min(6, ( $get_columns != '' ? $get_columns : '4')));
        $num++;
        $prm[0]['before_widget'] = str_replace(' class="', ' class="widget-number-' . $num . ' ', $prm[0]['before_widget']);

        //main
        if (($last_sidebar_count > $num && $last_sidebar == 'main') || ($last_sidebar_count > $num && $last_sidebar == 'shortcode' && $get_columns_sc == 1)) {
            $prm[0]['before_widget'] = str_replace(' class="', ' class="widget-first ', $prm[0]['before_widget']);
        }



        //footer || top
        if ($last_sidebar == 'footer' || $last_sidebar == 'top') {
            $prm[0]['before_widget'] = str_replace(' class="', ' class="sc_columns_item ', $prm[0]['before_widget']);
            if ($num == 1)
                $prm[0]['before_widget'] = '<div class="sc_columns_' . $widget_columns . ' sc_columns_indent"><div class="widget_area">' . $prm[0]['before_widget'];
            if ($last_sidebar_count == $num)
                $prm[0]['after_widget'] .= '</div></div>';
            else if ($num % $widget_columns == 0) {
                $prm[0]['after_widget'] .= '</div></div><div class="sc_columns_' . $widget_columns . ' sc_columns_indent widget_area widget_second">';
            }
        }

        //footer || top
        if ($last_sidebar == 'shortcode' && $get_columns_sc > 1) {
            $prm[0]['before_widget'] = str_replace(' class="', ' class="sc_columns_item ', $prm[0]['before_widget']);
            $prm[0]['before_widget'];
        }

        return $prm;
    }

}

// Add main menu classes
add_filter('wp_nav_menu_objects', 'themerex_nav_menu_classes', 10, 2);
if (!function_exists('themerex_nav_menu_classes')) {

    function themerex_nav_menu_classes($items, $args) {
        if (is_admin())
            return $items;
        if ($args->menu_id == 'mainmenu' && get_theme_option('menu_colored') == 'yes') {
            foreach ($items as $k => $item) {
                if ($item->menu_item_parent == 0) {
                    if ($item->type == 'taxonomy' && $item->object == 'category') {
                        $cur_theme = get_category_inherited_property($item->object_id, 'blog_theme');
                        if (!empty($cur_theme) && !is_inherit_option($cur_theme))
                            $items[$k]->classes[] = 'theme_' . $cur_theme;
                    }
                }
            }
        }
        return $items;
    }

}

// Add theme-specific vars to post_data
add_filter('themerex_get_post_data', 'themerex_get_post_data', 10, 3);
if (!function_exists('themerex_get_post_data')) {

    function themerex_get_post_data($post_data, $opt, $post_obj) {
        $post_data['post_accent_color'] = $opt['parent_cat_id'] > 0 ? (empty($opt['accent_color']) ? get_category_inherited_property($opt['parent_cat_id'], 'theme_accent_color') : $opt['accent_color']) : '';
        if ($post_data['post_accent_color'] == '') {
            $ex_cats = explode(',', get_theme_option('exclude_cats'));
            for ($i = 0; $i < count($post_data['post_categories_list']); $i++) {
                if (in_array($post_data['post_categories_list'][$i]['term_id'], $ex_cats))
                    continue;
                if (get_theme_option('close_category') == 'parental') {
                    $parent_cat = getParentCategory($post_data['post_categories_list'][$i]['term_id'], $opt['parent_cat_id']);
                    if ($parent_cat) {
                        $post_data['post_accent_color'] = get_category_inherited_property($parent_cat['term_id'], 'theme_accent_color');
                    }
                } else {
                    $post_data['post_accent_color'] = get_category_inherited_property($post_categories_list[$i]['term_id'], 'theme_accent_color');
                }
                if ($post_data['post_accent_color'] != '')
                    break;
            }
        }
        return $post_data;
    }

}





/* ========================= AJAX queries section ============================== */


// Clear Wordpress cache
if (!function_exists('themerex_callback_clear_cache')) {

    function themerex_callback_clear_cache() {
        global $_REQUEST;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'ajax_nonce'))
            die();

        $response = array('error' => '');

        themerex_clear_cache('all');

        echo json_encode($response);
        die();
    }

}

// Save e-mail in subscribe list
add_action('wp_ajax_emailer_submit', 'themerex_callback_emailer_submit');
add_action('wp_ajax_nopriv_emailer_submit', 'themerex_callback_emailer_submit');
if (!function_exists('themerex_callback_emailer_submit')) {

    function themerex_callback_emailer_submit() {
        global $_REQUEST;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'ajax_nonce'))
            die();

        $response = array('error' => '');

        $group = $_REQUEST['group'];
        $email = $_REQUEST['email'];

        if (preg_match('/[\.\-_A-Za-z0-9]+?@[\.\-A-Za-z0-9]+?[\ .A-Za-z0-9]{2,}/', $email)) {
            $subscribers = get_option('emailer_subscribers', array());
            if (!is_array($subscribers))
                $subscribers = array();
            if (!isset($subscribers[$group]) || !is_array($subscribers[$group]))
                $subscribers[$group] = array();
            if (in_array($email, $subscribers[$group]))
                $response['error'] = __('E-mail address already in the subscribers list!', 'themerex');
            else {
                $subscribers[$group][] = $email;
                update_option('emailer_subscribers', $subscribers);
            }
        } else
            $response['error'] = __('E-mail address is not valid!', 'themerex');
        echo json_encode($response);
        die();
    }

}


// Get subscribers list if group changed
add_action('wp_ajax_emailer_group_getlist', 'themerex_callback_emailer_group_getlist');
add_action('wp_ajax_nopriv_emailer_group_getlist', 'themerex_callback_emailer_group_getlist');
if (!function_exists('themerex_callback_emailer_group_getlist')) {

    function themerex_callback_emailer_group_getlist() {
        global $_REQUEST;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'ajax_nonce'))
            die();

        $response = array('error' => '', 'subscribers' => '');

        $group = $_REQUEST['group'];
        $subscribers = get_option('emailer_subscribers', array());
        if (!is_array($subscribers))
            $subscribers = array();
        if (!isset($subscribers[$group]) || !is_array($subscribers[$group]))
            $subscribers[$group] = array();
        $response['subscribers'] = join("\n", $subscribers[$group]);

        echo json_encode($response);
        die();
    }

}


// Set post likes/views count
add_action('wp_ajax_post_counter', 'themerex_callback_post_counter');
add_action('wp_ajax_nopriv_post_counter', 'themerex_callback_post_counter');
if (!function_exists('themerex_callback_post_counter')) {

    function themerex_callback_post_counter() {
        global $_REQUEST;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'ajax_nonce'))
            die();

        $response = array('error' => '');

        $id = (int) $_REQUEST['post_id'];
        if (isset($_REQUEST['likes'])) {
            $counter = max(0, (int) $_REQUEST['likes']);
            setPostLikes($id, $counter);
        } else if (isset($_REQUEST['views'])) {
            $counter = max(0, (int) $_REQUEST['views']);
            setPostViews($id, $counter);
        }
        echo json_encode($response);
        die();
    }

}

// Get attachment url
add_action('wp_ajax_get_attachment_url', 'themerex_callback_get_attachment_url');
add_action('wp_ajax_nopriv_get_attachment_url', 'themerex_callback_get_attachment_url');
if (!function_exists('themerex_callback_get_attachment_url')) {

    function themerex_callback_get_attachment_url() {
        global $_REQUEST;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'ajax_nonce'))
            die();

        $response = array('error' => '');

        $id = (int) $_REQUEST['attachment_id'];

        $response['data'] = wp_get_attachment_url($id);

        echo json_encode($response);
        die();
    }

}

// Send contact form data
add_action('wp_ajax_send_contact_form', 'themerex_callback_send_contact_form');
add_action('wp_ajax_nopriv_send_contact_form', 'themerex_callback_send_contact_form');
if (!function_exists('themerex_callback_send_contact_form')) {

    function themerex_callback_send_contact_form() {
        global $_REQUEST;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'ajax_nonce'))
            die();

        $response = array('error' => '');

        $user_name = themerex_substr($_REQUEST['user_name'], 0, 20);
        $user_email = themerex_substr($_REQUEST['user_email'], 0, 60);
        $user_msg = getShortString($_REQUEST['user_msg'], 300);

        if (!($contact_email = get_theme_option('contact_email')) && !($contact_email = get_theme_option('admin_email')))
            $response['error'] = __('Unknown admin email!', 'themerex');
        else {
            $subj = sprintf(__('Site %s - Contact form message from %s', 'themerex'), get_bloginfo('site_name'), $user_name);
            $msg = "
" . __('Name:', 'themerex') . " $user_name
" . __('E-mail:', 'themerex') . " $user_email
	
" . __('Message:', 'themerex') . " $user_msg
	
............ " . get_bloginfo('site_name') . " (" . home_url() . ") ............";

            /* 	
              $head = "Content-Type: text/plain; charset=\"utf-8\"\n"
              . "X-Mailer: PHP/" . phpversion() . "\n"
              . "Reply-To: $user_email\n"
              . "To: $contact_email\n"
              . "From: $user_email\n"
              . "Subject: $subj\n";
             */

            if (!@wp_mail($contact_email, $subj, $msg)) { //, $head
                $response['error'] = __('Error send message!', 'themerex');
            }

            echo json_encode($response);
            die();
        }
    }

}


// New user registration
add_action('wp_ajax_registration_user', 'themerex_callback_registration_user');
add_action('wp_ajax_nopriv_registration_user', 'themerex_callback_registration_user');
if (!function_exists('themerex_callback_registration_user')) {

    function themerex_callback_registration_user() {
        global $_REQUEST;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'ajax_nonce')) {
            die();
        }

        $user_name = themerex_substr($_REQUEST['user_name'], 0, 20);
        $user_email = themerex_substr($_REQUEST['user_email'], 0, 60);
        $user_pwd = themerex_substr($_REQUEST['user_pwd'], 0, 20);

        $response = array('error' => '');

        $id = wp_insert_user(array('user_login' => $user_name, 'user_pass' => $user_pwd, 'user_email' => $user_email));
        if (is_wp_error($id)) {
            $response['error'] = $id->get_error_message();
        } else if (get_theme_option('notify_about_new_registration') == 'yes' && (($contact_email = get_theme_option('contact_email')) || ($contact_email = get_theme_option('admin_email')))) {
            $subj = sprintf(__('Site %s - New user registration: %s', 'themerex'), get_bloginfo('site_name'), $user_name);
            $msg = "
	" . __('New registration:', 'themerex') . "
	" . __('Name:', 'themerex') . " $user_name
	" . __('E-mail:', 'themerex') . " $user_email
	
	............ " . get_bloginfo('site_name') . " (" . home_url() . ") ............";

            $head = "Content-Type: text/plain; charset=\"utf-8\"\n"
                    . "X-Mailer: PHP/" . phpversion() . "\n"
                    . "Reply-To: $user_email\n"
                    . "To: $contact_email\n"
                    . "From: $user_email\n"
                    . "Subject: $subj\n";

            @wp_mail($contact_email, $subj, $msg, $head);
        }

        echo json_encode($response);
        die();
    }

}

// Get next page on blog streampage
add_action('wp_ajax_view_more_posts', 'themerex_callback_view_more_posts');
add_action('wp_ajax_nopriv_view_more_posts', 'themerex_callback_view_more_posts');
if (!function_exists('themerex_callback_view_more_posts')) {

    function themerex_callback_view_more_posts() {
        global $_REQUEST, $post, $wp_query;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'ajax_nonce'))
            die();

        $response = array('error' => '', 'data' => '', 'no_more_data' => 0);

        $page = $_REQUEST['page'];
        $args = unserialize(stripslashes($_REQUEST['data']));
        $vars = unserialize(stripslashes($_REQUEST['vars']));

        if ($page > 0 && is_array($args) && is_array($vars)) {
            extract($vars);
            $args['page'] = $page;
            $args['paged'] = $page;
            $args['ignore_sticky_posts'] = 1;
            if (!isset($wp_query))
                $wp_query = new WP_Query($args);
            else
                query_posts($args);
            $per_page = count($wp_query->posts);
            $response['no_more_data'] = $page >= $wp_query->max_num_pages; //$per_page < $ppp;
            $post_number = 0;
            $accent_color = '';
            $response['data'] = '';
            while (have_posts()) {
                the_post();
                $post_number++;
                $post_data = getPostData(
                        array(
                            'thumb_size' => $blog_style,
                            'parent_cat_id' => $parent_cat_id,
                            'sidebar' => !in_array($show_sidebar_main, array('none', 'fullwidth')),
                            'accent_color' => $accent_color
                        )
                );
                $accent_color = $post_data['post_accent_color'];
                $response['data'] .= showPostLayout(
                        array(
                    'layout' => $blog_style,
                    'show' => false,
                    'number' => $post_number,
                    'add_view_more' => true,
                    'posts_on_page' => $per_page
                        ), $post_data
                );
            }
        } else {
            $response['error'] = __('Wrong query arguments', 'themerex');
        }

        echo json_encode($response);
        die();
    }

}


/* ========================= Isotope ajax load content ============================== */

// Get next page on blog streampage
add_action('wp_ajax_isotope_content', 'themerex_isotope_content');
add_action('wp_ajax_nopriv_isotope_content', 'themerex_isotope_content');
if (!function_exists('themerex_isotope_content')) {

    function themerex_isotope_content() {
        global $_REQUEST; //, $post, $wp_query;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'ajax_nonce'))
            die();

        $response = array('data' => '');
        $postID = stripslashes($_REQUEST['postID']);
        $get_post_content = get_post($postID);

        $post_layout = showPostLayout(
                array(
            'layout' => 'excerpt',
            'layout_isotope' => true,
            'thumb_size' => 'image_large',
            'thumb_crop' => true,
            'sidebar' => false,
            'show' => false
                ), null, $get_post_content
        );

        if ($get_post_content != '') {
            $response['data'] = $post_layout;
        } else {
            $response['data'] = do_shortcode('[trx_infobox style="error" closeable="no"  title="' . __('Error', 'themerex') . '" bottom="40" top="40"]' . __('Content upload error occured', 'themerex') . '[/trx_infobox]');
        }



        echo json_encode($response);
        die();
    }

}


/* ========================= Taxonomies cache ============================== */
// Clear all cache (when save or delete post)
if (!function_exists('themerex_clear_cache_all')) {

    function themerex_clear_cache_all($post_id = 0, $post_obj = null) {
        delete_transient("themerex_terms_filter_category");
        delete_transient("themerex_terms_filter_post_tag");
        delete_transient("themerex_terms_filter_post_format");
    }

}

// Clear categories cache (when create, edit or delete category)
if (!function_exists('themerex_clear_cache_categories')) {

    function themerex_clear_cache_categories($term_id = 0) {
        delete_transient("themerex_terms_filter_category");
    }

}




/* ========================= Frontend Editor ============================== */

// Save post data from frontend editor
add_action('wp_ajax_frontend_editor_save', 'themerex_callback_frontend_editor_save');
add_action('wp_ajax_nopriv_frontend_editor_save', 'themerex_callback_frontend_editor_save');
if (!function_exists('themerex_callback_frontend_editor_save')) {

    function themerex_callback_frontend_editor_save() {
        global $_REQUEST;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'themerex_editor_nonce'))
            die();

        $response = array('error' => '');

        parse_str($_REQUEST['data'], $output);
        $post_id = $output['frontend_editor_post_id'];

        if (get_theme_option("allow_editor") == 'yes' && (current_user_can('edit_posts', $post_id) || current_user_can('edit_pages', $post_id))) {
            if ($post_id > 0) {
                $title = stripslashes($output['frontend_editor_post_title']);
                $content = stripslashes($output['frontend_editor_post_content']);
                $excerpt = stripslashes($output['frontend_editor_post_excerpt']);
                $rez = wp_update_post(array(
                    'ID' => $post_id,
                    'post_content' => $content,
                    'post_excerpt' => $excerpt,
                    'post_title' => $title
                ));
                if ($rez == 0)
                    $response['error'] = __('Post update error!', 'themerex');
            } else {
                $response['error'] = __('Post update error!', 'themerex');
            }
        } else
            $response['error'] = __('Post update denied!', 'themerex');

        echo json_encode($response);
        die();
    }

}

// Delete post from frontend editor
add_action('wp_ajax_frontend_editor_delete', 'themerex_callback_frontend_editor_delete');
add_action('wp_ajax_nopriv_frontend_editor_delete', 'themerex_callback_frontend_editor_delete');
if (!function_exists('themerex_callback_frontend_editor_delete')) {

    function themerex_callback_frontend_editor_delete() {
        global $_REQUEST;

        if (!wp_verify_nonce($_REQUEST['nonce'], 'themerex_editor_nonce'))
            die();

        $response = array('error' => '');

        $post_id = $_REQUEST['post_id'];

        if (get_theme_option("allow_editor") == 'yes' && (current_user_can('delete_posts', $post_id) || current_user_can('delete_pages', $post_id))) {
            if ($post_id > 0) {
                $rez = wp_delete_post($post_id);
                if ($rez === false)
                    $response['error'] = __('Post delete error!', 'themerex');
            } else {
                $response['error'] = __('Post delete error!', 'themerex');
            }
        } else
            $response['error'] = __('Post delete denied!', 'themerex');

        echo json_encode($response);
        die();
    }

}



/* ========================= Frontend function ============================== */

//post info 
require(get_template_directory() . '/templates/page-part-postinfo.php');

/* ========================= Custom lists (sidebars, styles, etc) ============================== */


// Return list of categories
if (!function_exists('getCategoriesList')) {

    function getCategoriesList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $args = array(
            'type' => 'post',
            'child_of' => 0,
            'parent' => '',
            'orderby' => 'name',
            'order' => 'ASC',
            'hide_empty' => 0,
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'number' => '',
            'taxonomy' => 'category',
            'pad_counts' => false);
        $categories = get_categories($args);
        foreach ($categories as $cat) {
            $list[$cat->term_id] = $cat->name;
        }
        return $list;
    }

}


// Return list of registered users
if (!function_exists('getUsersList')) {

    function getUsersList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $args = array(
            'orderby' => 'display_name',
            'order' => 'ASC');
        $users = get_users($args);
        foreach ($users as $user) {
            $list[$user->user_login] = $user->display_name;
        }
        return $list;
    }

}

// Return sliders list, prepended inherit and main sidebars item (if need)
if (!function_exists('getSlidersList')) {

    function getSlidersList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["swiper"] = __("Swiper slider", 'themerex');
        if (revslider_exists())
            $list["revo"] = __("Revolution slider", 'themerex');
        if (royalslider_exists())
            $list["royal"] = __("Royal slider", 'themerex');
        return $list;
    }

}


// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if (!function_exists('getSidebarsList')) {

    function getSidebarsList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list['sidebar-top'] = __("Top sidebar", 'themerex');
        $list['sidebar-main'] = __("Main sidebar", 'themerex');
        $list['sidebar-footer'] = __("Footer sidebar", 'themerex');
        $sidebars = get_theme_option('custom_sidebars');
        if (is_array($sidebars) && count($sidebars) > 0) {
            foreach ($sidebars as $i => $sb) {
                if (trim(chop($sb)) == '')
                    continue;
                $list['custom-sidebar-' . $i] = $sb;
            }
        }
        return $list;
    }

}


// Return sidebars positions
if (!function_exists('getSidebarsPositions')) {

    function getSidebarsPositions($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list['sideBarLeft'] = get_template_directory_uri() . '/admin/images/icons/sidebar_left.png';
        $list['fullWidth'] = get_template_directory_uri() . '/admin/images/icons/sidebar_none.png';
        $list['sideBarRight'] = get_template_directory_uri() . '/admin/images/icons/sidebar_right.png';
        return $list;
    }

}


// Return body styles list, prepended inherit
if (!function_exists('getBodyStylesList')) {

    function getBodyStylesList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list['boxed'] = get_template_directory_uri() . '/admin/images/icons/boxed.png';
        $list['wide'] = get_template_directory_uri() . '/admin/images/icons/wide.png';
        $list['fullWide'] = get_template_directory_uri() . '/admin/images/icons/fullwide.png';
        //$list['fullscreen'] = get_template_directory_uri().'/admin/images/icons/fullscreen.png';
        return $list;
    }

}

// Return blog styles list, prepended inherit
if (!function_exists('getBlogStylesList')) {

    function getBlogStylesList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list['excerpt_style1'] = get_template_directory_uri() . '/admin/images/icons/layout_s1.png';
        $list['excerpt_style2'] = get_template_directory_uri() . '/admin/images/icons/layout_s2.png';
        $list['excerpt_style3'] = get_template_directory_uri() . '/admin/images/icons/layout_s3.png';
        $list['portfolio_mini'] = get_template_directory_uri() . '/admin/images/icons/cub_mini.png';
        $list['portfolio_medium'] = get_template_directory_uri() . '/admin/images/icons/cub_medium.png';
        $list['portfolio_big'] = get_template_directory_uri() . '/admin/images/icons/cub_big.png';
        return $list;
    }

}

// Return blogger styles list, prepended inherit
if (!function_exists('getBloggerStylesList')) {

    function getBloggerStylesList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list['regular'] = __('Regular', 'themerex');
        $list['excerpt'] = __('Excerpt', 'themerex');
        $list['related'] = __('Related', 'themerex');
        $list['date'] = __('Date', 'themerex');
        $list['image_large'] = __('Large featured image', 'themerex');
        $list['image_medium'] = __('Medium featured image', 'themerex');
        $list['image_small'] = __('Small featured image', 'themerex');
        $list['image_tiny'] = __('Tiny featured image', 'themerex');
        $list['accordion_1'] = __('Accordion style 1', 'themerex');
        $list['accordion_2'] = __('Accordion style 2', 'themerex');
        $list['accordion_3'] = __('Accordion style 3', 'themerex');
        $list['portfolio_mini'] = __('Portfolio style small', 'themerex');
        $list['portfolio_medium'] = __('Portfolio style medium', 'themerex');
        $list['portfolio_big'] = __('Portfolio style large', 'themerex');
        $list['list'] = __('List', 'themerex');
        return $list;
    }

}

// Return portfolio filters list, prepended inherit
if (!function_exists('getPortfolioFiltersList')) {

    function getPortfolioFiltersList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["no"] = __('No filters', 'themerex');
        $list["tags"] = __('Tags', 'themerex');
        $list["categories"] = __('Categories', 'themerex');
        return $list;
    }

}



// Return 
if (!function_exists('getInfoSet')) {

    function getInfoSet($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list['comments'] = __('Comments', 'themerex');
        $list['category'] = __('Categories', 'themerex');
        $list['author'] = __('Author', 'themerex');
        $list['date'] = __('Date', 'themerex');
        $list['tags'] = __('Tags', 'themerex');
        $list['views'] = __('Views', 'themerex');
        $list['review'] = __('Reviews', 'themerex');
        $list['sticky'] = __('Sticky', 'themerex');
        $list['br1'] = __(' | ', 'themerex');
        $list['editor'] = __('Editor', 'themerex');
        $list['br2'] = __(' | ', 'themerex');
        return $list;
    }

}


// Return Google map styles
if (!function_exists('getGooglemapStyles')) {

    function getGooglemapStyles($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list['default'] = __('Default', 'themerex');
        $list['royal'] = __('Royal', 'themerex');
        $list['simple'] = __('Simple', 'themerex');
        $list['greyscale1'] = __('Greyscale 1', 'themerex');
        $list['greyscale2'] = __('Greyscale 2', 'themerex');
        $list['style1'] = __('Custom style 1', 'themerex');
        $list['style2'] = __('Custom style 2', 'themerex');
        $list['style3'] = __('Custom style 3', 'themerex');
        return $list;
    }

}

// Return Google map styles
if (!function_exists('getBoxStyles')) {

    function getBoxStyles($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list['none'] = __('None', 'themerex');
        $list['circle'] = __('Round', 'themerex');
        $list['square'] = __('Square', 'themerex');
        return $list;
    }

}


// Return themes list
if (!function_exists('getThemesList')) {

    function getThemesList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $dir = get_template_directory() . "/css/themes";
        if (is_dir($dir)) {
            $hdir = @ opendir($dir);
            if ($hdir) {
                while (($file = readdir($hdir) ) !== false) {
                    $pi = pathinfo($dir . '/' . $file);
                    if (substr($file, 0, 1) == '.' || is_dir($dir . '/' . $file) || $pi['extension'] != 'css')
                        continue;
                    $key = themerex_substr($file, 0, themerex_strrpos($file, '.'));
                    $list[$key] = themerex_strtoproper(str_replace('_', ' ', $key));
                }
                @closedir($hdir);
            }
        }
        return $list;
    }

}

// Return iconed classes list
if (!function_exists('getIconsList')) {

    function getIconsList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        return array_merge($list, parseIconsClasses(get_template_directory() . "/includes/fontello/css/fontello-codes.css"));
    }

}

// Return socials list
if (!function_exists('getSocialsList')) {

    function getSocialsList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        return array_merge($list, getListFiles("/images/socials", "png"));
    }

}

// Return flags list
if (!function_exists('getFlagsList')) {

    function getFlagsList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        return array_merge($list, getListFiles("/images/flags", "png"));
    }

}

// Return list with 'Yes' and 'No' items
if (!function_exists('getYesNoList')) {

    function getYesNoList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["yes"] = __("Yes", 'themerex');
        $list["no"] = __("No", 'themerex');
        return $list;
    }

}

// Return list with 'On' and 'Of' items
if (!function_exists('getOnOffList')) {

    function getOnOffList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["on"] = __("On", 'themerex');
        $list["off"] = __("Off", 'themerex');
        return $list;
    }

}

// Return list with 'Show' and 'Hide' items
if (!function_exists('getShowHideList')) {

    function getShowHideList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["show"] = __("Show", 'themerex');
        $list["hide"] = __("Hide", 'themerex');
        return $list;
    }

}

// Return list with 'Ascending' and 'Descending' items
if (!function_exists('getOrderingList')) {

    function getOrderingList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["asc"] = __("Ascending", 'themerex');
        $list["desc"] = __("Descending", 'themerex');
        return $list;
    }

}

// Return list with 'Horizontal' and 'Vertical' items
if (!function_exists('getDirectionList')) {

    function getDirectionList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["horizontal"] = __("Horizontal", 'themerex');
        $list["vertical"] = __("Vertical", 'themerex');
        return $list;
    }

}

// Return list with float items
if (!function_exists('getFloatList')) {

    function getFloatList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["none"] = __("None", 'themerex');
        $list["left"] = __("Float Left", 'themerex');
        $list["right"] = __("Float Right", 'themerex');
        return $list;
    }

}

// Return list with float items
if (!function_exists('getAlignList')) {

    function getAlignList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["left"] = __("Left", 'themerex');
        $list["center"] = __("Center", 'themerex');
        $list["right"] = __("Right", 'themerex');
        $list["justify"] = __("Justify ", 'themerex');
        return $list;
    }

}

// Return list with alignment items
if (!function_exists('getAlignmentList')) {

    function getAlignmentList($justify = false, $prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["none"] = __("None", 'themerex');
        $list["left"] = __("Left", 'themerex');
        $list["center"] = __("Center", 'themerex');
        $list["right"] = __("Right", 'themerex');
        if ($justify)
            $list["justify"] = __("Justify", 'themerex');
        return $list;
    }

}

// Return sorting list items
if (!function_exists('getSortingList')) {

    function getSortingList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["date"] = __("Date", 'themerex');
        $list["title"] = __("Alphabetically", 'themerex');
        $list["views"] = __("Popular (views count)", 'themerex');
        $list["comments"] = __("Most commented (comments count)", 'themerex');
        $list["author_rating"] = __("Author rating", 'themerex');
        $list["users_rating"] = __("Visitors (users) rating", 'themerex');
        $list["random"] = __("Random", 'themerex');
        return $list;
    }

}

// Return list with columns widths
if (!function_exists('getColumnsList')) {

    function getColumnsList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["none"] = __("None", 'themerex');
        $list["1_1"] = __("100%", 'themerex');
        $list["1_2"] = __("1/2", 'themerex');
        $list["1_3"] = __("1/3", 'themerex');
        $list["1_4"] = __("1/4", 'themerex');
        $list["1_5"] = __("1/5", 'themerex');
        $list["1_6"] = __("1/6", 'themerex');
        $list["2_3"] = __("2/3", 'themerex');
        $list["2_4"] = __("2/4", 'themerex');
        $list["3_4"] = __("3/4", 'themerex');
        $list["2_5"] = __("2/5", 'themerex');
        $list["3_5"] = __("3/5", 'themerex');
        $list["4_5"] = __("4/5", 'themerex');
        return $list;
    }

}

// Return list of locations for the dedicated content
if (!function_exists('getDedicatedLocationsList')) {

    function getDedicatedLocationsList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["default"] = __('As in the post defined', 'themerex');
        $list["center"] = __('Above the text of the post', 'themerex');
        $list["left"] = __('To the left the text of the post', 'themerex');
        $list["right"] = __('To the right the text of the post', 'themerex');
        $list["alter"] = __('Alternates for each post', 'themerex');
        return $list;
    }

}

// Return list of locations for the dedicated content
if (!function_exists('getContactInfo')) {

    function getContactInfo($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["address_1"] = __('Adress 1', 'themerex');
        $list["address_2"] = __('Adress 2', 'themerex');
        $list["phone_1"] = __('Phone 1', 'themerex');
        $list["phone_2"] = __('Phone 2', 'themerex');
        $list["fax"] = __('Fax', 'themerex');
        $list["website"] = __('Web site', 'themerex');
        $list["email"] = __('Email', 'themerex');
        return $list;
    }

}

// Return post-format name
if (!function_exists('getPostFormatName')) {

    function getPostFormatName($format, $single = true) {
        $name = '';
        if ($format == 'gallery')
            $name = $single ? __('gallery', 'themerex') : __('galleries', 'themerex');
        else if ($format == 'video')
            $name = $single ? __('video', 'themerex') : __('videos', 'themerex');
        else if ($format == 'audio')
            $name = $single ? __('audio', 'themerex') : __('audios', 'themerex');
        else if ($format == 'image')
            $name = $single ? __('image', 'themerex') : __('images', 'themerex');
        else if ($format == 'quote')
            $name = $single ? __('quote', 'themerex') : __('quotes', 'themerex');
        else if ($format == 'link')
            $name = $single ? __('link', 'themerex') : __('links', 'themerex');
        else if ($format == 'status')
            $name = $single ? __('status', 'themerex') : __('statuses', 'themerex');
        else if ($format == 'aside')
            $name = $single ? __('aside', 'themerex') : __('asides', 'themerex');
        else if ($format == 'chat')
            $name = $single ? __('chat', 'themerex') : __('chats', 'themerex');
        else
            $name = $single ? __('standard', 'themerex') : __('standards', 'themerex');
        return $name;
    }

}

// Return post-format icon name (from Fontello library)
if (!function_exists('getPostFormatIcon')) {

    function getPostFormatIcon($format = '') {
        $format_array = array(
            'standard' => 'post2',
            'gallery' => 'gallery2',
            'video' => 'video2',
            'audio' => 'audio2',
            'image' => 'image2',
            'quote' => 'quote2',
            'link' => 'link2',
            'status' => 'flag2',
            'aside' => 'aside2',
            'chat' => 'chat2');
        return $format ? 'icon-' . $format_array[$format] : 'icon-post';
    }

}

// Return Google fonts list
if (!function_exists('getThemeFontsList')) {

    function getThemeFontsList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        //$list['Advent Pro'] = array('family'=>'sans-serif', 'link'=>'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic');
        $list['Advent Pro'] = array('family' => 'sans-serif');
        $list['Arimo'] = array('family' => 'sans-serif');
        $list['Asap'] = array('family' => 'sans-serif');
        $list['Averia Sans Libre'] = array('family' => 'cursive');
        $list['Averia Serif Libre'] = array('family' => 'cursive');
        $list['Cabin'] = array('family' => 'sans-serif', 'link' => 'Cabin:700');
        $list['Cabin Condensed'] = array('family' => 'sans-serif');
        $list['Caudex'] = array('family' => 'serif');
        $list['Comfortaa'] = array('family' => 'cursive');
        $list['Cousine'] = array('family' => 'sans-serif');
        $list['Crimson Text'] = array('family' => 'serif');
        $list['Cuprum'] = array('family' => 'sans-serif');
        $list['Dosis'] = array('family' => 'sans-serif');
        $list['Economica'] = array('family' => 'sans-serif');
        $list['Exo'] = array('family' => 'sans-serif');
        $list['Expletus Sans'] = array('family' => 'cursive');
        $list['Karla'] = array('family' => 'sans-serif');
        $list['Lato'] = array('family' => 'sans-serif');
        $list['Laila'] = array('family' => 'sans-serif', 'link' => 'Laila:400,300,500,600,700');
        $list['Lekton'] = array('family' => 'sans-serif');
        $list['Lobster Two'] = array('family' => 'cursive');
        $list['Maven Pro'] = array('family' => 'sans-serif');
        $list['Merriweather'] = array('family' => 'serif');
        $list['Neuton'] = array('family' => 'serif');
        $list['Noticia Text'] = array('family' => 'serif');
        $list['Old Standard TT'] = array('family' => 'serif');
        $list['Open Sans'] = array('family' => 'sans-serif');
        $list['Source Sans Pro'] = array('family' => 'sans-serif');
        $list['Orbitron'] = array('family' => 'sans-serif');
        $list['Oswald'] = array('family' => 'sans-serif');
        $list['Overlock'] = array('family' => 'cursive');
        $list['Oxygen'] = array('family' => 'sans-serif', 'link' => 'Oxygen:400,700');
        $list['PT Serif'] = array('family' => 'serif');
        $list['Puritan'] = array('family' => 'sans-serif');
        $list['Raleway'] = array('family' => 'sans-serif');
        $list['Roboto'] = array('family' => 'sans-serif');
        $list['Roboto Condensed'] = array('family' => 'sans-serif');
        $list['Ruda'] = array('family' => 'sans-serif', 'link' => 'Ruda:400,700,900');
        $list['Rosario'] = array('family' => 'sans-serif');
        $list['Share'] = array('family' => 'cursive');
        $list['Signika Negative'] = array('family' => 'sans-serif');
        $list['Tinos'] = array('family' => 'serif');
        $list['Ubuntu'] = array('family' => 'sans-serif');
        $list['Vollkorn'] = array('family' => 'serif');
        $list['ProximaNova'] = array('family' => 'proximaNova','ext'=>true);
        $list['ProximaNovaAlt'] = array('family' => 'proximaNovaAlt','ext'=>true);
        return $list;
    }

}

// Return to the list of styles for fonts
if (!function_exists('getFontsStyleList')) {

    function getFontsStyleList($prepend_inherit = false) {
        $list = array();
        if ($prepend_inherit)
            $list['inherit'] = __("Inherit", 'themerex');
        $list["100"] = __('100', 'themerex');
        $list["300"] = __('300', 'themerex');
        $list["400"] = __('400', 'themerex');
        $list["500"] = __('500', 'themerex');
        $list["700"] = __('700', 'themerex');
        $list["900"] = __('900', 'themerex');
        return $list;
    }

}






/* ========================= Theme setup section ============================== */


/**
 * Theme image dimensions
 */
// 16:9
add_image_size('fullpost', 1150, 647, true);
add_image_size('excerpt', 714, 402, true);
add_image_size('classic3', 400, 225, true);
add_image_size('classic4', 250, 141, true);
// Non 16:9
add_image_size('portfolio3', 383, 245, true);
add_image_size('portfolio4', 287, 287, true);

/**
 * Init theme template - prepare global variables
 */
function themerex_init_template() {
    // AJAX Queries settings
    global $THEMEREX_ajax_nonce, $THEMEREX_ajax_url;
    $THEMEREX_ajax_nonce = wp_create_nonce('ajax_nonce');
    $THEMEREX_ajax_url = admin_url('admin-ajax.php');

    // Get custom options from current category / page / post / shop
    load_custom_options();

    // Reject old browsers support
    global $THEMEREX_jreject;
    $THEMEREX_jreject = false;
    if (!isset($_COOKIE['jreject'])) {
        themerex_enqueue_style('jquery_reject-style', get_template_directory_uri() . '/js/jreject/css/jquery.reject.css', array(), null);
        themerex_enqueue_script('jquery_reject', get_template_directory_uri() . '/js/jreject/jquery.reject.js', array('jquery'), null, true);
        setcookie('jreject', 1, 0, '/');
        $THEMEREX_jreject = true;
    }

    // Main menu
    global $THEMEREX_mainmenu, $THEMEREX_mainmenu_right;
    $THEMEREX_mainmenu = wp_nav_menu(array(
        'menu' => '',
        'container' => '',
        'container_class' => '',
        'container_id' => '',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'menu_class' => '',
        'menu_id' => 'mainmenu',
        'echo' => false,
        'fallback_cb' => '',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 11,
        'theme_location' => 'mainmenu'
    ));

    $THEMEREX_mainmenu_right = wp_nav_menu(array(
        'menu' => '',
        'container' => '',
        'container_class' => '',
        'container_id' => '',
        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'menu_class' => '',
        'menu_id' => 'mainmenu_right',
        'echo' => false,
        'fallback_cb' => '',
        'before' => '',
        'after' => '',
        'link_before' => '',
        'link_after' => '',
        'depth' => 11,
        'theme_location' => 'mainmenu_right'
    ));

    // Logo image
    global $logo_image,
    $logo_footer;
    if (($logo_image = get_theme_option('logo_image')) == '')
        $logo_image = get_template_directory_uri() . '/images/logo.png';
    if (($logo_footer = get_theme_option('logo_footer')) == '')
        $logo_footer = get_template_directory_uri() . '/images/logo-footer.png';
}

add_action('after_setup_theme', 'themerex_theme_setup');
if (!function_exists('themerex_theme_setup')) {

    function themerex_theme_setup() {
        // Add default posts and comments RSS feed links to head 
        add_theme_support('automatic-feed-links');
        // Enable support for Post Thumbnails
        add_theme_support('post-thumbnails');
        // Custom header setup
        // add_theme_support( 'custom-header', array('header-text'=>false));
        // Custom backgrounds setup
        // add_theme_support( 'custom-background');
        // Supported posts formats
        add_theme_support('post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat'));
        // Add user menu
        add_theme_support('nav-menus');
        if (function_exists('register_nav_menus')) {
            register_nav_menus(
                    array(
                        'mainmenu' => 'Main Menu',
                        'mainmenu_right' => 'Main Menu Right'
                    )
            );
        }
        // WooCommerce Support
        add_theme_support('woocommerce');
        // Editor custom stylesheet - for user
        add_editor_style('admin/css/editor-style.css');
        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain('themerex', (is_dir(get_stylesheet_directory() . '/languages') ? get_stylesheet_directory() : get_template_directory()) . '/languages');
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
                'before_title' => '<h5 class="title">',
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

        themerex_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish.js', array('jquery'), null, true);

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


// Admin actions:
// Enqueue scripts and styles
//add_action('admin_enqueue_scripts', 'themerex_admin_scripts');
// Add categories (taxonomies) filter for custom posts types
add_action('restrict_manage_posts', 'themerex_admin_taxonomy_filter');
// Init TGM Activation Plugin
add_action('tgmpa_register', 'themerex_admin_register_plugins');
// Clear taxonomies cache when save or delete post or category
add_action('save_post', 'themerex_clear_cache_all', 10, 2);
add_action('delete_post', 'themerex_clear_cache_all', 10, 2);
add_action('edit_category', 'themerex_clear_cache_categories', 10, 1);
add_action('create_category', 'themerex_clear_cache_categories', 10, 1);
add_action('delete_category', 'themerex_clear_cache_categories', 10, 1);


// Compose scripts in one file
$THEMEREX_scripts_collector = array('', '');
add_action('wp_print_scripts', 'themerex_compose_scripts', 20);
if (!function_exists('themerex_compose_scripts')) {

    function themerex_compose_scripts() {
        global $wp_scripts, $concatenate_scripts, $THEMEREX_scripts_collector;
        if (is_admin() || get_theme_option('compose_scripts') != 'yes' || !is_object($wp_scripts))
            return;
        //$concatenate_scripts = true;
        $theme_url = get_template_directory_uri();
        foreach ($wp_scripts->queue as $script) {
            if (isset($wp_scripts->registered[$script]) && themerex_strpos($wp_scripts->registered[$script]->src, $theme_url) === 0 && themerex_strpos($wp_scripts->registered[$script]->ver, 'no-compose') === false) {
                if (file_exists($file = get_template_directory() . themerex_substr($wp_scripts->registered[$script]->src, themerex_strlen($theme_url)))) {
                    $THEMEREX_scripts_collector[isset($wp_scripts->registered[$script]->extra['group']) && $wp_scripts->registered[$script]->extra['group'] == 1 ? 1 : 0] .= "\n" . themerex_fgc($file) . "\n";
                    $wp_scripts->done[] = $script;
                }
            }
        }
        if ($THEMEREX_scripts_collector[0]) {
            echo "\n<script type=\"text/javascript\">\n" . $THEMEREX_scripts_collector[0] . "\n</script>\n";
        }
    }

}


// Compose scripts in one file
add_action('wp_print_footer_scripts', 'themerex_footer_scripts', 20);
if (!function_exists('themerex_footer_scripts')) {

    function themerex_footer_scripts() {
        if (is_admin() || get_theme_option('compose_scripts') != 'yes')
            return;
        global $THEMEREX_scripts_collector;
        if ($THEMEREX_scripts_collector[1]) {
            echo "\n<script type=\"text/javascript\">\n" . $THEMEREX_scripts_collector[1] . "\n</script>\n";
        }
    }

}


// Compose styles in one file
$THEMEREX_styles_collector = '';
add_action('wp_print_styles', 'themerex_compose_styles', 20);
if (!function_exists('themerex_compose_styles')) {

    function themerex_compose_styles() {
        global $wp_styles, $concatenate_scripts, $compress_css, $THEMEREX_styles_collector;
        if (is_admin() || get_theme_option('compose_scripts') != 'yes' || !is_object($wp_styles))
            return;
        //$concatenate_scripts = $compress_css = true;
        $theme_url = get_template_directory_uri();
        foreach ($wp_styles->queue as $style) {
            if (isset($wp_styles->registered[$style]) && themerex_strpos($wp_styles->registered[$style]->src, $theme_url) === 0 && themerex_strpos($wp_styles->registered[$style]->ver, 'no-compose') === false) {
                //$dir = dirname(themerex_substr($wp_styles->registered[$style]->src, themerex_strlen($wp_styles->base_url))).'/';
                $dir = dirname($wp_styles->registered[$style]->src) . '/';
                if (file_exists($file = get_template_directory() . themerex_substr($wp_styles->registered[$style]->src, themerex_strlen($theme_url)))) {
                    $css = themerex_fgc($file);
                    if (isset($wp_styles->registered[$style]->extra['after'])) {
                        foreach ($wp_styles->registered[$style]->extra['after'] as $add) {
                            $css .= "\n" . $add . "\n";
                        }
                    }
                    $pos = -1;
                    while (($pos = themerex_strpos($css, 'url(', $pos + 1)) !== false) {
                        if (themerex_substr($css, $pos, 9) == 'url(data:')
                            continue;
                        $shift = 0;
                        if (($ch = themerex_substr($css, $pos + 4, 1)) == '"' || $ch == "'") {
                            $shift = 1;
                        }
                        $css = themerex_substr($css, 0, $pos + 4 + $shift) . $dir . themerex_substr($css, $pos + 4 + $shift);
                    }
                    $THEMEREX_styles_collector .= "\n" . $css . "\n";
                    $wp_styles->done[] = $style;
                }
            }
        }
        if ($THEMEREX_styles_collector) {
            echo "\n<style type=\"text/css\">\n" . $THEMEREX_styles_collector . "\n</style>\n";
        }
    }

}

// Admin side setup
if (is_admin()) {
    add_action('admin_head', 'themerex_admin_setup');
    if (!function_exists('themerex_admin_setup')) {

        function themerex_admin_setup() {
            themerex_enqueue_script('jquery', false, array(), null, true);
            themerex_enqueue_script('jquery-ui-core', false, array('jquery'), null, true);
            themerex_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
            themerex_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js', array('jquery'), null, true);

            themerex_enqueue_style('wp-color-picker', array(), null);
            themerex_enqueue_script('wp-color-picker', false, array(), null, true);

            themerex_enqueue_style('theme-admin-style', get_template_directory_uri() . '/admin/css/admin-style.css', array(), null);
            themerex_enqueue_style('fontello-admin', get_template_directory_uri() . '/admin/css/fontello/css/fontello-admin.css', array(), null);
            themerex_enqueue_style('fontello', get_template_directory_uri() . '/includes/fontello/css/fontello.css', array(), null);

            themerex_enqueue_script('_utils', get_template_directory_uri() . '/js/_utils.js', array(), null, true);
        }

    }

    // Add categories (taxonomies) filter for custom posts types
    add_action('restrict_manage_posts', 'themerex_admin_taxonomy_filter');
    if (!function_exists('themerex_admin_taxonomy_filter')) {

        function themerex_admin_taxonomy_filter() {
            if (get_theme_option('admin_add_filters') != 'yes')
                return;
            $page = get_query_var('post_type');
            if ($page == 'post')
                $taxes = array('post_format', 'post_tag');
            else if ($page == 'attachment')
                $taxes = array('media_folder');
            else
                return;
            echo getTermsFilters($taxes);
        }

    }

    // Register optional plugins
    if (!function_exists('themerex_admin_register_plugins')) {

        function themerex_admin_register_plugins() {

            $plugins = array(
                array(
                    'name' => 'WooCommerce',
                    'slug' => 'woocommerce',
                    'required' => false
                ),
                array(
                    'name' => 'Visual Composer',
                    'slug' => 'js_composer',
                    'source' => themerex_get_file_dir('/plugins/js_composer.zip'),
                    'required' => false
                ),
                array(
                    'name' => 'Revolution Slider',
                    'slug' => 'revslider',
                    'source' => themerex_get_file_dir('/plugins/revslider.zip'),
                    'required' => false
                ),
                array(
                    'name' => 'Booking Calendar WP Plugin',
                    'slug' => 'wp-booking-calendar',
                    'source' => themerex_get_file_dir('/plugins/wp-booking-calendar.zip'),
                    'required' => false
                ),
                array(
                    'name' => 'The Events Calendar',
                    'slug' => 'the-events-calendar',
                    'required' => false
                )
            );
            $theme_text_domain = 'themerex';
            $config = array(
                'domain' => $theme_text_domain, // Text domain - likely want to be the same as your theme.
                'default_path' => '', // Default absolute path to pre-packaged plugins
                'parent_menu_slug' => 'themes.php', // Default parent menu slug
                'parent_url_slug' => 'themes.php', // Default parent URL slug
                'menu' => 'install-required-plugins', // Menu slug
                'has_notices' => true, // Show admin notices or not
                'is_automatic' => true, // Automatically activate plugins after installation or not
                'message' => '', // Message to output right before the plugins table
                'strings' => array(
                    'page_title' => __('Install Required Plugins', 'themerex'),
                    'menu_title' => __('Install Plugins', 'themerex'),
                    'installing' => __('Installing Plugin: %s', 'themerex'), // %1$s = plugin name
                    'oops' => __('Something went wrong with the plugin API.', 'themerex'),
                    'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.'), // %1$s = plugin name(s)
                    'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.'), // %1$s = plugin name(s)
                    'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.'), // %1$s = plugin name(s)
                    'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.'), // %1$s = plugin name(s)
                    'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.'), // %1$s = plugin name(s)
                    'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.'), // %1$s = plugin name(s)
                    'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.'), // %1$s = plugin name(s)
                    'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.'), // %1$s = plugin name(s)
                    'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins'),
                    'activate_link' => _n_noop('Activate installed plugin', 'Activate installed plugins'),
                    'return' => __('Return to Required Plugins Installer', 'themerex'),
                    'plugin_activated' => __('Plugin activated successfully.', 'themerex'),
                    'complete' => __('All plugins installed and activated successfully. %s', 'themerex'), // %1$s = dashboard link
                    'nag_type' => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
                )
            );

            tgmpa($plugins, $config);
        }

    }
}

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require_once( get_template_directory() . '/includes/_debug.php' );

require_once( get_template_directory() . '/includes/_utils.php' );
require_once( get_template_directory() . '/includes/_wp_utils.php' );

require_once( get_template_directory() . '/admin/theme-settings.php' );
if (is_themerex_options_used()) {
    require_once( get_template_directory() . '/admin/theme-options.php' );
}

require_once( get_template_directory() . '/includes/theme-customizer.php' );

require_once( get_template_directory() . '/includes/aq_resizer.php' );

require_once( get_template_directory() . '/admin/includes/type-attachment.php' );
require_once( get_template_directory() . '/admin/includes/type-category.php' );
require_once( get_template_directory() . '/admin/includes/type-post.php' );
require_once( get_template_directory() . '/admin/includes/type-page.php' );
require_once( get_template_directory() . '/admin/includes/type-reviews.php' );
require_once( get_template_directory() . '/admin/includes/type-woocommerce.php' );
require_once( get_template_directory() . '/admin/includes/type-tribe-events.php' );

require_once( get_template_directory() . '/includes/shortcodes/shortcodes.php' );

require_once( get_template_directory() . '/includes/wp-pagenavi.php' );

require_once( get_template_directory() . '/widgets/widget-top10.php' );
require_once( get_template_directory() . '/widgets/widget-popular-posts.php' );
require_once( get_template_directory() . '/widgets/widget-recent-posts.php' );
require_once( get_template_directory() . '/widgets/widget-recent-reviews.php' );
require_once( get_template_directory() . '/widgets/widget-flickr.php' );
require_once( get_template_directory() . '/widgets/widget-twitter2.php' );
require_once( get_template_directory() . '/widgets/widget-advert.php' );
require_once( get_template_directory() . '/widgets/widget-socials.php' );
require_once( get_template_directory() . '/widgets/qrcode/widget-qrcode.php' );


if (is_admin()) {
    if (get_theme_option('admin_update_notifier') == 'yes') {
        require_once( themerex_get_file_dir('/admin/tools/update-notifier.php') );
    }
    if (get_theme_option('admin_emailer') == 'yes') {
        require_once( themerex_get_file_dir('/admin/tools/emailer/emailer.php') );
    }
    if (get_theme_option('admin_po_composer') == 'yes') {
        require_once( themerex_get_file_dir('/admin/tools/po_composer/po_composer.php') );
    }
    if (get_theme_option('admin_dummy_data') == 'yes' && file_exists(themerex_get_file_dir('/admin/tools/importer/importer.php'))) {
        require_once( themerex_get_file_dir('/admin/tools/importer/importer.php') );
    }
    require_once( themerex_get_file_dir('/admin/tools/tgm/class-tgm-plugin-activation.php') );
}


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
    $content_width = get_custom_option('show_sidebar_main') != 'fullWidth' ? 900 : 1150; /* pixels */
}

// Return current site protocol
if (!function_exists('themerex_get_protocol')) {

    function themerex_get_protocol() {
        return is_ssl() ? 'https' : 'http';
    }

}
?>