<?php
/*
  Plugin Name: Artist Gallery
  Plugin URI: #
  Description: This plugin is required for PrintedWine Dashboard features.
  Version: 1.0.0
  Author: Daivat Soni
  Author URI: http://www.daivat.com
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

require_once dirname( __FILE__ ).'/db.php';

class Ds_gallery {
    function Ds_gallery() {
        
        add_action('wp_enqueue_scripts', array(__CLASS__, 'add_scripts_files'));
        add_action('wp_ajax_get_albums', array(__CLASS__, 'listAlbums'));
        add_action('wp_ajax_save_galery', array(__CLASS__, 'save_galery'));
        add_action('wp_ajax_createForm', array(__CLASS__, 'createForm'));
        
        if(is_admin()) {
            register_activation_hook(__FILE__, array(__CLASS__, 'on_plugin_activation'));
        }                
    }
    
    function on_plugin_activation() {
        $sdb1 = new Ds_gallery_db();
        $sdb1->setup_tables();	
    }
    
    function add_scripts_files() {
        wp_enqueue_script('co-scripts', plugins_url('assets/js/script.js', __FILE__), array('jquery'));
    }

    function save_galery() {
        // get current user id
        $user_id = get_current_user_id();
        
        $albumVars = array(
            "user_id"=> $user_id,
            "name" => $_POST['title'],
            "status" => "Inactive"
        );
        
        $db = new Ds_gallery_db();
        $status = $db->add_album($albumVars);

        // at the end stop further execution
        if($status) {
            $result = array("status"=>1, "message"=>"Album created successfully.");
            echo json_encode($result);
        } else {
            $result = array("status"=>0, "message"=>"Sorry, we are unable to create album. Please try again.");
            echo json_encode($result);
        }
        exit;
    }

    function createForm() {
        ob_start();
        ?>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-3">
                    <label>Album Name</label>
                </div>
                <div class="col-lg-6">
                    <input type="text" name="album_name" class="album_name">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-3">
                <div class="row">
                    <button name="submit" id="saveData">Save</button>
                    <button name="cancel" id="cancelAlbum">Cancel</button>
                </div>
            </div>
        </div>
        <?php
        $formHtml = ob_get_clean();
        echo $formHtml;
        exit; //When no return msg than use exit;
    }
    
    // LIST LOGGED IN USERS AVAILABLE ALBUMS
    function listAlbums() {
        $userId = get_current_user_id();
        
        // get all album list by current user id
        $db = new Ds_gallery_db();
        $arrAlbums = $db->return_albums();
        
        if(count($arrAlbums)) {
            // album founds 
            ob_start(); ?>
            <div class="album_list">
                <ul>
                    <?php foreach($arrAlbums as $album) { ?>
                    <li><?php echo $album['name']; ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php    
            $html = ob_get_clean();
            echo $html;
            exit;
        } else {
            // no album available.
            ob_start(); ?>
            <div class="album_list">
                <ul>
                    <li>There is no any album available.</li>
                </ul>
            </div>
        <?php    
            $html = ob_get_clean();
            echo $html;
            exit;            
        }
    }
}

new Ds_gallery();