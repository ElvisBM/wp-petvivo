<?php

require_once ( get_template_directory() . '/shortcodes/tinyMCE/tinyMCE.php'); 

//////////////////////////////////////////////////////////////////
// Buttons
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_button') ) {
function wpsm_shortcode_button( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'color' => 'orange',
				'size' => 'medium',
				'icon' => '',
				'link' => '',
				'target' => '',
				'border_radius' => '',
				'class' => '',
				'rel' => ''
			), $atts);
    $icon_show = (!empty($atts['icon'])) ? '<i class="fa fa-'.$atts['icon'].'"></i>' : ''; 
    $class_show = (!empty($atts['class'])) ? ' '.$atts['class'].'' : '';
    $border_show = (!empty($atts['border_radius'])) ? ' style="border-radius:'.$atts['border_radius'].'"' : '';
	$out = '<a href="'.esc_url($atts['link']).'"';
    if ($atts['target'] !='') :
    	$out .=' target="'.$atts['target'].'"';
    endif;
    if ($atts['rel'] !='') :
    	$out .=' rel="'.$atts['rel'].'"';
    endif;    
    $out .=''.$border_show.' class="wpsm-button '.$atts['color'].' '.$atts['size'].''.$class_show.'">'.$icon_show.'' .do_shortcode($content). '</a>';
    return $out;
}
add_shortcode('wpsm_button', 'wpsm_shortcode_button');
}

//////////////////////////////////////////////////////////////////
// Column
//////////////////////////////////////////////////////////////////

if( !function_exists('wpsm_column_shortcode') ) {
	function wpsm_column_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			'size' => 'one-half',
			'position' =>'first'
		  ), $atts ) );
		  $out = '';
		  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		  $content = do_shortcode($content);
		  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		  $Old     = array( '<br />', '<br>' );
		  $New     = array( '','' );
		  $content = str_replace( $Old, $New, $content );		  
		  $out .= '<div class="wpsm-' . $size . ' wpsm-column-'.$position.'">' . $content . '</div>';
		  if($position == 'last') {
			$out .= '<div class="clearfix"></div>';
		      }
		  return $out;	  
	}
	add_shortcode('wpsm_column', 'wpsm_column_shortcode');
}


//////////////////////////////////////////////////////////////////
// Highlight
//////////////////////////////////////////////////////////////////

if ( !function_exists( 'wpsm_highlight_shortcode' ) ) {
	function wpsm_highlight_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => 'yellow',
		  ),
		  $atts ) );
		  return '<span class="wpsm-highlight wpsm-highlight-'. $color .'">' . do_shortcode( $content ) . '</span>';
	
	}
	add_shortcode('wpsm_highlight', 'wpsm_highlight_shortcode');
}

//////////////////////////////////////////////////////////////////
// Color table
//////////////////////////////////////////////////////////////////
if ( !function_exists( 'wpsm_colortable_shortcode' ) ) {
	function wpsm_colortable_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'color' => 'black',
		  ),
		  $atts ) );
		  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		  $content = do_shortcode($content);
		  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		  $Old     = array( '<br />', '<br>' );
		  $New     = array( '','' );
		  $content = str_replace( $Old, $New, $content );		  
		  return '<div class="wpsm-table wpsm-table-'. $color .'">' . do_shortcode( $content ) . '</div>';
	
	}
	add_shortcode('wpsm_colortable', 'wpsm_colortable_shortcode');
}

//////////////////////////////////////////////////////////////////
// Quote
//////////////////////////////////////////////////////////////////	
if(!function_exists('wpsm_quote_shortcode')) {
	function wpsm_quote_shortcode($atts, $content) {   
		$out = '';
		$out .= '<blockquote class="wpsm-quote';
		if(!empty($atts['float']) && $atts['float']):
	      $out .= ' align'.$atts['float'].'';
	    endif;  
		$out .= '"';
		if(!empty($atts['width']) && $atts['width']):
	      $out .= 'style="width:'.$atts['width'].'"';
	    endif;
		$out .= '><p>'.$content.'</p>';
		if(!empty($atts['author']) && $atts['author']):
	      $out .= '<cite>'.$atts['author'].'</cite>';
	    endif;
		$out .='</blockquote>';
		return $out;
	} 
	// add the shortcode to system
	add_shortcode('wpsm_quote', 'wpsm_quote_shortcode');
}

//////////////////////////////////////////////////////////////////
// Dropcap
//////////////////////////////////////////////////////////////////	
if(!function_exists('wpsm_dropcap_shortcode')) {
function wpsm_dropcap_shortcode( $atts, $content = null ) { 
    return '<span class="wpsm_dropcap">'.$content.'</span>';  
}  
add_shortcode("wpsm_dropcap", "wpsm_dropcap_shortcode");  
}	

//////////////////////////////////////////////////////////////////
// Video
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_shortcode_AddVideo')) {
function wpsm_shortcode_AddVideo( $atts, $content = null ) {
	$schema = $width = $height = $title = $description = '';
    @extract($atts);
    if ($schema =='yes') {
		$width  = ($width)  ? $width  :'703' ;
		$height = ($height) ? $height : '395';
    }
    else {
 		$width  = ($width)  ? $width  :'765' ;
		$height = ($height) ? $height : '430';   	
    }
	$title = ($title) ? $title : get_the_title();
	$description = ($description) ? $description : get_the_title();

		if ($schema =='yes') {
			$out = '<div class="media_video clearfix" itemscope itemtype="http://schema.org/VideoObject"><meta content="'.$title.'" itemprop="name"><meta itemprop="thumbnail" content="'.parse_video_url($content, "hqthumb").'"><div class="clearfix inner"><div class="video-container">'.parse_video_url($content, "embed", "$width", "$height").'</div><h4 itemprop="name">'.$title.'</h4><p itemprop="description">'.$description.'</p></div></div>';
		}
		else {	
		$out ='<div class="video-container">'.parse_video_url($content, "embed", "$width", "$height").'</div>';
		}
		
    return $out;
}
add_shortcode('wpsm_video', 'wpsm_shortcode_AddVideo');
}

//////////////////////////////////////////////////////////////////
// Lightbox
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_shortcode_lightbox')) {
function wpsm_shortcode_lightbox( $atts, $content = null ) {
	wp_enqueue_script('prettyphoto');
	wp_enqueue_script('custom_pretty');
    @extract($atts);
	if(!isset($title)) {
		$title = '';
	}
	$out = '<a rel="prettyPhoto" href="'.$full.'" title="'.$title.'">' .do_shortcode($content). '</a>';
    return $out;
}
add_shortcode('wpsm_lightbox', 'wpsm_shortcode_lightbox');
}



//////////////////////////////////////////////////////////////////
// Boxes
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_shortcode_box')) {
function wpsm_shortcode_box( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'type' => 'info',
				'float' => 'none',
				'textalign' => 'left',
				'width' => 'auto',
			), $atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );

	$out = '<div class="wpsm_box '.$atts['type'].'_type '.$atts['float'].'float_box" style="text-align:'.$atts['textalign'].'; width:'.$atts['width'].'"><i></i><div>
			' .do_shortcode($content). '
			</div></div>';
    return $out;
}
add_shortcode('wpsm_box', 'wpsm_shortcode_box');
}


//////////////////////////////////////////////////////////////////
// Promoboxes
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_promobox_shortcode') ) {
function wpsm_promobox_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'background' => '#f8f8f8',
			'border_size' => '',
			'border_color' => '',
			'highligh_color' => '',
			'highlight_position' => '',
			'title' => '',
			'description' => ''
		), $atts));	

	$out = '<div class="wpsm_promobox" style="background-color:'.$background.' !important;';
	if((isset($atts['border_size']) && $atts['border_size']) && (isset($atts['border_color']) && $atts['border_color'])):
		$out .= ' border-width:'.$border_size.';border-color:'.$border_color.'!important; border-style:solid;';
	endif;
	if((isset($atts['highligh_color']) && $atts['highligh_color']) && (isset($atts['highlight_position']) && $atts['highlight_position'])):
		$out .= ' border-'.$highlight_position.'-width:3px !important;border-'.$highlight_position.'-color:'.$highligh_color.'!important;border-'.$highlight_position.'-style:solid';
	endif;
	$out .= '">';
	if((isset($atts['button_link']) && $atts['button_link']) && (isset($atts['button_text']) && $atts['button_text'])):
		$out .= '<a href="'.$atts['button_link'].'" class="wpsm-button rehub_main_btn" target="_blank" rel="nofollow"><span>'.$atts['button_text'].'</span></a>';
	endif;
	if(isset($atts['title']) && $atts['title']):
		$out .= '<div class="title_promobox">'.$atts['title'].'</div>';
	endif;
	if(isset($atts['description']) && $atts['description']):
		$out.= '<p>'.$atts['description'].'</p>';
	endif;
	$out .= '</div>';
    return $out;
}
add_shortcode('wpsm_promobox', 'wpsm_promobox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Number box
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_numbox_shortcode')) {
		function wpsm_numbox_shortcode($atts, $content) {  
			// get the optional style value
			extract(shortcode_atts( array('num' => '1', 'style' => '1'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );
			$styledot = ($style=='5' || $style=='6') ? '.' : '';			
			// return output
		    return "<div class=\"wpsm-numbox wpsm-style$style\"><span class=\"num\">" . $num . $styledot ."</span>" . $content . "</div>";  
		} 
		// add the shortcode to system
		add_shortcode('wpsm_numbox', 'wpsm_numbox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Numbered heading
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_numhead_shortcode')) {
		function wpsm_numhead_shortcode($atts, $content) {  
			// get the optional style value
			extract(shortcode_atts( array('num' => '1', 'style' => '1', 'heading' => '2'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );			
			// return output
		    return "<div class=\"wpsm-numhead wpsm-style$style\"><span>" . $num . "</span><h$heading>" . $content . "</h$heading></div>";  
		} 
		// add the shortcode to system
		add_shortcode('wpsm_numhead', 'wpsm_numhead_shortcode');
}

//////////////////////////////////////////////////////////////////
// Numbered circle
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_numcircle_shortcode')) {
	function wpsm_numcircle_shortcode($atts, $content) {  
		// get the optional style value
		extract(shortcode_atts( array('num' => '1', 'style' => '1'), $atts));	
		// return output
	    return "<span class=\"wpsm-numcircle wpsm-style$style\">" . $num . "</span>";  
	} 
	// add the shortcode to system
	add_shortcode('wpsm_numcircle', 'wpsm_numcircle_shortcode');
}

//////////////////////////////////////////////////////////////////
// Titled box
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_titlebox_shortcode')) {
		function wpsm_titlebox_shortcode($atts, $content) {   
			// get the optional style value
			extract(shortcode_atts( array('title' => 'Sample title', 'style' => '1'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );			
			// return the url
		    return '<div class="wpsm-titlebox wpsm_style_' . $style . '"><strong>' . $title . '</strong><div>'.$content.'</div></div>';  
		} 
		// add the shortcode to system
		add_shortcode('wpsm_titlebox', 'wpsm_titlebox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Code box
//////////////////////////////////////////////////////////////////

if(!function_exists('wpsm_code_shortcode')) {
		function wpsm_code_shortcode($atts, $content) {   
			// get the optional style value
			extract(shortcode_atts( array('style' => '1'), $atts));
			// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );			
			// return the element
		    return '<pre class="wpsm-code wpsm_code_' . $style . '"><code>'. trim($content) .'</code></pre>'; 
			 
		} 
		// add the shortcode to system
		add_shortcode('wpsm_codebox', 'wpsm_code_shortcode');
}

//////////////////////////////////////////////////////////////////
// Accordition
//////////////////////////////////////////////////////////////////

// Main
if( !function_exists('wpsm_accordion_main_shortcode') ) {
	function wpsm_accordion_main_shortcode( $atts, $content = null  ) {	
		// Enque scripts
		wp_enqueue_script('jquery-ui-accordion');	
        
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		// Display the accordion	
		return '<div class="wpsm-accordion">' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'wpsm_accordion', 'wpsm_accordion_main_shortcode' );
}

// Section
if( !function_exists('wpsm_accordion_section_shortcode') ) {
	function wpsm_accordion_section_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
		  'title' => 'Title',
		), $atts ) );
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		  
	   return '<h3 class="wpsm-accordion-trigger"><a href="#">'. $title .'</a></h3><div>' . do_shortcode($content) . '</div>';
	}
	add_shortcode( 'wpsm_accordion_section', 'wpsm_accordion_section_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Testimonial
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_testimonial_shortcode') ) { 
	function wpsm_testimonial_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'by' => '',
			'image' => '',
		  ), $atts ) );
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
				  
		$out = '';
		$out .= '<div class="wpsm-testimonial"><div class="wpsm-testimonial-content">';
		$out .= $content;
		$out .= '</div><div class="wpsm-testimonial-author">';
		if (isset($image) && !empty($image)) {
			$out .= '<img src="'. $image .'" alt="'. $by .'" class="author_image">';
		}
		$out .= $by .'</div></div>';	
		return $out;
	}
	add_shortcode( 'wpsm_testimonial', 'wpsm_testimonial_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Slider (DEPRECATED)
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_slider') ) {

	function wpsm_shortcode_slider($atts, $content = null) {
		wp_enqueue_script('flexslider');
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
				
		$str = '';
		$str .= '<div class="post_slider media_slider blog_slider loading">';
		$str .= do_shortcode($content);
		$str .= '</div>';

		return $str;
	}
	add_shortcode('wpsm_slider', 'wpsm_shortcode_slider');
}

//////////////////////////////////////////////////////////////////
// Slider
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_quick_slider') ) {
	function wpsm_shortcode_quick_slider($atts, $content = null) {
		extract(shortcode_atts(array(
				"ids" => '',
		), $atts));
		wp_enqueue_script('flexslider');
		return wpsm_get_post_slide($ids);
	}
	add_shortcode('wpsm_quick_slider', 'wpsm_shortcode_quick_slider');
}

//////////////////////////////////////////////////////////////////
// Post image attachment slider
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_post_slide') ) {
function wpsm_post_slide( $atts, $content = null ) {
		wp_enqueue_script('flexslider');
	return wpsm_get_post_slide();
}
add_shortcode('wpsm_post_images_slider', 'wpsm_post_slide');
function wpsm_get_post_slide($ids='') {
		$out = '';
		if (!empty($ids)) {
			$attachments = array_map( 'trim', explode( ",", $ids ) );
		}
		else {
			$attachments = get_posts( array(
            	'post_type' => 'attachment',
				'post_mime_type' => 'image',
            	'posts_per_page' => -1,
            	'post_parent' => get_the_ID(),
            	'exclude'     => get_post_thumbnail_id()
        	));
		}

        if ( $attachments ) {

            $out = '<div class="post_slider media_slider blog_slider loading"><ul class="slides">';
            foreach ( $attachments as $attachment ) {
            	if (!empty($ids)) {
            		$thumbimg = wp_get_attachment_image($attachment, 'post-thumbnail', false);
            	}
            	else {
            		$thumbimg = wp_get_attachment_image($attachment->ID, 'post-thumbnail', false);
            	}                      
                $out .= '<li>' . $thumbimg . '</li>';
            }
            $out .='</ul></div>';
            
        }
        return $out;
    }
}


//////////////////////////////////////////////////////////////////
// Map
//////////////////////////////////////////////////////////////////
if (! function_exists( 'wpsm_shortcode_googlemaps' ) ) :
	function wpsm_shortcode_googlemaps($atts, $content = null) {	
		extract(shortcode_atts(array(
				"title" => '',
				"location" => '',
				"height" => '300px',
				"zoom" => 10,
				"align" => '',
				"lat"=>'',
				"lng"=>''
		), $atts));
		
		// load scripts
		wp_enqueue_script('wpsm_googlemap');
		wp_enqueue_script('wpsm_googlemap_api');
		$output = '';
		
		if ($location){
			$output .= '<div id="map_canvas_'.uniqid().'" class="wpsm_googlemap wpsm_gmap_loc" style="height:'.$height.';width:100%">';
				$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
				$output .= '<input class="location" type="hidden" value="'.$location.'" />';
				$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
				$output .= '<div class="map_canvas"></div>';
			$output .= '</div>';			
		}		
		elseif ($lat && $lng){
			$output .= '<div id="map_canvas_'.uniqid().'" class="wpsm_googlemap wpsm_gmap_pos" style="height:'.$height.';width:100%">';
				//$output .= (!empty($title)) ? '<input class="title" type="hidden" value="'.$title.'" />' : '';
				$output .= '<input class="lat" type="hidden" value="'.$lat.'" />';
				$output .= '<input class="lng" type="hidden" value="'.$lng.'" />';				
				$output .= '<input class="zoom" type="hidden" value="'.$zoom.'" />';
				$output .= '<div class="map_canvas"></div>';
			$output .= '</div>';			
		}
		
		return $output;
	   
	}
	add_shortcode("wpsm_googlemap", "wpsm_shortcode_googlemaps");
endif;


//////////////////////////////////////////////////////////////////
// Dividers
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_divider_shortcode') ) {
	function wpsm_divider_shortcode( $atts ) {
		extract( shortcode_atts( array(
			'style' => 'solid',
			'top' => '20px',
			'bottom' => '20px',
		  ),
		  $atts ) );
		$style_attr = '';
		if ( $top && $bottom ) {  
			$style_attr = 'style="margin-top: '. $top .';margin-bottom: '. $bottom .';"';
		} elseif( $bottom ) {
			$style_attr = 'style="margin-bottom: '. $bottom .';"';
		} elseif ( $top ) {
			$style_attr = 'style="margin-top: '. $top .';"';
		} else {
			$style_attr = NULL;
		}
	 return '<hr class="wpsm-divider '. $style .'_divider" '.$style_attr.' />';
	}
	add_shortcode( 'wpsm_divider', 'wpsm_divider_shortcode' );
}


//////////////////////////////////////////////////////////////////
// Price Table shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_price_shortcode') ) {
	function wpsm_price_shortcode( $atts, $content = null  ) {
	  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	  $content = do_shortcode($content);
	  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	  $Old     = array( '<br />', '<br>' );
	  $New     = array( '','' );
	  $content = str_replace( $Old, $New, $content );		
	   return '<ul class="wpsm-price clearfix">' . $content . '</ul><br class="clear" />';
	}
	add_shortcode( 'wpsm_price_table', 'wpsm_price_shortcode' );
}
/* Column of price*/
if( !function_exists('wpsm_price_column_shortcode') ) {
	function wpsm_price_column_shortcode( $atts, $content = null  ) {
		extract( shortcode_atts( array(
			'size' => '3',
			'featured' => '',
			'name' => 'Sample Name',
			'price' => '',
			'per' => '',
			'button_url' => '',
			'button_text' => 'Buy Now',
			'button_color' => 'orange',
		), $atts ) );
		
	  // Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	  $content = do_shortcode($content);
	  $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	  $Old     = array( '<br />', '<br>' );
	  $New     = array( '','' );
	  $content = str_replace( $Old, $New, $content );		
		
		if($size == '2') $column_size = 'one-half';
		if($size == '3') $column_size = 'one-third';
		if($size =='4') $column_size = 'one-fourth';
		if($size =='5') $column_size = 'one-fifth';
	
		if($featured =='yes') $featured_price = 'wpsm-featured-price';
		else $featured_price = NULL;
			
		//fetch content  
		$out_price ='';
		$out_price .= '<li class="wpsm-price-column wpsm-'. $column_size .' '. $featured .' '. $featured_price .'">';
		$out_price .= '<div class="wpsm-price-header"><h4>'. $name. '</h4></div>';
		$out_price .= '<div class="wpsm-price-content"><div class="wpsm-price-cell"><span class="wpsm-price-value">'. $price .'</span>';
		if (!empty($per)) :
			$out_price .= ' /'.$per.'';
		endif;
		$out_price .='</div>';
		$out_price .= $content;
		if ($button_url){
			$out_price .= '<div class="wpsm-price-button"><a href="'. $button_url .'" class="wpsm-button '. $button_color .'"><span class="wpsm-button-inner">'. $button_text .'</span></a></div>';
		}
		$out_price .= '</div></li>';
		  
	   return $out_price;
	}
	add_shortcode( 'wpsm_price_column', 'wpsm_price_column_shortcode' );
}

