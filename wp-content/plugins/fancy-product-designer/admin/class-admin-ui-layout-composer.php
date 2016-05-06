<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( !class_exists('FPD_UI_Layout_Composer') ) {

	class FPD_UI_Layout_Composer {

		public function output() {

			//FPD_UI_Layout_Composer::reset_to_default('default');

			$selected_layout_id = 'default';

			if( isset($_POST['fpd_selected_layout']) ) {

				check_admin_referer( 'fpd_save_layout' );

				$selected_layout_id =  sanitize_key($_POST['fpd_selected_layout']);

				if( $_POST['fpd_method'] == 'delete' ) {

					$selected_layout_id = 'default';

				}
			}

			$selected_layout = FPD_UI_Layout_Composer::get_layout($selected_layout_id);
			$all_layouts = FPD_UI_Layout_Composer::get_layouts();

			?>
			<div class="wrap" id="fpd-ui-layout-composer">

				<h2 class="fpd-clearfix">
					<?php _e('UI &amp; Layout Composer', 'radykal'); ?>
					<?php fpd_admin_display_version_info(); ?>
				</h2>
				<p class="description"><?php _e('With the composer you can easily customize and create own user interfaces for the product designer.', 'radykal'); ?></p>

				<div id="fpd-composer-head" class="fpd-panel fpd-clearfix">

					<select name="fpd_ui_layouts">
						<?php
						foreach($all_layouts as $layout) {

							$name = json_decode(stripslashes($layout->option_value), true);
							$name = $name['name'];
							$slug = str_replace('fpd_ui_layout_', '', $layout->option_name);
							echo '<option value="'.$slug.'" '.selected($slug, $selected_layout_id, false).'>'.$name.'</option>';

						}
						?>
					</select>
					<a href="#" class="add-new-h2" id="fpd-save-layout"><?php _e('Save', 'radykal'); ?></a>
					<a href="#" class="add-new-h2" id="fpd-delete-layout"><?php _e('Delete', 'radykal'); ?></a>
					<a href="#" class="add-new-h2" id="fpd-reset-to-default-layout"><?php _e('Reset To Default', 'radykal'); ?></a>
					<a href="#" class="add-new-h2" id="fpd-save-as-new-layout"><?php _e('Save As New', 'radykal'); ?></a>


				</div>
				<style type="text/css" id="fpd-preview-styles">

				</style>
				<div id="fpd-composer-product-designer-wrap" class="fpd-panel" style="padding-bottom: 60px;">
					<h3><?php _e('Preview', 'radykal'); ?></h3>
					<script type="text/javascript">

						var initial_opts = {};
						try {
							initial_opts = JSON.parse(JSON.stringify(<?php echo json_encode($selected_layout); ?>));
						}
						catch(evt) {
							console.log('Is not a valid JSON');
						}

					</script>
					<div id="fpd-product-designer-preview" class="<?php echo $selected_layout['container_classes']; ?>">
						<div class="fpd-product" title="Front" data-thumbnail="<?php echo plugins_url('/img/shirt-preview.png', __FILE__); ?>">
							<img title="demo-shirt" src="<?php echo plugins_url('/img/shirt-preview.png', __FILE__); ?>" data-parameters='{"autoCenter": true}' />
							<div class="fpd-product" title="Back" data-thumbnail="<?php echo plugins_url('/img/shirt-preview.png', __FILE__); ?>">
								<img  title="demo-shirt" src="<?php echo plugins_url('/img/shirt-preview.png', __FILE__); ?>" data-parameters='{"autoCenter": true}' />
							</div>
						</div>
					</div>

				</div>
				<div id="fpd-composer-toolbar" class="fpd-panel">

					<div class="radykal-tabs">
						<div class="radykal-tabs-nav">
							<a href="layout" class="current"><?php _e('Layout', 'radykal'); ?></a>
							<a href="modules"><?php _e('Modules', 'radykal'); ?></a>
							<a href="actions"><?php _e('Actions', 'radykal'); ?></a>
							<a href="colors"><?php _e('Colors', 'radykal'); ?></a>
							<a href="custom-css"><?php _e('Custom CSS', 'radykal'); ?></a>
						</div>

						<div class="radykal-tabs-content radykal-form">

							<div data-id="layout" class="current">

								<div class="radykal-columns-two">

									<div>
										<h4><?php _e('Main Bar', 'radykal'); ?></h4>
										<div class="radykal-form-group radykal-columns-three" id="fpd-mainbar-layout">

											<div>
												<label for="layout-topbar" class="radykal-checkbox-image">
													<input type="radio" name="layout" value="fpd-topbar" id="layout-topbar" class="radykal-hidden" checked="">
													<i><?php _e('Top Bar', 'radykal') ?></i>
													<img src="<?php echo plugins_url('/img/topbar.png', __FILE__); ?>" alt="" />
												</label>
											</div>

											<div>
												<label for="layout-sidebar" class="radykal-checkbox-image">
													<input type="radio" name="layout" value="fpd-sidebar fpd-tabs" id="layout-sidebar" class="radykal-hidden">
													<i><?php _e('Side Bar Left', 'radykal') ?></i>
													<img src="<?php echo plugins_url('/img/sidebar-left.png', __FILE__); ?>" alt="" />
												</label>
											</div>

											<div>
												<label for="layout-sidebar-right" class="radykal-checkbox-image">
													<input type="radio" name="layout" value="fpd-sidebar fpd-sidebar-right fpd-tabs" id="layout-sidebar-right" class="radykal-hidden">
													<i><?php _e('Side Bar Right', 'radykal') ?></i>
													<img src="<?php echo plugins_url('/img/sidebar-right.png', __FILE__); ?>" alt="" />
												</label>
											</div>

										</div><!-- main bar -->

										<h4><?php _e('Side Bar Tabs Position', 'radykal'); ?></h4>
										<div class="radykal-form-group radykal-columns-two" id="fpd-sidebar-tabs-position">

											<div>
												<label for="sidebar-tabs-left" class="radykal-checkbox-image">
													<input type="radio" name="sidebar_tabs_position" value="fpd-tabs-side" id="sidebar-tabs-left" class="radykal-hidden" checked="">
													<i><?php _e('Tabs Side', 'radykal') ?></i>
													<img src="<?php echo plugins_url('/img/sidebar-tabs-left.png', __FILE__); ?>" alt="" />
												</label>
											</div>
											<div>
												<label for="sidebar-tabs-top" class="radykal-checkbox-image">
													<input type="radio" name="sidebar_tabs_position" value="fpd-tabs-top" id="sidebar-tabs-top" class="radykal-hidden">
													<i><?php _e('Tabs Top', 'radykal') ?></i>
													<img src="<?php echo plugins_url('/img/sidebar-tabs-top.png', __FILE__); ?>" alt="" />
												</label>
											</div>

										</div><!-- side bar tabs position -->

									</div><!-- first col in layout -->

									<div>

										<div class="radykal-columns-two">

											<div class="radykal-form-group">
												<h4><?php _e('Dimensions', 'radykal'); ?></h4>
												<label for="stageWidth">
													<i><?php _e('Stage Width', 'radykal') ?>:</i>
													<input type="number" id="stageWidth" value="<?php echo $selected_layout['plugin_options']['stageWidth']; ?>" />
												</label>
												<label for="stageHeight">
													<i><?php _e('Stage Height', 'radykal') ?>:</i>
													<input type="number" id="stageHeight" value="<?php echo $selected_layout['plugin_options']['stageHeight']; ?>" />
												</label>
											</div>

											<div class="radykal-form-group">
												<h4><?php _e('Container Shadow', 'radykal'); ?></h4>
												<select name="shadow" >
													<?php
													foreach(FPD_Settings_General::get_frame_shadows() as $key => $shadow) {
														echo '<option value="'.$key.'">'.$shadow.'</option>';
													}
													?>
												</select>
											</div>

										</div>

										<div class="radykal-columns-two">

											<div class="radykal-form-group">
												<h4>
													<?php _e('Image Grid Columns', 'radykal'); ?>
													<br />
													<span class="description"><?php _e('Used in products & designs module', 'radykal'); ?></span>
												</h4>
												<select name="grid_columns">
													<option value="1"><?php _e('One', 'radykal'); ?></option>
													<option value="2"><?php _e('Two', 'radykal'); ?></option>
													<option value="3"><?php _e('Three', 'radykal'); ?></option>
													<option value="4"><?php _e('Four', 'radykal'); ?></option>
													<option value="5"><?php _e('Five', 'radykal'); ?></option>
												</select>
											</div>

											<div class="radykal-form-group">
												<h4><?php _e('Initial Active Module', 'radykal'); ?></h4>
												<select name="initial_active_module">
													<option value=""><?php _e('None', 'radykal'); ?></option>
												</select>
											</div>

										</div>

										<div class="radykal-form-group radykal-radio-group-inline">
											<h4><?php _e('View Selection Position', 'radykal'); ?></h4>
											<label>
												<input type="radio" name="views_selection_pos" value="fpd-views-inside-top" >
												<i><?php _e('Inside Top', 'radykal'); ?></i>
											</label>
											<label>
												<input type="radio" name="views_selection_pos" value="fpd-views-inside-right" >
												<i><?php _e('Inside Right', 'radykal'); ?></i>
											</label>
											<label>
												<input type="radio" name="views_selection_pos" value="fpd-views-inside-bottom" >
												<i><?php _e('Inside Bottom', 'radykal'); ?></i>
											</label>
											<label>
												<input type="radio" name="views_selection_pos" value="fpd-views-inside-left" checked="" >
												<i><?php _e('Inside Left', 'radykal'); ?></i>
											</label>
											<label>
												<input type="radio" name="views_selection_pos" value="fpd-views-outside" >
												<i><?php _e('Outside', 'radykal'); ?></i>
											</label>
										</div>

									</div><!-- second col in layout -->

								</div>

							</div><!-- layout content -->

							<div data-id="modules">

								<div class="radykal-columns-two">

									<div>

										<h4><?php _e('Your Selected Modules', 'radykal'); ?></h4>
										<p class="description"><?php _e('These modules will be visible in your main navigation.', 'radykal'); ?></p>
										<div class="radykal-segment">
											<div class="radykal-dropzone" data-zone="top">
												<span class="radykal-dropzone-placeholder"><?php _e('Drop Modules Here', 'radykal'); ?></span>
											</div>
										</div>
										<p>
											<i class="dashicons dashicons-info"></i>
											<span class="description"><?php _e('Double-click on an item to remove it from the dropzone.', 'radykal'); ?></span>
										</p>

									</div><!-- left col in modules -->

									<div>

										<h4><?php _e('Available Modules', 'radykal'); ?></h4>
										<p class="description"><?php _e('Drag desired modules to dropzone.', 'radykal'); ?></p>
										<div class="radykal-segment" id="fpd-available-modules"></div>

									</div><!-- right col  in modules -->

								</div>

							</div>

							<div data-id="actions">

								<div class="radykal-columns-two">

									<div>

										<h4><?php _e('Your Selected Actions', 'radykal'); ?></h4>
										<div id="fpd-actions-dropzones" class="radykal-segment">

											<div class="radykal-dropzone" data-zone="top">
												<span class="radykal-dropzone-placeholder"><?php _e('Drop Actions here', 'radykal'); ?></span>
											</div>

											<div class="radykal-dropzone" data-zone="right">
												<span class="radykal-dropzone-placeholder"><?php _e('Drop Actions here', 'radykal'); ?></span>
											</div>

											<div class="radykal-dropzone" data-zone="bottom">
												<span class="radykal-dropzone-placeholder"><?php _e('Drop Actions here', 'radykal'); ?></span>
											</div>

											<div class="radykal-dropzone" data-zone="left">
												<span class="radykal-dropzone-placeholder"><?php _e('Drop Actions here', 'radykal'); ?></span>
											</div>

										</div>
										<p>
											<i class="dashicons dashicons-info"></i>
											<span class="description"><?php _e('Double-click on an item to remove it from the dropzone.', 'radykal'); ?></span>
										</p>

									</div><!-- left col in actions -->

									<div>

										<div class="radykal-form-group">
											<h4><?php _e('Available Actions', 'radykal'); ?></h4>
											<div class="radykal-segment" id="fpd-available-actions"></div>
											<p class="description"><?php _e('Drag desired actions to dropzone', 'radykal'); ?></p>
										</div>

										<div id="fpd-actions-alignment">
											<h4><?php _e('Alignment', 'radykal'); ?></h4>
											<div class="radykal-segment">
												<div>
													<i><?php _e('Top Actions', 'radykal'); ?></i>
													<label>
														<input type="radio" name="top_actions_align" class="fpd-class-toggle-radio" checked="" value="" ><?php _e('Left', 'radykal'); ?>
													</label>
													<label>
														<input type="radio" name="top_actions_align" class="fpd-class-toggle-radio" value="fpd-top-actions-centered"><?php _e('Center', 'radykal'); ?>
													</label>
												</div>
												<div>
													<i><?php _e('Right Actions', 'radykal'); ?></i>
													<label>
														<input type="radio" name="right_actions_align" class="fpd-class-toggle-radio" checked="" value="" ><?php _e('Top', 'radykal'); ?>
													</label>
													<label>
														<input type="radio" name="right_actions_align" class="fpd-class-toggle-radio" value="fpd-right-actions-centered"><?php _e('Center', 'radykal'); ?>
													</label>
												</div>
												<div>
													<i><?php _e('Bottom Actions', 'radykal'); ?></i>
													<label>
														<input type="radio" name="bottom_actions_align" class="fpd-class-toggle-radio" checked="" value="" ><?php _e('Left', 'radykal'); ?>
													</label>
													<label>
														<input type="radio" name="bottom_actions_align" class="fpd-class-toggle-radio" value="fpd-bottom-actions-centered"><?php _e('Center', 'radykal'); ?>
													</label>
												</div>
												<div>
													<i><?php _e('Left Actions', 'radykal'); ?></i>
													<label>
														<input type="radio" name="left_actions_align" class="fpd-class-toggle-radio" checked="" value="" ><?php _e('Top', 'radykal'); ?>
													</label>
													<label>
														<input type="radio" name="left_actions_align" class="fpd-class-toggle-radio" value="fpd-left-actions-centered"><?php _e('Center', 'radykal'); ?>
													</label>
												</div>
											</div>
										</div>

									</div><!-- right col in actions -->

								</div>

							</div>

							<div data-id="colors">

								<h4><?php _e('Create an own color scheme.', 'radykal'); ?></h4>
								<div class="radykal-columns-two radykal-segment">

									<div>
										<div>
											<p class="description"><?php _e('Primary', 'radykal'); ?></p>
											<input type="text" name="primary_color" class="fpd-color-picker" value="<?php echo $selected_layout['css_colors']['primary_color']; ?>" />
										</div>
										<div>
											<p class="description"><?php _e('Secondary', 'radykal'); ?></p>
											<input type="text" name="secondary_color" class="fpd-color-picker" value="<?php echo $selected_layout['css_colors']['secondary_color']; ?>" />
										</div>
										<div>
											<p class="description"><?php _e('Element Boundary', 'radykal'); ?></p>
											<input type="text" name="element_boundary_color" class="fpd-color-picker" value="<?php echo $selected_layout['plugin_options']['selectedColor']; ?>" />
										</div>
									</div>
									<div>
										<div>
											<p class="description"><?php _e('Bounding Box', 'radykal'); ?></p>
											<input type="text" name="bounding_box_color" class="fpd-color-picker" value="<?php echo $selected_layout['plugin_options']['boundingBoxColor']; ?>" />
										</div>
										<div>
											<p class="description"><?php _e('Out Of Bounding Box', 'radykal'); ?></p>
											<input type="text" name="out_of_bounding_box_color" class="fpd-color-picker" value="<?php echo $selected_layout['plugin_options']['outOfBoundaryColor']; ?>" />
										</div>
										<div>
											<p class="description"><?php _e('Corner Control Icons', 'radykal'); ?></p>
											<input type="text" name="corner_control_icons_color" class="fpd-color-picker" value="<?php echo $selected_layout['plugin_options']['cornerIconColor']; ?>" />
										</div>
									</div>

								</div>
								<button class="button-secondary radykal-disabled" id="fpd-update-preview"><?php _e('Update Preview', 'radykal'); ?></button>
								<div class="fpd-ui-blocker"></div>

							</div>

							<div data-id="custom-css">
								<h4><?php _e('You can add custom CSS styles to the pages where the product designer is included.', 'radykal'); ?></h4>
								<span><?php _e('Helpful CSS classes:', 'radykal'); ?></span>
								<ul>
									<li><code>.fpd-container</code> - <?php _e('The product designer container.', 'radykal'); ?></li>
									<li><code>.fpd-product-designer-wrapper</code> - <?php _e('Wrapper around the product designer container.', 'radykal'); ?></li>
									<li><code>.fpd-mainbar</code> - <?php _e('The main bar container.', 'radykal'); ?></li>
								</ul>
								<div class="radykal-segment">
									<div class="radykal-ace-editor" id="fpd-custom-css"><?php echo $selected_layout['custom_css']; ?></div>
								</div>

							</div>

						</div><!-- tabs content -->

					</div> <!-- radykal tabs -->

					<form class="radykal-hidden" method="post">
						<?php wp_nonce_field( 'fpd_save_layout'); ?>
						<input type="text" name="fpd_selected_layout" value="" />
						<input type="text" name="fpd_method" value="" />
						<textarea name="fpd_ui_layout" class="large-text"></textarea>
					</form>


				</div><!-- composer toolbar -->

			</div>
			<?php

		}

		public static function get_layouts() {

			global $wpdb;
			return $wpdb->get_results( $wpdb->prepare("SELECT * FROM {$wpdb->options} WHERE option_name LIKE %s", "fpd_ui_layout_%") );

		}

		public static function get_layout( $id='' ) {

			if( get_option('fpd_ui_layout_'.$id) !== false ) {
				return json_decode( stripslashes(get_option('fpd_ui_layout_'.$id)), true);
			}
			else if( get_option('fpd_ui_layout_default') !== false ) {
				return json_decode( stripslashes(get_option('fpd_ui_layout_default') ), true);
			}
			else {

				$default_layout = file_get_contents(FPD_PLUGIN_DIR.'/assets/default_ui_layout.json');
				$default_layout = json_encode(json_decode($default_layout));
				update_option('fpd_ui_layout_default', $default_layout);

				return json_decode($default_layout, true);

			}

		}

		public static function get_css_from_layout( $layout ) {

			if( isset($layout->css) && !empty($layout->css) ) {

				return $layout->css;

			}
			else {

				if( is_array($layout) )
					$layout = json_decode(json_encode($layout)); //convert array to stdclass

				$primary_color = @$layout->css_colors && @$layout->css_colors->primary_color ? $layout->css_colors->primary_color : '#000000';
				$secondary_color = @$layout->css_colors && @$layout->css_colors->secondary_color ? $layout->css_colors->secondary_color : '#27ae60';
				$css_result = FPD_UI_Layout_Composer::parse_css('@primaryColor: '.$primary_color.'; @secondaryColor: '.$secondary_color.';');

				if( !is_array($css_result) ) {

					$layout_id = sanitize_key($layout->name);
					$layout->css = $css_result;
					update_option( 'fpd_ui_layout_'.$layout_id, addslashes(json_encode($layout)) );

					return $css_result;

				}
				else {
					return '';
				}
			}

		}

		public static function parse_css( $parse_str='' ) {

			if( !class_exists('Less_Parser') )
				require_once(FPD_PLUGIN_ADMIN_DIR.'/inc/less/Less.php');

			$less_file = FPD_PLUGIN_ADMIN_DIR.'/less/colors.less';
			try {

				$options = array( 'compress'=>true );
				$parser = new Less_Parser($options);
				$parser->parseFile( $less_file );
				$parser->parse( $parse_str );
				return $parser->getCss(); //save ins json

			}
			catch(Exception $e){

				return array(
					'message' => $e->getMessage(),
					'type'    => 'error'
				);

			}

		}

		public static function reset_to_default( $id='' ) {

			$default_layout = file_get_contents(FPD_PLUGIN_DIR.'/assets/default_ui_layout.json');
			$default_layout = json_decode(stripslashes($default_layout), true);

			if( get_option('fpd_ui_layout_'.$id) !== false ) {

				$old_layout = get_option('fpd_ui_layout_'.$id);
				$old_layout = json_decode( stripslashes($old_layout), true );
				$default_layout['name'] = empty($old_layout['name']) ? 'Default' : $old_layout['name'];

			}

			update_option('fpd_ui_layout_'.$id, json_encode($default_layout));

		}

	}

}

?>