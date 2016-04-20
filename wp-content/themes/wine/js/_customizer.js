// Customization panel

jQuery(document).ready(function() {
	"use strict";


	// Open/close panel
	if (jQuery('#custom_options').length > 0) {

		jQuery('#co_toggle').click(function(e) {
			"use strict";
			var co = jQuery('#custom_options').eq(0);
			if (co.hasClass('opened')) {
				co.removeClass('opened');
				jQuery('body').removeClass('custom_options_opened');
				jQuery('.custom_options_shadow').fadeOut(500);
			} else {
				co.addClass('opened');
				jQuery('body').addClass('custom_options_opened');
				jQuery('.custom_options_shadow').fadeIn(500);
			}
			e.preventDefault();
			return false;
		});
		jQuery('.custom_options_shadow').click(function(e) {
			"use strict";
			jQuery('#co_toggle').trigger('click');
			e.preventDefault();
			return false;
		});

		//sec cookie opened
		if( jQuery.cookie('custom_options') != 1 ){
			jQuery("#co_toggle").trigger('click');
		}
		jQuery.cookie('custom_options', '1', {expires: 1, path: '/'});

		customResetShow();
		jQuery('#custom_options #co_theme_reset').click(function (e) {
			"use strict";
			jQuery('#custom_options .co_section').each(function () {
				"use strict";

				jQuery(this).find('div[data-options]').each(function() {
					var value = jQuery(this).data('options');
					jQuery.cookie(value,null, {expires: -1, path: '/'});
				});
			});
			location.reload();
			runLoader();
			e.preventDefault();
			return false;
		});

		// Switcher
		var swither = jQuery("#custom_options .co_switch_box:not(.inited)" )
		if( swither.length > 0 ){

			swither.each(function() {
				jQuery(this).addClass('inited');
				switchBox( jQuery(this) );
			});

			jQuery("#custom_options .co_switch_box a" ).click(function(e) {
				"use strict";
				var value = jQuery(this).data('value');
				var wrap = jQuery(this).parent('.co_switch_box');
				var options = wrap.data('options');
				wrap.find('.switcher').data('value', value );

				jQuery.cookie(options, value, {expires: 1, path: '/'});

				customResetShow();
				switchBox(wrap);

				//check settings
				if ( options == 'body_style'){
					jQuery('#custom_options .co_pattern_wrapper').removeClass('active');
					location.reload();
					runLoader();
				} else if( options == 'color_scheme_theme') {
					jQuery('#wrap').removeClass('themeLight themeDark').addClass(value);
					jQuery('#custom_options').removeClass('co_dark co_light').addClass( value == 'themeDark' ? 'co_dark' : 'co_light' );
				} else if( options == 'menu_display') {
					jQuery('#wrap').removeClass('hideMenuDisplay visibleMenuDisplay').addClass(value);
					location.reload();
					runLoader();
				} else if( options == 'menu_style') {
					jQuery('#wrap').removeClass('menuStyle1 menuStyle2').addClass('menuStyle'+value);
				} else if( options == 'reviews_max_level'){
					location.reload();
					runLoader();
				}

				e.preventDefault();
				return false;
			});
		}


		// ColorPicker
		iColorPicker();
		jQuery('#custom_options .iColorPicker').each(function() {
			"use strict";
			jQuery(this).css('backgroundColor',jQuery(this).data('value'))	
		});

		jQuery('#custom_options .iColorPicker').click(function (e) {
			"use strict";
			iColorShow(null, jQuery(this), function(fld, clr) {
				"use strict";
				var val = fld.data('value');
				var options = fld.data('options');
				fld.css('backgroundColor',clr);

				jQuery.cookie(options, val, {expires: 1, path: '/'});
				customResetShow();

				//check settings
				if ( options == 'theme_color'){
					location.reload();
					runLoader();
					//alert('theme_color');
					jQuery.cookie(options, clr, {expires: 1, path: '/'});
				} else if( options == 'theme_accent_color' ){
					location.reload();
					runLoader();
					//alert('theme_accent_color');
					jQuery.cookie(options, clr, {expires: 1, path: '/'});
				} else if ( options == 'bg_color'){
					jQuery("#custom_options .co_switch_box a[data-value='boxed']").trigger('click');
					jQuery('#custom_options #co_bg_pattern_list .co_pattern_wrapper, #custom_options #co_bg_images_list .co_image_wrapper').removeClass('active');
					jQuery.cookie('bg_image', null, {expires: -1, path: '/'});
					jQuery.cookie('bg_pattern', null, {expires: -1, path: '/'});
					jQuery.cookie('bg_color', clr, {expires: 1, path: '/'});
					jQuery(document).find('#wrap').removeClass('bgPattern_1 bgPattern_2 bgPattern_3 bgPattern_4 bgPattern_5 bgImage_1 bgImage_2 bgImage_3').css('backgroundColor', clr);
				}
			});
		});
		
		// Background patterns
		jQuery('#custom_options #co_bg_pattern_list a').click(function(e) {
			"use strict";
			jQuery("#custom_options .co_switch_box a[data-value='boxed']").trigger('click');
			jQuery('#custom_options #co_bg_pattern_list .co_pattern_wrapper,#custom_options #co_bg_images_list .co_image_wrapper').removeClass('active');
			var obj = jQuery(this).addClass('active');
			var val = obj.attr('id').substr(-1);
			jQuery.cookie('bg_color', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_image', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_pattern', val, {expires: 1, path: '/'});
			jQuery(document).find('#wrap').removeClass('bgPattern_1 bgPattern_2 bgPattern_3 bgPattern_4 bgPattern_5 bgImage_1 bgImage_2 bgImage_3').removeAttr('style').addClass('bgPattern_' + val);
			customResetShow();
			e.preventDefault();
			return false;
		});

		// Background images
		jQuery('#custom_options #co_bg_images_list a').click(function(e) {
			"use strict";
			jQuery("#custom_options .co_switch_box a[data-value='boxed']").trigger('click');
			jQuery('#custom_options #co_bg_images_list .co_image_wrapper, #custom_options #co_bg_pattern_list .co_pattern_wrapper').removeClass('active');
			var obj = jQuery(this).addClass('active');
			var val = obj.attr('id').substr(-1);
			jQuery.cookie('bg_color', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_pattern', null, {expires: -1, path: '/'});
			jQuery.cookie('bg_image', val, {expires: 1, path: '/'});
			jQuery(document).find('#wrap').removeClass('bgPattern_1 bgPattern_2 bgPattern_3 bgPattern_4 bgPattern_5 bgImage_1 bgImage_2 bgImage_3').removeAttr('style').addClass('bgImage_' + val);
			customResetShow();
			e.preventDefault();
			return false;
		});

		jQuery('#custom_options #co_bg_pattern_list a, #custom_options #co_bg_images_list a, .iColorPicker').hover(
			function() {
				"use strict";
				jQuery(this).addClass('current');
			},
			function() {
				"use strict";
				jQuery(this).removeClass('current');
			}
		);
	}
});

jQuery(window).resize(function () {
	jQuery('#custom_options .sc_scroll').css('height',jQuery('#custom_options').height()-46);
})


//switchBox
function switchBox(wrap) {
	"use strict";
	var drag = wrap.find('.switcher').eq(0);
	var value = drag.data('value');
	var pos = wrap.find('a[data-value="'+value+'"]').position();

	if( pos != undefined ){
		drag.css({
			left: pos.left,
			top: pos.top
		});
	}

	//--
	if(	drag.data('value') == 'fullWide' ){ 
		drag.fadeOut();
	} else {
		drag.fadeIn();
	}
}

//reset 
function customResetShow() {
	"use strict";
	var cooks = false;
	
	jQuery('#custom_options .co_section').each(function () {
		if ( cooks ) 
			return;

		jQuery(this).find('div[data-options]').each(function() {
			var cook = jQuery.cookie(jQuery(this).data('options'))
			if ( cook != undefined )
				cooks = true;			
		});
	});

	if( cooks ){
		jQuery('#custom_options').addClass('co_show_reset');			
	} else {
		jQuery('#custom_options').removeClass('co_show_reset');
	}

}

//loader
function runLoader() {
	jQuery('.custom_options_shadow').addClass('sc_loader_show');
}

