<?php require_once(dirName(__FILE__).'/../../../../../../wp-load.php'); ?>
<script data-cfasync="false">
jQuery(document).ready(function() { 
	// handles the click event of the submit box
	jQuery('#submit').click(function(){
				//var offerlinkid = jQuery('#offerlinkid').val();
				var offerid = jQuery('#offerid').val();
				var offertype = jQuery('#offertype').val();

				if (offertype == 'review')
				{
					var shortcode = '[wpsm_top postid="'+offerid+'"] ';
				}
				else if(offertype == 'ceoffer'){
					var shortcode = '[wpsm_bigoffer post_id="'+offerid+'" ce_enable=1 pricealert=1] ';
				}							

		// inserts the shortcode into the active editor
		window.send_to_editor(shortcode);
		
		
		// closes Thickbox
		tb_remove();
				
			});
			
});

</script>

<form action="/" method="get" id="form" name="form" accept-charset="utf-8">
	
	<p>
	<label for="offerid"><?php _e('Type post name', 'rehub_framework') ;?></label>
	<input id="offerid" name="offerid" type="text" value="" />
	<small>You can choose several for reviews list</small>
	</p>
    
	<p>
		<label><?php _e('Type', 'rehub_framework') ;?></label>
		<select name="offertype" id="offertype" size="1">
            <option value="review" selected="selected"><?php _e('Review list item', 'rehub_framework') ;?></option>
            <option value="ceoffer"><?php _e('Post offer with comparison widget', 'rehub_framework') ;?></option>
        </select>
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
	jQuery("#offerid").tokenInput("$path_script", { 
		minChars: 3,
		preventDuplicates: true,
		theme: "rehub",
		onSend: function(params) {
			params.data.posttype = 'post';
			params.data.postnum = 6;
		}
	});
});
</script>
END;
?>