jQuery(document).ready(function($) {

	//****** SETTINGS

	$('.radykal-settings-form')
	.on('click', 'input[readonly]', function() {
		$(this).select();
	});

	//Select2
	if($().select2) {

		$('.radykal-select2').select2({width: 'style'})
		.on("change", function (e) {

			var $this = $(this);
			if($this.nextAll('.fpd-select2-input:first').size() > 0) {
				var options = $this.select2('data'),
					optionIDs= [];

				for(var i=0; i < options.length; ++i) {
					optionIDs.push(options[i].id);
				}

				$this.nextAll('.fpd-select2-input:first').val(optionIDs.toString());

			}

		});

		$('.radykal-select2').each(function(i, select2) {

			var $select2 = $(select2);
			if($select2.is('select') && $select2.nextAll('.fpd-select2-input:first').size() > 0) {

				var order = $select2.nextAll('.fpd-select2-input:first').val().split(","),
					choices = [];

				order = order.filter(function(n){ return n != undefined && n.length > 0 }); //remove empty strings from array

				for (i = 0; i < order.length; i++) {
				    var option = $select2.find('option[value="' +order[i]+ '"]');
				    choices[i] = {id:order[i], text:option.text(), element: option};
				}

				$select2.select2('data', choices);

			}

		});

	}


	//Ace-Editor
	if(typeof ace !== undefined) {

		$('.radykal-ace-editor').each(function(i, item) {

			var editor = ace.edit(item);
			editor.setTheme("ace/theme/chrome");
			editor.setShowPrintMargin(false);
			editor.getSession().setMode("ace/mode/css");
			editor.getSession().on('change', function(evt) {
				$(editor.container).next('textarea').val(editor.getValue());
			});

		});

	}

	//Upload
	var radykalUploader = null;
	$('.radykal-add-image').click(function(evt) {

		evt.preventDefault();

		var $this = $(this);

		radykalUploader = wp.media({
			title: $this.parents('td:first').prev('th').text(),
            multiple: false
        });

		radykalUploader.$input = $this.nextAll('input:first');
		radykalUploader.on('select', function() {

			radykalUploader.$input.val(radykalUploader.state().get('selection').toJSON()[0].url);

			radykalUploader = null;
        });

        radykalUploader.open();

	});

	$('.radykal-remove-image').click(function(evt) {

		evt.preventDefault();

		$(this).prevAll('input:first').val('');

	});


	//TABS
	$('.radykal-tabs-nav a').click(function(evt) {

		evt.preventDefault();

		var $this = $(this);
		$this.addClass('current').siblings().removeClass('current');

		$this.parent().next('.radykal-tabs-content')
		.children('div').removeClass('current')
		.filter('[data-id="'+$this.attr('href')+'"]').addClass('current');

	});

	//Values Group
	$('.radykal-values-group-add').click(function(evt) {

		evt.preventDefault();

		var $this = $(this),
			$tbody = $this.parents('table:first').find('tbody'),
			$inputs = $this.parents('tr:first').find('input[type="text"]').removeClass('radykal-error'),
			valid = true;

		var valid = true;
		for(var i=0; i<$inputs.length; ++i) {
			var $input = $inputs.eq(i),
				regex = new RegExp($input.data('regex'), "i");

			if(regex.test($input.val()) === false) {
				$input.addClass('radykal-error');
				valid = false;
				break;
			}
		}

		if(valid) {
			var values = [];
			$inputs.each(function(i, item) {
				values.push(item.value);
			})
			_appendValuesGroupRow($tbody, values);
		}

		_saveValuesGroup($tbody);

	});

	$('.radykal-option-type--values-group .radykal-option-value').each(function(i, item) {

		var $tbody = $(this).parent().find('tbody'),
			value = item.value;

		if(value.trim().length <= 0) {
			return false;
		}

		var values = value.split(',');

		for(var i=0; i < values.length; ++i) {
			_appendValuesGroupRow($tbody, values[i].split(':'));
		}


	});


	//SLIDER
	 if(jQuery().slider) {

		$('.radykal-input-slider').each(function(i, slider) {

			var $slider = $(slider),
				$input = $slider.children('input');

			$slider.children('div').slider({
				range: 'min',
				min: Number($input.attr('min')),
				max: Number($input.attr('max')),
				step: Number($input.attr('step')),
				slide: function( event, ui ) {
			        $input.val( ui.value ).change();
			    }
			});

			$input.change(function () {
			    var value = this.value.substring(1);
			    $slider.children('div:first').slider("value", Number(this.value));
			});

		});

	}

	function _appendValuesGroupRow($tbody, values) {

		var row = '<tr>',
			prefix = '';

		for(var i=0; i<values.length; ++i) {
			if( $tbody.prev('thead').find('input').eq(i).prev('span').size() > 0) {
				prefix = $tbody.prev('thead').find('input').eq(i).prev('span').html();
			}
			row += '<td>'+prefix+'<span class="radykal-values-group-td-value">'+values[i]+'</span></td>';
		};

		row += '<td><a href="#" class="radykal-values-group-remove">&times;</a></td></tr>';
		$tbody.append(row)
		.find('tr:last .radykal-values-group-remove').click(function(evt) {

			evt.preventDefault();
			$(this).parents('tr:first').remove();
			_saveValuesGroup($tbody);

		});

	};

	function _saveValuesGroup($tbody) {

		var inputValue = '',
			$rows = $tbody.find('tr');

		$rows.each(function(i, row) {

			var $tds = $(row).children('td:not(:last)');
			$tds.each(function(j, td) {
				inputValue += $(td).children('.radykal-values-group-td-value').text();
				if(j < $tds.size()-1) {
					inputValue += ':';
				}
			});

			if(i < $rows.size()-1) {
				inputValue += ',';
			}

		});

		$tbody.parents('.radykal-option-type--values-group:first')
		.children('.radykal-option-value').val(inputValue);

	};


	//Multi Values
	$('.radykal-multi-values input[type="hidden"]').each(function() {

		var $this = $(this),
			$container = $this.parents('.radykal-multi-values'),
			unserializedFields = radykalSerializedStringToObject($this.val());

		$container.find('input[type="number"]').each(function(i, item) {
			$(item).val(unserializedFields[item.name]);
		});

	});

	$('.radykal-multi-values input[type="number"]').on('change keyup', function() {

		var $container = $(this).parents('.radykal-multi-values');
		$container.find('input[type="hidden"]').val($container.find('input[type="number"]').serialize());

	});


	//Colorpicker
	if($().wpColorPicker) {
		$('.radykal-color-picker').wpColorPicker({
			change: function(evt, ui) {

				var $input = $(this);
				setTimeout(function() {

					if($input.wpColorPicker('color') !== $input.data('tempcolor')) {
						$input.change().data('tempcolor', $input.wpColorPicker('color'));
					}

				}, 10);

			}
		});
	}


	//Relations
	$('input[data-relation]').change(function() {

		var $this = $(this),
			relationObj = radykalSerializedStringToObject($this.data('relation'));

		for (var key in relationObj) {
			if (relationObj.hasOwnProperty(key)) {
				var value = Boolean(parseInt(relationObj[key]));
				if($this.is(':checkbox')) {
					value = $this.is(':checked') ? value : !value;
				}
				$('#'+key).parents('tr:first').toggle(value);
			}
		}


	}).filter(':checked, :selected, :checkbox').change();

});

