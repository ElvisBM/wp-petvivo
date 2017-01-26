<?php

//////////////////////////////////////////////////////////////////
// Function for extract args from VC filter
//////////////////////////////////////////////////////////////////

if( !class_exists('WPSM_Postfilters') ) {
class WPSM_Postfilters{
	public $filter_args = array(
		'data_source'=>'cat',
		'cat'=>'',
		'tag'=>'',
		'cat_exclude'=>'',
		'tag_exclude'=>'',
		'ids'=>'',
		'orderby'=>'',
		'order '=> 'DESC',
		'meta_key'=>'',
		'show'=>12,
		'offset'=>'',
		'show_date' => '',		
		'post_type'=>'',
		'tax_name'=>'',
		'tax_slug'=>'',
		'tax_slug_exclude'=>'',
		'post_formats'=>'',
		'badge_label '=>'1',
		'enable_pagination'=>'',
		'show_coupons_only'=>'',
	);
	function __construct( $filter_args = array() ){
		$this->set_opt( $filter_args );
		return $this;
	}
	function set_opt( $filter_args = array() ){
		$this->filter_args = (object) array_merge( $this->filter_args, (array) $filter_args );
	}	
	public function extract_filters(){

		$filter_args = & $this->filter_args;

	    if ($filter_args->data_source == 'ids' && $filter_args->ids !='') {
	    	$ids = array_map( 'trim', explode( ",", $filter_args->ids ) );
	        $args = array(
	            'post__in' => $ids,
	            'numberposts' => '-1',
	            'orderby' => 'post__in', 
	            'ignore_sticky_posts' => 1,
	            'post_type'=> 'any'            
	        );
	    }
	    elseif ($filter_args->data_source == 'cat') {
	        $args = array(
	            'post_type' => 'post',
	            'posts_per_page'   => (int)$filter_args->show, 
	            'orderby' => $filter_args->orderby,
	            'order' => $filter_args->order,                  
	        );	        
	        if ($filter_args->offset != '') {$args['offset'] = (int)$filter_args->offset;}
	        if (($filter_args->orderby == 'meta_value' || $filter_args->orderby == 'meta_value_num') && $filter_args->meta_key !='') {$args['meta_key'] = $filter_args->meta_key;}
	        if ($filter_args->cat !='') {$args['cat'] = $filter_args->cat;}
	        if ($filter_args->tag !='') {$args['tag__in'] = array_map( 'trim', explode(",", $filter_args->tag ));}
	        if ($filter_args->cat_exclude !='') {$args['category__not_in'] = array_map( 'trim', explode(",", $filter_args->cat_exclude ));}
	        if ($filter_args->tag_exclude !='') {$args['tag__not_in'] = explode(',', $filter_args->tag_exclude);}
	        if ($filter_args->post_formats != 'all' && $filter_args->post_formats != '') {$args['meta_key'] = 'rehub_framework_post_type'; $args['meta_value'] = $filter_args->post_formats;}
	    } 
	    elseif ($filter_args->data_source == 'badge') {
	        $args = array(
	            'post_type' => 'any',
	            'posts_per_page'   => (int)$filter_args->show, 
	            'orderby' => $filter_args->orderby,
	            'order' => $filter_args->order,                  
	        );
	        if ($filter_args->offset != '') {$args['offset'] = (int)$filter_args->offset;}
	        if (($filter_args->orderby == 'meta_value' || $filter_args->orderby == 'meta_value_num') && $filter_args->meta_key !='') {$args['meta_key'] = $filter_args->meta_key;}
	        $args['meta_query'] = array(
	    		array(
					'key'     => 'is_editor_choice',
					'value'   => $filter_args->badge_label,
					'compare' => '=',        			
	    		)
	        );
	        if ($filter_args->post_formats != 'all' && $filter_args->post_formats != '') {
	        	$args['meta_query'][] = array(
						'key'     => 'rehub_framework_post_type',
						'value'   => $filter_args->post_formats,
						'compare' => '=',         		
	        		);
	        }
	    }      
	    elseif ($filter_args->data_source == 'cpt') {
	        $args = array(
	            'post_type' => $filter_args->post_type,
	            'posts_per_page'   => (int)$filter_args->show, 
	            'orderby' => $filter_args->orderby,
	            'order' => $filter_args->order,                  
	        );
	        if ($filter_args->offset != '') {$args['offset'] = (int)$filter_args->offset;}
	        if (($filter_args->orderby == 'meta_value' || $filter_args->orderby == 'meta_value_num') && $filter_args->meta_key !='') {$args['meta_key'] = $filter_args->meta_key;}
	        if ($filter_args->post_formats != 'all' && $filter_args->post_formats != '') {$args['meta_key'] = 'rehub_framework_post_type'; $args['meta_value'] = $filter_args->post_formats;}
	        if (!empty ($filter_args->tax_name) && !empty ($filter_args->tax_slug)) {
	            $args['tax_query'] = array (
	                array(
	                    'taxonomy' => $filter_args->tax_name,
	                    'field'    => 'slug',
	                    'terms'    => array($filter_args->tax_slug),
	                )
	            );
	        }
	        if (!empty ($filter_args->tax_name) && !empty ($filter_args->tax_slug_exclude)) {
	            $args['tax_query'] = array (
	                array(
	                    'taxonomy' => $filter_args->tax_name,
	                    'field'    => 'slug',
	                    'terms'    => array($filter_args->tax_slug_exclude),
	                    'operator' => 'NOT IN',
	                ),
	            );
	        }        
	    } 
	    if ($filter_args->show_coupons_only == '1') { 
	    	$args['meta_query']['relation'] = 'AND';    
	        $args['meta_query'][] = array(
	            'key'     => 'rehub_offer_product_price_old',
	            'value' => '',
	            'compare' => '!=',
	        );
	        $args['meta_query'][] = array(
	            'key'     => 're_post_expired',
	            'value'   => '1',
	            'compare' => '!=',
	        );		        
	    }	     
	    if ($filter_args->show_coupons_only == '2') { 
	    	$args['meta_query']['relation'] = 'AND';    
	        $args['meta_query'][] = array(
	            'key'     => 'rehub_offer_product_coupon',
	            'value' => '',
	            'compare' => '!=',
	        );
	        $args['meta_query'][] = array(
	            'key'     => 're_post_expired',
	            'value'   => '1',
	            'compare' => '!=',
	        );	        
	    } 
	    if ($filter_args->show_coupons_only == '3') {     
		    $args['meta_query'][] = array(
		    	array(
		       		'key' => 're_post_expired',
		       		'value' => '1',
		       		'compare' => '!=',
		    	),	    	
			);
	    } 	
	    if ($filter_args->show_coupons_only == '6') {     
		    $args['meta_query'][] = array(
		    	array(
		       		'key' => 'rehub_review_overall_score',
		       		'compare' => 'EXISTS',
		    	),	    	
			);
	    } 	    
	    if ($filter_args->show_coupons_only == '4') {     
	        $args['meta_query'][] = array(
	            'key'     => 're_post_expired',
	            'value'   => '1',
	            'compare' => '=',
	        );
	    } 
	    if ($filter_args->show_coupons_only == '5') { 
	    	$args['meta_query']['relation'] = 'AND';    
	        $args['meta_query'][] = array(
	            'key'     => 'rehub_offer_product_coupon',
	            'compare' => 'NOT EXISTS',
	        );
	        $args['meta_query'][] = array(
	            'key'     => 're_post_expired',
	            'value'   => '1',
	            'compare' => '!=',
	        );		        
	    }	    

	    if ($filter_args->show_date == 'day') {     
	        $args['date_query'][] = array(
				'after'  => '1 day ago',
	        );
	    }
	    if ($filter_args->show_date == 'week') {    
	        $args['date_query'][] = array(
				'after'  => '7 days ago',
	        );
	    }	
	    if ($filter_args->show_date == 'month') {     
	        $args['date_query'][] = array(
				'after'  => '1 month ago',
	        );
	    }	
	    if ($filter_args->show_date == 'year') {     
	        $args['date_query'][] = array(
				'after'  => '1 year ago',
	        );
	    }	            

		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }	    
		if ($filter_args->enable_pagination != '' && $filter_args->enable_pagination != '0') {
			$args['paged'] = $paged;
		}
		else {
			$args['no_found_rows'] = 1;
		}
		//$args['ignore_sticky_posts'] = 1;
		
		return $args;		
	}

	public static function re_show_brand_tax($type='list'){  
		$term_brand_image = $brand_link = $brand_url = $brandtermname = '';
        if ($type == 'list'){
	    	$term_list = get_the_term_list( get_the_ID(), 'dealstore', '<span class="store_post_meta_item">', ', ', '</span>' );
	    	if(!is_wp_error($term_list)){
	    		echo '<span class="tag_post_store_meta">'.$term_list.'</span>';
	    	}	        	
        }  
        if ($type=='logo'){
	        $brand_url = get_post_meta( get_the_ID(), 'rehub_offer_logo_url', true );
	        if (!empty ($brand_url)) {
	            $term_brand_image = esc_url($brand_url);
	        }  
	        else {
	        	$term_ids =  wp_get_post_terms(get_the_ID(), 'dealstore', array("fields" => "ids")); 
	        	if (!empty($term_ids) && ! is_wp_error($term_ids)) {
	        		$term_id = $term_ids[0];
	        		$brand_url = get_term_meta( $term_id, 'brandimage', true );
	        		$brand_link = get_term_link( $term_id );
	        		$brandterm = get_term( $term_id);
	        		$brandtermname = $brandterm->name;
	        	}
		        if ($brand_url) {
		            $term_brand_image = esc_url($brand_url);
		        }  
	        } 
	        if(!$term_brand_image){
	        	$domain = get_post_meta(get_the_ID(), 'rehub_offer_domain', true);
	        	if($domain){
	        		$term_brand_image = rh_ae_logo_get('http://'.$domain);
	        	}
	        }
	        if ($brand_link){echo '<a href="' . esc_url( $brand_link ) . '">';}
	        if ($term_brand_image) : 
		        WPSM_image_resizer::show_static_resized_image(array('lazy'=> true, 'src'=> $term_brand_image, 'crop'=> false, 'height'=> 40, 'title'=> $brandtermname));
			endif;
			if ($brand_link){echo '</a>';}
        }                
	}		

}
}

//////////////////////////////////////////////////////////////////
// Rehub Woo helper class
//////////////////////////////////////////////////////////////////
if( !class_exists('WPSM_Woohelper') ) {
class WPSM_Woohelper{
	public $filter_args = array(
		'data_source' => 'cat',
		'cat' => '',
		'tag' => '',
		'ids' => '',	
		'orderby' => '',
		'order' => 'DESC',
		'meta_key'=>'',	
		'show' => '',
		'offset' => '',
		'show_date' => '',			
		'show_coupons_only' => '',
		'user_id' => '',	
		'type' => '',	
		'tax_name'=>'',
		'tax_slug'=>'',	
		'tax_slug_exclude'=>'',	
		'enable_pagination' => '',		
	);
	function __construct( $filter_args = array() ){
		$this->set_opt( $filter_args );
		return $this;
	}
	function set_opt( $filter_args = array() ){
		$this->filter_args = (object) array_merge( $this->filter_args, (array) $filter_args );
	}	

	public function extract_filters(){
		$filter_args = & $this->filter_args;
	    if ($filter_args->data_source == 'ids' && $filter_args->ids !='') {
	        $ids = array_map( 'trim', explode( ",", $filter_args->ids ) );
	        $args = array(
	            'post__in' => $ids,
	            'orderby' => 'post__in', 
	            'post_type' => 'product', 
	            'posts_per_page'   => $filter_args->show,          
	        );
	    }
	    else {
	        $args = array(
	            'post_type' => 'product',
	            'posts_per_page'   => $filter_args->show, 
	            'orderby' => $filter_args->orderby,
	            'order' => $filter_args->order,                  
	        );
	        if ($filter_args->data_source == 'cat' && $filter_args->cat !='') {
	            $cat = array_map( 'trim', explode( ",", $filter_args->cat ) );
	            $args['tax_query'] = array(array('taxonomy' => 'product_cat', 'terms' => $cat, 'field' => 'term_id'));
	        }
	        if ($filter_args->data_source == 'tag' && $filter_args->tag !='') {
	            $tag = array_map( 'trim', explode( ",", $filter_args->tag ) );
	            $args['tax_query'] = array(array('taxonomy' => 'product_tag', 'terms' => $tag, 'field' => 'term_id'));
	        }         
	        if ($filter_args->data_source == 'type') {
	            if($filter_args->type =='featured') {$args['meta_query']=array(array('key' => '_featured', 'value' => 'yes'));}
	            elseif($filter_args->type =='sale') {
	                $product_ids_on_sale = wc_get_product_ids_on_sale();
	                $meta_query   = array();
	                $meta_query[] = WC()->query->visibility_meta_query();
	                $meta_query[] = WC()->query->stock_status_meta_query();
	                $meta_query   = array_filter( $meta_query );
	                $args['meta_query'] = $meta_query;
	                $args['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
	                $args['no_found_rows'] = 1;
	            }
	            elseif($filter_args->type =='best_sale') {$args['meta_key']='total_sales'; $args['orderby']='meta_value_num';}
	        }
	        if (!empty ($filter_args->tax_name) && !empty ($filter_args->tax_slug)) {
	            $args['tax_query'] = array (
	                array(
	                    'taxonomy' => $filter_args->tax_name,
	                    'field'    => 'slug',
	                    'terms'    => array($filter_args->tax_slug),
	                )
	            );
	        }
	        if (!empty ($filter_args->tax_name) && !empty ($filter_args->tax_slug_exclude)) {
	            $args['tax_query'] = array (
	                array(
	                    'taxonomy' => $filter_args->tax_name,
	                    'field'    => 'slug',
	                    'terms'    => array($filter_args->tax_slug_exclude),
	                    'operator' => 'NOT IN',
	                ),
	            );
	        } 	        
	        if (($filter_args->orderby == 'meta_value' || $filter_args->orderby == 'meta_value_num') && $filter_args->meta_key !='') {$args['meta_key'] = $filter_args->meta_key;}	   
	        if ($filter_args->offset != '') {$args['offset'] = (int)$filter_args->offset;}     	        
	    }
	    if ($filter_args->show_coupons_only == '1') { 
	    	$args['meta_query']['relation'] = 'AND';    
	        $args['meta_query'][] = array(
	            'key'     => '_sale_price',
	            'value' => '',
	            'compare' => '!=',
	        );
	        $args['meta_query'][] = array(
	            'key'     => 're_post_expired',
	            'value'   => '1',
	            'compare' => '!=',
	        );		        
	    }	    	  
	    if ($filter_args->show_coupons_only == '4') {     
	    	$args['meta_query']['relation'] = 'AND';    
	        $args['meta_query'][] = array(
	            'key'     => 'rehub_woo_coupon_code',
	            'value' => '',
	            'compare' => '!=',
	        );
	        $args['meta_query'][] = array(
	            'key'     => 're_post_expired',
	            'value'   => '1',
	            'compare' => '!=',
	        );	        
	    } 	      
	    if ($filter_args->show_coupons_only == '2') {     
		    $args['meta_query'][] = array(
		    	array(
		       		'key' => 're_post_expired',
		       		'value' => '1',
		       		'compare' => '!=',
		    	),	    	
			);
	    } 	
	    if ($filter_args->show_coupons_only == '3') {     
	        $args['meta_query'][] = array(
	            'key'     => 're_post_expired',
	            'value'   => '1',
	            'compare' => '=',
	        );
	    }	
	    if ($filter_args->show_coupons_only == '5') { 
	    	$args['meta_query']['relation'] = 'AND';    
	        $args['meta_query'][] = array(
	            'key'     => 'rehub_woo_coupon_code',
	            'compare' => 'NOT EXISTS',
	        );
	        $args['meta_query'][] = array(
	            'key'     => 're_post_expired',
	            'value'   => '1',
	            'compare' => '!=',
	        );		        
	    }	    
	    if ($filter_args->show_date == 'day') {     
	        $args['date_query'][] = array(
				'after'  => '1 day ago',
	        );
	    }
	    if ($filter_args->show_date == 'week') {    
	        $args['date_query'][] = array(
				'after'  => '7 days ago',
	        );
	    }	
	    if ($filter_args->show_date == 'month') {     
	        $args['date_query'][] = array(
				'after'  => '1 month ago',
	        );
	    }	
	    if ($filter_args->show_date == 'year') {     
	        $args['date_query'][] = array(
				'after'  => '1 year ago',
	        );
	    }	
	    if (!empty($filter_args->user_id)) {  
	        if(is_numeric($filter_args->user_id)) {
		        $args['author'] = $filter_args->user_id;	        	
	        }  
	    }	        

		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }	    
		if ($filter_args->enable_pagination != '' && $filter_args->enable_pagination != '0') {
			$args['paged'] = $paged;
		}
		else {
			$args['no_found_rows'] = 1;
		}
		//$args['ignore_sticky_posts'] = 1;		
		
		return $args;		
	}

	public static function re_show_brand_tax($type='list'){   
        if ($type == 'list'){
	    	$term_list = get_the_term_list( get_the_ID(), 'store', '<span class="tag_woo_meta_item">', ', ', '</span>' );
	        echo '<span class="tag_woo_meta">'.$term_list.'</span>';	        	
        }  
        if ($type=='logo'){
	        $brand_url = get_post_meta( get_the_ID(), 'rehub_woo_coupon_logo_url', true );
	        if (!empty ($brand_url)) {
	            $term_brand_image = esc_url($brand_url);
	        }  
	        else {
	        	$term_ids =  wp_get_post_terms(get_the_ID(), 'store', array("fields" => "ids")); 
	        	if (!empty($term_ids) && ! is_wp_error($term_ids)) {
	        		$term_id = $term_ids[0];
	        		$brand_url = get_term_meta( $term_id, 'brandimage', true );
	        		$brand_link = get_term_link( $term_id );
	        	}
		        if (!empty ($brand_url)) {
		            $term_brand_image = esc_url($brand_url);
		        }  
	        } 
	        if (!empty($brand_link)){echo '<a href="' . esc_url( $brand_link ) . '">';}
	        if (!empty($term_brand_image)) :
		        $showbrandimg = new WPSM_image_resizer();
		        $showbrandimg->height = '30';
		        $showbrandimg->src = $term_brand_image;
		        $showbrandimg->show_resized_image();                                    
			endif;
			if (!empty($brand_link)){echo '</a>';}
        }                
	}	

	public static function get_ratings_counts( $product ) {
		global $wpdb;
		
		$counts     = array();
		$raw_counts = $wpdb->get_results( $wpdb->prepare("
                SELECT meta_value, COUNT( * ) as meta_value_count FROM $wpdb->commentmeta
                LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                WHERE meta_key = 'rating'
                AND comment_post_ID = %d
                AND comment_approved = '1'
                AND meta_value > 0
                GROUP BY meta_value
            ", $product->id ) );
		
		foreach ( $raw_counts as $count ) {
			$counts[ $count->meta_value ] = $count->meta_value_count;
		}
        
        return $counts;
	}	

}
}

function rehub_custom_taxonomy_dropdown( $taxdrop, $limit = '40', $class, $taxdroplabel = '', $containerid ='' ) {
	$args = array(
		'taxonomy'=> $taxdrop,
		'number' => $limit,
		'hide_empty' => true,
		'parent'        => 0,
	);
	$terms = get_terms($args );
	$class = ( $class ) ? $class : 're_tax_dropdown';
	$output = '';
	if ( $terms && !is_wp_error($terms) ) {
		$output .= '<ul class="'.$class.'">';
		if (empty($taxdroplabel)){$taxdroplabel = __('Choose category', 'rehub_framework');}
		$output .= '<li class="label"><span class="rh_tax_placeholder">'.$taxdroplabel.'</span><span class="rh_choosed_tax"></span></li>';
		foreach ( $terms as $term ) {
			$term_link = get_term_link( $term );
		   	if ( is_wp_error( $term_link ) ) {
		        continue;
		    }	
		    if(!empty($containerid)){
		    	$sort_array=array();
		    	$sort_array['filtertype'] = 'tax';
		    	$sort_array['filtertaxkey'] = $taxdrop;
		    	$sort_array['filtertaxtermslug'] = $term->slug;
		    	$json_filteritem = json_encode($sort_array);
		    	$output .='<li class="rh_drop_item"><span data-sorttype=\''.$json_filteritem.'\' class="re_filtersort_btn" data-containerid="'.$containerid.'">';
		    		$output .= $term->name;
		    	$output .= '</span></li>';
		    }	
		    else{
				$output .= '<li class="rh_drop_item"><span><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></span></li>';		    	
		    }			
		}
		$output .= '</ul>';
	}
	return $output;
}

//////////////////////////////////////////////////////////////////
// RFILTER PANEL RENDER
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_vc_filterpanel_render') ) {
function rehub_vc_filterpanel_render( $filterpanel='', $containerid, $taxdrop='', $taxdroplabel='' ) {
	if(!$filterpanel){
		return;
	}
	$filterpanel = (array) json_decode( urldecode( $filterpanel ), true );
	$output = '';
	if (!empty($filterpanel[0])){
		$tax_enabled_div = (!empty($taxdrop)) ? ' tax_enabled_drop' : '';
		$output .= '<div class="re_filter_panel'.$tax_enabled_div.'">';
			$output .= '<ul class="re_filter_ul">';
			foreach ( $filterpanel as $k => $v ) {
				$output .= '<li>';
					if (!empty($v['filtertitle'])) {
						$label = $v['filtertitle'];
						unset ($v['filtertitle']);		
					}
					$json_filteritem = json_encode($v);	
					$class = ($k==0) ? ' class="active re_filtersort_btn resort_'.$k.'"' : ' class="re_filtersort_btn resort_'.$k.'"';								
					$output .= '<span data-sorttype=\''.$json_filteritem.'\''.$class.' data-containerid="'.$containerid.'">';
						$output .= $label;						
					$output .= '</span>';					
				$output .= '</li>';				
			}
			$output .= '</ul>';

			if($taxdrop){
				$output .= rehub_custom_taxonomy_dropdown($taxdrop, '40', 're_tax_dropdown', $taxdroplabel, $containerid);
			}

		$output .= '</div>';
	}
	echo $output;

}
}

//////////////////////////////////////////////////////////////////
// WOOCOMMERCE FEATURED AREA
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woofeatured_function') ) {
function wpsm_woofeatured_function( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'data_source' => 'cat',
	'cat' => '',
	'tag' => '',
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key'=>'',
	'show' => 5,	
	'offset' => '',
	'show_date' => '',	
	'show_coupons_only' => '',	
	'user_id' => '',	
	'type' => '',	
	'tax_name'=>'',
	'tax_slug'=>'',	
	'tax_slug_exclude'=>'',	
	'enable_pagination' => '', //end woo filters
	'feat_type'=>'1',
	'dis_excerpt' =>'',
	'bottom_style' =>'',
	'custom_height'=>'',
), $atts, 'wpsm_woofeatured'); 
extract($build_args); 
$rand_id = 'woo_feat'.uniqid();            
ob_start(); 
?>
<?php if( !is_paged()) : ?>
<?php if ($feat_type=='1') {wp_enqueue_script('flexslider');} ;?>
<?php
	$argsfilter = new WPSM_Woohelper($build_args);
	$args = $argsfilter->extract_filters();
	$products = new WP_Query($args);
