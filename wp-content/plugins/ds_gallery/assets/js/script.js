jQuery(document).ready(function ($) {

    // load available albums
    getAlbumList();

    $('#createAlbum').on("click", function () {
        var data = {
            action: 'createForm'
        };

        $.post(THEMEREX_ajax_url, data, function (msg) {
            $("#albumForm").show();
            $("#albumForm").html(msg);            
        });
    });

    //Submit the Gallery Data 
    $('#cancelAlbum').live("click", function () {
        $("#albumForm").hide();
    });
    $('#saveData').live("click", function () {

        var data = {
            action: 'save_galery',
            title: $('.album_name').val()
        };

        $.post(THEMEREX_ajax_url, data, function (msg) {
            $result = JSON.parse(msg);
            $("#resultMsg").html($result.message);
            if($result.status) {
                $("#resultMsg").addClass("success");
            } else {
                $("#resultMsg").addClass("error");
            }
            $("#albumForm").hide();
            getAlbumList();
            
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