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
           // $("#albumForm").hide();
           // getAlbumList();
            
            setTimeout(function() {
                $('#resultMsg').fadeOut('fast');
                $("#resultMsg").removeClass("success");
                $("#resultMsg").removeClass("error");
            }, 3000);
            
        });
    });
    
    /* save artist art data */
    $('#saveDataArt').live("click", function () {
        var data = $("#saveDataArtForm").serialize();
           // artist_type: $('#artist_type').val(),
      /*  var data = {
            'action': 'save_art',
            //'file-upload': $('#file-upload').val(),
            'art_title': $('#art_title').val(),
            'art_category': $('#art_category').val(),
            'art_sub_category': $('#art_sub_category').val(),
            'art_colors': $('#art_colors').val(),
            'art_year': $('#art_year').val(),
            'art_description': $('#art_description').val()
        };*/
         alert(data);
        $.post(THEMEREX_ajax_url, data, function (msg) {
            alert(msg);
            $result = JSON.parse(msg);
            alert($result);
            $("#resultMsg").html($result.message);
            if($result.status) {
                $("#resultMsg").addClass("success");
            } else {
                $("#resultMsg").addClass("error");
            }
                       
        });
    });
});