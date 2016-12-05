<?php 
	$title_enable = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.post_carousel_mod.0.post_carousel_toggle_title');
	$title_name = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.post_carousel_mod.0.post_carousel_title');
	$title_position = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.post_carousel_mod.0.post_carousel_title_position');
	$title_url_title = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.post_carousel_mod.0.post_carousel_url_text');
	$title_url_url = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.post_carousel_mod.0.post_carousel_url_url');
	$module_fetch = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.post_carousel_mod.0.post_carousel_fetch');
	$module_cats = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.post_carousel_mod.0.post_carousel_cats');
	$module_formats = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.post_carousel_mod.0.post_carousel_formats');		    
?>

<?php title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url) ?>
<?php echo do_shortcode ('[full_carousel data_source="cat" cat="'.$module_cats.'" post_formats="'.$module_formats.'" showrow="3" show="'.$module_fetch.'" style="2"]');?>