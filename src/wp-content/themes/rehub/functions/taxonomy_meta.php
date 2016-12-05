<?php

add_action('admin_init', 'category_custom_fields', 1);
if( !function_exists('category_custom_fields') ) {
function category_custom_fields()
    {
        add_action('edit_category_form_fields', 'category_custom_fields_form');
        add_action('edited_category', 'category_custom_fields_save');
        add_action( 'create_category', 'category_custom_fields_save'); 
        add_action( 'category_add_form_fields', 'category_custom_fields_form_new');

    }
}    

if( !function_exists('category_custom_fields_form') ) {
function category_custom_fields_form($tag)
    {
        $t_id = $tag->term_id;
        $cat_meta = get_option("category_$t_id");
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style( 'wp-color-picker' );
?>
        <tr class="form-field color_cat_grade">
        	<th scope="row" valign="top"><label><?php _e('Cat color','rehub_framework'); ?></label></th>
        	<td>
        		<input type="text" name="Cat_meta[cat_color]" id="Cat_meta[cat_color]" size="25" style="width:60%;" value="<?php echo (!empty($cat_meta['cat_color'])) ? $cat_meta['cat_color'] : ''; ?>" data-default-color="#E43917"><br />
	            <script type="text/javascript">
	    			jQuery(document).ready(function($) {   
	        			$('.color_cat_grade input').wpColorPicker();
	    			});             
	    		</script>
                <span class="description"><?php _e('Set category color. Note, this color will be used under white text','rehub_framework'); ?></span>
            </td>
        </tr> 
        <tr class="form-field">
        	<th scope="row" valign="top"><label><?php _e('Category banner custom html','rehub_framework'); ?></label></th>
        	<td>
        		<input type="text" name="Cat_meta[cat_image_url]" id="Cat_meta[cat_image_url]" size="25" style="width:60%;" value="<?php echo (!empty($cat_meta['cat_image_url'])) ? $cat_meta['cat_image_url'] : ''; ?>"><br />
                <span class="description"><?php _e('Set url to image of banner or any custom html, shortcode','rehub_framework'); ?></span>
            </td>
        </tr>          
<?php
    }
}    

if( !function_exists('category_custom_fields_form_new') ) {
function category_custom_fields_form_new($tag)
    {
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style( 'wp-color-picker' );
?>
        <div class="form-field color_cat_grade">
        	<label><?php _e('Cat color','rehub_framework'); ?></label>        	
        		<input type="text" name="Cat_meta[cat_color]" id="Cat_meta[cat_color]" size="25" style="width:60%;" value="" data-default-color="#E43917"><br />
	            <script type="text/javascript">
	    			jQuery(document).ready(function($) {   
	        			$('.color_cat_grade input').wpColorPicker();
	    			});             
	    		</script>
                <span class="description"><?php _e('Set category color. Note, this color will be used under white text','rehub_framework'); ?></span> 
        </div> 
        <div class="form-field">
        	<label><?php _e('Category banner custom html','rehub_framework'); ?></label>
        		<input type="text" name="Cat_meta[cat_image_url]" id="Cat_meta[cat_image_url]" size="25" style="width:60%;" value=""><br />
                <span class="description"><?php _e('Set url to image of banner or any custom html, shortcode','rehub_framework'); ?></span>     
        </div>         
<?php
    }    
}

if( !function_exists('category_custom_fields_save') ) {    
function category_custom_fields_save($term_id)
    {
        if (isset($_POST['Cat_meta'])) {
            $t_id = $term_id;
            $cat_meta = get_option("category_$t_id");
            $cat_keys = array_keys($_POST['Cat_meta']);
            foreach ($cat_keys as $key) {
                if (isset($_POST['Cat_meta'][$key])) {
                    $cat_meta[$key] = $_POST['Cat_meta'][$key];
                }
            }
            //save the option array
            update_option("category_$t_id", $cat_meta);
        }
    }
}    