function radykalResetForm($form) {

	$form.find('[type="text"], [type="number"], textarea, select').val('');
	$form.find('[type="checkbox"], option').removeAttr('checked').removeAttr('selected');

};

function radykalFillForm($form, obj) {

	if(typeof obj === 'string') {

		try {
			//object string
			obj = JSON.parse(obj);
		}
		catch(e) {
			//if parameter string (serialized with $.serialize), create object
			obj = radykalSerializedStringToObject(obj);
		}

	}

	if($form) {

		radykalResetForm($form);

		for(var prop in obj) {
			if(obj.hasOwnProperty(prop)) {

				var value = obj[prop],
					$formElement = $form.find('[name="'+prop+'"]');

				if($formElement.is('[type="radio"]') || $formElement.is('[type="checkbox"]')) {
					$formElement.filter('[value="'+value+'"]').prop('checked', true);
				}
				else if($formElement.is('select')) {

					//multi values
					if(typeof value === 'object') {
						for(var i=0; i < value.length; ++i) {
							$formElement.children('[value="'+value[i]+'"]').prop('selected', true);
						}
					}
					//single value
					else {
						$formElement.children('[value="'+value+'"]').prop('selected', true);
					}

				}
				else {
					$formElement.val(value);
				}

			}
		}

	}

};

function radykalSerializedStringToObject(str) {

	var obj = new Object();

	var fields = str.split('&');
	for(var i=0; i < fields.length; ++i) {
		var field = fields[i].split('=');
		if(field[1] !== undefined) {
			obj[field[0]] = field[1];
		}

	}

	return obj;
};