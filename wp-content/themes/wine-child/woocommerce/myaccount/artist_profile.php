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
	
	$user_id = get_current_user_id();
	$user = get_userdata( $user_id );
	$artist_type = get_field('artist_type','option');
      //  echo "<pre>";print_r($artist_type);exit;
	$birthdate = get_user_meta( $user_id, 'user_profile_image', true );
	
	$api = LOU_ACF_API::instance();

	// fetch the list of groups that belong on the top of the my account page
	$field_groups = $api->get_field_groups();
        
        global $wpdb;
        $category = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist_category");
        $country = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."country");
       
        $artist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist");
       // print_r($artist[0]->artist_name);exit;
        if($artist){
            $name = $artist[0]->artist_name;
        }else{
            $name = esc_attr( $user->first_name ).''.esc_attr( $user->last_name );
        }
	$selected_type = explode(",", $artist[0]->artist_type);
?>

<form class="woocommerce-ArtistProfileForm artist_profile" action="" method="post">

    <h1>1. Artist Profile</h1><span>All fields are mendetory</span>
	
	<?php do_action( 'woocommerce_artist_profile_form_start' ); ?>
		
	<p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text"
		name="artist_name" id="account_artist_name" value="<?php echo $name; ?>" placeholder="Artist Name" />
	
	</p>
	<div class="clear"></div>
	
	<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
		<select name="artist_country" style="width:30% !important;">
                    <option value="">Country</option>
                    <?php 
                    foreach ($country as $item){
                    ?>
                    <option value="<?php echo $item->id;?>" <?php if($artist[0]->artist_country == $item->id ){?> selected="selected"<?php } ?>><?php echo $item->country_name;?></option>
                    <?php 
                    }
                    ?>
		</select>
                <select name="artist_born_year" style="width:30% !important;">
                    <option value="">Born</option>
                    <?php for($born = date('Y'); $born >= date('Y', strtotime('-100 years')); $born--){?>
                    <option value="<?php echo $born;?>"<?php if($artist[0]->artist_born_year == $born ){?> selected="selected"<?php } ?>><?php echo $born;?></option>
                    <?php } ?>
		</select>
            <select name="artist_type[]" style="width:30% !important;" multiple="multiple">
                    
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
                      name="artist_description" id="artist_description" placeholder="Artist Profile Description"><?php echo $artist[0]->artist_description; ?></textarea>
	
	</p>
	<div class="clear"></div>
        <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
            <textarea class="woocommerce-Input woocommerce-Input--text input-text"
                      name="artist_awards" id="artist_awards" placeholder="Artist Profile Awards"><?php echo $artist[0]->artist_awards; ?></textarea>
	
	</p>
	<div class="clear"></div>   
	<?php do_action( 'woocommerce_artist_profile_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_artist_details' ); ?>
		<input type="submit" class="woocommerce-Button button" name="save_artist_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>" />
		<input type="hidden" name="action" value="save_artist_details" />
	</p>

	<?php do_action( 'woocommerce_artist_profile_form_end' ); ?>
</form>


<?php do_action( 'woocommerce_after_artist_profile_form' ); ?>