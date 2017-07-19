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
        add_action('wp_ajax_get_art', array(__CLASS__, 'get_art'));
        add_action('wp_ajax_save_artist', array(__CLASS__, 'save_artist'));
        add_action('wp_ajax_get_subcategories', array(__CLASS__, 'get_subcategories'));
        add_action('wp_ajax_save_art_update', array(__CLASS__, 'save_art_update'));
        add_action('wp_ajax_get_art_form', array(__CLASS__, 'get_art_form'));  
        add_action('wp_ajax_get_art_get', array(__CLASS__, 'get_art_get'));
        add_action('wp_ajax_set_art_order', array(__CLASS__, 'set_art_order'));
        add_action('wp_ajax_fav_status', array(__CLASS__, 'fav_status'));
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
       
        $upload_dir = wp_upload_dir(); // Relative to the root
        if (!file_exists($upload_dir["basedir"].'/arts/'.$user_id)) {
            mkdir($upload_dir["basedir"].'/arts/'.$user_id, 0777, true);
        }
       // $image_path = get_stylesheet_directory_uri()."/images/arts/blank_photo.jpeg";
        $albumVars = array(
            "user_id"=> $user_id,
            "art_title" => $_POST['art_title'],
            "art_category" => $_POST['art_category'],
            "art_sub_category" => $_POST['art_sub_category'],
            "art_colors" => $_POST['art_colors'],
            "art_year" => $_POST['art_year'],
            "art_description" => $_POST['art_description'],
            "status" => "Active"
        );
        
     
        $db = new Artist_db();
        
        $status = $db->add_art($albumVars);
       // echo "<pre>";print_r($status);exit; 
        //$img_path = $db->update_art_path();
        // at the end stop further execution
        if($status) {
            $img_path = $upload_dir["basedir"].'/arts_tmp/'.$_POST['image_hidden_path'];
            $my_path = $upload_dir["basedir"].'/arts/'.$user_id.'/';
            $str = explode('.',$_POST['image_hidden_path']);
            rename($img_path, $my_path.'/'.$user_id.'_'.$status.'.'.$str[1]);
            unlink($img_path);
            
            $img = $user_id.'_'.$status.'.'.$str[1];
            $img_path = $db->update_art_path($img,$status);
            $result = array("status"=>1, "message"=>"Artist created successfully.");
            echo json_encode($result);
        } 
        exit;
    }
    
    function get_art(){
        $db = new Artist_db();
        
        $status = $db->get_art();
        if($status) {
            //echo "<pre>";print_r($status);exit;
            $result = array("status"=>1, "message"=>$status);
            echo json_encode($result);
        } 
        exit;
    }
    
    function save_art_update(){
        $user_id = get_current_user_id();
      $upload_dir = wp_upload_dir(); // Relative to the root
        $albumVars = array(
            "art_id"=> $_POST['art_id'],
            "art_title" => $_POST['art_title'],
            "art_category" => $_POST['art_category'],
            "art_sub_category" => $_POST['art_sub_category'],
            "art_colors" => $_POST['art_colors'],
            "art_year" => $_POST['art_year'],
            "art_description" => $_POST['art_description']
        );
        
        $db = new Artist_db();
        if($_POST['image_hidden_path']){
            $img_path = $upload_dir["basedir"].'/arts_tmp/'.$_POST['image_hidden_path'];
            $my_path = $upload_dir["basedir"].'/arts/'.$user_id.'/';
            $str = explode('.',$_POST['image_hidden_path']);
            rename($img_path, $my_path.'/'.$user_id.'_'.$_POST['art_id'].'.'.$str[1]);
            unlink($img_path);
            
            $img = $user_id.'_'.$_POST['art_id'].'.'.$str[1];
            $img_path = $db->update_art_path($img,$_POST['art_id']);
        }
        $status = $db->save_art_update($albumVars);
            $result = array("status"=>1, "message"=>"Update successful");
            echo json_encode($result);
         
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
    
    function get_subcategories(){
        $cat_id = $_GET['art_category'];
        $art_sub_cat = get_field('art_sub_category','option');
        //echo "<pre>";print_r($art_sub_cats);exit;
        $msg = '';
        foreach ($art_sub_cat as $item){ 
            if($item['parent_id'] == $cat_id){
                $msg.= "<option value='".$item['sub_category_id']."'>".$item['sub_category_name']."</option>";
            }
        }//echo $msg;exit;
        if($msg) {
            $result = array("status"=>1, "message"=>$msg);
            echo json_encode($result);
        } 
        exit;
    }
    
    function get_art_form(){
        ob_start();
        ?>
<ul>
        <li style="list-style: none;border: 1px dotted #000;padding: 5px;float: left;margin-bottom: 5px;">
        <form class="woocommerce-ArtistArtForm artist_art" id="saveDataArtForm" action="" method="post" enctype="multipart/form-data">
        <div class="container">
        <div class="col-md-3">
                <input id="file_uploads" name="file_uploads" type="file" />
        </div>
        <div class="col-md-9">
            <div class="col-md-12">
                <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                        name="art_title" id="art_title" value="" placeholder="Title of Artwork" />

                </p>
            </div>
	<div class="col-md-12">
            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                <select name="art_category" id="art_category" style="width:20% !important;">
                        <option value="">Category</option>
                        <?php 
                        foreach ($art_cat as $item){ ?>
                            <option value="<?php echo $item['category_id'];?>"  ><?php echo $item['category_name'];?></option>;
                        <?php } ?>
                    </select>
                <select name="art_sub_category" id="art_sub_category" style="width:20% !important;">
                        <option value="">Sub Category</option>
                        
                    </select>
                <select name="art_colors" id="art_colors" style="width:20% !important;">
                        <option value="">Colours</option>
                        <?php 
                        foreach ($colours as $item){ ?>
                            <option value="<?php echo $item['colour'];?>" ><?php echo $item['colour'];?></option>;
                        <?php } ?>
                    </select>
                <select name="art_year" id="art_year" style="width:20% !important;">
                        <option value="">Year</option>
                         <?php for($born = date('Y'); $born >= date('Y', strtotime('-100 years')); $born--){?>
                            <option value="<?php echo $born;?>"><?php echo $born;?></option>
                        <?php } ?>
                    </select>
              
            </p>
        </div>
        <div class="col-md-12">
        <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
            <textarea class="woocommerce-Input woocommerce-Input--text input-text"
                      name="art_description" id="art_description" placeholder="Art Description"></textarea>
	</p>
	<p>
            <input type="hidden" id="image_hidden_path" name="image_hidden_path" value="" />
            <input type="submit" class="woocommerce-Button button" id="saveDataArt" name="saveDataArt" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>" />
            <input type="hidden" name="action" value="save_art" />
	</p>
        </div>
        </div>
        </div>
        </div>
   
        </form></li></ul>
        <?php
        $formHtml = ob_get_clean();
        echo $formHtml;
        exit; //When no return msg than use exit;
    }
    
    function get_art_get(){
        ob_start();
        $user_id = get_current_user_id();
    global $wpdb;
   $upload_dir = wp_upload_dir(); // Relative to the root
   //echo "<pre>";print_r($upload_dir);exit;
    $art_data = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist_gallery WHERE `user_id` = '$user_id' ORDER BY `art_order` ASC");
    $art_cat = get_field('art_category','option');
    $art_sub_cat = get_field('art_sub_category','option');
    $art_sub_cat = get_field('art_sub_category','option');
    $colours = get_field('colours','option');
        ?>
<ul id="sortable-row">
        <?php foreach ($art_data as $item_art){  ?>
    <li style="list-style: none;border: 1px dotted #000;padding: 5px;float: left;margin-bottom: 5px;" id="<?php echo $item_art->id; ?>">
<form class="woocommerce-ArtistArtForm artist_art" id="saveDataArtForm_<?php echo $item_art->id; ?>" action="" method="post" enctype="multipart/form-data" >
    
    <div class="container">
        <div class="col-md-3" style="width: 30%;float: left;">
            <?php $imgpath = $upload_dir['baseurl']."/arts/".$user_id."/".$item_art->image_path; ?>
                <!-- <input id="file_uploads" name="file_uploads" type="file" />-->
            <img src="<?php echo $imgpath;?>"  style="height:150px;width:150px;" />
            <script>
                jQuery(document).ready(function ($) {
                    $('#file_uploads_<?php echo $item_art->id; ?>').uploadifive({ 
                    'buttonText'   : 'Click to Upload',
                    'fileType'     : 'image/*',
                    'multi'        : false,
                    'uploadScript' : '<?php echo get_site_url(); ?>/uploadify.php',
                    'onUploadComplete' : function(file, data) {
                        $('#image_hidden_path_<?php echo $item_art->id; ?>').val(data);
                    }
                    // Put your options here
                    });
                });
                </script>
                <input id="file_uploads_<?php echo $item_art->id; ?>" name="file_uploads" type="file" />
            <div class="clearfix"></div>
        </div>
        <div class="col-md-9"  style="width: 70%;float: right;">
            <div class="col-md-12">
                <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                        name="art_title" id="art_title_<?php echo $item_art->id; ?>" value="<?php echo $item_art->art_title; ?>" placeholder="Title of Artwork" />
                </p>
                
            </div>
            <div class="clearfix"></div>
	<div class="col-md-12">
            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                <select name="art_category" id="art_category_<?php echo $item_art->id; ?>" style="width:20% !important;">
                        <option value="">Category</option>
                        <?php 
                        foreach ($art_cat as $item){ ?>
                            <option value="<?php echo $item['category_id'];?>" <?php if($item['category_id'] == $item_art->art_category){ ?> selected="selected" <?php } ?>><?php echo $item['category_name'];?></option>;
                        <?php } ?>
                    </select>
                <select name="art_sub_category" id="art_sub_category_<?php echo $item_art->id; ?>" style="width:20% !important;">
                        <option value="">Sub Category</option>
                        <?php 
                        foreach ($art_sub_cat as $item){ if($item_art->art_category == $item['parent_id']){?>
                            <option value="<?php echo $item['sub_category_id'];?>" <?php if($item['sub_category_id'] == $item_art->art_sub_category){ ?> selected="selected" <?php } ?>><?php echo $item['sub_category_name'];?></option>;
                        <?php }} ?>
                    </select>
                <select name="art_colors" id="art_colors_<?php echo $item_art->id; ?>" style="width:20% !important;">
                        <option value="">Colours</option>
                        <?php 
                        foreach ($colours as $item){ ?>
                            <option value="<?php echo $item['colour'];?>" <?php if($item['colour'] == $item_art->art_colors){ ?> selected="selected" <?php } ?>><?php echo $item['colour'];?></option>;
                        <?php } ?>
                    </select>
                <select name="art_year" id="art_years_<?php echo $item_art->id; ?>" style="width:20% !important;">
                        <option value="">Year</option>
                         <?php for($born = date('Y'); $born >= date('Y', strtotime('-100 years')); $born--){?>
                            <option value="<?php echo $born;?>" <?php if($born == $item_art->art_year){ ?> selected="selected" <?php } ?>><?php echo $born;?></option>
                        <?php } ?>
                    </select>
              
            </p>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
        <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
            <textarea class="woocommerce-Input woocommerce-Input--text input-text"
                      name="art_description" id="art_description_<?php echo $item_art->id; ?>" placeholder="Art Description"><?php echo $item_art->art_description;?></textarea>
	</p>
        <div class="clearfix"></div>
	<p>
            <input type="hidden" name="form_id" id="form_id" value="<?php echo $item_art->id; ?>" />
            <input type="hidden" id="image_hidden_path_<?php echo $item_art->id; ?>" name="image_hidden_path" value="" />
            <input type="submit" class="sub woocommerce-Button button" id="saveDataArt_<?php echo $item_art->id; ?>" name="saveDataArt" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>" />
            <input type="hidden" name="action" value="save_art_update"/>
	</p>
        <div class="clearfix"></div>
        </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        </div>
    <div id="resultMsg_<?php echo $item_art->id; ?>"></div>
        <div class="clearfix"></div>
</form></li>
    <?php } ?></ul>
        <?php
        $formHtml = ob_get_clean();
        echo $formHtml;
        exit; //When no return msg than use exit;
    }
    
    function set_art_order(){
        //echo $_POST["art_order"];exit;
        $id_ary = explode(",",$_POST["art_order"]);
        $db = new Artist_db();
        
        
        for($i=0;$i<count($id_ary);$i++) {
            $status = $db->update_art_order($id_ary[$i], $i);
        }
        $result = array("status"=>1, "message"=>"Order Updated Successfully");
        echo "Order Updated Successfully";
        exit;
    }
    
    function fav_status(){
        $user_id = get_current_user_id();
       // echo "<pre>";print_r($_POST);exit;
        $id = $_POST['artId'];
        $db = new Artist_db();
        $status = $db->update_art_fav($id);
        if($status == 'Insert'){
           $src = get_template_directory_uri()."-child/images/star-one-2.png"; 
        }else{
           $src = get_template_directory_uri()."-child/images/star-no-1.png";  
        }
        echo $src;
        exit;
    }
}

new Artist();