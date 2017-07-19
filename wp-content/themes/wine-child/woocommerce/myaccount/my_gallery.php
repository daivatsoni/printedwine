<?php
	$title = get_field('wine_title','option');
	$tag_line = get_field('wine_subheading','option');
	
	$form_opt = get_field('wine_list_of_options','option');
	
	$memberId = get_current_user_id();
	global $current_user;
        get_currentuserinfo();
        
        $user_id = get_current_user_id();
    global $wpdb;
   $upload_dir = wp_upload_dir(); // Relative to the root
   //echo "<pre>";print_r($upload_dir);exit;
    $artist_data = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist WHERE `user_id` = '$user_id'");
   //echo "<pre>";print_r($artist_data);exit;
    $country = $wpdb->get_results("SELECT country_name FROM ".$wpdb->prefix."country WHERE `id` = '".$artist_data[0]->artist_country."'");
   //echo "<pre>";print_r($country);exit;

    $art_data = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist_gallery WHERE `user_id` = '$user_id'");
       //echo "<pre>";print_r($art_data);exit;

    $art_cat = get_field('art_category','option');
    $art_sub_cat = get_field('art_sub_category','option');
    $art_sub_cat = get_field('art_sub_category','option');
    $colours = get_field('colours','option');
    
 ?>

<div class="row">
	
	<div class="col-lg-9">
            <p id="resultMsg"></p>
          
            <div id="albumListContainer">
                <div class="col-lg-12" style="width:980px;float: left;">
                    <div class="col-lg-6" style="width:400px;float:left;">
                        <div class="flexslider">
                            <ul class="slides">
                                <?php foreach ($art_data as $item){ ?>
                                <li style="list-style: none;">
                                    <img src="<?php echo $upload_dir['baseurl']."/arts/".$user_id."/".$item->image_path; ?>" style="height:150px;width:400px;" >
                                    
                                    <p class="flex-caption"><a href="<?php echo get_site_url(); ?>/member-dashboard/art_detail/?id=<?php echo $item->id;?>"><?php echo $item->art_title; ?></a></p>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div> 
                    <div class="col-lg-6" style="width:400px;float: right">
                        <p>Artist Gallery Profile</p>
                        <p><h1><?php echo $artist_data[0]->artist_name; ?></h1></p>
                        <p><?php echo $artist_data[0]->artist_name; ?> was born in <?php echo $country[0]->country_name; ?> <?php echo $artist_data[0]->artist_born_year; ?>.</p>
                        <p><?php echo $artist_data[0]->artist_description; ?></p>
                        <p><h3>Awards</h3></p>
                        <p><?php echo $artist_data[0]->	artist_awards; ?></p>
                    </div>
                    
                </div>
                <div class="col-lg-12" style="width:980px;float: left">
                    <?php //echo get_template();
                    foreach ($art_data as $item){
                             
                            // echo "<pre>";print_r($fv_data->art_id.' art id = '.$item->id);
                    ?>
                    <img src="<?php echo $upload_dir['baseurl']."/arts/".$user_id."/".$item->image_path; ?>" style="height:150px;width:150px;float: left" > 
                    <p><?php 
                    $sql = "SELECT * FROM pw_art_favourite WHERE 1";
		$sql .= " AND art_id='$item->id'";
                $sql .= " AND user_id='$user_id'";
		
		$results = $wpdb->get_results($sql, 'ARRAY_A');
                    if($results){ 
                        ?>
                            <img src="<?php echo get_template_directory_uri();?>-child/images/star-one-2.png" style="float:left" id="favId_<?php echo $item->id ?>" class="fvclick">
                        <?php }else{ ?>
                            <img src="<?php echo get_template_directory_uri();?>-child/images/star-no-1.png" style="float:left" id="favId_<?php echo $item->id ?>" class="fvclick">
                                <?php }?></p>
                    <span><a href="<?php echo get_site_url(); ?>/member-dashboard/art_detail/?id=<?php echo $item->id;?>" style="float: left"><?php echo $item->art_title; ?></a></span>
                    <?php
                       }
                    ?>
                    
                </div> 
            </div>
		   
	</div>	
</div>