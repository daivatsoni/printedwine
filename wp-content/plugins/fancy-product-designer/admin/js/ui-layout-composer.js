jQuery(document).ready(function($) {

	if(!initial_opts) {
		return;
	}

	var $select = $('[name="fpd_ui_layouts"]'),
		$preview = $('#fpd-product-designer-preview'),
		$actionDropzones = $( '[data-id="actions"] .radykal-dropzone' ),
		$moduleDropzone = $( '[data-id="modules"] .radykal-dropzone' ),
		$availableActions = $('#fpd-available-actions'),
		$availableModules = $('#fpd-available-modules'),
		$composerForm = $('#composer-form'),
		$colorPickers = $('.composer-color-picker'),
		$window = $(window),
		isReady = false;


	/********************************
	******** SETUP ******************
	*********************************/

	var pluginOpts = $.extend({}, fpd_ui_layout_composer_opts.general_plugin_opts, initial_opts.plugin_options) ;
	pluginOpts.templatesType = 'php';
	//console.log(pluginOpts);

	var fancyProductDesigner = new FancyProductDesigner($preview, pluginOpts);

	$preview.on('ready', function() {

		//setup initial actions
		var actionKeys = Object.keys(fancyProductDesigner.actions.currentActions);
		for(var i=0; i < actionKeys.length; ++i) {

			var key = actionKeys[i],
				zoneActions = fancyProductDesigner.actions.currentActions[key],
				$dz = $actionDropzones.filter('[data-zone="'+key+'"]');

			for(var j=0; j < zoneActions.length; ++j) {

				_addItemToZone($dz, zoneActions[j], 'action');

			}

		}

		//setup initial modules
		var modules = fancyProductDesigner.mainBar.currentModules;
		for(var i=0; i < modules.length; ++i) {

			_addItemToZone($moduleDropzone, modules[i], 'module');
			$availableModules.children('[data-module="'+modules[i]+'"]').remove();

		}

		isReady = true;

	});

	/********************************
	******** TOP INTERACTIONS *******
	*********************************/

	$select.change(function() {

		$('[name="fpd_selected_layout"]').val($select.val())
		.parent('form').submit();

	});

	$('#fpd-save-as-new-layout, #fpd-save-layout').click(function(evt) {

		evt.preventDefault();

		if(!isReady) {return;}

		if(this.id == 'fpd-save-layout') { //overwrite

			var c = confirm(fpd_ui_layout_composer_opts.overwrite_info);
			if(c) {


				$('[name="fpd_method"]').val('save');
				$('[name="fpd_selected_layout"]').val($select.val());
				$('[name="fpd_ui_layout"]').val(getFormJSON($select.children(':selected').text()))
				.parent('form').submit();

			}

		}
		else {// save as new

			var title = prompt(fpd_admin_opts.enterTitlePrompt+':', '');

			if(title != null) {

				$('[name="fpd_method"]').val('save-new');
				$('[name="fpd_selected_layout"]').val(title);
				$('[name="fpd_ui_layout"]').val(getFormJSON(title))
				.parent('form').submit();

			}

		}

	});

	$('#fpd-delete-layout').click(function(evt) {

		evt.preventDefault();

		if(!isReady) {return;}

		var title = $select.val();

		if(title === 'default') {
			alert(fpd_ui_layout_composer_opts.fpd_ui_layout_composer_opts);
			return;
		}

		var c = confirm(fpd_ui_layout_composer_opts.delete_info);
		if(c) {

			$('[name="fpd_method"]').val('delete');
			$('[name="fpd_selected_layout"]').val($select.val())
			.parent('form').submit();

		}

	});

	$('#fpd-reset-to-default-layout').click(function(evt) {

		evt.preventDefault();

		var c = confirm(fpd_ui_layout_composer_opts.reset_default_info);
		if(c) {

			$('[name="fpd_method"]').val('reset');
			$('[name="fpd_selected_layout"]').val($select.val())
			.parent('form').submit();

		}

	});



	/********************************
	******** LAYOUT TAB *************
	*********************************/

	//main bar layout
	var availableLayouts = $('[name="layout"]').change(function() {

		fancyProductDesigner.deselectElement();

		$preview.removeClass(availableLayouts).addClass(this.value);

		$('#fpd-sidebar-tabs-position').toggleClass('radykal-disabled', this.value === 'fpd-topbar');

		if(this.value !== 'fpd-topbar') {
			$preview.addClass($('[name="sidebar_tabs_position"]:checked').val());
		}

		if(fancyProductDesigner && fancyProductDesigner.mainBar) {

			var contentWrapper = 'sidebar';
			if(this.value === 'fpd-topbar') {
				contentWrapper = 'draggable-dialog';
			}
			fancyProductDesigner.mainBar.setContentWrapper(contentWrapper);

		}

		$window.resize();
		$window.resize();

	}).map(getGroupValues).get().toString().replace(/,/g, ' ');

	//$('[name="layout"]').change();
	selectFormOptionByClass($('[name="layout"]'));


	//tab tab position
	var availableNavTypes = $('[name="sidebar_tabs_position"]').change(function() {

		$preview.removeClass(availableNavTypes).addClass(this.value);

	}).map(getGroupValues).get().toString().replace(/,/g, ' ');
	$('#fpd-sidebar-tabs-position').toggleClass('radykal-disabled', $preview.hasClass('fpd-topbar'));

	selectFormOptionByClass($('[name="sidebar_tabs_position"]'));

	//dimensions
	$('#stageWidth, #stageHeight').change(function() {

		fancyProductDesigner.setDimensions($('#stageWidth').val(), $('#stageHeight').val());
		//center demo shirt
		fancyProductDesigner.viewInstances[0].centerElement(true, true, fancyProductDesigner.viewInstances[0].getElementByTitle('demo-shirt'));
		fancyProductDesigner.viewInstances[1].centerElement(true, true, fancyProductDesigner.viewInstances[1].getElementByTitle('demo-shirt'));

	});

	//shadow
	var availableShadows = $('[name="shadow"]').change(function() {

		$preview.removeClass(availableShadows).addClass(this.value);

	}).children('option').map(getGroupValues).get().toString().replace(/,/g, ' ');
	selectFormOptionByClass($('[name="shadow"]'));

	//grid columns
	var availableGridColumns = $('[name="grid_columns"]').change(function() {

		removeGridColsClasses();
		$preview.addClass('fpd-grid-columns-'+this.value);
		$('.fpd-draggable-dialog').addClass('fpd-grid-columns-'+this.value);

	}).children('option').map(getGroupValues).get().toString().replace(/,/g, ' ');

	var removeGridColsClasses = function() {

		for(var i=0; i < availableGridColumns.length; ++i) {
			$preview.removeClass('fpd-grid-columns-'+availableGridColumns[i]);
			$('.fpd-draggable-dialog').removeClass('fpd-grid-columns-'+availableGridColumns[i])
		}

	};
	$('[name="grid_columns"]').children('option[value="'+pluginOpts.gridColumns+'"]').prop('selected', true);


	//initial active module
	var $initialActiveModuleSelect = $('[name="initial_active_module"]');
	for(var i=0; i < FPDMainBar.availableModules.length; ++i) {
		var module = FPDMainBar.availableModules[i];
		$initialActiveModuleSelect.append('<option value="'+module+'">'+(module.charAt(0).toUpperCase() + module.slice(1))+'</option>');
	}
	$initialActiveModuleSelect.children('[value="'+pluginOpts.initialActiveModule+'"]').prop('selected', true);


	//views selection pos
	var viewSelectionPos = $('[name="views_selection_pos"]').change(function() {

		$preview.removeClass(viewSelectionPos).addClass(this.value);

		if(this.value === 'fpd-views-outside') {

			$('.fpd-views-selection').insertAfter($preview);

		}
		else {

			$('.fpd-views-selection').appendTo($preview.find('.fpd-main-wrapper'));

		}

	}).map(getGroupValues).get().toString().replace(/,/g, ' ');
	selectFormOptionByClass($('[name="views_selection_pos"]'));



	/********************************
	******** MODULES TAB ************
	*********************************/
	var modules = FPDMainBar.availableModules;

	for(var i=0; i < modules.length; ++i) {

		$availableModules.append('<span class="radykal-label" data-module="'+modules[i]+'">'+modules[i].replace(/-/g, ' ')+'</span>');

	}

    $moduleDropzone.droppable({
	    hoverClass: 'radykal-dropzone-hover',
	    accept: '#fpd-available-modules .radykal-label',
	    drop: function(evt, ui) {

		    var $this = $(this);

		    _addItemToZone($this, ui.helper.data('module'), 'module');
		    ui.draggable.remove();
		    setupModules();

	    }
	})
	.sortable({
		items: '> .radykal-label',
		scroll: false,
		placeholder: "ui-sortable-placeholder",
		update: function() {
			setupModules();
		}
	});

	$moduleDropzone.on('dblclick', '.radykal-label', function() {

		var $this = $(this);

		$this.siblings('.radykal-dropzone-placeholder').toggle($this.siblings('.radykal-label').size() === 0);
		$this.appendTo($availableModules);

		_doModulesDraggable();
		setupModules();

	});

	var _doModulesDraggable = function() {

		$( ".radykal-label", $availableModules ).draggable({
			refreshPositions: true,
			cursor: "move",
			revert: "invalid"
	    });

	};

	_doModulesDraggable();

	function setupModules() {

		if(fancyProductDesigner && fancyProductDesigner.mainBar) {

			var modules = $moduleDropzone.children('.radykal-label').map(function(id, elem) {
				return $(elem).data('module');
			}).get();

			fancyProductDesigner.mainBar.setup(modules);

		}

	};


	/********************************
	******** ACTIONS TAB ************
	*********************************/
	var actions = FPDActions.availableActions;

	for(var i=0; i < actions.length; ++i) {

		var actionTooltip = '',
			actionCssClasses = 'radykal-label';

		if(actions[i] == 'info') {
			actionTooltip = fpd_ui_layout_composer_opts.info_action_tooltip;
			actionCssClasses += ' fpd-admin-tooltip';
		}

		$availableActions.append('<span class="'+actionCssClasses+'" data-action="'+actions[i]+'" title="'+actionTooltip+'">'+actions[i].replace(/-/g, ' ')+'</span>');

	}

	$( ".radykal-label", $availableActions ).draggable({
		helper: 'clone',
		cursor: "move"
    });

    $actionDropzones.droppable({
	    hoverClass: 'radykal-dropzone-hover',
	    accept: '#fpd-available-actions .radykal-label',
	    drop: function(evt, ui) {

		    var $this = $(this);

		    _addItemToZone($this, ui.helper.data('action'), 'action');
		    $actionDropzones.sortable('refreshPositions');
		    setupActions();

	    }
	})
	.sortable({
		items: '> .radykal-label',
		scroll: true,
		placeholder: "ui-sortable-placeholder",
		update: function() {
			setupActions();
		}
	});

	$actionDropzones.on('dblclick', '.radykal-label', function() {

		var $this = $(this);

		$this.siblings('.radykal-dropzone-placeholder').toggle($this.siblings('.radykal-label').size() === 0);
		$this.remove();

		setupActions();

	});

	$('.fpd-class-toggle-radio').change(function() {

		var $this = $(this),
			classes = $this.parents('div:first').find('[type="radio"]').map(getGroupValues).get().toString().replace(',', ' ');

		$preview.removeClass(classes).addClass(this.value);

	}).each(function(i, radio) {

		if($preview.hasClass(radio.value)) {
			$(radio).prop('checked', true);
		}

	});

	function setupActions() {

		if(fancyProductDesigner && fancyProductDesigner.actions) {

			var actionsObj = {};
			$actionDropzones.each(function(i, dz) {

				$dz = $(dz);

				var actions = $dz.children('.radykal-label').map(function(id, elem) {
					return $(elem).data('action');
				}).get();

				actionsObj[$dz.data('zone')] = actions;

			});

			fancyProductDesigner.actions.setup(actionsObj);

		}

	};


	/********************************
	******** COLORS TAB *************
	*********************************/

	var $previewStyle = $('#fpd-preview-styles'),
		$colorsPanel = $('.radykal-tabs-content [data-id="colors"]'),
		$updatePreviewBtn = $('#fpd-update-preview');

	$('.fpd-color-picker').wpColorPicker({
		change: function() {

			var $this = $(this);
			if($this.attr('name') == 'primary_color' || $this.attr('name') == 'secondary_color') {

				$updatePreviewBtn.removeClass('radykal-disabled');

			}

		}
	});

	$updatePreviewBtn.click(function(evt) {

		evt.preventDefault();

		fpdBlockPanel($colorsPanel);

		$.ajax({
			url: fpd_admin_opts.adminAjaxUrl,
			data: {
				action: 'fpd_getcss',
				_ajax_nonce: fpd_admin_opts.ajaxNonce,
				primary_color: $('[name="primary_color"]').val(),
				secondary_color: $('[name="secondary_color"]').val()
			},
			type: 'post',
			dataType: 'json',
			success: function(data) {

				if(data.error) {
					alert(data.error);
				}
				else {
					$previewStyle.text(data.css);
				}

				$updatePreviewBtn.addClass('radykal-disabled');
				fpdUnblockPanel($colorsPanel);

			}
		});

	});


	/********************************
	******** COMMON *****************
	*********************************/

	function getFormJSON(title) {

		removeGridColsClasses();

		var layout_json = {};
		layout_json.name = title;
		layout_json.plugin_options = {
			stageWidth: isNaN($('#stageWidth').val()) ? 1000 : Number($('#stageWidth').val()),
			stageHeight: isNaN($('#stageHeight').val()) ? 600 : Number($('#stageHeight').val()),
			gridColumns: $('[name="grid_columns"]').val(),
			initialActiveModule: $('[name="initial_active_module"]').val(),
			selectedColor: $('[name="element_boundary_color"]').val(),
			boundingBoxColor: $('[name="bounding_box_color"]').val(),
			outOfBoundaryColor: $('[name="out_of_bounding_box_color"]').val(),
			cornerIconColor: $('[name="corner_control_icons_color"]').val(),
			mainBarModules: fancyProductDesigner.mainBar.currentModules,
			actions: fancyProductDesigner.actions.currentActions
		};
		layout_json.container_classes = $preview.attr('class');
		layout_json.css_colors = {
			primary_color: $('[name="primary_color"]').val(),
			secondary_color: $('[name="secondary_color"]').val()
		};

		var editor = ace.edit(document.getElementById('fpd-custom-css'));
		layout_json.custom_css = editor.getValue();

		return JSON.stringify(layout_json);

	};

	function selectFormOptionByClass($options) {

		if($options.is('select')) {

			$options.children().each(function(i, option) {
				if($preview.hasClass(option.value)) {
					$(option).prop('selected', true);
				}
			});

		}
		else {

			$options.each(function(i, option) {
				if($preview.hasClass(option.value)) {
					$(option).prop('checked', true);
				}
			});

		}

	};

	function getGroupValues(id, elem) {
		return $(elem).val();
	};

	function _addItemToZone($zone, value, type) {

		$zone.append('<span class="radykal-label" data-'+type+'="'+value+'">'+value.replace(/-/g, ' ')+'</span>');
		$zone.children('.radykal-dropzone-placeholder').toggle($zone.children('.radykal-label').size() === 0);

	};

	fpdUpdateTooltip();

});