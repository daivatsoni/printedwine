jQuery(document).ready(function( $ ) {
    
    //Every checkboxes in the page
    $('.pw-price-select .extended input:checkbox').change(function() {
        $('.extended input:checkbox').not(this).prop('checked', false);
        isChecked = $(this).prop('checked');
        if(isChecked) {
            var selPriceType = $(this).val();

            var data = {
                'action' : 'pw_filter_wines',
                'level' : selPriceType
            }
            // call ajax for filter data 
            $.get(THEMEREX_ajax_url, data, function(result) {
                // update HTML
                $("#wine-selector").html(result);
                $("#btnStep1").hide();
            });
        } else {
            // remove HTML
            $("#wine-selector").html("Select Price Range.");
            $("#btnStep1").hide();
        }
    });
    
    $('.pw-wine-select .extended input:checkbox').live('change', function(e) {
        currStatus = $(this).prop('checked');
        $(this).prop('checked', !currStatus);
    });
    
    $(".pw-wine-select .selWine").live("change", function() {
        selId = $(this).prop('id');
        selVal = $(this).val();
        chkId = 'chk-'+selId;
        if(selVal !="") {
            $('.pw-wine-select .extended input:checkbox').not($("#"+chkId)).prop('checked', false);
            $("#"+chkId).prop('checked', true);
            $("#btnStep1").show();
        } else {
            $("#"+chkId).prop('checked', false);
            $("#btnStep1").hide();
        }
    }); 
	
	Array.prototype.associate = function (keys) {
	  var result = {};

	  this.forEach(function (el, i) {
		result[keys[i]] = el;
	  });

	  return result;
	};
	
	/* Get All Let's Communicate form parameters send to the mailchimp functionality; */
	
	$('#lets_communicate').on("click",function(){
		
		var checkedArray = '';
		 checkedArray = $("#commnunicate").find(":checked").map(function (index) {
			return this.value;
		}).get();
		
		var indexArray = $("#commnunicate").find(".listIndex").map(function (index) {
			return this.value;
		}).get();
		
		var listIds = checkedArray.associate(checkedArray);
		
		var data = {
			'action': 'lets_communicate',
			'list_ids': listIds,    // We pass php values differently!
			'user_id': $('.user_id').val(),
			'user_email':$('.user_email').val(),
			'user_firstname':$('.user_firstname').val()
		};
		
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		$.post(THEMEREX_ajax_url, data, function(msg) {
			// TODO : Show Thank you subscribe/unsubscribe message based on selection;
			console.log(msg);
			$("#resultMsg").html(msg); // Append response to the viewer;
		});
		
		return false;
	
	});
	
	$('#wineandartAct').on("click",function(){
		
		var checkedArray = '';
		 checkedArray = $("#wineandart").find(":checked").map(function (index) {
			return this.value;
		}).get();
		
		var indexArray = $("#wineandart").find(".listIndex").map(function (index) {
			return this.value;
		}).get();
		
		var listIds = checkedArray.associate(checkedArray);
		
		var data = {
			'action': 'wine_and_art',
			'list_ids': listIds,    // We pass php values differently!
			'user_id': $('.user_id').val(),
			'user_email':$('.user_email').val(),
			'user_firstname':$('.user_firstname').val(),
			'user_lastname':$('.user_lastname').val()
		};
		
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		$.post(THEMEREX_ajax_url, data, function(msg) {
			// TODO : Show Thank you subscribe/unsubscribe message based on selection;
			console.log(msg);
			$("#resultMsg").html(msg); // Append response to the viewer;   
		});
		
		return false;
	
	});
	
	/* Get All Let's Chat's form parameters send to the mailchimp functionality; */
	
	$('#lets_chat').on("click",function(){
		var user_Val = $('.user_firstname').val();
		console.log('here'+user_Val+'.....');
				
		var data = {
			'action': 'lets_chat',
			'list_id': $('.chat_list_id').val(), //Get the Mailchimp list id of chat form submission
			'primary_phone': $('.primary_phone').val(),    
			'contact_hours': $('.contact_hours').val(),
			'contact_day':$('.contact_day').val(),
			'contact_time':$('.contact_time').val(),
			'user_email':$('.user_email').val(),
			'user_firstname':$('.user_firstname').val(),
			'user_id':$('.user_id').val()
		};
		
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		$.post(THEMEREX_ajax_url, data, function(msg) {
			// TODO : Show Thank you subscribe/unsubscribe message based on selection;
			console.log(msg+'Test----');
			console.log(data);
			$("#letcchat").html(msg); //Append the response to the viewer 
		});
		
		return false;	
	});
});