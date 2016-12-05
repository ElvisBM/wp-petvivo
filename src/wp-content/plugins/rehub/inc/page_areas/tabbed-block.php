<?php 
	$title_enable = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_toggle_title');
	$title_name = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_title');
	$title_position = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_title_position');
	$title_url_title = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_url_text');
	$title_url_url = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_url_url');
	
    $module_cats_first = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_cats_1');
	$module_cats_second = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_cats_2');
	$module_cats_third = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_cats_3');
	$module_cats_fourth = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_cats_4');	
	
    $module_name_first = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_name_1');
	$module_name_second = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_name_2');
	$module_name_third = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_name_3');
	$module_name_fourth = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.tab_mod.0.tab_mod_name_4');

?>
<?php title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url) ?>
<?php echo do_shortcode ('[tab_mod module_name_first="'.$module_name_first.'" module_name_second="'.$module_name_second.'" module_name_third="'.$module_name_third.'" module_name_fourth="'.$module_name_fourth.'" module_cats_first="'.$module_cats_first.'" module_cats_second="'.$module_cats_second.'" module_cats_third="'.$module_cats_third.'" module_cats_fourth="'.$module_cats_fourth.'"]');?> 