// A callback function to add a custom field to our "presenters" taxonomy 
if( !function_exists('shopimage_taxonomy_custom_fields') ) { 
function shopimage_taxonomy_custom_fields($tag) {  
   // Check for existing taxonomy meta for the term you're editing  
    $t_id = $tag->term_id; // Get the ID of the term you're editing  
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check 
    if (function_exists('wp_enqueue_media')) {wp_enqueue_media();} 
?>  
<script>
jQuery(document).ready(function ($) {
//Image helper	
	var imageFrame;jQuery(".wpsm_tax_helper_upload_image_button").click(function(e){e.preventDefault();return $self=jQuery(e.target),$div=$self.closest("div.wpsm_tax_helper_image"),imageFrame?void imageFrame.open():(imageFrame=wp.media({title:"Choose Image",multiple:!1,library:{type:"image"},button:{text:"Use This Image"}}),imageFrame.on("select",function(){selection=imageFrame.state().get("selection"),selection&&selection.each(function(e){console.log(e);{var t=e.attributes.sizes.full.url;e.id}$div.find(".wpsm_tax_helper_preview_image").attr("src",t),$div.find(".wpsm_tax_helper_upload_image").val(t)})}),void imageFrame.open())}),jQuery(".wpsm_tax_helper_clear_image_button").click(function(){var e='';return jQuery(this).parent().siblings(".wpsm_tax_helper_upload_image").val(""),jQuery(this).parent().siblings(".wpsm_tax_helper_preview_image").attr("src",e),!1});
});
</script>  
<tr class="form-field">  
    <th scope="row" valign="top">  
        <label for="brand_image"><?php _e('Shop image', 'rehub_framework'); ?></label>  
    </th>  
    <td> 
	<div class="wpsm_tax_helper_image">
		<img src="<?php echo $term_meta['brand_image'] ? $term_meta['brand_image'] : ''; ?>" class="wpsm_tax_helper_preview_image" alt="" style="max-height: 80px" />
		<p class="description"><?php _e('Upload or choose image here for affiliate shop', 'rehub_framework'); ?></p>
		<input name="term_meta[brand_image]" id="term_meta[brand_image]" size="25" style="width:60%;" value="<?php echo $term_meta['brand_image'] ? $term_meta['brand_image'] : ''; ?>" class="wpsm_tax_helper_upload_image" value="" />									
		<a href="#" class="wpsm_tax_helper_upload_image_button button" rel=""><?php _e('Choose Image', 'rehub_framework'); ?></a>
		<small>&nbsp;<a href="#" class="wpsm_tax_helper_clear_image_button button">X</a></small>
		<br /><br />		
	</div>       
    </td>  
</tr>  
  
<?php  
} 
}

// A callback function to add a custom field to our "presenters" taxonomy 
if( !function_exists('shopimage_taxonomy_custom_fields_new') ) { 
function shopimage_taxonomy_custom_fields_new($tag) {  
if (function_exists('wp_enqueue_media')) {wp_enqueue_media();}
?>  
<script>
jQuery(document).ready(function ($) {
//Image helper	
	var imageFrame;jQuery(".wpsm_tax_helper_upload_image_button").click(function(e){e.preventDefault();return $self=jQuery(e.target),$div=$self.closest("div.wpsm_tax_helper_image"),imageFrame?void imageFrame.open():(imageFrame=wp.media({title:"Choose Image",multiple:!1,library:{type:"image"},button:{text:"Use This Image"}}),imageFrame.on("select",function(){selection=imageFrame.state().get("selection"),selection&&selection.each(function(e){console.log(e);{var t=e.attributes.sizes.full.url;e.id}$div.find(".wpsm_tax_helper_preview_image").attr("src",t),$div.find(".wpsm_tax_helper_upload_image").val(t)})}),void imageFrame.open())}),jQuery(".wpsm_tax_helper_clear_image_button").click(function(){var e='';return jQuery(this).parent().siblings(".wpsm_tax_helper_upload_image").val(""),jQuery(this).parent().siblings(".wpsm_tax_helper_preview_image").attr("src",e),!1});
});
</script>  
<div class="form-field"> 
        <label for="brand_image"><?php _e('Shop image', 'rehub_framework'); ?></label>  
		<div class="wpsm_tax_helper_image">
			<img src="" class="wpsm_tax_helper_preview_image" alt="" style="max-height: 80px" />
			<p class="description"><?php _e('Upload or choose image here for affiliate shop', 'rehub_framework'); ?></p>
			<input name="term_meta[brand_image]" id="term_meta[brand_image]" size="25" style="width:60%;" value="" class="wpsm_tax_helper_upload_image" value="" />									
			<a href="#" class="wpsm_tax_helper_upload_image_button button" rel=""><?php _e('Choose Image', 'rehub_framework'); ?></a>
			<small>&nbsp;<a href="#" class="wpsm_tax_helper_clear_image_button button">X</a></small>
			<br /><br />		
		</div>   
</div>  
  
<?php  
}  
}

