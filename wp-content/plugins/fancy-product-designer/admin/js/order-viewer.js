var fancyProductDesigner,
	loadingProduct = false,
	$orderImageList,
	currentItemId = '',
	isReady = false,
	stageWidth = stageHeight = 0;


jQuery(document).ready(function() {

	var $fancyProductDesigner = jQuery('#fpd-order-designer'),
		$customElementsList = jQuery('#fpd-custom-elements-list'),
		$tabsContent = jQuery('#fpd-order-panel .radykal-tabs-content'),
		customElements = null;

	$orderImageList = jQuery('#fpd-order-image-list');

	jQuery(document).ajaxError( function(e, xhr, settings, exception) {
	 	//console.log(e, xhr, settings, exception);
	});

	var pluginsOptions = {
		responsive: false,
    	langJSON: false,
    	templatesDirectory: fpd_order_viewer.templates_dir,
    	editorMode: '#fpd-editor-box-wrapper',
    	keyboardControl: false,
    	deselectActiveOnOutside : false,
    	templatesType: 'php',
    	fonts: fpd_order_viewer.enabled_fonts && fpd_order_viewer.enabled_fonts.length > 2 ? fpd_order_viewer.enabled_fonts.split(',') : [],
    	actions: {
	    	top: ['manage-layers', 'undo', 'redo']
    	},
    	mainBarModules: []
	};

	//api buttons first available when
	$fancyProductDesigner.on('ready', function() {
		isReady = true;
	})
	.on('productCreate', function() {

		$customElementsList.empty();

		customElements = fancyProductDesigner.getCustomElements();
		for(var i=0; i < customElements.length; ++i) {
			var customElement = customElements[i].element;
			$customElementsList.append('<li><a href="#">'+customElement.title+'</a></li>');
		}

		loadingProduct = false;

	});

	fancyProductDesigner = new FancyProductDesigner($fancyProductDesigner, pluginsOptions);

	jQuery('.fancy-product').on('click', '.fpd-show-order-item', function(evt) {

		evt.preventDefault();

		if(	isReady && !loadingProduct ) {

			var $this = jQuery(this);
			$this.data('defaultText', $this.text()).text(fpd_order_viewer.loading_data_text);

			currentItemId = $this.data('order_item_id');

			jQuery.ajax({
			url: fpd_admin_opts.adminAjaxUrl,
			data: {
				action: 'fpd_loadorder',
				_ajax_nonce: fpd_admin_opts.ajaxNonce,
				order_id: $this.data('order_id'),
				item_id: currentItemId
			},
			type: 'post',
			dataType: 'json',
			complete: function(data) {

				if(data == undefined || data.responseJSON) {

					$('html, body').animate({
				        scrollTop: $("#fpd-order").offset().top
				    }, 300);

					fpdLoadOrder(JSON.parse(data.responseJSON.order_data));

				}
				else {

					fpdMessage(fpd_order_viewer.order_data_error_text, 'error');

				}

				$this.text($this.data('defaultText'));

			}
		});


		}

	});

	//EXPORT
	jQuery('[name="fpd_output_file"]').change(function() {

		if(jQuery('[name="fpd_output_file"]:checked').val() == 'pdf') {
			jQuery('#fpd-pdf-width').parents('label:first').show();
			jQuery('#fpd-pdf-height').parents('label:first').show();
			jQuery('#fpd-pdf-dpi').parents('label:first').show();
		}
		else {
			jQuery('#fpd-pdf-width').parents('label:first').hide();
			jQuery('#fpd-pdf-height').parents('label:first').hide();
			jQuery('#fpd-pdf-dpi').parents('label:first').hide();
		}

	}).change();

	jQuery('[name="fpd_image_format"]').change(function() {

		if(jQuery('[name="fpd_image_format"]:checked').val() == 'svg') {
			jQuery('#fpd-pdf-width').parents('tr:first').hide();
		}
		else {
			jQuery('#fpd-pdf-width').parents('tr:first').show();
		}

	}).change();

	jQuery('input[name="fpd_scale"]').keyup(function() {

		var scale = !isNaN(this.value) && this.value.length > 0 ? this.value : 1,
			mmInPx = 3.779528;

		jQuery('#fpd-pdf-width').val(Math.round((stageWidth * scale) / mmInPx));
		jQuery('#fpd-pdf-height').val(Math.round((stageHeight * scale) / mmInPx));

	}).keyup();

	jQuery('#fpd-generate-file').click(function(evt) {

		evt.preventDefault();

		if(_checkAPI()) {

			if(jQuery('[name="fpd_output_file"]:checked').val() == 'image') {
				createImage();
			}
			else {
				fpdBlockPanel($tabsContent);
				createPdf();
			}

		}

	});



	//SINGLE ELEMENT IMAGES
	$customElementsList.on('click', 'li', function(evt) {

		evt.preventDefault();

		var index = $customElementsList.children('li').index(this);

		fancyProductDesigner.currentViewInstance.stage.setActiveObject(customElements[index].element).renderAll().calcOffset();

	});

	jQuery('[name="fpd_single_image_format"]').change(function() {

		if(this.value == 'jpeg') {
			jQuery('[name="fpd_single_element_dpi"]').parents('tr:first').show();
		}
		else {
			jQuery('[name="fpd_single_element_dpi"]').parents('tr:first').hide();
		}

	}).change();


	jQuery('#fpd-save-element-as-image').click(function(evt) {

		evt.preventDefault();

		if(_checkAPI()) {

			var stage = fancyProductDesigner.currentViewInstance.stage,
				format = jQuery('input[name="fpd_single_image_format"]:checked').val(),
				backgroundColor = format == 'jpeg' ? '#ffffff' : 'transparent',
				dataURLOpts = {
					format: format
				};

			if(stage.getActiveObject()) {

				var $this = jQuery(this),
					element = stage.getActiveObject(),
					tempScale = element.scaleX,
					tempWidth = stage.getWidth(),
					tempHeight = stage.getHeight(),
					dataObj;

				//element can not be saved as svg
				if(format == 'svg') {

					if(element.toSVG().search('<image') != -1) {
						fpdMessage(fpd_order_viewer.svg_bitmap_text, 'info');
						return false;
					}

				}

				fancyProductDesigner.deselectElement();

				//check if origin size should be rendered
				if(jQuery('#fpd-restore-oring-size').is(':checked')) {

					var scaleXTo1 = (1 / element.scaleX),
						scaleYTo1 = (1 / element.scaleY);

					element.setScaleX(1);
					element.setScaleY(1);
				}

				stage.setBackgroundColor(backgroundColor, function() {

					var paddingTemp = element.padding;
					element.padding = jQuery('input[name="fpd_single_element_padding"]').val().length == 0 ? 0 : Number(jQuery('input[name="fpd_single_element_padding"]').val());

					var clipToTemp = element.getClipTo();
					if(element.clippingRect) {

						if(!jQuery('#fpd-without-bounding-box').is(':checked')) {

							var elementPoint = element.getPointByOrigin('left', 'top');

							if(jQuery('#fpd-restore-oring-size').is(':checked')) {
								dataURLOpts.left = (element.clippingRect.left - elementPoint.x) - (element.clippingRect.width * .5);
								dataURLOpts.top = (element.clippingRect.top - elementPoint.y) - (element.clippingRect.height * .5);
								dataURLOpts.width = element.clippingRect.width * scaleXTo1;
								dataURLOpts.height = element.clippingRect.height * scaleYTo1;
							}
							else {
								dataURLOpts.left = (element.clippingRect.left - elementPoint.x);
								dataURLOpts.top = (element.clippingRect.top - elementPoint.y);
								dataURLOpts.width = element.clippingRect.width;
								dataURLOpts.height = element.clippingRect.height;
							}

						}

						element.setClipTo(null);

					}

					element.setCoords();

					var source = format == 'svg' ? source = element.toSVG() : element.toDataURL(dataURLOpts);

					//save on server
					if(jQuery('#fpd-save-on-server').is(':checked')) {

						fpdBlockPanel($tabsContent);

						if(format == 'svg') {

							dataObj = {
								action: 'fpd_imagefromsvg',
								_ajax_nonce: fpd_admin_opts.ajaxNonce,
								order_id: fpd_order_viewer.order_id,
								item_id: currentItemId,
								svg: source,
								width: stage.getWidth(),
								height: stage.getHeight(),
								title: element.title
							};

						}
						else {

							dataObj = {
								action: 'fpd_imagefromdataurl',
									_ajax_nonce: fpd_admin_opts.ajaxNonce,
									order_id: fpd_order_viewer.order_id,
									item_id: currentItemId,
									data_url: source,
									title: element.title,
									format: format,
									dpi: jQuery('[name="fpd_single_element_dpi"]').val().length == 0 ? 72 : jQuery('[name="fpd_single_element_dpi"]').val()
							};
						}

						jQuery.ajax({
							url: fpd_admin_opts.adminAjaxUrl,
							data: dataObj,
							type: 'post',
							dataType: 'json',
							complete: function(data) {

								var json = data.responseJSON;
								if(data.status != 200 || json.code == 500) {
									fpdMessage(fpd_order_viewer.image_creation_fail_text, 'error');
								}
								else if( json.code == 201 ) {
									$orderImageList.append('<li><a href="'+json.url+'" title="'+json.url+'" target="_blank">'+json.title+'.'+format+'</a></li>');
								}
								else {
									//prevent caching
									$orderImageList.find('a[title="'+json.url+'"]').attr('href', json.url+'?t='+new Date().getTime());
								}

								fpdUnblockPanel($tabsContent);

							}
						});

					}
					else { //dont save it on server

						var popup = window.open('','_blank');
						if(!_popupBlockerEnabled(popup)) {

							popup.document.title = element.title;

							if(format == 'svg') {
								source = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="'+stage.getWidth()+'" height="'+stage.getHeight()+'" xml:space="preserve">'+element.toSVG()+'</svg>';
								jQuery(popup.document.body).append(source);
							}
							else {
								jQuery(popup.document.body).append('<img src="'+source+'" title="Product" />');

							}

						}

					}

					element.set({scaleX: tempScale, scaleY: tempScale, padding: paddingTemp})
					.setClipTo(clipToTemp)
					.setCoords();

					stage.setBackgroundColor('transparent')
					.setDimensions({width: tempWidth, height: tempHeight})
					.renderAll();

				});

			}
			else {
				fpdMessage(fpd_order_viewer.no_element_text, 'info');
			}
		}

	});

	jQuery('#fpd-create-new-fp').click(function(evt) {

		evt.preventDefault();

		if(	_checkAPI() ) {

			var addToLibrary = confirm(fpd_admin_opts.addToLibrary),
				options = {stage_width: stageWidth, stage_height: stageHeight};

			fpdBlockPanel($tabsContent);

			fpdAddProduct(function(data) {

				if(data) {

					fpdAddViews(
						data.id,
						fancyProductDesigner.getProduct(),
						addToLibrary,
						//view added
						function(data) {
						},
						//complete
						function() {
							fpdUnblockPanel($tabsContent);
						}
					);

				}
				else {
					fpdUnblockPanel($tabsContent);
				}

			}, options);

		}

	});

	function createImage() {

		var format = jQuery('input[name="fpd_image_format"]:checked').val();

		if(format == 'svg') {

			var popup = window.open('','_blank');
			if(!_popupBlockerEnabled(popup)) {

				var svg = fancyProductDesigner.getViewsSVG({suppressPreamble: true});

				popup.document.title = fpd_order_viewer.order_id;
				jQuery(popup.document.body).append(svg);
			}

		}
		else {

			var backgroundColor = format == 'jpeg' ? '#ffffff' : 'transparent',
				multiplier = jQuery('input[name="fpd_scale"]').val().length == 0 ? 1 : Number(jQuery('input[name="fpd_scale"]').val());

			if(jQuery('[name="fpd_export_views"]:checked').val() == 'current') {

				fancyProductDesigner.getViewsDataURL(function(dataURLs) {

					var dataURL = dataURLs[fancyProductDesigner.currentViewIndex];

					var popup = window.open('','_blank');
					if(!_popupBlockerEnabled(popup)) {

						popup.document.title = fpd_order_viewer.order_id;
						jQuery(popup.document.body).append('<img src="'+dataURL+'" title="View '+fancyProductDesigner.currentViewIndex+'" />');
					}

				}, backgroundColor, {multiplier: multiplier, format: format});

			}
			else {
				fancyProductDesigner.createImage(true, true, backgroundColor, {multiplier: multiplier, format: format});
			}

		}

	};

	function createPdf() {

		if(jQuery('#fpd-pdf-width').val() == '') {
			fpdMessage(fpd_order_viewer.no_width_text, 'error');
			return false;
		}
		else if(jQuery('#fpd-pdf-height').val() == '') {
			fpdMessage(fpd_order_viewer.no_height_text, 'error');
			return false;
		}

		fpdBlockPanel($tabsContent);

		function _renderData(data) {

			if(jQuery('[name="fpd_export_views"]:checked').val() == 'current') {
				var requestedIndex = data[fancyProductDesigner.currentViewIndex];
				data = [];
				data.push(requestedIndex);
			}

			var data_str = JSON.stringify(data);

			jQuery.ajax({
				url: fpd_admin_opts.adminAjaxUrl,
				data: {
					action: 'fpd_pdffromdataurl',
					_ajax_nonce: fpd_admin_opts.ajaxNonce,
					order_id: fpd_order_viewer.order_id,
					item_id: currentItemId,
					data_strings: data_str,
					width: jQuery('#fpd-pdf-width').val(),
					height: jQuery('#fpd-pdf-height').val(),
					image_format: jQuery('input[name="fpd_image_format"]:checked').val(),
					orientation: stageWidth > stageHeight ? 'L' : 'P',
					dpi: jQuery('#fpd-pdf-dpi').val().length == 0 ? 300 : jQuery('#fpd-pdf-dpi').val()
				},
				type: 'post',
				dataType: 'json',
				complete: function(data) {
					if(data == undefined || data.status != 200) {

						var message = '';
						if(data.responseJSON && data.responseJSON.message) {
							message += data.responseJSON.message;
						}
						message += '.\n';
						message += fpd_order_viewer.pdf_creation_fail_text;
						fpdMessage(message, 'error');

					}
					else {
						var json = data.responseJSON;
						if(json !== undefined) {
							window.open(json.url, '_blank');
						}
						else {
							fpdMessage(fpd_order_viewer.json_parse_error_text, 'error');
						}
					}

					fpdUnblockPanel($tabsContent);

				}
			});

		};

		var format = jQuery('input[name="fpd_image_format"]:checked').val(),
			backgroundColor = format == 'jpeg' ? '#ffffff' : 'transparent';

		if(format == 'svg') {
			_renderData(fancyProductDesigner.getViewsSVG());
		}
		else {

			var multiplier = jQuery('input[name="fpd_scale"]').val().length == 0 ? 1 : Number(jQuery('input[name="fpd_scale"]').val());
			fancyProductDesigner.getViewsDataURL(function(dataURLs) {
				_renderData(dataURLs);
			}, backgroundColor, {format: format, multiplier: multiplier});
		}

	};

	function _checkAPI() {

		if(fancyProductDesigner.currentViewInstance && fancyProductDesigner.currentViewInstance.stage.getObjects().length > 0 && isReady) {
			return true;
		}
		else {
			fpdMessage(fpd_order_viewer.no_fp_select_text, 'error');
			return false;
		}

	};

	function _popupBlockerEnabled(popup) {

		if (popup == null || typeof(popup)=='undefined') {
			fpdMessage(fpd_order_viewer.popup_block_text, 'info');
			return true;
		}
		else {
			return false;
		}

	}

});


