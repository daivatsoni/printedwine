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
            $('.pw-wine-select .extended input:checkbox').prop('checked', false);
            $("#btnStep1").hide();
        }
    });    
});