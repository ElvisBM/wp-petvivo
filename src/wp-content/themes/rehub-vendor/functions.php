<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_theme_style' );
function enqueue_parent_theme_style() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
	if (is_rtl()) {
		 wp_enqueue_style( 'parent-rtl', get_template_directory_uri().'/rtl.css' );
	}    
}

// Add specific CSS class by filter
add_filter('body_class','style_body_repick');
function style_body_repick($classes) {
$classes[] = 'separate_sidebar_bg';
//if (rehub_option('rehub_bg_flat_color') !='' || rehub_option('rehub_color_background') !='' ){ 
	$classes[] = 'colored_bg';
//}	
//if (rehub_option('rehub_content_shadow') !='' ){ 
	$classes[] = 'no_bg_wrap';
//}
	// return the $classes array
	return $classes;
}

// repick scripts
function revendor_js_scripts() {
	wp_enqueue_script( 'revendor_js', get_stylesheet_directory_uri().'/js/revendor_js.js', array('jquery'), '1.0', 1 );	
}
//add_action('wp_enqueue_scripts','revendor_js_scripts', 11);

//////////////////////////////////////////////////////////////////
// Translation
//////////////////////////////////////////////////////////////////
add_action('after_setup_theme', 'rehubchild_lang_setup');
function rehubchild_lang_setup(){
    load_child_theme_textdomain('rehubchild', get_stylesheet_directory() . '/lang');
}