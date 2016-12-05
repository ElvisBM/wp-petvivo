<?php  
require_once(dirName(__FILE__).'/../../../../wp-load.php'); 

if ( empty( $_GET['q'] ) && !empty( $_GET['t'] ) ) {
	$taxonomies = $_GET['taxonomy'];
	$args = array(
		'search' => $_GET['t'],
		'hide_empty' => 1,
		'taxonomy'=> $taxonomies,
	);
	
	$terms = get_terms( $args );
	
	if ( !empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$tag_id = $term->term_id;
			$tag_name = $term->name;
			$search_array[] = array( 'id' => $tag_id, 'name' => $tag_name );
		}
	}

} else {
    $args = array(
        's' => $_GET['q'],
        'post_type' => $_GET['posttype'],
        'posts_per_page' => $_GET['postnum'],
        'post_status' => 'publish',
		'cache_results' => false,
		'no_found_rows' => true	    
    );

    $search_query = new WP_Query( $args );

    if ( !empty( $search_query->posts ) ) {
        foreach ( $search_query->posts as $post ) {
			$post_id = $post->ID;
			$post_title = $post->post_title;
			$search_array[] = array( 'id' => $post_id, 'name' => $post_title );
        }
		wp_reset_query();
    }
}

die( json_encode( $search_array ) );
