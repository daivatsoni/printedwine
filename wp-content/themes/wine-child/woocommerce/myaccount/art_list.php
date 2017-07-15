<?php
    global $wpdb;
    $upload_dir = wp_upload_dir(); // Relative to the root
    $user_id = get_current_user_id();
    
    if(!($_GET['s_artist'])){
        $artist_name = "t";
    }else{
        $artist_name = $_GET['s_artist'];
    }
    if(!($_GET['s_cat'])){
        $category = "1";
    }else{
        $category = $_GET['s_cat'];
    }
    
    if(!($_GET['s_clr'])){
        $clr = "Red";
    }else{
       $clr = $_GET['s_clr']; 
    }
    
    if(!($_GET['s_yr'])){
        $yr = "2017";
    }else{
        $yr = $_GET['s_yr'];
    }
    
    /* SELECT pwa.artist_name,pwag.* 
FROM `pw_artist_gallery` pwag LEFT JOIN `pw_artist` pwa on pwag.`user_id` = pwa.`user_id`
WHERE pwa.artist_name LIKE 't%' AND pwag.`art_category` = '1' AND pwag.`art_colors` = 'Red' AND pwag.`art_year` = '2002' */
    $art_cat = get_field('art_category','option');
    $colours = get_field('colours','option');
     
    $art_data1 = $wpdb->get_results("SELECT pwa.artist_name,pwag.* 
FROM `pw_artist_gallery` pwag LEFT JOIN `pw_artist` pwa on pwag.`user_id` = pwa.`user_id`
WHERE pwa.artist_name LIKE '".$artist_name."%' AND pwag.`art_category` = '".$category."' AND pwag.`art_colors` = '".$clr."' AND pwag.`art_year` = '".$yr."'");
 ?>

<div class="col-md-12" style="width: 800px;float: left;">
    <div class="row" style="float: left"></div>
    <div class="row" style="float: right">
        <?php 
            foreach (range('A', 'Z') as $char) {
                ?> <a href="<?php echo get_site_url(); ?>/member-dashboard/art_list/?s_artist=<?php echo $char;?>"><?php echo $char . "\n";?></a><?php
            }
        ?>
        
    </div>
</div>
<div class="col-md-12" style="width: 800px;float: left;">
    <div class="row"  style="float: left;"><h3><?php echo $art_data1[0]->artist_name; ?></h3></div>
    <div class="row" style="float: right">
        <select name="category">
            <option value="">Select Category</option>
            <?php 
            foreach ($art_cat as $item){ ?>
                <option value="<?php echo $item['category_id'];?>"  ><?php echo $item['category_name'];?></option>;
            <?php } ?>
        </select>
        <select name="color">
            <option value="">Select Colour</option>
            <?php 
            foreach ($colours as $item){ ?>
                <option value="<?php echo $item['colour'];?>" ><?php echo $item['colour'];?></option>;
            <?php } ?>
        </select>
        <select name="newest">
            <option value="">Select Year</option>
            <?php for($born = date('Y'); $born >= date('Y', strtotime('-100 years')); $born--){?>
                <option value="<?php echo $born;?>"<?php if($artist && ($artist[0]->artist_born_year == $born) ){?> selected="selected"<?php } ?>><?php echo $born;?></option>
            <?php } ?>
        </select>
        <input type="button" name="search_art" id="search_art" value="Search"/>
    </div>
</div>

<div id="searchResult" class="col-md-12" style="width: 800px;float: left;">
    <?php
    foreach ($art_data1 as $item){
    ?>
    <img src="<?php echo $upload_dir['baseurl']."/arts/".$user_id."/".$item->image_path; ?>" style="height:150px;width:150px;" > 
    <a href="<?php echo get_site_url(); ?>/member-dashboard/art_detail/?id=<?php echo $item->id;?>"><?php echo $item->art_title; ?></a>
    <?php
       }
    ?>
    
</div>