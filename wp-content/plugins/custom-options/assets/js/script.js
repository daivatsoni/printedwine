jQuery(document).ready(function ($) {

    //Submit the Gallery Data 

    $('#saveData').live("click", function () {

        var data = {
            action: 'save_galery',
            title: $('.album_name').val(),
            user_id: $('.user_id').val(),
            post_type: $('.post_type').val()
        };

        $.post(THEMEREX_ajax_url, data, function (msg) {
            $("#resultMsg").html(msg);
        });
    });

    $('#createAlbum').on("click", function () {
        var data = {
            action: 'createForm'
        };

        $.post(THEMEREX_ajax_url, data, function (msg) {
            $("#resultMsg").html(msg);
        });
    });

});