var cegg_p_stop = 0;
var cegg_start_prefill_begin = 0;
var cegg_xxx;
var cegg_in_action = false;
var cegg_post_ids = [];

jQuery(document).ready(function($) {

        updateProgress(0);

    jQuery('#start_prefill_begin').click(function() {
        if (cegg_in_action) {
            return false;
        }
        cegg_post_ids = content_egg_prefill.post_ids.slice();
        cegg_p_stop = 0;
        cegg_start_prefill_begin = 1;
        jQuery('#start_prefill').prop('disabled', true);
        jQuery('#start_prefill_begin').prop('disabled', true);
        jQuery('#stop_prefill').prop('disabled', false);
        updateProgress(0);
        jQuery("#filled").text(0);
        jQuery("#not_filled").text(jQuery("#total").text());
        jQuery("#logs").css("display", 'none');
        jQuery('#logs').html('');
        jQuery("#logs").css("height", '200px');
        if (jQuery("#logs").is(":hidden"))
            jQuery("#logs").slideDown("slow");

        prefill();
    });

    jQuery('#start_prefill').click(function() {
        if (cegg_in_action) {
            return false;
        }
        cegg_p_stop = 0;
        jQuery('#start_prefill').prop('disabled', true);
        jQuery('#start_prefill_begin').prop('disabled', true);
        jQuery('#stop_prefill').prop('disabled', false);
        //jQuery("#logs").css("display", 'none');
        //jQuery('#logs').html('');
        //jQuery("#logs").css("height", '200px');
        if (jQuery("#logs").is(":hidden"))
            jQuery("#logs").slideDown("slow");

        prefill();
    });

    jQuery('#stop_prefill').click(function() {
        cegg_p_stop = 1;
        cegg_xxx.abort();
        jQuery('#start_prefill').prop('disabled', false);
        jQuery('#start_prefill_begin').prop('disabled', false);
        jQuery('#stop_prefill').prop('disabled', true);
        jQuery('#ajaxBusy').hide();
        
    });

    // Ajax activity indicator bound
    // to ajax start/stop document events
    /*
    jQuery(document).ajaxStart(function() {
        cegg_in_action = true;
        jQuery('#ajaxBusy').show();
        jQuery('#ajaxWaiting').hide();

    }).ajaxStop(function() {
        cegg_in_action = false;
        jQuery('#ajaxBusy').hide();
    });
    */

});

function prefill() {
    
    jQuery('#ajaxBusy').show();
    
    if (cegg_post_ids.length == 0)
        cegg_post_ids = content_egg_prefill.post_ids.slice();
    
    var post_id = cegg_post_ids.shift();
    
    if (cegg_post_ids.length == 0)
        cegg_p_stop = 1;

    var prefill_url = ajaxurl + '?action=content-egg-prefill&post_id=' + post_id;    
    
    var module_id = jQuery("#module_id").val();
    var keyword_source = jQuery("#keyword_source").val();
    var keyword_count = jQuery("#keyword_count").val();
    var autoupdate = jQuery("#autoupdate").is(':checked');

    prefill_url += '&module_id=' + module_id;
    prefill_url += '&keyword_source=' + keyword_source;
    prefill_url += '&keyword_count=' + keyword_count;
    prefill_url += '&autoupdate=' + autoupdate;
    prefill_url += '&nonce=' + content_egg_prefill.nonce;

    cegg_xxx = jQuery.ajax({
        url: prefill_url,
        dataType: 'json',
        //dataType: (jQuery.browser.msie) ? "text" : "xml",
        cache: false,
        type: 'GET',
        timeout: 600000, //10min
        //data: 'cmd=' + cmd + required_plugins,
    });

    var progress = (content_egg_prefill.post_ids.length - cegg_post_ids.length) * 100 / content_egg_prefill.post_ids.length;


    cegg_xxx.done(function(data, textStatus) {
        jQuery('#logs').prepend(data['log'] + '<br />');
        //updateProgress(parseInt(data['progress']));
        jQuery("#total").text(data['total']);
        jQuery("#filled").text(data['filled']);
        jQuery("#not_filled").text(data['total'] - data['filled']);
        cmd = data['cmd'];
        cegg_start_prefill_begin = 0;
        updateProgress(progress);

        //stop prefill
        if (cegg_p_stop == 1 || cmd == 'stop') {
            if (cegg_p_stop)
                jQuery('#start_prefill').prop('disabled', false);
            else
                jQuery('#start_prefill').prop('disabled', true);

            jQuery('#start_prefill_begin').prop('disabled', false);
            jQuery('#stop_prefill').prop('disabled', true);
            jQuery('#ajaxWaiting').hide();
            jQuery('#ajaxBusy').hide();
            
            return false;
        } else {
            //recursion
            jQuery('#ajaxWaiting').show();
            //var pause = jQuery("#sleep").text();
            var pause = 300;
            setTimeout('prefill()', pause);
        }
    });

    cegg_xxx.fail(function(jqXHR, textStatus, errorThrown) {
        jQuery('#logs').prepend('<span class="label label-important">Error: ' + errorThrown + '</span><br>');
        updateProgress(progress);
        
        //stop prefill
        if (cegg_p_stop == 1) {
            jQuery('#start_prefill').prop('disabled', false);
            jQuery('#start_prefill_begin').prop('disabled', false);
            jQuery('#stop_prefill').prop('disabled', true);
            jQuery('#ajaxWaiting').hide();
            jQuery('#ajaxBusy').hide();
            
            return false;
        } else {
            //recursion
            jQuery('#ajaxWaiting').show();
            //var sleep = jQuery("#sleep").text();
            var sleep = 300;
            setTimeout('prefill()', sleep);
        }
    });


}

function updateProgress(percentage) {
    if (isNaN(percentage))
        return;
    if (percentage > 100)
        percentage = 100;
    
    jQuery( "#progressbar" ).progressbar({
      value: percentage
    });    
}