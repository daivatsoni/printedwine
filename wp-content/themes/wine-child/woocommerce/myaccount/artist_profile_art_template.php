<?php
    $user_id = get_current_user_id();
    global $wpdb;
   $upload_dir = wp_upload_dir(); // Relative to the root
   //echo "<pre>";print_r($upload_dir);exit;
    $art_data = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist_gallery WHERE `user_id` = '$user_id'");
    $art_cat = get_field('art_category','option');
    $art_sub_cat = get_field('art_sub_category','option');
    $art_sub_cat = get_field('art_sub_category','option');
    $colours = get_field('colours','option');
   // echo "<pre>";print_r($art_data);exit;
?>
<?php foreach ($art_data as $item_art){  ?>
<form class="woocommerce-ArtistArtForm artist_art" id="saveDataArtForm_<?php echo $item_art->id; ?>" action="" method="post" enctype="multipart/form-data" onsubmit="abc('<?php echo $item_art->id; ?>');">
    <div class="container">
        <div class="col-md-3">
            <?php $imgpath = $upload_dir['baseurl']."/arts/".$user_id."/".$item_art->image_path; ?>
                <!-- <input id="file_uploads" name="file_uploads" type="file" />-->
            <img src="<?php echo $imgpath;?>" hight='150' width='150' />
            <div class="clearfix"></div>
        </div>
        <div class="col-md-9">
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
            <input type="hidden" id="image_hidden_path" name="image_hidden_path" value="" />
            <input type="submit" class="woocommerce-Button button" id="saveDataArt_<?php echo $item_art->id; ?>" name="saveDataArt" value="<?php esc_attr_e( 'Save', 'woocommerce' ); ?>" />
            <input type="hidden" name="action" value="save_art_update"/>
	</p>
        <div class="clearfix"></div>
        </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
</form>
<?php } ?>