?>
<div class="wpsm_featured_wrap wpsm_featured_<?php echo $feat_type?>" id="<?php echo $rand_id;?>">
<?php if($feat_type =='1') : //First type - featured full width slider?>
	<?php if($custom_height) :?>
    	<style scoped>
    		@media (min-width: 768px){
    			#<?php echo $rand_id;?> .main_slider.full_width_slider.flexslider .slides .slide{height: <?php echo (int)$custom_height;?>px; line-height: <?php echo (int)$custom_height;?>px;} 
    			#<?php echo $rand_id;?> .main_slider.full_width_slider.flexslider{height:<?php echo (int)$custom_height;?>px}
    		}        		
    	</style>
	<?php endif ;?>
	<div class="flexslider main_slider loading full_width_slider<?php if ($bottom_style =='1') :?> bottom_style_slider<?php endif ?>">
		<i class="fa fa-spinner fa-pulse"></i>
		<ul class="slides">	
		<?php if($products->have_posts()): while($products->have_posts()): $products->the_post(); global $post; global $product; ?>
		<?php 
	  		$image_id = get_post_thumbnail_id(get_the_ID());  
	  		$image_url = wp_get_attachment_image_src($image_id,'full');
			$image_url = $image_url[0];
			if (function_exists('_nelioefi_url')){
				$image_nelio_url = get_post_meta( $post->ID, _nelioefi_url(), true );
				if (!empty($image_nelio_url)){
					$image_url = esc_url($image_nelio_url);
				}			
			}			
			$showbigimg = new WPSM_image_resizer();
			$showbigimg->src = $image_url;
			$imagebig_url = $showbigimg->get_resized_url();
		?>	
			<li class="slide" style="background-image: url('<?php echo $imagebig_url ;?>');"> 
				<span class="pattern"></span>
				<a href="<?php the_permalink();?>" class="feat_overlay_link"></a>
		  		<div class="flex-overlay">
		    		<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
		    		<div class="post-meta">
		      			<div class="inner_meta">    				
							<?php do_action( 'rehub_vendor_show_action' ); ?>       				
		      			</div>
		    		</div>		    		
		    		<?php if ($dis_excerpt !='1' && $bottom_style !='1') :?><div class="hero-description"><p><?php kama_excerpt('maxchar=150'); ?></p></div><?php endif ;?>
		    		<?php if(rehub_option('disable_btn_offer_loop')!='1')  : ?>
		    		<div class="priced_block clearfix">
		    			<p> <span class="price_count"><?php wc_get_template( 'loop/price.php' ); ?></p>
			            <?php if ( $product->add_to_cart_url() !='') : ?>			            	
			                <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
			                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="re_track_btn woo_loop_btn btn_offer_block %s %s product_type_%s"%s>%s</a>',
			                    esc_url( $product->add_to_cart_url() ),
			                    esc_attr( $product->id ),
			                    esc_attr( $product->get_sku() ),
			                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			                    $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			                    esc_attr( $product->product_type ),
			                    $product->product_type =='external' ? ' target="_blank"' : '',
			                    esc_html( $product->add_to_cart_text() )
			                    ),
			            $product );?> 
		    			<?php endif; ?>	
		    		</div>
		    		<?php endif;?>            		
		    	</div>
			</li>
		<?php endwhile; endif; ?>
		<?php  wp_reset_query(); ?>
		</ul>
	</div>
<?php elseif($feat_type =='2') : //Second type - featured grid ?>
	<div class="featured_grid">	
		<?php $col_number = 0; if($products->have_posts()): while($products->have_posts()): $products->the_post(); global $post; global $product; $col_number ++; ?>
		<?php 
	  		$image_id = get_post_thumbnail_id(get_the_ID());  
	  		if ($col_number == 1) {
	  			$image_url = wp_get_attachment_image_src($image_id,'full');
	  		}
	  		else {
	  			$image_url = wp_get_attachment_image_src($image_id,'news_big');
	  		}	
			$image_url = $image_url[0];
			if (function_exists('_nelioefi_url')){
				$image_nelio_url = get_post_meta( $post->ID, _nelioefi_url(), true );
				if (!empty($image_nelio_url)){
					$image_url = esc_url($image_nelio_url);
				}			
			}			
			$showimg = new WPSM_image_resizer();
			$showimg->src = $image_url;
			$image_url = $showimg->get_resized_url();
		?>	<?php if ($col_number == 2) {echo '<div class="scroll-on-mobile col-feat-50">';}?>
			<div class="col-feat-grid item-<?php echo $col_number;?>" style="background-image: url('<?php echo $image_url ;?>');">
				<a href="<?php the_permalink();?>" class="feat_overlay_link"></a> 
		  		<div class="feat-grid-overlay text_in_thumb">
	      			<div class="inner_meta">    				
						<?php do_action( 'rehub_vendor_show_action' ); ?>    				
	      			</div>		  		
		    		<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
		    		<div class="woopriceInGrid"><?php wc_get_template( 'loop/price.php' ); ?> </div>		    		
		    		<?php if ($col_number == 1) :?>
		    		<div class="post-meta">
                		<span class="date_ago"><i class="fa fa-clock-o"></i> <?php printf( __( '%s ago', 'rehub_framework' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span>		    		
		    			<span class="comm_count_meta"><?php comments_popup_link( __('no comments','rehub_framework'), __('1 comment','rehub_framework'), __('% comments','rehub_framework'), 'comm_meta', ''); ?></span>                
		    		</div>
		    		<?php endif;?>	            		
		    	</div> 
			</div>
		<?php endwhile; echo '</div>'; endif; ?>
		<?php  wp_reset_query(); ?>
	</div>
<?php endif;?>
</div>
<?php endif;?>


<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('wpsm_woofeatured', 'wpsm_woofeatured_function');
}

//////////////////////////////////////////////////////////////////
// Woo GRID
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woogrid_shortcode') ) {
function wpsm_woogrid_shortcode( $atts, $content = null ) {
$build_args = shortcode_atts(array(
	'data_source' => 'cat',
	'cat' => '',
	'tag' => '',
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key'=>'',
	'show' => 12,	
	'offset' => '',
	'show_date' => '',	
	'show_coupons_only' => '',	
	'user_id' => '',	
	'type' => '',	
	'tax_name'=>'',
	'tax_slug'=>'',	
	'tax_slug_exclude'=>'',	
	'enable_pagination' => '', //end woo filters
	'columns' => '3_col',
	'woolinktype' => 'product',	
	'filterpanel' => '',
	'taxdrop' => '',
	'taxdroplabel' => '',
	'disable_thumbs'=>'',	
), $atts, 'wpsm_woogrid');
extract($build_args);

if ($columns == '3_col'){
    $col_wrap = ' col_wrap_three';
}
elseif ($columns == '4_col'){
    $col_wrap = ' col_wrap_fourth';
}  
elseif ($columns == '5_col'){
    $col_wrap = ' col_wrap_fifth';
} 
elseif ($columns == '6_col'){
    $col_wrap = ' col_wrap_six';
}             
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}  
$containerid = 'rh_woogrid_' . uniqid(); 
$ajaxoffset = (int)$show + (int)$offset;  
$additional_vars = array();
$additional_vars['columns'] = $columns;
$additional_vars['woolinktype'] = $woolinktype; 
$additional_vars['disable_thumbs'] = $disable_thumbs;
ob_start(); 
?>
	<?php rehub_vc_filterpanel_render($filterpanel, $containerid, $taxdrop, $taxdroplabel);?>
	<?php		 
		$argsfilter = new WPSM_Woohelper($build_args);
		$args = $argsfilter->extract_filters();
		global $post; global $woocommerce; global $wp_query; $temp = $wp_query; 
	?>
	<?php 
    if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){   
        $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
        $_REQUEST['mdf_get_query_args_only'] = true;
        do_shortcode('[meta_data_filter_results]');
        $args = $_REQUEST['meta_data_filter_args'];
        $wp_query=new WP_Query($args);
        $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
    }
    else { $wp_query = new WP_Query($args); }
	$i=1; if ( $wp_query->have_posts() ) : ?>
		<?php 
			if(!empty($args['paged'])){unset($args['paged']);}
			$jsonargs = json_encode($args);
			$json_innerargs = json_encode($additional_vars);
		?> 
		<div class="woocommerce">    
		<div class="rh-flex-eq-height grid_woo products <?php echo $infinitescrollwrap; echo $col_wrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="woogridpart" id="<?php echo $containerid;?>" data-innerargs='<?php echo $json_innerargs;?>'>                   
		
			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  ?>
			  	<?php include(rh_locate_template('inc/parts/woogridpart.php')); ?>  
			<?php $i++; endwhile; ?>

			<?php if ($enable_pagination == '1') :?>
			    <div class="pagination"><?php rehub_pagination();?></div>
			<?php elseif ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
			    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
			<?php endif;?>
		</div> 
		</div>
	<?php endif; $wp_query = $temp; wp_reset_query(); ?>   
	<div class="clearfix"></div>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('wpsm_woogrid', 'wpsm_woogrid_shortcode');
} 

//////////////////////////////////////////////////////////////////
// Woo COLUMNS
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woocolumns_shortcode') ) {
function wpsm_woocolumns_shortcode( $atts, $content = null ) {
$build_args = shortcode_atts(array(
	'data_source' => 'cat',
	'cat' => '',
	'tag' => '',
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',
	'meta_key'=>'',		
	'show' => 12,	
	'offset' => '',	
	'show_date' => '',
	'show_coupons_only' => '',
	'user_id' => '',		
	'type' => '',
	'tax_name'=>'',
	'tax_slug'=>'',	
	'tax_slug_exclude'=>'',		
	'enable_pagination' => '', //end woo filters
	'columns' => '3_col',
	'woolinktype' => 'product',	
	'filterpanel' => '',
	'taxdrop' => '',
	'taxdroplabel' => '',
	'custom_col' => '',
	'custom_img_width'=>'',
	'custom_img_height'	=>'',			
), $atts, 'wpsm_woocolumns');
extract($build_args);             
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}  
if ($columns == '3_col'){
    $col_wrap = ' col_wrap_three';
}
elseif ($columns == '4_col'){
    $col_wrap = ' col_wrap_fourth';
}  
elseif ($columns == '5_col'){
    $col_wrap = ' col_wrap_fifth';
} 
elseif ($columns == '6_col'){
    $col_wrap = ' col_wrap_six';
} 
$containerid = 'rh_woocolumn_' . uniqid(); 
$ajaxoffset = (int)$show + (int)$offset;    
$additional_vars = array();
$additional_vars['columns'] = $columns;
$additional_vars['woolinktype'] = $woolinktype;
if($custom_col){
$additional_vars['custom_col'] = $custom_col;
$additional_vars['custom_img_width'] = $custom_img_width;
$additional_vars['custom_img_height'] = $custom_img_height;
}
ob_start(); 
?>

<?php rehub_vc_filterpanel_render($filterpanel, $containerid, $taxdrop, $taxdroplabel);?>
<?php		 
	$argsfilter = new WPSM_Woohelper($build_args);
	$args = $argsfilter->extract_filters();
	global $post; global $woocommerce; global $wp_query; $temp = $wp_query;
?>
<?php 
    if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){   
        $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
        $_REQUEST['mdf_get_query_args_only'] = true;
        do_shortcode('[meta_data_filter_results]');
        $args = $_REQUEST['meta_data_filter_args'];
        $wp_query=new WP_Query($args);
        $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
    }
    else { $wp_query = new WP_Query($args); }
	$i=1; if ( $wp_query->have_posts() ) : ?> 
	<?php 
		if(!empty($args['paged'])){unset($args['paged']);}
		$jsonargs = json_encode($args);
		$json_innerargs = json_encode($additional_vars);
	?> 
	<div class="woocommerce">
	<div class="rh-flex-eq-height column_woo products <?php echo $infinitescrollwrap; echo $col_wrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="woocolumnpart" data-innerargs='<?php echo $json_innerargs;?>' id="<?php echo $containerid;?>">                     

		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  ?>
		   <?php include(rh_locate_template('inc/parts/woocolumnpart.php')); ?>  
		<?php $i++; endwhile; ?>

		<?php if ($enable_pagination == '1') :?>
		    <div class="pagination"><?php rehub_pagination();?></div>
		<?php elseif ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
		    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
		<?php endif;?>	
	</div>
	</div>

<?php endif; $wp_query = $temp; wp_reset_query(); ?>   
<div class="clearfix"></div>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('wpsm_woocolumns', 'wpsm_woocolumns_shortcode');
}

//////////////////////////////////////////////////////////////////
// Woo List
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woolist_shortcode') ) {
function wpsm_woolist_shortcode( $atts, $content = null ) {
	
$build_args = shortcode_atts(array(
	'data_source' => 'cat',
	'cat' => '',
	'tag' => '',
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key'=>'',
	'show' => 12,
	'offset' => '',	
	'show_date' => '',		
	'show_coupons_only' => '',	
	'user_id' => '',
	'type' => '',	
	'tax_name'=>'',
	'tax_slug'=>'',	
	'tax_slug_exclude'=>'',	
	'enable_pagination' => '', //end woo filters	
), $atts, 'wpsm_woolist');
extract($build_args);
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}  
$containerid = 'rh_woolist_' . uniqid(); 
$ajaxoffset = (int)$show + (int)$offset; 
ob_start(); 
?>

