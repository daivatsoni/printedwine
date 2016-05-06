<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if( !class_exists('FPD_Settings_General') ) {

	class FPD_Settings_General {

		public static function get_options() {

			return apply_filters('fpd_general_settings', array(

				'general-product-designer' => array(

					array(
						'title' 	=> __( 'Main UI Layout', 'radykal' ),
						'description' 		=> sprintf( __( 'Create and customize UI layouts with the <a href="%s" %s>Composer</a>.', 'radykal' ), 'admin.php?page=fpd_ui_layout_composer', 'style="font-weight: bold;"'),
						'id' 		=> 'fpd_product_designer_ui_layout',
						'default'	=> 'default',
						'type' 		=> 'select',
						'class'		=> 'radykal-select2',
						'css'		=> 'width: 200px',
						'options'   => self::get_saved_ui_layouts()
					),

					array(
						'title' 	=> __( 'Open Product Designer in...', 'radykal' ),
						'description' 		=> __( 'By default the product designer will display while page is loading. But you can also display it in a lightbox or in the page after the user clicks on a button.', 'radykal' ),
						'id' 		=> 'fpd_product_designer_visibility',
						'default'	=> 'page',
						'type' 		=> 'radio',
						'options'   => self::get_product_designer_visibilities()
					),

					array(
						'title' 	=> __( 'Main Bar Position', 'radykal' ),
						'description' 		=> __( 'You can set a custom position for the main bar. Only sidebar layouts can be used with a custom position.', 'radykal' ),
						'id' 		=> 'fpd_main_bar_position',
						'css' 		=> 'min-width:350px;',
						'default'	=> 'default',
						'type' 		=> 'radio',
						'options'   => self::get_main_bar_positions()
					),

					array(
						'title' 	=> __( 'Customiazion Required', 'radykal' ),
						'description' 		=> __( 'The user must customize the initial elements of a Fancy Product in order to proceed.', 'radykal' ),
						'id' 		=> 'fpd_customization_required',
						'default'	=> 'no',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'Replace Initial Elements', 'radykal' ),
						'description'	 	=> __( 'When changing the main product, replace only the initial elements of the Fancy Product. Custom-added elements will remain on the canvas.', 'radykal' ),
						'id' 		=> 'fpd_replace_initial_elements',
						'default'	=> 'no',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'Lazy Load', 'radykal' ),
						'description'	 	=> __( 'Enable lazy loading for the images in the products and designs containers.', 'radykal' ),
						'id' 		=> 'fpd_lazy_load',
						'default'	=> 'yes',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'Improved Image Resize Quality', 'radykal' ),
						'description'	 	=> __( 'Enable a filter that improves the quality of a resized bitmap image. This could take a long time for large images.', 'radykal' ),
						'id' 		=> 'fpd_improvedResizeQuality',
						'default'	=> 'no',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'Responsive', 'radykal' ),
						'description'	 	=> __( 'Resizes the canvas and all elements in the canvas, so that all elements are displaying properly in the canvas container. This is useful, when your canvas (stage) is larger than the available space in the parent container.', 'radykal' ),
						'id' 		=> 'fpd_responsive',
						'default'	=> 'yes',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'Upload zones always on top', 'radykal' ),
						'description'	 	=> __( 'Upload zones will be always on top of all elements.', 'radykal' ),
						'id' 		=> 'fpd_uploadZonesTopped',
						'default'	=> 'yes',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'Hide On Smartphones', 'radykal' ),
						'description'	 	=> sprintf(__( 'Hide product designer on smartphones and display an <a href="%s">information</a> instead.', 'radykal'), esc_url(admin_url('admin.php?page=fpd_settings&tab=labels#not_supported_device_info')) ),
						'id' 		=> 'fpd_disable_on_smartphones',
						'default'	=> 'no',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'Hide On Tablets', 'radykal' ),
						'description'	 	=> sprintf(__( 'Hide product designer on tablets and display an <a href="%s">information</a> instead.', 'radykal' ), esc_url(admin_url('admin.php?page=fpd_settings&tab=labels#not_supported_device_info')) ),
						'id' 		=> 'fpd_disable_on_tablets',
						'default'	=> 'no',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'Unsaved Customizations Alert', 'radykal' ),
						'description'	 => __( 'The user will see a notification alert when he leaves the page without saving or adding the product to the cart.', 'radykal' ),
						'id' 		=> 'fpd_unsaved_customizations_alert',
						'default'	=> 'no',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' => __( 'Zoom-Action: Step', 'radykal' ),
						'description' 		=> __( 'The step for zooming in and out.', 'radykal' ),
						'id' 		=> 'fpd_zoom_step',
						'css' 		=> 'width:60px;',
						'default'	=> '0.2',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 0.1
						)
					),

					array(
						'title' => __( 'Zoom-Action: Maximum', 'radykal' ),
						'description' 		=> __( 'The maximum zoom when zooming in.', 'radykal' ),
						'id' 		=> 'fpd_max_zoom',
						'css' 		=> 'width:60px;',
						'default'	=> '3',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 1,
							'step' 	=> 0.1
						)
					),

					array(
						'title' => __( 'Text Control Padding', 'radykal' ),
						'description' 		=> __( 'The padding of the corner controls when a text element is selected.', 'radykal' ),
						'id' 		=> 'fpd_padding_controls',
						'css' 		=> 'width:60px;',
						'default'	=> '10',
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' => __( 'Watermark Image', 'radykal' ),
						'description' 		=> __( 'Set a watermark image that will be added when the user downloads or prints the product. If the WooCommerce product is downloadable, the watermark will be removed when the customer downloads/prints the completed order.', 'radykal' ),
						'id' 		=> 'fpd_watermark_image',
						'css' 		=> 'width:500px;',
						'default'	=> '',
						'type' 		=> 'upload'
					),

					array(
						'title' => __( 'Button CSS Classes', 'radykal' ),
						'description' 		=> __( 'These CSS clases will be added e.g. to the customisation button. Add class names without the dot.', 'radykal' ),
						'id' 		=> 'fpd_start_customizing_css_class',
						'css' 		=> 'width:500px;',
						'default'	=> 'fpd-blue-btn',
						'type' 		=> 'text'
					),


				), //layout-skin

				'custom-images' => array(

					array(
						'title' => __( 'Save On Server', 'radykal' ),
						'id' 		=> 'fpd_type_of_uploader',
						'default'	=> 'php',
						'type' 		=> 'radio',
						'description'	=>  __( 'If your customers can add multiple or large images, then save images on server, otherwise you may inspect some issues when adding the customized product to the cart. The images will be saved in wp-content/uploads/fancy_products_uploads/ directory.', 'radykal' ),
						'options'	=> array(
							'filereader' => __( 'No', 'radykal' ),
							'php' => __( 'Yes', 'radykal' )
						),
						'relations' => array(
							'filereader' => array(
								'fpd_upload_designs_php_logged_in' => false,
							),
							'php' => array(
								'fpd_upload_designs_php_logged_in' => true,
							)
						)
					),

					array(
						'title' 	=> __( 'Login Required', 'radykal' ),
						'description'	 	=> __( 'Users must create an account in your Wordpress site and need to be logged-in to upload images.', 'radykal' ),
						'id' 		=> 'fpd_upload_designs_php_logged_in',
						'default'	=> 'no',
						'type' 		=> 'checkbox'
					),

					array(
						'title' => __( 'Facebook App-ID', 'radykal' ),
						'description' 		=> __( 'Enter a Facebook App-ID to enable Facebook photos in the images module.', 'radykal' ),
						'id' 		=> 'fpd_facebook_app_id',
						'css' 		=> 'width:500px;',
						'default'	=> '',
						'type' 		=> 'text'
					),

					array(
						'title' => __( 'Instagram Client ID', 'radykal' ),
						'description' 		=> __( 'Enter an Instagram Client ID to enable Instagram photos in the images module.', 'radykal' ),
						'id' 		=> 'fpd_instagram_client_id',
						'css' 		=> 'width:500px;',
						'default'	=> '',
						'type' 		=> 'text'
					),

					array(
						'title' => __( 'Instagram Redirect URI', 'radykal' ),
						'description' 		=> __( 'This is the URI you need to paste into the "OAuth Redirect URI" input when creating a Instagram Client ID. Do not change it!', 'radykal' ),
						'id' 		=> 'fpd_instagram_redirect_uri',
						'css' 		=> 'width:500px;',
						'default'	=> plugins_url( '/inc/instagram_auth.php', dirname(__FILE__) ),
						'type' 		=> 'text'
					),

				),//custom-images

				'sharing' => array(

					array(
						'title' => __( 'Design Share', 'radykal' ),
						'description' 		=> __( 'Allow users to share their designs on social networks.', 'radykal' ),
						'id' 		=> 'fpd_sharing',
						'default'	=> 'no',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'Yes', 'radykal' ),
							'no'	 => __( 'No', 'radykal' ),
						)
					),

					array(
						'title' => __( 'Cache Days', 'radykal' ),
						'description' 		=> __( 'Whenever an user shares a design, an image and database entry will be created. To delete this data after a certain period of time, you can set the days of caching. A value of 0 will store the data forever.', 'radykal' ),
						'id' 		=> 'fpd_sharing_cache_days',
						'default'	=> 5,
						'type' 		=> 'number',
						'custom_attributes' => array(
							'min' 	=> 0,
							'step' 	=> 1
						)
					),

					array(
						'title' => __( 'Social Networks', 'radykal' ),
						'id' 		=> 'fpd_sharing_social_networks',
						'css' 		=> 'width:300px;',
						'default'	=> array('facebook', 'twitter', 'googleplus', 'email'),
						'type' 		=> 'multiselect',
						'class'		=> 'radykal-select2',
						'options'   => array(
							"facebook" => 'Facebook',
							"twitter" => 'Twitter',
							"googleplus" => 'Google Plus',
							"linkedin" => 'Linkedin',
							"pinterest" => 'Pinterest',
							"email" => 'Email',
						)
					),

				),

				'troubleshooting' => array(

					array(
						'title' 	=> __( 'Debug Mode', 'radykal' ),
						'description' 		=> __( 'Enables Theme-Check modal and loads the unminified Javascript files.', 'radykal' ),
						'id' 		=> 'fpd_debug_mode',
						'default'	=> 'no',
						'type' 		=> 'radio',
						'options'   => array(
							'yes'	 => __( 'On', 'radykal' ),
							'no'	 => __( 'Off', 'radykal' ),
						)
					),

					array(
						'title' 	=> __( 'jQuery No Conflict Mode', 'radykal' ),
						'description' 		=> __( 'Turns on the jQuery no conflict mode. Turn it on if you are facing some Javascript issues.', 'radykal' ),
						'id' 		=> 'fpd_jquery_no_conflict',
						'default'	=> 'off',
						'type' 		=> 'radio',
						'options'   => array(
							'on'	 => __( 'On', 'radykal' ),
							'off'	 => __( 'Off', 'radykal' ),
						)
					),

				),

			));
		}

		public static function get_saved_ui_layouts() {

			$saved_layouts = FPD_UI_Layout_Composer::get_layouts();

			if(sizeof($saved_layouts) == 0) {

				return array(
					'default' => __('Default', 'radykal')
				);

			}

			$layouts = array();
			foreach($saved_layouts as $saved_layout) {

				$id = str_replace('fpd_ui_layout_', '', $saved_layout->option_name);
				$name = json_decode(stripslashes($saved_layout->option_value), true);
				$layouts[$id] = $name['name'];

			}

			return $layouts;
		}

		public static function get_product_designer_visibilities() {

			$values = array(
				'page'	=> __( 'Page', 'radykal' ),
				'lightbox'	=> __( 'Lightbox', 'radykal' ),
				'page-customize'	=> __( 'Page after user clicks on the customization button', 'radykal' ),
			);

			return $values;

		}

		public static function get_main_bar_positions() {

			$positions = array(
				'default'	=> __( 'Default', 'radykal' ),
				'shortcode'	=> __( 'Via Shortcode: [fpd_main_bar]', 'radykal' )
			);

			if( function_exists('get_woocommerce_currency') ) {
				$positions['after_product_title']	=  __( 'After Product Title (WooCommerce)', 'radykal' );
				$positions['after_excerpt'] 	=  __( 'After Product Excerpt (WooCommerce)', 'radykal' );
			}

			return $positions;

		}

		public static function get_bounding_box_modi() {

			return array(
				'inside' => __('Inside', 'radyal'),
				'clipping' => __('Clipping', 'radyal'),
				'limitModify' => __('Limit Modification', 'radyal'),
				'none' => __('None', 'radyal'),
			);

		}


		/**
		 * Get the available frame shadows.
		 *
		 */
		public static function get_frame_shadows() {

			return array(
				'fpd-shadow-1'	 => __( 'Shadow 1', 'radykal' ),
				'fpd-shadow-2'	 => __( 'Shadow 2', 'radykal' ),
				'fpd-shadow-3'	 => __( 'Shadow 3', 'radykal' ),
				'fpd-shadow-4'	 => __( 'Shadow 4', 'radykal' ),
				'fpd-shadow-5'	 => __( 'Shadow 5', 'radykal' ),
				'fpd-shadow-7'	 => __( 'Shadow 6', 'radykal' ),
				'fpd-no-shadow'	 => __( 'No Shadow ', 'radykal' ),
			);

		}

	}
}

?>