//////////////////////////////////////////////////////////////////
// tab shortcode
//////////////////////////////////////////////////////////////////

if (!function_exists('wpsm_tabgroup_shortcode')) {
	function wpsm_tabgroup_shortcode( $atts, $content = null ) {
		
		//Enque scripts
		wp_enqueue_script('jquery-ui-tabs');
		
		// Display Tabs
		
		$defaults = array();
		extract( shortcode_atts( $defaults, $atts ) );
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		$tab_titles = array();
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
		$output = '';
		if( count($tab_titles) ){
		    $output .= '<div id="wpsm-tab-'. rand(1, 100) .'" class="wpsm-tabs">';
			$output .= '<ul class="ui-tabs-nav wpsm-clearfix">';
			foreach( $tab_titles as $tab ){
				$output .= '<li><a href="#wpsm-tab-'. sanitize_title( $tab[0] ) .'">' . $tab[0] . '</a></li>';
			}
		    $output .= '</ul>';
		    $output .= do_shortcode( $content );
		    $output .= '</div>';
		} else {
			$output .= do_shortcode( $content );
		}
		return $output;
	}
	add_shortcode( 'wpsm_tabgroup', 'wpsm_tabgroup_shortcode' );
}
if (!function_exists('wpsm_tab_shortcode')) {
	function wpsm_tab_shortcode( $atts, $content = null ) {
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		return '<div id="wpsm-tab-'. sanitize_title( $title ) .'" class="tab-content">'. do_shortcode( $content ) .'</div>';
	}
	add_shortcode( 'wpsm_tab', 'wpsm_tab_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Toggle
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_toggle_shortcode') ) {
	function wpsm_toggle_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array( 'title' => 'Toggle Title', 'class' => ''), $atts ) );
		
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		
		// Display the Toggle

		$opens = '';
		if ( $class == 'active' ) {  
			$opens = 'style="display:block"';
		} else {
			$opens = NULL;
		}

		return '<div class="wpsm-toggle"><h3 class="wpsm-toggle-trigger '.$class.'">'. $title .'</h3><div class="wpsm-toggle-container"'.$opens.'>' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('wpsm_toggle', 'wpsm_toggle_shortcode');
}

//////////////////////////////////////////////////////////////////
// Get feeds
//////////////////////////////////////////////////////////////////

if( !function_exists('wpsm_shortcode_feeds') ) {
function wpsm_shortcode_feeds( $atts, $content = null ) {
    @extract($atts);
	$number  = ($number)  ? $number  : '5' ;
	return wpsm_get_feeds( $url , $number );
}
add_shortcode('wpsm_feed', 'wpsm_shortcode_feeds');
}

function wpsm_get_feeds( $feed , $number ){
	include_once(ABSPATH . WPINC . '/feed.php');

	$rss = @fetch_feed( $feed );
	if (!is_wp_error( $rss ) ){
		$maxitems = $rss->get_item_quantity($number); 
		$rss_items = $rss->get_items(0, $maxitems); 
	}
	if ($maxitems == 0) {
		$out = "<ul><li>No items</li></ul>";
	}else{
		$out = "<ul>";
		
		foreach ( $rss_items as $item ) : 
			$out .= '<li><a href="'. esc_url( $item->get_permalink() ) .'" title="Posted '.$item->get_date("j F Y | g:i a").'">'. esc_html( $item->get_title() ) .'</a></li>';
		endforeach;
		$out .='</ul>';
	}
	
	return $out;
}

//////////////////////////////////////////////////////////////////
// Percent bars
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_bar_shortcode') ) {
	function wpsm_bar_shortcode( $atts  ) {		
		extract( shortcode_atts( array(
			'title' => '',
			'percentage' => '100%',
			'color' => '#6adcfa'
		), $atts ) );		

		$output = '<div class="wpsm-bar wpsm-clearfix" data-percent="'. $percentage .'%">';
			if ( $title !== '' ) $output .= '<div class="wpsm-bar-title" style="background: '. $color .';"><span>'. $title .'</span></div>';
			$output .= '<div class="wpsm-bar-bar" style="background: '. $color .';"></div>';
			$output .= '<div class="wpsm-bar-percent">'.$percentage.' %</div>';
		$output .= '</div>';
		
		return $output;
	}
	add_shortcode( 'wpsm_bar', 'wpsm_bar_shortcode' );
}

//////////////////////////////////////////////////////////////////
// List
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_list_shortcode') ) {
function wpsm_list_shortcode( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'type' => 'arrow',
			'hover' => '',
			'gap' => '',
			'darklink' => ''
		), $atts ) ); 
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		$gapclass = ($gap == 'small') ? ' small_gap_list' : '';	
		$hoverclass = ($hover) ? ' wpsm_pretty_hover' : '';	
		$darklinkclass = ($darklink) ? ' darklink' : '';
    return '<div class="wpsm_'.$type.'list wpsm_pretty_list'.$gapclass.$hoverclass.$darklinkclass.'">'.do_shortcode($content).'</div>';  
}  
add_shortcode("wpsm_list", "wpsm_list_shortcode");
}

//////////////////////////////////////////////////////////////////
// Pros
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_pros_shortcode') ) {
function wpsm_pros_shortcode( $atts, $content = null ) {

		@extract($atts);
		if( empty($title) ) $title = 'Positives';
		// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
		$content = do_shortcode($content);
        $content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );		 	
    return '<div class="wpsm_pros"><div class="title_pros">'.$title.'</div>'.do_shortcode($content).'</div>';  
}  
add_shortcode("wpsm_pros", "wpsm_pros_shortcode");
}

//////////////////////////////////////////////////////////////////
// Cons
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_cons_shortcode') ) {
function wpsm_cons_shortcode( $atts, $content = null ) {

		@extract($atts);
		if( empty($title) ) $title = 'Negatives'; 	
    return '<div class="wpsm_cons"><div class="title_cons">'.$title.'</div>'.do_shortcode($content).'</div>';  
}  
add_shortcode("wpsm_cons", "wpsm_cons_shortcode");
}

//////////////////////////////////////////////////////////////////
// Tooltip
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_tooltip') ) {
function wpsm_shortcode_tooltip( $atts, $content = null ) {
	wp_enqueue_script('tipsy');

    @extract($atts);
	if( empty($gravity) ) $gravity = 'sw';
	$content_true = do_shortcode($content);
	if( empty($content_true) ) return;
	$out = '';
	$out .= '<span class="wpsm-tooltip wpsm-tooltip-sw" original-title="'.$content_true.'">'.$text.'</span>';
   return $out;
}
add_shortcode('wpsm_tooltip', 'wpsm_shortcode_tooltip');
}


//////////////////////////////////////////////////////////////////
// Member block
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_member_shortcode') ) {
function wpsm_member_shortcode( $atts, $content = null ) {
	@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );	
	if($guest_text == '') $guest_text = ' This content visible only for members. You can login <a href="/wp-login.php" class="act-rehub-login-popup">here</a>.';
	if (is_user_logged_in() && !is_null( $content ) && !is_feed()) {
		return '<div class="wpsm-members"><strong>'.__("Members only", "rehub_framework").'</strong>' . do_shortcode( $content ) . '</div>';
	}
	else { 

		return '<div class="wpsm-members not-logined"><strong>'.__("Members only", "rehub_framework").'</strong> '.$guest_text.'</div>';	
		 }

	}	
add_shortcode('wpsm_member', 'wpsm_member_shortcode');
}

//////////////////////////////////////////////////////////////////
// Member content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_logged_in') ) {
function wpsm_shortcode_is_logged_in( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );	
	if (is_user_logged_in() && !is_null( $content ) && !is_feed()) {
		return $content;
	}
	else { 
		return;	
	}

}	
add_shortcode('wpsm_is_user', 'wpsm_shortcode_is_logged_in');
}

//////////////////////////////////////////////////////////////////
// Guest content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_guest') ) {
function wpsm_shortcode_is_guest( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );	
	if (!is_user_logged_in() && !is_null( $content ) && !is_feed()) {
		return $content;
	}
	else { 
		return;	
	}

}	
add_shortcode('wpsm_is_guest', 'wpsm_shortcode_is_guest');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_vendor') ) {
function wpsm_shortcode_is_vendor( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();
	if ( in_array( 'vendor', (array) $user->roles )  && !is_null( $content ) && !is_feed()) {
		return $content;
	}		
	else { 
		return;	
	}

}	
add_shortcode('wpsm_is_vendor', 'wpsm_shortcode_is_vendor');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_is_pending_vendor') ) {
function wpsm_shortcode_is_pending_vendor( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();
	if ( in_array( 'pending_vendor', (array) $user->roles )  && !is_null( $content ) && !is_feed()) {
		return $content;
	}		
	else { 
		return;	
	}

}	
add_shortcode('wpsm_is_pending_vendor', 'wpsm_shortcode_is_pending_vendor');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_not_vendor_logged') ) {
function wpsm_shortcode_not_vendor_logged( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();
	if ( is_user_logged_in() && !in_array( 'vendor', (array) $user->roles )  && !is_null( $content ) && !is_feed()) {
		return $content;
	}		
	else { 
		return;	
	}

}	
add_shortcode('wpsm_not_vendor_logged', 'wpsm_shortcode_not_vendor_logged');
}

//////////////////////////////////////////////////////////////////
// Vendor content
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_shortcode_customer_user') ) {
function wpsm_shortcode_customer_user( $atts, $content = null ) {
	//@extract($atts);
	// Remove all instances of "<p>&nbsp;</p><br>" to avoid extra lines.

	if ( is_user_logged_in() && !in_array( 'customer', (array) $user->roles )  && !is_null( $content ) && !is_feed()) {
	$content = do_shortcode($content);
	$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
	$Old     = array( '<br />', '<br>' );
	$New     = array( '','' );
	$content = str_replace( $Old, $New, $content );
	$user = wp_get_current_user();		
		return $content;
	}		
	else { 
		return;	
	}

}	
add_shortcode('wpsm_customer_user', 'wpsm_shortcode_customer_user');
}


//////////////////////////////////////////////////////////////////
// Gallery carousel
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_gallery_carousel') ) {
function wpsm_gallery_carousel( $atts, $content = null ) {
	wp_enqueue_script('owlcarousel');
	$title='';
    @extract($atts);
    $pretty_id = rand(5, 150) ;
    $everul =''; 
	$gals = explode(',', $ids);
	$everul .='<div class="media_owl_carousel carousel-style-2 pretty_photo_'.$pretty_id.' clearfix"><h3>'.$title.'</h3><div class="re_carousel" data-showrow="4" data-auto="">';
	foreach ($gals as $gal){
		$urlgal =  wp_get_attachment_url( $gal);
		$params = array( 'width' => 200, 'crop' => false  );
		$everul .='<div class="photo-item"><a href="'.$urlgal.'"><img src="'.bfi_thumb($urlgal, $params).'" alt="" /></a></div>';
	}
	$everul .='</div></div>';
    if (isset ($prettyphoto) && $prettyphoto == 'true'){
    	wp_enqueue_script('prettyphoto');
    	$everul .='<script>jQuery(function($){$(document).ready(function($){
     		$(".pretty_photo_'.$pretty_id.' a").attr("rel","prettyPhoto[gallery_'.$pretty_id.']").prettyPhoto({social_tools:false});
      	});});</script>';	
    } 			
	 return $everul;
}
add_shortcode('wpsm_minigallery', 'wpsm_gallery_carousel');
}

//////////////////////////////////////////////////////////////////
// Woo Box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woobox_shortcode') ) {
function wpsm_woobox_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
			'wooid'=> '',
		), $atts));
		
	if(!empty($id)):
		ob_start(); 
		rehub_get_woo_offer(esc_attr($id));
		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
	endif;	

}
add_shortcode('wpsm_woobox', 'wpsm_woobox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Woo Compare box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woocompare_shortcode') ) {
function wpsm_woocompare_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'ids' => '',
			'show_vendor'=>''
		), $atts));
		
	if(!empty($ids)):
		$ids = array_map( 'trim', explode( ",", $ids ) );
		$args = array(
	        'post__in' => $ids,
	        'numberposts' => '-1',
	        'orderby' => 'meta_value_num', 
	        'post_type' => 'product',  
	        'meta_key' => '_price',         
	    );
		ob_start(); 
		?>

			<?php $wp_query = new WP_Query( $args ); if ( $wp_query->have_posts() ) : ?> 
			<?php wp_enqueue_style('eggrehub'); ?>
			<div class="egg_sort_list re_sort_list simple_sort_list mb20">
			    <div class="aff_offer_links">			
				<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();  global $product;  ?>
					<?php $woolink = ($product->product_type =='external' && $product->add_to_cart_url() !='') ? $product->add_to_cart_url() : get_post_permalink($product->id) ;?>  
		            <div class="rehub_feat_block table_view_block">               
		                <div class="logo_offer_thumb offer_thumb<?php if(!empty($logo)) {echo ' nologo_thumb';}?>">  
						<?php if ($show_vendor==1 && defined('wcv_plugin_dir')) :?>
							<?php $vendor_id = get_the_author_meta( 'ID' );?>
							<a href="<?php echo WCV_Vendors::get_vendor_shop_page( $vendor_id );?>">
								<img src="<?php echo rh_show_vendor_avatar($vendor_id, 70, 70);?>" class="vendor_store_image_single" width="70" height="70" />
							</a>
						<?php else:?>
							<?php 
								$brand_url = get_post_meta($product->id, 'rehub_woo_coupon_logo_url', true );
						        $term_ids =  wp_get_post_terms($product->id, 'store', array("fields" => "ids"));
						        if (!empty($term_ids) && ! is_wp_error($term_ids)) {
						        	$term_id = $term_ids[0];
						        	$storeobj = get_term_by('id', $term_id, 'store');
						        	$store = $storeobj->name;
						        }
						        if (!empty ($brand_url)) {
						            $logo = esc_url($brand_url);
						        }  
						        else { 
						        	if (!empty($term_id)) {			        		
						        		$brand_url = get_term_meta( $term_id, 'brandimage', true );
						        	}
							        if (!empty ($brand_url)) {
							            $logo = esc_url($brand_url);
							        }  
						        }							

						    ?>						
		                    <a rel="nofollow" target="_blank" href="<?php echo esc_url($woolink) ?>" class="re_track_btn">
		                        <?php if(!empty($logo)) :?>
		                            <?php WPSM_image_resizer::show_static_resized_image(array('src'=> $logo, 'lazy'=>false, 'height'=> 50, 'title' => get_the_title(), 'no_thumb_url' => get_template_directory_uri().'/images/default/noimage_100_70.png'));?>
		                        <?php elseif (!empty($store)) :?>
		                          	<div class="aff_logo_text"><?php echo $store; ?></div>                          
		                        <?php endif ;?>                                                           
		                    </a>						
						<?php endif;?>
		                </div>
		                <div class="desc_col desc_simple_col">
		                    <div class="simple_title">
		                        <a rel="nofollow" target="_blank" class="re_track_btn" href="<?php echo esc_url($woolink) ?>">
		                            <?php the_title(); ?>
		                        </a>
		                        <?php do_action( 'rehub_vendor_show_action' ); ?>
		                    </div>                                
		                </div>                    
		                <div class="desc_col price_simple_col"> 
		                	<p><span class="price_count"><?php echo $product->get_price_html(); ?></span></p>                       
		                </div>
		                <div class="buttons_col">
		                    <div class="priced_block clearfix">
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
		                    </div>
		                </div>                                                                         
		            </div>               					

				<?php endwhile; ?>
				</div>    
			</div>
			<?php endif; wp_reset_query(); ?> 

		<?php

		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
	endif;	

}
add_shortcode('wpsm_woocompare', 'wpsm_woocompare_shortcode');
}

//////////////////////////////////////////////////////////////////
// POPUP BUTTON
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_button_popup_funtion') ) {
function wpsm_button_popup_funtion( $atts, $content = null ) {
    extract(shortcode_atts(array(
		'color' => 'orange',
		'size' => 'medium',
		'icon' => 'none',
		'btn_text' => 'Show me popup',
		'max_width' => '500',
		'enable_icon' => ''    
    ), $atts));	
    $rand = rand(1, 100) ;
    $iconshow = ($enable_icon !='') ? '<span class="'.$icon.'"></span>' : '';
	$out = '<div id="popup_cont_'.$rand.'" class="popup_cont_div"><div class="popup_cont_inside">'.do_shortcode($content).'</div></div>';
	$out .= '<a href="javascript:void(0)" class="popup_btn'.$rand.' wpsm-button wpsm-flat-btn '.$color.' '.$size.'"><span class="wpsm-button-inner">'.$iconshow.$btn_text.'</span></a>';
	$out .= '<script>jQuery(document).ready(function($) {
     			$(".popup_btn'.$rand.'").click(function(){
     				$.pgwModal({target: "#popup_cont_'.$rand.'",maxWidth: '.$max_width.',titleBar: false});
     			});
     		});</script>';
    return $out;
}
add_shortcode('wpsm_button_popup', 'wpsm_button_popup_funtion');
}

//////////////////////////////////////////////////////////////////
// Countdown
//////////////////////////////////////////////////////////////////
if (! function_exists( 'wpsm_countdown' ) ) :
	function wpsm_countdown($atts, $content = null) {	
		extract(shortcode_atts(array(
				"year" => '',
				"month" => '',
				"day" => '',
				"hour" => '00',
		), $atts));
		
		// load scripts
		wp_enqueue_script('lwtCountdown');
		$rand_id = rand(1, 100);
		ob_start(); 		
		?>

		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#countdown_dashboard<?php echo $rand_id;?>').show();
			  	$('#countdown_dashboard<?php echo $rand_id;?>').countDown({
				  	targetDate: {
					  'day': 	<?php echo $day ?>,
					  'month': 	<?php echo $month ?>,
					  'year': 	<?php echo $year ?>,
					  'hour': 	<?php echo $hour ?>,
					  'min': 		0,
					  'sec': 		0
				  	},
				  	omitWeeks: true,
				  	onComplete: function() { $('#countdown_dashboard<?php echo $rand_id;?>').hide() }
			  	});
			});
		</script>
		<div id="countdown_dashboard<?php echo $rand_id;?>" class="countdown_dashboard"> 			  
			<div class="dash days_dash"> <span class="dash_title">days</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
			<div class="dash hours_dash"> <span class="dash_title">hours</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
			<div class="dash minutes_dash"> <span class="dash_title">minutes</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
			<div class="dash seconds_dash"> <span class="dash_title">seconds</span>
				<div class="digit">0</div>
				<div class="digit">0</div>
			</div>
		</div>
		<!-- Countdown dashboard end -->
		<div class="clearfix"></div>		

		<?php		
		$output = ob_get_contents();
		ob_end_clean();
		return $output;	
	   
	}
	add_shortcode("wpsm_countdown", "wpsm_countdown");
endif;


//////////////////////////////////////////////////////////////////
// TITLE
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_title_function') ) {
function rehub_title_function( $atts, $content = null ) {  
    extract(shortcode_atts(array(
		'link' => '',				   
    ), $atts));
    $out = '';
    if(!empty($link)) :
	    $link_source = ($link =='affiliate') ? rehub_create_affiliate_link() : get_the_permalink() ;
		$link_target = ($link =='affiliate') ? ' target="_blank" rel="nofollow"' : '' ;
		$out .='<a href="'.$link_source.'"'.$link_target.'>';
	endif;
	$out .= get_the_title();
    if(!empty($link)) :
		$out .='</a>';
	endif;	
    return $out;
}
add_shortcode('rehub_title', 'rehub_title_function');
}

