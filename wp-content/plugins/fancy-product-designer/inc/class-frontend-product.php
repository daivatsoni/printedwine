<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if(!class_exists('FPD_Frontend_Product')) {

	class FPD_Frontend_Product {

		private $form_views = null;
		private $remove_watermark = false;

		public function __construct() {

			require_once(FPD_PLUGIN_DIR.'/inc/class-parameters.php');
			require_once(FPD_PLUGIN_DIR.'/inc/class-share.php');

			add_action( 'wp_head', array( &$this, 'head_frontend') );

			//CATALOG
			$catalog_button_pos = fpd_get_option('fpd_catalog_button_position');
			if(  $catalog_button_pos == 'fpd-replace-add-to-cart' ) {
				add_filter( 'woocommerce_loop_add_to_cart_link', array(&$this, 'add_to_cart_shop_link'), 10, 2 );
			}
			else {
				add_action( 'woocommerce_after_shop_loop_item', array(&$this, 'add_catalog_customize_button'), 20 );
			}

			//SINGLE FANCY PRODUCT
			add_filter( 'body_class', array( &$this, 'add_fancy_product_class') );
			add_filter( 'woocommerce_product_single_add_to_cart_text', array( &$this, 'add_to_cart_text'), 20, 2 );

			//before product container
			add_action( 'woocommerce_before_single_product', array( &$this, 'before_product_container'), 1 );

			//add customize button
			if( fpd_get_option('fpd_start_customizing_button_position') == 'under-short-desc' ) {
				add_action( 'woocommerce_single_product_summary', array( &$this, 'add_customize_button'), 25 );
			}
			else {
				add_action( 'woocommerce_after_add_to_cart_button', array( &$this, 'add_customize_button'), 0 );
			}

			//add additional form fields to cart form
			add_action( 'woocommerce_before_add_to_cart_button', array( &$this, 'add_product_designer_form') );
			//php uploader - image upload
			add_action( 'wp_ajax_fpduploadimage', array( &$this, 'upload_image' ) );
			if( fpd_get_option('fpd_upload_designs_php_logged_in') == 0 ) {
				add_action( 'wp_ajax_nopriv_fpduploadimage', array( &$this, 'upload_image' ) );
			}

			//order via shortcode
			add_shortcode( 'fpd', array( &$this, 'fpd_shortcode_handler') );
			add_shortcode( 'fpd_form', array( &$this, 'fpd_form_shortcode_handler') );
			add_action( 'wp_ajax_fpd_newshortcodeorder', array( &$this, 'create_shortcode_order' ) );
			add_action( 'wp_ajax_nopriv_fpd_newshortcodeorder', array( &$this, 'create_shortcode_order' ) );

		}

		public function head_frontend() {

			if( !is_admin() ) {

				global $post;
				if( isset($post->ID) && is_fancy_product( $post->ID ) ) {

					$product_settings = new FPD_Product_Settings( $post->ID );
					$main_bar_pos = $product_settings->get_option('main_bar_position');
					if( $main_bar_pos === 'shortcode' ) {
						add_shortcode( 'fpd_main_bar', array( &$this, 'return_main_bar_container') );
					}
					else if( $main_bar_pos === 'after_product_title' ) {
						add_action( 'woocommerce_single_product_summary', array( &$this, 'add_main_bar_container'), 7 );
					}
					else if( $main_bar_pos === 'after_excerpt' ) {
						add_action( 'woocommerce_single_product_summary', array( &$this, 'add_main_bar_container'), 25 );
					}

				}

			}

		}

		//custom text for the add-to-cart button in single page
		public function add_to_cart_text( $text, $product ) {

			if( is_fancy_product( $product->id ) ) {

				$product_settings = new FPD_Product_Settings( $product->id );

				if( is_product() ) { //only change text if on single product page and get quote is enabled
					if( $product_settings->get_option('get_quote') )
						return FPD_Settings_Labels::get_translation( 'misc', 'get_a_quote' );
				}

			}

			return $text;

		}

		//custom add-to-cart button in catalog
		public function add_to_cart_shop_link( $handler, $product ) {

			if( is_fancy_product( $product->id ) ) {

				$product_settings = new FPD_Product_Settings( $product->id );

				return sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="button product_type_%s">%s</a>',
					esc_url( get_permalink($product->id) ),
					esc_attr( $product->id ),
					esc_attr( $product->get_sku() ),
					esc_attr( $product->product_type ),
					esc_html( $product_settings->get_add_to_cart_text() )
				);
			}

			return $handler;

		}

		//add customize button add the end of catalog item
		public function add_catalog_customize_button() {

			global $product;

			if( is_fancy_product( $product->id ) ) {

				$product_settings = new FPD_Product_Settings( $product->id );

				printf( '<a href="%s" rel="nofollow" class="button" style="width: 100%%; margin: 10px 0;">%s</a>',
					esc_url( get_permalink($product->id) ),
					esc_html( $product_settings->get_add_to_cart_text() )
				);

			}

		}

		//add fancy-product class in body
		public function add_fancy_product_class( $classes ) {

			global $post;

			if( isset($post->ID) && is_fancy_product( $post->ID ) ) {

				$product_settings = new FPD_Product_Settings( $post->ID );

				$classes[] = 'fancy-product';

				if( $product_settings->customize_button_enabled ) {
					$classes[] = 'fpd-customize-button-visible';
				}
				else {
					$classes[] = 'fpd-customize-button-hidden';
				}

				//check if tablets are supported
				if( fpd_get_option( 'fpd_disable_on_tablets' ) )
					$classes[] = 'fpd-hidden-tablets';

				//check if smartphones are supported
				if( fpd_get_option( 'fpd_disable_on_smartphones' ) )
					$classes[] = 'fpd-hidden-smartphones';

				if( $product_settings->get_option( 'fullwidth_summary' ) )
					$classes[] = 'fpd-fullwidth-summary';

				if( $product_settings->get_option('hide_product_image') )
					$classes[] = 'fpd-product-images-hidden';

				if( $product_settings->get_option('get_quote') )
					$classes[] = 'fpd-get-quote-enabled';

				if( fpd_get_option('fpd_customization_required') )
					$classes[] = 'fpd-customization-required';

			}

			return $classes;

		}

		public function before_product_container() {

			global $post;

			if( is_fancy_product( $post->ID ) ) {

				//add product designer
				$product_settings = new FPD_Product_Settings( $post->ID );
				$position = $product_settings->get_option('placement');

				if( $position  == 'fpd-replace-image') {
					add_action( 'woocommerce_before_single_product_summary', array( &$this, 'add_product_designer'), 15 );
				}
				else if( $position  == 'fpd-under-title') {
					add_action( 'woocommerce_single_product_summary', array( &$this, 'add_product_designer'), 6 );
				}
				else if( $position  == 'fpd-after-summary') {
					add_action( 'woocommerce_after_single_product_summary', array( &$this, 'add_product_designer'), 1 );
				}
				else {
					add_action( 'fpd_product_designer', array( &$this, 'add_product_designer') );
				}

				//remove product image, there you gonna see the product designer
				if( $product_settings->get_option('hide_product_image') || ($position == 'fpd-replace-image' && (!$product_settings->customize_button_enabled)) ) {
					remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
				}

			}
		}

		//add a main bar container
		public function add_main_bar_container( $output_type = 'echo' ) {

			if($output_type === 'return') {
				return '<div class="fpd-main-bar-position"></div>';
			}
			else {
				echo '<div class="fpd-main-bar-position"></div>';
			}

		}

		//return main bar container
		public function return_main_bar_container() {
			return $this->add_main_bar_container('return');
		}

		//the actual product designer will be added
		public function add_product_designer() {

			global $post;

			$product_settings = new FPD_Product_Settings( $post->ID );
			$visibility = $product_settings->get_option('product_designer_visibility');

			do_action('fpd_before_product_designer', $post->ID);

			if( $product_settings->show_designer() ) {

				FPD_Scripts_Styles::$add_script = true;
				$selector = 'fancy-product-designer-'.$product_settings->master_id.'';

				//get availabe fonts
				$available_fonts = $product_settings->get_option('font_families[]') === false ? FPD_Fonts::get_enabled_fonts() : $product_settings->get_option('font_families[]');

				if( !is_array($available_fonts) )
					$available_fonts = str_split($available_fonts, strlen($available_fonts));

				//make default font
				$default_font = 'Arial';
				$db_default_font = fpd_get_option('fpd_font');
				if( !empty($db_default_font) )
					$default_font = $db_default_font;
				else if( $available_fonts && !empty($available_fonts) ) {
					$available_fonts_values = array_values($available_fonts);
					$default_font = array_shift($available_fonts_values); //get first array element
				}

				//output woocommerce related markup
				if( get_post_type( $post ) === 'product' ) {
					$this->output_wc_start();
				}

				//load product from share
				if( isset($_GET['share_id']) ) {

					$transient_key = 'fpd_share_'.$_GET['share_id'];
					$transient_val = get_transient($transient_key);
					if($transient_val !== false)
						$this->form_views = stripslashes($transient_val['product']);

				}

				//get assigned categories/products
				$fancy_content_ids = fpd_has_content( $product_settings->master_id );
				$fancy_content_ids = $fancy_content_ids === false ? array() : $fancy_content_ids;

				//get ui layout
				$ui_layout = FPD_UI_Layout_Composer::get_layout($product_settings->get_option('product_designer_ui_layout'));

				$selector_classes = $ui_layout['container_classes'];
				$selector_classes .= ' '.($visibility == 'lightbox' ? 'fpd-hidden' : '');

				?>
				<div class="fpd-product-designer-wrapper">
					<div id="<?php echo $selector; ?>" class="<?php echo $selector_classes; ?>">
					<?php

					$source_type = get_post_meta( $product_settings->master_id, 'fpd_source_type', true );
					foreach($fancy_content_ids as $fancy_content_id) {

						if( empty($source_type) || $source_type == 'category' ) {

							$fancy_category = new Fancy_Category($fancy_content_id);

							if( $fancy_category->get_data() ) {

								echo '<div class="fpd-category" title="'.esc_attr($fancy_category->get_data()->title).'">';

									$fancy_products_data = $fancy_category->get_products();
									foreach($fancy_products_data as $fancy_product_data) {

										echo $this->get_product_html($fancy_product_data->ID);

									}

								echo '</div>'; //category
							}


						}
						else {

							echo $this->get_product_html($fancy_content_id);

						}

					}

					//output designs
					if( !intval($product_settings->get_option('hide_designs_tab')) ) {

						require_once( FPD_PLUGIN_DIR.'/inc/class-designs.php' );

						$fpd_designs = new FPD_Designs(
							$product_settings->get_option('design_categories[]') ? $product_settings->get_option('design_categories[]') : array()
							,$product_settings->get_image_parameters()
						);
						$fpd_designs->output();

					}

					?>
					</div>
				</div>

				<?php

					$price_format = function_exists('get_woocommerce_price_format') ? sprintf( get_woocommerce_price_format(), get_woocommerce_currency_symbol(), '%d' ) : '%d';

				?>
				<script type="text/javascript">

					var fancyProductDesigner,
						$selector,
						$productWrapper,
						$cartForm,
						$mainBarCon = null,
						$modalPrice = null,
						productCreated = false,
						fpdPrice = 0,
						isReady = false;

					<?php echo fpd_get_option('fpd_jquery_no_conflict') === 'on' ? 'jQuery.noConflict();' : ''; ?>
					jQuery(document).ready(function() {

						//return;

						$selector = jQuery('#<?php echo $selector; ?>');
						$productWrapper = jQuery('.post-<?php echo $post->ID; ?>');
						$cartForm = jQuery('[name="fpd_product"]:first').parents('form:first');
						$mainBarCon = jQuery('.fpd-main-bar-position');

						//merge image parameters with custom image parameters
						var customImageParams = jQuery.extend(
							<?php echo $product_settings->get_image_parameters_string(); ?>,
							<?php echo $product_settings->get_custom_image_parameters_string(); ?>
						);

						var modalModeOpt = false;
						if(<?php echo intval($visibility == 'lightbox'); ?>) {
							modalModeOpt = '#fpd-start-customizing-button';
						}

						//get plugin options from UI Layout
						var uiLayoutOptions = <?php echo json_encode($ui_layout['plugin_options']); ?>,
							uiLayoutOptions = typeof uiLayoutOptions === 'object' ? uiLayoutOptions : {};

						//call fancy product designer plugin
						var pluginOptions = {
							langJSON: <?php echo FPD_Settings_Labels::get_labels_object_string(); ?>,
							fonts: [<?php echo '"'.implode('", "', $available_fonts).'"'; ?>],
							templatesDirectory: "<?php echo plugins_url('/templates/', FPD_PLUGIN_ROOT_PHP ); ?>",
							facebookAppId: "<?php echo fpd_get_option('fpd_facebook_app_id'); ?>",
							instagramClientId: "<?php echo fpd_get_option('fpd_instagram_client_id'); ?>",
							instagramRedirectUri: "<?php echo fpd_get_option('fpd_instagram_redirect_uri'); ?>",
							patterns: [<?php echo implode(',', $this->get_pattern_urls()); ?>],
							zoomStep: <?php echo fpd_get_option('fpd_zoom_step'); ?>,
							maxZoom: <?php echo fpd_get_option('fpd_max_zoom'); ?>,
							hexNames: <?php echo FPD_Settings_Advanced_Colors::get_hex_names_object_string(); ?>,
							selectedColor:  "<?php echo fpd_get_option('fpd_selected_color'); ?>",
							boundingBoxColor:  "<?php echo fpd_get_option('fpd_bounding_box_color'); ?>",
							outOfBoundaryColor:  "<?php echo fpd_get_option('fpd_out_of_boundary_color'); ?>",
							replaceInitialElements: <?php echo $product_settings->get_option('replace_initial_elements'); ?>,
							lazyLoad: <?php echo fpd_get_option('fpd_lazy_load'); ?>,
							improvedResizeQuality: <?php echo fpd_get_option('fpd_improvedResizeQuality'); ?>,
							uploadZonesTopped: <?php echo fpd_get_option('fpd_uploadZonesTopped'); ?>,
							mainBarContainer: $mainBarCon.size() ? $mainBarCon : false,
							responsive: <?php echo fpd_get_option('fpd_responsive'); ?>,
							priceFormat: "<?php echo $price_format; ?>",
							modalMode: modalModeOpt,
							templatesType: 'php',
							watermark: "<?php echo $this->remove_watermark ? '' : fpd_get_option('fpd_watermark_image'); ?>",
							loadFirstProductInStage: <?php echo $this->form_views === null ? 1 : 0; ?>,
							unsavedProductAlert: <?php echo fpd_get_option('fpd_unsaved_customizations_alert'); ?>,
							customImageAjaxSettings: {
								url: "<?php echo plugins_url('/inc/custom-image-handler.php', FPD_PLUGIN_ROOT_PHP); ?>",
								data: {
									saveOnServer: <?php echo (int) (fpd_get_option('fpd_type_of_uploader') === 'php'); ?>,
									uploadsDir: "<?php echo FPD_WP_CONTENT_DIR . '/uploads/fancy_products_uploads/'; ?>",
									uploadsDirURL: "<?php echo content_url() . '/uploads/fancy_products_uploads/'; ?>"
								}
							},
							elementParameters: {
								originX: "<?php echo fpd_get_option('fpd_common_parameter_originX'); ?>",
								originY: "<?php echo fpd_get_option('fpd_common_parameter_originY'); ?>",
							},
							imageParameters: {
								padding:  0,
								colorPrices: <?php echo $product_settings->get_option('enable_image_color_prices') ? FPD_Settings_Advanced_Colors::get_color_prices() : '{}'; ?>,
								replaceInAllViews: <?php echo $product_settings->get_option('designs_parameter_replaceInAllViews'); ?>,
							},
							textParameters: {
								padding:  <?php echo fpd_get_option('fpd_padding_controls'); ?>,
								fontFamily: "<?php echo $default_font; ?>",
								colorPrices: <?php echo $product_settings->get_option('enable_text_color_prices') ? FPD_Settings_Advanced_Colors::get_color_prices() : '{}'; ?>,
								replaceInAllViews: <?php echo $product_settings->get_option('custom_texts_parameter_replaceInAllViews'); ?>,
							},
							customImageParameters: customImageParams,
							customTextParameters: <?php echo $product_settings->get_custom_text_parameters_string(); ?>
						};

						pluginOptions = jQuery.extend({}, pluginOptions, uiLayoutOptions);
						fancyProductDesigner = new FancyProductDesigner($selector, pluginOptions);

						//when load from cart or order, use loadProduct
						$selector.on('ready', function() {

							if(<?php echo $this->form_views === null ? 0 : 1; ?>) {
								var views = <?php echo $this->form_views === null ? 0 : $this->form_views; ?>;
								fancyProductDesigner.toggleSpinner(true);
								fancyProductDesigner.loadProduct(views);
							}

							//requires login to upload images
							<?php $login_required = fpd_get_option('fpd_upload_designs_php_logged_in') !== 0 && !is_user_logged_in() ? 1 : 0; ?>
							if ( <?php echo $login_required; ?> ) {
								$('.fpd-upload-zone').replaceWith('<p class="fpd-login-info"><?php _e('You need to be logged in to upload images!', 'radykal'); ?></p>');
							}
							isReady = true;

							//add price to modal
							$modalPrice = $('<span class="fpd-modal-price fpd-right"></span>');
							 $('.fpd-modal-product-designer .fpd-done').after($modalPrice);

						})
						.on('undoRedoSet', function() {

							$('body').removeClass('fpd-customization-required');

						});

					});

				</script>

				<?php

				if( fpd_get_option('fpd_sharing') )
					echo FPD_Share::get_javascript();

				//woocommerce
				if( get_post_type( $post ) === 'product' ) {
					$this->output_wc_js();
				}
				else {
					$this->output_shortcode_js();
				}

			}

			do_action('fpd_after_product_designer', $post->ID);

		}

		public function fpd_shortcode_handler( $atts ) {

			extract( shortcode_atts( array(
			), $atts, 'fpd' ) );

			ob_start();

			echo $this->add_customize_button();
			echo $this->add_product_designer();

			$output = ob_get_contents();
			ob_end_clean();

			return $output;

		}

		public function fpd_form_shortcode_handler( $atts ) {

			extract( shortcode_atts( array(
				'button' => 'Send',
				'name_placeholder' => 'Enter your name here',
				'email_placeholder' => 'Enter your email here',
				'price_format' => '$%d',
			), $atts, 'fpd_form' ) );


			ob_start();

			?>
			<script type="text/javascript">
				jQuery(document).ready(function() {

					$selector.on('templateLoad', function(evt, url) {
						fancyProductDesigner.mainOptions.priceFormat = "<?php echo empty($price_format) ? '' : $price_format; ?>";
					});

				})

			</script>
			<form name="fpd_shortcode_form">
				<?php if( !empty($price_format) ) : ?>
				<p class="fpd-shortcode-price-wrapper">
					<span class="fpd-shortcode-price" data-priceformat="<?php echo $price_format; ?>"></span>
				</p>
				<?php endif; ?>
				<input type="text" name="fpd_shortcode_form_name" placeholder="<?php echo $name_placeholder ?>" class="fpd-shortcode-form-text-input" />
				<input type="email" name="fpd_shortcode_form_email" placeholder="<?php echo $email_placeholder ?>" class="fpd-shortcode-form-text-input" />
				<input type="hidden" name="fpd_product" />
				<input type="submit" value="<?php echo $button; ?>" class="fpd-disabled <?php echo fpd_get_option('fpd_start_customizing_css_class'); ?>" />
			</form>
			<?php

			$output = ob_get_contents();
			ob_end_clean();

			return $output;

		}

		//adds a customize button to the summary
		public function add_customize_button( ) {

			global $post;
			$product_settings = new FPD_Product_Settings($post->ID);

			$fancy_content_ids = fpd_has_content( $post->ID );
			if( !is_array($fancy_content_ids) || sizeof($fancy_content_ids) === 0 ) { return; }

			if( $product_settings->customize_button_enabled ) {

				$button_class = trim(fpd_get_option('fpd_start_customizing_css_class')) == '' ? 'fpd-start-customizing-button' : fpd_get_option('fpd_start_customizing_css_class');
				$button_class .= fpd_get_option('fpd_start_customizing_button_position') === 'under-short-desc' ? ' fpd-block' : ' fpd-inline';
				$label = FPD_Settings_Labels::get_translation('misc', 'customization_button');

				?>
				<a href="<?php echo esc_url( add_query_arg( 'start_customizing', '' ) ); ?>" id="fpd-start-customizing-button" class="<?php echo $button_class; ?>" title="<?php echo $product_settings->get_option('start_customizing_button'); ?>"><?php echo $label; ?></a>
				<?php

			}

		}

		//the additional form fields
		public function add_product_designer_form() {

			global $post;
			$product_settings = new FPD_Product_Settings($post->ID);

			if( $product_settings->show_designer() ) {
				?>
				<input type="hidden" value="" name="fpd_product" />
				<input type="hidden" value="" name="fpd_product_price" />
				<input type="hidden" value="" name="fpd_product_thumbnail" />
				<input type="hidden" value="<?php echo isset($_GET['cart_item_key']) ? $_GET['cart_item_key'] : ''; ?>" name="fpd_remove_cart_item" />
				<?php
			}

		}

		private function get_pattern_urls() {

			$urls = array();

			$path = FPD_WP_CONTENT_DIR . '/uploads/fpd_patterns/';

			if( file_exists($path) ) {
			  	$folder = opendir($path);

				$pic_types = array("jpg", "jpeg", "png");

				while ($file = readdir ($folder)) {

				  if(in_array(substr(strtolower($file), strrpos($file,".") + 1),$pic_types)) {
					  $urls[] = '"'.content_url('/uploads/fpd_patterns/'.$file, FPD_PLUGIN_ROOT_PHP ).'"';
				  }
				}

				closedir($folder);
			}

			return $urls;

		}

		private function get_product_html( $product_id ) {

			$fancy_product = new Fancy_Product($product_id);
			$views_data = $fancy_product->get_views();
			$output = '';

			if( !empty($views_data) ) {

				$first_view = $views_data[0];
				$product_options = fpd_convert_obj_string_to_array($fancy_product->get_options());

				$view_options = fpd_convert_obj_string_to_array($first_view->options);
				$view_options = array_merge((array) $product_options, (array) $view_options);
				$view_options = Fancy_View::options_to_string($view_options);

				ob_start();
				echo "<div class='fpd-product' title='".esc_attr($first_view->title)."' data-thumbnail='".esc_attr($first_view->thumbnail)."' data-options='".$view_options."' data-productthumbnail='".esc_attr($fancy_product->get_thumbnail())."' data-producttitle='".esc_attr($fancy_product->get_title())."'>";

					echo $this->get_element_anchors_from_view($first_view->elements);

					//sub views
					if( sizeof($views_data) > 1 ) {

						for($i = 1; $i <  sizeof($views_data); $i++) {
							$sub_view = $views_data[$i];

							$view_options = fpd_convert_obj_string_to_array($sub_view->options);
							$view_options = array_merge((array) $product_options, (array) $view_options);
							$view_options = Fancy_View::options_to_string($view_options);

							?>
							<div class="fpd-product" title="<?php echo esc_attr($sub_view->title); ?>" data-thumbnail="<?php echo esc_attr($sub_view->thumbnail); ?>" data-options='<?php echo $view_options; ?>'>
								<?php
								echo $this->get_element_anchors_from_view($sub_view->elements);
								?>
							</div>
							<?php
						}

					}

				echo '</div>'; //product
				$output = ob_get_contents();
				ob_end_clean();
			}

			return $output;

		}

		private function get_element_anchors_from_view($elements) {

			//unserialize when necessary
			if( @unserialize($elements) !== false ) {
				$elements = @unserialize($elements);
			}

			//V3 - json
			if( !is_array($elements) ) {
				$elements = json_decode($elements);
			}

			$view_html = '';
			if(is_array($elements)) {
				foreach($elements as $element) {
					$element = (array) $element;
					$view_html .= $this->get_element_anchor($element['type'], $element['title'], $element['source'], (array) $element['parameters']);
				}
			}

			return $view_html;

		}

		//return a single element markup
		private function get_element_anchor($type, $title, $source, $parameters) {

			$parameters_string = FPD_Parameters::convert_parameters_to_string($parameters, $type);

			if($type == 'image') {

				//get correct url for image source
				$url_parts = explode('/wp-content/', $source);
				if($url_parts && !empty($url_parts) && strpos($source, '/wp-content/') !== false)
					$source = site_url('/wp-content/'.$url_parts[sizeof($url_parts)-1]);

				return "<img data-src='$source' title='$title' data-parameters='$parameters_string' />";
			}
			else {
				$source = stripslashes($source);
				return "<span title='$title' data-parameters='$parameters_string'>$source</span>";
			}

		}

		private function output_wc_start() {

			global $product, $woocommerce;

			//added to cart, recall added product
			if( isset($_POST['fpd_product']) ) {

				$views = $_POST['fpd_product'];
				$this->form_views = stripslashes($views);

			}
			else if( isset($_GET['cart_item_key']) ) {

				//load from cart item
				$cart = $woocommerce->cart->get_cart();
				$cart_item = $cart[$_GET['cart_item_key']];
				if($cart_item) {
					if( isset($cart_item['fpd_data']) ) {
						$views = $cart_item['fpd_data']['fpd_product'];
						$this->form_views = stripslashes($views);
					}
				}
				else {
					//cart item could not be found
					echo '<p><strong>';
					_e('Sorry, but the cart item could not be found!', 'radykal');
					echo '</strong></p>';
					return;
				}

			}
			else if( isset($_GET['order']) && isset($_GET['item_id']) ) {

				//load ordered product in designer
				$order = new WC_Order( $_GET['order'] );
				$item_meta = $order->get_item_meta( $_GET['item_id'], 'fpd_data' );
				$this->form_views = $item_meta[0]["fpd_product"];

				$this->remove_watermark = true;

				if( $product->is_downloadable()) {

					if( $order->is_download_permitted() ): ?>
					<p>
						<a href="#" id="fpd-extern-download-pdf" class="<?php echo trim(fpd_get_option('fpd_start_customizing_css_class')); ?>">
							<?php echo FPD_Settings_Labels::get_translation( 'actions', 'download' ); ?>
						</a>
					</p>
					<?php
					else:
						$this->remove_watermark = false;
					endif;
				}

			}

		}

		private function output_wc_js() {

			global $product;

			?>
			<script type="text/javascript">

				//WOOCOMMERCE JS

				var wcPrice = <?php echo $product->get_display_price() ? $product->get_display_price() : 0; ?>,
					currencySymbol = '<?php echo get_woocommerce_currency_symbol(); ?>',
					decimalSeparator = "<?php echo get_option('woocommerce_price_decimal_sep'); ?>",
					thousandSeparator = "<?php echo get_option('woocommerce_price_thousand_sep'); ?>",
					numberOfDecimals = <?php echo get_option('woocommerce_price_num_decimals'); ?>,
					currencyPos = "<?php echo get_option('woocommerce_currency_pos'); ?>",
					firstViewImg = null;

				jQuery(document).ready(function() {

					//reset image when variation has changed
					$productWrapper.on('found_variation', '.variations_form', function() {

						if(firstViewImg !== null) {
							setTimeout(_setProductImage, 5);
						}

					});

					jQuery('#fpd-extern-download-pdf').click(function(evt) {

						evt.preventDefault();
						if(productCreated) {
							fancyProductDesigner.actions.downloadFile('pdf');
						}
						else {
							FPDUtil.showModal("<?php _e('The product is not created yet, try again when the product has been fully loaded into the designer', 'fpd_label'); ?>");
						}


					});

					//calculate initial price
					$selector.on('productCreate', function() {

						productCreated = true;
						fpdPrice = fancyProductDesigner.currentPrice;
						_setTotalPrice();
						if(<?php echo $this->form_views === null ? 0 : 1; ?>) {
							_setProductImage();
						}

					});

					//check when variation has been selected
					jQuery(document).on('found_variation', '.variations_form', function(evt, variation) {

						if(variation.display_price !== undefined) {

							wcPrice = variation.display_price;
							console.log(wcPrice);
							/* old
							//- get last price, if a sale price is found, use it
							//- set thousand and decimal separator
							//- parse it as numberjQuery(variation.price_html).find('span:last').text().replace(currencySymbol,'').replace(thousandSeparator, '').replace(decimalSeparator, '.').replace(/[^\d.]/g,'');*/

						}

						_setTotalPrice();

					});

					//listen when price changes
					$selector.on('priceChange', function(evt, sp, tp) {

						fpdPrice = tp;
						_setTotalPrice();

					});

					//fill custom form with values and then submit
					$cartForm.on('click', ':submit', function(evt) {

						evt.preventDefault();

						if(!productCreated) { return false; }

						var product = fancyProductDesigner.getProduct(false, <?php echo fpd_get_option('fpd_customization_required'); ?>);
						if(product != false) {

							_setTotalPrice();
							$('.single_add_to_cart_button').addClass('fpd-disabled');


							var viewOpts = fancyProductDesigner.viewInstances[0].options,
								multiplier = FPDUtil.getScalingByDimesions(viewOpts.stageWidth, viewOpts.stageHeight, 300, 300);

							fancyProductDesigner.viewInstances[0].toDataURL(function(dataURL) {

								$cartForm.find('input[name="fpd_product"]').val(JSON.stringify(product));
								$cartForm.find('input[name="fpd_product_thumbnail"]').val(dataURL);
								$cartForm.submit();

							}, 'transparent', {format: 'png', multiplier: multiplier})

						}

					});

					$('.fpd-modal-product-designer').on('click', '.fpd-done', function(evt) {

						evt.preventDefault();

						if($selector.parents('.woocommerce').size() > 0) {
							_setProductImage();
						}

						if(<?php echo intval(fpd_get_option('fpd_lightbox_add_to_cart')); ?>) {
							$cartForm.find(':submit').click();
						}

					});

					//set total price depending from wc and fpd price
					function _setTotalPrice() {

						var totalPrice = parseFloat(wcPrice) + parseFloat(fpdPrice),
							htmlPrice;

						totalPrice = totalPrice.toFixed(numberOfDecimals);
						htmlPrice = totalPrice.toString().replace('.', decimalSeparator);
						if(thousandSeparator.length > 0) {
							htmlPrice = _addThousandSep(htmlPrice);
						}

						if(currencyPos == 'right') {
							htmlPrice = htmlPrice + currencySymbol;
						}
						else if(currencyPos == 'right_space') {
							htmlPrice = htmlPrice + ' ' + currencySymbol;
						}
						else if(currencyPos == 'left_space') {
							htmlPrice = currencySymbol + ' ' + htmlPrice;
						}
						else {
							htmlPrice = currencySymbol + htmlPrice;
						}

						//check if variations are used
						if($productWrapper.find('.variations_form').size() > 0) {
							//check if amount contains 2 prices or sale prices. If yes different prices are used
							if($productWrapper.find('.price:first > .amount').size() == 2 || $productWrapper.find('.price:first ins > .amount').size() == 2) {
								//different prices
								$productWrapper.find('.single_variation .price .amount:last').html(htmlPrice);
							}
							else {
								//same price
								$productWrapper.find('.price:first .amount:last').html(htmlPrice);
							}

						}
						//no variations are used
						else {
							$productWrapper.find('.price:first .amount:last').html(htmlPrice);
						}

						$cartForm.find('input[name="fpd_product_price"]').val(fpdPrice);

						if($modalPrice) {
							$modalPrice.html(htmlPrice);
						}

					};

					//todo: add to FPDUTIL
					function _addThousandSep(n){

					    var rx=  /(\d+)(\d{3})/;
					    return String(n).replace(/^\d+/, function(w){
					        while(rx.test(w)){
					            w= w.replace(rx, '$1'+thousandSeparator+'$2');
					        }
					        return w;
					    });

					};

					function _setProductImage() {

						if(jQuery('.fpd-modal-product-designer').size() > 0 && <?php echo fpd_get_option('fpd_lightbox_update_product_image'); ?>) {

							fancyProductDesigner.viewInstances[0].toDataURL(function(dataURL) {

								$productWrapper.find('div.images img:eq(0)').attr('src', dataURL).attr('srcset', dataURL).parent('a').attr('href', dataURL);

							}, 'transparent', {format: 'png'});

						}

					};

				});

			</script>
			<?php
		}

		private function output_shortcode_js() {

			?>
			<script type="text/javascript">

				jQuery(document).ready(function() {

					var $shortcodePrice = $cartForm.find('.fpd-shortcode-price');

					//calculate initial price
					$selector.on('productCreate', function() {

						productCreated = true;
						$cartForm.find(':submit').removeClass('fpd-disabled');
						fpdPrice = fancyProductDesigner.currentPrice;
						_setTotalPrice();


					});

					//listen when price changes
					$selector.on('priceChange', function(evt, sp, tp) {

						fpdPrice = tp;
						_setTotalPrice();

					});

					jQuery('[name="fpd_shortcode_form"]').on('click', ':submit', function(evt) {

						evt.preventDefault();

						if(!productCreated) { return false; }

						var product = fancyProductDesigner.getProduct(false, <?php echo fpd_get_option('fpd_customization_required'); ?>),
							$submitBtn = $(this),
							data = {
								action: 'fpd_newshortcodeorder'
							};

						if(product != false) {

							var $nameInput = $cartForm.find('[name="fpd_shortcode_form_name"]').removeClass('fpd-error'),
								$emailInput = $cartForm.find('[name="fpd_shortcode_form_email"]').removeClass('fpd-error'),
								emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


							if( $nameInput.val() === '' ) {
								$nameInput.focus().addClass('fpd-error');
								return false;
							}
							else {
								data.name = $nameInput.val();
							}

							if( !emailRegex.test($emailInput.val()) ) {
								$emailInput.focus().addClass('fpd-error');
								return false;
							}
							else {
								data.email = $emailInput.val();
							}

							data.product = JSON.stringify(product);
							$submitBtn.addClass('fpd-disabled');
							$selector.find('.fpd-full-loader').show();

							jQuery.post("<?php echo admin_url('admin-ajax.php'); ?>", data, function(response) {

								FPDUtil.showMessage(response.id ? response.message : response.error);
								$submitBtn.removeClass('fpd-disabled');
								$selector.find('.fpd-full-loader').hide();

							}, 'json');

							$nameInput.val('');
							$emailInput.val('');

						}

					});

					//set total price depending from wc and fpd price
					function _setTotalPrice() {

						if($shortcodePrice.data('priceformat')) {

							var htmlPrice = $shortcodePrice.data('priceformat').replace('%d', parseFloat(fpdPrice).toFixed(2));

							$shortcodePrice.html(htmlPrice)
							.parent().addClass('fpd-show-up');

							if($modalPrice) {
								$modalPrice.html(htmlPrice);
							}

						}

					};

				});

			</script>
			<?php

		}

		public function create_shortcode_order() {

			if( !isset($_POST['product']) )
				die;

			if( !class_exists('FPD_Shortcode_Order') ) {
				require_once(FPD_PLUGIN_DIR.'/inc/class-shortcode-order.php');
			}

			$insert_id = FPD_Shortcode_Order::create( $_POST['name'], $_POST['email'], $_POST['product']);

			if( $insert_id ) {
				echo json_encode(array(
					'id' => $insert_id,
					'message' => FPD_Settings_Labels::get_translation( 'misc', 'shortcode_order:_success_sent' ),
				));
			}
			else {

				echo json_encode(array(
					'error' => FPD_Settings_Labels::get_translation( 'misc', 'shortcode_order:_fail_sent' ),
				));

			}

			die;

		}

	}
}

new FPD_Frontend_Product();

?>