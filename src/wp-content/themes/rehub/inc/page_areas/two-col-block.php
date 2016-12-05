<?php 
	$title_enable = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_toggle_title');
	$title_name = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_title');
	$title_position = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_title_position');
	$title_url_title = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_url_text');
	$title_url_url = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_url_url');

	$module_cats_first = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_cats_1');
	$module_cats_second = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_cats_2');
	$post_formats_first = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_formats_1');
	$post_formats_second = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_formats_2');
    $module_offset_second = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_offset_2');	
    $module_fetch = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.two_col_news.0.two_col_news_module_fetch');
		    
?>
<?php title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url) ?>
<?php echo do_shortcode ('[two_col_news module_cats_first="'.$module_cats_first.'" module_cats_second="'.$module_cats_second.'" post_formats_first="'.$post_formats_first.'" post_formats_second="'.$post_formats_second.'"  module_offset_second="'.$module_offset_second.'" module_fetch="'.$module_fetch.'"]');?>           							