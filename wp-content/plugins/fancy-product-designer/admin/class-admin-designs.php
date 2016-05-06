<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if( !class_exists('FPD_Admin_Fancy_Designs') ) {

	class FPD_Admin_Fancy_Designs {

		private $hierarchical_terms = array();

		public function __construct() {

			add_action( 'fpd_design_category_add_form_fields', array( $this, 'add_image_uploader_to_add_form'), 10, 2 );
			add_action( 'fpd_design_category_edit_form_fields', array( $this, 'add_image_uploader_to_edit_form'), 10, 1);
			add_action( 'edited_fpd_design_category', array( $this, 'save_taxonomy_custom_meta'), 10, 2 );
			add_action( 'create_fpd_design_category', array( $this, 'save_taxonomy_custom_meta'), 10, 2 );
			add_action( 'delete_fpd_design_category', array( $this, 'delete_taxonomy_custom_meta'), 10, 2 );

			add_action( 'delete_term',  array( &$this, 'term_delete' ), 10, 4 );

		}

		public function add_image_uploader_to_add_form() {

			?>
			<div class="form-field">
				<label for="mspc_image_url"><?php _e('Thumbnail', 'radykal') ?></label>
				<div class="radykal-option-type--upload radykal-clearfix">
					<a href="#" class="radykal-add-image">+</a>
					<input type="text" name="fpd_category_thumbnail_url" value="" style="width: calc(95% - 60px);px" />
					<a href="#" class="radykal-remove-image">-</a>
				</div>
				<p>
					<?php _e('Set a thumbnail for the category.'); ?>
				</p>
			</div>
			<?php

		}

		public function add_image_uploader_to_edit_form( $term ) {

			$term_id = $term->term_id;
			$thumbnail_url = get_option( 'fpd_category_thumbnail_url_'.$term_id );

			?>
			<tr class="form-field">
				<th scope="row" valign="top">
					<label for="mspc_image_url"><?php _e('Thumbnail', 'radykal') ?></label>
				</th>
				<td>
					<div class="radykal-option-type--upload radykal-clearfix">
						<a href="#" class="radykal-add-image">+</a>
						<input type="text" name="fpd_category_thumbnail_url" value="<?php echo $thumbnail_url; ?>" style="width: calc(95% - 60px);px" />
						<a href="#" class="radykal-remove-image">-</a>
					</div>
					<p class="description"><?php _e('Set a thumbnail for the category.', 'radykal'); ?></p>
				</td>
			</tr>
			<?php

		}

		public function save_taxonomy_custom_meta( $term_id ) {

			if ( isset( $_POST['fpd_category_thumbnail_url'] ) )
				update_option( 'fpd_category_thumbnail_url_'.$term_id, $_POST['fpd_category_thumbnail_url'] );

		}

		public function delete_taxonomy_custom_meta( $term_id ) {

			delete_option( 'fpd_category_thumbnail_url_'.$term_id );

		}


		//delete category parameters if fancy design category is deleted
		public function term_delete( $term_id, $tax_id, $tax_slug, $term ) {

			delete_option( 'fpd_category_parameters_'.$term->slug );

		}

		private function make_terms_hierarchical( $parent_terms = array() ) {

			foreach($parent_terms as $parent_term) {

				$children = get_terms(
				    'fpd_design_category',
				    array(
					    'hide_empty' => false,
					 	'orderby' 	 => 'name',
				        'parent' => $parent_term->term_id,
				    )
				);

				array_push($this->hierarchical_terms, $parent_term);

				if( !empty($children) ) {
					foreach($children as $child) {
						$this->make_terms_hierarchical(array($child));
					}

				}

			}

		}

		public function output() {

			?>
			<div class="wrap" id="fpd-manage-designs">
				<h2 class="fpd-clearfix">
					<?php _e('Manage Fancy Designs', 'radykal'); ?>
						<a class="add-new-h2" href="<?php echo admin_url('edit-tags.php?taxonomy=fpd_design_category&post_type=attachment'); ?>"><?php _e('Create Category', 'radykal'); ?></a>
					<?php fpd_admin_display_version_info(); ?>
				</h2>
				<?php

					//get all created categories
					$categories = get_terms( 'fpd_design_category', array(
					 	'hide_empty' => false,
					 	'orderby' 	 => 'name',
					 	'parent' => 0
					));

					$this->make_terms_hierarchical($categories);
					$categories = $this->hierarchical_terms;

					//check that categories are not empty
					if( empty($categories) ) {
						echo '<div class="error"><p><strong>'.__('No categories found. You need to create a category first!', 'radykal').'</strong></p></div></div>';
						return false;
					}

					//select first category id
					$selected_category = $categories[0];
					$selected_category_id = $selected_category->term_id;

					//loop through all categories
					foreach($categories as $category) {

						//check if a category is selected
						if( isset($_GET['category_id']) && $_GET['category_id'] == $category->term_id) {
							$selected_category = $category;
							$selected_category_id = $selected_category->term_id;
						}

					}

					if( isset($_POST['save_designs']) ) {

						check_admin_referer( 'fpd_save_designs' );

						//remove all designs from design category
						$args = array(
							'posts_per_page' => -1,
							'post_type' => 'attachment',
							'fpd_design_category' => $selected_category->slug
						);

						//get all attachments and remove the from category
						$designs = get_posts( $args );
						foreach( $designs as $design ) {
							wp_delete_object_term_relationships($design->ID, 'fpd_design_category');
						}

					 	$order = 0;
					 	//loop through all submitted images
					 	foreach( $_POST['image_ids'] as $image_id ) {

						 	//update menu order
					 		$attachment = array(
								'ID'           => $image_id,
								'menu_order' => $order
							);
							wp_update_post( $attachment );

							//set relation between image and design category
					 		wp_set_object_terms( $image_id, $selected_category->slug, 'fpd_design_category', true );

					 		//set parameters for design
					 		update_post_meta( $image_id, 'fpd_parameters', $_POST['parameters'][$order]);
					 		update_post_meta( $image_id, 'fpd_thumbnail', $_POST['thumbnail'][$order]);

					 		$order++;

					 	}

					 	update_option( 'fpd_category_parameters_'.$selected_category->slug, $_POST['fpd_category_options'] );

						echo '<div class="updated"><p><strong>'.__('Designs saved.', 'radykal').'</strong></p></div>';
					}

					//get category parametes
					$category_parameters = get_option( 'fpd_category_parameters_'.$selected_category->slug );

				?>

				<br class="clear" />
				<?php
				require_once(FPD_PLUGIN_ADMIN_DIR.'/modals/modal-edit-design-category-options.php');
				?>
				<form method="post" id="fpd-designs-form">
					<div>
						<p class="description"><?php _e('Categories', 'radykal'); ?></p>
						<select name="design_category" class="radykal-select2" style="width: 400px;">
							<?php
								foreach($categories as $category) {

									$parent_cat_str = get_category_parents($category->term_id, false, '%#%');
									$parent_cats_array = explode('%#%', $parent_cat_str);
									$level = max(sizeof($parent_cats_array) - 2, 0);

									$selected = '';
									//check if a category is selected
									if( isset($_GET['category_id']) && $_GET['category_id'] == $category->term_id) {
										$selected = 'selected="selected"';
									}

									//output category option
									echo '<option value="'.$category->term_id.'" '.$selected.'>'.str_repeat("- ", $level).$category->name.'</option>';

								}
							?>
						</select>
					</div>
					<br /><br />
					<p class="description"><?php _e('Designs in "', 'radykal'); echo $selected_category->name.'"'; ?></p>
					<div class="fpd-panel">
						<?php

						?>
						<input type="hidden" value="<?php if( $category_parameters ) echo $category_parameters; ?>" name="fpd_category_options" />
					 	<a href="#" class="add-new-h2 fpd-add-designs"><?php _e('Add Designs', 'radykal'); ?></a>
					 	<a href="#" id="fpd-edit-category-options" class="add-new-h2"><?php _e('Edit Category Options', 'radykal'); ?></a>
					 	<div id="fpd-black-white-switcher" class="fpd-right">
						 	<a href="#" id="fpd-white"></a>
						 	<a href="#" id="fpd-black"></a>
					 	</div>

					 	<div class="inside">
						 	<ul id="fpd-designs-list" class="fpd-clearfix">
						 	<?php

							 //get designs by category id
							$args = array(
								'posts_per_page' => -1,
								'post_type' => 'attachment',
								'orderby' => 'menu_order',
								'order' => 'ASC',
								'fpd_design_category' => $selected_category->slug
							);

							$designs = get_posts( $args );

							//loop through all designs
							foreach( $designs as $design ) {

								$origin_image = wp_get_attachment_image_src( $design_id, 'full' );
								$origin_image = $origin_image[0] ? $origin_image[0] : $design->guid;

								$parameters = get_post_meta($design->ID, 'fpd_parameters', true);
								$thumbnail = get_post_meta($design->ID, 'fpd_thumbnail', true);
								echo '<li><img src="'.$origin_image.'" /><a href="#" class="fpd-edit-parameters"><i class="fpd-admin-icon-settings"></i></a><a href="#" class="fpd-remove-design"><i class="fpd-admin-icon-close"></i></a><input type="hidden" value="'.$design->ID.'" name="image_ids[]" /><input type="hidden" value="'.$parameters.'" name="parameters[]" /><input type="hidden" value="'.$thumbnail.'" name="thumbnail[]" /></li>';

							}
						 	?>
						 	</ul>
					 	</div>

					 </div>
					<?php wp_nonce_field( 'fpd_save_designs'); ?>
					<input type="submit" name="save_designs"  value="<?php _e('Save Changes', 'radykal'); ?>" class="button button-primary" />
				</form>

			</div>
			<?php

		}
	}
}

new FPD_Admin_Fancy_Designs();

?>