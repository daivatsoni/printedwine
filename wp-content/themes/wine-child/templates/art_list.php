<?php 

/* Template Name: Art List */

get_header(); ?>
<?php
    global $wpdb;
    $upload_dir = wp_upload_dir(); // Relative to the root
    $user_id = get_current_user_id();
    
    if(!($_GET['s_art'])){
        $art_name = "a";
    }else{
        $art_name = $_GET['s_art'];
    }
   
    $art_cat = get_field('art_category','option');
    $colours = get_field('colours','option');
    
    $art_years = $wpdb->get_results("SELECT DISTINCT art_year 
    FROM `pw_artist_gallery` ORDER BY `art_year` DESC");
    // echo "<pre>";print_r($art_years);exit;
    $art_data1 = $wpdb->get_results("SELECT pwa.artist_name,pwag.* 
FROM `pw_artist_gallery` pwag LEFT JOIN `pw_artist` pwa on pwag.`user_id` = pwa.`user_id`
WHERE pwag.art_title LIKE '".$art_name."%' AND pwag.`user_id` = '".$user_id."'");
 ?>

<div class="col-md-12" style="width: 800px;float: left;">
    <div class="row" style="float: left"></div>
    <div class="row" style="float: right">
        <?php 
            foreach (range('A', 'Z') as $char) {
                ?> <a href="<?php echo get_site_url(); ?>/art-list/?s_art=<?php echo $char;?>" ><?php echo $char . "\n";?></a><?php
            }
        ?>
    </div>
</div>
<div class="col-md-12" style="width: 800px;float: left;">
    <form name="art_search_frm" method="post" id="art_search_frm">
    <div class="row"  style="float: left;"><h3><?php echo $art_data1[0]->artist_name; ?></h3></div>
    <div class="row" style="float: right">
        <select name="category" id="s_category">
            <option value="">Select Category</option>
            <?php 
            foreach ($art_cat as $item){ ?>
                <option value="<?php echo $item['category_id'];?>"  ><?php echo $item['category_name'];?></option>;
            <?php } ?>
        </select>
        <select name="color" id="s_color">
            <option value="">Select Colour</option>
            <?php 
            foreach ($colours as $item){ ?>
                <option value="<?php echo $item['colour'];?>" ><?php echo $item['colour'];?></option>;
            <?php } ?>
        </select>
        <select name="newest" id="s_year">
            <option value="">Select Year</option>
            <?php foreach ($art_years as $item){?>
                <option value="<?php echo $item->art_year;?>"<?php if($artist && ($artist[0]->artist_born_year == $item->art_year) ){?> selected="selected"<?php } ?>><?php echo $item->art_year;?></option>
            <?php } ?>
        </select>
        <input type="hidden" name="art_title" id="art_title" value="<?php echo $art_name; ?>" />
        <input type="submit" name="search_art" id="search_art" value="Search"/>
    </div>
    </form>
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
 <?php get_footer(); ?>