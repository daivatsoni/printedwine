
<?php 
	
	$user_id = get_current_user_id();
	$artist_type = get_field('artist_type','option');
        $art_cat = get_field('art_category','option');
        $art_sub_cat = get_field('art_sub_category','option');
        $colours = get_field('colours','option');

       // echo "<pre>";print_r($art_cat);exit;
	
        
        global $wpdb;
        $category = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist_category");
        $country = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."country");
       
        $artist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist");
       // print_r($artist[0]->artist_name);exit;
        if($artist){
            $name = $artist[0]->artist_name;
        }else{
            $name = esc_attr( $user->first_name ).' '.esc_attr( $user->last_name );
        }
	$selected_type = explode(",", $artist[0]->artist_type);
?>
		
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
                      name="artist_description" id="artist_description" placeholder="Artist Profile Description"><?php echo $artist[0]->artist_description; ?></textarea>
	
	</p>
	<div class="clear"></div>
        <p class="woocommerce-FormRow woocommerce-FormRow--first form-row form-row-first">
            <textarea class="woocommerce-Input woocommerce-Input--text input-text"
                      name="artist_awards" id="artist_awards" placeholder="Artist Profile Awards"><?php echo $artist[0]->artist_awards; ?></textarea>
	
	</p>
	<div class="clear"></div>   
