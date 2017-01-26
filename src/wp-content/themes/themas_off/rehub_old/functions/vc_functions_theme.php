<?php


//AFFILIATE LIST

if(function_exists('thirstyInit')) {

//Thirstylink Category Chooser
$thirstycats = get_terms( 'thirstylink-category'  );
$thirstycatchooser = array();
foreach ( $thirstycats as $t ) {
    $thirstycatchooser[] = array(
        'label' => $t->name,
        'value' => $t->term_id,
    );
}

vc_map( array(
    "name" => __('List of offers', 'rehub_framework'),
    "base" => "wpsm_afflist",
    "icon" => "icon-afflist",
    'deprecated' => '4.9',
    'description' => __('Works only with ThirstyAffiliate plugin', 'rehub_framework'), 
    "params" => array(
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Data source', 'rehub_framework'),
            "param_name" => "data_source",
            "value" => array(
                __('Category', 'rehub_framework') => "cat",
                __('Manual select and order', 'rehub_framework') => "ids",                  
            ), 
        ),      
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category', 'rehub_framework' ),
            'param_name' => 'cat',
            'settings' => array(
                'multiple' => true,
                'min_length' => 2,
                'display_inline' => true,
                'values' => $thirstycatchooser,
            ),
            'description' => __( 'Enter names of thirstylink categories', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'cat' ),
            ),          
        ), 
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Offer names', 'rehub_framework' ),
            'param_name' => 'ids',
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Or enter names of offers.', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'ids' ),
            ),                          
        ), 
        // Data settings
        array(
            'type' => 'dropdown',
            'heading' => __( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            'value' => array(
                __( 'Date', 'js_composer' ) => 'date',
                __( 'Order by post ID', 'js_composer' ) => 'ID',
                __( 'Title', 'js_composer' ) => 'title',
                __( 'Last modified date', 'js_composer' ) => 'modified',
                __( 'Meta value', 'js_composer' ) => 'meta_value',
                __( 'Meta value number', 'js_composer' ) => 'meta_value_num',
                __( 'Random order', 'js_composer' ) => 'rand',
            ),
            'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer' ),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids'),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Sorting', 'js_composer' ),
            'param_name' => 'order',
            'group' => __( 'Data settings', 'js_composer' ),
            'value' => array(
                __( 'Descending', 'js_composer' ) => 'DESC',
                __( 'Ascending', 'js_composer' ) => 'ASC',
            ),
            'description' => __( 'Select sorting order.', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Meta key', 'js_composer' ),
            'param_name' => 'meta_key',
            'description' => __( 'Input meta key for grid ordering.', 'js_composer' ),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'orderby',
                'value' => array( 'meta_value', 'meta_value_num' ),
            ),
        ),  
        array(
            "type" => "textfield",
            "heading" => __('Fetch Count', 'rehub_framework'),
            "param_name" => "show",
            "value" => '9',
            'description' => __('Number of products to display', 'rehub_framework'),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),          
        ),                                     
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Enable pagination?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "enable_pagination",
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),          
        ),  
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Disable link cloaking?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "no_cloaking",
        ),                                      
    )
) );