//////////////////////////////////////////////////////////////////
// AFF BUTTON
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_affbtn_function') ) {
function rehub_affbtn_function( $atts, $content = null ) { 
    extract(shortcode_atts(array(
		'btn_text' => '',
		'btn_url' => '',
		'btn_price' => '',
		'meta_btn_url' => '',
		'meta_btn_price' => '',
		'button_from_review' => '',				   
    ), $atts));
    if ($button_from_review =='1') :
    	ob_start();
    	rehub_create_btn(''); 
		$out = ob_get_contents();
		ob_end_clean();
	else :	
	    $button_url = (!empty($meta_btn_url)) ? get_post_meta( get_the_ID(), esc_html($meta_btn_url), true ) : $btn_url;
		if (empty ($button_url)) {$button_url = get_the_permalink();}
		$button_price = (!empty($meta_btn_price)) ? get_post_meta( get_the_ID(), esc_html($meta_btn_price), true ) : $btn_price;    
		$out = 	'<div class="priced_block clearfix">';
		if (!empty($button_price)) :
			$out .= '<p><span class="price_count">'.esc_html($button_price).'</span></p>'; 
		endif;
		$out .='<div><a href="'.esc_url($button_url).'" class="re_track_btn btn_offer_block" target="_blank" rel="nofollow">';
		if (!empty($btn_text)) :         
			$out .= $btn_text;
		elseif (rehub_option('rehub_btn_text') !='') :
			$out .= rehub_option("rehub_btn_text");
		else :
			$out .= __("Buy this item", "rehub_framework");	
		endif;
		$out .='</a></div></div>';
	endif;            
    return $out;
}
add_shortcode('rehub_affbtn', 'rehub_affbtn_function');
}

//////////////////////////////////////////////////////////////////
// EXCERPT
//////////////////////////////////////////////////////////////////
if( !function_exists('rehub_exerpt_function') ) {
function rehub_exerpt_function( $atts, $content = null ) { 
    extract(shortcode_atts(array(
		'length' => '120',
		'reviewtext' => '',
		'reviewheading'=> '',
		'reviewpros'=>'',
		'reviewcons'=>'',
    ), $atts));
    ob_start();
    if ($reviewtext =='1') :
    	echo vp_metabox('rehub_post.review_post.0.review_post_summary_text');
    elseif ($reviewheading =='1') :
    	echo vp_metabox('rehub_post.review_post.0.review_post_heading');    
	elseif ($reviewpros =='1') :
	    $prosvalues = vp_metabox('rehub_post.review_post.0.review_post_pros_text');
		if(empty($prosvalues)) return;	
	    $prosvalues = explode(PHP_EOL, $prosvalues);	    	
	    echo '<div class="wpsm_pros"><ul>';
	    foreach ($prosvalues as $prosvalue) {
	    	echo '<li>'.$prosvalue.'</li>';
	    }
	    echo '</ul></div>';	
	elseif ($reviewcons =='1') :
	    $consvalues = vp_metabox('rehub_post.review_post.0.review_post_cons_text');
		if(empty($consvalues)) return;		
	    $consvalues = explode(PHP_EOL, $consvalues);	    
	    echo '<div class="wpsm_pros"><ul>';
	    foreach ($consvalues as $consvalue) {
	    	echo '<li>'.$consvalue.'</li>';
	    }
	    echo '</ul></div>';		         
    else :
		kama_excerpt('maxchar='.$length.'');
	endif;
	$output = ob_get_contents();
	ob_end_clean();
	return $output; 
}
add_shortcode('rehub_exerpt', 'rehub_exerpt_function');
}

//////////////////////////////////////////////////////////////////
// Review and ads shortcode and functions
//////////////////////////////////////////////////////////////////

if( !function_exists('rehub_shortcode_review') ) {
function rehub_shortcode_review( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_post_product_shortcode') == '1') {	
		ob_start();
		rehub_get_review();
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
	}
}
}
add_shortcode('review', 'rehub_shortcode_review');

if( !function_exists('rehub_shortcode_offer') ) {
function rehub_shortcode_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_offer_shortcode') == '1') {
		ob_start(); 
		rehub_get_offer();
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
	}
}
}
add_shortcode('offer_product', 'rehub_shortcode_offer');

if( !function_exists('rehub_shortcode_aff_offer') ) {
function rehub_shortcode_aff_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_offer_shortcode') == '1') {
		ob_start(); 
		rehub_get_aff_offer();
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
	}
}
}
add_shortcode('aff_offer_product', 'rehub_shortcode_aff_offer');

if( !function_exists('rehub_shortcode_woo_offer') ) {
function rehub_shortcode_woo_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_offer_shortcode') == '1') {
		if (vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') {
			$review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');
			ob_start(); 
			rehub_get_woo_offer($review_woo_link);
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		} 
	}
}
}
add_shortcode('woo_offer_product', 'rehub_shortcode_woo_offer');

if( !function_exists('rehub_shortcode_woolist_offer') ) {
function rehub_shortcode_woolist_offer( $atts, $content = null ) {
	if(vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_shortcode') == '1') {
		if (vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_list') {
			$review_woo_list_links = vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_links');
			if (is_array($review_woo_list_links)) { $review_woo_list_links = implode(',', $review_woo_list_links); }
			ob_start(); 
			echo do_shortcode('[wpsm_woolist data_source="ids" ids="'.$review_woo_list_links.'"]');
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		} 
	}
}
}
add_shortcode('woo_offer_list', 'rehub_shortcode_woolist_offer');

if( !function_exists('rehub_shortcode_quick_offer') ) {
function rehub_shortcode_quick_offer( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'id' => '',
			), $atts);	
		if (empty($atts['id'])) return false;
		ob_start(); 
		rehub_quick_offer($atts['id']);
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
}
}
add_shortcode('quick_offer', 'rehub_shortcode_quick_offer');

if(!function_exists('wpsm_shortcode_boxad')) {
function wpsm_shortcode_boxad( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'float' => 'none',
			), $atts);

	$out = '<div class="wpsm_boxad mediad align'.$atts['float'].'">
			' .rehub_option("rehub_shortcode_ads"). '
			</div>';
    return $out;
}
add_shortcode('wpsm_ads1', 'wpsm_shortcode_boxad');
}

if(!function_exists('wpsm_shortcode_boxad2')) {
function wpsm_shortcode_boxad2( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'float' => 'none',
			), $atts);

	$out = '<div class="wpsm_boxad mediad align'.$atts['float'].'">
			' .rehub_option("rehub_shortcode_ads_2"). '
			</div>';
    return $out;
}
add_shortcode('wpsm_ads2', 'wpsm_shortcode_boxad2');
}

//////////////////////////////////////////////////////////////////
// Specification for meta filter plugin
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_specification_shortcode') ) {
function wpsm_specification_shortcode($atts, $content = null ) {
extract(shortcode_atts(array(
	'id' => '',
	'title' => '',
), $atts));
if(class_exists('MetaDataFilter')):
	global $post;
	if(!isset($atts['id']) || $atts['id'] =='') {
		$id = get_the_ID();
	}
	$title_label = (!empty($atts['title'])) ? $atts['title'] : __('Specification', 'rehub_framework');

	ob_start();
	echo '<div class="rehub_specification"><div class="title_specification">'.$title_label.'</div>';
	MetaDataFilterPage::draw_single_page_items($id, false);
	echo '</div>';
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
endif;
}
add_shortcode('wpsm_specification', 'wpsm_specification_shortcode');
}

//////////////////////////////////////////////////////////////////
// Top rating shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_toprating_shortcode') ) {
function wpsm_toprating_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
			'postid' => '',
			'full_width' => '0',
		), $atts));
		
	if(isset($atts['id']) || isset($atts['postid'])):

		if(!empty($atts['id'])){
			$toppost = get_post($atts['id']);
			$module_cats = get_post_meta( $toppost->ID, 'top_review_cat', true ); 
	    	$module_tag = get_post_meta( $toppost->ID, 'top_review_tag', true ); 
	    	$module_fetch = get_post_meta( $toppost->ID, 'top_review_fetch', true ); 
	    	$module_ids = get_post_meta( $toppost->ID, 'manual_ids', true ); 
	    	$order_choose = get_post_meta( $toppost->ID, 'top_review_choose', true ); 
	    	$module_desc = get_post_meta( $toppost->ID, 'top_review_desc', true );
	    	$module_desc_fields = get_post_meta( $toppost->ID, 'top_review_custom_fields', true );
	    	$rating_circle = get_post_meta( $toppost->ID, 'top_review_circle', true );
	    	$module_field_sorting = get_post_meta( $toppost->ID, 'top_review_field_sort', true );
	    	$module_order = get_post_meta( $toppost->ID, 'top_review_order', true );    	
	    	if ($module_fetch ==''){$module_fetch = '10';}; 
	    	if ($module_desc ==''){$module_desc = 'post';};
	    	if ($rating_circle ==''){$rating_circle = '1';};
		}
		elseif(!empty($atts['postid'])){
			$module_cats = $module_tag = ''; 
	    	$module_fetch = 1; 
	    	$module_ids = explode(',', $atts['postid']); 
	    	$order_choose = 'manual_choose'; 
	    	$module_desc = 'post';
	    	$module_desc_fields = '';
	    	$rating_circle = 1;
	    	$module_field_sorting = '';
	    	$module_order = '';    				
		}
		ob_start(); 

    	?>
            <div class="clearfix"></div>

            <?php if ($order_choose == 'cat_choose') :?>
                <?php $query = array( 
                    'cat' => $module_cats, 
                    'tag' => $module_tag, 
                    'posts_per_page' => $module_fetch, 
                    'nopaging' => 0, 
                    'post_status' => 'publish', 
                    'ignore_sticky_posts' => 1, 
                    'meta_key' => 'rehub_review_overall_score', 
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                        array(
                        'key' => 'rehub_framework_post_type',
                        'value' => 'review',
                        'compare' => 'LIKE',
                        )
                    )
                );
                ?> 
                <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting;} ?>
                <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                
        	<?php elseif ($order_choose == 'manual_choose' && $module_ids !='') :?>
                <?php $query = array( 
                    'post_status' => 'publish', 
                    'ignore_sticky_posts' => 1,
                    'posts_per_page'=> -1, 
                    'meta_key' => 'rehub_review_overall_score', 
                    'orderby' => 'meta_value_num',
                    'post__in' => $module_ids
                );
                ?>
        	<?php else :?>
                <?php $query = array( 
                    'posts_per_page' => $module_fetch, 
                    'nopaging' => 0, 
                    'post_status' => 'publish', 
                    'ignore_sticky_posts' => 1, 
                    'meta_key' => 'rehub_review_overall_score', 
                    'orderby' => 'meta_value_num',
                    'meta_query' => array(
                        array(
                        'key' => 'rehub_framework_post_type',
                        'value' => 'review',
                        'compare' => 'LIKE',
                        )
                    )
                );
                ?>
                <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting;} ?>
                <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                             		
        	<?php endif ;?>	

	        <?php 
	        if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){
	            $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
	            $_REQUEST['mdf_get_query_args_only'] = true;
	            do_shortcode('[meta_data_filter_results]');
	            $args = $_REQUEST['meta_data_filter_args'];
	            global $wp_query;
	            $wp_query=new WP_Query($args);
	            $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
	        }
	        else { $wp_query = new WP_Query($query); }
	        ?>
            <?php $wp_query = new WP_Query($query); $i=0; if ($wp_query->have_posts()) :?>
            <div class="top_rating_block<?php if(isset($atts['full_width']) && $atts['full_width']=='1') : ?> full_width_rating<?php else :?> with_sidebar_rating<?php endif;?> list_style_rating">
            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i ++?>     
                <div class="top_rating_item" id='rank_<?php echo $i?>'>                    
                    <div class="product_image_col">                        	
                        <figure><?php echo re_badge_create('ribbon'); ?>
                        	<span class="rank_count"><?php if (($i) == '1') :?><i class="fa fa-trophy"></i><?php else:?><?php echo $i?><?php endif ?></span>
                        	<a href="<?php the_permalink();?>">
                                <?php 
                                $showimg = new WPSM_image_resizer();
                                $showimg->use_thumb = true;
                                $width_figure_rating = apply_filters( 'wpsm_top_rating_figure_width', 120 );
                                $height_figure_rating = apply_filters( 'wpsm_top_rating_figure_height', 120 );
                                $showimg->height = $height_figure_rating;
                                $showimg->crop = true;
                                $showimg->show_resized_image();                                    
                                ?>
                        	</a>
                        </figure>
                    </div>                            
                <div class="desc_col">
                    <h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                    <p>
                    	<?php if ($module_desc =='post') :?>
                    		<?php if ($full_width == 1):?>
                    			<?php kama_excerpt('maxchar=250'); ?>                        			
                    		<?php else:?>
                    			<?php kama_excerpt('maxchar=120'); ?> 
                    		<?php endif;?>
                    	<?php elseif ($module_desc =='review') :?>
                    		<?php echo wp_kses_post(vp_metabox('rehub_post.review_post.0.review_post_summary_text')); ?>
                        <?php elseif ($module_desc =='field') :?>
                            <?php if ( get_post_meta(get_the_ID(), $module_desc_fields, true) ) : ?>
                                <?php echo get_post_meta(get_the_ID(), $module_desc_fields, true) ?>
                            <?php endif; ?>                        		
                    	<?php elseif ($module_desc =='none') :?>
                    	<?php else :?>
                    		<?php if ($full_width == 1):?>
                    			<?php kama_excerpt('maxchar=250'); ?>                        			
                    		<?php else:?>
                    			<?php kama_excerpt('maxchar=120'); ?> 
                    		<?php endif;?>	
                		<?php endif;?>
                    </p>
                    <div class="star"><?php rehub_get_user_results('small', 'yes') ?></div>
                </div>
                <div class="rating_col">
                <?php if ($rating_circle =='1'):?>
                    <?php $rating_score_clean = rehub_get_overall_score(); ?>
                    <div class="top-rating-item-circle-view">
                        <div class="radial-progress" data-rating="<?php echo $rating_score_clean?>">
                            <div class="circle">
                                <div class="mask full">
                                    <div class="fill"></div>
                                </div>
                                <div class="mask half">
                                    <div class="fill"></div>
                                    <div class="fill fix"></div>
                                </div>
                                
                            </div>
                            <div class="inset">
                                <div class="percentage"><?php echo $rating_score_clean?></div>
                            </div>
                        </div>
                    </div>
                <?php elseif ($rating_circle =='2') :?> 
                    <div class="score square_score"> <span class="it_score"><?php echo rehub_get_overall_score() ?></span></div>       
                <?php else :?>
                    <div class="score"> <span class="it_score"><?php echo rehub_get_overall_score() ?></span></div>    
                <?php endif ;?>
                </div>
                <div class="buttons_col">
                	<?php rehub_create_btn('') ;?>
                    <a href="<?php the_permalink();?>" class="read_full"><?php if(rehub_option('rehub_review_text') !='') :?><?php echo rehub_option('rehub_review_text') ; ?><?php else :?><?php _e('Read full review', 'rehub_framework'); ?><?php endif ;?></a>
                </div>
                </div>
            <?php endwhile; ?>
            </div>
            <?php wp_reset_query(); ?>
            <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
            <?php endif; ?>

    	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_top', 'wpsm_toprating_shortcode');
}

//////////////////////////////////////////////////////////////////
// Top table shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_toptable_shortcode') ) {
function wpsm_toptable_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
			'full_width' => '0',
		), $atts));
		
	if(isset($atts['id']) && $atts['id']):

		$toppost = get_post($atts['id']);
		$module_cats = get_post_meta( $toppost->ID, 'top_review_cat', true );
		$disable_filters = get_post_meta( $toppost->ID, 'top_review_filter_disable', true ); 
    	$module_tag = get_post_meta( $toppost->ID, 'top_review_tag', true ); 
    	$module_fetch = intval(get_post_meta( $toppost->ID, 'top_review_fetch', true ));  
    	$module_ids = get_post_meta( $toppost->ID, 'manual_ids', true ); 
    	$order_choose = get_post_meta( $toppost->ID, 'top_review_choose', true ); 
	    $module_custom_post = get_post_meta( $toppost->ID, 'top_review_custompost', true );
	    $catalog_tax = get_post_meta( $toppost->ID, 'catalog_tax', true );
	    $catalog_tax_slug = get_post_meta( $toppost->ID, 'catalog_tax_slug', true );    	
    	$module_field_sorting = get_post_meta( $toppost->ID, 'top_review_field_sort', true );
    	$module_order = get_post_meta( $toppost->ID, 'top_review_order', true );
	    $first_column_enable = get_post_meta( $toppost->ID, 'first_column_enable', true );
	    $first_column_rank = get_post_meta( $toppost->ID, 'first_column_rank', true ); 
	    $last_column_enable = get_post_meta( $toppost->ID, 'last_column_enable', true );
	    $first_column_name = (get_post_meta( $toppost->ID, 'first_column_name', true ) !='') ? esc_html(get_post_meta( $toppost->ID, 'first_column_name', true )) : __('Product', 'rehub_framework') ;
	    $last_column_name = (get_post_meta( $toppost->ID, 'last_column_name', true ) !='') ? esc_html(get_post_meta( $toppost->ID, 'last_column_name', true )) : '' ;
	    $affiliate_link = get_post_meta( $toppost->ID, 'first_column_link', true );
	    $rows = get_post_meta( $toppost->ID, 'columncontents', true ); //Get the rows     	    	
    	if ($module_fetch ==''){$module_fetch = '10';}; 
		
		ob_start(); 
    	?>
        <div class="clearfix"></div>
        <?php 
            if ( get_query_var('paged') ) { 
                $paged = get_query_var('paged'); 
            } 
            else if ( get_query_var('page') ) {
                $paged = get_query_var('page'); 
            } 
            else {
                $paged = 1; 
            }        
        ?>        
        <?php if ($order_choose == 'cat_choose') :?>
            <?php $query = array( 
                'cat' => $module_cats, 
                'tag' => $module_tag, 
                'posts_per_page' => $module_fetch, 
                'paged' => $paged,  
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
            );
            ?> 
            <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting; $query['orderby'] = 'meta_value_num';} ?>
            <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                
    	<?php elseif ($order_choose == 'manual_choose' && $module_ids !='') :?>
            <?php $query = array( 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1,
                'posts_per_page'=> -1, 
                'orderby' => 'post__in',
                'post__in' => $module_ids

            );
            ?>
	    <?php elseif ($order_choose == 'custom_post') :?>
	        <?php $query = array(  
	            'posts_per_page' => $module_fetch,  
	            'post_status' => 'publish', 
	            'ignore_sticky_posts' => 1,
	            'paged' => $paged, 
	            'post_type' => $module_custom_post, 
	        );
	        ?> 
	        <?php if (!empty ($catalog_tax_slug) && !empty ($catalog_tax)) : ?>
	            <?php $query['tax_query'] = array (
	                array(
	                    'taxonomy' => $catalog_tax,
	                    'field'    => 'slug',
	                    'terms'    => $catalog_tax_slug,
	                ),
	            );?>
	        <?php endif ?> 
            <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting; $query['orderby'] = 'meta_value_num';} ?>
            <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                    
    	<?php else :?>
            <?php $query = array( 
                'posts_per_page' => $module_fetch, 
                'paged' => $paged,
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
            );
            ?>
            <?php if(!empty ($module_field_sorting)) {$query['meta_key'] = $module_field_sorting; $query['orderby'] = 'meta_value_num';} ?>
            <?php if($module_order =='asc') {$query['order'] = 'ASC';} ?>	                             		
    	<?php endif ;?>	

        <?php 
        if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){
            $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
            $_REQUEST['mdf_get_query_args_only'] = true;
            do_shortcode('[meta_data_filter_results]');
            $args = $_REQUEST['meta_data_filter_args'];
            global $wp_query;
            $wp_query=new WP_Query($args);
            $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
        }
        else { $wp_query = new WP_Query($query); }
        ?>
        <?php $i=0; if ($wp_query->have_posts()) :?>
        <?php wp_enqueue_script('tablesorter'); wp_enqueue_style('tabletoggle'); ?>
        <?php $sortable_col = ($disable_filters !=1) ? ' data-tablesaw-sortable-col' : '';?>
        <?php $sortable_switch = ($disable_filters !=1) ? ' data-tablesaw-sortable-switch' : '';?>
        <table data-tablesaw-sortable<?php echo $sortable_switch; ?> class="tablesaw top_table_block<?php if ($full_width =='1') : ?> full_width_rating<?php else :?> with_sidebar_rating<?php endif;?> tablesorter" cellspacing="0">
            <thead> 
            <tr class="top_rating_heading">
                <?php if ($first_column_enable):?><th class="product_col_name" data-tablesaw-priority="persist"><?php echo $first_column_name; ?></th><?php endif;?>
                <?php if (!empty ($rows)) {
                    $nameid=0;                       
                    foreach ($rows as $row) {                       
                    $col_name = $row['column_name'];
                    echo '<th class="col_name"'.$sortable_col.' data-tablesaw-priority="1">'.esc_html($col_name).'</th>';
                    $nameid++;
                    } 
                }
                ?>
                <?php if ($last_column_enable):?><th class="buttons_col_name" <?php echo $sortable_col; ?> data-tablesaw-priority="1"><?php echo $last_column_name; ?></th><?php endif;?>                      
            </tr>
            </thead>
            <tbody>
        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i ++?>     
            <tr class="top_rating_item" id='rank_<?php echo $i?>'>
                <?php if ($first_column_enable):?>
                    <td class="product_image_col"><?php echo re_badge_create('tablelabel'); ?>
                        <figure>
                            <?php if (!is_paged() && $first_column_rank) :?><span class="rank_count"><?php if (($i) == '1') :?><i class="fa fa-trophy"></i><?php else:?><?php echo $i?><?php endif ?></span><?php endif ?>                        
                            <?php $link_on_thumb = ($affiliate_link =='1') ? rehub_create_affiliate_link() : get_the_permalink(); ?>
                            <?php $link_on_thumb_target = ($affiliate_link =='1') ? ' class="btn_offer_block" target="_blank" rel="nofollow"' : '' ; ?>
                            <a href="<?php echo $link_on_thumb;?>" <?php echo $link_on_thumb_target;?>>
                            <?php 
                            $showimg = new WPSM_image_resizer();
                            $showimg->use_thumb = true;
                            $height_figure_table = apply_filters( 'wpsm_top_table_figure_height', 120 );
                            $showimg->height = $height_figure_table;
                            $showimg->crop = true;
                            $showimg->show_resized_image();                                    
                            ?> 
                            </a>
                        </figure>
                    </td>
                <?php endif;?>
                <?php 
                if (!empty ($rows)) {
                    $pbid=0;                       
                    foreach ($rows as $row) {
                    $centered = ($row['column_center']== '1') ? ' centered_content' : '' ;
                    echo '<td class="column_'.$pbid.' column_content'.$centered.'">';
                    echo do_shortcode(wp_kses_post($row['column_html']));                       
                    $element = $row['column_type'];
                        if ($element == 'meta_value') {
                            include(rh_locate_template('inc/top/metacolumn.php'));
                        } else if ($element == 'review_function') {
                            include(rh_locate_template('inc/top/reviewcolumn.php'));
                        } else if ($element == 'taxonomy_value') {
                            include(rh_locate_template('inc/top/taxonomyrow.php'));                            
                        } else if ($element == 'user_review_function') {
                            include(rh_locate_template('inc/top/userreviewcolumn.php')); 
                        } else if ($element == 'static_user_review_function') {
                            include(rh_locate_template('inc/top/staticuserreviewcolumn.php'));                                                                       
                        } else {
                            
                        };
                    echo '</td>';
                    $pbid++;
                    } 
                }
                ?>
                <?php if ($last_column_enable):?>
                    <td class="buttons_col">
                    	<?php rehub_create_btn('') ;?>                                
                    </td>
                <?php endif ;?>
            </tr>
        <?php endwhile; ?>
	        </tbody>
	    </table>
        <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
        <?php endif; ?>
        <?php wp_reset_query(); ?>

    	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_toptable', 'wpsm_toptable_shortcode');
}

