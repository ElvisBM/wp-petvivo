<?php require_once(dirName(__FILE__).'/../../../../../../wp-load.php'); ?>

<script data-cfasync="false">
// executes this when the DOM is ready
jQuery(document).ready(function() {
	// handles the click event of the submit button
	jQuery('#submit').click(function(){
        var idvalue = jQuery('#woocompare-ids').val();       
        var show_vendor = jQuery('#show_vendor');
		var shortcode = '[wpsm_woocompare';

		if (idvalue !='') {
			shortcode += ' ids="' + idvalue + '"';
		}

		if(show_vendor.is(":checked")) {
			shortcode += ' show_vendor="1"';
		}		

		shortcode += ']';

		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);		
		
		// closes Thickbox
		tinyMCEPopup.close();
	});
}); 
</script>
<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
    <p><label><?php _e('Add products', 'rehub_framework') ;?></label>
        <input type="text" name="woocompare-ids" value="" id="woocompare-ids" /><br />
		<small></small>
    </p> 
	<p>
		<label><?php _e('Show logos of vendors?', 'rehub_framework') ;?></label>

        <input id="show_vendor" name="show_vendor" type="checkbox" class="checks" value="false" />
        <small><?php _e('This option will work only if you use WC Vendor plugin', 'rehub_framework') ;?></small>
	</p>    
	<p>
        <label>&nbsp;</label>
        <input type="button" id="submit" class="button" value="<?php _e('Insert', 'rehub_framework') ;?>" name="submit" />
    </p>
</form>
<?php
$path_script = get_template_directory_uri() . '/jsonids/json-ids.php';
print <<<END
<script data-cfasync="false">
jQuery(document).ready(function () {
	jQuery("#woocompare-ids").tokenInput("$path_script", { 
		minChars: 3,
		preventDuplicates: true,
		theme: "rehub",
		onSend: function(params) {
			params.data.posttype = 'product';
			params.data.postnum = 6;
		}
	});
});
</script>
END;
?>