// A callback function to save our extra taxonomy field(s) 
if( !function_exists('rehub_save_taxonomy_custom_fields') ) { 
function rehub_save_taxonomy_custom_fields( $term_id ) {  
    if ( isset( $_POST['term_meta'] ) ) {  
        $t_id = $term_id;  
        $term_meta = get_option( "taxonomy_term_$t_id" );  
        $cat_keys = array_keys( $_POST['term_meta'] );  
            foreach ( $cat_keys as $key ){  
            if ( isset( $_POST['term_meta'][$key] ) ){  
                $term_meta[$key] = $_POST['term_meta'][$key];  
            }  
        }  
        //save the option array  
        update_option( "taxonomy_term_$t_id", $term_meta );  
    }  
} 
}


// A callback function to add a custom field to our "deal brand" taxonomy 
if( !function_exists('woo_store_rehub_custom_field') ) { 
function woo_store_rehub_custom_field($tag) {  
    wp_nonce_field( basename( __FILE__ ), 'brandimage_nonce' );
   // Check for existing taxonomy meta for the term you're editing  
    $t_id = $tag->term_id; // Get the ID of the term you're editing  
    $term_meta = get_term_meta( $t_id, 'brandimage', true ); 
    if (function_exists('wp_enqueue_media')) {wp_enqueue_media();} 
?>  
<script>
jQuery(document).ready(function ($) {
//Image helper  
    var imageFrame;jQuery(".wpsm_tax_helper_upload_image_button").click(function(e){e.preventDefault();return $self=jQuery(e.target),$div=$self.closest("div.wpsm_tax_helper_image"),imageFrame?void imageFrame.open():(imageFrame=wp.media({title:"Choose Image",multiple:!1,library:{type:"image"},button:{text:"Use This Image"}}),imageFrame.on("select",function(){selection=imageFrame.state().get("selection"),selection&&selection.each(function(e){console.log(e);{var t=e.attributes.sizes.full.url;e.id}$div.find(".wpsm_tax_helper_preview_image").attr("src",t),$div.find(".wpsm_tax_helper_upload_image").val(t)})}),void imageFrame.open())}),jQuery(".wpsm_tax_helper_clear_image_button").click(function(){var e='';return jQuery(this).parent().siblings(".wpsm_tax_helper_upload_image").val(""),jQuery(this).parent().siblings(".wpsm_tax_helper_preview_image").attr("src",e),!1});
});
</script>  
<tr class="form-field">  
    <th scope="row" valign="top">  
        <label for="brand_image"><?php _e('Store image', 'rehub_framework'); ?></label>  
    </th>  
    <td> 
    <div class="wpsm_tax_helper_image">
        <img src="<?php echo $term_meta ? esc_url($term_meta) : ''; ?>" class="wpsm_tax_helper_preview_image" alt="" style="max-height: 80px" />
        <p class="description"><?php _e('Upload or choose image here for affiliate shop', 'rehub_framework'); ?></p>
        <input name="brandimage" id="brandimage" size="25" style="width:60%;" value="<?php echo $term_meta ? esc_url($term_meta) : ''; ?>" class="wpsm_tax_helper_upload_image" value="" />                                    
        <a href="#" class="wpsm_tax_helper_upload_image_button button" rel=""><?php _e('Choose Image', 'rehub_framework'); ?></a>
        <small>&nbsp;<a href="#" class="wpsm_tax_helper_clear_image_button button">X</a></small>
        <br /><br />        
    </div>       
    </td>  
</tr>  
  
<?php  
} 
}

