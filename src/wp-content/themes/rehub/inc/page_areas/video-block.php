<?php 
	$title_enable = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.video_mod.0.video_mod_toggle_title');
	$title_name = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.video_mod.0.video_mod_title');
	$title_position = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.video_mod.0.video_mod_title_position');
	$title_url_title = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.video_mod.0.video_mod_url_text');
	$title_url_url = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.video_mod.0.video_mod_url_url');

	$videolinks = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.video_mod.0.videolinks');	
    $playlist_host = vp_metabox('mag_builder_page.pagebuilders.'.$pbid.'.video_mod.0.playlist_host');	    
?>
<?php title_custom_block ($title_enable, $title_name, $title_position, $title_url_title, $title_url_url) ?>
<?php echo do_shortcode ('[video_mod videolinks="'.$videolinks.'" playlist_host="'.$playlist_host.'" playlist_width="stack"]');?> 