//////////////////////////////////////////////////////////////////
// Top charts shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_topcharts_shortcode') ) {
function wpsm_topcharts_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'id' => '',
		), $atts));
		
	if(isset($atts['id']) && $atts['id']):
		$topchart = get_post($atts['id']);
	    $type_chart = get_post_meta( $topchart->ID, 'top_chart_type', true );
	    $ids_chart = get_post_meta( $topchart->ID, 'top_chart_ids', true );
	    if($ids_chart) {$module_ids = explode(',', $ids_chart);}
	    $module_width = get_post_meta( $topchart->ID, 'top_chart_width', true );     
	    $rows = get_post_meta( $topchart->ID, 'columncontents', true ); //Get the rows 
	    $compareids = (get_query_var('compareids')) ? explode(',', get_query_var('compareids')) : '';    		
		ob_start(); 
    	?>
        <?php if ($compareids !='') :?>
            <?php $query = array( 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
                'orderby' => 'post__in',
                'post__in' => $compareids,
                'posts_per_page'=> -1,

            );
            ?>
    	<?php elseif (!empty($module_ids)) :?>
            <?php $query = array( 
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
                'orderby' => 'post__in',
                'post__in' => $module_ids,
                'posts_per_page'=> -1,

            );
            ?>
    	<?php else :?>
            <?php $query = array( 
                'posts_per_page' => 5,  
                'post_status' => 'publish', 
                'ignore_sticky_posts' => 1, 
            );
            ?>                                		
    	<?php endif ;?>
        <?php if (post_type_exists( $type_chart )) {$query['post_type'] = $type_chart;} ?>	

        <?php 
        if(class_exists('MetaDataFilter') AND MetaDataFilter::is_page_mdf_data()){

            $_REQUEST['mdf_do_not_render_shortcode_tpl'] = true;
            $_REQUEST['mdf_get_query_args_only'] = true;
            do_shortcode('[meta_data_filter_results]');
            $args = $_REQUEST['meta_data_filter_args'];
            global $wp_query;
            $wp_query=new WP_Query($args);
            $_REQUEST['meta_data_filter_found_posts']=$wp_query->found_posts;
        }
        else { $wp_query = new WP_Query($query); }    
        $i=0; if ($wp_query->have_posts()) :?>
        <?php wp_enqueue_script('carouFredSel'); wp_enqueue_script('touchswipe'); ?>                                       
        <div class="top_chart table_view_charts loading">
            <div class="top_chart_controls">
                <a href="/" class="controls prev"></a>
                <div class="top_chart_pagination"></div>
                <a href="/" class="controls next"></a>
            </div>
            <div class="top_chart_first">
                <ul>
                    <?php if (!empty ($rows)) {
                        $nameid=0;                       
                        foreach ($rows as $row) {   
                        $element_type = $row['column_type']; 
                        $first_col_value = '<div';  
                        if (isset ($row['sticky_header']) && $row['sticky_header'] == 1) {$first_col_value .= ' class="sticky-cell"';} 
                        $first_col_value .= '>'.esc_html($row["column_name"]).'';
                        if (isset ($row['enable_diff']) && $row['enable_diff'] == 1) {$first_col_value .= '<br /><label class="diff-label"><input class="re-compare-show-diff" name="re-compare-show-diff" type="checkbox" />'.__('Show only differences', 'rehub_framework').'</label>';}                                                              
                        $first_col_value .= '</div>';                
                        echo '<li class="row_chart_'.$nameid.' '.$element_type.'_row_chart">'.$first_col_value.'</li>';
                        $nameid++;
                        } 
                    }
                    ?>
                </ul>
            </div>
        	<div class="top_chart_wrap"><div class="top_chart_carousel">
		        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i ++?>     
		            <div class="<?php echo re_badge_create('class'); ?> top_rating_item top_chart_item compare-item-<?php echo get_the_ID();?>" id='rank_<?php echo $i?>' data-compareid="<?php echo get_the_ID();?>">
		                <ul>
		                <?php 
		                if (!empty ($rows)) {
		                    $pbid=0;                       
		                    foreach ($rows as $row) {                                                     
		                    $element = $row['column_type'];
		                        echo '<li class="row_chart_'.$pbid.' '.$element.'_row_chart">';
		                        if ($element == 'meta_value') {                                
		                            include(rh_locate_template('inc/top/metarow.php'));
		                        } else if ($element == 'image') {
		                            include(rh_locate_template('inc/top/imagerow.php'));
                                } else if ($element == 'imagefull') {
                                        include(rh_locate_template('inc/top/imagefullrow.php'));
		                        } else if ($element == 'title') {
		                            include(rh_locate_template('inc/top/titlerow.php'));   
		                        } else if ($element == 'taxonomy_value') {
		                            include(rh_locate_template('inc/top/taxonomyrow.php'));     
		                        } else if ($element == 'affiliate_btn') {
		                            include(rh_locate_template('inc/top/btnrow.php'));
		                        } else if ($element == 'review_link') {
		                            include(rh_locate_template('inc/top/reviewlinkrow.php'));
		                        } else if ($element == 'review_function') {
		                            include(rh_locate_template('inc/top/reviewrow.php'));                                    
		                        } else if ($element == 'user_review_function') {
		                            include(rh_locate_template('inc/top/userreviewcolumn.php'));
                                } else if ($element == 'static_user_review_function') {
                                    include(rh_locate_template('inc/top/staticuserreviewcolumn.php'));
                                } else if ($element == 'shortcode') {
                                    $shortcodevalue = (isset($row['shortcode_value'])) ? $row['shortcode_value'] : '';
                                    echo do_shortcode(wp_kses_post($shortcodevalue));                                     
		                        } else {   
		                        };
		                        echo '</li>';
		                    $pbid++;
		                    } 
		                }
		                ?>
		            </ul>
		            </div>
		        <?php endwhile; ?>
        	</div></div>
        	<span class="top_chart_row_found" data-rowcount="<?php echo $pbid;?>"></span>
        </div>
        <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
        <?php endif; ?>
        <?php wp_reset_query(); ?>

    	<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_charts', 'wpsm_topcharts_shortcode');
}


//////////////////////////////////////////////////////////////////
// Woo charts shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_woocharts_shortcode') ) {
function wpsm_woocharts_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'ids' => '',
		), $atts));
		
	if($ids):
		$compareids = explode(',', $ids);
	else :
		$compareids = (get_query_var('compareids')) ? explode(',', get_query_var('compareids')) : '';
	endif;	
	if(!empty($compareids)):
		ob_start(); 
		?>		
	        <?php $query = array( 
	            'post_status' => 'publish', 
	            'ignore_sticky_posts' => 1, 
	            'orderby' => 'post__in',
	            'post__in' => $compareids,
	            'posts_per_page'=> -1,
	            'post_type'=> 'product'

	        );
	        ?>	

	        <?php $common_attributes = array();?>
	        <?php $common = new WP_Query($query); if ($common->have_posts()) : ?>
	        <?php while ($common->have_posts()) : $common->the_post(); global $product; ?>
	        	<?php $attributes = $product->get_attributes();?>
	        	<?php foreach ($attributes as $key => $attribute) {
	        		if($attribute['is_visible'] == 1){
	        			$key = $attribute['name'];
	        			if(!empty($common_attributes) && array_key_exists($key, $common_attributes)){
	        				continue;
	        			}
	        			$common_attributes[$key] = $attribute;
	        		}
	        	}
	        	?>
	        <?php endwhile; endif; wp_reset_query(); ?>

	    	<?php $wp_query = new WP_Query($query); $ci=0; if ($wp_query->have_posts()) : ?>

	    	<?php wp_enqueue_script('carouFredSel'); wp_enqueue_script('touchswipe'); ?>
		    <div class="top_chart table_view_charts loading">
		        <div class="top_chart_controls">
		            <a href="/" class="controls prev"></a>
		            <div class="top_chart_pagination"></div>
		            <a href="/" class="controls next"></a>
		        </div>
                <div class="top_chart_first">
                    <ul>
                        <li class="row_chart_0 image_row_chart">
                            <div class="sticky-cell"><br /><label class="diff-label"><input class="re-compare-show-diff" name="re-compare-show-diff" type="checkbox" /><?php _e('Show only differences', 'rehub_framework');?></label></div>
                        </li>
                        <li class="row_chart_1 heading_row_chart">
                            <?php _e('Overview', 'rehub_framework');?>
                        </li>                        
                        <li class="row_chart_2 meta_value_row_chart">
                            <?php _e('Description', 'rehub_framework');?>
                        </li> 
                        <li class="row_chart_3 meta_value_row_chart">
                            <?php _e('Rating', 'rehub_framework');?>
                        </li>                          
                        <li class="row_chart_4 meta_value_row_chart">
                            <?php _e('SKU', 'rehub_framework');?>
                        </li> 
                        <li class="row_chart_5 meta_value_row_chart">
                            <?php _e('Brand/Store', 'rehub_framework');?>
                        </li>  
                        <li class="row_chart_6 meta_value_row_chart">
                            <?php _e('Sold by', 'rehub_framework');?>
                        </li>                                                
                        <li class="row_chart_7 meta_value_row_chart">
                            <?php _e('Availability', 'rehub_framework');?>
                        </li>    
                        <?php if(!empty($common_attributes)):?>
	                        <li class="row_chart_8 heading_row_chart">
	                            <?php _e('Attributes', 'rehub_framework');?>
	                        </li>                        
	                        <?php $i = 8; foreach($common_attributes as $attribute_value):?>
	                            <?php $i++;?>
	                            <li class="row_chart_<?php echo $i;?> meta_value_row_chart">
	                                <?php echo wc_attribute_label( $attribute_value['name'] ); ?>
	                            </li>
	                        <?php endforeach;?>
                    	<?php endif;?>
                    </ul>
                </div>
		    	<div class="top_chart_wrap woocommerce"><div class="top_chart_carousel">
			        <?php while ($wp_query->have_posts()) : $wp_query->the_post(); global $product, $post; $ci ++?>
			            <div class="top_rating_item top_chart_item compare-item-<?php echo $post->ID;?>" id='rank_<?php echo $i?>' data-compareid="<?php echo $post->ID;?>">
			                <ul>
                                <li class="row_chart_0 image_row_chart">
                                    <div class="product_image_col sticky-cell">                                  
                                        <i class="fa fa-times-circle-o re-compare-close-in-chart"></i>
                                        <figure>
								            <?php if ( $product->is_featured() ) : ?>
								                    <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . __( 'Featured!', 'rehub_framework' ) . '</span>', $post, $product ); ?>
								            <?php endif; ?>        
								            <?php if ( $product->is_on_sale()) : ?>
								                <?php 
								                $percentage=0;
								                $featured = ($product->is_featured()) ? ' onsalefeatured' : '';
								                if ($product->regular_price) {
								                    $percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
								                }
								                if ($percentage && $percentage>0 && !$product->is_type( 'variable' )) {
								                    $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'"><span>- ' . $percentage . '%</span></span>', $post, $product );
								                }
								                else{
								                    $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'">' . esc_html__( 'Sale!', 'rehub_framework' ) . '</span>', $post, $product );  
								                }                 
								                ?>
								                <?php echo $sales_html; ?>
								            <?php endif; ?>                                        
                                            <a href="<?php the_permalink();?>">
                								<?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'thumb'=> true, 'crop'=> false, 'height'=> 150, 'no_thumb_url' => rehub_woocommerce_placeholder_img_src('')));?>
                                            </a>
                                        </figure>
                                        <h2>
                                            <a href="<?php the_permalink();?>">
                                                <?php echo the_title();?>                     
                                            </a>
                                        </h2>
                                        <div class="price-in-compare-flip mt20">
                                         
                                            <?php if ($product->get_price() !='') : ?>
                                                <span class="price-woo-compare-chart rehub-main-font"><?php echo $product->get_price_html(); ?></span>
                                                <div class="mb10"></div>
                                            <?php endif;?>
							                <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
							                    <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
							                        sprintf( '<a href="%s" data-product_id="%s" data-product_sku="%s" class="re_track_btn btn_offer_block btn-woo-compare-chart woo_loop_btn %s %s product_type_%s"%s%s>%s</a>',
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
                                    		<?php if ( defined( 'YITH_WCWL' )){ ?>
                                    		    <div class="yith_woo_chart"> 
                									<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                								</div> 
            								<?php } ?>                     
                                        </div>                                              
                                    </div>
                                </li> 
                                <li class="row_chart_1 heading_row_chart">
                                </li>                               
                                <li class="row_chart_2 meta_value_row_chart">
                                	<?php the_excerpt();?>
                                </li>
                                <li class="row_chart_3 meta_value_row_chart">
                                    <?php if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes'):?>
                                    	<?php $avg_rate_score 	= number_format( $product->get_average_rating(), 1 ) * 20 ;?>
                                    	<?php if ($avg_rate_score):?>
	                                    	<div class="rev-in-woocompare">
	                                    		<div class="star-big"><span class="stars-rate"><span style="width: <?php echo $avg_rate_score;?>%;"></span></span></div>
	                                    	</div>
                                    	<?php else:?>
                                    		-
                                    	<?php endif;?>
                                    <?php else:?>
                                    		-
                                    <?php endif;?>
                                </li>                                  
                                <li class="row_chart_4 meta_value_row_chart">
                                	<?php echo get_post_meta($post->ID, '_sku', true)?>
                                </li> 
                                <li class="row_chart_5 meta_value_row_chart">
                                	<?php WPSM_Woohelper::re_show_brand_tax(); //show brand taxonomy?>
                                </li> 
                                <li class="row_chart_6 meta_value_row_chart">
					                <?php if (class_exists('WCV_Vendor_Shop')) :?>
					                    <?php if(method_exists('WCV_Vendor_Shop', 'template_loop_sold_by')) :?>
					                        <span class="woolist_vendor"><?php WCV_Vendor_Shop::template_loop_sold_by(get_the_ID()); ?></span>
					                    <?php endif;?>
					                <?php else:?>
					                	<?php echo get_bloginfo( 'name' );?>
					                <?php endif;?>
                                </li>                                                               
                                <li class="row_chart_7 meta_value_row_chart">
                                	<?php if ( $product->is_in_stock() ):?>
										<span class="greencolor"><?php _e( 'In stock', 'rehub_framework' ) ;?></span>
									<?php else :?>
										<span class="redcolor"><?php _e( 'Out of stock', 'rehub_framework' ) ;?></span>
									<?php endif;?>
                                </li>
                                <?php if(!empty($common_attributes)):?>                                
	                                <li class="row_chart_8 heading_row_chart">
	                                </li>                                                               
			                        <?php $i = 8; foreach($common_attributes as $attkey => $attribute):?>
			                            <?php $i++;?>
			                            <li class="row_chart_<?php echo $i;?> meta_value_row_chart">
											<?php
												if ( $attribute['is_taxonomy'] ) {
													$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
													if(!empty($values)){
														echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );	
													}
												} else {	
													$customattributes = $product->get_attributes();
													$custom_attribute_array = wp_list_pluck($customattributes, 'value', 'name' );
													// Convert pipes to commas and display values
													$values = array_map( 'trim', explode( WC_DELIMITER, $custom_attribute_array[$attkey] ) );
													if(!empty($values)){
														echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
													}
												}
											?>
			                            </li>
			                        <?php endforeach;?> 
			                    <?php else:?>
			                    	<?php $i = 7;?>
		                        <?php endif;?>                                                              
			            </ul>
			            </div>
			        <?php endwhile; ?>
		    	</div></div>
		    	<span class="top_chart_row_found" data-rowcount="<?php echo ($i + 1);?>"></span>
		    </div>
		    <?php else: ?><?php _e('No posts for this criteria.', 'rehub_framework'); ?>
		    <?php endif; ?>
		    <?php wp_reset_query(); ?>

		<?php 
		$output = ob_get_contents();
		ob_end_clean();
		return $output;   
	endif;	

}
add_shortcode('wpsm_woocharts', 'wpsm_woocharts_shortcode');
}


//////////////////////////////////////////////////////////////////
// Categorizator
//////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_multi_cat', 'ajax_action_multi_cat' );
add_action( 'wp_ajax_nopriv_multi_cat', 'ajax_action_multi_cat' );
if( !function_exists('ajax_action_multi_cat') ) {
function ajax_action_multi_cat() {
	$nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajaxed-nonce' ) )
        die ( 'Nope!' );   
		$data = $_POST;

		$page = intval($data['page']);
		$paged = ($page) ? $page : 1;
		ob_start();
		$query_args = array(
			'paged' => $paged,
			'post_type' => 'post',
			'posts_per_page' => 5,
			'tax_query' => array(
				array(
					'taxonomy' => $data['tax'],
					'field' => 'id',
					'terms' => $data['term']
				)
			),
		);
		$query = new WP_Query($query_args);
		$response = '';
		if ( $query->have_posts() ) {
			while ($query->have_posts() ) {
				$query->the_post();
				ob_start();
				get_template_part( 'content', 'multi_category' );
				$response .= ob_get_clean();
			}
			wp_reset_postdata();
		} else {
			$response = 'fail';
		}

		echo $response ;
		exit;
}
}

