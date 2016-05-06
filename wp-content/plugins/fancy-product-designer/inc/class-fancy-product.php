<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('Fancy_Product')) {

	class Fancy_Product {

		public $id;

		public function __construct( $id ) {

			$this->id = $id;

		}

		public static function create( $title, $options = '', $thumbnail = '' ) {

			if( empty($title) ) {
				return false;
			}

			global $wpdb, $charset_collate;

			//create products table if necessary
			if( !fpd_table_exists(FPD_PRODUCTS_TABLE) ) {
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

				//create products table
				$products_sql_string = "ID BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				              title TEXT COLLATE utf8_general_ci NOT NULL,
				              options TEXT COLLATE utf8_general_ci NULL,
				              thumbnail TEXT COLLATE utf8_general_ci NULL,
							  PRIMARY KEY (ID)";

				$sql = "CREATE TABLE ".FPD_PRODUCTS_TABLE." ($products_sql_string) $charset_collate;";
				dbDelta($sql);

			}

			self::columns_exist();

			$inserted = $wpdb->insert(
				FPD_PRODUCTS_TABLE,
				array(
					'title' => $title,
					'options' => htmlentities($options),
					'thumbnail' => $thumbnail
				),
				array( '%s' )
			);

			return $inserted ? $wpdb->insert_id : false;

		}

		public function add_view( $title, $elements = '', $thumbnail = '', $order = NULL, $options = NULL ) {

			global $wpdb;

			//check if an order value is set
			if($order === NULL) {
				//count views of a fancy product
				$count = $wpdb->get_var("SELECT COUNT(*) FROM ".FPD_VIEWS_TABLE." WHERE product_id=".$this->id."");
				//count is the order value
				$order = intval($count);
			}

			Fancy_View::columns_exist();

			$elements = is_array($elements) ? json_encode($elements) : $elements;
			$inserted = $wpdb->insert(
				FPD_VIEWS_TABLE,
				array(
					'product_id' => $this->id,
					'title' => $title,
					'elements' => $elements ? $elements : '',
					'thumbnail' => $thumbnail ? $thumbnail : '',
					'view_order' => $order,
					'options' => $options
				),
				array( '%d', '%s', '%s', '%s', '%d', '%s')
			);

			return $inserted ? $wpdb->insert_id : false;

		}

		public function update( $title, $options=null, $thumbnail=null ) {

			global $wpdb;

			$columns = array();
			$colum_formats = array();

			if( !empty($title) ) {

				$columns['title'] = $title;
				array_push($colum_formats, '%s');
			}

			if( !empty($options) ) {

				$columns['options'] = htmlentities($options);
				array_push($colum_formats, '%s');
			}

			if( $thumbnail !== null ) {

				$columns['thumbnail'] = $thumbnail;
				array_push($colum_formats, '%s');
			}

			if( !empty($columns) ) {

				self::columns_exist();

				$wpdb->update(
				 	FPD_PRODUCTS_TABLE,
				 	$columns, //what
				 	array('ID' => $this->id), //where
				 	$colum_formats, //format what
				 	array('%d') //format where
				);

			}

			return $columns;

		}

		public function duplicate( $new_product_id ) {

			$new_fp = new Fancy_Product( $new_product_id );

			try {

				$html = '';
				foreach( $this->get_views() as $view ) {

					$view_id = $new_fp->add_view($view->title, $view->elements, $view->thumbnail, $view->view_order, $view->options);

					$html .= FPD_Admin_Manage_Fancy_Products::get_view_item_html(
						$view_id,
						$view->thumbnail,
						$view->title,
						$view->options
					);

				}

				return array(
					'html'	  => $html,
					'message' => __('Views successfully created!', 'radykal')
				);

			}
			catch(Exception $e) {

				return array(
					'error' => 1,
					'message' => __('Fancy Product could not be stored. Please try again!', 'radykal')
				);

			}

		}

		public function delete() {

			global $wpdb;

			try {
				$wpdb->query( $wpdb->prepare("DELETE FROM ".FPD_PRODUCTS_TABLE." WHERE ID=%d", $this->id) );
				$wpdb->query( $wpdb->prepare("DELETE FROM ".FPD_VIEWS_TABLE." WHERE product_id=%d", $this->id) );
				return 1;
			}
			catch(Exception $e) {
				return 0;
			}

		}

		public function get_category_ids() {

			global $wpdb;

			$category_ids = array();

			if( fpd_table_exists(FPD_CATEGORY_PRODUCTS_REL_TABLE) ) {

				$categories = $wpdb->get_results("SELECT category_id FROM ".FPD_CATEGORY_PRODUCTS_REL_TABLE." WHERE product_id=".$this->id."");

				foreach($categories as $category) {
					array_push($category_ids, $category->category_id);
				}

			}


			return $category_ids;

		}

		public function get_views() {

			global $wpdb;

			$views = array();

			if( fpd_table_exists(FPD_VIEWS_TABLE) ) {

				$views = $wpdb->get_results("SELECT * FROM ".FPD_VIEWS_TABLE." WHERE product_id=".$this->id." ORDER BY view_order ASC");
				//updates the image sources to the current domain and protocol
				foreach($views as $view_key => $view) {

					//update thumbnail source
					$view->thumbnail = $this->reset_image_source($view->thumbnail);

					//V2 - views are serialized
					$elements = @unserialize($view->elements) !== false ? @unserialize($view->elements) : $view->elements;
					if( is_array($elements) ) {

						foreach( $elements as $key => $element ) {
							if($element['type'] == 'image') {
								$updated_image = $this->reset_image_source($element['source']);
								$element['source'] = $updated_image;
							}

							$elements[$key] = $element;
						}

						$view->elements = serialize($elements);

					}

				}

			}

			return $views;

		}

		public function get_data() {

			global $wpdb;

			$product_array = array();
			$views = $wpdb->get_results("SELECT * FROM ".FPD_VIEWS_TABLE." WHERE product_id=".$this->id." ORDER BY view_order ASC");
			foreach($views as $view) {

				$view_array = array(
					'title' => $view->title,
					'thumbnail' => $view->thumbnail,
					'elements' => $view->elements,
					'options' => $view->options
				);

				$product_array[] = $view_array;

			}

			return $product_array;

		}

		public function get_thumbnail() {

			global $wpdb;

			self::columns_exist();

			return $wpdb->get_var("SELECT thumbnail FROM ".FPD_PRODUCTS_TABLE." WHERE ID=".$this->id."");

		}

		public function get_title() {

			global $wpdb;

			return $wpdb->get_var("SELECT title FROM ".FPD_PRODUCTS_TABLE." WHERE ID=".$this->id."");

		}

		public function get_options() {

			global $wpdb;

			return @stripslashes($wpdb->get_var("SELECT options FROM ".FPD_PRODUCTS_TABLE." WHERE ID=".$this->id.""));

		}

		public function get_option( $name ) {

			global $wpdb;

			$options = $wpdb->get_row("SELECT options FROM ".FPD_PRODUCTS_TABLE." WHERE ID=".$this->id."");

			if( isset($options->options) ) {

				$options = fpd_convert_obj_string_to_array($options->options);

				if( isset($options[$name]) ) {
					$value = fpd_convert_string_value_to_int($options[$name]);
				}
				else {
					$value = fpd_get_option( 'fpd_'.$name );
				}

			}
			else {
				$value = fpd_get_option( 'fpd_'.$name );
			}


			return $value;

		}

		private function reset_image_source($string) {

			return preg_replace("/(http|https):\/\/(.*?)\/wp-content/i", content_url(), $string);

		}

		private static function columns_exist() {

			global $wpdb;

			$thumbnail_col_exists = $wpdb->get_var( "SHOW COLUMNS FROM ".FPD_PRODUCTS_TABLE." LIKE 'thumbnail'" );
			if( empty($thumbnail_col_exists) ) {
				$wpdb->query( "ALTER TABLE ".FPD_PRODUCTS_TABLE." ADD COLUMN thumbnail TEXT COLLATE utf8_general_ci NULL" );
			}

		}

	}

}

?>