<?php
if (get_custom_option('slider_show')=='yes') { 
	$slider = get_custom_option('slider_engine');
	themerex_enqueue_style( 'main-slider-style',  get_template_directory_uri() . '/css/slider-style.css', array(), null );
	$slider_shortcode = '';
		if ($slider == 'revo' && revslider_exists()) {
				$slider_alias = get_custom_option('slider_alias');
				if (!empty($slider_alias)) $slider_shortcode = do_shortcode('[rev_slider '.$slider_alias.']');//putRevSlider($slider_alias);
			} if ($slider == 'royal' && royalslider_exists()) {
				$slider_alias = get_custom_option('slider_alias');
				if (!empty($slider_alias)) {
					//register_new_royalslider_files($slider_alias);
					themerex_enqueue_style( 'new-royalslider-core-css', NEW_ROYALSLIDER_PLUGIN_URL . 'lib/royalslider/royalslider.css', array(), null );
					themerex_enqueue_script( 'new-royalslider-main-js', NEW_ROYALSLIDER_PLUGIN_URL . 'lib/royalslider/jquery.royalslider.min.js', array('jquery'), NEW_ROYALSLIDER_WP_VERSION, true );
					$slider_shortcode = get_new_royalslider($slider_alias);
				}
			} else if ($slider == 'swiper') {
				$slider_cat = get_custom_option("slider_category");
				$slider_orderby = get_custom_option("slider_orderby");
				$slider_order = get_custom_option("slider_order");
				$slider_count = $slider_ids = get_custom_option("slider_posts");
				$slider_theme = get_custom_option("slider_nav_theme");
				$slider_height = get_custom_option("slider_height");
				$slider_reviews_style = get_custom_option("slider_reviews_style");
				$slider_controls = get_custom_option('slider_controls');
				$slider_pagination = get_custom_option('slider_pagination');
				if (themerex_strpos($slider_ids, ',')!==false)
					$slider_count = 0;
				else {
					$slider_ids = '';
					if (empty($slider_count)) $slider_count = 3;
				}
				$slider_info_box = get_custom_option("slider_info_box");
				$slider_info_fixed = get_custom_option("slider_info_fixed");
				if ($slider_count>0 || !empty($slider_ids)) {
					$slider_shortcode = do_shortcode('[trx_slider engine="'.$slider.'"'
						.($slider_cat ? ' cat="'.$slider_cat.'"' : '') 
						.($slider_ids ? ' ids="'.$slider_ids.'"' : '') 
						.($slider_count ? ' count="'.$slider_count.'"' : '') 
						.' height="'.($slider_height ? $slider_height : '500').'"'
						.' theme="'.($slider_theme ? $slider_theme : 'light').'"'
						.' controls="'.($slider_controls ? $slider_controls : 'yes').'"'
						.' pagination="'.($slider_pagination ? $slider_pagination : 'yes').'"'
						.' rev_style="'.($slider_reviews_style ? $slider_reviews_style : '' ).'"'
						.($slider_orderby ? ' orderby="'.$slider_orderby.'"' : '') 
						.($slider_order ? ' order="'.$slider_order.'"' : '') 
						.' titles="'.($slider_info_box=='yes' ? ($slider_info_fixed=='yes' ? 2 : 1) : 0)  .'"'
						.']');
				}
			}
		//echo slider
		if( $slider_shortcode != ''){ ?>
			<div class="sliderHeader staticSlider slider_engine_<?php echo esc_attr($slider); ?>"><?php
			echo $slider_shortcode; ?>
			</div>
		<?php } ?>
	
<?php } ?>