if( !function_exists('wpsm_categorizator_shortcode') ) {
function wpsm_categorizator_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
			'tax' => 'category',
			'exclude' => '',
			'include' => '',
			'col' => '3'
		), $atts));
        
    $args = array(
    	'taxonomy'=> $tax,
        'orderby' => 'name',
		'exclude' => explode(',', $exclude),
		'include' => explode(',', $include),
    );
    $terms = get_terms($args );

	ob_start(); 
    ?>

    <?php
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            if ($col == '4') {
            	echo '<div class="col_wrap_fourth">';
            }
            elseif ($col == '2') {
            	echo '<div class="col_wrap_two">';
            }  
            elseif ($col == '1') {
            	echo '<div class="alignleft multicatleft">';
            }                       
            else {echo '<div class="col_wrap_three">'; }
            $i = 1;
            foreach ($terms as $term) {
                $query_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $term->taxonomy,
                            'field' => 'id',
                            'terms' => $term->term_id
                        )
                    ),
                );

                $query = new WP_Query($query_args);

                if ( $query->have_posts() ) :
                    ?>

                    <div id="directory-<?php echo $term->term_id; ?>" class="multi_cat col_item"
                         data-tax="<?php echo $term->taxonomy; ?>"
                         data-term="<?php echo $term->term_id; ?>">
                        <div class="multi_cat_header">
							<div class="multi_cat_lable">
								<?php echo $term->name; ?>
							</div>
                        </div>
                        <div class="multi_cat_wrap eq_height_post">

                            <?php while ($query->have_posts() ) :
                                $query->the_post();
                                get_template_part( 'content', 'multi_category' );
                            endwhile; wp_reset_postdata(); ?>

                        </div>
                        <div class="cat-pagination multi_cat_header clearfix">

                            <?php for ($j = 1, $max_count = $query->max_num_pages; $j<= $max_count;  $j++) : ?>
                                <?php $active = ($j ===1) ? 'active' : '' ;?>
                                <a class="styled <?php echo $active; ?>" data-paginated="<?php echo $j; ?>"><?php echo $j;?></a>
                            <?php endfor; ?>

                        </div>
                    </div>

                    <?php $i++;
                    
                endif;
            }
            echo '</div>';
        }   
    ?>

	<?php 
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('wpsm_categorizator', 'wpsm_categorizator_shortcode');
}

//////////////////////////////////////////////////////////////////
// Cartbox
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_cartbox_shortcode') ) {
function wpsm_cartbox_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'title' => '',
			'link' => '',
			'description' => '',
			'image' => '',
			'bg_contain' =>'',
			'revert_image' =>''
		), $atts));

	if (is_numeric($image)) {$image = wp_get_attachment_url( $image);}
	$bg_contain = ($bg_contain) ? 'background-size: contain;' : '';
	$output = '<div class="categoriesbox">';
	if ($revert_image) :
		if ($image) :
			$output .= '<div class="categoriesbox-bg" style="background-image: url('.$image.');'.$bg_contain.'">';	
			if ($link) : 
				$output .= '<a href="'.esc_url($link).'"></a>';
			endif;
			$output .= '</div>';	
		endif;		
	endif;
	$output .='<div class="categoriesbox-content">';
	if ($title) :
		$output .= '<h3>';
		if ($link) : 
			$output .= '<a href="'.esc_url($link).'">';
		endif;
			$output .= $title;	
		if ($link) : 
			$output .= '</a>';
		endif;
		$output .= '</h3>';		
	endif;
	if ($description) :
		$output .= '<p>'.$description.'</p>';		
	endif;	
	$output .= '</div>';
	if ($revert_image =='' || $revert_image =='0') :
		if ($image) :
			$output .= '<div class="categoriesbox-bg" style="background-image: url('.$image.');'.$bg_contain.'">';	
			if ($link) : 
				$output .= '<a href="'.esc_url($link).'"></a>';
			endif;
			$output .= '</div>';	
		endif;
	endif;
	$output .= '</div>';
	return $output;
}
add_shortcode('wpsm_cartbox', 'wpsm_cartbox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Score box
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_scorebox_shortcode') ) {
function wpsm_scorebox_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'criterias' => 'editor',
			'simplestar' => '',
			'offerbtn' => 'yes',
			'id' => '',
			'title'=> '',
			'proscons' => '',
			'prostitle' => 'PROS:',
			'constitle' => 'CONS:',
			'ce_enable'=> '',
		), $atts));

	ob_start(); 
    ?>

	<?php if(isset($atts['id']) && $atts['id']) :?>		
		<?php $revid = $atts['id'];?>
	<?php else :?>   
		<?php if (!is_single() || is_front_page()) {return; } ?>
    	<?php $revid = get_the_ID();?>
    <?php endif ;?>  
	<?php if(isset($atts['title']) && $atts['title']) :?>		
		<?php $title = $atts['title'];?>
	<?php else :?>   
    	<?php $title = __('Average Score', 'rehub_framework');?>
    <?php endif ;?>


    <?php $args = array('no_found_rows' => 1,'p' => $revid); $query = new WP_Query($args);?>
    <?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post(); global $post; ?>
    	<div class="wpsm_score_box">    
			<?php if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review') :?>
		    	<?php $overal_score = rehub_get_overall_score(); 
		    	if($overal_score !='0') :?>	    	
		    		<div class="wpsm_score_title">
		    			<span class="overall-text"><?php echo $title; ?></span>
		    			<span class="overall-score"><?php echo round($overal_score, 1) ?></span>
		    		</div>
		    		<div class="wpsm_inside_scorebox">
		    			<?php if ($simplestar == 'yes') :?><div class="rating_bar"><?php echo rehub_get_user_rate() ; ?></div><?php endif ;?>
			    		<?php if ($criterias == 'editor' || $criterias == 'both') :?>
			    			<?php $thecriteria = vp_metabox('rehub_post.review_post.0.review_post_criteria'); $firstcriteria = $thecriteria[0]['review_post_name']; ?>
				    		<?php if($firstcriteria) : ?>
				    		<div class="rate_bar_wrap">
								<div class="review-criteria">
									<?php foreach ($thecriteria as $criteria) { ?>
										<?php $perc_criteria = $criteria['review_post_score']*10; ?>
										<div class="rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
											<div class="rate-bar-title"><span><?php echo $criteria['review_post_name']; ?></span></div>
											<div class="rate-bar-bar r_score_<?php echo round($criteria['review_post_score']); ?>"></div>
											<div class="rate-bar-percent"><?php echo $criteria['review_post_score']; ?></div>
										</div>
									<?php } ?>
								</div>
							</div>
							<?php endif; ?>
			    		<?php endif ;?>	
			    		<?php if ($criterias == 'user' || $criterias == 'both') :?>
			    			<?php $postAverage = get_post_meta(get_the_ID(), 'post_user_average', true); ?>
				    		<?php if($postAverage !='0' && $postAverage !='') : ?>
							<div class="rate_bar_wrap">	
								<?php $user_rates = get_post_meta(get_the_ID(), 'post_user_raitings', true); $usercriterias = $user_rates['criteria'];  ?>
								<div class="review-criteria user-review-criteria">
									<div class="r_criteria">
										<?php foreach ($usercriterias as $usercriteria) { ?>
										<?php $perc_criteria = $usercriteria['average']*10; ?>
										<div class="rate-bar user-rate-bar clearfix" data-percent="<?php echo $perc_criteria; ?>%">
											<div class="rate-bar-title"><span><?php echo $usercriteria['name']; ?></span></div>
											<div class="rate-bar-bar r_score_<?php echo round($usercriteria['average']); ?>"></div>
											<div class="rate-bar-percent"><?php echo $usercriteria['average']; ?></div>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<?php endif; ?>
			    		<?php endif ;?>	
						<?php if($proscons):?>
							<?php 	
						    	$prosvalues = vp_metabox('rehub_post.review_post.0.review_post_pros_text');	
								$consvalues = vp_metabox('rehub_post.review_post.0.review_post_cons_text');
							?> 
							<!-- PROS CONS BLOCK-->
							<div class="prosconswidget">
							<?php if(!empty($prosvalues)):?>
								<div class="wpsm_pros mb30 mt10">
									<div class="title_pros"><?php echo $prostitle;?></div>
									<ul>		
										<?php $prosvalues = explode(PHP_EOL, $prosvalues);?>
										<?php foreach ($prosvalues as $prosvalue) {
											echo '<li>'.$prosvalue.'</li>';
										}?>
									</ul>
								</div>
							<?php endif;?>	
							<?php if(!empty($consvalues)):?>
								<div class="wpsm_cons">
									<div class="title_cons"><?php echo $constitle;?></div>
									<ul>
										<?php $consvalues = explode(PHP_EOL, $consvalues);?>
										<?php foreach ($consvalues as $consvalue) {
											echo '<li>'.$consvalue.'</li>';
										}?>
									</ul>
								</div>
							<?php endif;?>
							</div>	
							<!-- PROS CONS BLOCK END-->
						<?php endif;?>		    		    		
			    		<?php if ($offerbtn=="yes") :?>
			    			<?php $multiofferrows = get_post_meta($post->ID, 'rehub_multioffer_group', true);?>
			    			<?php if (!empty($multiofferrows[0]['multioffer_url'])) :?>
			    				<div class="btn_score_btm rh_deal_block">
			    				<?php foreach ($multiofferrows as $key => $value):?>
			    					<?php 
			    						$brand_image_url = $brand_link = $brandtermname = $brandterm = '';
			    						$offer_post_url = (!empty($value['multioffer_url'])) ? $value['multioffer_url'] : '';
										$offer_url = apply_filters('rh_post_multioffer_url_filter', $offer_post_url );
										$offer_price = (!empty($value['multioffer_price'])) ? $value['multioffer_price'] : '';
										$offer_price_old = (!empty($value['multioffer_price_old'])) ? $value['multioffer_price_old'] : '';
										$offer_btn_text = (!empty($value['multioffer_btn_text'])) ? $value['multioffer_btn_text'] : '';	
										$offer_title = (!empty($value['multioffer_name'])) ? $value['multioffer_name'] : '';
										$offer_badge = (!empty($value['featured_multioffer'])) ? $value['featured_multioffer'] : '';
										$offer_user = (!empty($value['multioffer_user'])) ? $value['multioffer_user'] : '';
										$offer_brand = (!empty($value['multioffer_brand'])) ? $value['multioffer_brand'] : '';	
										$offer_coupon = (!empty($value['multioffer_coupon'])) ? $value['multioffer_coupon'] : '';
										if($offer_brand){
											$brandterm = get_term((int)$offer_brand);
											if(!empty($brandterm) && !is_wp_error($brandterm )){
												$brand_image_url = get_term_meta((int)$offer_brand, 'brandimage', true );
									        	$brand_link = get_term_link((int)$offer_brand );
									        	$brandtermname = $brandterm->name;
											}
										}																									
									?>
									<?php $featured_class = ($offer_badge) ? ' featured_multioffer' : ''; ?>
									<div class="deal_block_row">
										<div class="rh-deal-details-noimage">
												<?php if(!empty($offer_coupon)) : ?>
													<div class="redemptionText"><?php _e('Use Coupon Code:', 'rehub_framework');?><span class="code"><?php echo $offer_coupon ?></span></div>	
											  	<?php endif;?>									            
											<div class="rh-deal-pricetable">
												<div class="rh-deal-left">
													<div class="rh-deal-name"><h5><a href="<?php echo esc_url($offer_url); ?>"><?php echo $offer_title;?></a></h5></div>
									                <?php if ($brand_link):?>
									                	<div class="rh-deal-brandlogo">
								                        <a class="retailer_multioffer" href="<?php echo $brand_link ?>">
									                        <?php if($brand_image_url) :?>
	            												<?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'src'=> $brand_image_url, 'crop'=> false, 'width'=> 70, 'height'=> 70));?>
	            											<?php else:?>
	            												<?php echo $brandtermname; ?>
	            											<?php endif;?>
	        											</a>
	        											</div>
	        										<?php else:?>
	        											<div class="mb10 font90">
	        											<?php echo rehub_get_site_favicon(esc_url($offer_url)); ?>
	        											</div>
									                <?php endif;?>														
													<div class="rh-deal-tag">												
										                <?php if ($offer_user):?>
										                    <span>
										                        <?php _e('Posted by:', 'rehub_framework');?>
										                        <?php if ( class_exists( 'BuddyPress' ) ):?>
										                             <a class="admin" href="<?php echo bp_core_get_user_domain( $offer_user ) ?>"><?php the_author_meta( 'display_name', $offer_user ); ?>
										                             </a>
										                        <?php else:?>
										                             <a class="admin" href="<?php echo get_author_posts_url( $offer_user ) ?>"><?php the_author_meta( 'display_name', $offer_user ); ?>
										                             </a>
										                        <?php endif;?>
										                    </span>
										                <?php endif;?> 							
													</div>
												</div>
												<div class="rh-deal-right">
													<?php if(!empty($offer_price)) : ?>
							                            <div class="rh-deal-price">
							                                <ins><?php echo $offer_price ?></ins>
							                                <?php if(!empty($offer_price_old)) : ?>
								                                <del>
								                                    <?php echo $offer_price_old ?>
								                                </del>
							                                <?php endif ;?>                                
							                            </div>
							                        <?php endif ;?>
													<div class="rh-deal-btn">
										                <a href="<?php echo $offer_url ?>" class="re_track_btn rh-deal-compact-btn btn_offer_block" target="_blank" rel="nofollow">
										                    <?php if($offer_btn_text !='') :?>
										                        <?php echo $offer_btn_text ; ?>
										                    <?php elseif(rehub_option('rehub_btn_text') !='') :?>
										                        <?php echo rehub_option('rehub_btn_text') ; ?>
										                    <?php else :?>
										                        <?php _e('Buy Now', 'rehub_framework') ?>
										                    <?php endif ;?>
										                </a>	            					
													</div>						
												</div>					
											</div>
										</div>
									</div>								
			    				<?php endforeach;?>
			    				</div>
			    			<?php else:?>
				    			<div class="btn_score_btm">
				    				<?php rehub_create_btn('no')?>
				    				<div class="centered_brand_logo">
				    				<?php WPSM_Postfilters::re_show_brand_tax('logo'); //show brand logo?>
				    				</div>
				    			</div>
			    			<?php endif ;?>
			    		<?php endif ;?>
		    		</div>
		    	<?php endif;?>	    	
		    <?php endif;?>
    		<?php if ($ce_enable) :?>
    			<div class="wpsm_inside_scorebox">
	                <?php
	                    $cegg_field_array = rehub_option('save_meta_for_ce');
	                    $cegg_fields = array();
	                    if (!empty($cegg_field_array) && is_array($cegg_field_array)) {
	                        foreach ($cegg_field_array as $cegg_field) {
	                            $cegg_field_value = get_post_meta ($post->ID, '_cegg_data_'.$cegg_field.'', true);
	                            if (!empty ($cegg_field_value) && is_array($cegg_field_value)) {
	                                $cegg_fields[$cegg_field]= $cegg_field_value;
	                            }       
	                        }		                        
	                        if (!empty($cegg_fields) && is_array($cegg_fields)) {
								$all_items = array(); 
							    foreach ($cegg_fields as $module_id => $items) {
							        foreach ($items as $item_ar) {
							            $item_ar['module_id'] = $module_id;
							            $all_items[] = $item_ar;

							        }       
							    }		                        	
	                        	?>
				    			<div class="btn_score_btm rh_deal_block">		                        	
		                        	<?php foreach ($all_items as $key => $item) :?>
		                        		<?php                             
		                        			$currency_code = (!empty($item['currencyCode'])) ? $item['currencyCode'] : '';                                
	                        				$offer_price = (!empty($item['price'])) ? RhPriceTemplateHelper::formatPriceCurrency($item['price'], $currency_code) : '';
	                        				$offer_price_old = (!empty($item['priceOld'])) ? RhPriceTemplateHelper::formatPriceCurrency($item['priceOld'], $currency_code) : '';    
	                        				$offer_title = (!empty($item['title'])) ? $item['title'] : '';
	                        				$offer_post_url = (!empty($item['url'])) ? $item['url'] : '';
	                        				$offer_url = apply_filters('rh_post_multioffer_url_filter', $offer_post_url );
	                        			?>
								        <?php if (!empty($item['domain'])):?>
								            <?php $domain = $item['domain'];?>
								        <?php elseif (!empty($item['extra']['domain'])):?>
								            <?php $domain = $item['extra']['domain'];?>
								        <?php else:?>
								            <?php $domain = '';?>        
								        <?php endif;?>  	                            			
	                        			<?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
								        <?php if (!empty($item['logo'])) :?>
								            <?php $logo = $item['logo']; ?>	
								        <?php elseif (!empty($item['extra']['logo'])) :?>
								            <?php $logo = $item['extra']['logo']; ?>
								        <?php elseif (!empty($item['extra']['MerchantLogoURL'])) :?>
								            <?php $logo = $item['extra']['MerchantLogoURL']; ?>
								        <?php elseif (!empty($item['extra']['programLogo'])) :?>
								            <?php $logo = $item['extra']['programLogo']; ?>                         
								        <?php elseif(isset($item['module_id']) && $item['module_id'] =='Amazon') :?>
								            <?php $logo = get_template_directory_uri().'/images/logos/amazon.png' ;?>
								        <?php elseif(isset($item['module_id']) && $item['module_id'] =='Aliexpress') :?>
								            <?php $logo = get_template_directory_uri().'/images/logos/aliexpress.png' ;?> 
								        <?php elseif(isset($item['module_id']) && $item['module_id'] =='Ebay') :?>
								            <?php $logo = get_template_directory_uri().'/images/logos/ebay.png' ;?> 
								        <?php elseif(isset($item['module_id']) && $item['module_id'] =='Flipkart') :?>
								            <?php $logo = get_template_directory_uri().'/images/logos/flipkart.png' ;?>  
								        <?php elseif(isset($item['module_id']) && $item['module_id'] =='PayTM') :?>
								            <?php $logo = get_template_directory_uri().'/images/logos/paytm.jpg' ;?>
								        <?php elseif(isset($item['module_id']) && !empty($domain)) :?>
								                <?php $logo = rh_ae_logo_get('http://'.$domain); ?>         
								        <?php else :?>
								            <?php $logo = ''; ?>
								        <?php endif;?>
										<div class="deal_block_row">									
											<div class="rh-deal-pricetable">
												<div class="rh-deal-left">
													<div class="rh-deal-name">
														<h5><a href="<?php echo esc_url($offer_url); ?>"><?php echo $offer_title;?></a></h5>
													</div>
									                <?php if ($logo):?>
									                	<div class="rh-deal-brandlogo">
	            											<?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> false, 'src'=> $logo, 'crop'=> false, 'width'=> 70, 'height'=> 70));?>
	        											</div>
	        										<?php elseif ($merchant):?>
	        											<div class="rh-deal-tag">
	        												<span><?php echo $merchant;?></span>
	        											</div>
									                <?php endif;?>
												</div>
												<div class="rh-deal-right">
													<?php if(!empty($offer_price)) : ?>
							                            <div class="rh-deal-price">
							                                <ins><?php echo $offer_price ?></ins>
							                                <?php if(!empty($offer_price_old)) : ?>
								                                <del>
								                                    <?php echo $offer_price_old ?>
								                                </del>
							                                <?php endif ;?>                                
							                            </div>
							                        <?php endif ;?>
													<div class="rh-deal-btn">
										                <a href="<?php echo $offer_url ?>" class="re_track_btn rh-deal-compact-btn btn_offer_block" target="_blank" rel="nofollow">
										                    <?php if(rehub_option('rehub_btn_text') !='') :?>
										                        <?php echo rehub_option('rehub_btn_text') ; ?>
										                    <?php else :?>
										                        <?php _e('Buy Now', 'rehub_framework') ?>
										                    <?php endif ;?>
										                </a>	            					
													</div>						
												</div>					
											</div>
										</div>                             			
		                        	<?php endforeach;?>
		                        </div>
	                        	<?php
	                        }
	                    }
	                ?>	    		
				</div>
			<?php endif ;?>		    
	    </div>
    <?php endwhile; endif; wp_reset_postdata(); ?>

    <?php 
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode('wpsm_scorebox', 'wpsm_scorebox_shortcode');
}

