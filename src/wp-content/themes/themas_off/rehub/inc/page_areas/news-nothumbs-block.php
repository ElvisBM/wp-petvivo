<?php 
	$title_enable = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.news_no_thumbs_mod.0.news_no_thumbs_toggle_title');
	$title_name = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.news_no_thumbs_mod.0.news_no_thumbs_title');
	$title_position = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.news_no_thumbs_mod.0.news_no_thumbs_title_position');
	$title_url_title = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.news_no_thumbs_mod.0.news_no_thumbs_url_text');
	$title_url_url = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.news_no_thumbs_mod.0.news_no_thumbs_url_url');
	$module_cats = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.news_no_thumbs_mod.0.news_no_thumbs_cats');	    
?>

<?php title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url) ?>
<?php echo do_shortcode ('[news_no_thumbs_mod module_cats="'.$module_cats.'"]');?> 