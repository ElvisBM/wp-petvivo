<?php

//////////////////////////////////////////////////////////////////
// AJAX SEARCH
//////////////////////////////////////////////////////////////////
ini_set('html_errors', 0);
define( 'SHORTINIT', true );

require_once(dirName(__FILE__).'/../../../../wp-load.php');

require( ABSPATH . WPINC . '/formatting.php' );
require( ABSPATH . WPINC . '/class-wp-tax-query.php' );
require( ABSPATH . WPINC . '/class-wp-meta-query.php' );
require( ABSPATH . WPINC . '/l10n.php' );
require( ABSPATH . WPINC . '/user.php' );
require( ABSPATH . WPINC . '/class-wp-user.php' );
require( ABSPATH . WPINC . '/pluggable.php' );
require( ABSPATH . WPINC . '/query.php' );
require( ABSPATH . WPINC . '/meta.php' );
require( ABSPATH . WPINC . '/class-wp-post.php' );
require( ABSPATH . WPINC . '/post.php' );
require( ABSPATH . WPINC . '/taxonomy.php' );


wp_plugin_directory_constants();


    $buffer = $buffer_msg = '';

    //the search string
    if (!empty($_POST['re_string'])) {
        $re_string = $_POST['re_string'];
    } else {
        $re_string = '';
    }

    //the post types for search    
    if (!empty($_POST['posttypesearch'])) {
        $posttypes = $_POST['posttypesearch'];
        $posttypes = explode(',', $posttypes);
    } else {
        $posttypes = array('post');
    }

    //get the data
    $args = array(
        's' => $re_string,
        'post_type' => $posttypes,
        'posts_per_page' => 5,
        'post_status' => 'publish',
        'cache_results' => false,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'no_found_rows' => true     
    );

    $search_query = new WP_Query($args);

    //build the results
    if (!empty($search_query->posts)) {
        foreach ($search_query->posts as $post) {
            $title = get_the_title( $post->ID );
            $url = get_permalink( $post->ID );
            $the_price = get_post_meta( $post->ID, '_price', true);         
            if ( has_post_thumbnail($post->ID) ){
                $image_id = get_post_thumbnail_id($post->ID);  
                $image_url = wp_get_attachment_image_src($image_id, 'med_thumbs');  
                $image_url = $image_url[0];
            }
            else {
                $image_url = get_template_directory_uri() . '/images/default/noimage_123_90.png' ;
            } 
            if ( '' != $the_price ) {
                $the_price = strip_tags( wc_price( $the_price ) );
            } else {
                $the_price = '';
            }

            $buffer .= '<div class="re-search-result-div">';
            $buffer .= '<div class="re-search-result-thumb"><a href="'.$url.'"><img src="'.$image_url.'" alt=""/></a></div>';
            $buffer .= '<div class="re-search-result-info"><h3 class="re-search-result-title">'.rh_expired_or_not($post->ID, "span").'<a href="'.$url.'">'.$title.'</a></h3>';
            if ( empty( $post->post_excerpt ) ) {
                $buffer .= '<div class="re-search-result-excerpt">'.rehub_truncate("maxchar=150&text=$post->post_content&echo=false").'</div>';
            } else {
                $buffer .= '<div class="re-search-result-excerpt">'.rehub_truncate("maxchar=150&text=$post->post_excerpt&echo=false").'</div>'; 
            }            

            if ( '' != $the_price ) {
                $buffer .= '<span class="re-search-result-price">'.$the_price.'</span>';
            } else {
                $buffer .= '<span class="re-search-result-meta">'.get_the_time(get_option( 'date_format' ), $post->ID).'</span>';
            }
            $buffer .= '</div></div>';
        }
    }

    if (count($search_query->posts) == 0) {
        //no results
        $buffer = '<div class="re-aj-search-result-msg no-result">' . __('No results', 'rehub_framework') . '</div>';
    } else {
        $buffer_msg .= '<div class="re-aj-search-result-msg"><a href="' . esc_url(home_url('/?s=' . $re_string.'&post_type='.$posttypes )) . '">' . __('View all results', 'rehub_framework') . '</a></div>';
        //add wrap
        $buffer = '<div class="re-aj-search-wrap-results">' . $buffer . '</div>' . $buffer_msg;
    }

    //prepare array for ajax
    $bufferArray = array(
        're_data' => $buffer,
        're_total_inlist' => count($search_query->posts),
        're_search_query'=> $re_string
    );

    //Return the String
    die(json_encode($bufferArray));