// A callback function to add a custom field to our "deal brand" taxonomy 
if( !function_exists('woo_store_rehub_custom_field_new') ) { 
function woo_store_rehub_custom_field_new($tag) {   
wp_nonce_field( basename( __FILE__ ), 'brandimage_nonce' );
if (function_exists('wp_enqueue_media')) {wp_enqueue_media();}
?>  
<script>
jQuery(document).ready(function ($) {
//Image helper  
    var imageFrame;jQuery(".wpsm_tax_helper_upload_image_button").click(function(e){e.preventDefault();return $self=jQuery(e.target),$div=$self.closest("div.wpsm_tax_helper_image"),imageFrame?void imageFrame.open():(imageFrame=wp.media({title:"Choose Image",multiple:!1,library:{type:"image"},button:{text:"Use This Image"}}),imageFrame.on("select",function(){selection=imageFrame.state().get("selection"),selection&&selection.each(function(e){console.log(e);{var t=e.attributes.sizes.full.url;e.id}$div.find(".wpsm_tax_helper_preview_image").attr("src",t),$div.find(".wpsm_tax_helper_upload_image").val(t)})}),void imageFrame.open())}),jQuery(".wpsm_tax_helper_clear_image_button").click(function(){var e='';return jQuery(this).parent().siblings(".wpsm_tax_helper_upload_image").val(""),jQuery(this).parent().siblings(".wpsm_tax_helper_preview_image").attr("src",e),!1});
});
</script>  
<div class="form-field"> 
        <label for="brand_image"><?php _e('Store image', 'rehub_framework'); ?></label>  
        <div class="wpsm_tax_helper_image">
            <img src="" class="wpsm_tax_helper_preview_image" alt="" style="max-height: 80px" />
            <p class="description"><?php _e('Upload or choose image here for affiliate shop', 'rehub_framework'); ?></p>
            <input name="brandimage" id="brandimage" size="25" style="width:60%;" value="" class="wpsm_tax_helper_upload_image" value="" />                                 
            <a href="#" class="wpsm_tax_helper_upload_image_button button" rel=""><?php _e('Choose Image', 'rehub_framework'); ?></a>
            <small>&nbsp;<a href="#" class="wpsm_tax_helper_clear_image_button button">X</a></small>
            <br /><br />        
        </div>   
</div>  
  
<?php  
}  
}

// A callback function to save our extra taxonomy field(s) 
if( !function_exists('woo_store_rehub_custom_field_save') ) { 
function woo_store_rehub_custom_field_save( $term_id ) { 

    if ( ! isset( $_POST['brandimage'] ) || ! wp_verify_nonce( $_POST['brandimage_nonce'], basename( __FILE__ ) ) )
        return; 
    $term_meta_old = get_term_meta( $term_id, 'brandimage', true );
    $term_meta_old_new = isset( $_POST['brandimage'] ) ? esc_url( $_POST['brandimage'] ) : '';

    if ( $term_meta_old && '' === $term_meta_old_new )
        delete_term_meta( $term_id, 'brandimage' );

    else if ( $term_meta_old !== $term_meta_old_new )
        update_term_meta( $term_id, 'brandimage', $term_meta_old_new );   
} 
}


if(function_exists('thirstyInit')) { add_action('admin_init', 'aff_cat_custom_fields', 1);}
if( !function_exists('aff_cat_custom_fields') ) {
function aff_cat_custom_fields() {    
    // Add the fields to the "presenters" taxonomy, using our callback function  
	add_action( 'thirstylink-category_edit_form_fields', 'shopimage_taxonomy_custom_fields', 10, 2 );  
    // Save the changes made on the "presenters" taxonomy, using our callback function  
	add_action( 'edited_thirstylink-category', 'rehub_save_taxonomy_custom_fields', 10, 2 ); 
    add_action( 'create_thirstylink-category', 'rehub_save_taxonomy_custom_fields'); 
    add_action( 'thirstylink-category_add_form_fields', 'shopimage_taxonomy_custom_fields_new');
}
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	add_action('admin_init', 'woo_tag_custom_fields', 1);
}
if( !function_exists('woo_tag_custom_fields') ) {
function woo_tag_custom_fields() {  
    add_action( 'store_edit_form_fields', 'woo_store_rehub_custom_field', 10, 2 );  
    add_action( 'edited_store', 'woo_store_rehub_custom_field_save', 10, 2 ); 
    add_action( 'create_store', 'woo_store_rehub_custom_field_save'); 
    add_action( 'store_add_form_fields', 'woo_store_rehub_custom_field_new');       
}
}	