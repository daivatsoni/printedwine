<?php
if (get_theme_option('show_theme_customizer') == 'yes') {


	$basic_color = get_custom_option('theme_color');
	$accent_color = get_custom_option('theme_accent_color');
	$background_color = get_custom_option('bg_color');
	$color_cheme = get_custom_option('color_scheme_theme');

	$reviews_max_level = max(5, (int) get_custom_option('reviews_max_level'));
	$body_style = get_custom_option('body_style');
	$bg_pattern = get_custom_option('bg_pattern');
	$bg_image = get_custom_option('bg_image');

	$menu_display = get_custom_option('menu_display');
	$menu_style = get_custom_option('menu_style');

	$custom_style = ($color_cheme == 'themeDark' ? 'co_dark' : 'co_light');

?>
	<div class="custom_options_shadow"></div>
	<div id="custom_options" class="custom_options <?php echo esc_attr($custom_style) ?>">
		
		<div class="co_header">
			<a href="#" id="co_toggle" class="co_ico icon-control"></a>
			<div class="co_title">
				<a href="#" id="co_theme_reset" class="co_reset icon-retweet">RESET</a>
				<span><?php _e('Style switcher', 'themerex'); ?></span>
			</div>
		</div>

		<div id="sc_custom_scroll" class="co_options sc_scroll sc_scroll_vertical">
			<div class="sc_scroll_wrapper swiper-wrapper">
			<div class="sc_scroll_slide swiper-slide">
				<input type="hidden" id="co_site_url" name="co_site_url" value="<?php echo 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>" />

				<div class="co_section">
					<div class="co_label"><?php _e('Body styles', 'themerex'); ?></div>
					<div class="co_switch_box co_switch_horizontal <?php /* co_switch_vertical|horizontal,co_switch_columns_3|4 */ ?>" data-options="body_style">
						<div class="switcher" data-value="<?php echo esc_attr($body_style); ?>"></div>
						<a href="#" data-value="boxed"><?php _e('Boxed', 'themerex'); ?></a>
						<a href="#" data-value="wide"><?php _e('Wide', 'themerex'); ?></a>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php _e('Color settings', 'themerex'); ?></div>
					<div class="co_colorpic_list">
						<div class="iColorPicker" data-options="theme_color" data-value="<?php echo esc_attr($basic_color); ?>"><span><?php _e('Basic color', 'themerex'); ?></span></div>
						<div class="iColorPicker" data-options="theme_accent_color" data-value="<?php echo esc_attr($accent_color); ?>"><span><?php _e('Accent color', 'themerex'); ?></span></div>
						<div class="iColorPicker" data-options="bg_color" data-value="<?php echo esc_attr($background_color); ?>"><span><?php _e('Background color', 'themerex'); ?></span></div>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php _e('Background pattern', 'themerex'); ?></div>
					<div id="co_bg_pattern_list" class="co_image_check" data-options="bg_pattern">
						<?php 
						$i_pattern = 1;
						 while( $i_pattern <= 5 ){
							$count = $i_pattern;
							$pattern = get_template_directory_uri().'/images/bg/pattern_'.$count;
							$current = $bg_pattern == $count ? ' active' : '' ;
							echo '<a href="#" id="pattern_'.$count.'" class="co_pattern_wrapper'.$current.'" style="background-image: url('.$pattern.'_thumb.png)"> <span class="co_bg_preview" style="background-image: url('.$pattern.'.png)"></span> </a> ';
						$i_pattern++;
						} ?>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php _e('Background image', 'themerex'); ?></div>
					<div id="co_bg_images_list" class="co_image_check" data-options="bg_image">
						<?php 
						$i_image = 1;
						 while( $i_image <= 3 ){
							$count = $i_image;
							$pattern = get_template_directory_uri().'/images/bg/image_'.$count;
							$current = $bg_image == $count ? ' active' : '' ;
							echo '<a href="#" id="image_'.$count.'" class="co_image_wrapper'.$current.'" style="background-image: url('.$pattern.'_thumb.jpg)"> <span class="co_bg_preview" style="background-image: url('.$pattern.'.jpg)"></span> </a>';
						$i_image++;
					} ?>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php _e('Reviews type', 'themerex'); ?></div>
					<div class="co_switch_box co_switch_horizontal co_switch_columns_3 <?php /* co_switch_vertical|horizontal,co_switch_columns_3|4 */ ?>" data-options="reviews_max_level">
						<div class="switcher" data-value="<?php echo esc_attr($reviews_max_level); ?>"></div>
						<a href="#" data-value="5"><?php _e('5 <small><span class="icon-star"></span></small>', 'themerex'); ?></a>
						<a href="#" data-value="10"><?php _e('10 <small><span class="icon-star"></span></small>', 'themerex'); ?></a>
						<a href="#" data-value="100"><?php _e('100%', 'themerex'); ?></a>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php _e('Menu display', 'themerex'); ?></div>
					<div class="co_switch_box co_switch_horizontal <?php /* co_switch_vertical|horizontal,co_switch_columns_3|4 */ ?>" data-options="menu_display">
						<div class="switcher" data-value="<?php echo esc_attr($menu_display); ?>"></div>
						<a href="#" data-value="hide"><?php _e('Hidden', 'themerex'); ?></a>
						<a href="#" data-value="visible"><?php _e('Visible', 'themerex'); ?></a>
					</div>
				</div>

				<div class="co_section">
					<div class="co_label"><?php _e('Dropdown menu style', 'themerex'); ?></div>
					<div class="co_switch_box co_switch_horizontal <?php /* co_switch_vertical|horizontal,co_switch_columns_3|4 */ ?>" data-options="menu_style">
						<div class="switcher" data-value="<?php echo esc_attr($menu_style); ?>"></div>
						<a href="#" data-value="1"><?php _e('Background', 'themerex'); ?></a>
						<a href="#" data-value="2"><?php _e('Line', 'themerex'); ?></a>
					</div>
				</div>


			</div>
			</div>
			<div id="sc_custom_scroll_bar" class="sc_scroll_bar sc_scroll_bar_vertical sc_custom_scroll_bar"></div>
		</div>
	</div>
<?php
}
?>