//////////////////////////////////////////////////////////////////
// Reveal shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_reveal_shortcode') ) {
function wpsm_reveal_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
		'textcode' => '',
		'btntext' => '',
		'url' => '',
	), $atts));
wp_enqueue_script('affegg_coupons');
wp_enqueue_script('zeroclipboard');

$output = '<div class="rehub_offer_coupon free_coupon_width masked_coupon" data-clipboard-text="'.rawurlencode(esc_html($textcode)).'" data-codetext="'.rawurlencode(esc_html($textcode)).'" data-dest="'.esc_url($url).'">';
if($btntext !='') :
	$output .=esc_html($btntext);
else :
	$output .= __('Reveal', 'rehub_framework');
endif;
	$output .='<i class="fa fa-external-link-square"></i></div>';
return $output;
}
add_shortcode('wpsm_reveal', 'wpsm_reveal_shortcode');
} 


//////////////////////////////////////////////////////////////////
// User login/register link with popup
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_user_modal') ) {
function wpsm_user_modal_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'wrap' => 'span',
	'as_btn' => '',
	'class' => '',
	'loginurl' => '',		
), $atts));
$as_button = (!empty($as_btn)) ? ' wpsm-button white medium ' : '';
$class_show = (!empty($class)) ? ' '.$class.'' : '';
$output='';
if (is_user_logged_in()) {
	global $current_user;
	$notice_bp_number = $notification_bp_item = '';
	$user_id  = get_current_user_id();
	$current_user = wp_get_current_user();
	$profile_url  = rehub_option('userlogin_profile_page');
	$sumbit_url = rehub_option('userlogin_submit_page');
	$edit_url = rehub_option('userlogin_edit_page');
	$mycredpoint = ( function_exists( 'mycred_get_users_fcred' ) ) ? mycred_get_users_fcred($user_id) : '';    
	if ( function_exists('bp_notifications_get_notifications_for_user')) {
		$notifications = bp_notifications_get_notifications_for_user($user_id, 'object');
		$notification_bp_item .='<li class="bp-profile-edit-menu-item menu-item"><a href="'.bp_core_get_user_domain( $user_id ).'"><i class="fa fa-cogs"></i></i><span>'. __("Edit Profile", "rehub_framework") .'</span></a></li>';		
		if (!empty($notifications)){
			$notice_bp_number = count($notifications);
			$notice_number = 0;
			foreach ((array)$notifications as $notification) {
				$notice_number ++;
				$notification_bp_item .= '<li id="bp-profile-menu-note-'.$notification->id.'" class="bp-profile-menu-item menu-item bppmi_'.$notice_number.' bp-profile-menu-'.$notification->component_action.'"><a href="'.$notification->href.'">'.$notification->content.'</a></li>';
			}			
		}
	}	

	$output .= '<div class="user-dropdown-intop'.$class_show.'">';
	if (!empty($notice_bp_number)){
		$output .='<span class="rh_bp_notice_profile">'.$notice_bp_number.'</span>';
	}
    $output .= '<span class="user-ava-intop">'.get_avatar( $user_id, 22 ).'</span>';
    $output .= '<ul class="user-dropdown-intop-menu">';
        $output .= '<li class="user-name-and-badges-intop"><span class="user-image-in-name">'.get_avatar( $user_id, 35 ).'</span>';
        $output .=$current_user->display_name;
        if(function_exists('bp_get_member_type')){
			$membertype = bp_get_member_type($user_id);
			$membertype_object = bp_get_member_type_object($membertype);
			$membertype_label = (!empty($membertype_object) && is_object($membertype_object)) ? $membertype_object->labels['singular_name'] : '';        	
        	$output .='<br /><span class="rh_user_s2_label">'.$membertype_label.'</span>';
        }        
        if (!empty($mycredpoint)){
        	$output .='<br /><i class="fa fa-star-o"></i> '.$mycredpoint.'';
        }
        $output .= '</li>';
        if ($profile_url) :
        	$output .= '<li class="user-profile-link-intop menu-item"><a href="'. esc_url(get_the_permalink($profile_url)) .'"><i class="fa fa-user"></i><span>'. __("My profile", "rehub_framework") .'</span></a></li>';
        endif;
        if ($sumbit_url) :
        	$output .= '<li class="user-addsome-link-intop menu-item"><a href="'. esc_url(get_the_permalink($sumbit_url)) .'"><i class="fa fa-cloud-upload"></i><span>'. __("Submit a Post", "rehub_framework") .'</span></a></li>';
        endif; 
        if ($edit_url) :
        	$output .= '<li class="user-editposts-link-intop menu-item"><a href="'. esc_url(get_the_permalink($edit_url)) .'"><i class="fa fa-pencil"></i><span>'. __("Edit My Posts", "rehub_framework") .'</span></a></li>';
        endif;  
        if (defined('wcv_plugin_dir')) :
		    if (class_exists('WCV_Vendors') && class_exists('WCVendors_Pro') && WCV_Vendors::is_vendor($user_id) ) {
		        $redirect_to = get_permalink(WCVendors_Pro::get_option( 'dashboard_page_id' ));
		    }
		    elseif (class_exists('WCV_Vendors') && WCV_Vendors::is_vendor($user_id) ) {
		    	$redirect_to = get_permalink(WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' ));
		    }
        	if (!empty($redirect_to)){
	        	$output .= '<li class="user-editshop-link-intop menu-item"><a href="'. esc_url($redirect_to) .'"><i class="fa fa-shopping-bag" aria-hidden="true"></i><span>'. __("Manage Your Shop", "rehub_framework") .'</span></a></li>';        	
        	}
        endif;                            
        if(has_nav_menu('user_logged_in_menu')):
        	$output .= wp_nav_menu( array( 'theme_location' => 'user_logged_in_menu','menu_class' => '','container' => false,'depth' => 1,'items_wrap'=> '%3$s', 'echo' => false ) );
        endif;
        $output .=$notification_bp_item;
        $output .= '<li class="user-logout-link-intop menu-item"><a href="'. wp_logout_url( home_url()) .'"><i class="fa fa-lock"></i><span>'. __("Log out", "rehub_framework") .'</span></a></li>';
$output .= '</ul></div>';
} else {
	if(get_option('users_can_register')) :
		if (empty ($loginurl)):
			if ($wrap =='a'):
				$output .= '<a class="act-rehub-login-popup menu-item-one-line'.$as_button.$class_show.'" data-type="login" href="#"><i class="fa fa-sign-in"></i><span>'.__("Login / Register", "rehub_framework").'</span></a>';
			else:
				$output .= '<span class="act-rehub-login-popup'.$as_button.$class_show.'" data-type="login"><i class="fa fa-sign-in"></i><span>'.__("Login / Register", "rehub_framework").'</span></span>';
			endif;
		else:
			$output .= '<span class="act-rehub-login-popup'.$as_button.$class_show.'" data-type="url" data-customurl="'.esc_url($loginurl).'"><i class="fa fa-sign-in"></i><span>'.__("Login / Register", "rehub_framework").'</span></span>';
		endif;
	else:
		$output .= '<a class="act-rehub-login-popup'.$as_button.$class_show.'" data-type="restrict" href="#"><i class="fa fa-sign-in"></i><span>'.__("Login / Register is disabled", "rehub_framework").'</span></a>';
	endif;	
	
}

return $output;

}
add_shortcode('wpsm_user_modal', 'wpsm_user_modal_shortcode');
}

//////////////////////////////////////////////////////////////////
// Search form
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_searchform_shortcode') ) {
function wpsm_searchform_shortcode( $atts, $content = null ) {
extract(shortcode_atts(array(
	'class' => '',		
), $atts));

return '<div class="'.$class.'">'.get_search_form(false).'</div>';

}
add_shortcode('wpsm_searchform', 'wpsm_searchform_shortcode');
}

//////////////////////////////////////////////////////////////////
// Link hide
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_hidelink_shortcode') ) {
function wpsm_hidelink_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
			'text' => 'Click here',
			'link' => '',
	), $atts));

	$output = '<span class="ext-source" data-dest="'.$link.'">'.$text.'</span>';
	return $output;
}
add_shortcode('wpsm_hidelink', 'wpsm_hidelink_shortcode');
}


//////////////////////////////////////////////////////////////////
// Compare Buttons
//////////////////////////////////////////////////////////////////

if( !function_exists('wpsm_comparison_button') ) {
function wpsm_comparison_button( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'color' => 'white',
				'size' => 'small',
				'cats' => '',
				'class' => '',
				'id' => '',
			), $atts);
	$postid = (!empty($atts['id'])) ? $atts['id'] : get_the_ID(); 
	$multicats_on = rehub_option('compare_multicats_toggle');
	$singlecat_on = rehub_option('compare_page');
	if($multicats_on == '' && $singlecat_on == '') return;	
	if (isset ($atts['cats']) && !empty($atts['cats'])) : //Check if button is not in category
		$cats_array = explode (',', $atts['cats']);
		if (!in_category ($cats_array)) return;
	endif;     
    $class_show = (!empty($atts['class'])) ? ' '.$atts['class'].'' : '';
	$ip = rehub_get_ip();
	$userid = get_current_user_id();
	$userid = empty($userid) ? $ip : $userid;

	if ($multicats_on =='1'){
		$multicats_array = rehub_get_compare_multicats();
	}
	$post_ids_arr = array();
	
	if($multicats_on =='1' && !empty($multicats_array)) {
		foreach( $multicats_array as $multicat ){
			$page_id = (int)$multicat[2];
			$post_ids_arr[] = get_transient('re_compare_'. $page_id .'_' . $userid);
		}
		$post_ids = implode(',', $post_ids_arr);
	} else {
		$post_ids = get_transient('re_compare_' . $userid);
	}
	
	if(!empty($post_ids)) {
		$post_ids_arr = explode(',', $post_ids);
	}

	$compare_active = ( in_array( $postid, $post_ids_arr ) ) ? ' comparing' : ' not-incompare';
	
	$out = '<span';   
    $out .=' class="wpsm-button wpsm-button-new-compare addcompare-id-'.$postid.' '.$atts['color'].' '.$atts['size'].''.$compare_active.$class_show.'" data-addcompare-id="'.$postid.'"><i class="fa re-icon-compare"></i>'.__("Add to compare", "rehub_framework").'</span>';
    return $out;
}
add_shortcode('wpsm_compare_button', 'wpsm_comparison_button');
}

//////////////////////////////////////////////////////////////////
// Icecat shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_icecat_shortcode') ) {
function wpsm_icecat_shortcode( $atts, $content = null ) {
        $atts = shortcode_atts(
			array(
				'ean' => '',
				'language' => '',
				'username' => 'openIcecat-xml',
				'password' => 'freeaccess'
			), $atts);
    $data = array();
    $data['language'] = (!empty($atts['language'])) ? $atts['language'] : substr(get_locale(), 0, 2);
    $data['username'] = (!empty($atts['username'])) ? $atts['username'] : 'openIcecat-xml';
    $data['password'] = (!empty($atts['password'])) ? $atts['password'] : 'freeaccess';    
    $out = '';

    if (isset($atts['ean']) && $atts['ean']!='') :
        $data['ean'] = $atts['ean'];
        include(rh_locate_template('functions/icecat.php'));
        $data = icecat_to_array($data); 
    	if(!isset($data['id'])) :
            if(isset($data[1])) :
                $out .= '<div style="display:none">Error: '.$data[1].'</div>';
         
            elseif(isset($data[2])) :
                $out .= '<div style="display:none">Error: '.$data[2].'</div>';
            elseif(isset($data[3])) :
                $out .= '<div style="display:none">Error: '.$data[3].'</div>';
            endif;
    	else :
        	$out .='<div class="wpsm-table wpsm-icecat-spec">';       
	            $out .='<table>';
	                foreach($data['spec'] as $id=>$s):
	                    $out .='<tr class="heading-th-spec">';
	                        $out .='<th colspan="2">'.$s['name'].'</th>';
	                    $out .='</tr>';
	                    	$i = 0;
	                    	foreach($s['features'] as $id=>$f):
	                    	$i++; $odd = ($i % 2 == 1) ? ' class="odd"' : '';
	                        $out .='<tr'.$odd.'>';
	                            $out .='<td>'.$f['name'].'</td>';
	                            $out .='<td>'.$f['pres_value'].'</td>';
	                        $out .='</tr>';
	                    	endforeach;
	                endforeach;
	            $out .='</table>'; 
        	$out .='</div>';                    
    	endif;            
    endif;   
    return $out;
}
add_shortcode('wpsm_icecat', 'wpsm_icecat_shortcode');
}

//////////////////////////////////////////////////////////////////
// Login form shortcode
//////////////////////////////////////////////////////////////////
if(!function_exists('wpsm_login_page')) {
function wpsm_login_page( $atts, $content = null ) {
	ob_start(); 
	rehub_login_form();
	$output = ob_get_contents();
	ob_end_clean();
	return $output; 
}
add_shortcode('wpsm_login_form', 'wpsm_login_page');
}

//////////////////////////////////////////////////////////////////
// Get custom value shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_get_custom_value') ) {
function wpsm_get_custom_value($atts){
     extract(shortcode_atts(array(
                  'post_id' => NULL,
                  'field' => NULL,
               ), $atts));
  if(!isset($atts['field'])) return;
       $field = esc_attr($atts['field']);
       global $post;
       $post_id = (NULL === $post_id) ? $post->ID : $post_id;
       return get_post_meta($post_id, $field, true);
}
add_shortcode('wpsm_custom_meta', 'wpsm_get_custom_value');
}

//////////////////////////////////////////////////////////////////
// Alphabet Catalog Shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_tax_archive_shortcode') ) {
function wpsm_tax_archive_shortcode( $atts, $content = null ) {
	// Attributes
	extract( shortcode_atts(
		array(
			'type' => 'alpha',
			'taxonomy' => 'store',
			'show_images' => 1,
			'limit' =>'',
			'random' => '',
		), $atts, 'wpsm_tax_archive' )
	);

	if($random){
		$number = '';
	}else{
		$number = $limit;
	}

	$args = array( 'hide_empty' => false, 'order' => 'ASC', 'taxonomy'=> $taxonomy, 'number'=> $number);
	 
	$terms = get_terms($args );

	if(is_wp_error($terms)) return;

	if($random){
		shuffle($terms);
		if ($limit){
			$terms = array_slice($terms, 0, $limit);
		}
	}

	$letter_keyed_terms = array();

	$term_letter_links = '';
	$term_titles = '';

	if($type == 'alpha') {
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach( $terms as $term ) {
				$first_letter = mb_substr( $term->name, 0, 1, 'UTF-8' );
				
				if( is_numeric( $first_letter ) ) {
					$first_letter = '0-9';
				} else {
					$first_letter = mb_strtoupper( $first_letter, 'UTF-8' );
				}
				
				if ( !array_key_exists( $first_letter, $letter_keyed_terms ) ) {
					$letter_keyed_terms[ $first_letter ] = array();
				}
				
				$letter_keyed_terms[ $first_letter ][] = $term;
			}
			
			foreach( $letter_keyed_terms as $letter => $terms ) {
				$term_letter_links .= '<li><a href="#'.$letter.'" class="rehub_scroll">'.$letter.'</a></li>';

				$term_titles .= '<div class="single-letter"><a href="#" name="'.$letter.'"></a><div class="letter_tag">'.$letter.'<div class="return_to_letters"><span class="rehub_scroll" data-scrollto="#top_ankor"><i class="fa fa-angle-up"></i></span></div></div></div> <!-- single-letter -->';
				$term_titles .= '<div class="tax-wrap rh-flex-eq-height">';
										
				foreach( $terms as $term ) {

					$thumbnail = $thumbnail_url = '';
					
					if ( $taxonomy == 'product_tag' && $show_images == 1 ) {
						  	$term_tag_array = get_option( 'taxonomy_term_'. $term->term_id ); 
						  	if (!empty ($term_tag_array['brand_image'])) {
							  	$showbrandimg = new WPSM_image_resizer();
				                $showbrandimg->height = '50';
				                $showbrandimg->src = $term_tag_array['brand_image'];
				                $thumbnail_url = $showbrandimg->get_resized_url();					  		
						  	}					  
						if ( $thumbnail_url ) {
							$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
						}
					}
					elseif ( $taxonomy == 'store' && $show_images == 1 ) {
							$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
						  	if (!empty ($brandimage)) {
							  	$showbrandimg = new WPSM_image_resizer();
				                $showbrandimg->height = '50';
				                $showbrandimg->src = $brandimage;
				                $thumbnail_url = $showbrandimg->get_resized_url();					  		
						  	}					  
						if ( $thumbnail_url ) {
							$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
						}
					}
					elseif ( $taxonomy == 'dealstore' && $show_images == 1 ) {
							$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
						  	if (!empty ($brandimage)) {
							  	$showbrandimg = new WPSM_image_resizer();
				                $showbrandimg->height = '50';
				                $showbrandimg->src = $brandimage;
				                $thumbnail_url = $showbrandimg->get_resized_url();					  		
						  	}					  
						if ( $thumbnail_url ) {
							$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
						}
					}					
					
					$term_titles .= '<div id="taxonomy-'. $term->term_id .'" class="tax-item"><a class="single-letter-link" href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( sprintf( __( 'View all post filed under %s', 'rehub_framework' ), $term->name ) ) . '">' . $thumbnail . '<h5>'. $term->name . '</h5></a></div>';
				}
				
				$term_titles .= '</div>';		
			}
		}
		
		return	'<div class="alphabet-filter">
						<div class="head-wrapper clearfix">
							<ul class="list-inline">
								'. $term_letter_links .'
							</ul>
						</div>
						<div class="body-wrapper clearfix">
								'. $term_titles .'
						</div>
					</div>';		
	}
	elseif ($type == 'compact') {
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach( $terms as $term ) {
				$term_titles .= '<div id="taxonomy-'. $term->term_id .'" class="tax-item"><a class="mini-tax-link" href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( sprintf( __( 'View all post filed under %s', 'rehub_framework' ), $term->name ) ) . '"><h5>'. $term->name . '</h5></a></div>';
			}
			return '<div class="alphabet-filter">'.$term_titles.'</div>';	
		}
	}
	elseif ($type == 'logo') {
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach( $terms as $term ) {
				$thumbnail = $thumbnail_url = '';
				
				if ( $taxonomy == 'product_tag' && $show_images == 1 ) {
					  	$term_tag_array = get_option( 'taxonomy_term_'. $term->term_id ); 
					  	if (!empty ($term_tag_array['brand_image'])) {
						  	$showbrandimg = new WPSM_image_resizer();
			                $showbrandimg->height = '50';
			                $showbrandimg->src = $term_tag_array['brand_image'];
			                $thumbnail_url = $showbrandimg->get_resized_url();					  		
					  	}					  
					if ( $thumbnail_url ) {
						$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
					}
				}
				elseif ( $taxonomy == 'store' && $show_images == 1 ) {
						$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
					  	if (!empty ($brandimage)) {
						  	$showbrandimg = new WPSM_image_resizer();
			                $showbrandimg->height = '50';
			                $showbrandimg->src = $brandimage;
			                $thumbnail_url = $showbrandimg->get_resized_url();					  		
					  	}					  
					if ( $thumbnail_url ) {
						$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
					}
				}
				elseif ( $taxonomy == 'dealstore' && $show_images == 1 ) {
						$brandimage = get_term_meta( $term->term_id, 'brandimage', true ); 
					  	if (!empty ($brandimage)) {
						  	$showbrandimg = new WPSM_image_resizer();
			                $showbrandimg->height = '50';
			                $showbrandimg->src = $brandimage;
			                $thumbnail_url = $showbrandimg->get_resized_url();					  		
					  	}					  
					if ( $thumbnail_url ) {
						$thumbnail = '<img src="'. $thumbnail_url .'" alt="'. $term->name .'" />';
					}
				}
				if ($thumbnail){
					$term_titles .= '<div id="taxonomy-'. $term->term_id .'" class="tax-item"><a class="logo-tax-link" href="' . esc_url( get_term_link( $term ) ) . '" title="' . esc_attr( sprintf( __( 'View all post filed under %s', 'rehub_framework' ), $term->name ) ) . '">'. $thumbnail . '</a></div>';					
				}
			}
			return '<div class="alphabet-filter">'.$term_titles.'</div>';	
		}
	}	
}
}
add_shortcode( 'wpsm_tax_archive', 'wpsm_tax_archive_shortcode' );


