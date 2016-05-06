<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


if(!class_exists('FPD_Scripts_Styles')) {

	class FPD_Scripts_Styles {

		public static $add_script = false;

		public function __construct() {

			add_action( 'init', array( &$this, 'register') );
			add_action( 'wp_enqueue_scripts',array( &$this,'enqueue_styles' ) );
			add_action( 'wp_head',array( &$this,'print_css' ), 100 );
			add_action( 'wp_footer', array(&$this, 'footer_handler') );

		}

		public function register() {

			$local_test = false;
			//only local testing
			if($local_test) {
				wp_enqueue_style( 'fpd-test-webfont', 'http://radykal.dev/fpd4/src/FontFPD/style.css', false, Fancy_Product_Designer::VERSION );
				wp_enqueue_style( 'fpd-test-plugins', 'http://radykal.dev/fpd4/dist/css/plugins.min.css', false, Fancy_Product_Designer::FPD_VERSION );
			}

			$fpd_css_url = $local_test ? 'http://radykal.dev/fpd4/dist/css/FancyProductDesigner.css' : plugins_url('/css/FancyProductDesigner-all.min.css', FPD_PLUGIN_ROOT_PHP);
			$fpd_js_url = $local_test ? 'http://radykal.dev/fpd4/dist/js/FancyProductDesigner.js' : plugins_url('/js/FancyProductDesigner-all.min.js', FPD_PLUGIN_ROOT_PHP);
			$fpd_js_plugins_url = $local_test ? 'http://radykal.dev/fpd4/dist/js/plugins.js' : plugins_url('/js/plugins.js', FPD_PLUGIN_ROOT_PHP);
			$fpd_js_url = get_option('fpd_debug_mode') == 'yes' ?  plugins_url('/js/FancyProductDesigner.js', FPD_PLUGIN_ROOT_PHP) : $fpd_js_url;

			//register css files
			$fonts_dir = FPD_WP_CONTENT_DIR.'/uploads/fpd_fonts';
			$fonts_css = $fonts_dir.'/jquery.fancyProductDesigner-fonts.css';
			if( !file_exists($fonts_css) ) {

				if( !file_exists($fonts_dir) )
					wp_mkdir_p($fonts_dir);

				$handle = @fopen($fonts_css, 'w') or print('Cannot open file:  '.$fonts_css);
				fclose($handle);

			}

			wp_register_style( 'fpd-fonts', content_url('/uploads/fpd_fonts/jquery.fancyProductDesigner-fonts.css', FPD_PLUGIN_ROOT_PHP), false, Fancy_Product_Designer::FPD_VERSION );
			wp_register_style( 'jquery-fpd-static', plugins_url('/css/static.min.css', FPD_PLUGIN_ROOT_PHP), false, Fancy_Product_Designer::FPD_VERSION );
			wp_register_style( 'jquery-fpd', $fpd_css_url, array('fpd-fonts'), Fancy_Product_Designer::FPD_VERSION );
			wp_register_style( 'fpd-jssocials-theme', plugins_url('/assets/jssocials/jssocials-theme-flat.css', FPD_PLUGIN_ROOT_PHP), false, '0.2.0' );
			wp_register_style( 'fpd-jssocials', plugins_url('/assets/jssocials/jssocials.css', FPD_PLUGIN_ROOT_PHP), array('fpd-jssocials-theme'), '0.2.0' );

			//register js files
			wp_register_script( 'fpd-plugins', $fpd_js_plugins_url, false, Fancy_Product_Designer::FPD_VERSION );
			wp_register_script( 'fabric', plugins_url('/js/fabric.min.js', FPD_PLUGIN_ROOT_PHP), false, Fancy_Product_Designer::FPD_VERSION );
			wp_register_script( 'fpd-jssocials', plugins_url('/assets/jssocials/jssocials.min.js', FPD_PLUGIN_ROOT_PHP), false, '0.2.0' );

			$fpd_dep = array(
				'jquery',
				'jquery-ui-draggable',
				'jquery-ui-sortable',
				'fabric',
			);

			if( get_option('fpd_debug_mode') == 'yes' || $local_test )
				array_push($fpd_dep, 'fpd-plugins');

			wp_register_script( 'jquery-fpd', $fpd_js_url, $fpd_dep, Fancy_Product_Designer::FPD_VERSION );

		}

		//includes scripts and styles in the frontend
		public function enqueue_styles() {

			global $post;

			if( !isset($post->ID) )
				return;

			if( fpd_get_option('fpd_sharing') )
				wp_enqueue_style( 'fpd-jssocials' );

			wp_enqueue_style( 'jquery-fpd' );
			wp_enqueue_style( 'fpd-single-product', plugins_url('/css/fancy-product.css', FPD_PLUGIN_ROOT_PHP), false, Fancy_Product_Designer::VERSION );

		}

		public function print_css() {

			global $post;

			if( isset($post->ID) && is_fancy_product($post->ID) ) {

				//only enqueue css and js files when necessary
				$product_settings = new FPD_Product_Settings( $post->ID );
				//get ui layout
				$ui_layout = FPD_UI_Layout_Composer::get_layout($product_settings->get_option('product_designer_ui_layout'));
				$css_str = FPD_UI_Layout_Composer::get_css_from_layout($ui_layout);

				?>
				<style type="text/css">

					<?php if( $product_settings->get_option('background_type') ): ?>
					.fpd-container .fpd-main-wrapper {
						background: <?php echo $product_settings->get_option('background_type') == 'color' ? $product_settings->get_option('background_color') : 'url('.$product_settings->get_option('background_image').')'; ?> !important;
					}
					<?php endif; ?>
					<?php
						if( !empty($css_str) )
							echo $css_str;
						echo stripslashes( $ui_layout['custom_css'] );
					?>
				</style>
				<?php

				FPD_Fonts::output_webfont_links();

			}

		}

		public function footer_handler() {

			if( self::$add_script ) {

				wp_enqueue_script( 'jquery-fpd' );
				if( fpd_get_option('fpd_sharing') )
					wp_enqueue_script( 'fpd-jssocials' );

			}

		}

	}

}

new FPD_Scripts_Styles();

?>