<?php		 
	$argsfilter = new WPSM_Woohelper($build_args);
	$args = $argsfilter->extract_filters();
	global $post; global $woocommerce; $backup=$post; $result_min = array(); //add array of prices
?>
<?php $wp_query = new WP_Query( $args ); $i=1; if ( $wp_query->have_posts() ) : ?> 
	<?php 
		if(!empty($args['paged'])){unset($args['paged']);}
		$jsonargs = json_encode($args);
	?> 
	<div class="woo_offer_list <?php echo $infinitescrollwrap; ?>" data-filterargs='<?php echo $jsonargs;?>' data-template="woolistpart" id="<?php echo $containerid;?>">	                    
		<a name="woo-link-list"></a>		
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  global $product;  ?>
			<?php include(rh_locate_template('inc/parts/woolistpart.php')); ?>
            <?php
                $price_clean = $product->get_price();
                $result_min[] = $price_clean;
            ?>			
		<?php $i++; endwhile; ?>
		
		<?php if ($enable_pagination == '1') :?>
		    <div class="pagination"><?php rehub_pagination();?></div>
		<?php elseif ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
		    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
		<?php endif;?>	

	</div>
<?php endif; $post=$backup; wp_reset_query(); ?> 


<?php
if (!empty($result_min)) {
	$min_woo_price_old = get_post_meta( get_the_ID(), 'rehub_min_woo_price', true );
	$min_woo_price = min($result_min); 
	if ( $min_woo_price !='' && $min_woo_price_old !='' && $min_woo_price != $min_woo_price_old ){
		update_post_meta(get_the_ID(), 'rehub_min_woo_price', $min_woo_price);
		update_post_meta(get_the_ID(), 'rehub_main_product_price', $min_woo_price); 
	}
	elseif($min_woo_price !='' && $min_woo_price_old =='') {
		update_post_meta(get_the_ID(), 'rehub_min_woo_price', $min_woo_price); 
		update_post_meta(get_the_ID(), 'rehub_main_product_price', $min_woo_price);
	}					 
}
?>	

<?php
$output = ob_get_contents();
ob_end_clean();
return $output;		

}
add_shortcode('wpsm_woolist', 'wpsm_woolist_shortcode');
}

//////////////////////////////////////////////////////////////////
// Woo Rows
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woorows_shortcode') ) {
function wpsm_woorows_shortcode( $atts, $content = null ) {
	
$build_args = shortcode_atts(array(
	'data_source' => 'cat',
	'cat' => '',
	'tag' => '',
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key'=>'',
	'show' => 12,
	'offset' => '',	
	'show_date' => '',		
	'show_coupons_only' => '',
	'user_id' => '',	
	'type' => '',	
	'tax_name'=>'',
	'tax_slug'=>'',	
	'tax_slug_exclude'=>'',	
	'enable_pagination' => '', //end woo filters	
), $atts, 'wpsm_woorows');
extract($build_args);
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}  
$containerid = 'rh_woorows_' . uniqid(); 
$ajaxoffset = (int)$show + (int)$offset; 
ob_start(); 
?>

<?php		 
	$argsfilter = new WPSM_Woohelper($build_args);
	$args = $argsfilter->extract_filters();
	global $post; global $woocommerce; $backup=$post;
?>
<?php 
    if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){   
        $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
        $_REQUEST['mdf_get_query_args_only'] = true;
        do_shortcode('[meta_data_filter_results]');
        $args = $_REQUEST['meta_data_filter_args'];
        $wp_query=new WP_Query($args);
        $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
    }
    else { $wp_query = new WP_Query($args); }
	$i=1; if ( $wp_query->have_posts() ) : ?> 
	<?php 
		if(!empty($args['paged'])){unset($args['paged']);}
		$jsonargs = json_encode($args);
	?> 
	<div class="woocommerce">
	<div class="list_woo products <?php echo $infinitescrollwrap; ?>" data-filterargs='<?php echo $jsonargs;?>' data-template="woolistmain" id="<?php echo $containerid;?>">	                    
		
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  global $product;  ?>
			<?php include(rh_locate_template('inc/parts/woolistmain.php')); ?>
		<?php $i++; endwhile; ?>
		
		<?php if ($enable_pagination == '1') :?>
		    <div class="pagination"><?php rehub_pagination();?></div>
		<?php elseif ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
		    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
		<?php endif;?>	
	</div>
	</div>
<?php endif; $post=$backup; wp_reset_query(); ?> 

<?php
$output = ob_get_contents();
ob_end_clean();
return $output;		

}
add_shortcode('wpsm_woorows', 'wpsm_woorows_shortcode');
}

//////////////////////////////////////////////////////////////////
// COMPACT DEAL GRID
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_compactgrid_loop_shortcode') ) {
function wpsm_compactgrid_loop_shortcode( $atts, $content = null ) {

$build_args = shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 12,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',	
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
	'columns' => '3_col',
	'aff_link' => '',
	'disable_btn'=>'',
	'disable_act'=>'',	
	'price_meta'=> 'admin',
	'filterpanel' => '',
	'taxdrop' => '',
	'taxdroplabel' => '',	
), $atts, 'compactgrid_loop_mod');

extract($build_args);

if ($columns == '4_col'){
    $col_wrap = 'col_wrap_fourth';
}  
elseif ($columns == '5_col'){
    $col_wrap = 'col_wrap_fifth';
} 
elseif ($columns == '6_col'){
    $col_wrap = 'col_wrap_six';
} 
else {
   $col_wrap = 'col_wrap_three'; 
}             
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}  
$containerid = 'rh_dealgrid_' . uniqid();    
$ajaxoffset = (int)$show + (int)$offset;   
$additional_vars = array();
$additional_vars['columns'] = $columns;
$additional_vars['aff_link'] = $aff_link;
$additional_vars['disable_btn'] = $disable_btn;
$additional_vars['disable_act'] = $disable_act;
$additional_vars['price_meta'] = $price_meta;
ob_start(); 
?>
<?php rehub_vc_filterpanel_render($filterpanel, $containerid, $taxdrop, $taxdroplabel);?>
<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
    
    if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){   
        $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
        $_REQUEST['mdf_get_query_args_only'] = true;
        do_shortcode('[meta_data_filter_results]');
        $args = $_REQUEST['meta_data_filter_args'];
        $wp_query=new WP_Query($args);
        $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
    }
    else { $wp_query = new WP_Query($args); }
?>
<?php if ( $wp_query->have_posts() ) : ?>
	<?php 
		if(!empty($args['paged'])){unset($args['paged']);}
		$jsonargs = json_encode($args);
		$json_innerargs = json_encode($additional_vars);
	?> 	
	<div class="eq_grid post_eq_grid rh-flex-eq-height <?php echo $col_wrap; echo $infinitescrollwrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="compact_grid" id="<?php echo $containerid;?>" data-innerargs='<?php echo $json_innerargs;?>'>

		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  ?>
			<?php include(rh_locate_template('inc/parts/compact_grid.php')); ?>
		<?php endwhile; ?>

		<?php if ($enable_pagination == '1') :?>
		    <div class="pagination"><?php rehub_pagination();?></div>
		<?php elseif ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
		    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
		<?php endif ;?>

	</div>
	<div class="clearfix"></div>
<?php endif; wp_reset_query(); ?>


<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('compactgrid_loop_mod', 'wpsm_compactgrid_loop_shortcode');
}

//////////////////////////////////////////////////////////////////
// COLUMN GRID
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_columngrid_loop_shortcode') ) {
function wpsm_columngrid_loop_shortcode( $atts, $content = null ) {
$build_args = shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 12,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
	'columns' => '3_col',
	'exerpt_count' => '110',
	'enable_btn'=> '',
	'disable_meta' => '',
	'aff_link' => '',	
	'filterpanel' => '',
	'boxed' => '',
	'taxdrop' => '',
	'taxdroplabel' => '',	
), $atts, 'columngrid_loop'); 
extract($build_args);            
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}  
$containerid = 'rh_clmgrid_' . uniqid();    
$ajaxoffset = (int)$show + (int)$offset;   
$additional_vars = array();
$additional_vars['columns'] = $columns;
$additional_vars['aff_link'] = $aff_link;
$additional_vars['exerpt_count'] = $exerpt_count;
$additional_vars['disable_meta'] = $disable_meta;
$additional_vars['enable_btn'] = $enable_btn;
$additional_vars['boxed'] = $boxed;
ob_start(); 
?>
<?php rehub_vc_filterpanel_render($filterpanel, $containerid, $taxdrop, $taxdroplabel);?>
<?php if ($columns =='2_col') : ?>
	<?php $col_number_class= ' col_wrap_two'; ?>
<?php elseif ($columns =='3_col') : ?>
	<?php $col_number_class= ' col_wrap_three'; ?>
<?php elseif ($columns =='4_col') : ?>
	<?php $col_number_class= ' col_wrap_fourth'; ?>
<?php elseif ($columns =='5_col') : ?>
	<?php $col_number_class= ' col_wrap_fifth'; ?>
<?php elseif ($columns =='6_col') : ?>
	<?php $col_number_class= ' col_wrap_six'; ?>	
<?php endif ;?>
<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
    if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){   
        $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
        $_REQUEST['mdf_get_query_args_only'] = true;
        do_shortcode('[meta_data_filter_results]');
        $args = $_REQUEST['meta_data_filter_args'];
        $wp_query=new WP_Query($args);
        $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
    }
    else { $wp_query = new WP_Query($args); }
?>

<?php $i=1; if ( $wp_query->have_posts() ) : ?>
	<?php 
		if(!empty($args['paged'])){unset($args['paged']);}
		$jsonargs = json_encode($args);
		$json_innerargs = json_encode($additional_vars);
	?>   
	<div class="columned_grid_module rh-flex-eq-height <?php echo $infinitescrollwrap; echo $col_number_class?>" data-filterargs='<?php echo $jsonargs;?>' data-template="column_grid" id="<?php echo $containerid;?>" data-innerargs='<?php echo $json_innerargs;?>'>                    
		
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
			<?php include(rh_locate_template('inc/parts/column_grid.php')); ?>
		<?php $i++; endwhile; ?>

		<?php if ($enable_pagination == '1') :?>
		    <div class="pagination"><?php rehub_pagination();?></div>
		<?php elseif ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
		    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
		<?php endif ;?>

	</div>
	<div class="clearfix"></div>
<?php endif; wp_reset_query(); ?>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('columngrid_loop', 'wpsm_columngrid_loop_shortcode');
}

//////////////////////////////////////////////////////////////////
// LIST LOOP OF POSTS
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_small_thumb_loop_shortcode') ) {
function wpsm_small_thumb_loop_shortcode( $atts, $content = null ) {
$build_args = shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 10,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',	
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
	'type' => '1',
	'filterpanel' => '',
	'taxdrop' => '',
	'taxdroplabel' => '',	
), $atts, 'small_thumb_loop');   
extract($build_args);   
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}   
$news_type = ($type =='2') ? ' no_bordered_news' : '';
$containerid = 'rh_filterid_' . uniqid(); 
$ajaxoffset = (int)$show + (int)$offset;
$additional_vars = array();
$additional_vars['type'] = $type;
ob_start(); 
?>
<?php rehub_vc_filterpanel_render($filterpanel, $containerid, $taxdrop, $taxdroplabel);?>
<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
    if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){   
        $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
        $_REQUEST['mdf_get_query_args_only'] = true;
        do_shortcode('[meta_data_filter_results]');
        $args = $_REQUEST['meta_data_filter_args'];
        $wp_query=new WP_Query($args);
        $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
    }
    else { $wp_query = new WP_Query($args); }
?>
<?php if ( $wp_query->have_posts() ) : ?>
	<?php 
		if(!empty($args['paged'])){unset($args['paged']);}
		$jsonargs = json_encode($args);
		$json_innerargs = json_encode($additional_vars);
	?>
	<div class="<?php echo $infinitescrollwrap; echo $news_type?>" data-filterargs='<?php echo $jsonargs;?>' data-template="query_type1" id="<?php echo $containerid;?>" data-innerargs='<?php echo $json_innerargs;?>'>

		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  ?>	
			<?php include(rh_locate_template('inc/parts/query_type1.php')); ?>
		<?php endwhile; ?>

		<?php if ($enable_pagination == '1') :?>
			<div class="clearfix"></div>
		    <div class="pagination"><?php rehub_pagination();?></div>
		<?php elseif ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
		    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
		<?php endif ;?>

	</div>
	<div class="clearfix"></div>
<?php endif; wp_reset_query(); ?>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('small_thumb_loop', 'wpsm_small_thumb_loop_shortcode');
}

//////////////////////////////////////////////////////////////////
// BLOG LOOP OF POSTS
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_regular_blog_loop_shortcode') ) {
function wpsm_regular_blog_loop_shortcode( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 12,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',	
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
), $atts, 'regular_blog_loop'); 
extract($build_args);            
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}  
$containerid = 'rh_blogloop_' . uniqid();    
$ajaxoffset = (int)$show + (int)$offset;   
ob_start(); 
?>

<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
    if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){   
        $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
        $_REQUEST['mdf_get_query_args_only'] = true;
        do_shortcode('[meta_data_filter_results]');
        $args = $_REQUEST['meta_data_filter_args'];
        $wp_query=new WP_Query($args);
        $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
    }
    else { $wp_query = new WP_Query($args); }
?>

<?php if ( $wp_query->have_posts() ) : ?>
	<?php 
		if(!empty($args['paged'])){unset($args['paged']);}
		$jsonargs = json_encode($args);
	?> 
	<div class="<?php echo $infinitescrollwrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="query_type2" id="<?php echo $containerid;?>">
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  ?>	
			<?php include(rh_locate_template('inc/parts/query_type2.php')); ?>
		<?php endwhile; ?>

		<?php if ($enable_pagination == '1') :?>
		    <div class="pagination"><?php rehub_pagination();?></div>
		<?php elseif ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
		    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
		<?php endif ;?>

	</div>
	<div class="clearfix"></div>
<?php endif; wp_reset_query(); ?>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('regular_blog_loop', 'wpsm_regular_blog_loop_shortcode');
}

//////////////////////////////////////////////////////////////////
// GRID LOOP MASONRY
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_grid_loop_mod_shortcode') ) {
function wpsm_grid_loop_mod_shortcode( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 12,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',	
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
	'columns' => '2_col',
	'aff_link' => '',
	'filterpanel' => '',
	'taxdrop' => '',
	'taxdroplabel' => '',	
), $atts, 'grid_loop_mod'); 
extract($build_args);       
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}  
$containerid = 'rh_fltmasongrid_' . uniqid();    
$ajaxoffset = (int)$show + (int)$offset;  
$additional_vars = array();
$additional_vars['columns'] = $columns; 
$additional_vars['aff_link'] = $aff_link;   
ob_start(); 
?>
<?php rehub_vc_filterpanel_render($filterpanel, $containerid, $taxdrop, $taxdroplabel);?>
<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
    if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){   
        $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
        $_REQUEST['mdf_get_query_args_only'] = true;
        do_shortcode('[meta_data_filter_results]');
        $args = $_REQUEST['meta_data_filter_args'];
        $wp_query=new WP_Query($args);
        $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
    }
    else { $wp_query = new WP_Query($args); }
?>
<?php if ($columns =='2_col') : ?>
	<?php $columns = ' two-col-gridhub';?>
<?php elseif ($columns =='3_col') : ?>
	<?php $columns = ' three-col-gridhub';?> 
<?php elseif ($columns =='4_col') : ?>
	<?php $columns = ' fourth-col-gridhub';?>
<?php elseif ($columns =='5_col') : ?>
	<?php $columns = ' fifth-col-gridhub';?>
<?php else :?>	
	<?php $columns = ' two-col-gridhub';?>
<?php endif ;?>

<?php if ( $wp_query->have_posts() ) : ?>
	<?php 
		if(!empty($args['paged'])){unset($args['paged']);}
		$jsonargs = json_encode($args);
		$json_innerargs = json_encode($additional_vars);
	?> 
	<?php  wp_enqueue_script('masonry'); wp_enqueue_script('imagesloaded');  ?>
	<?php wp_enqueue_script('masonry_init'); ?>	
	<div class="<?php echo $infinitescrollwrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="query_type3" id="<?php echo $containerid;?>" data-innerargs='<?php echo $json_innerargs;?>'>
		<div class="masonry_grid_fullwidth<?php echo $columns;?>">	

			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  ?>	
				<?php include(rh_locate_template('inc/parts/query_type3.php')); ?>
			<?php endwhile; ?>

			<?php if ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
			    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
			<?php endif ;?>
		</div>
		<?php if ($enable_pagination == '1') :?>
		    <div class="pagination"><?php rehub_pagination();?></div>
		<?php endif ;?>		
	</div>
	<div class="clearfix"></div>
<?php endif; wp_reset_query(); ?>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('grid_loop_mod', 'wpsm_grid_loop_mod_shortcode');
}

//////////////////////////////////////////////////////////////////
// NEWS WITHOUT THUMBNAILS
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_news_no_thumbs_mod_shortcode') ) {
function wpsm_news_no_thumbs_mod_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'module_cats' => '',
	'module_tags' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'color_cat' => '',
	'post_formats' => ''
), $atts, 'news_no_thumbs_mod'));                
ob_start(); 
?>

<?php   
	$args = array('ignore_sticky_posts' => 1, 'showposts' => 1, 'offset'=>0, 'no_found_rows' => 1);
    if ($module_cats !='' && $module_cats != 'all') {$args['cat'] = $module_cats;}
    if ($module_tags !='') {$args['tag__in'] = array_map( 'trim', explode(",", $module_tags ));}
    if ($cat_exclude !='') {$args['category__not_in'] = array_map( 'trim', explode(",", $cat_exclude ));}
    if ($tag_exclude !='') {$args['tag__not_in'] = array_map( 'trim', explode(",", $tag_exclude ));}
    if ($post_formats != 'all' && $post_formats != '') {$args['meta_key'] = 'rehub_framework_post_type'; $args['meta_value'] = $post_formats;}
	$rand_id = uniqid().time(); 
