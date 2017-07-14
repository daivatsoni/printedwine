<?php
//echo "<pre>";print_r($_GET['id']);exit;
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
    $artId = $_GET['id'];
    $art_data = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist_gallery WHERE `id` = '$artId' AND `user_id` = '$user_id'");
    $art_data1 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."artist_gallery WHERE `user_id` = '$user_id'");
     //  echo "<pre>";print_r($art_data);exit;

    $art_cat = get_field('art_category','option');
    $art_sub_cat = get_field('art_sub_category','option');
    $art_sub_cat = get_field('art_sub_category','option');
    $colours = get_field('colours','option');
    
 ?>

<div class="row">
	
	<div class="col-lg-9">
            <p id="resultMsg"></p>
          
            <div id="albumListContainer">
                <div class="col-lg-12" style="width:800px;float: left;">
                    <div class="col-lg-6" style="width:575px;float:left;">
                        <div class="flexslider">
                                    <img src="<?php echo $upload_dir['baseurl']."/arts/".$user_id."/".$art_data[0]->image_path; ?>" style="height:150px;width:400px;" > 
                                    <p class="flex-caption"><a href="<?php echo get_site_url(); ?>/member-dashboard/art_detail/"><?php echo $art_data[0]->art_title; ?></a></p>
                               
                        </div>
                        <?php
                    foreach ($art_data1 as $item){
                              // echo "<pre>";print_r($item->image_path);exit;

                       // $i = 1;
                      //  for($i=1;$i<=5;$i++){
                    ?>
                    <img src="<?php echo $upload_dir['baseurl']."/arts/".$user_id."/".$item->image_path; ?>" style="height:150px;width:150px;" > 
                    <a href="<?php echo get_site_url(); ?>/member-dashboard/art_detail/?id=<?php echo $item->id;?>"><?php echo $item->art_title; ?></a>
                    <?php
                       }
                    ?>
                    </div> 
                    <div class="col-lg-6" style="width:200px;float: right">
                        <p>Artist Gallery Profile</p>
                        <p><h1><?php echo $artist_data[0]->artist_name; ?></h1></p>
                        <p><?php echo $artist_data[0]->artist_name; ?> was born in <?php echo $country[0]->country_name; ?> <?php echo $artist_data[0]->artist_born_year; ?>.</p>
                        <p><?php echo $artist_data[0]->artist_description; ?></p>
                        <p><h3>Art Details</h3></p>
                        <p><h1><?php echo $art_data[0]->art_title; ?></h1></p>
                        <p><?php echo $art_data[0]->art_description; ?></p>
                        <p><a href="#" style="float:left;padding: 10px;border-radius: 5px;background-color:#3867ad;color: #fff">Edit Profile/Gallery &nbsp;&nbsp;&nbsp;&nbsp; ></a></p>
                    </div>
                    
                </div>
                
            </div>
		   
	</div>	
</div>