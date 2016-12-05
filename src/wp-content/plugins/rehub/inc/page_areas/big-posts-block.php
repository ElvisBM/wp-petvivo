<?php 
	$title_enable = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_toggle_title');
	$title_name = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_title');
	$title_position = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_title_position');
	$title_url_title = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_url_text');
	$title_url_url = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_url_url');
	$module_cats = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_cats');
	$module_cats_in = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_cats_in');
	$module_fetch = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_fetch');
	$module_pagination = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_toggle_page');
	$module_offset = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_offset');
	$module_format = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.regular_blog_loop_mod.0.regular_blog_loop_format');	    
?>
<?php title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url) ?>
<?php echo do_shortcode ('[regular_blog_loop cat="'.$module_cats_in.'" cat_exclude="'.$module_cats.'" show="'.$module_fetch.'" offset="'.$module_offset.'" post_formats="'.$module_format.'" enable_pagination="'.$module_pagination.'"]');?> 