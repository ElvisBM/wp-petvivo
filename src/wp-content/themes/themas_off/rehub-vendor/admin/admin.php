<?php

define('REHUB_ADMIN', get_stylesheet_directory() . '/admin');
define('REHUB_MAIN_ADMIN', get_template_directory() . '/admin');
define('REHUB_ADMIN_URI', get_stylesheet_directory_uri() . '/admin');
define('REHUB_NAME_ACTIVE_THEME', 'REVENDOR');

// require VafPress
require_once get_template_directory() . '/vafpress-framework/bootstrap.php';
load_theme_textdomain('rehubchild', get_stylesheet_directory() . '/lang');


// require data source
require_once get_template_directory() . '/admin/source.php';

$theme_options = REHUB_ADMIN . '/option/option.php';

$theme_options_obj = new VP_Option(array(
	'is_dev_mode'           => 	false, // dev mode, default to false
	'option_key' => 'rehub_option',
	'page_slug'  => 'vpt_option',
	'template'   => $theme_options,
	'menu_page'  => array(),
	'page_title' => __( 'Theme Options', 'rehubchild' ),
	'menu_label' => __( 'Theme Options', 'rehubchild' )
));
function rehub_option( $key )
{
    return vp_option( "rehub_option." . $key );
}

// load metaboxes

$post_type_metabox  = REHUB_MAIN_ADMIN . '/metabox/post_type.php';
$post_type_side_metabox  = REHUB_MAIN_ADMIN . '/metabox/post_type_side.php';
$page_review_metabox  = REHUB_MAIN_ADMIN . '/metabox/page_review.php';
$page_toptable_metabox  = REHUB_MAIN_ADMIN . '/metabox/page_toptable.php';
$page_topchart_metabox  = REHUB_MAIN_ADMIN . '/metabox/page_topchart.php';
//$fullwidth_grid_metabox  = REHUB_MAIN_ADMIN . '/metabox/fullwidth_grid.php';
$catalog  = REHUB_MAIN_ADMIN . '/metabox/catalogue_constructor.php';
if ( class_exists( 'woocommerce' ) ) { $woo_metabox  = REHUB_MAIN_ADMIN . '/metabox/woo_links.php'; }

$visual_builder_metabox  = REHUB_MAIN_ADMIN . '/metabox/visual_builder.php';
$multioffer_metabox  = REHUB_MAIN_ADMIN . '/metabox/multioffermeta.php';    
 
$post_type_metabox_obj = new VP_Metabox($post_type_metabox);
$post_type_metabox_side_obj = new VP_Metabox($post_type_side_metabox);
$page_review_metabox_obj = new VP_Metabox($page_review_metabox);
$page_toptable_metabox_obj = new VP_Metabox($page_toptable_metabox);
$page_topchart_metabox_obj = new VP_Metabox($page_topchart_metabox);
//$fullwidth_grid_metabox_obj = new VP_Metabox($fullwidth_grid_metabox);
$catalog_obj = new VP_Metabox($catalog);
if ( class_exists( 'woocommerce' ) ) { $woo_metabox_obj  = new VP_Metabox($woo_metabox); }
$visual_builder_metabox_obj = new VP_Metabox($visual_builder_metabox);
if (rehub_option('enable_multioffer') == 1)  {
    $multioffer_obj = new VP_Metabox($multioffer_metabox);
}   


/*
 * EOF
 */