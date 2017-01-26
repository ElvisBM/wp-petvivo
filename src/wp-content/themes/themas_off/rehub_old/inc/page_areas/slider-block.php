<?php 
	$title_enable = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.slider_mod.0.slider_toggle_title');
	$title_name = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.slider_mod.0.slider_title');
	$title_position = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.slider_mod.0.slider_title_position');
	$title_url_title = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.slider_mod.0.slider_url_text');
	$title_url_url = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.slider_mod.0.slider_url_url');
	$module_fetch = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.slider_mod.0.slider_fetch');
	$slider_tag = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.slider_mod.0.slider_tag');
	$feat_tag = get_term_by('slug', $slider_tag, 'post_tag');
	$feat_tag_id = (!empty($feat_tag)) ? (int) $feat_tag->term_id : '';	    
?>

<?php title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url) ?>
<?php echo do_shortcode ('[wpsm_featured show="'.$module_fetch.'" feat_type="2" tag="'.$feat_tag_id.'" bottom_style="1"]');?>