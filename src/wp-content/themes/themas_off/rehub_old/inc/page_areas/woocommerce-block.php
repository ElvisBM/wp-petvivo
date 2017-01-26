<?php 
	$title_enable = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.woo_mod.0.woo_toggle_title');
	$title_name = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.woo_mod.0.woo_title');
	$title_position = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.woo_mod.0.woo_title_position');
	$title_url_title = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.woo_mod.0.woo_url_text');
	$title_url_url = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.woo_mod.0.woo_url_url');
	
    $module_fetch = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.woo_mod.0.woo_mod_fetch');
	$module_type = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.woo_mod.0.woo_mod_type');
    $product_cat = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.woo_mod.0.woo_cat');   

?>

<?php title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url) ?>
<?php echo do_shortcode ('[woo_mod show="'.$module_fetch.'" type="'.$module_type.'" showrow="3"]');?> 