?>
<?php if( !is_paged()) : ?>
<div class="news_block seventy_col_block news_without_thumb_block clearfix">
    <?php $news = new WP_Query($args); 
        if( $news->have_posts() ) :
        while($news->have_posts()) : $news->the_post(); 
    ?>
    <div class="left_news_col">
    	<div class="news_in_thumb">
	        <figure>
	        	<?php echo re_badge_create('tablelabel'); ?>
	            <a href="<?php the_permalink();?>">

	            	<?php 
                		$showimg = new WPSM_image_resizer();
                		$showimg->use_thumb = true;
                		$showimg->width = '474';
                		$showimg->height = '342';  
                		$showimg->crop = true;                                    
                	?>
					<?php $showimg->show_resized_image(); ?>
	            </a>
                <?php if (rehub_option('exclude_comments_meta') == 0) : ?><?php comments_popup_link( 0, 1, '%', 'comment', ''); ?><?php endif ;?>
                <?php rehub_formats_icons() ?>
                <div class="text_in_thumb" id="n_w_t_<?php echo $rand_id;?>">
                	<?php if($color_cat) :?>
	                	<style scoped>
	                		#n_w_t_<?php echo $rand_id;?> .news_cat a{background-color: <?php echo $color_cat;?>}
	                	</style>
                	<?php endif ;?>
                    <?php 	
                    if ('post' == get_post_type($news->ID) && rehub_option('exclude_cat_meta') != 1) {
	                    $category = get_the_category();
						$category_id = $category[0]->term_id;
						$category_link = get_category_link($category_id);
						$category_name = get_cat_name($category_id);
						$category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>'; 
						echo $category_echo ;                   	
                    }
                    ?>
                    <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                    <?php do_action( 'rehub_after_news_no_thumbs_title' ); ?>
                    <div class="post-meta"><?php meta_all( true, false, true ); ?></div>
                    <?php do_action( 'rehub_after_news_no_thumbs_text' ); ?>
                </div>
	        </figure>
        </div>
    </div>
    <?php endwhile; endif; wp_reset_query(); ?>

    <?php $args['showposts'] = 5; $args['offset'] = 1; $args['no_found_rows'] = 1; $nextnews = new WP_Query($args); 
        if( $nextnews->have_posts() ) : echo '<div class="right_news_col">';
        while($nextnews->have_posts()) : $nextnews->the_post(); 
    ?>
        <div class="news_no_thumbs">
            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
            <div class="post-meta">
                <p><?php meta_small( true, false, true ); ?></p>
            </div>
        </div>
    <?php endwhile; echo '</div>'; endif; wp_reset_query(); ?>    
</div>
<?php endif ; ?>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('news_no_thumbs_mod', 'wpsm_news_no_thumbs_mod_shortcode');
}

//////////////////////////////////////////////////////////////////
// NEWS WITH THUMBNAILS
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_news_with_thumbs_mod_shortcode') ) {
function wpsm_news_with_thumbs_mod_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'module_cats' => '',
	'module_tags' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'color_cat' => '',
	'post_formats' => ''
), $atts, 'news_with_thumbs_mod'));                
ob_start(); 
?>

<?php   
	$args = array('ignore_sticky_posts' => 1, 'showposts' => 1, 'offset'=>0, 'no_found_rows' => 1);
    if ($module_cats !='' && $module_cats != 'all') {$args['cat'] = $module_cats;}
    if ($module_tags !='') {$args['tag__in'] = array_map( 'trim', explode(",", $module_tags ));}
    if ($cat_exclude !='') {$args['category__not_in'] = array_map( 'trim', explode(",", $cat_exclude ));}
    if ($tag_exclude !='') {$args['tag__not_in'] = array_map( 'trim', explode(",", $tag_exclude ));}
    if ($post_formats != 'all' && $post_formats != '') {$args['meta_key'] = 'rehub_framework_post_type'; $args['meta_value'] = $post_formats;}
 
	$rand_id = uniqid().time(); 
?>
<?php if( !is_paged()) : ?>
<div class="news_block clearfix">
    <?php $news = new WP_Query($args); 
        if( $news->have_posts() ) :
        while($news->have_posts()) : $news->the_post(); 
    ?>
	<?php $category_echo = '';	
	if ('post' == get_post_type($news->ID) && rehub_option('exclude_cat_meta') != 1) {
	    $category = get_the_category();
		$category_id = $category[0]->term_id;
		$category_link = get_category_link($category_id);
		$category_name = get_cat_name($category_id);
		$category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>';                   	
	}
	?>
    <div class="left_news_col">
    	<div class="news_out_thumb">
	    	<figure id="n_with_t_<?php echo $rand_id;?>">
	    		<?php if ($color_cat) :?>
		        	<style scoped>
		        		#n_with_t_<?php echo $rand_id;?> .news_cat a{background-color: <?php echo $color_cat;?>}
		        	</style>
	        	<?php endif;?>
	            <?php echo $category_echo ;?>    	
	            <?php echo re_badge_create('ribbon'); ?>
	    	    <a href="<?php the_permalink();?>"><?php wpsm_thumb ('medium_news') ?></a>
	    		<?php rehub_formats_icons('full') ?>
	        </figure>
	        <?php do_action( 'rehub_after_news_with_thumbs_figure' ); ?>
	        <div class="text_out_thumb">
	        	<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
	        	<?php do_action( 'rehub_after_news_with_thumbs_title' ); ?>
	        	<div class="post-meta"> <?php meta_small( true, false, true ); ?> </div>            
	            <p><?php kama_excerpt('maxchar=160'); ?></p>  
	            <?php do_action( 'rehub_after_news_with_thumbs_text' ); ?>              
	        </div> 
        </div>       
    </div>
    <?php endwhile; endif; wp_reset_query(); ?>

    <?php $args['showposts'] = 4; $args['offset'] = 1; $args['no_found_rows'] = 1;$nextnews = new WP_Query($args); 
        if( $nextnews->have_posts() ) : echo '<div class="right_news_col">';
        while($nextnews->have_posts()) : $nextnews->the_post(); 
    ?>
        <div class="news_widget_item clearfix">	
            <figure><a href="<?php the_permalink();?>"><?php wpsm_thumb ('med_thumbs') ?></a><?php rehub_formats_icons('small') ?></figure>
            <div class="detail">
                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                <div class="post-meta">
                    <p><?php meta_small( true, false, true ); ?></p>
                </div>
                <?php rehub_format_score('small');?>
            </div>
        </div>
    <?php endwhile; echo '</div>'; endif; wp_reset_query(); ?>    
</div>
<?php endif ; ?>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('news_with_thumbs_mod', 'wpsm_news_with_thumbs_mod_shortcode');
}

//////////////////////////////////////////////////////////////////
// TABS BLOCK
//////////////////////////////////////////////////////////////////
if( !function_exists('tab_mod_shortcode') ) {
function tab_mod_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'module_name_first' => '',
	'module_name_second' => '',
	'module_name_third' => '',
	'module_name_fourth' => '',			
	'module_cats_first' => '',
	'module_cats_second' => '',
	'module_cats_third' => '',
	'module_cats_fourth' => '',	
	'cat_exclude_first' => '',
	'cat_exclude_second' => '',	
	'cat_exclude_third' => '',
	'cat_exclude_fourth' => '',	
	'module_tags_first' => '',
	'module_tags_second' => '',
	'module_tags_third' => '',
	'module_tags_fourth' => '',	
	'tag_exclude_first' => '',
	'tag_exclude_second' => '',	
	'tag_exclude_third' => '',
	'tag_exclude_fourth' => '',				
	'color_cat_first' => '',
	'color_cat_second' => '',
	'color_cat_third' => '',
	'color_cat_fourth' => '',
), $atts, 'tab_mod'));                
ob_start(); 
?>
<?php if( !is_paged()) : ?>
<?php   
	$rand_id_first = 'cat1'.uniqid();
	$rand_id_second = 'cat2'.uniqid();
	$rand_id_third = 'cat3'.uniqid();
	$rand_id_fourth = 'cat4'.uniqid(); 
?>
<div class="news_out_tabs tabs">
<style scoped>
	<?php if( !empty( $color_cat_first )) :?>.news_out_tabs > ul > li.tabcat-<?php echo $rand_id_first;?>:hover, .news_out_tabs > ul > li.tabcat-<?php echo $rand_id_first;?>.current, .<?php echo $rand_id_first;?> .news_cat a{background-color: <?php echo $color_cat_first;?>}<?php endif ;?>
	<?php if( !empty( $color_cat_second )) :?>.news_out_tabs > ul > li.tabcat-<?php echo $rand_id_second;?>:hover, .news_out_tabs > ul > li.tabcat-<?php echo $rand_id_second;?>.current, .<?php echo $rand_id_second;?> .news_cat a{background-color: <?php echo $color_cat_second;?>}<?php endif ;?>
	<?php if( !empty( $color_cat_third )) :?>.news_out_tabs > ul > li.tabcat-<?php echo $rand_id_third;?>:hover, .news_out_tabs > ul > li.tabcat-<?php echo $rand_id_third;?>.current, .<?php echo $rand_id_third;?> .news_cat a{background-color: <?php echo $color_cat_third;?>}<?php endif ;?>
	<?php if( !empty( $color_cat_fourth )) :?>.news_out_tabs > ul > li.tabcat-<?php echo $rand_id_fourth;?>:hover, .news_out_tabs > ul > li.tabcat-<?php echo $rand_id_fourth;?>.current, .<?php echo $rand_id_fourth;?> .news_cat a{background-color: <?php echo $color_cat_fourth;?>}<?php endif ;?>
</style>
<ul class="tabs-menu clearfix">
  	<?php if( !empty( $module_name_first )) :?><li class="first tabcat-<?php echo $rand_id_first;?>"><?php echo $module_name_first ?></li><?php endif ;?>
  	<?php if( !empty( $module_name_second )) :?><li class="second tabcat-<?php echo $rand_id_second;?>"><?php echo $module_name_second ?></li><?php endif ;?>
  	<?php if( !empty( $module_name_third )) :?><li class="third tabcat-<?php echo $rand_id_third ?>"><?php echo $module_name_third ?></li><?php endif ;?>
  	<?php if( !empty( $module_name_fourth )) :?><li class="fourth tabcat-<?php echo $rand_id_fourth ?>"><?php echo $module_name_fourth ?></li><?php endif ;?>
</ul>

<?php $tabs_arrays = array('first' => $module_name_first, 'second' => $module_name_second, 'third' => $module_name_third, 'fourth' => $module_name_first); ?>

<?php foreach ($tabs_arrays as $arg_number=>$value):?>

	<?php if(!empty($value)) :?>
		<?php   
			${'args'.$arg_number} = array('ignore_sticky_posts' => 1, 'showposts' => 1, 'offset'=>0, 'no_found_rows' => 1);
		    if (${'module_cats_'.$arg_number} !='' && ${'module_cats_'.$arg_number} != 'all') {${'args'.$arg_number}['cat'] = ${'module_cats_'.$arg_number};}
		    if (${'module_tags_'.$arg_number} !='') {${'args'.$arg_number}['tag__in'] = explode(',', ${'module_tags_'.$arg_number});}
		    if (${'cat_exclude_'.$arg_number} !='') {${'args'.$arg_number}['category__not_in'] = explode(',', ${'cat_exclude_'.$arg_number});}
		    if (${'tag_exclude_'.$arg_number} !='') {${'args'.$arg_number}['tag__not_in'] = explode(',', ${'tag_exclude_'.$arg_number});}
		?>
		<div class="news_block tabs-item clearfix <?php echo ${'rand_id_'.$arg_number};?>">
		    <?php $news = new WP_Query(${'args'.$arg_number}); 
		        if( $news->have_posts() ) :
		        while($news->have_posts()) : $news->the_post(); 
		    ?>
            <?php $category_echo = '';	
            if ('post' == get_post_type($news->ID) && rehub_option('exclude_cat_meta') != 1) {
                $category = get_the_category();
				$category_id = $category[0]->term_id;
				$category_link = get_category_link($category_id);
				$category_name = get_cat_name($category_id);
				$category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>';                    	
            }
            ?>		    
		    <div class="left_news_col">
		    	<div class="news_out_thumb">
			    	<figure>
			            <?php echo $category_echo ;?>    	
			            <?php echo re_badge_create('ribbon'); ?>
			    	    <a href="<?php the_permalink();?>"><?php wpsm_thumb ('medium_news') ?></a>
			    		<?php rehub_format_score('small', 'square') ?>
			        </figure>
			        <?php do_action( 'rehub_after_tab_mod_figure' ); ?>
			        <div class="text_out_thumb">
			        	<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
			        	<?php do_action( 'rehub_after_tab_mod_title' ); ?>
			        	<div class="post-meta"> <?php meta_small( true, false, true ); ?> </div>            
			            <p><?php kama_excerpt('maxchar=160'); ?></p>                
			        </div> 
		        </div>       
		    </div>
		    <?php endwhile; endif; wp_reset_query(); ?>

		    <?php ${'args'.$arg_number}['showposts'] = 4; ${'args'.$arg_number}['offset'] = 1; ${'args'.$arg_number}['no_found_rows'] = 1; $nextnews = new WP_Query(${'args'.$arg_number}); 
		        if( $nextnews->have_posts() ) : echo '<div class="right_news_col">';
		        while($nextnews->have_posts()) : $nextnews->the_post(); 
		    ?>
		        <div class="news_widget_item clearfix">	
		            <figure><a href="<?php the_permalink();?>"><?php wpsm_thumb ('med_thumbs') ?></a><?php rehub_formats_icons('small') ?></figure>
		            <div class="detail">
		                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
		                <div class="post-meta">
		                    <p><?php meta_small( true, false, true ); ?></p>
		                </div>
		                <?php rehub_format_score('small');?>
		            </div>
		        </div>
		    <?php endwhile; echo '</div>'; endif; wp_reset_query(); ?>    
		</div>
		<?php do_action( 'rehub_after_tab_mod_module' ); ?>				

	<?php endif;?>

<?php endforeach;?>


</div>
<?php endif ; ?>
<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('tab_mod', 'tab_mod_shortcode');
}


//////////////////////////////////////////////////////////////////
// TITLE MODULE
//////////////////////////////////////////////////////////////////
if( !function_exists('title_mod_shortcode') ) {
function title_mod_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'title_name' => '',
	'title_color' => '',
	'title_background_color' => '',
	'title_size' => 'middle',	
	'title_bold' => '',
	'title_icon' => '',
	'title_pos' => 'left',
	'title_line' => 'under-title',
	'title_line_color' => '',
	'vc_link' => '',
	'title_url_title' =>'',
	'title_url_url' =>'',
	'title_class_add' => '',
), $atts, 'title_mod'));
ob_start(); 
?>

<?php if (!empty($title_name)) :?>
	<?php $rand_id = '-'.uniqid(); ?>
	<?php $upper_echo = ($title_bold == 1) ? 'no_bold_title' : '';?>
	<?php $back_echo = ($title_background_color != '') ? 'background_title' : '';?>
	<?php $icon_echo = ($title_icon != '') ? '<i class="'.$title_icon.'"></i> ' : '';?>
	<?php 
		$title_url_target = '_self';
		if ($vc_link !='' && $vc_link != '||') {
			$title_url = vc_build_link( $vc_link );
			$title_url_title = ($title_url !='') ? $title_url['title'] : '';
			$title_url_url = ($title_url !='') ? $title_url['url'] : '';
			$title_url_target = ($title_url !='') ? $title_url['target'] : '';
		}

		$add_link_echo = ($title_url_url !='' && $title_url_title !='') ? '<a href="'.esc_url($title_url_url).'" target="'.$title_url_target.'" class="add-link-title">'.$title_url_title.'</a>' : '';

	?>

	<div id="wpsm-title<?php echo $rand_id;?>" class="wpsm-title <?php echo $title_size;?>-size-title <?php echo $upper_echo;?> <?php echo $title_pos;?>-align-title <?php echo $title_line;?>-line <?php echo $back_echo;?> <?php echo esc_html($title_class_add);?>">
		<?php if ($title_color !='' || $title_background_color !='' || $title_line_color !='') :?>
			<style scoped>
				<?php if ($title_color !='') :?>
					#wpsm-title<?php echo $rand_id;?> h5{color:<?php echo $title_color;?>;}
				<?php endif;?>
				<?php if ($title_background_color !='') :?>
					#wpsm-title<?php echo $rand_id;?> h5{background-color:<?php echo $title_background_color?>;}
				<?php endif;?>	
				<?php if ($title_line_color !='') :?>
					#wpsm-title<?php echo $rand_id;?>:after{background-color:<?php echo $title_line_color?>;}
				<?php endif;?>					
			</style>
		<?php endif;?>
		<h5><?php echo $icon_echo; echo $title_name;?></h5>
		<?php echo $add_link_echo;?>
	</div>

<?php endif;?>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('title_mod', 'title_mod_shortcode');
}