//////////////////////////////////////////////////////////////////
// USER REVIEWS BASED ON FULL REVIEWS
//////////////////////////////////////////////////////////////////
if( !function_exists('re_user_rating_shortcode') ) {
function re_user_rating_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts(
	array(
		'size' => 'big',
	), $atts);

    $postAverage = get_post_meta(get_the_ID(), 'post_user_average', true);
    if(!empty($postAverage)){
    	$starscore = $postAverage*10 ;
    	$output = '<div class="star-'.$atts['size'].'"><span class="stars-rate"><span style="width: '.$starscore.'%;"></span></span></div>';
    	return $output;
    }
}
add_shortcode('wpsm_user_rating_stars', 're_user_rating_shortcode');
}

//////////////////////////////////////////////////////////////////
// UPDATE BLOCK
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_update_shortcode') ) {
function wpsm_update_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts(
	array(
		'date' => '',
		'label' => '',
	), $atts);
	$date = (!empty($atts['date'])) ? ' - '.$atts['date'].'' : '';
	$label = (!empty($atts['label'])) ? $atts['label'] : __('Update', 'rehub_framework');
	$content = do_shortcode($content);	
	$output = '<div class="wpsm_update"><span class="label-info">'.$label.$date.'</span>'.$content.'</div>';
	return $output;
}
add_shortcode('wpsm_update', 'wpsm_update_shortcode');
}


//////////////////////////////////////////////////////////////////
// SPECIFICATION BUILDER
//////////////////////////////////////////////////////////////////
if ( !function_exists( 'wpsm_spec_builders_shortcode' ) ) {
	function wpsm_spec_builders_shortcode( $atts, $content = null ) {
		
		extract(shortcode_atts( array(
				'id' => '',
				'postid' => '',
			), $atts));
			
		if( !empty($id) ) :

			$rows = get_post_meta( $id, '_wpsm_spec_line', true );
			if(empty($rows)) return;

			ob_start(); 
			?>

                <?php 
                	$postID = (!empty($postid)) ? $postid : get_the_ID();
                    $pbid=0;                       
                    foreach ($rows as $row) {
                    echo '<div class="wpsm_spec_row_'.$id.'_'.$pbid.'">';                       
                    $element = $row['column_type'];
                        if ($element == 'heading_line') {
                            include(rh_locate_template('inc/specification/heading_line.php'));
                        } else if ($element == 'meta_line') {
                            include(rh_locate_template('inc/specification/meta_line.php'));                          
                        } else if ($element == 'divider_line') {
                            include(rh_locate_template('inc/specification/divider_line.php'));                            
                        } else if ($element == 'tax_line') {
                            include(rh_locate_template('inc/specification/tax_line.php'));                            
                        } else if ($element == 'shortcode_line') {
                            include(rh_locate_template('inc/specification/shortcode_line.php')); 
                        } else if ($element == 'photo_line') {
                            include(rh_locate_template('inc/specification/photo_line.php'));
                        } else if ($element == 'video_line') {
                            include(rh_locate_template('inc/specification/video_line.php'));
                        } else if ($element == 'mdtf_line') {
                            include(rh_locate_template('inc/specification/mdtf_line.php'));   
                        } else if ($element == 'proscons_line') {
                            include(rh_locate_template('inc/specification/proscons_line.php'));  
                        } else if ($element == 'map_line') {
                            include(rh_locate_template('inc/specification/map_line.php'));
                        } else {
                            
                        };
                    echo '</div>';
                    $pbid++;
                    } 
                ?>

			<?php 
			$output = ob_get_contents();
			ob_end_clean();
			return $output;   
		endif;	

	}
add_shortcode( 'wpsm_specification_builder', 'wpsm_spec_builders_shortcode' );
}

//////////////////////////////////////////////////////////////////
// Category box
//////////////////////////////////////////////////////////////////
if ( !function_exists('wpsm_catbox_shortcode') ) {
function wpsm_catbox_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
			'category' => '', // one ID
			'title' => '', // if empty - original title
			'link' => '0', // 1 or 0
			'image' => '', // URL or post_id in media library
			'size_img' => '' // % or px ('width' or 'width height')
		), $atts ) );

	if ( empty( $category ) || $category == 0 )
		return;

	$term = get_term( (int) $category );
	
 	if ( is_wp_error( $term ) ) {
		$error_string = $term->get_error_message();
		return '<div id="message" class="error"><p><b>Error</b>: Category ID '. $category .' - '. $error_string .'</p></div>';
 	}

	if ( is_numeric( $image ) ) {
		$image = wp_get_attachment_url( $image );
	}
	
	$bg_size = ( $size_img ) ? ' background-size:'. $size_img .'; height:'. $size_img .'' : '';
	
	// HTML output
	$output = '<div class="rh-cartbox catbox mb20">';
		
		if ( $image ){
			$output .= '<div class="categoriesbox-bg" style="background-image:url('. $image .');'. $bg_size .'">';	
			if ( $link == 1 ) {
				$output .= '<a href="'. get_term_link( $term->term_id ) .'" rel="nofollow"></a>';
			}
			$output .= '</div>';
		}	

		$output .='<div class="catbox-content r_offer_details">';
		
		$title = ( $title && $title !='' ) ? $title : $term->name;
			
			if ( $link == 1 ) {
				$output .= '<h3><a href="'. get_term_link( $term->term_id ) .'">'. $title .'</a></h3>';
			} else {
				$output .= '<h3>'. $title .'</h3>';
			}
			
			$termchildren = get_terms( array(
				'taxonomy' => $term->taxonomy,
				'orderby' => 'name',
				'hide_empty' => true,
				'child_of' => $term->term_id
			) );
			
			if ( is_wp_error( $termchildren ) ) {
				$error_string = $termchildren->get_error_message();
				return '<div id="message" class="error"><p><b>Error</b>: Category ID '. $category .' - '. $error_string .'</p></div>';
			}

			
			$term_count = count( $termchildren ); 
			if($term_count > 0) {
				$output .= '<ul class="catbox-child-list">';
				$i = 0;
				foreach ( $termchildren as $termchild ) {

					if ( $i == 5 )
						$output .= '<div class="open_dls_onclk">';
					$output .= '<li><a href="'. get_term_link( (int) $termchild->term_id ) .'">'. $termchild->name .'</a> ('. (int) $termchild->count .')</li>';
					
					if ( $i == $term_count )
						$output .= '</div>';
					$i++;
				}
				$output .= '</ul>';
			}

			
			if ( $term_count > 5 )
				$output .= '<span class="r_show_hide r_catbox_btn">'.__('See all', 'rehub_framework').'</span>';
			
		$output .= '</div>';

	$output .= '</div>';

	return $output;
}
add_shortcode('wpsm_catbox', 'wpsm_catbox_shortcode');
}

if (!function_exists('rh_wcv_vendorslist_flat')) {
function rh_wcv_vendorslist_flat( $atts ) {

		$html = ''; 
		
	  	extract( shortcode_atts( array(
	  			'orderby' => 'registered',
	  			'order'	=> 'ASC',
				'per_page' => '12',
				'show_products' => 'yes',
				'search_form' => 0,
				'user_id' => '' 
			), $atts ) );

	  	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;   
	  	$offset = ( $paged - 1 ) * $per_page;
		
		// Search query fom the form
		$search_sellers = isset($_GET['search_sellers']) ? esc_attr($_GET['search_sellers']) : '';
		
		// Sort filter and data from the form change parametres of the WP user query
		$alphabet = $mostpopular = $mostposts = $mostresent = '';
		$selected = ' selected="selected"';
		$meta_key = 'pv_shop_name';
		
		if( isset($_GET['orderby_sellers']) ) {
			$orderby_sellers = $_GET['orderby_sellers'];
			switch ($orderby_sellers) {
				case 'alphabet':
					$orderby = 'display_name';
					$order = 'ASC';
					$alphabet = $selected;
					break;
				case 'mostpopular':
					$orderby = 'meta_value';
					$order = 'DESC';
					$meta_key = '_rh_user_favorite_shop_count';
					$mostpopular = $selected;
					break;
				case 'mostposts': // omitted
					$mostposts = $selected;
					break;
				default;
					$mostresent = $selected;
			}
		} else {
			$mostresent = $selected;
		}

	  	// Hook into the user query to modify the query to return users that have at least one product 
	  	if ($show_products == 'yes') add_action( 'pre_user_query', 'rh_vendors_with_products' );

	  	// Get all vendors 
	  	$vendor_total_args = array ( 
	  		'role' 			=> 'vendor', 
			'meta_key' 	=> $meta_key, 
			'meta_value'   	=> '',
			'meta_compare'	=> '>',
			'orderby' 		=> $orderby,
  			'order'			=> $order,
	  	);

	  	if ($show_products == 'yes') $vendor_total_args['query_id'] = 'vendors_with_products'; 

	  	$vendor_query = New WP_User_Query( $vendor_total_args ); 
	  	$all_vendors =$vendor_query->get_results(); 

	  	// Get the paged vendors 
	  	$vendor_paged_args = array ( 
	  		'role' 			=> 'vendor', 
			'meta_key' 	=> $meta_key, 
			'meta_value'   	=> '',
			'meta_compare'	=> '>',
			'search'		=> $search_sellers,
			'orderby' 		=> $orderby,
  			'order'			=> $order,
	  		'offset' 		=> $offset, 
	  		'number' 		=> $per_page, 
	  	);

	  	if ($show_products == 'yes' ) $vendor_paged_args['query_id'] = 'vendors_with_products'; 

	  	if ($user_id){
	  		$user_ids = array_map( 'trim', explode( ",", $user_id ) );
		  	$vendor_paged_args = array ( 
		  		'role' 			=> 'vendor', 
				'meta_key' 	=> $meta_key, 
				'meta_value'   	=> '',
				'meta_compare'	=> '>',
				'include' 		=> $user_ids,
		  	);	  		
	  	}	  	

	  	$vendor_paged_query = New WP_User_Query( $vendor_paged_args ); 
	  	$paged_vendors = $vendor_paged_query->get_results(); 

	  	// Pagination calcs 
		$total_vendors = count( $all_vendors );  
		$total_vendors_paged = count($paged_vendors);  
		$total_pages = ceil( $total_vendors / $per_page );
	    
	   	ob_start();
		
		if($search_form ==1){
		$html .='
		<div class="tabledisplay mb20">
			<form id="search-sellers" role="search" method="get" class="celldisplay search-form floatleft mb10">
				<input type="text" name="search_sellers" placeholder="'. __('Search sellers', 'rehub_framework') .'" value="">
				<button type="submit" alt="'. __('Search', 'rehub_framework') .'" value="'. __('Search', 'rehub_framework') .'" class="btnsearch"><i class="fa fa-search"></i></button>
			</form>
			<form id="filter-sellers" method="get" class="celldisplay floatright mb10 ml10">
				<label>'. __('Sort by:', 'rehub_framework') .'</label>
				<select name="orderby_sellers" class="orderby">
					<option value="alphabet"'. $alphabet .'>'. __('Alphabetical', 'rehub_framework') .'</option>
					<option value="mostpopular"'. $mostpopular .'>'. __('Most popular', 'rehub_framework') .'</option>
					<option value="mostresent"'. $mostresent .'>'. __('Most recent', 'rehub_framework') .'</option>
				</select>
			</form>
			<script>jQuery( function( $ ) {
				$( "#filter-sellers" ).on( "change", "select.orderby", function() {
					$( this ).closest( "form" ).submit();
				});
			});
			</script>
		</div>';
		}

	    // Loop through all vendors and output a simple link to their vendor pages
	    foreach ($paged_vendors as $vendor) {
	    	$shop_link = WCV_Vendors::get_vendor_shop_page($vendor->ID);
	    	$shop_name = $vendor->pv_shop_name;
	    	$vendor_id= $vendor->ID;
	    	//$shop_description = $vendor->pv_shop_description;
	    	if ( class_exists( 'WCVendors_Pro' ) ) {
	    		$vendor_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta( $vendor->ID ) );
	    	}
	    	include(rh_locate_template('inc/wcvendor/vendorlist.php'));

	    } // End foreach 
	   	
	   	$html .= '<div class="rh_vendors_listflat">' . ob_get_clean() . '</div>';

	    if ( $total_vendors > $total_vendors_paged ) {  
			$html .= '<nav class="woocommerce-pagination">';  
			  $current_page = max( 1, get_query_var('paged') );  
			  $html .= paginate_links( 	array(  
			        'base' => get_pagenum_link() . '%_%',
			        'format' => 'page/%#%/',  
			        'current' => $current_page,  
			        'total' => $total_pages,  
			        'prev_next' => false,  
			        'type' => 'list',  
			    ));  
			$html .= '</nav>'; 
		}

	    return $html; 
	}
add_shortcode('wpsm_vendorlist', 'rh_wcv_vendorslist_flat');
}

if (!function_exists('rh_vendors_with_products')) {
function rh_vendors_with_products( $query ) {
	global $wpdb; 
    if ( isset( $query->query_vars['query_id'] ) && 'vendors_with_products' == $query->query_vars['query_id'] ) {  
        $query->query_from = $query->query_from . ' LEFT OUTER JOIN (
                SELECT post_author, COUNT(*) as post_count
                FROM '.$wpdb->prefix.'posts
                WHERE post_type = "product" AND (post_status = "publish" OR post_status = "private")
                GROUP BY post_author
            ) p ON ('.$wpdb->prefix.'users.ID = p.post_author)';
        $query->query_where = $query->query_where . ' AND post_count  > 0 ' ;  
    } 
}
}

//GMW SHORTCODE MAP
function rh_add_map_gmw($atts, $content = null ) {
	extract( shortcode_atts( array(
			'user_id' => '', // one ID
		), $atts ) );	
	if ( class_exists( 'GMW_Members_Locator_Component' ) ) {
		include (locate_template( 'geo-my-wp/customform/gmw-fl-location-tab.php' ));
		$user_id = (!empty($user_id)) ? $user_id : get_current_user_id();
		if (is_user_logged_in()){
			ob_start(); 
			$mapform = new RH_GMW_FL_Location_Page($user_id);
			echo '<div id="buddypress">';
			$mapform->display_location_form( $mapform->location, $user_id );
			echo '</div>';
			$output = ob_get_contents();
			ob_end_clean();
			return $output; 
		}else{
			ob_start(); 
			_e('Please, login to set location', 'rehub_framework');
			$output = ob_get_contents();
			ob_end_clean();
			return $output;		
		}		
	}
}
add_shortcode('rh_add_map_gmw', 'rh_add_map_gmw');

//GMW SHORTCODE MAP
function rh_compare_icon($atts, $content = null ) {
	if (rehub_option('compare_page') != '' || rehub_option('compare_multicats_toggle') == 1) {	
		$output = '<span class="re-compare-icon-toggle">';
			$output .= '<i class="fa fa-balance-scale" aria-hidden="true"></i>';
			$totalcompared = re_compare_panel('count');
			if ($totalcompared == '') {$totalcompared = 0;}
			$output .= '<span class="re-compare-notice">'.$totalcompared.'</span>';		
		$output .= '</span>';
		return $output;
	}
}
add_shortcode('rh_compare_icon', 'rh_compare_icon');

//VC SHORTCODES
include ( get_template_directory() . '/shortcodes/module_shortcodes.php'); 

//////////////////////////////////////////////////////////////////
// Compare price shortcode
//////////////////////////////////////////////////////////////////
if( !function_exists('wpsm_get_merchant_list') ) {
function wpsm_get_merchant_list($atts){
    extract(shortcode_atts(array(
        'postid' => NULL,
        'ce_enable' => NULL,
        'pricehistory' => NULL,
        'pricealert' => NULL,
    ), $atts));
   	global $post;
   	$post_id = (NULL === $postid) ? $post->ID : $postid;
   	ob_start();
   	?>
		<?php $multiofferrows = get_post_meta($post_id, 'rehub_multioffer_group', true);?>
		<?php $offers_array = $cegg_fields = $cegg_clean_array = array();?>

		<?php if (!empty($multiofferrows[0]['multioffer_url'])) :?>
			<?php foreach ($multiofferrows as $key => $value):?>
				<?php 
					$offer_post_url = (!empty($value['multioffer_url'])) ? $value['multioffer_url'] : '';
					$offer_url = apply_filters('rh_post_multioffer_url_filter', $offer_post_url );
					$offer_price = (!empty($value['multioffer_price'])) ? $value['multioffer_price'] : '';
					$offers_array[$key]['price'] = rehub_price_clean($offer_price);
					$offers_array[$key]['price_noclean'] = $offer_price;
					$offers_array[$key]['url'] = $offer_url;					
				?>								
			<?php endforeach;?>
		<?php endif ;?>
		<?php if ($ce_enable) :?>
            <?php
                $cegg_field_array = rehub_option('save_meta_for_ce');
                if (!empty($cegg_field_array) && is_array($cegg_field_array)) {
                    foreach ($cegg_field_array as $cegg_field) {
                        $cegg_field_value = get_post_meta ($post_id, '_cegg_data_'.$cegg_field.'', true);
                        if (!empty ($cegg_field_value) && is_array($cegg_field_value)) {
                            $cegg_fields[$cegg_field]= $cegg_field_value;
                        }       
                    }		                        
                    if (!empty($cegg_fields) && is_array($cegg_fields)) {
						$all_items = array(); 
					    foreach ($cegg_fields as $module_id => $items) {
					        foreach ($items as $item_ar) {
					            $item_ar['module_id'] = $module_id;
					            $all_items[] = $item_ar;
					        }       
					    }
					    foreach ($all_items as $key => $value) {
							$cegg_clean_array[$key]['price'] = $value['price'];
							$cegg_clean_array[$key]['currency'] = $value['currencyCode'];
							$cegg_clean_array[$key]['url'] = $value['url'];		
							$cegg_clean_array[$key]['domain'] = $value['extra']['domain'];	
							$cegg_clean_array[$key]['merchant'] = (!empty($value['merchant'])) ? $value['merchant'] : '';
							$cegg_clean_array[$key]['orig_url'] = (!empty($value['orig_url'])) ? $value['orig_url'] : '';	    	       
					    }					    
                    }
                }
            ?>	    		
		<?php endif ;?>

		<?php $items = array_merge($offers_array, $cegg_clean_array);?>
		<?php  if(!empty($items)):?>
			<?php 	
				$postid = $post_id; //Here we get synced product data from CE
    			$unique_id = get_post_meta($postid, '_rehub_product_unique_id', true);
    			$module_id = get_post_meta($postid, '_rehub_module_ce_id', true);
    			$cegg_sync_field = get_post_meta($postid, '_cegg_data_'.$module_id.'', true);
    			$syncitem = (!empty($cegg_sync_field[$unique_id])) ? $cegg_sync_field[$unique_id] : '';
    		?>

			<?php usort($items, 'rehub_sort_price_ce');?>
			<?php $countitems = count($items);?>
	        <?php if($pricealert):?>
				<?php if (version_compare(PHP_VERSION, '5.3.0', '>=') && $unique_id && $module_id && !empty($syncitem)) {	
					include(rh_locate_template( 'inc/parts/pricealertpopup.php' ) );
				} ?>			        	
	        <?php endif;?>			
			<div class="widget_merchant_list<?php if ($countitems > 7):?> expandme<?php endif;?>">
			    <div class="tabledisplay">
			        <?php  foreach ($items as $key => $item): ?>
			            <?php $offer_post_url = $item['url'] ;?>
    					<?php $afflink = apply_filters('rh_post_offer_url_filter', $offer_post_url );?>
			            <?php $merchant = (!empty($item['merchant'])) ? $item['merchant'] : ''; ?>
			            <?php $offer_price = (!empty($item['price'])) ? $item['price'] : ''; ?>
			            <?php $price_noclean = (!empty($item['price_noclean'])) ? $item['price_noclean'] : ''; ?>
			            <?php $currency_code = (!empty($item['currency'])) ? $item['currency'] : ''; ?>
			            <?php $domain = (!empty($item['domain'])) ? $item['domain'] : ''; ?>
			            <?php $domain = rh_fix_domain($merchant, $domain);?>
			            <?php $orig_url = (!empty($item['orig_url'])) ? $item['orig_url'] : ''; ?> 
			            <?php if(rehub_option('rehub_btn_text') !='') :?>
			            	<?php $btn_txt = rehub_option('rehub_btn_text') ; ?>
			            <?php else :?>
			            	<?php $btn_txt = __('See it', 'rehub_framework') ;?>
			            <?php endif ;?>  
			            <div class="table_merchant_list">               
			                <div class="merchant_thumb">   
			                    <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>" class="re_track_btn">
			                        <?php if ($merchant) :?>
			                            <?php echo rehub_get_site_favicon_icon('http://'.$domain); ?>
			                            <?php echo $merchant; ?>
			                        <?php elseif($domain) :?> 
			                            <?php echo rehub_get_site_favicon('http://'.$domain); ?> 
			                        <?php elseif($orig_url) :?>
			                            <?php echo rehub_get_site_favicon($orig_url); ?>   
			                        <?php endif ;?>                                                           
			                    </a>
			                </div>                  
			                <div class="price_simple_col">
			                    <?php if($offer_price || $price_noclean) : ?>
			                            <a rel="nofollow" target="_blank" href="<?php echo esc_url($afflink) ?>" class="re_track_btn">
			                                <span class="val_sim_price">
			                                	<?php if ($price_noclean):?>
			                                		<?php echo $price_noclean;?>
			                                	<?php else:?>
													<?php echo RhPriceTemplateHelper::formatPriceCurrency($offer_price, $currency_code); ?>			                                	
			                                	<?php endif;?>			                                    
			                                </span>
			                            </a>                       
			                    <?php endif ;?>                       
			                </div>
			                <div class="buttons_col">
			                    <a class="re_track_btn" href="<?php echo esc_url($afflink) ?>" target="_blank" rel="nofollow">
			                        <?php echo $btn_txt ; ?>
			                    </a>                        			                        
			                </div>
			                                                                          
			            </div>
			        <?php endforeach; ?> 
			    </div>
			    <div class="additional_line_merchant">
			    	<?php if ($countitems > 7):?>
			        	<span class="expand_all_offers"><?php _e('Show all', 'rehub_framework');?> <span class="expandme">+</span></span>
			    	<?php endif;?>
			        <?php if($pricehistory):?>
						<?php if (version_compare(PHP_VERSION, '5.3.0', '>=') && $unique_id && $module_id && !empty($syncitem)) {
							include(rh_locate_template( 'inc/parts/pricehistorypopup.php' ) );
						} ?>			        	
			        <?php endif;?>
			    </div>  
			</div>			
			<div class="clearfix"></div>			  
		<?php endif;?>
    <?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;    
}
add_shortcode('wpsm_compare_multioffer', 'wpsm_get_merchant_list');
}

