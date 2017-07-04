<?php

class Artist_db {
	
	var $wpdb;
	var $table_name;
        var $table_name_gallery;
	
	function Artist_db() {
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->table_name = $wpdb->prefix . "artist";
                $this->table_name_gallery = $wpdb->prefix . "artist_gallery";
	}
	
	function setup_tables() {
		if(!is_multisite()) {
			self::create_tables();
//			self::update_gallery_table();
//			self::update_categories_table();			
		}
	}
	
	function update_artist_table() {
		$sql = "DESCRIBE $this->table_name";
		$result = $this->wpdb->get_results($sql, 'ARRAY_N');
		
		for($i=0; $i<count($result); $i++) {
			$field[] = $result[$i][0];
		}
		
		if(!in_array('category_id',$field)) {
			$sql = "ALTER TABLE `$this->table_name` ADD `category_id` INT NOT NULL AFTER `post_id`";
			$this->wpdb->query($sql);
		}
		if(!in_array('country',$field)) {
			$sql = "ALTER TABLE `$this->table_name` ADD `country` VARCHAR( 60 ) NULL AFTER `address`";
			$this->wpdb->query($sql);
		}
		if(!in_array('city',$field)) {
			$sql = "ALTER TABLE `$this->table_name` ADD `city` VARCHAR( 60 ) NULL AFTER `address`";
			$this->wpdb->query($sql);
		}
		if(!in_array('googleUrl',$field)) {
			$sql = "ALTER TABLE `$this->table_name` ADD `googleUrl` VARCHAR( 255 ) NULL AFTER `city`";
			$this->wpdb->query($sql);
		}
		if(!in_array('work_hours',$field)) {
			$sql = "ALTER TABLE `$this->table_name` ADD `work_hours` TEXT NULL AFTER `googleUrl`";
			$this->wpdb->query($sql);
		}
	}
	
	
	
	function create_tables() {
		$sql = "CREATE TABLE IF NOT EXISTS " . $this->table_name . " (
		`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`user_id` BIGINT NOT NULL ,
		`artist_name` VARCHAR( 160 ) NULL ,
		`artist_country` INT NOT NULL ,
		`artist_born_year` INT NOT NULL ,
		`artist_type` VARCHAR( 160 ) NULL  ,
		`artist_description` TEXT NULL,
                `artist_awards` TEXT NULL,
                `status` enum('Active','Inactive') NOT NULL
		);";
		$this->wpdb->query($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS " . $this->table_name_gallery . " (
		`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		`user_id` BIGINT NOT NULL ,
                `art_title` VARCHAR( 160 ) NULL ,
                `art_category` VARCHAR( 160 ) NULL ,
                `art_sub_category` VARCHAR( 160 ) NULL ,
                `art_colors` VARCHAR( 160 ) NULL ,
                `art_year` BIGINT NOT NULL ,
                `image_path` VARCHAR( 255 ) NULL ,
                `art_description` TEXT NULL ,
                `status` enum('Active','Inactive') NOT NULL
		);";
		