//////////////////////////////////////////////////////////////////
// TWO COLUMN BLOCK
//////////////////////////////////////////////////////////////////
if( !function_exists('two_col_news_shortcode') ) {
function two_col_news_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'module_cats_first' => '',
	'module_tags_first' => '',
	'cat_exclude_first' => '',
	'tag_exclude_first' => '',
	'post_formats_first' => '',	
	'module_cats_second' => '',
	'module_tags_second' => '',
	'cat_exclude_second' => '',
	'tag_exclude_second' => '',
	'post_formats_second' => '',
	'color_cat_first' => '',
	'color_cat_second' => '',		
	'module_offset_second'=> '',
	'module_fetch' => 4,
	'compact' => '',
	'only_one' => '',
), $atts, 'two_col_news'));                
ob_start(); 
?>
<?php $count = $count_sec = 0;?>
<?php $inout = ($compact !='') ? 'in' : 'out'; ?>
<?php if( !is_paged()) : ?>
<div class="news_two_col_block">
	<div class="<?php if ($only_one == '') {echo'left_news_col';}?>">
	<?php   
		$args = array('ignore_sticky_posts' => 1, 'showposts' => $module_fetch, 'no_found_rows' => 1);
		$rand_id = 'two_col_news'.uniqid();
	    if ($module_cats_first !='' && $module_cats_first != 'all') {$args['cat'] = $module_cats_first;}
	    if ($module_tags_first !='') {$args['tag__in'] = explode(',', $module_tags_first);}
	    if ($cat_exclude_first !='') {$args['category__not_in'] = explode(',', $cat_exclude_first);}
	    if ($tag_exclude_first !='') {$args['tag__not_in'] = explode(',', $tag_exclude_first);}
	    if ($post_formats_first != 'all' && $post_formats_first != '') {$args['meta_key'] = 'rehub_framework_post_type'; $args['meta_value'] = $post_formats_first;}
	?>
	<?php $news = new WP_Query($args); 
	    if( $news->have_posts() ) :
	    while($news->have_posts()) : $news->the_post(); $count ++; 
	?> 
		<?php if($count == 1) : ?>
			<div class="news_<?php echo $inout;?>_thumb">
				<figure id="t_c_t_<?php echo $rand_id;?>">
					<?php if ($color_cat_first):?>
			        	<style scoped>
			        		#t_c_t_<?php echo $rand_id;?> .news_cat a{background-color: <?php echo $color_cat_first;?>}
			        	</style>
		        	<?php endif;?>				
                    <?php $category_echo = '';	
                    if ('post' == get_post_type($news->ID) && rehub_option('exclude_cat_meta') != 1) {
	                    $category = get_the_category();
						$category_id = $category[0]->term_id;
						$category_link = get_category_link($category_id);
						$category_name = get_cat_name($category_id);
						$category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>';                  	
                    }
                    ?>    			            	
			        <?php echo re_badge_create('ribbon'); ?>
				    <a href="<?php the_permalink();?>"><?php wpsm_thumb ('medium_news') ?></a>
					<?php rehub_formats_icons('full') ?>
					<?php if ($compact !='') :?>
					    <div class="text_in_thumb">
					    	<?php echo $category_echo ;?>
					    	<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
					    	<div class="post-meta"> <?php meta_small( true, false, true ); ?> </div>                            
					    </div>
					<?php else :?>
						<?php echo $category_echo ;?>
				    <?php endif;?>					
			    </figure>
				<?php if ($compact =='') :?>
				    <div class="text_out_thumb">
				    	<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
				    	<?php do_action( 'rehub_after_two_column_title' ); ?>
				    	<div class="post-meta"> <?php meta_small( true, false, true ); ?> </div>            
				        <p><?php kama_excerpt('maxchar=160'); ?></p>                
				    </div>
			    <?php endif;?>			    
		    </div>
		<?php else :?>	    
		    <div class="news_widget_item clearfix">	
		        <figure><a href="<?php the_permalink();?>"><?php wpsm_thumb ('med_thumbs') ?></a></figure>
		        <div class="detail">
		            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
		            <?php do_action( 'rehub_after_two_column_title' ); ?>
		            <div class="post-meta">
		                <p><?php meta_small( true, false, true ); ?></p>
		            </div>
		            <?php rehub_format_score('small');?>
		        </div>
		    </div>
	    <?php endif;?> 
	<?php endwhile; endif; wp_reset_query(); ?>
	</div>

	<?php if ($only_one == '') : ?>
	<div class="right_news_col">
	<?php   
		$args_second = array('ignore_sticky_posts' => 1, 'showposts' => $module_fetch, 'offset' => $module_offset_second, 'no_found_rows' => 1);
	    if ($module_cats_second !='' && $module_cats_second != 'all') {$args_second['cat'] = $module_cats_second;}
	    if ($module_tags_second !='') {$args_second['tag__in'] = explode(',', $module_tags_second);}
	    if ($cat_exclude_second !='') {$args_second['category__not_in'] = explode(',', $cat_exclude_second);}
	    if ($tag_exclude_second !='') {$args_second['tag__not_in'] = explode(',', $tag_exclude_second);}
	    if ($post_formats_second != 'all' && $post_formats_second != '') {$args_second['meta_key'] = 'rehub_framework_post_type'; $args_second['meta_value'] = $post_formats_second;}
	?>
	<?php $news_second = new WP_Query($args_second); 
	    if( $news_second->have_posts() ) :
	    while($news_second->have_posts()) : $news_second->the_post(); $count_sec ++; 
	?> 
		<?php if($count_sec == 1) : ?>
			<div class="news_<?php echo $inout;?>_thumb">
				<figure id="t_c_t_sec<?php echo $rand_id;?>">
					<?php if ($color_cat_second):?>
			        	<style scoped>
			        		#t_c_t_sec<?php echo $rand_id;?> .news_cat a{background-color: <?php echo $color_cat_second;?>}
			        	</style>
		        	<?php endif;?>				
                    <?php $category_echo = '';	
                    if ('post' == get_post_type($news_second->ID) && rehub_option('exclude_cat_meta') != 1) {
	                    $category = get_the_category();
						$category_id = $category[0]->term_id;
						$category_link = get_category_link($category_id);
						$category_name = get_cat_name($category_id);
						$category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>';                    	
                    }
                    ?>   	    	
			        <?php echo re_badge_create('ribbon'); ?>
				    <a href="<?php the_permalink();?>"><?php wpsm_thumb ('medium_news') ?></a>
					<?php rehub_formats_icons('full') ?>
					<?php if ($compact !='') :?>
					    <div class="text_in_thumb">
					    	<?php echo $category_echo ;?>
					    	<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
					    	<div class="post-meta"> <?php meta_small( true, false, true ); ?> </div>                            
					    </div>
					<?php else :?>
						<?php echo $category_echo ;?>					    
				    <?php endif;?>					
			    </figure>
				<?php if ($compact =='') :?>
				    <div class="text_out_thumb">
				    	<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
				    	<?php do_action( 'rehub_after_two_column_title' ); ?>
				    	<div class="post-meta"> <?php meta_small( true, false, true ); ?> </div>            
				        <p><?php kama_excerpt('maxchar=160'); ?></p>                
				    </div>
			    <?php endif;?>
		    </div>
		<?php else :?>	    
		    <div class="news_widget_item clearfix">	
		        <figure><a href="<?php the_permalink();?>"><?php wpsm_thumb ('med_thumbs') ?></a></figure>
		        <div class="detail">
		            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
		            <?php do_action( 'rehub_after_two_column_title' ); ?>
		            <div class="post-meta">
		                <p><?php meta_small( true, false, true ); ?></p>
		            </div>
		            <?php rehub_format_score('small');?>
		        </div>
		    </div>
	    <?php endif;?> 
	<?php endwhile; endif; wp_reset_query(); ?>	
	</div>
	<?php endif; ?>

</div>


<?php endif; ?>
<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('two_col_news', 'two_col_news_shortcode');
}


//////////////////////////////////////////////////////////////////
// CAROUSEL
//////////////////////////////////////////////////////////////////
if( !function_exists('full_carousel_shortcode') ) {
function full_carousel_shortcode( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 8,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',	
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
	'style' => '2',
	'aff_link' => '',
	'autorotate'=> '',
	'add_badge'=>'',
	'badge_title' => 'Editor choice',
	'color_stamp' => '',
	'showrow'=> '4',
	'cat_id' =>'',
	'nav_dis' => '',
	'number_posts'=>''	
), $atts, 'full_carousel');  
extract($build_args);
ob_start(); 
?>
<?php wp_enqueue_script('owlcarousel'); ?>
<?php $autodata = ($autorotate) ? 'data-auto="1"' : 'data-auto="0"' ;?>
<?php $disable_nav = ($nav_dis) ? 'data-navdisable="1"' : '' ;?>
<?php $disable_nav_class = ($nav_dis) ? ' no-nav-carousel' : '' ;?>
<?php 
if (!empty($number_posts)) {$show=$number_posts;}
if (!empty($cat_id)) {
	$build_args['cat']=$cat_id; $style='2';
	$cat_name = get_cat_name($cat_id);
	$category_link = get_category_link( $cat_id);
	echo '<h5>'.__('From category: ', 'rehub_framework').'<a href="'.$category_link.'" class="link_to_cat">'.$cat_name.'</a></h5>';
}
?>
<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
	$args['ignore_sticky_posts'] = 1;
?>

<div class="post_carousel_block loading carousel-style-<?php echo $style;?><?php echo $disable_nav_class;?>">
    <?php if ($add_badge != '') :?>
		<?php $rand_id = 'carousel'.uniqid();?>
    	<?php if ($color_stamp) :?>
        	<style scoped>
        		#badge_<?php echo $rand_id;?>, #badge_<?php echo $rand_id;?> span{background-color: <?php echo $color_stamp;?>}
        	</style>
    	<?php endif;?>    		
		<div class="carousel-stamp"><span class="re-starburst" id="badge_<?php echo $rand_id;?>"><span><span><span><span><span><span><span><span><strong><?php echo strip_tags($badge_title);?></strong></span></span></span></span></span></span></span></span></span></span></div>
	<?php endif;?>

    <div class="re_carousel" data-showrow="<?php echo $showrow;?>" <?php echo $autodata;?> <?php echo $disable_nav;?> data-laizy="1">
        <?php $result_cat = array();
            $home_carousel = new WP_Query($args); 
            if( $home_carousel->have_posts() ) :
            while($home_carousel->have_posts()) : $home_carousel->the_post();
        ?>
		<?php 
		if ($aff_link == '1') {
		    $link = rehub_create_affiliate_link ();
		    $target = ' rel="nofollow" target="_blank"';
		}
		else {
		    $link = get_the_permalink();
		    $target = '';  
		}
		?> 
        <?php 
        $showimg = new WPSM_image_resizer();
        $showimg->use_thumb = true;
        $showimg->width = '300';
        $showimg->height = '216';
        $showimg->crop = true;
        $showimg->lazy = false;                                    
        ?>
        <?php 	
        if ('post' == get_post_type($home_carousel->ID)) {
            $category = get_the_category();
			$category_id = $category[0]->term_id; 
			$category_echo = $category_id;                  	
        }
        else {$category_echo = '';  }
        ?>
        <div class="carousel-item tabcat-<?php echo $category_echo;?>">
            <figure>
                <?php rehub_formats_icons() ?>
                <a href="<?php echo $link;?>"<?php echo $target;?>>
                	<img class="owl-lazy" data-src="<?php echo $showimg->get_resized_url();?>" alt="<?php the_title_attribute(); ?>">
                </a>                    
                	<?php if ($style==1) :?>
                		<div class="text-oncarousel">
                    		<h3><a href="<?php echo $link;?>"<?php echo $target;?>><?php $post_title = get_the_title(); rehub_truncate('maxchar=55&text='.$post_title.''); ?></a></h3>
                        	<div class="post-meta"><?php if ('post' == get_post_type($home_carousel->ID)) {meta_small( false, $category_id, false, false );} ?></div>	                        	
                        	<?php rehub_format_score('small') ?>
                        	<div class="views-in-carosel"><?php rehub_create_btn('', 'price');?></div>
                    	</div>
                	<?php endif;?>                       
            </figure> 
        	<?php if ($style==2) :?>
        		<div class="text-oncarousel">
            		<h3><a href="<?php echo $link;?>"<?php echo $target;?>><?php the_title();?></a></h3>
                	<div class="post-meta"><?php if ('post' == get_post_type($home_carousel->ID)) {meta_small( false, $category_id, false, false );} ?></div>	                        	
                	<?php rehub_create_btn('', 'price');?>
                	<?php do_action( 'rehub_after_uni_carousel_text' ); ?>
            	</div>
        	<?php endif;?>                                           
        </div>
        <?php endwhile; endif; wp_reset_query(); ?>
    </div>


</div>     


<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('full_carousel', 'full_carousel_shortcode');
add_shortcode('wpsm_recent_posts', 'full_carousel_shortcode');
}


//////////////////////////////////////////////////////////////////
// DEAL CAROUSEL
//////////////////////////////////////////////////////////////////
if( !function_exists('deal_carousel_shortcode') ) {
function deal_carousel_shortcode( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 8,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',	
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
	'style' => '3',
	'aff_link' => '',
	'autorotate'=> '',
	'showrow'=> '4',	
), $atts, 'post_carousel_mod');  
extract($build_args);
ob_start(); 
?>
<?php wp_enqueue_script('owlcarousel'); ?>
<?php $autodata = ($autorotate) ? 'data-auto="1"' : 'data-auto="0"' ;?>
<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
	$args['ignore_sticky_posts'] = 1;
?>
<?php if ($style == 3):?>  
    <div class="post_carousel_block loading carousel-style-3">
        <div class="re_carousel" data-showrow="3" data-laizy="1" data-fullrow="2">
	        <?php $result_cat = array(); 
	            $deal_carousel = new WP_Query($args); 
	            if( $deal_carousel->have_posts() ) :
	            while($deal_carousel->have_posts()) : $deal_carousel->the_post();
	        	global $post;
	        ?>
			<?php 
			if ($aff_link == '1') {
			    $link = rehub_create_affiliate_link ();
			    $target = ' rel="nofollow" target="_blank"';
			}
			else {
			    $link = get_the_permalink();
			    $target = '';  
			}
			?> 
            <?php 
            $showimg = new WPSM_image_resizer();
            $showimg->use_thumb = true;
            $showimg->height = '120';
            $showimg->crop = true;
            $showimg->lazy = false;                                    
            ?>
            <?php   
            if ('post' == get_post_type($post->ID)) {
                $category = get_the_category();
                $category_id = $category[0]->term_id; 
                $category_echo = $category_id;                      
            }
            else {$category_echo = '';  }
            ?>
            <div class="carouselhor-item">
                <div class="l-part-car">
                    <figure>
                        <a href="<?php echo $link;?>"<?php echo $target;?>>
                            <img class="owl-lazy" height="120" data-src="<?php echo $showimg->get_resized_url();?>" alt="<?php the_title_attribute(); ?>">
                        </a>                                           
                    </figure> 
                </div>
                <div class="r-part-car">
                    <?php echo getHotIconfire($post->ID);?><?php echo getHotLikeTitle($post->ID);?>
                    <h2><a href="<?php echo $link;?>"<?php echo $target;?>><?php kama_excerpt('maxchar=55&text='.get_the_title()) ;?></a></h2>
                    <div class="post-meta"><?php if ('post' == get_post_type($post->ID)) {meta_small( false, $category_id, false, false );} ?></div>                                
                    <?php rehub_create_price_for_list($post->ID);?>
                    <?php do_action( 'rehub_after_recash_carousel_text' ); ?>
                </div>                                           
            </div>
            <?php endwhile; endif; wp_reset_query(); ?>
        </div>
    </div>	
<?php else:?>
<div class="post_carousel_block loading carousel-style-2 carousel-style-deal showrow-<?php echo $showrow;?>">
    <div class="re_carousel" data-showrow="<?php echo $showrow;?>" <?php echo $autodata;?> data-laizy="1">
        <?php $result_cat = array();
            $deal_carousel = new WP_Query($args); 
            if( $deal_carousel->have_posts() ) :
            while($deal_carousel->have_posts()) : $deal_carousel->the_post();
        ?>
		<?php 
		if ($aff_link == '1') {
		    $link = rehub_create_affiliate_link ();
		    $target = ' rel="nofollow" target="_blank"';
		}
		else {
		    $link = get_the_permalink();
		    $target = '';  
		}
		?>   
        <?php 
        $showimg = new WPSM_image_resizer();
        $showimg->use_thumb = true;
        $showimg->width = '120';
        $showimg->crop = true;
        $showimg->lazy = false;                                    
        ?>        
        <div class="deal-item-wrap">
        	<div class="deal-item">
                <a href="<?php echo $link;?>"<?php echo $target;?>>
                	<img class="owl-lazy" data-src="<?php echo $showimg->get_resized_url();?>" alt="<?php the_title_attribute(); ?>">
                </a>                    
        		<div class="info-overlay">
                	<?php rehub_create_btn('', 'price');?>
                	<?php do_action( 'rehub_after_deal_carousel_price' ); ?>
            	</div>                                                                       
        	</div>
        	<div class="deal-detail">
        		<h3><a href="<?php echo $link;?>"<?php echo $target;?>><?php the_title();?></a></h3>
        		<?php do_action( 'rehub_after_deal_carousel_title' ); ?>
        	</div>
        </div>
        <?php endwhile; endif; wp_reset_query(); ?>
    </div>
</div> 
<?php endif;?>    

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('post_carousel_mod', 'deal_carousel_shortcode');
}