function fpdLoadOrder(order) {

	if(typeof order !== 'object') { return false; }

	loadingProduct = true;
	$orderImageList.empty();
	fancyProductDesigner.clear();

	stageWidth = (order[0].options === undefined || order[0].options.stageWidth === undefined) ? stageWidth : order[0].options.stageWidth;
	stageHeight = (order[0].options === undefined || order[0].options.stageHeight === undefined) ? stageHeight : order[0].options.stageHeight;

	jQuery('input[name="fpd_scale"]').keyup();

	fancyProductDesigner.loadProduct(order);

	jQuery.ajax({

		url: fpd_admin_opts.adminAjaxUrl,
		data: {
			action: 'fpd_loadorderitemimages',
			_ajax_nonce: fpd_admin_opts.ajaxNonce,
			order_id: fpd_order_viewer.order_id,
			item_id: currentItemId
		},
		type: 'post',
		dataType: 'json',
		success: function(data) {

			if(data == undefined || data.code == 500) {

				fpdMessage(fpd_order_viewer.load_order_error_text, 'info');

			}
			//append order item images to list
			else if( data.code == 200 ) {

				for (var i=0; i < data.images.length; ++i) {
					var title = data.images[i].substr(data.images[i].lastIndexOf('/')+1);
					$orderImageList.append('<li><a href="'+data.images[i]+'" title="'+data.images[i]+'" target="_blank" >'+title+'</a></li>');
				}

			}

		}

	});

};