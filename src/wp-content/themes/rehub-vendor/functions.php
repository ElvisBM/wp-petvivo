<?php

if ( defined( 'RH_GRANDCHILD_DIR' ) ) {
	include( RH_GRANDCHILD_DIR . 'rh-grandchild-func.php' );
}

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
$classes[] = 'no_bg_wrap';
return $classes;
}

//////////////////////////////////////////////////////////////////
// Translation
//////////////////////////////////////////////////////////////////
add_action('after_setup_theme', 'rehubchild_lang_setup');
function rehubchild_lang_setup(){
    load_child_theme_textdomain('rehubchild', get_stylesheet_directory() . '/lang');
}