//////////////////////////////////////////////////////////////////
// WOO CAROUSEL
//////////////////////////////////////////////////////////////////
if( !function_exists('woo_mod_shortcode') ) {
function woo_mod_shortcode( $atts, $content = null ) {
$build_args = shortcode_atts(array(
	'data_source' => 'cat',//Filters start
	'cat' => '',
	'tag' => '',
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key'=>'',
	'show' => 8,	
	'show_coupons_only' => '',
	'user_id' => '',	
	'type' => 'latest',	
	'tax_name'=>'',
	'tax_slug'=>'',	
	'tax_slug_exclude'=>'',	
	'enable_pagination' => '', //end woo filters
	'autorotate'=> '',
	'showrow'=> '3',
	'aff_link' => '',				
), $atts, 'woo_mod');
extract($build_args); 
ob_start(); 
?>
<?php wp_enqueue_script('owlcarousel'); ?>
<?php $autodata = ($autorotate) ? 'data-auto="1"' : 'data-auto="0"' ;?>
<?php $full_row_data = ($showrow == '5' || $showrow == '6') ? 'data-fullrow="1"' : 'data-fullrow="0"' ;?>

<div class="woo_carousel_block woo_sell_block loading carousel-style-2 carousel-style-deal woocommerce showrow-<?php echo $showrow;?>">

    <div class="re_carousel" data-showrow="<?php echo $showrow;?>" <?php echo $autodata;?> <?php echo $full_row_data;?> data-laizy="1" data-loopdisable="1">
		<?php		 
			$argsfilter = new WPSM_Woohelper($build_args);
			$args = $argsfilter->extract_filters();
		?>
        <?php $products = new WP_Query( $args );                    
            if ( $products->have_posts() ) : ?>                      
                <?php while ( $products->have_posts() ) : $products->the_post(); global $product ?> 
				    <?php $woolink = ($aff_link == '1' && $product->product_type =='external') ? $product->add_to_cart_url() : get_post_permalink(get_the_ID()) ;?>
				    <?php $target = ($aff_link == '1' && $product->product_type =='external') ? ' target="_blank" rel="nofollow"' : '' ;?>
					<?php $offer_coupon = get_post_meta( get_the_ID(), 'rehub_woo_coupon_code', true ) ?>
					<?php $offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_woo_coupon_date', true ) ?>
					<?php $offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_woo_coupon_mask', true ) ?>
					<?php $offer_coupon_url = esc_url( $product->add_to_cart_url() ); ?>
					<?php $coupon_style = $expired =''; if(!empty($offer_coupon_date)) : ?>
					    <?php
					    $timestamp1 = strtotime($offer_coupon_date);
					    $seconds = $timestamp1 - (int)current_time('timestamp',0);
					    $days = floor($seconds / 86400);
					    $seconds %= 86400;
					    if ($days > 0) {
					        $coupon_text = $days.' '.__('days left', 'rehub_framework');
					        $coupon_style = '';
					    }
					    elseif ($days == 0){
					      $coupon_text = __('Last day', 'rehub_framework');
					      $coupon_style = '';
					    }
					    else {
					      $coupon_text = __('Expired', 'rehub_framework');
					      $coupon_style = ' expired_coupon';
					      $expired = '1';
					    }
					    ?>
					<?php endif ;?>
					<?php do_action('woo_change_expired', $coupon_style); //Here we update our expired?>
					<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
					<?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
					<?php $outsidelinkpart = ($coupon_mask_enabled=='1') ? ' data-codeid="'.$product->id.'" data-dest="'.$offer_coupon_url.'" data-clipboard-text="'.$offer_coupon.'" class="masked_coupon"' : '';?>				                    	                 
			        <?php 
			        $showimg = new WPSM_image_resizer();
			        $showimg->use_thumb = true;
			        $showimg->width = '154';
			        $showimg->crop = true;
			        $showimg->lazy = false;                                    
			        ?>
			        <div class="deal-item-wrap<?php echo $reveal_enabled; echo $coupon_style; ?>">
			        	<div class="deal-item">
			                <?php if ($product->is_on_sale() && !$product->is_type( 'variable' ) && $product->get_regular_price() && $product->get_price() > 0) : ?>
			                    <span class="small_sale_a_proc">
			                        <?php   
			                            $offer_price_calc = (float) $product->get_price();
			                            $offer_price_old_calc = (float) $product->get_regular_price();
			                            $sale_proc = 0 -(100 - ($offer_price_calc / $offer_price_old_calc) * 100); 
			                            $sale_proc = round($sale_proc); 
			                            echo $sale_proc; echo '%';
			                        ;?>
			                    </span>
			                <?php endif ?>			        	
			                <a href="<?php echo $woolink;?>"<?php echo $target;?>>
			                	<img class="owl-lazy" data-src="<?php echo $showimg->get_resized_url();?>" alt="<?php the_title_attribute(); ?>">
			                </a>                    
			        		<div class="info-overlay">
			                	<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
			                	<?php do_action( 'rehub_after_woo_carousel_price' ); ?>
			            	</div>                                                                       
			        	</div>
			        	<div class="deal-detail">
				        	<h3><a href="<?php echo $woolink;?>"<?php echo $target;?>><?php the_title();?></a></h3>
				        	<?php do_action( 'rehub_after_woo_carousel_title' ); ?>
		                    <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
		                        <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
		                            sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn woo_loop_btn btn_offer_block %s %s product_type_%s"%s%s>%s</a>',
		                            esc_url( $product->add_to_cart_url() ),
		                            esc_attr( $product->id ),
		                            esc_attr( $product->get_sku() ),
		                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
		                            $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
		                            esc_attr( $product->product_type ),
		                            $product->product_type =='external' ? ' target="_blank"' : '',
		                            $product->product_type =='external' ? ' rel="nofollow"' : '',
		                            esc_html( $product->add_to_cart_text() )
		                            ),
		                        $product );?>
		                    <?php endif; ?> 

		                    <?php if ($coupon_mask_enabled =='1') :?>
		                        <?php wp_enqueue_script('zeroclipboard'); ?>                
		                        <a class="woo_loop_btn coupon_btn re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" href="<?php echo $woolink; ?>"<?php if ($product->product_type =='external'){echo ' target="_blank" rel="nofollow"'; echo $outsidelinkpart; } ?>>
		                            <?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?>
		                        </a>
		                    <?php else :?> 
		                        <?php if(!empty($offer_coupon)) : ?>
		                            <?php wp_enqueue_script('zeroclipboard'); ?>
		                            <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>">
		                                <i class="fa fa-scissors fa-rotate-180"></i>
		                                <span class="coupon_text"><?php echo $offer_coupon ?></span>
		                            </div>
		                        <?php endif ;?>                                               
		                    <?php endif;?>
		                    <?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>
	                        <?php do_action( 'rehub_after_woo_carousel_module' ); ?>	
                        </div>		        	
			        </div>        		


        <?php endwhile; endif; wp_reset_query(); ?>
    </div>
</div>     

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('woo_mod', 'woo_mod_shortcode');
}

//////////////////////////////////////////////////////////////////
// List of recent posts
//////////////////////////////////////////////////////////////////
if( !function_exists('recent_posts_function') ) {
function recent_posts_function( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 8,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',	
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
	'nometa' =>'',
	'image' =>'',
	'center' => '',
	'filterpanel' => '',
	'taxdrop' => '',
	'taxdroplabel' => '',	
), $atts, 'wpsm_recent_posts_list'); 
extract($build_args); 
$containerid = 'rh_simplepostid_' . uniqid();
$center_class=($center) ? ' text-center': ''; 
$ajaxoffset = (int)$show + (int)$offset;
$additional_vars = array();
$additional_vars['nometa'] = $nometa;
$additional_vars['image'] = $image;
if ($enable_pagination =='2'){
	$infinitescrollwrap = ' re_aj_pag_auto_wrap';
}     
elseif ($enable_pagination =='3') {
	$infinitescrollwrap = ' re_aj_pag_clk_wrap';
} 
else {
	$infinitescrollwrap = '';
}              
ob_start(); 
?>
<?php rehub_vc_filterpanel_render($filterpanel, $containerid, $taxdrop, $taxdroplabel);?>
<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
	$wp_query = new WP_Query($args);
?>
	<?php 
		if(!empty($args['paged'])){unset($args['paged']);}
		$jsonargs = json_encode($args);
		$json_innerargs = json_encode($additional_vars);
	?>
	<div class="wpsm_recent_posts_list<?php echo $center_class; echo $infinitescrollwrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="simplepostlist" id="<?php echo $containerid;?>" data-innerargs='<?php echo $json_innerargs;?>'>
<?php if ( $wp_query->have_posts() ) : ?>

		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  ?>	
			<?php include(rh_locate_template('inc/parts/simplepostlist.php')); ?>
		<?php endwhile; ?>

		<?php if ($enable_pagination == '1') :?>
			<div class="clearfix"></div>
		    <div class="pagination"><?php rehub_pagination();?></div>
		<?php elseif ($enable_pagination == '2' || $enable_pagination == '3' ) :?> 
		    <div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Show next', 'rehub_framework') ?></span></div>      
		<?php endif ;?>
<?php endif; wp_reset_query(); ?>
	</div>
	<div class="clearfix"></div>


<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('wpsm_recent_posts_list', 'recent_posts_function');
}


//////////////////////////////////////////////////////////////////
// 3 COLUMN FULL WIDTH ROW
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_three_col_posts_function') ) {
function wpsm_three_col_posts_function( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 3,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',	
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
	'custom_label_color'=>'',
	'custom_label' => ''
), $atts, 'wpsm_three_col_posts'); 
extract($build_args); 
$rand_id = uniqid().time(); 
$i = 0;           
ob_start(); 
?>

<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
	$args['ignore_sticky_posts'] = true;
	$wp_query = new WP_Query($args);
?>
<div class="wpsm_three_col_posts rh-flex-columns scroll-on-mobile" id="w_t_c_<?php echo $rand_id;?>">
<?php if($custom_label_color) :?>
	<style scoped>
		#w_t_c_<?php echo $rand_id;?> .custom_col_label{background-color: <?php echo $custom_label_color; ?> ;}
	</style>
<?php endif ;?>
<?php if ($custom_label) {echo '<div class="custom_col_label">'.$custom_label.'</div>';} ?>
<?php if($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post(); $i++ ?>	
	<div class="col-item news_in_thumb numb_<?php echo $i;?>">
		<figure>				   			            	
		    <a href="<?php the_permalink();?>">
                <?php 
                $showimg = new WPSM_image_resizer();
                $showimg->use_thumb = true;
                $showimg->width = '400';
                $showimg->height = '224';
                $showimg->crop = true;
                $showimg->show_resized_image();                                    
                ?>		    

		    </a>
			<?php rehub_formats_icons('full') ?>
		    <div class="text_in_thumb">
		    	<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
		    	<div class="post-meta"> <?php meta_small( true, false, true ); ?> </div>                            
		    </div>					
	    </figure>			    
    </div>
<?php endwhile; endif; ?>
</div>
<?php  wp_reset_query(); ?>

<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('wpsm_three_col_posts', 'wpsm_three_col_posts_function');
}

//////////////////////////////////////////////////////////////////
// Offer Box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_offerbox_shortcode') ) {
function wpsm_offerbox_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		'title' => '',
		'description' => '',
		'price' => '',
		'price_old' => '',
		'offer_coupon' => '',
		'offer_coupon_date' => '',
		'offer_coupon_mask' => '',
		'offer_coupon_mask_text' => '',
		'button_text' => '',
		'button_link' => '',
		'logo_thumb' => '',
		'logo_image_id' => '',
		'offer_linkid' => '',
	), $atts));

	if ($offer_coupon_mask_text =='') {
		if(rehub_option('rehub_mask_text') !=''){
			$offer_coupon_mask_text = rehub_option('rehub_mask_text');
		}
		else {
			$offer_coupon_mask_text = __('Reveal', 'rehub_framework');
		}
	}

	if ($button_text =='') {
		if(rehub_option('rehub_btn_text') !=''){
			$button_text = rehub_option('rehub_btn_text');
		}
		else {
			$button_text = __('Buy this item', 'rehub_framework');
		}
	} 

	$coupon_style = '';
	if(!empty($offer_coupon_date)) :
		$timestamp1 = strtotime($offer_coupon_date);
		$seconds = $timestamp1 - (int)current_time('timestamp',0);
		$days = floor($seconds / 86400);
		$seconds %= 86400;
		if ($days > 0) {
			$coupon_text = $days.' '.__('days left', 'rehub_framework');
			$coupon_style = '';
		}
		elseif ($days == 0){
			$coupon_text = __('Last day', 'rehub_framework');
			$coupon_style = '';
		}
		else {
			$coupon_text = __('Expired', 'rehub_framework');
			$coupon_style = 'expired_coupon';
		}			
	endif;
	$coupon_enabled_style = (!empty($atts['offer_coupon_mask'])) ? ' reveal_enabled '.$coupon_style.'' : ' '.$coupon_style.'';	
		
	$out = '<div class="rehub_feat_block table_view_block'.$coupon_enabled_style.'"><div class="block_with_coupon">';

	if(isset($atts['offer_linkid']) && $atts['offer_linkid']):

		$linkpost = get_post($atts['offer_linkid']);
		if ($linkpost) :
			$term_list = wp_get_post_terms($linkpost->ID, 'thirstylink-category', array("fields" => "names"));
			if (is_wp_error($term_list)){return;}
			$term_ids =  wp_get_post_terms($linkpost->ID, 'thirstylink-category', array("fields" => "ids")); 
			if (is_wp_error($term_ids)){return;}
			if (!empty($term_ids) && !is_wp_error($term_ids)) {$term_brand = $term_ids[0]; $term_brand_image = get_option("taxonomy_term_$term_brand");}	
			$attachments = get_posts( array(
	            'post_type' => 'attachment',
				'post_mime_type' => 'image',
	            'posts_per_page' => -1,
	            'post_parent' => $linkpost->ID,
		    ) );
		    if (!empty($attachments)) {$offer_thumb = wp_get_attachment_url( $attachments[0]->ID);} 
		    elseif (!empty($term_brand_image['brand_image'])) {$offer_thumb = $term_brand_image['brand_image'];}
		    else {$offer_thumb ='';}
	        $show_offer_thumb = new WPSM_image_resizer();
	        $show_offer_thumb->src = $offer_thumb; 
	        $show_offer_thumb->width = '100';
            $show_offer_thumb->height = '100';                                   	    
		    $offer_price = get_post_meta( $linkpost->ID, 'rehub_aff_price', true );
		    $offer_price_old = get_post_meta( $linkpost->ID, 'rehub_aff_price_old', true );
			$offer_desc = get_post_meta( $linkpost->ID, 'rehub_aff_desc', true );
		    $offer_url = get_post_permalink($atts['offer_linkid']);
		    $offer_title = $linkpost->post_title;
		    $offer_btn_text = get_post_meta( $linkpost->ID, 'rehub_aff_btn_text', true );
		    $offer_coupon = get_post_meta( $linkpost->ID, 'rehub_aff_coupon', true );
		    $offer_coupon_date = get_post_meta( $linkpost->ID, 'rehub_aff_coupon_date', true );
		    $offer_coupon_mask = get_post_meta( $linkpost->ID, 'rehub_aff_coupon_mask', true );
		    $rehub_aff_review_related = get_post_meta( $linkpost->ID, "rehub_aff_rel", true );

		    if (!empty($offer_thumb) ) :	
				$out .= '<div class="offer_thumb"><img src="'.$show_offer_thumb->get_resized_url().'" alt="" /></div>'; 
		    endif; 
		    $out .= '<div class="desc_col"><div class="offer_title">'.$offer_title.'</div>';
		    $out.= '<p>'.$offer_desc.'</p>';
		    if ( !empty($rehub_aff_review_related)) :
                $out .= '<a href="'.$rehub_aff_review_related.'" target="_blank" class="color_link">'.__("Read review", "rehub_framework").'</a>';    
            endif;
		    $out.= '</div>';

			if ( !empty($offer_price) || !empty($term_list[0])) :
				$out .='<div class="price_col">'; 
				if (!empty($offer_price)) :
					$out .='<p><span class="price_count"><ins>'.$offer_price.'</ins>';
					if($offer_price_old !='') :
						$out .=' <del>'.$offer_price_old.'</del>';
					endif ;
					$out .='</span></p>';						
				endif ;	
					$out .='<div class="aff_tag">'; 			        			        	
			        if (!empty($term_brand_image['brand_image'])) :
				        $show_offer_brand = new WPSM_image_resizer();
				        $show_offer_brand->src = $term_brand_image['brand_image']; 
				        $show_offer_brand->width = '50';		        	
			            $out .='<img src="'.$show_offer_brand->get_resized_url().'" alt="'.$linkpost->post_title.'" />';  
			        elseif (!empty($term_list[0])) : 
			            $out .=''.$term_list[0].'';
			        endif;         
		            $out .='</div>';
		        $out .='</div>';
	        endif;

	        $out .='<div class="buttons_col"><div class="priced_block">';
			if(!empty($offer_coupon_date)) :
				$timestamp1 = strtotime($offer_coupon_date); 
				$seconds = $timestamp1 - (int)current_time('timestamp',0); 
				$days = floor($seconds / 86400);
				$seconds %= 86400;
        		if ($days > 0) {
        			$coupon_text = $days.' '.__('days left', 'rehub_framework');
        			$coupon_style = '';
        		}
        		elseif ($days == 0){
        			$coupon_text = __('Last day', 'rehub_framework');
        			$coupon_style = '';
        		}
        		else {
        			$coupon_text = __('Expired', 'rehub_framework');
        			$coupon_style = 'expired_coupon';
        		}									
			endif;
			$out .='<div><a class="re_track_btn btn_offer_block" href="'.get_post_permalink($linkpost).'" target="_blank" rel="nofollow">';	
			if($offer_btn_text !='') :
				$out .=''.$offer_btn_text.'';
			elseif(rehub_option('rehub_btn_text') !='') :
				$out .=''.rehub_option("rehub_btn_text").''; 
			else :
				$out .=''.__("Buy this item", "rehub_framework").''; 
			endif ;
			$out .='</a></div>';
			
			if(!empty($offer_coupon)) :
				wp_enqueue_script('zeroclipboard');
				if ($offer_coupon_mask !='1') :
					$out .='<div class="rehub_offer_coupon not_masked_coupon';
					if(!empty($offer_coupon_date)):
						$out .=' '.$coupon_style.'';
					endif;
					$out .='" data-clipboard-text="'.$offer_coupon.'"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text">'.$offer_coupon.'</span></div>';										
				else:
					$out .='<div class="rehub_offer_coupon masked_coupon';
					if(!empty($offer_coupon_date)):
						$out .=' '.$coupon_style.'';
					endif;
					$out .='" data-clipboard-text="'.$offer_coupon.'" data-codeid="'.$linkpost->ID.'" data-dest="'.get_post_permalink($linkpost).'">';
					if(rehub_option('rehub_mask_text') !='') :
						$out .=''.rehub_option("rehub_mask_text").'';
					else:
						$out .=''.__("Reveal coupon", "rehub_framework").'<i class="fa fa-external-link-square"></i>';
					endif;	
					$out .='</div>';
				endif;				
				if(!empty($offer_coupon_date)):
				 $out .='<div class="time_offer">'.$coupon_text.'</div>';
				endif;						
			endif ;									
				
			$out .='</div></div>';	
		
		endif;
	
	else :	
		if(isset($atts['image_id']) && $atts['image_id']):
			$offer_thumb = wp_get_attachment_url($atts['image_id']);
			$show_offer_thumb = new WPSM_image_resizer();
	        $show_offer_thumb->src = $offer_thumb; 
	        $show_offer_thumb->width = '120';
            $show_offer_thumb->height = '120';
            $checklink = (isset($atts['button_link'])) ? esc_url($atts['button_link']) : '';
			$out .= '<div class="offer_thumb"><a href="'.$checklink.'" target="_blank" rel="nofollow"><img src="'.$show_offer_thumb->get_resized_url().'" alt="" /></a></div>';
		elseif(isset($atts['thumb']) && $atts['thumb']):
			$offer_thumb = $atts['thumb'];
			$show_offer_thumb = new WPSM_image_resizer();
	        $show_offer_thumb->src = $offer_thumb; 
	        $show_offer_thumb->width = '120';
            $show_offer_thumb->height = '120';
			$out .= '<div class="offer_thumb"><img src="'.$show_offer_thumb->get_resized_url().'" alt="" /></div>';           		
		endif;	
		$out .= '<div class="desc_col">';
		if(isset($atts['title']) && $atts['title']):
			$out .= '<div class="offer_title">'.$atts['title'].'</div>';
		endif;

		if(isset($atts['description']) && $atts['description']):
			$out.= '<p>'.$atts['description'].'</p>';
		endif;
		$out .= '</div>';

		$out .= '<div class="price_col">';
			if(isset($atts['price']) && $atts['price']):
		    	$out .= '<p><span class="price_count"><ins>'.$atts['price'].'</ins> ';
		    	if(isset($atts['price_old']) && $atts['price_old']):
		    		$out .= '<del>'.$atts['price_old'].'</del>';
		    	endif;
		    	$out .= '</span></p>';
			endif;
			if(isset($atts['logo_image_id']) && $atts['logo_image_id']):
				$logo_thumb = wp_get_attachment_url($atts['logo_image_id']);
				$show_logo_thumb = new WPSM_image_resizer();
	        	$show_logo_thumb->src = $logo_thumb; 
	        	$show_logo_thumb->width = '50';
				$out .= '<div class="brand_logo_small"><img src="'.$show_logo_thumb->get_resized_url().'" alt="" /></div>';
			elseif(isset($atts['logo_thumb']) && $atts['logo_thumb']):
				$logo_thumb = $atts['logo_thumb'];
				$show_logo_thumb = new WPSM_image_resizer();
	        	$show_logo_thumb->src = $logo_thumb; 
	        	$show_logo_thumb->width = '50';
				$out .= '<div class="brand_logo_small"><img src="'.$show_logo_thumb->get_resized_url().'" alt="" /></div>';         		
			endif;			
		$out .= '</div>';	
	
		$out .= '<div class="buttons_col"><div class="priced_block clearfix">';
			
			if(isset($atts['button_link']) && $atts['button_link']):
			    $out .= '<div><a href="'.esc_url($atts['button_link']).'" class="re_track_btn btn_offer_block" target="_blank" rel="nofollow">'.$button_text.'</a></div>';
			endif;

			if(!empty($atts['offer_coupon'])) :
				wp_enqueue_script('zeroclipboard');
				if (empty($atts['offer_coupon_mask'])) :
                    $out .= '<div class="rehub_offer_coupon not_masked_coupon ';
                		if(!empty($atts['offer_coupon_date'])) :
                			$out .= $coupon_style;
                		endif;
                	$out .= '" data-clipboard-text="'.$atts['offer_coupon'].'"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text">'.$atts['offer_coupon'].'</span></div>';
                else :
                	wp_enqueue_script('affegg_coupons');
                    $out .= '<div class="rehub_offer_coupon free_coupon_width masked_coupon ';
                		if(!empty($atts['offer_coupon_date'])) :
                			$out .= $coupon_style;
                		endif;
               		$out .= '" data-clipboard-text="'.rawurlencode(esc_html($atts['offer_coupon'])).'" data-codetext="'.rawurlencode(esc_html($atts['offer_coupon'])).'" data-dest="'.esc_url($atts['button_link']).'">'.$offer_coupon_mask_text.'<i class="fa fa-external-link-square"></i></div>';
				endif;	
			endif;
            if(!empty($atts['offer_coupon_date'])) :
            	$out .='<div class="time_offer">'.$coupon_text.'</div>';
            endif;					
		$out .= '</div></div>';

	endif;

	$out .= '</div></div><div class="clearfix"></div>';
    return $out;
}
add_shortcode('wpsm_offerbox', 'wpsm_offerbox_shortcode');
}