//AFFILIATE GRID
vc_map( array(
    "name" => __('Grid of offers', 'rehub_framework'),
    "base" => "wpsm_affgrid",
    "icon" => "icon-affgrid",
    'deprecated' => '4.9',
    'description' => __('Works only with ThirstyAffiliate plugin', 'rehub_framework'), 
    "params" => array(
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Data source', 'rehub_framework'),
            "param_name" => "data_source",
            "value" => array(
                __('Category', 'rehub_framework') => "cat",
                __('Manual select and order', 'rehub_framework') => "ids",                  
            ), 
        ),      
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Category', 'rehub_framework' ),
            'param_name' => 'cat',
            'settings' => array(
                'multiple' => true,
                'min_length' => 2,
                'display_inline' => true,
                'values' => $thirstycatchooser,
            ),
            'description' => __( 'Enter names of thirstylink categories', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'cat' ),
            ),          
        ), 
        array(
            'type' => 'autocomplete',
            'heading' => __( 'Offer names', 'rehub_framework' ),
            'param_name' => 'ids',
            'settings' => array(
                'multiple' => true,
                'sortable' => true,
                'groups' => false,
            ),
            'description' => __( 'Or enter names of offers.', 'rehub_framework' ),
            'dependency' => array(
                'element' => 'data_source',
                'value' => array( 'ids' ),
            ),                          
        ), 
        // Data settings
        array(
            'type' => 'dropdown',
            'heading' => __( 'Order by', 'js_composer' ),
            'param_name' => 'orderby',
            'value' => array(
                __( 'Date', 'js_composer' ) => 'date',
                __( 'Order by post ID', 'js_composer' ) => 'ID',
                __( 'Title', 'js_composer' ) => 'title',
                __( 'Last modified date', 'js_composer' ) => 'modified',
                __( 'Meta value', 'js_composer' ) => 'meta_value',
                __( 'Meta value number', 'js_composer' ) => 'meta_value_num',
                __( 'Random order', 'js_composer' ) => 'rand',
            ),
            'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer' ),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids'),
            ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Sorting', 'js_composer' ),
            'param_name' => 'order',
            'group' => __( 'Data settings', 'js_composer' ),
            'value' => array(
                __( 'Descending', 'js_composer' ) => 'DESC',
                __( 'Ascending', 'js_composer' ) => 'ASC',
            ),
            'description' => __( 'Select sorting order.', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Meta key', 'js_composer' ),
            'param_name' => 'meta_key',
            'description' => __( 'Input meta key for grid ordering.', 'js_composer' ),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'orderby',
                'value' => array( 'meta_value', 'meta_value_num' ),
            ),
        ),  
        array(
            "type" => "textfield",
            "heading" => __('Fetch Count', 'rehub_framework'),
            "param_name" => "show",
            "value" => '9',
            'description' => __('Number of products to display', 'rehub_framework'),
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),          
        ),                                     
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Enable pagination?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "enable_pagination",
            'group' => __( 'Data settings', 'js_composer' ),
            'dependency' => array(
                'element' => 'data_source',
                'value_not_equal_to' => array( 'ids' ),
            ),          
        ),
        array(
            "type" => "dropdown",
            "class" => "",
            "heading" => __('Set columns', 'rehub_framework'),
            "param_name" => "columns",
            "value" => array(
                __('3 columns', 'rehub_framework') => "3_col",
                __('4 columns', 'rehub_framework') => "4_col",                  
            ),
            'description' => __('4 columns is good only for full width row', 'rehub_framework'), 
        ),  
        array(
            "type" => "checkbox",
            "class" => "",
            "heading" => __('Disable link cloaking?', 'rehub_framework'),
            "value" => array(__("Yes", "rehub_framework") => true ),
            "param_name" => "no_cloaking",
        ),                                                             
    )
) );


add_filter( 'vc_autocomplete_wpsm_affgrid_ids_callback',
    'rehub_thirsty_search', 10, 1 ); 
add_filter( 'vc_autocomplete_wpsm_affgrid_ids_render',
    'rehub_thirsty_render', 10, 1 ); 
add_filter( 'vc_autocomplete_wpsm_offerlist_ids_callback',
    'rehub_thirsty_search', 10, 1 ); 
add_filter( 'vc_autocomplete_wpsm_offerlist_ids_render',
    'rehub_thirsty_render', 10, 1 );

function rehub_thirsty_search( $search_string ) {
    $query = $search_string;
    $data = array();
    $args = array( 's' => $query, 'post_type' => 'thirstylink' );
    $args['vc_search_by_title_only'] = true;
    $args['numberposts'] = - 1;
    if ( strlen( $args['s'] ) == 0 ) {
        unset( $args['s'] );
    }
    add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
    $posts = get_posts( $args );
    foreach ( $posts as $post ) {
        $data[] = array(
            'value' => $post->ID,
            'label' => $post->post_title,
        );
    }
    return $data;
}

function rehub_thirsty_render( $value ) {
    $post = get_post( $value['value'] );

    return is_null( $post ) ? false : array(
        'label' => $post->post_title,
        'value' => $post->ID,
    );
}

}