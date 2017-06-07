<?php
/*
  Plugin Name: Custom Options
  Plugin URI: #
  Description: This plugin is required for PrintedWine Dashboard features.
  Version: 1.0.0
  Author: Daivat Soni
  Author URI: http://www.daivat.com
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

function add_scripts_files() {
//    if( 'index.php' != $hook ) {
//	// Only applies to dashboard panel
//	return;
//    }
    wp_enqueue_script('co-scripts', plugins_url('assets/js/script.js', __FILE__), array('jquery'));
}

add_action('wp_enqueue_scripts', 'add_scripts_files');

add_action('init', 'create_posttype');

function create_posttype() {
    register_post_type('acme_gallery', array(
        'labels' => array(
            'name' => __('Gallery'),
            'singular_name' => __('Gallery')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'gallery'),
        )
    );
}

add_action('wp_ajax_save_galery', 'save_galery');
add_action('wp_ajax_nopriv_save_galery', 'save_galery');

function save_galery() {

    $my_cptpost_args = array(
        'post_title' => $_POST['cptTitle'],
        'post_content' => $_POST['cptContent'],
        'post_status' => 'pending',
        'post_type' => $_POST['post_type']
    );

    echo '124837483478';
    
    // at the end stop further execution
    exit;
}

global $jal_db_version;
$jal_db_version = '1.0';

function create_plugin_database_table() {
    global $table_prefix, $wpdb;

    $tblname = 'album_1';
    $wp_track_table = $table_prefix . "$tblname ";

    #Check to see if the table exists already, if not, then create it

    if ($wpdb->get_var("show tables like '$wp_track_table'") != $wp_track_table) {

        $sql = "CREATE TABLE `" . $wp_track_table . "` ( ";

        $sql .= "  id mediumint(9) NOT NULL AUTO_INCREMENT, ";
        $sql .= "  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL ";
        $sql .= "  album_name tinytext NOT NULL ";
        $sql .= "  album_status tinytext NOT NULL ";
        $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }
}

register_activation_hook(__FILE__, 'create_plugin_database_table');

add_action('wp_ajax_createForm', 'createForm');
add_action('wp_ajax_nopriv_createForm', 'createForm');

function createForm() {
    ?>

        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label>Album Name</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" name="album_name" class="album_name">
                </div>
                <div class="col-lg-2">
                    <input type="hidden" name="user_id" value="<?php echo $memberId; ?>" class="user_id">
    <?php /*
      <input type="hidden" name="user_email" value="<?php echo $current_user->user_email; ?>" class="user_email">
      <input type="hidden" name="user_firstname" value="<?php echo $current_user->user_firstname; ?>" class="user_firstname">
      <input type="hidden" name="user_lastname" value="<?php echo $current_user->user_lastname; ?>" class="user_lastname">
     */ ?>
                </div>
            </div>
        </div>
        <input type="hidden" name="post_type" id="post_type" class="post_type" value="acme_gallery" />

        <div class="form-group">
            <div class="col-lg-3">
                <div class="row">
                    <button name="submit" id="saveData">Save</button>
                </div>
            </div>
        </div>
    <?php //wp_nonce_field( 'cpt_nonce_action', 'cpt_nonce_field' );  ?>		

    <?php
    exit; //When no return msg than use exit;
}
