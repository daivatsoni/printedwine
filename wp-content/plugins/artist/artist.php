<?php
/*
  Plugin Name: Artist Custom
  Plugin URI: #
  Description: This plugin is required for PrintedWine Dashboard features.
  Version: 1.0.0
  Author: Bhumika Trivedi
  Author URI: http://www.daivat.com
 */

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

require_once dirname( __FILE__ ).'/db.php';

class Artist {
    function Artist() {
        
        add_action('wp_enqueue_scripts', array(__CLASS__, 'add_scripts_files'));
        add_action('wp_ajax_save_art', array(__CLASS__, 'save_art'));
        add_action('wp_ajax_save_artist', array(__CLASS__, 'save_artist'));
      //  add_action('wp_ajax_createForm', array(__CLASS__, 'createForm'));
        
        if(is_admin()) {
            register_activation_hook(__FILE__, array(__CLASS__, 'on_plugin_activation'));
        }                
    }
    
    function on_plugin_activation() {
        $sdb1 = new Artist_db();
        $sdb1->setup_tables();	
    }
    
    function add_scripts_files() {
        wp_enqueue_script('art-scripts', plugins_url('assets/js/script.js', __FILE__), array('jquery'));
    }

    function save_artist() {
          
        // get current user id
        $user_id = get_current_user_id();
        $artist_type = implode(",", $_POST['artist_type']);
        $albumVars = array(
            "user_id"=> $user_id,
            "artist_name" => $_POST['artist_name'],
            "artist_country" => $_POST['artist_country'],
            "artist_born_year" => $_POST['artist_born_year'],
            "artist_type" => $artist_type,
            "artist_description" => $_POST['artist_description'],
            "artist_awards" => $_POST['artist_awards'],
            "status" => "Active"
        );
        
     
        $db = new Artist_db();
        $results = $db->get_artist($user_id);
        
        if($results) {
            $status = $db->update_artist($albumVars);
        }else{
            $status = $db->add_artist($albumVars);
        }
        // at the end stop further execution
        if($status) {
            $result = array("status"=>1, "message"=>"Artist created successfully.");
            echo json_encode($result);
        } 
        exit;
    }
    
    function save_art() {
         //echo "<pre>";print_r($_FILES);exit;
        // get current user id
        $user_id = get_current_user_id();
        $uploaddir = get_stylesheet_directory_uri().'/images/arts/'; 
        $file = $uploaddir . basename($_FILES['image']['name']); 
        $raw_file_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($_FILES['image']['tmp_name'], $file)) { 
            echo "success"; 
        } else {
            echo "error";
        }
       // $image_path = get_stylesheet_directory_uri()."/images/arts/blank_photo.jpeg";
        $albumVars = array(
            "user_id"=> $user_id,
            "art_title" => $_POST['art_title'],
            "art_category" => $_POST['art_category'],
            "art_sub_category" => $_POST['art_sub_category'],
            "art_colors" => $_POST['art_colors'],
            "art_year" => $_POST['art_year'],
            "image_path" => $raw_file_name,
            "art_description" => $_POST['art_description'],
            "status" => "Active"
        );
        
     
        $db = new Artist_db();
        
        $status = $db->add_art($albumVars);
        // at the end stop further execution
        if($status) {
            $result = array("status"=>1, "message"=>"Artist created successfully.");
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

new Artist();