if( !function_exists('wpsm_get_bigoffer') ) {
function wpsm_get_bigoffer($atts){
	extract(shortcode_atts(array(
        'post_id' => NULL,
        'ce_enable' => NULL,
        'pricehistory' => NULL,
        'pricealert' => NULL,
    ), $atts));

	if($post_id && is_numeric($post_id)){
		ob_start();
		?>
        <div class="rh-tabletext-block">
            <div class="rh-tabletext-block-heading"><h4><a href="<?php echo get_the_permalink($post_id) ?>"><?php echo get_the_title($post_id); ?></a></h4> </div>		
	        <div class="rh-tabletext-block-wrapper flowhidden"> 
	            <div class="featured_compare_left">
	                <figure>                                                                    
	                    <a href="<?php echo get_the_permalink($post_id) ?>">
	                        <?php           
                    			$image_id = get_post_thumbnail_id($post_id);  
                    			$image_url = wp_get_attachment_image_src($image_id,'full');
                    			$image_url = $image_url[0]; 
                			?> 
	                        <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=> true, 'src'=> $image_url, 'crop'=> false, 'height'=> 350, 'width'=> 350));?>
	                    </a>
	                </figure>                             
	            </div>
	            <div class="single_compare_right">
                    <?php $overall_review = $rating_score_clean = get_post_meta($post_id, 'rehub_review_overall_score', true);?>
                    <?php if($overall_review):?>
                    	<?php $overall_review_100 = $overall_review * 10;?>                  	
                    	<?php 
                    	if($overall_review<=2){
                    		$color = "#940000";
                    	}    
                    	elseif($overall_review<=4){
                    		$color = "#cc0000";
                    	}   
                    	elseif($overall_review<=6){
                    		$color = "#9c0";
                    	}  
                    	elseif ($overall_review <=8){
                    		$color = "#ffac00";
                    	}                    	                  	                  	                 	
                    	elseif ($overall_review <=10) {
                    		$color = "#ffac00";
                    	}
                    	?>                    	                   	
                        <div class="bigoffer-overall-score mb20">
                        	<div class="text-overal-score mb10 flowhidden">
                            <span class="overall floatleft"><?php echo $overall_review;?>/10 </span>
                            <span class="text-read-review floatright"><a href="<?php echo get_the_permalink($post_id) ?>"><?php _e('Read review', 'rehub_framework');?></a></span>
                            </div>
                            <?php echo do_shortcode('[wpsm_bar percentage="'.$overall_review_100.'" color="'.$color.'"]' );?>
                        </div>                         

                    <?php endif;?>
	                <?php echo do_shortcode('[wpsm_compare_multioffer ce_enable="'.$ce_enable.'" postid="'.$post_id.'" pricehistory="'.$pricehistory.'" pricealert="'.$pricealert.'"]');?>
	            </div> 
			</div>
		</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 

	}

}
add_shortcode('wpsm_bigoffer', 'wpsm_get_bigoffer');
}


if( !function_exists('wpsm_get_add_deal_popup') ) {
function wpsm_get_add_deal_popup($atts, $content = NULL){
	extract(shortcode_atts(array(
        'postid' => NULL,
        'role' => 'contributor',
    ), $atts));

   	global $post;
   	$post_id = (NULL === $postid) ? $post->ID : $postid;	

	if($post_id && is_numeric($post_id)){
		ob_start();
		$rand = uniqid();
		?>		
		<a class="btn_offer_block csspopuptrigger rh-deal-compact-btn act-rehub-addoffer-popup act-rehub-login-popup" data-popup="addfrontdeal_<?php echo $rand;?>"><?php _e('Add your deal', 'rehub_framework') ?></a>

		<?php if (is_user_logged_in()): 
			$current_user = wp_get_current_user();
		?>
			<div class="csspopup" id="addfrontdeal_<?php echo $rand;?>">
				<div class="csspopupinner addfrontdeal-popup">
					<span class="cpopupclose" href="#">×</span> 
					<?php if ( in_array( $role, (array) $current_user->roles )):?>
						<?php $offer_group_array = get_post_meta( $post_id, 'rehub_multioffer_group', true );?>
						<?php 
						$multioffer_names = array();
						if (!empty($offer_group_array)){
							$multioffer_names = wp_list_pluck( $offer_group_array, 'multioffer_user' );
						}?>
						<?php if (false === in_array($current_user->ID, $multioffer_names)):?>
							<div class="rehub-offer-popup">
								<div class="re_title_inmodal"><?php _e('Add an Offer', 'rehub_framework'); ?></div>
								<form id="rehub_add_offer_form_modal" action="<?php echo home_url( '/' ); ?>" method="post">
									<div class="re-form-group mb20">
										<label for="rehub_product_name"><?php _e('Name of product', 'rehub_framework') ?><span>*</span></label>
										<input class="re-form-input required" name="rehub_product_name" id="rehub_product_name" type="text" />
									</div>
									<div class="re-form-group mb20">
										<label for="rehub_product_url"><?php _e('Offer url', 'rehub_framework') ?><span>*</span></label>
										<input class="re-form-input required" name="rehub_product_url" id="rehub_product_url" type="url" required />
									</div>
									<div class="re-form-group mb20">
										<label for="rehub_product_price"><?php _e('Offer sale price (example, $55)', 'rehub_framework') ?><span>*</span></label>
										<input class="re-form-input required" name="rehub_product_price" id="rehub_product_price" type="text" />
									</div>
									<div class="re-form-group mb20">
										<label for="rehub_product_desc"><?php _e('Short description', 'rehub_framework') ?><span></span></label>
										<input class="re-form-input" name="rehub_product_desc" id="rehub_product_desc" type="text" />
									</div>									
									<div class="re-form-group mb20">
										<input type="hidden" name="action" value="rh_ajax_action_send_offer" />
										<input type="hidden" name="from_user" value="<?php echo $current_user->ID; ?>" />
										<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
										<?php wp_nonce_field( 'rh_ajax_action_send_offer', 'offer_nonce' ); ?>
										<button class="wpsm-button rehub_main_btn" type="submit" name="send"><?php _e('Send', 'rehub_framework'); ?></button>
									</div>
								</form>
								<div class="rehub-errors"></div>
							</div>
						<?php else:?>
							<?php _e('You already added your deal to this post', 'rehub_framework');?>
						<?php endif;?>
					<?php else:?>
						<?php $content = do_shortcode($content);?>
						<?php if($content):?>
							<?php echo $content;?>
						<?php else:?>
							<?php  echo sprintf( 'Only users with role <span class="greencolor">%s</span> are allowed to post deals', $role);?>
						<?php endif;?>
					<?php endif;?>
					<div class="rehub-offer-popup-ok font110 rhhidden">
						<div class="re_title_inmodal"><?php _e('Send Offer', 'rehub_framework'); ?></div>
							<?php printf( __('<strong>Thank you, %s!</strong> Your offer has been sent', 'rehub_framework'), $current_user->display_name ); ?>
					</div>
				</div>				
			</div>
		<?php endif;?>
		
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		return $output; 
	}
}
add_shortcode('wpsm_add_deal_popup', 'wpsm_get_add_deal_popup');
}


if( !function_exists('rh_get_post_thumbnails') ) {
function rh_get_post_thumbnails($atts, $content = NULL){
	extract(shortcode_atts(array(
        'postid' => NULL,
        'video' => '',
        'height' => '100',
        'columns' => 5,
        'class' => '',
        'justify' => ''
    ), $atts));	
	global $post;
   	$post_id = (NULL === $postid) ? $post->ID : $postid;
    $post_image_gallery = get_post_meta( $post_id, 'rh_post_image_gallery', true );
    $post_image_videos = get_post_meta( $post_id, 'rh_post_image_videos', true );
    $countimages = '';
    $columnclass = ($columns==5) ? ' five-thumbnails' : '';
    $justifyclass = ($justify) ? 'justified-gallery rh-tilled-gallery ' : 'rh-flex-eq-height compare-full-thumbnails mt15 ';
	ob_start();
	?>    
    <?php if(!empty($post_image_gallery) || (!empty($post_image_videos) && $video == 1) ) :?>
    	<?php $random_key = rand(0, 50);?>
        <?php $post_image_gallery = explode(',', $post_image_gallery);?>
        <?php if($post_image_videos):?>
        	<?php $post_image_videos = array_map('trim', explode(PHP_EOL, $post_image_videos));?>
        <?php endif;?> 
        <?php if($justify):?>
        	<div class="rh-line mt30 mb30 clearfix"></div>
        <?php endif;?> 
        <div class="<?php echo $justifyclass; echo $class; echo $columnclass;?>" data-galleryid="rhgal_<?php echo $random_key;?>">
            <?php foreach($post_image_gallery as $key=>$image_gallery):?>
            	<?php if($image_gallery):?>
	                <a href="<?php echo wp_get_attachment_url($image_gallery);?>" target="_blank" class="mb10"> 
	                    <?php WPSM_image_resizer::show_static_resized_image(array('lazy'=>false, 'src'=> wp_get_attachment_url($image_gallery), 'crop'=> false, 'height'=> $height, 'title' => esc_attr(get_post_meta( $image_gallery, '_wp_attachment_image_alt', true))));?>                                                     
	                    </a> 
                <?php endif;?>                              
            <?php endforeach;?>  
            <?php if($video == 1 && !empty($post_image_videos)):?>   
	            <?php foreach($post_image_videos as $key=>$video):?>
	                <a href="<?php echo esc_url($video);?>" target="_blank" class="mb10 rh_videothumb_link"> 
						<img src="<?php echo parse_video_url(esc_url($video), 'hqthumb'); ?>" width="<?php echo $height;?>" alt="" />
	                </a>                               
	            <?php endforeach;?> 
            <?php endif;?>                       
        </div>
        <?php  wp_enqueue_script('prettyphoto');?>
        <?php if($justify):?>
        	<?php wp_enqueue_script('justifygallery');?>
        <?php else:?>
	        <script data-cfasync="false">
	        jQuery(document).ready(function($) {
	            'use strict'; 
	            $('.compare-full-thumbnails a').attr('rel', 'prettyPhoto[rehub_postthumb_gallery_<?php echo $random_key;?>]');
	            $(".compare-full-thumbnails a[rel^='prettyPhoto']").prettyPhoto({social_tools:false, default_width: 854,default_height: 480});
	        });
	        </script>        	
        <?php endif;?>
        
    <?php endif;?>   
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output; 
}
add_shortcode('rh_get_post_thumbnails', 'rh_get_post_thumbnails');
}

if( !function_exists('rh_get_profile_data') ) {
function rh_get_profile_data($atts, $content = NULL){
	extract(shortcode_atts(array(
        'name' => '',
        'type' => '',
        'userid' =>'',
    ), $atts));	
	if(!$name || !bp_is_active( 'xprofile' )) return;
	if(bp_get_profile_field_data('field='.$name.'&user_id='.$userid.'')){
		$data = bp_get_profile_field_data('field='.$name.'');
		if($type == 'text'){
			$data = esc_html($data);
		}
		elseif ($type=='link'){
			$data = esc_url($data);
		}
		return $data;
	}

}
add_shortcode('rh_get_profile_data', 'rh_get_profile_data');
}


if( !function_exists('rh_is_bpmember_type') ) {
function rh_is_bpmember_type($atts, $content = NULL){
	extract(shortcode_atts(array(
        'type' => '',
        'current' => '',
    ), $atts));	

	if(!$type || !function_exists('bp_get_member_type')) return;
	if($current){
		$userid = get_current_user_id();
		if(!$userid) return;
	}
	else{
		$userid = bp_displayed_user_id();
		if(!$userid) return;
	}
	$usertype = bp_get_member_type($userid);
	if(($usertype == $type) && !is_null( $content )){		
		$content = do_shortcode($content);
		$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
		$Old     = array( '<br />', '<br>' );
		$New     = array( '','' );
		$content = str_replace( $Old, $New, $content );
		return $content;
	}
	else{
		return false;
	}
}
add_shortcode('rh_is_bpmember_type', 'rh_is_bpmember_type');
}

if( !function_exists('rh_bpmember_type') ) {
function rh_bpmember_type($atts, $content = NULL){
	extract(shortcode_atts(array(
        'bp_user' => '',
    ), $atts));	

	if(!function_exists('bp_get_member_type')) return;
	if($bp_user){
		$userid = bp_displayed_user_id();
		if(!$userid) return;
	}
	else{
		$userid = get_current_user_id();
		if(!$userid) return;
	}
	$usertype = bp_get_member_type($userid);
	$membertype_object = bp_get_member_type_object($usertype);
	$membertype_label = (!empty($membertype_object) && is_object($membertype_object)) ? $membertype_object->labels['singular_name'] : '';	
	return $membertype_label;

}
add_shortcode('rh_bpmember_type', 'rh_bpmember_type');
}

if( !function_exists('rh_is_bpmember_role') ) {
function rh_is_bpmember_role($atts, $content = NULL){
	extract(shortcode_atts(array(
        'role' => '',
    ), $atts));	

	if(!$role || !function_exists('bp_displayed_user_id')) return;
	$userid = bp_displayed_user_id();
	$user = get_userdata($userid);
	if (!empty($user)){
		if(in_array( $role, (array)$user->roles) && !is_null( $content )){		
			$content = do_shortcode($content);
			$content = preg_replace( '%<p>&nbsp;\s*</p>%', '', $content ); 
			$Old     = array( '<br />', '<br>' );
			$New     = array( '','' );
			$content = str_replace( $Old, $New, $content );
			return $content;
		}
		else{
			return false;
		}		
	}
	else{
		return false;
	}
}
add_shortcode('rh_is_bpmember_role', 'rh_is_bpmember_role');
}

if( !function_exists('rh_is_bpmember_profile') ) {
function rh_is_bpmember_profile($atts, $content = NULL){	
	if(!function_exists('bp_is_my_profile')) return;
	if (bp_is_my_profile()){		
		$content = do_shortcode($content);
		return $content;	
	}
	else{
		return false;
	}
}
add_shortcode('rh_is_bpmember_profile', 'rh_is_bpmember_profile');
}


if( !function_exists('rh_get_group_admins') ) {
function rh_get_group_admins($atts, $content = NULL){
	extract(shortcode_atts(array(
        'text' => '',
    ), $atts));	
    if(!bp_is_group_single()) return;
	global $groups_template;
	$output = '';
	if ( empty( $group ) ) {
		$group =& $groups_template->group;
	}
	$txt = ($text) ? $text : __('Write message', 'rehub_framework') ;
	if ( ! empty( $group->admins ) ) { 
		$output .= '<ul class="buddypress widget">';
			foreach( (array) $group->admins as $admin ) {
				$output .= '<li class="vcard mb15">';
					$output .= '<div class="item-avatar"><a href="'.bp_core_get_user_domain( $admin->user_id, $admin->user_nicename, $admin->user_login ).'">'.bp_core_fetch_avatar( array( 'item_id' => $admin->user_id, 'email' => $admin->user_email, 'alt' => sprintf( __( 'Profile picture of %s', 'rehub_framework' ), bp_core_get_user_displayname( $admin->user_id ) ) ) ).'</a></div>';
					$link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $admin->user_id) .'&ref='. urlencode(get_permalink())) : '#';
					$class = (!is_user_logged_in() && rehub_option('userlogin_enable') == '1') ? ' act-rehub-login-popup' : '';
					$output .='<div class="item"><div class="item-title-bpadmin"><a href="'.bp_core_get_user_domain( $admin->user_id, $admin->user_nicename, $admin->user_login ).'">'.$admin->user_nicename.'</a></div><a href="'.$link.'" class="vendor_store_owner_contactlink'.$class.'"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>'. $txt .'</span></a></div>';					
				$output .= '</li>';
			} 
		$output .= '</ul>';
	}
	return $output; 
}
add_shortcode('rh_get_group_admins', 'rh_get_group_admins');
}


if( !function_exists('rh_get_group_admin_shop') ) {
function rh_get_group_admin_shop($atts, $content = NULL){	
	global $groups_template;
	$output = '';
	if ( empty( $group ) ) {
		$group =& $groups_template->group;
	}

	if (defined('wcv_plugin_dir')):
		foreach( (array) $group->admins as $admin ) {
			if(WCV_Vendors::is_vendor( $admin->user_id )):
				$output .='<div class="user-profile-div">';
					$output .='<div class="mb20 text-center">';
						$output .='<a href="'.WCV_Vendors::get_vendor_shop_page( $admin->user_id ).'"><img src="'. rh_show_vendor_avatar($admin->user_id, 150, 150).'" class="vendor_store_image_single" width=150 height=150 /></a>';
					$output .='</div>';
					$output .='<div class="profile-usertitle-name mb20 text-center">';
						$output .='<a href="'.WCV_Vendors::get_vendor_shop_page( $admin->user_id ).'">'.WCV_Vendors::get_vendor_sold_by( $admin->user_id ).'</a>';
					$output .='</div>';	
					$output .='<div class="profile-stats">';
						if (rehub_option('woo_thumb_enable') == '1') :
							$output .='<div><i class="fa fa-heartbeat"></i>'.__( 'Product Votes', 'rehub_framework' ).': ' . get_user_meta( $admin->user_id, 'overall_post_likes', true).'</div>';					
						endif;
						$output .='<div><i class="fa fa-briefcase"></i>'.__( 'Total products', 'rehub_framework' ).': ' . count_user_posts( $admin->user_id, $post_type = 'product' ).'</div>';
					$output .='</div>';	
				$output .='</div>';
				return $output;							
			endif;
		}
	endif; 
}
add_shortcode('rh_get_group_admin_shop', 'rh_get_group_admin_shop');
}