		$this->wpdb->query($sql);
	}
	
	function return_nb_stores($criteria=array()) {
		$category_id = $criteria['category_id'];
		
		$sql = "SELECT count(*) as nb 
		FROM $this->table_name WHERE 1";
		
		if($category_id!='') $sql .= " AND category_id='$category_id'";
		
		$results = $this->wpdb->get_results($sql, 'ARRAY_A');
		return $results[0];
	}
		
	function return_albums($criteria=array()) {
		$id = $criteria['id'];
		$userId = $criteria['user_id'];
                
		$sql = "SELECT * FROM $this->table_name_gallery WHERE 1";
                
		if($id>0) $sql .= " AND id='$id'";                
		if($userId>0) $sql .= " AND user_id='$userId'";
                
		$sql .= ' ORDER BY name';
		
		$results = $this->wpdb->get_results($sql, 'ARRAY_A');
		return $results;
	}
	
	function return_nb_stores_by_category() {
		$sql = 'SELECT c.id, count(*) nb 
		FROM '.$this->table_name.' s, '.$this->table_name_category.' c 
		WHERE s.category_id=c.id GROUP BY s.category_id';
		$results = $this->wpdb->get_results($sql, 'ARRAY_A');
		for($i=0; $i<count($results); $i++) {
			$storesCat[$results[$i]['id']] = $results[$i]['nb'];
		}
		return $storesCat;
	}
	
	function delete_store($id) {
		$sql = "DELETE FROM $this->table_name WHERE id='%d'";
		$this->wpdb->query($this->wpdb->prepare($sql, $id));
		return 'The store has been deleted.';
	}
	
	function delete_gallery($id) {
		$sql = "SELECT * FROM $this->table_name WHERE category_id='$id'";
		$results = $this->wpdb->get_results($sql, 'ARRAY_A');
		if(count($results)>0) {
			return "You cannot delete this category because it's containing ".count($results)." store(s). Please delete the stores first then try again.";
		}
		else {
			$sql = "DELETE FROM $this->table_name_category WHERE id='%d'";
			$this->wpdb->query($this->wpdb->prepare($sql, $id));
			return 'The category has been deleted.';
		}
	}
	
	function update_gallery($criteria) {
		$sql = "UPDATE $this->table_name_category SET name='".$criteria['name']."', marker_icon='".$criteria['marker_icon']."', postcode='".$criteria['postcode']."' 
		WHERE id='".$criteria['id']."'";
		$this->wpdb->query($sql);
	}
        function get_artist($id){
                $sql = "SELECT * FROM $this->table_name WHERE user_id='$id'";
		$results = $this->wpdb->get_results($sql, 'ARRAY_A');
		if(count($results)>0) {
			return $results;
                }
        }
	function add_artist($criteria) {
            
		$sql = "INSERT INTO $this->table_name 
		(user_id, artist_name, artist_country, artist_born_year, artist_type, artist_description, artist_awards, status) 
		VALUES ('".$criteria['user_id']."', '".$criteria['artist_name']."', '".$criteria['artist_country']."', '".$criteria['artist_born_year']."', '".$criteria['artist_type']."', '".$criteria['artist_description']."', '".$criteria['artist_awards']."', '".$criteria['status']."', 
		)";
		if(is_main_site()) $this->wpdb->query($sql);
	}
        
        function update_artist($criteria) {
            
		$sql = "UPDATE $this->table_name "
                        . "SET "
                        . "`user_id` = '".$criteria['user_id']."',"
                        . "`artist_name` = '".$criteria['artist_name']."',"
                        . "`artist_country` = '".$criteria['artist_country']."',"
                        . "`artist_born_year` = '".$criteria['artist_born_year']."',"
                        . "`artist_type` = '".$criteria['artist_type']."',"
                        . "`artist_description` = '".$criteria['artist_description']."',"
                        . "`artist_awards` = '".$criteria['artist_awards']."' "
                        . "where `user_id` = '".$criteria['user_id']."'";
		
		if(is_main_site()) $this->wpdb->query($sql);
	}
	
	function add_art($criteria=array()) {
		
		$sql = "INSERT INTO $this->table_name_gallery 
		(user_id, art_title,
                art_category, art_sub_category,
                art_colors, art_year, 
                image_path, art_description, status) 
		VALUES (
                '".$criteria['user_id']."', '".$criteria['art_title']."',"
                . " '".$criteria['art_category']."', '".$criteria['art_sub_category']."', "
                . "'".$criteria['art_colors']."', '".$criteria['art_year']."', "
                . "'".$criteria['image_path']."', '".$criteria['art_description']."', '".$criteria['status']."'
		)";
		if(is_main_site()) $this->wpdb->query($sql);
	}
	
}

?>