//////////////////////////////////////////////////////////////////
// VIDEO PLAYLIST
//////////////////////////////////////////////////////////////////
if( !function_exists('video_mod_function') ) {
function video_mod_function( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'videolinks' => '',
	'playlist_auto_play' => '0',
	'playlist_host' => 'youtube',
	'playlist_width' => 'full',
	'playlist_type' => 'playlist'
), $atts, 'video_mod'); 
extract($build_args); 
$rand_id = uniqid().time(); 
require_once( get_template_directory() . '/functions/remote_http.php' );     

ob_start(); 
?>

<?php if ($videolinks) :?>

	<?php if ($playlist_type == 'slider') :?>
		<?php $idshosts = WPSM_video_class::parse_videoid_from_urls($videolinks, 'arrayhost') ;?>	

		<?php  wp_enqueue_script('flexslider'); ?>
		<div class="gallery_video_wrap">
			<div class="post_slider media_slider gallery_top_slider loading"> 
			<ul class="slides">     <script src="//a.vimeocdn.com/js/froogaloop2.min.js"></script>
			<?php if (!empty ($idshosts['youtube']) && $playlist_host == 'youtube') :?>
				<?php $videoarraytube = WPSM_video_class::get_video_data($idshosts['youtube'], 'youtube'); ?>
				<?php foreach ($videoarraytube as $video_id=>$video_data):?>
					<li data-thumb="<?php echo $video_data['thumb'] ?>" class="play3">
					    <?php echo WPSM_video_class::embed_video_from_id($video_id, 'youtube');?>
					</li>
				<?php endforeach;?>
			<?php elseif (!empty ($idshosts['vimeo']) && $playlist_host == 'vimeo') :?>
				<?php $videoarrayvimeo = WPSM_video_class::get_video_data($idshosts['vimeo'], 'vimeo'); ?>
				<?php foreach ($videoarrayvimeo as $video_id=>$video_data):?>
					<li data-thumb="<?php echo $video_data['thumb'] ?>" class="play3">
					    <?php echo WPSM_video_class::embed_video_from_id($video_id, 'vimeo');?>
					</li>
				<?php endforeach;?>
			<?php endif;?>
			</ul>
			</div>
		</div>			

	<?php else :?>

		<?php $idshosts = WPSM_video_class::parse_videoid_from_urls($videolinks, 'arrayhost') ;?>
		<?php if (!empty ($idshosts['youtube']) && $playlist_host == 'youtube') :?>
			<?php echo WPSM_video_class::render_playlist( $atts, 'youtube' ); ?>
		<?php elseif (!empty ($idshosts['vimeo']) && $playlist_host == 'vimeo') :?>
			<?php echo WPSM_video_class::render_playlist( $atts, 'vimeo' ); ?>
		<?php endif;?>

	<?php endif; ?>

<?php endif; ?>


<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('video_mod', 'video_mod_function');
}


//////////////////////////////////////////////////////////////////
// FEATURED AREA
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_featured_function') ) {
function wpsm_featured_function( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'data_source' => 'cat', //Filters start
	'cat' => '',
	'tag' => '',
	'cat_exclude' => '',
	'tag_exclude' => '',	
	'ids' => '',	
	'orderby' => '',
	'order' => 'DESC',	
	'meta_key' => '',
	'show' => 5,
	'offset' => '',
	'show_date' => '',	
	'post_type' => '',
	'tax_name' => '',
	'tax_slug' => '',
	'tax_slug_exclude' => '',
	'post_formats' => '',
	'badge_label'=> '1',	
	'enable_pagination' => '',	
	'show_coupons_only' =>'', //Filters end
	'feat_type'=>'1',
	'dis_excerpt' =>'',
	'bottom_style' =>'',
	'custom_height'=>'',
), $atts, 'wpsm_featured'); 
extract($build_args); 
$rand_id = 'feat_area'.uniqid();            
ob_start(); 
?>
<?php if( !is_paged()) : ?>
<?php if ($feat_type=='1' || $feat_type == '2') {wp_enqueue_script('flexslider');} ;?>
<?php
	global $wp_query; 
	$argsfilter = new WPSM_Postfilters($build_args);
	$args = $argsfilter->extract_filters();
	$args['ignore_sticky_posts'] = 1;
	$argsleft = $args;
	if ($feat_type=='1' && !empty($ids)) {
		$idscount = array_map( 'trim', explode( ",", $ids ) );
		$idscount = count($idscount);
		$argsleft['showposts'] = $idscount - 2;
	}
	$wp_query = new WP_Query($argsleft);
?>
<div class="wpsm_featured_wrap wpsm_featured_<?php echo $feat_type?>">
<?php if ($feat_type=='1') : //First type - featured slider + 2 posts ?>
	
	<div class="flexslider main_slider loading<?php if ($bottom_style =='1') :?> bottom_style_slider<?php endif ?>">
		<i class="fa fa-spinner fa-pulse"></i>
		<ul class="slides">	
		<?php if($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post(); global $post; ?>
		<?php 
	  		$image_id = get_post_thumbnail_id(get_the_ID());  
	  		$image_url = wp_get_attachment_image_src($image_id,'post-thumbnail');
			$image_url = $image_url[0];
			if (function_exists('_nelioefi_url')){
				$image_nelio_url = get_post_meta( $post->ID, _nelioefi_url(), true );
				if (!empty($image_nelio_url)){
					$image_url = esc_url($image_nelio_url);
				}			
			}			
			$showbigimg = new WPSM_image_resizer();
			$showbigimg->src = $image_url;
			$imagebig_url = $showbigimg->get_resized_url();
		?>	
			<li class="slide" style="background-image: url('<?php echo $imagebig_url ;?>');"> 
				<span class="pattern"></span>
				<a href="<?php the_permalink();?>" class="feat_overlay_link"></a> 
		  		<div class="flex-overlay">
		    		<div class="post-meta">   				
			            <?php 	
			            if ('post' == get_post_type($post->ID) && rehub_option('exclude_cat_meta') != 1) {
			                $category = get_the_category();
							$category_id = $category[0]->term_id;
							$category_link = get_category_link($category_id);
							$category_name = get_cat_name($category_id);
							$category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>';                  	
			            	echo $category_echo;
			            }
			            ?>       				
		    		</div>
		    		<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
		    		<?php if ($dis_excerpt !='1') :?><div class="hero-description"><p><?php kama_excerpt('maxchar=150'); ?></p></div><?php endif ;?>
		    		<?php if(rehub_option('disable_btn_offer_loop')!='1')  : ?><?php rehub_create_btn('yes') ;?><?php endif; ?>	            		
		    	</div>
		    	<?php if (rehub_option('exclude_comments_meta') == 0) : ?><?php comments_popup_link( 0, 1, '%', 'comment', ''); ?><?php endif ;?> 
			</li>
		<?php endwhile; endif; ?>
		<?php  wp_reset_query(); ?>
		</ul>
	</div>
    <?php $args['showposts'] = 2; 
    if ($ids){
    	$args['offset'] = count($idscount) - 2; 
    }
    else {
    	$args['offset'] = $show; 
    }
    $i = 0; 
    $nextnews = new WP_Query($args); 
        if( $nextnews->have_posts() ) : echo '<div class="side-twocol scroll-on-mobile">';
        while($nextnews->have_posts()) : $nextnews->the_post(); 
    ?>
    <div class="columns<?php if (($i) == '0') :?> col-1<?php endif ?>">
		<div class="col-item news_in_thumb">
			<figure>	
				<?php if (rehub_option('exclude_comments_meta') == 0) : ?><?php comments_popup_link( 0, 1, '%', 'comment', ''); ?><?php endif ;?>			
	            <?php $category_echo = '';	
	            if ('post' == get_post_type($wp_query->ID) && rehub_option('exclude_cat_meta') != 1) {
	                $category = get_the_category();
					$category_id = $category[0]->term_id;
					$category_link = get_category_link($category_id);
					$category_name = get_cat_name($category_id);
					$category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>'; 				               
	            }
	            ?>    			            	
			    <a href="<?php the_permalink();?>">
	                <?php wpsm_thumb('grid_news'); ?>		    
			    </a>
			    <div class="text_in_thumb">
			    	<?php echo $category_echo;  ?>
			    	<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>    	                          
			    </div>					
		    </figure>			    
	    </div>
  	</div>
  	<?php $i++; ?>
	<?php endwhile; echo '</div>'; endif; wp_reset_query(); ?>  
<?php elseif($feat_type =='2') : //Second type - featured full width slider?>
	<?php if($custom_height) :?>
    	<style scoped>
    		@media (min-width: 768px){
    			#<?php echo $rand_id;?> .main_slider.full_width_slider.flexslider .slides .slide{height: <?php echo (int)$custom_height;?>px; line-height: <?php echo (int)$custom_height;?>px;} 
    			#<?php echo $rand_id;?> .main_slider.full_width_slider.flexslider{height:<?php echo (int)$custom_height;?>px}
    		}        		
    	</style>
	<?php endif ;?>
	<div class="flexslider main_slider loading full_width_slider<?php if ($bottom_style =='1') :?> bottom_style_slider<?php endif ?>">
		<i class="fa fa-spinner fa-pulse"></i>
		<ul class="slides">	
		<?php if($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post(); global $post; ?>
		<?php 
	  		$image_id = get_post_thumbnail_id(get_the_ID());  
	  		$image_url = wp_get_attachment_image_src($image_id,'full');
			$image_url = $image_url[0];
			if (function_exists('_nelioefi_url')){
				$image_nelio_url = get_post_meta( $post->ID, _nelioefi_url(), true );
				if (!empty($image_nelio_url)){
					$image_url = esc_url($image_nelio_url);
				}			
			}			
			$showbigimg = new WPSM_image_resizer();
			$showbigimg->src = $image_url;
			$imagebig_url = $showbigimg->get_resized_url();
		?>	
			<li class="slide" style="background-image: url('<?php echo $imagebig_url ;?>');"> 
				<span class="pattern"></span>
				<a href="<?php the_permalink();?>" class="feat_overlay_link"></a>
		  		<div class="flex-overlay">
		    		<div class="post-meta">
		      			<div class="inner_meta">    				
				            <?php 	
				            if ('post' == get_post_type($post->ID) && rehub_option('exclude_cat_meta') != 1) {
				                $category = get_the_category();
								$category_id = $category[0]->term_id;
								$category_link = get_category_link($category_id);
								$category_name = get_cat_name($category_id);
								$category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>';                  	
				            	echo $category_echo;
				            }
				            ?>       				
		      			</div>
		    		</div>
		    		<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
		    		<?php if ($dis_excerpt !='1') :?><div class="hero-description"><p><?php kama_excerpt('maxchar=150'); ?></p></div><?php endif ;?>
		    		<?php if(rehub_option('disable_btn_offer_loop')!='1')  : ?><?php rehub_create_btn('yes') ;?><?php endif; ?>	            		
		    	</div>
		    	<?php if (rehub_option('exclude_comments_meta') == 0) : ?><?php comments_popup_link( 0, 1, '%', 'comment', ''); ?><?php endif ;?> 
			</li>
		<?php endwhile; endif; ?>
		<?php  wp_reset_query(); ?>
		</ul>
	</div>
<?php elseif($feat_type =='3') : //Third type - featured grid ?>
	<div class="featured_grid">	
		<?php $col_number = 0; if($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post(); global $post; $col_number ++; ?>
		<?php 
	  		$image_id = get_post_thumbnail_id(get_the_ID());  
	  		if ($col_number == 1) {
	  			$image_url = wp_get_attachment_image_src($image_id,'full');
	  		}
	  		else {
	  			$image_url = wp_get_attachment_image_src($image_id,'news_big');
	  		}	
			$image_url = $image_url[0];
			if (function_exists('_nelioefi_url')){
				$image_nelio_url = get_post_meta( $post->ID, _nelioefi_url(), true );
				if (!empty($image_nelio_url)){
					$image_url = esc_url($image_nelio_url);
				}			
			}			
			$showimg = new WPSM_image_resizer();
			$showimg->src = $image_url;
			$image_url = $showimg->get_resized_url();
		?>	<?php if ($col_number == 2) {echo '<div class="scroll-on-mobile col-feat-50">';}?>
			<div class="col-feat-grid item-<?php echo $col_number;?>" style="background-image: url('<?php echo $image_url ;?>');">
				<a href="<?php the_permalink();?>" class="feat_overlay_link"></a> 
		  		<div class="feat-grid-overlay text_in_thumb">
	      			<div class="inner_meta">    				
			            <?php 	
			            if ('post' == get_post_type($post->ID) && rehub_option('exclude_cat_meta') != 1) {
			                $category = get_the_category();
							$category_id = $category[0]->term_id;
							$category_link = get_category_link($category_id);
							$category_name = get_cat_name($category_id);
							$category_echo = '<span class="news_cat"><a href="'.esc_url( $category_link ).'">'.$category_name.'</a></span>';                  	
			            	echo $category_echo;
			            }
			            ?>       				
	      			</div>
		    		<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
		    		<?php if ($col_number == 1) {echo '<div class="post-meta">'; meta_small(true, false, true); echo'</div>';}?>	            		
		    	</div> 
			</div>
		<?php endwhile; echo '</div>'; endif; ?>
		<?php  wp_reset_query(); ?>
	</div>
<?php endif;?>
</div>
<?php endif;?>


<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('wpsm_featured', 'wpsm_featured_function');
add_shortcode('post_slider_mod', 'wpsm_featured_function');
}


//////////////////////////////////////////////////////////////////
// SEARCH BLOCK
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_searchbox_function') ) {
	function wpsm_searchbox_function( $atts, $content = null ) {
	$build_args =shortcode_atts(array(
		'by' => '',
		'placeholder' => 'Search',
		'color' => 'orange',
		'enable_ajax' => '',
		'tax' => '',
		'enable_compare' => '',
		'catid' => ''
	), $atts, 'wpsm_searchbox'); 
	extract( $build_args ); 
	ob_start(); 
	?>
	<div class="custom_search_box">
		<?php if ( $tax && $tax !='' ) { ?>
		<form role="search" id="rh-category-search">
			<span class="tt-clear-search hide js-clear-search"><i class="fa fa-times"></i></span>
			<input class="typeahead search-text-input" type="text" placeholder="<?php echo $placeholder?>" autocomplete="off">
			 <i class="fa fa-arrow-right inside-search"></i>
		</form> 
		<?php
		$tax_arr = array_map('trim', explode(",", $tax));
		$terms = get_terms(array(
			'taxonomy'=> $tax_arr,
			'hide_empty' => true,
		) );

		if ( is_wp_error( $terms ) ) {
			return;
		}
			
		foreach ( $terms as $term ) {
			$parsed_url = parse_url( get_term_link( $term ) );
			$term_path = isset($parsed_url['path']) ? $parsed_url['path'] : ''; 
			$term_arr = array( 
				'html_name' => $term_path,
				'long_name' => $term->name,
				'key_word' => $term->description
			);
			$cat_arr[] = $term_arr;
		}

			$cat_json = json_encode( $cat_arr );
			wp_enqueue_script( 'typehead' );
			
			if ( function_exists( 'wp_add_inline_script' ) )
				wp_add_inline_script( 'typehead', 'var typeahead_categories =' . $cat_json . ';' );	
		?>

		<?php } else { ?>
			<form  role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
			  <input type="text" name="s" placeholder="<?php echo $placeholder?>" <?php if ($enable_ajax == '1') {echo 'class="re-ajax-search" autocomplete="off"';} ?> data-posttype="<?php echo $by;?>" data-enable_compare="<?php echo $enable_compare;?>" data-catid="<?php echo $catid;?>">
			  <input type="hidden" name="post_type" value="<?php echo $by?>" />
			  <input type="hidden" name="enable_compare" value="<?php echo $enable_compare	?>" />
			  <input type="hidden" name="catid" value="<?php echo $catid	?>" />
			  <i class="fa fa-arrow-right inside-search"></i>
			  <button type="submit" class="wpsm-button <?php echo $color?>"><i class="fa fa-search"></i></button>
			</form>
			<?php if ($enable_ajax == '1') { echo '<div class="re-aj-search-wrap"></div>'; } ?>
		<?php } ?>
	</div>
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
	}
	
	add_shortcode('wpsm_searchbox', 'wpsm_searchbox_function');
}


//////////////////////////////////////////////////////////////////
// THIRSTYAFFILIATES OFFERLIST **********DEPRECATED, BUT STILL WORKS
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_afflist_function') ) {
function wpsm_afflist_function( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'enable_pagination' => '',
	'no_cloaking' => '',
	'cat' => '',
	'ids' => '',
	'orderby' => '',
	'order' =>'DESC',
	'meta_key' =>'',
	'show' => 10,	
), $atts, 'wpsm_offerlist'); 
extract($build_args); 
ob_start(); 
?>
<?php
	global $wp_query;
    if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }
    if ($ids !='') {
        $ids = array_map( 'trim', explode( ",", $ids ) );
        $args = array(
            'post_type' => 'thirstylink',
            'post__in' => $ids,
            'numberposts' => '-1',
            'orderby' => 'post__in',            
        );
    }
    else {
        $args = array(
            'post_type' => 'thirstylink',
            'posts_per_page'   => $show, 
            'orderby' => $orderby,
            'order' => $order,
            'ignore_sticky_posts' => 1,                  
        );
        if ($enable_pagination != '') {$args['paged'] = $paged;}
        if (($orderby == 'meta_value' || $orderby == 'meta_value_num') && $meta_key !='') {$args['meta_key'] = $meta_key;}
        if ($cat !='') {
        	$cat_id = get_term_by('slug', $cat, 'thirstylink-category');
        	if (empty($cat_id)) {
        		$cat = array_map( 'trim', explode( ",", $cat ) );
        	}
        	else {
        		$cat = array();
        		$cat[] = (int) $cat_id->term_id;
        	}       	
            $args['tax_query'] = array(array('taxonomy' => 'thirstylink-category', 'terms' => $cat, 'field' => 'term_id'));             
        }
    }    
	$wp_query = new WP_Query($args);
