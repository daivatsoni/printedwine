
jQuery(document).ready(function ($) {
    
    /* save artist profile data */
    $('#saveDataArtist').live("click", function () {
        var data = {
            'action': 'save_artist',
            'artist_name': $('#artist_name').val(),
            'artist_country': $('#artist_country').val(),
            'artist_born_year': $('#artist_born_year').val(),
            'artist_type': $('#artist_type').val(),
            'artist_description': $('#artist_description').val(),
            'artist_awards': $('#artist_awards').val()
        };
        

        $.post(THEMEREX_ajax_url, data, function (msg) {
            $result = JSON.parse(msg);
            $("#resultMsg").html($result.message);
            if($result.status) {
                $("#resultMsg").addClass("success");
            } else {
                $("#resultMsg").addClass("error");
            }
            setTimeout(function() {
                $('#resultMsg').fadeOut('fast');
                $("#resultMsg").removeClass("success");
                $("#resultMsg").removeClass("error");
            }, 3000);
            
        });
        return false;
    });
    
    /* save artist art data */
    $('#saveDataArt').live("click", function () {
       // var data = $("#saveDataArtForm").serialize();
           // artist_type: $('#artist_type').val(),
        var data = {
            'action': 'save_art',
            'image_hidden_path': $('#image_hidden_path').val(),
            'art_title': $('#art_title').val(),
            'art_category': $('#art_category').val(),
            'art_sub_category': $('#art_sub_category').val(),
            'art_colors': $('#art_colors').val(),
            'art_year': $('#art_year').val(),
            'art_description': $('#art_description').val()
        };
        $.post(THEMEREX_ajax_url, data, function (msg) {
            $result = JSON.parse(msg);
            $("#resultMsg").html($result.message);
            if($result.status) {
                $("#resultMsg").addClass("success");
                var data1 = {
                    'action': 'get_art_get'
                };
                var data2 = {
                    'action': 'get_art_form'
                };
                $.get(THEMEREX_ajax_url, data1, function (msgss) {
                    $("artDataGet").html(''); 
                    $("#artDataGet").html(msgss);  
                });
                $.get(THEMEREX_ajax_url, data2, function (msgs) {
                    $("#artform").html('');  
                    $("#artform").html(msgs);  
                });
            } else {
                $("#resultMsg").addClass("error");
            }
                       
        });
        return false;
    });
    
    /* update artist art data */
    $('#save_art_update').live("click", function () {
        var artId = $('#form_id').val();
        var data = {
            'action': 'save_art_update',
            'art_id': artId,
            'image_hidden_path': $('#image_hidden_path_'+artId).val(),
            'art_title': $('#art_title_'+artId).val(),
            'art_category': $('#art_category_'+artId).val(),
            'art_sub_category': $('#art_sub_category_'+artId).val(),
            'art_colors': $('#art_colors_'+artId).val(),
            'art_year': $('#art_year_'+artId).val(),
            'art_description': $('#art_description_'+artId).val()
        };
        $.post(THEMEREX_ajax_url, data, function (msg) {
            $result = JSON.parse(msg);
            $("#resultMsg").html($result.message);
            if($result.status) {
                $("#resultMsg").addClass("success");
            } else {
                $("#resultMsg").addClass("error");
            }
                       
        });
        return false;
    });
    $("#art_category").change(function() {
        var data = {
            'action': 'get_subcategories',
            'art_category': $(this).val() //get option value from parent 
        };
        
        $.get(THEMEREX_ajax_url, data, function (msg) { 
                $("#art_sub_category").html(""); //reset child options
                $result = JSON.parse(msg);
                $("#art_sub_category").html($result.message);
        });
    });
    $('.sub').click(function(){
        var form = $(this);
        var id = form.attr('id').split('_');
        var artId = id[1];
        var data = {
            action: 'save_art_update',
            'art_id': artId,
            'art_title': $('#art_title_'+artId).val(),
            'image_hidden_path': $('#image_hidden_path_'+artId).val(),
            'art_category': $('#art_category_'+artId).val(),
            'art_sub_category': $('#art_sub_category_'+artId).val(),
            'art_colors': $('#art_colors_'+artId).val(),
            'art_year': $('#art_year_'+artId).val(),
            'art_description': $('#art_description_'+artId).val()
        };

        $.post(THEMEREX_ajax_url, data,  function(msg) {
           
            var result = $.parseJSON(msg);
        
            $("#resultMsg_"+artId).html(result.message);
            if(result.status) {
                $("#resultMsg_"+artId).addClass("success");
            } else {
                $("#resultMsg_"+artId).addClass("error");
            }
        });
        return false;   
    });
    
    $("#sortable-row" ).sortable({
        change: function( event, ui ) {
                var selectedLanguage = new Array();
                $('ul#sortable-row li').each(function() {
                    selectedLanguage.push($(this).attr("id"));
                }); 
                document.getElementById("row_order").value = selectedLanguage;
                //alert(("#row_order").val());
                var data = {
                    'action': 'set_art_order',
                    'art_order': document.getElementById("row_order").value 
                };
                $.post(THEMEREX_ajax_url, data, function (msg) { 
                    //var result = $.parseJSON(msg);
                    alert(msg);
                    $("#resultMsg").html(msg);
                    $("#resultMsg").addClass("success");
                    var data1 = {
                        'action': 'get_art_get'
                    };
                    var data2 = {
                        'action': 'get_art_form'
                    };
                    $.get(THEMEREX_ajax_url, data1, function (msgss) {
                        $("artDataGet").html(''); 
                        $("#artDataGet").html(msgss);  
                    });
                    $.get(THEMEREX_ajax_url, data2, function (msgs) {
                        $("#artform").html('');  
                        $("#artform").html(msgs);  
                    });
                });
                return false;
        }
    });
});
