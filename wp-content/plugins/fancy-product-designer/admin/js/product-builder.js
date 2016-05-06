jQuery(document).ready(function($) {

	var $fpd = $('#fpd-preview-wrapper'),
		fancyProductDesigner,
		viewInstance = null,
		stage = null,
		mediaUploader = null,
		$currentListItem = null,
		changesAreSaved = true,
		boundingBoxRect = null,
		$elementLists = $('#fpd-elements-list'),
		$parametersPanel = $('#fpd-edit-parameters > .radykal-tabs'),
		$parametersForm =  $('form#fpd-elements-form'),
		updatingFormFields = false,
		productCreated = false,
		initialProduct = [],
		pluginsOptions = {
			stageWidth: Number($fpd.data('stagewidth')),
			stageHeight: Number($fpd.data('stageheight')),
			responsive: false,
	    	langJSON: false,
	    	templatesDirectory: false,
	    	editorMode: true,
	    	keyboardControl: false,
	    	deselectActiveOnOutside: false,
	    	elementParameters: {
		    	originX: fpd_product_builder_opts.originX,
				originY: fpd_product_builder_opts.originY,
	    	},
	    	textParameters: {
		    	fontFamily: fpd_product_builder_opts.defaultFont,
				fontSize: 18
	    	}
		};

    $(".tm-input").tagsManager({
		delimiters: [13]
	})
	.on('tm:pushed', function(e, tag) {

		var $this = $(this);

		if(tag.search(',') > -1) {
			$this.tagsManager('popTag');
			var colorsArray = tag.split(',');
			for(var i=0; i < colorsArray.length; ++i) {
				$this.tagsManager('pushTag', colorsArray[i]);
			}
		}
		else {

			if(FPDUtil.isHex(tag)) {

				if(hasUpperCase(tag)) {
					$this.tagsManager('popTag');
					$this.tagsManager('pushTag', tag.toLowerCase());
				}

				$('.tm-tag:last').css('background-color', tag);
			}
			else {
				$this.tagsManager('popTag');
			}


		}

		_setParameters();

    }).on('tm:spliced', function(e, tag) {

    	_setParameters();

    });

    function hasUpperCase(str) {
	    return str.toLowerCase() != str;
	}

	//add color via btn
	$('#fpd-add-color').click(function(evt) {

		evt.preventDefault();

		var evt = jQuery.Event("keydown");
		evt.which = 13;
		$(".tm-input").trigger(evt);

	});

	//dropdown handler for choicing a view
	$('#fpd-view-switcher').change(function() {
		var $this = $(this);

		$('#fpd-submit').attr('action', fpd_product_builder_opts.adminUrl+"admin.php?page=fpd_product_builder&view_id="+$this.val()+"").submit();

	});

	//when select a list item, select the corresponding element in stage
	$elementLists.on('click', '.fpd-layer-item', function(evt) {
		stage.setActiveObject(viewInstance.getElementByID(this.id));
	});

	//make elements list sortable
	$elementLists.sortable({
		placeholder: 'fpd-sortable-placeholder',
		helper : 'clone',
		change: function(evt, ui) {

			//when item index changes, change also the z-index for the element in stage
			var newIndex = $elementLists.children('.fpd-layer-item').index(ui.item),
				element = viewInstance.getElementByID(ui.item.attr('id'));

			element.moveTo(newIndex);

			changesAreSaved = false;

		}
	});

	//change element text when related input text field is changed
	$elementLists.on('keyup', '[name="element_sources[]"]', function(evt) {

		var $this = $(this),
			activeObj = stage.getActiveObject();

		//when list item is not selected
		if(activeObj === undefined) {
			$this.parents('li:first').click();
			activeObj = stage.getActiveObject()
		}

		if(FPDUtil.getType(activeObj.type) == 'text') {
			activeObj.setText(this.value);
			activeObj.setCoords();
			stage.renderAll().calcOffset();
			$currentListItem.find('[name="element_titles[]"]').val(this.value);
		}

	});

	//change image source handler
	$elementLists.on('click', '.fpd-change-image', function(evt) {

		evt.preventDefault();

		var $this = $(this),
			$listItem = $this.parents('.fpd-layer-item:first'),
			element = viewInstance.getElementByID($listItem.attr('id'));

        mediaUploader = wp.media({
            title: fpd_product_builder_opts.chooseElementImageTitle,
            button: {
                text: fpd_product_builder_opts.set
            },
            multiple: false
        });

		mediaUploader.on('select', function() {

			fabric.util.loadImage(mediaUploader.state().get('selection').toJSON()[0].url, function(img) {

				$listItem.find('img').attr('src', img.src);
				$listItem.find('[name="element_sources[]"]').val(img.src);
				element.setElement(img);
				element.setCoords();
				stage.renderAll();

			});

			mediaUploader = null;

        });

        mediaUploader.open();

	});

	//element lock handler
	$elementLists.on('click', '.fpd-lock-element', function(evt) {

		evt.preventDefault();
		evt.stopPropagation();

		var $this = $(this),
			$lockInput = $('[name="locked"]'),
			element = viewInstance.getElementByID($this.parents('.fpd-layer-item:first').attr('id'));

		stage.setActiveObject(element);

		//lock
		if($this.children('i').hasClass('fpd-admin-icon-lock-open')) {
			$this.children('i').removeClass('fpd-admin-icon-lock-open').addClass('fpd-admin-icon-lock');
			$lockInput.prop('checked', true).change();
			element.set('evented', false);
			fancyProductDesigner.deselectElement();
		}
		//unlock
		else {
			$this.children('i').removeClass('fpd-admin-icon-lock').addClass('fpd-admin-icon-lock-open');
			$lockInput.prop('checked', false).change();
			element.set('evented', true);
		}

		_updateFormState();
	});

	//remove element
	$elementLists.on('click', '.fpd-trash-element', function(evt) {

		evt.preventDefault();
		evt.stopPropagation();

		var c = confirm(fpd_product_builder_opts.removeElement);
		if(!c) {
			return false;
		}

		viewInstance.removeElement(viewInstance.getElementByID($(this).parents('.fpd-layer-item:first').attr('id')));

	});

	//radio butons handler
	$('.fpd-radio-buttons').prevAll('.button').click(function(evt) {

		evt.preventDefault();

		var $this = $(this);

		$this.addClass('active').siblings('.button').removeClass('active');
		$this.nextAll('.fpd-radio-buttons').val($this.data('value')).change();

	});

	//toggle buttons handler
	$('.fpd-toggle-button').prevAll('.button').click(function(evt) {

		evt.preventDefault();

		var $this = $(this);
			$checkbox = $this.toggleClass('active').nextAll('.fpd-toggle-button').filter('[value="'+$this.data('value')+'"]');

		$checkbox .prop('checked', $this.hasClass('active')).change();

	});

	//lock/unlock prop scaling
	$('#fpd-scale-locker').click(function() {

		var $this = $(this);

		if($this.hasClass('fpd-admin-icon-lock')) {
			$this.removeClass().addClass('fpd-admin-icon-lock-open')
			.prev('label').removeClass('radykal-disabled');
		}
		else {
			$this.removeClass().addClass('fpd-admin-icon-lock')
			.prev('label').addClass('radykal-disabled');
		}

	});

	//undo/redo
	$('#fpd-undo, #fpd-redo').click(function(evt) {

		evt.preventDefault();

		if($(this).attr('id') == 'fpd-undo') {
			fancyProductDesigner.currentViewInstance.undo();
		}
		else {
			fancyProductDesigner.currentViewInstance.redo();
		}

	});

	//center fabric element
	$('#fpd-center-horizontal, #fpd-center-vertical').click(function(evt) {

		evt.preventDefault();

		var currentElement = stage.getActiveObject();
		if(currentElement) {

			if($(this).attr('id') == 'fpd-center-horizontal') {
				fancyProductDesigner.currentViewInstance.centerElement(true);
			}
			else {
				fancyProductDesigner.currentViewInstance.centerElement(false, true);
			}

			currentElement.setCoords();
			_setFormFields(currentElement);
		}

	});


	//submit form
	$('#fpd-save-layers').click(function(evt) {

		evt.preventDefault();

		if(productCreated) {
			$('[name="save_elements"]').click();
		}

	});

	//let the page know that elements are now saved
	$('input[name="save_elements"]').click(function() {

		fancyProductDesigner.deselectElement();
		changesAreSaved = true;

	});

	//switch responsive stage
	$('#fpd-responsive-stage-switch').change(function() {

		if($(this).is(':checked')) {

			$fpd.addClass('fpd-responsive-stage');
			viewInstance.options.responsive = true;
			viewInstance.resetCanvasSize();

		}
		else {

			$fpd.removeClass('fpd-responsive-stage');
			viewInstance.options.responsive = false;
			viewInstance.resetCanvasSize();

		}

	});



	//init fancy product designer
	$fpd.on('ready', function() {

		fancyProductDesigner = $(this).data('instance');

		$.ajax({
			url: fpd_admin_opts.adminAjaxUrl,
			data: {
				action: 'fpd_loadview',
				_ajax_nonce: fpd_admin_opts.ajaxNonce,
				view_id: $fpd.data('viewid')
			},
			type: 'post',
			dataType: 'json',
			success: function(data) {

				initialProduct = [{
					title: 'preview',
					thumbnail: '',
					elements: [],
					options: {}
				}];

				if(data && data.elements) {

					//V2 - views are serialized - string is newer
					var elements = typeof data.elements === 'string' ? JSON.parse(data.elements) : data.elements;

					//check that all number stings are parsed as number, <V3.0
					for(var i=0; i < elements.length; ++i) {

						var elementParams = elements[i].parameters;

						$.each(elementParams, function(key, value) {
							elementParams[key] = isNaN(value) ? value : Number(value);
						});

						var pbOpts = FPDUtil.rekeyDeprecatedKeys($.extend({}, elementParams));

						elements[i].parameters.pbOptions = pbOpts;

					}

					initialProduct[0].elements = elements;
				}

				fancyProductDesigner.toggleSpinner(true, fpd_product_builder_opts.loading);
				fancyProductDesigner.loadProduct(initialProduct);

			}
		});

	})
	.on('elementAdd', function(evt, element) {

		if(element.locked) {
			element.set('evented', false);
		}

		var type = FPDUtil.getType(element.type),
			imageHTML = type === 'image' ? "<img src='"+element.source+"' />" : "",
			imageToolHTML = type === 'image' ? "<a href='#' class='fpd-change-image'><i class='fpd-admin-icon-repeat'></i></a>" : "",
			lockedIcon = element.locked ? "fpd-admin-icon-lock" : "fpd-admin-icon-lock-open";

			//new element added
			if(element.pbOptions === undefined) {

				element.center();
				element.setCoords();
				stage.renderAll();

				element.pbOptions = {left: Math.round(element.left), top: Math.round(element.top)};

			}

		$elementLists.append("<div id='"+element.id+"' class='fpd-layer-item fpd-layer-item--"+type+"'><input type='text' name='element_titles[]' value='"+element.title+"' />"+imageHTML+"<textarea name='element_sources[]'>"+element.source+"</textarea><div class='fpd-layer-item-tools'>"+imageToolHTML+"<a href='#' class='fpd-lock-element'><i class='"+lockedIcon+"'></i></a><a href='#' class='fpd-trash-element'><i class='fpd-admin-icon-bin'></i></a></div><input type='hidden' name='element_types[]' value='"+type+"'/><input type='hidden' name='element_parameters[]' value='"+JSON.stringify(element.pbOptions)+"'/></div>");

		if(productCreated) {
			stage.setActiveObject(element);
			_setFormFields(element);
		}

	})
	.on('productCreate', function() {

		viewInstance = fancyProductDesigner.currentViewInstance;
		stage = viewInstance.stage;

		//create a bounding box rectangle
		boundingBoxRect = new fabric.Rect({
			stroke: 'blue',
			strokeWidth: 1,
			strokeDashArray: [5, 5],
			fill: false,
			selectable: false,
			visible: false,
			evented: false,
			selectable: false,
			transparentCorners: false,
			cornerSize: 20,
			originX: 'left',
			originY: 'top'
		});
		stage.add(boundingBoxRect);

		stage.on({
			'mouse:down': function(opts) {
				if(opts.target == undefined) {
					_updateFormState();
				}
			},
			'object:selected': function(opts) {

				if($currentListItem && opts.target.id !== $currentListItem.attr('id')) {
					$currentListItem.find('textarea, input').blur();
				}

				_updateFormState();
				_setFormFields();
				_setBoundingBox();

				setTimeout(function(){
					opts.target.setCoords();
					stage.calcOffset().renderAll();
				}, 50);

				opts.target.drawBorders(stage.contextContainer);
				opts.target.drawControls(stage.contextContainer);

			}
		});

		$('#fpd-manage-elements').removeClass('radykal-disabled');
		productCreated = true;

	})
	.on('elementRemove', function(evt, element) {

		$elementLists.children('#'+element.id).remove();
		_updateFormState();
		changesAreSaved = false;

	})
	.on('elementModify', function(evt, element, parameters) {

		if(productCreated) {

			if(parameters.text) {
				$elementLists.children('.fpd-layer-item#'+element.id+'')
				.find('[name="element_titles[]"], [name="element_sources[]"]')
				.val(parameters.text);
			}
			//only numeric values
			else if(parameters.hasOwnProperty('left') ||
					parameters.hasOwnProperty('angle') ||
					parameters.hasOwnProperty('scaleX') ||
					parameters.hasOwnProperty('fontSize')
				) {
				_setFormFields(element);
			}

		}

	})
	.on('undoRedoSet', function(evt, undos, redos) {

		_toggleUndoRedoBtn(undos, redos);

	});

	//initi FPD
	new FancyProductDesigner($fpd, pluginsOptions);


	//add new element buttons handler
	$('#fpd-add-image-element, #fpd-add-text-element, #fpd-add-curved-text-element, #fpd-add-upload-zone').click(function(evt) {
		evt.preventDefault();

		fancyProductDesigner.deselectElement();
		$currentListItem = null;

		var $this = $(this);

		//enter title
		var elementTitle = prompt(fpd_product_builder_opts.enterTitlePrompt+':', "");
		if(elementTitle == null) {
			return false;
		}
		else if(elementTitle.length == 0) {
			fpdMessage(fpd_product_builder_opts.enterTitlePrompt+'!', 'error');
			return false;
		}

		//add image or upload zone
		if(this.id == 'fpd-add-image-element' || this.id == 'fpd-add-upload-zone') {

			var addUploadZone = this.id == 'fpd-add-upload-zone';

	        mediaUploader = wp.media({
	            title: fpd_product_builder_opts.chooseElementImageTitle,
	            button: {
	                text: fpd_product_builder_opts.set
	            },
	            multiple: false
	        });

			mediaUploader.elementTitle = elementTitle;
			mediaUploader.on('select', function() {

				var imageParams = {};

				if(addUploadZone) {
					imageParams.uploadZone = 1;
				}

				fancyProductDesigner.addElement(
					'image',
					mediaUploader.state().get('selection').toJSON()[0].url,
					mediaUploader.elementTitle,
					imageParams
				);

				mediaUploader = null;
	        });

	        mediaUploader.open();

		}
		//add text
		else {

			var params = {};
			if(this.id == 'fpd-add-curved-text-element') {
				params.curved = 1;
				params.textAlign = 'center';
			}

			fancyProductDesigner.addElement(
				'text',
				elementTitle,
				elementTitle,
				params
			);

		}

    });


	//form change handler
	$parametersForm.on('change', 'input:not([name="hidden-colors"]), select', function(evt) {

		var $option = $(this),
			type = $option.attr('type');

		if($option.hasClass('fpd-svg-options') && $option.attr('name') == 'colors') {

			_toggleFormFields('.fpd-color-options:first input', Number($option.val()) === 0);

		}

		if(viewInstance && viewInstance.currentElement && updatingFormFields === false) {

			var params = {},
				key = $option.attr('name'),
				value = $option.val();

			if(type == 'checkbox') {

				params[key] = $option.is(':checked') ? 1 : 0;
				if($option.hasClass('fpd-toggle-button')) {
					params[key] = $option.is(':checked') ?  value : $option.data('unchecked');
				}

				if($option.data('checkedsel')) {
					$($option.data('checkedsel')).toggle($option.is(':checked'));
				}

				if($option.data('uncheckedsel')) {
					$($option.data('uncheckedsel')).toggle(!$option.is(':checked'));
				}

			}
			else if(key == 'fill' && !FPDUtil.isHex(value)) {
				params.fill = false;
			}
			else {

				if(key == 'scaleX' && $('#fpd-scale-locker').hasClass('fpd-admin-icon-lock')) {
					params.scaleY = Number(value);
				}

				params[key] = isNaN(value) || value === '' ? value : Number(value);
			}

			viewInstance.setElementParameters(params);

			_setParameters();
			_setBoundingBox();

		}

	})
	.on('keypress', function(evt) {

		if (evt.keyCode == 13) {
			$(evt.target).change();
			return false;
		}

	});

	//enable editing of the form when an element is selected in stage
	function _updateFormState() {

		updatingFormFields = true;

		var currentElement = stage.getActiveObject();

		$('.tm-input').tagsManager('empty');

		//object is selected
		if(currentElement && currentElement.selectable) {

			$parametersForm.find('input, select').prop('disabled', false);
			$elementLists.children('.fpd-layer-item').removeClass('fpd-active-item');
			$currentListItem = $elementLists.children('#'+currentElement.id).addClass('fpd-active-item');

			_hideTab('color-options', FPDUtil.elementIsColorizable(currentElement) === false);
			_hideTab('text-options', FPDUtil.getType(currentElement.type) !== 'text');
			_hideTab('upload-zone-options', !currentElement.uploadZone);
			_hideTab('bb-options', Boolean(currentElement.uploadZone));

			if(FPDUtil.elementIsColorizable(currentElement) === 'svg') {
				//if every path color is false or colors are set
				_toggleFormFields('.fpd-color-options:first input', Number(currentElement.colors) === 0 || $.isArray(currentElement.colors));
			}
			else {
				_toggleFormFields('.fpd-color-options input', FPDUtil.elementIsColorizable(currentElement));
			}

			$('.fpd-color-options').not(':first').toggleClass('radykal-hidden', FPDUtil.elementIsColorizable(currentElement) === 'svg');
			_toggleFormFields('.fpd-svg-options', FPDUtil.elementIsColorizable(currentElement) === 'svg');
			_toggleFormFields('.fpd-upload-zone-hidden', !currentElement.uploadZone);
			_toggleFormFields('.fpd-text-hidden', FPDUtil.getType(currentElement.type) !== 'text');


			$('.fpd-curved-text-opts').toggleClass('radykal-hidden', !currentElement.curved);
			if(currentElement.type === 'curvedText') {
				_toggleFormFields('[name="scaleX"], [name="scaleY"]', true);
			}

			$('#fpd-element-toolbar')
			.add($parametersPanel)
			.removeClass('radykal-disabled');

		}
		//no selected objecct
		else {

			$parametersPanel.addClass('radykal-disabled');
			$('#fpd-element-toolbar').addClass('radykal-disabled');
			$elementLists.children('.fpd-layer-item').removeClass('fpd-active-item');
			boundingBoxRect.visible = false;
			$currentListItem = null;

		}

		$parametersPanel.find('.radykal-tabs-nav > a:first').click();

	};

	//update form fields when element is changed via product stage
	function _setFormFields(element) {

		var formElementOpts = {},
			productBuilderOpts;

		if(element === undefined) { //get element properties from hidden input
			var elemParams = $currentListItem.children('[name="element_parameters[]"]').val();
			formElementOpts = JSON.parse(elemParams) || {},
			productBuilderOpts = formElementOpts;
		}
		else { //get properties from element
			productBuilderOpts = element;
		}

		$parametersForm.find('input, select').each(function(i, option) {

			var $option = $(option),
				type = $option.attr('type'),
				prop = $option.attr('name');

			if(type == 'text' || type == 'number') {

				if(productBuilderOpts.hasOwnProperty(prop) && productBuilderOpts[prop] !== false) {
					var value = productBuilderOpts[prop];

					if(type == 'number') {
						value = $option.hasClass('fpd-allow-dots') ? parseFloat(value).toFixed(2) : parseInt(value);
					}
					else {
						value = isNaN(value) ? value : '';
					}

					$option.val(value);

					if($option.prev('.ui-slider').size() > 0) {
						$option.prev('.ui-slider').slider('value', Number(value));
					}

					if($option.hasClass('wp-color-picker')) {
						$option.wpColorPicker('color', value);
					}


				}
				else {
					$option.val('');
				}

			}
			else if(type == 'checkbox') {

				if($option.hasClass('fpd-toggle-button')) {
					$option.prop('checked', productBuilderOpts[prop] == $option.val());
					$option.prevAll('.fpd-'+$option.val()+'.button').toggleClass('active', $option.is(':checked'));
				}
				else {
					$option.prop('checked', Boolean(productBuilderOpts[prop]) || false);

					if($option.data('checkedsel')) {
						$($option.data('checkedsel')).toggle($option.is(':checked'));

					}

					if($option.data('uncheckedsel')) {
						$($option.data('uncheckedsel')).toggle(!$option.is(':checked'));

					}

				}

			}
			else if(type == 'radio') {

				if(formElementOpts[prop] !== undefined) {
					$option.prop('checked', formElementOpts[prop] == $option.val());
				}

				if(prop == 'colors' && isNaN(formElementOpts[prop])) {
					$option.prop('checked', Number($option.val()) === 0);
				}

			}
			else if($option.is('select')) {

				if(prop == 'fontFamily') {
					$option.val(productBuilderOpts.hasOwnProperty(prop) ? productBuilderOpts[prop] : fpd_product_builder_opts.defaultFont);
				}
				else {
					$option.val(productBuilderOpts.hasOwnProperty(prop) ? productBuilderOpts[prop] : $option.val());
				}

				$option.children('option[value="'+productBuilderOpts[prop]+'"]').prop('selected', true);

				if(element === undefined) {
					$option.change();
				}

			}
			else if($option.hasClass('fpd-radio-buttons')) {

				$option.val((productBuilderOpts[prop] || $option.val()))
				.prevAll('.button').removeClass('active')
				.filter('[data-value="'+(productBuilderOpts[prop] || $option.val())+'"]').addClass('active');

			}


		});

		//set color tags
		if(productBuilderOpts.colors && productBuilderOpts.colors.length > 0 && unescape(productBuilderOpts.colors).charAt(0) == '#') {

			var colorArray = unescape(productBuilderOpts.colors).split(',');
			for(var i=0; i < colorArray.length; ++i) {
				$('.tm-input').tagsManager('pushTag', colorArray[i]);
			}

		}

		stage.calcOffset().renderAll();
		updatingFormFields = false;
		_setParameters();

	};

	function _hideTab(id, hide) {

		hide = hide === undefined ? true : hide;
		hide = Boolean(hide);

		$parametersPanel.find('.radykal-tabs-nav > [href="'+id+'"]').toggleClass('radykal-hidden', hide);
		$parametersPanel.find('.radykal-tabs-content > [data-id="'+id+'"]').find('input, select').prop('disabled', hide);

	};

	function _toggleFormFields(selector, toggle) {

		toggle = toggle === undefined ? false : toggle;
		toggle = Boolean(toggle);

		$(selector).each(function(i, field) {

			$(field).prop('disabled', !toggle)
			.parents('tr:first').toggle(toggle);

		});

	};

	function _setBoundingBox() {

		var target = JSON.parse($currentListItem.children('input[name="element_parameters[]"]').val());

		boundingBoxRect.visible = false;

		if(target.bounding_box_control && target.bounding_box_by_other && target.bounding_box_by_other.length > 0) {

			var targetElement = viewInstance.getElementByTitle(target.bounding_box_by_other);

			if(targetElement) {
				var boundingRect = targetElement.getBoundingRect();
				boundingBoxRect.left = boundingRect.left;
				boundingBoxRect.top = boundingRect.top;
				boundingBoxRect.width = boundingRect.width;
				boundingBoxRect.height = boundingRect.height;
				boundingBoxRect.visible = true;
			}

		}
		else if(target.bounding_box_x !== undefined &&
				target.bounding_box_y !== undefined &&
				target.bounding_box_width !== undefined &&
				target.bounding_box_height !== undefined) {

			boundingBoxRect.left = parseInt(target.bounding_box_x);
			boundingBoxRect.top = parseInt(target.bounding_box_y);
			boundingBoxRect.width = parseInt(target.bounding_box_width);
			boundingBoxRect.height = parseInt(target.bounding_box_height);
			boundingBoxRect.visible = true;

		}

		boundingBoxRect.setCoords();
		stage.renderAll();

	};

	function _setParameters() {

		if(!$currentListItem) {
			return;
		}

		var parameters = {};
		$parametersForm.find('input, select').each(function(i, option) {

			var $option = $(option);

			if(!$option.is(':disabled') && $option.val() !== '' && $option.attr('name') !== undefined) {

				var	key = $option.attr('name'),
					value = $option.val(),
					type = $option.attr('type');

				if(key === 'hidden-colors') {
					key = 'colors';
				}

				if(type == 'number' || type == 'text') {
					value = isNaN(value) ? value : Number(value);
				}
				else if(type == 'checkbox') {

					value = $option.is(':checked') ? 1 : 0;
					if($option.hasClass('fpd-toggle-button')) {
						value = $option.is(':checked') ? $option.val() : $option.data('unchecked');
					}
				}
				else if(type == 'radio') {
					value = $option.is(':checked') ? (isNaN($option.val()) ? $option.val() : Number($option.val())) : null;
				}

				if(value !== null) {
					parameters[key] = value;
				}

			}

		});

		$currentListItem.children('input[name="element_parameters[]"]').val(JSON.stringify(parameters));
		//console.log(parameters);

		changesAreSaved = false;

	};

	var _toggleUndoRedoBtn = function(undos, redos) {

		if(undos.length === 0) {
		  	$('#fpd-undo').addClass('radykal-disabled');
  		}
  		else {
	  		$('#fpd-undo').removeClass('radykal-disabled');
  		}

  		if(redos.length === 0) {
	  		$('#fpd-redo').addClass('radykal-disabled');
  		}
  		else {
	  		$('#fpd-redo').removeClass('radykal-disabled');
  		}

	};


	//check if changes are saved before page unload
	/*$(window).on('beforeunload', function () {
		if(!changesAreSaved) {
			return fpd_product_builder_opts.notChanged;
		}
	});*/

});