?>
<?php $i=1; if($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post(); ?>
<?php $linkData = unserialize(get_post_meta(get_the_ID(), 'thirstyData', true)); 
$link = ($no_cloaking !='') ? $linkData['linkurl'] : get_the_permalink() ;
?>
<?php   $attachments = get_posts( array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'posts_per_page' => -1,
    'post_parent' => get_the_ID(),
) );
if (!empty($attachments)) {$aff_thumb_list = wp_get_attachment_url( $attachments[0]->ID );} else {$aff_thumb_list ='';}
$term_list = wp_get_post_terms(get_the_ID(), 'thirstylink-category', array("fields" => "names")); 
if(is_wp_error($term_list)){return;}
$term_ids =  wp_get_post_terms(get_the_ID(), 'thirstylink-category', array("fields" => "ids")); 
if(is_wp_error($term_ids)){return;}
if (!empty($term_ids) && !is_wp_error($term_ids)) {$term_brand = $term_ids[0]; $term_brand_image = get_option("taxonomy_term_$term_ids[0]");} else {$term_brand_image ='';}
?>
<div class="rehub_feat_block table_view_block">
    <?php if (get_post_meta( get_the_ID(), 'rehub_aff_sticky', true) == '1') :?><div class="vip_corner"><span class="vip_badge"><i class="fa fa-thumbs-o-up"></i></span></div><?php endif ?> 
    <div class="block_with_coupon">
        <div class="offer_thumb">
        <a href="<?php echo $link; ?>" rel="nofollow" target="_blank">
			<?php $show_offer_thumb = new WPSM_image_resizer(); 
	        $show_offer_thumb->width = '120';
            $show_offer_thumb->height = '120';			
			if (!empty($aff_thumb_list) ) :	
				$show_offer_thumb->src = $aff_thumb_list;		    			
    		elseif (!empty($term_brand_image['brand_image'])) :
    			$show_offer_thumb->src = $term_brand_image['brand_image'];	  			
    		endif; ?>          
			<?php $show_offer_thumb->show_resized_image() ?>
        </a>    
        </div>
        <div class="desc_col">
            <div class="offer_title"><a href="<?php echo $link; ?>" rel="nofollow" target="_blank"><?php the_title(); ?></a></div>
            <p><?php echo get_post_meta( get_the_ID(), 'rehub_aff_desc', true );?></p>
            <?php $rehub_aff_review_related = get_post_meta( get_the_ID(), "rehub_aff_rel", true ); if ( !empty($rehub_aff_review_related)) : ?>
                <a href="<?php echo $rehub_aff_review_related; ?>" target="_blank" class="color_link"><?php _e("Read review", "rehub_framework") ;?></a>    
            <?php endif; ?>
        </div>
        <?php 
        $product_price = get_post_meta( get_the_ID(), 'rehub_aff_price', true ); 
        $offer_price_old = get_post_meta( get_the_ID(), 'rehub_aff_price_old', true );
        if ( !empty($product_price) || !empty($term_list[0])) :?>
            <div class="price_col">
                <p><span class="price_count"><ins><?php echo $product_price ;?></ins><?php if($offer_price_old !='') :?> <del><?php echo $offer_price_old ; ?></del><?php endif ;?></span></p>                         
                <div class="aff_tag">
                    <?php if (!empty($term_brand_image['brand_image'])) :?>                      
                        <?php 
                        	$show_offer_brand = new WPSM_image_resizer();
				        	$show_offer_brand->src = $term_brand_image['brand_image']; 
				        	$show_offer_brand->width = '50';
				        	$show_offer_brand->show_resized_image();
				        ?>
                    <?php elseif (!empty($term_list[0])) :?> 
                        <?php echo $term_list[0]; ?>
                    <?php endif; ?> 
                </div>
            </div>
        <?php endif ;?>                     
        <div class="buttons_col">
            <div class="priced_block">
            <?php $offer_btn_text = get_post_meta( get_the_ID(), 'rehub_aff_btn_text', true ) ?>
            <?php $offer_coupon = get_post_meta( get_the_ID(), 'rehub_aff_coupon', true ) ?>
            <?php $offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_aff_coupon_date', true ) ?>
            <?php $offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_aff_coupon_mask', true ) ?>
            <?php if(!empty($offer_coupon_date)) : ?>
                <?php 
                    $timestamp1 = strtotime($offer_coupon_date); 
                    $seconds = $timestamp1 - (int)current_time('timestamp',0); 
                    $days = floor($seconds / 86400);
                    $seconds %= 86400;
                    if ($days > 0) {
                        $coupon_text = $days.' '.__('days left', 'rehub_framework');
                        $coupon_style = '';
                    }
                    elseif ($days == 0){
                        $coupon_text = __('Last day', 'rehub_framework');
                        $coupon_style = '';
                    }
                    else {
                        $coupon_text = __('Expired', 'rehub_framework');
                        $coupon_style = 'expired_coupon';
                    }                                   
                ?>
            <?php endif ;?> 
                <div><a class="re_track_btn btn_offer_block" href="<?php echo $link; ?>" rel="nofollow" target="_blank"><?php if($offer_btn_text !='') :?><?php echo $offer_btn_text ; ?><?php elseif(rehub_option('rehub_btn_text') !='') :?><?php echo rehub_option('rehub_btn_text') ; ?><?php else :?><?php _e('Buy this item', 'rehub_framework') ?><?php endif ;?></a></div>
                <?php if(!empty($offer_coupon)) : ?> 
                    <?php wp_enqueue_script('zeroclipboard'); ?>
                    <div>
                        <?php if ($offer_coupon_mask !='1') :?>
                            <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>   
                        <?php else :?>
                            <div class="rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo get_the_ID()?>" data-dest="<?php echo $link; ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?><i class="fa fa-external-link-square"></i></div>   
                        <?php endif;?>                                   
                        <?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>
                    </div>
                <?php endif ;?>
            </div>
        </div>
    </div>
</div>
                                          
<?php $i++; endwhile; ?>
<?php else : ?>		
<div class="heading"><h5><?php _e('Sorry. No posts in this category yet', 'rehub_framework'); ?></h5></div>				   
<?php endif; ?>

<?php if ($enable_pagination != '') :?>
    <?php rehub_pagination();?>
<?php endif ;?>
<?php wp_reset_query(); ?>


<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('wpsm_offerlist', 'wpsm_afflist_function');
add_shortcode('wpsm_afflist', 'wpsm_afflist_function');
}

//////////////////////////////////////////////////////////////////
// THIRSTYAFFILIATES OFFERGRID **********DEPRECATED, BUT STILL WORKS
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_affgrid_function') ) {
function wpsm_affgrid_function( $atts, $content = null ) {
$build_args =shortcode_atts(array(
	'enable_pagination' => '',
	'no_cloaking' => '',
	'cat' => '',
	'ids' => '',
	'orderby' => '',
	'order' =>'DESC',
	'meta_key' =>'',
	'show' => 10,	
	'data_source' => '',
	'columns' => '3_col'
), $atts, 'wpsm_affgrid'); 
extract($build_args); 
ob_start(); 
?>

<?php
	global $wp_query;
    if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }
    if ($data_source == 'ids' && $ids !='') {
        $ids = explode(',', $ids);
        $args = array(
            'post_type' => 'thirstylink',
            'post__in' => $ids,
            'numberposts' => '-1',
            'orderby' => 'post__in',            
        );
    }
    else {
        $args = array(
            'post_type' => 'thirstylink',
            'posts_per_page'   => $show, 
            'orderby' => $orderby,
            'order' => $order,
            'ignore_sticky_posts' => 1,                  
        );
        if ($enable_pagination != '') {$args['paged'] = $paged;}
        if (($orderby == 'meta_value' || $orderby == 'meta_value_num') && $meta_key !='') {$args['meta_key'] = $meta_key;}
        if ($data_source == 'cat' && $cat !='') {
            $cat = explode(',', $cat);
            $args['tax_query'] = array(array('taxonomy' => 'thirstylink-category', 'terms' => $cat, 'field' => 'term_id'));            
        }
    }    
	$wp_query = new WP_Query($args);
?>
<?php if ($columns == '3_col') :?>
<div class="rh-flex-eq-height col_wrap_three">
<?php elseif ($columns == '4_col') :?>
<div class="rh-flex-eq-height col_wrap_fourth">   	
<?php endif ;?>
<?php $i=1; if($wp_query->have_posts()): while($wp_query->have_posts()): $wp_query->the_post(); ?>
<?php $linkData = unserialize(get_post_meta(get_the_ID(), 'thirstyData', true)); 
$link = ($no_cloaking !='') ? $linkData['linkurl'] : get_the_permalink() ;
?>
<?php $attachments = get_posts( array(
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'posts_per_page' => -1,
    'post_parent' => get_the_ID(),
) );
if (!empty($attachments)) {$aff_thumb_list = wp_get_attachment_url( $attachments[0]->ID );} else {$aff_thumb_list ='';}
$term_list = wp_get_post_terms(get_the_ID(), 'thirstylink-category', array("fields" => "names")); 
if(is_wp_error($term_list)){return;}
$term_ids =  wp_get_post_terms(get_the_ID(), 'thirstylink-category', array("fields" => "ids")); 
if(is_wp_error($term_ids)){return;}
if (!empty($term_ids)) {$term_brand = $term_ids[0]; $term_brand_image = get_option("taxonomy_term_$term_ids[0]");} else {$term_brand_image ='';}
?>                           

<?php if ($columns == '3_col') :?>
<div class="offer_grid column_grid col_item">
<?php elseif ($columns == '4_col') :?>
<div class="offer_grid col_4_grid column_grid col_item">   	
<?php endif ;?>
	<?php if (get_post_meta( get_the_ID(), 'rehub_aff_sticky', true) == '1') :?><span class="vip_badge"><i class="fa fa-thumbs-o-up"></i></span><?php endif ?>        
        <div class="aff_grid_top">
            <div class="aff_tag">
                <?php if (!empty($term_brand_image['brand_image'])) :?>                      
                    <?php 
                    	$show_offer_brand = new WPSM_image_resizer();
			        	$show_offer_brand->src = $term_brand_image['brand_image']; 
			        	$show_offer_brand->width = '50';
			        	$show_offer_brand->show_resized_image();
			        ?>
                <?php elseif (!empty($term_list[0])) :?> 
                    <?php echo $term_list[0]; ?>
                <?php endif; ?>          
            </div>
        </div>

        <div class="offer_thumb">
        <a href="<?php echo $link ?>" rel="nofollow" target="_blank">

			<?php $show_offer_thumb = new WPSM_image_resizer(); 
	        $show_offer_thumb->width = '378';
            $show_offer_thumb->height = '310';			
			if (!empty($aff_thumb_list) ) :	
				$show_offer_thumb->src = $aff_thumb_list;		    			
    		elseif (!empty($term_brand_image['brand_image'])) :
    			$show_offer_thumb->src = $term_brand_image['brand_image'];	  			
    		endif; ?>          
			<?php $show_offer_thumb->show_resized_image() ?>

        </a>    
        </div>
        <div class="desc_col">
            <h4><a href="<?php echo $link ?>" rel="nofollow" target="_blank"><?php the_title(); ?></a></h4>
            <div class="r_offer_details">
            <?php 
            $rehub_aff_review_related = get_post_meta( get_the_ID(), "rehub_aff_rel", true ); 
            $rehub_aff_desc = get_post_meta( get_the_ID(), 'rehub_aff_desc', true ); 
            if (!empty($rehub_aff_review_related) || !empty($rehub_aff_desc)) :
            ?>
                <span class="r_show_hide"><?php _e('Details +', 'rehub_framework') ?></span>
                <div class="open_dls_onclk">
                    <?php echo get_post_meta( get_the_ID(), 'rehub_aff_desc', true );?>
                    <?php if ( !empty($rehub_aff_review_related)) : ?>
                        <br /><a href="<?php echo $rehub_aff_review_related; ?>" target="_blank" class="color_link"><?php _e("Read review", "rehub_framework") ;?></a>    
                    <?php endif; ?>
                </div>
            <?php endif ;?>    
            </div>
        </div>
        <?php 
        $product_price = get_post_meta( get_the_ID(), 'rehub_aff_price', true ); 
        $offer_price_old = get_post_meta( get_the_ID(), 'rehub_aff_price_old', true );
        if ( !empty($product_price)) :?>
            <div class="price_col">
                <p><span class="price_count"><ins><?php echo $product_price ;?></ins><?php if($offer_price_old !='') :?> <del><?php echo $offer_price_old ; ?></del><?php endif ;?></span></p>                        
            </div>
        <?php endif ;?>                     
        <div class="buttons_col">
            <div class="priced_block">
            <?php $offer_btn_text = get_post_meta( get_the_ID(), 'rehub_aff_btn_text', true ) ?>
            <?php $offer_coupon = get_post_meta( get_the_ID(), 'rehub_aff_coupon', true ) ?>
            <?php $offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_aff_coupon_date', true ) ?>
            <?php $offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_aff_coupon_mask', true ) ?>
            <?php if(!empty($offer_coupon_date)) : ?>
                <?php 
                    $timestamp1 = strtotime($offer_coupon_date); 
                    $seconds = $timestamp1 - (int)current_time('timestamp',0); 
                    $days = floor($seconds / 86400);
                    $seconds %= 86400;
                    if ($days > 0) {
                        $coupon_text = $days.' '.__('days left', 'rehub_framework');
                        $coupon_style = '';
                    }
                    elseif ($days == 0){
                        $coupon_text = __('Last day', 'rehub_framework');
                        $coupon_style = '';
                    }
                    else {
                        $coupon_text = __('Expired', 'rehub_framework');
                        $coupon_style = 'expired_coupon';
                    }                                   
                ?>
            <?php endif ;?>                            
                <div><a class="re_track_btn btn_offer_block" href="<?php echo $link ?>" rel="nofollow" target="_blank"><?php if($offer_btn_text !='') :?><?php echo $offer_btn_text ; ?><?php elseif(rehub_option('rehub_btn_text') !='') :?><?php echo rehub_option('rehub_btn_text') ; ?><?php else :?><?php _e('Buy this item', 'rehub_framework') ?><?php endif ;?></a></div>
            </div>
        </div>
        <?php if(!empty($offer_coupon)) : ?> 
            <?php wp_enqueue_script('zeroclipboard'); ?>
            <div class="aff_grid_bottom">
                <?php if ($offer_coupon_mask !='1') :?>
                    <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>   
                <?php else :?>
                    <div class="rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo get_the_ID()?>" data-dest="<?php echo $link ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?><i class="fa fa-external-link-square"></i></div>   
                <?php endif;?>                                   
                <?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>
            </div>
        <?php endif ;?> 
</div>
                                    
<?php $i++; endwhile; ?>
<?php else : ?>		
<div class="wpsm-title middle-size-title wpsm-cat-title"><h5><?php _e('Sorry. No posts in this category yet', 'rehub_framework'); ?></h5></div>				   
<?php endif; ?>
</div>

<?php if ($enable_pagination != '') :?>
    <?php rehub_pagination();?>
<?php endif ;?>
<?php wp_reset_query(); ?>


<?php 
$output = ob_get_contents();
ob_end_clean();
return $output;
}
add_shortcode('wpsm_affgrid', 'wpsm_affgrid_function');
}