jQuery(document).ready(function ($) {

    $('#saveDataArtist').live("click", function () {
        
           // artist_type: $('#artist_type').val(),
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
    
    function getAlbumList() {
        var data = {
            action: 'get_albums'
        };

        $.post(THEMEREX_ajax_url, data, function (result) {
            $("#albumListContainer").html(result);
        });
    }

});