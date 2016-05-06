<?php

	$source_type = isset( $custom_fields["fpd_source_type"] ) ? $custom_fields["fpd_source_type"][0] : "category";
	$current_ind_settings = isset( $custom_fields["fpd_product_settings"] ) ? $custom_fields["fpd_product_settings"][0] : "";

	$selected_categories = isset( $custom_fields["fpd_product_categories"] ) ? $custom_fields["fpd_product_categories"][0] : "";
	if( @unserialize($selected_categories) !== false)
		$selected_categories = unserialize($selected_categories); //V2.0, saved as array in db
	else
		$selected_categories = explode(',', $selected_categories); //V3.0 saved as string in db

	$selected_products = isset( $custom_fields["fpd_products"] ) ? $custom_fields["fpd_products"][0] : "";
	if( @unserialize($selected_products) !== false)
		$selected_products = unserialize($selected_products); //V2.0, saved as array in db
	else
		$selected_products = explode(',', $selected_products); //V3.0 saved as string in db

?>

<div>
	<label><strong><?php _e( 'Source Type', 'radykal' ); ?></strong></label>
	<span style="padding-right: 20px;">
		<input type="radio" name="fpd_source_type" value="category" <?php checked($source_type, 'category') ?> />
		<?php _e( 'Category', 'radykal' ); ?>
	</span>
	<span>
		<input type="radio" name="fpd_source_type" value="product" <?php checked($source_type, 'product') ?> />
		<?php _e( 'Product', 'radykal' ); ?>
	</span>
</div>
<div>
	<p class="fpd-categories">
		<label><strong><?php _e( 'Fancy Product Categories', 'radykal' ); ?></strong></label>
		<select multiple="multiple" data-placeholder="<?php _e( 'Select one ore more!', 'radykal' ); ?>" class="radykal-select2" style="width: 100%;">
		<?php
			if( fpd_table_exists(FPD_CATEGORIES_TABLE) ) {

				$categories = $wpdb->get_results("SELECT * FROM ".FPD_CATEGORIES_TABLE." ORDER BY ID ASC");

				foreach($categories as $category) {
					$selected = @in_array($category->ID, $selected_categories) ? 'selected="selected"' : '';
					echo '<option value="'.$category->ID.'" '.$selected.'>'.$category->title.'</option>';
				}

			}
		?>
		</select>
		<input type="hidden" class="fpd-select2-input" name="fpd_product_categories" value="<?php echo implode(',', $selected_categories); ?>" />
	</p>
	<p class="fpd-products">
		<label><strong><?php _e( 'Fancy Products', 'radykal' ); ?></strong></label>
		<select multiple="multiple" data-placeholder="<?php _e( 'Select one ore more!', 'radykal' ); ?>" class="radykal-select2" style="width: 100%;">
			<?php
				if( fpd_table_exists(FPD_PRODUCTS_TABLE) ) {

					$products = $wpdb->get_results("SELECT * FROM ".FPD_PRODUCTS_TABLE." ORDER BY ID ASC");
					foreach($products as $fpd_product) {
						$selected = @in_array($fpd_product->ID, $selected_products) ? 'selected="selected"' : '';
						echo '<option value="'.$fpd_product->ID.'" '.$selected.'>'.$fpd_product->title.'</option>';
					}

				}
			?>
		</select>
		<input type="hidden" class="fpd-select2-input" name="fpd_products" value="<?php echo implode(',', $selected_products); ?>" />
	</p>
</div>
<div>
	<input type="hidden" name="fpd_product_settings" class="widefat" value="<?php echo $current_ind_settings; ?>" />
	<a href="#" id="fpd-change-settings"><?php _e( 'Individual Product Settings', 'radykal' ); ?></a>
</div>


<script type="text/javascript">

	jQuery(document).ready(function($) {

		//FANCY PRODUCT CHECKBOX
		$('#_fancy_product').change(function() {
			if($(this).is(':checked')) {
				$('.hide_if_fancy_product').show();
			}
			else {
				$('.hide_if_fancy_product').hide();
			}
		}).change();

		//source type
		$('[name="fpd_source_type"]').change(function() {
			if($('[name="fpd_source_type"]:checked').val() === 'category') {
				$('.fpd-categories').show();
				$('.fpd-products').hide();
			}
			else {
				$('.fpd-categories').hide();
				$('.fpd-products').show();
			}
		}).change();

	});

</script>