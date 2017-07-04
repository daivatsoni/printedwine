<?php
/**
 * Artist Profile form
 *
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_artist_profile_form' ); ?>
<?php 
        if ( !is_user_logged_in() && is_page('add page slug or i.d here') && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php' ) {

            wp_redirect( get_site_url() ); 
            exit;
        }
	$user_id = get_current_user_id();
        $user = get_userdata( $user_id );
	$artist_type = get_field('artist_type','option');
        $art_cat = get_field('art_category','option');
        $art_sub_cat = get_field('art_sub_category','option');
        $colours = get_field('colours','option');

       // echo "<pre>";print_r($art_cat);exit;
	
        
        global $wpdb;
       // $category = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist_category");
        $country = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."country");
       
        $artist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist");
       // print_r($artist[0]->artist_name);exit;
        if($artist){
            $name = $artist[0]->artist_name;
            $selected_type = explode(",", $artist[0]->artist_type);
        }else{
            $name = esc_attr( $user->first_name ).' '.esc_attr( $user->last_name );
            $selected_type = array();
        }
	
?>

<form class="woocommerce-artist_form artist_form" action="" method="post">

    <h1>1. Artist Profile</h1><span>All fields are mendetory</span>
		
	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
		name="artist_name" id="artist_name" value="<?php echo $name; ?>" placeholder="Artist Name" />
	
	</p>
	<div class="clear"></div>
	
	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
            <select name="artist_country" id="artist_country" style="width:30% !important;">
                    <option value="">Country</option>
                    <?php 
                    foreach ($country as $item){
                    ?>
                    <option value="<?php echo $item->id;?>" <?php if($artist[0]->artist_country == $item->id ){?> selected="selected"<?php } ?>><?php echo $item->country_name;?></option>
                    <?php 
                    }
                    ?>
		</select>
            <select name="artist_born_year" id="artist_born_year" style="width:30% !important;">
                    <option value="">Born</option>
                    <?php for($born = date('Y'); $born >= date('Y', strtotime('-100 years')); $born--){?>
                    <option value="<?php echo $born;?>"<?php if($artist[0]->artist_born_year == $born ){?> selected="selected"<?php } ?>><?php echo $born;?></option>
                    <?php } ?>
		</select>
            <select class="js-example-basic-multiple" id="artist_type" name="artist_type[]" style="width:30% !important;" multiple="multiple">
                <option value="">Select Type</option>
                    <?php 
                    foreach ($artist_type as $item){ ?>
                <option value="<?php echo $item['type'];?>" <?php if(in_array($item['type'], $selected_type)){ ?>selected="selected"<?php } ?> ><?php echo $item['type'];?></option>;
                    <?php    }
                       
                    ?>
		</select>
	</p>
        <div class="clear"></div>
        <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
            <textarea class="woocommerce-Input woocommerce-Input--text input-text"
                      name="artist_description" id="artist_description" placeholder="Artist Profile Description"><?php if($artist){echo $artist[0]->artist_description;} ?></textarea>
	
	</p>
	<div class="clear"></div>
        <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
            <textarea class="woocommerce-Input woocommerce-Input--text input-text"
                      name="artist_awards" id="artist_awards" placeholder="Artist Profile Awards"><?php if($artist){ echo $artist[0]->artist_awards;} ?></textarea>
	
	</p>
	<div class="clear"></div>   
	<?php //do_action( 'woocommerce_artist_profile_form' ); ?>

	<p>
		<?php //wp_nonce_field( 'save_artist_details' ); ?>
            <input type="submit" class="woocommerce-Button button" name="saveDataArtist" id="saveDataArtist" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>" />
		<input type="hidden" name="action" value="saveDataArtist" />
	</p>
 
 <?php //include 'woocommerce/myaccount/artist_profile_template.php';     ?>
</form>
<div class="clear"></div>
<form class="woocommerce-ArtistArtForm artist_art" id="saveDataArtForm" action="" method="post" enctype="multipart/form-data">

    <h1>2. Upload images to your gallary</h1><span>you may click and drag to reorder once you have saved</span>
	
	<?php do_action( 'woocommerce_artist_profile_image_form_start' ); ?>
    <div class="container">
        <div class="row">
        <div class="col-md-3">
            <div class="col-md-12">
                <image src="<?php echo get_stylesheet_directory_uri(); ?>/images/blank_photo.jpeg" height="150" width="150"/>
            </div>
            <div class="clear"></div>
            <div class="col-md-12">
                <label for="file-upload" class="custom-file-upload">
                    Click to upload
                </label>
                <input id="file-upload" name="image" type="file" hidden="true"/>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="col-md-9">
            <div class="col-md-12">
                <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
                        name="art_title" id="art_title" value="" placeholder="Title of Artwork" />

                </p>
            </div>
	<div class="clear"></div>
	<div class="col-md-12">
            <p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
                    <select name="art_category" style="width:20% !important;">
                        <option value="">Category</option>
                        <?php 
                        foreach ($art_cat as $item){ ?>
                            <option value="<?php echo $item['category'];?>"  ><?php echo $item['category'];?></option>;
                        <?php } ?>
                    </select>
                    <select name="art_sub_category" style="width:20% !important;">
                        <option value="">Sub Category</option>
                        <?php 
                        foreach ($art_sub_cat as $item){ ?>
                            <option value="<?php echo $item['sub_category'];?>" ><?php echo $item['sub_category'];?></option>;
                        <?php } ?>
                    </select>
                    <select name="art_colors" style="width:20% !important;">
                        <option value="">Colours</option>
                        <?php 
                        foreach ($colours as $item){ ?>
                            <option value="<?php echo $item['colour'];?>" ><?php echo $item['colour'];?></option>;
                        <?php } ?>
                    </select>
                    <select name="art_year" style="width:20% !important;">
                        <option value="">Year</option>
                         <?php for($born = date('Y'); $born >= date('Y', strtotime('-100 years')); $born--){?>
                            <option value="<?php echo $born;?>"><?php echo $born;?></option>
                        <?php } ?>
                    </select>
              
            </p>
        </div>
        <div class="clear"></div>
        <div class="col-md-12">
        <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
            <textarea class="woocommerce-Input woocommerce-Input--text input-text"
                      name="art_description" id="art_description" placeholder="Art Description"></textarea>
	
	</p>
    
	<div class="clear"></div>
      
	<?php //do_action( 'woocommerce_artist_profile_image_form' ); ?>

	<p>
		<?php //wp_nonce_field( 'save_artist_details' ); ?>
            <input type="submit" class="woocommerce-Button button" id="saveDataArt" name="saveDataArt" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>" />
		<input type="hidden" name="action" value="save_art" />
	</p>
        </div>
        </div>
        </div>
        </div>
   
	<?php //do_action( 'woocommerce_artist_profile_image_form_end' ); ?>
</form>


<?php //do_action( 'woocommerce_after_artist_profile_form' ); ?>