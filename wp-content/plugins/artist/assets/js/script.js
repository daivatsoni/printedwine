jQuery(document).ready(function ($) {
    //abc();
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
                    'action': 'get_art'
                };
                $.get(THEMEREX_ajax_url, data1, function (msg) {
                    $result = JSON.parse(msg);
                    if($result.status) {
                        // refresh artist_profile_art_template.php
                    }
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
            'art_title': $('#art_title_'+artId).val(),
            'art_category': $('#art_category_'+artId).val(),
            'art_sub_category': $('#art_sub_category_'+artId).val(),
            'art_colors': $('#art_colors_'+artId).val(),
            'art_year': $('#art_year_'+artId).val(),
            'art_description': $('#art_description_'+artId).val()
        };
        alert(data);
        $.post(THEMEREX_ajax_url, data, function (msg) {
            console.log(msg);
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
    function abc(id){
        var artId = id;
        var data = {
            'action': 'save_art_update',
            'art_id': artId,
            'art_title': jQuery('#art_title_'+artId).val(),
            'art_category': jQuery('#art_category_'+artId).val(),
            'art_sub_category': jQuery('#art_sub_category_'+artId).val(),
            'art_colors': jQuery('#art_colors_'+artId).val(),
            'art_year': jQuery('#art_year_'+artId).val(),
            'art_description': jQuery('#art_description_'+artId).val()
        };
        alert(jQuery('#art_title_'+artId).val());
        jQuery.post(THEMEREX_ajax_url, data, function (msg) {
            alert(msg);
            console.log(msg);
            
                       
        });
        return false;
        }
});
