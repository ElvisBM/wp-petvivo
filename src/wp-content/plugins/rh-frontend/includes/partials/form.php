<?php
	$form_errors = ( isset( $result['errors'] ) ) ? $result['errors'] : "";
	$submission_status = ( isset( $result['success'] ) ) ? $result['success'] : "";
	$final_post_id 	= ( isset( $current['post_id'] ) ) ? $current['post_id'] : "-1";
	$form_width = ( isset( $this->settings['width'] ) && !empty( $this->settings['width'] ) ) ? ( 'max-width:'. $this->settings['width'] .';') : '';
?>

<form class="wpfepp-form" method="POST" style="<?php echo $form_width ?>">
	
	<div class="wpfepp-message <?php echo ( $submission_status ) ? "success" : "error"; ?><?php echo isset( $form_errors['form'] ) ? 'display' : ''; ?>">
		<?php echo ( isset( $form_errors['form'] ) ) ? $form_errors['form'] : ""; ?>
	</div>

	<div class="wpfepp-form-fields">

		<?php foreach( $this->get_fields() as $field_key => $field ) : ?>

			<?php
				$field_errors = isset( $form_errors[$field_key] ) ? $form_errors[$field_key] : "";
				$element_width = ( isset( $field['width'] ) && !empty( $field['width'] ) ) ? ( 'width:'. $field['width'] .';' ) : ''; 
				$field_current = isset( $current[$field_key] ) ? ( $current[$field_key] ) : "";
				$print_restrictions = $this->print_restrictions( $field );
				$unique_key = 'form-'. $this->id .'-'. $field_key;
			?>
			
			<?php if ( wpfepp_is_field_supported( $field['type'], $this->post_type ) ) :?>
				<?php if ( $field['enabled'] ) : ?>

				<div class="wpfepp-<?php echo $field_key; ?>-field-container wpfepp-form-field-container" style="<?php echo $element_width; ?>">
					<label for="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-form-field-label"><?php echo $field['label']; ?></label>
					
					<div class="wpfepp-form-field-errors"><?php echo $field_errors; ?></div>
					
					<?php if ( isset( $field['prefix_text'] ) && $field['prefix_text'] ) { ?>
						<div class="wpfepp-prefix-text"><?php echo $field['prefix_text']; ?></div>
					<?php } ?>
					
					<?php if ( $field['type'] == 'title' ) { ?>
						<input id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>" type="text" value="<?php echo esc_attr( $field_current ); ?>" <?php echo $print_restrictions; ?> />
					<?php } ?>

					<?php if ( $field['type'] == 'content' ) { ?>
						<?php if ( $field['element'] == 'richtext' ) { ?>
							<?php $media_buttons = ( isset( $field['media_button'] ) ) ? (boolean)$field['media_button'] : true; ?>
							<?php wp_editor( $field_current, "wpfepp-$unique_key-field", array( 
								'wpautop'=>true, 
								'media_buttons'=> $media_buttons, 
								'textarea_name'=>$field_key, 
								'textarea_rows'=>10, 
								'editor_class'=>"wpfepp-$field_key-field wpfepp-form-field"
							) ); ?>
						<?php } else { ?>
							<textarea id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-plain-field wpfepp-form-field" name="<?php echo $field_key; ?>">
								<?php echo esc_textarea( $field_current ); ?>
							</textarea>
						<?php } ?>
						
						<?php if ( ! wpfepp_current_user_has( $this->settings['no_restrictions'] ) ) { ?>
							<script>
								function wpfepp_set_content_restrictions($){
								<?php if ( $field['required'] ) : ?>$('textarea#wpfepp-<?php echo $unique_key; ?>-field').attr('required', 'true');<?php endif; ?>
								<?php if ( $field["min_words"] && is_numeric( $field["min_words"] ) ) : ?>$('textarea#wpfepp-<?php echo $unique_key; ?>-field').attr('minwords', '<?php echo $field["min_words"]; ?>');<?php endif; ?>
								<?php if ( $field["max_words"] && is_numeric( $field["max_words"] ) ) : ?>$('textarea#wpfepp-<?php echo $unique_key; ?>-field').attr('maxwords', '<?php echo $field["max_words"]; ?>');<?php endif; ?>
								<?php if ( $field["max_links"] && is_numeric( $field["max_links"] ) ) : ?>$('textarea#wpfepp-<?php echo $unique_key; ?>-field').attr('maxlinks', '<?php echo $field["max_links"]; ?>');<?php endif; ?> }
							</script>
						<?php } ?>
					<?php } ?>

					<?php if($field['type'] == 'excerpt') { ?>
						<textarea id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>" <?php echo $this->print_restrictions($field); ?> ><?php echo esc_textarea($field_current); ?></textarea>
					<?php } ?>

					<?php if ( $field['type'] == 'thumbnail' ) { ?>
						<div class="wpfepp-<?php echo $field_key; ?>-field">
							<div class="wpfepp-<?php echo $field_key; ?>-container"><?php $this->output_thumbnail($field_current); ?></div>
							<a class="wpfepp-<?php echo $field_key; ?>-link" href="#"><?php _e('Select Featured Image', 'wpfepp-plugin'); ?></a>
							<a class="wpfepp-<?php echo $field_key; ?>-close" href="#"><i class="wpfepp-icon-close"></i></a>
							<input type="hidden" value="<?php echo ( $field_current ) ? esc_attr( $field_current ) : "-1"; ?>" name="<?php echo $field_key; ?>" class="wpfepp-<?php echo $field_key; ?>-id wpfepp-form-field" <?php echo $this->print_restrictions( $field ); ?> />
						</div>
					<?php } ?>
					
					<?php if($field['type'] == 'sku') { ?>
						<input id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>" type="text" value="<?php echo esc_attr($field_current); ?>" <?php echo $this->print_restrictions($field); ?> />
					<?php } ?>
					
					<?php if($field['type'] == 'price') { ?>
						<input id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>" type="text" value="<?php echo esc_attr($field_current); ?>" <?php echo $this->print_restrictions($field); ?> />
					<?php } ?>
					
					<?php if($field['type'] == 'sale_price') { ?>
						<input id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>" type="text" value="<?php echo esc_attr($field_current); ?>" <?php echo $this->print_restrictions($field); ?> />
					<?php } ?>
					
					<?php if($field['type'] == 'product_options') { ?>
						<input type="hidden" name="<?php echo $field_key; ?>" value="1" />
						<span class="wpfepp-sub-label"><?php _e('Product Gallery: ', 'woocommerce'); ?></span>
						<?php 
							wp_enqueue_script( 'wpfepp-meta-boxes-product' );
							if($final_post_id == '-1'):
						?>
							<div id="product_images_container">
								<ul class="product_images">
									<input type="hidden" id="product_image_gallery" name="product_image_gallery" value="">
								</ul>
							</div>
							<p class="add_product_images hide-if-no-js">
								<a href="#" data-choose="<?php esc_attr_e( 'Add Images to Product Gallery', 'woocommerce' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'woocommerce' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'woocommerce' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'woocommerce' ); ?>"><?php _e( 'Add product gallery images', 'woocommerce' ); ?>
								</a>
							</p>
						<?php else:?>
							<?php $post_obj = get_post($final_post_id);
							//hidden field name: product_image_gallery
							//value (string): attachment_ID
							WC_Meta_Box_Product_Images::output($post_obj);?>
						<?php endif;?>

						<span class="wpfepp-sub-label"><?php _e('External: ', 'woocommerce'); ?></span>
						<?php $curr_external = (isset($current[$field_key .'_external']) && $current[$field_key .'_external'] == 'yes') ? 1 : 0; ?>
						<input type="hidden" name="<?php echo $field_key; ?>_external" value="0" />
						<input type="checkbox" id="wpfepp-<?php echo $unique_key; ?>-external-field" class="wpfepp-<?php echo $field_key; ?>-external-field wpfepp-form-field" name="<?php echo $field_key; ?>_external" value="1" <?php checked($curr_external); ?> />
						
						<span class="wpfepp-sub-label"><?php _e('Virtual: ', 'woocommerce'); ?></span>
						<?php $curr_virtual = (isset($current[$field_key .'_virtual']) && $current[$field_key .'_virtual'] == 'yes') ? 1 : 0; ?>
						<input type="hidden" name="<?php echo $field_key; ?>_virtual" value="0" />
						<input type="checkbox" id="wpfepp-<?php echo $unique_key; ?>-virtual-field" class="wpfepp-<?php echo $field_key; ?>-virtual-field wpfepp-form-field" name="<?php echo $field_key; ?>_virtual" value="1" <?php checked($curr_virtual); ?> />

						<span class="wpfepp-sub-label"><?php _e('Downloadable: ', 'woocommerce'); ?></span>
						<?php $curr_downloadable = (isset($current[$field_key .'_downloadable']) && $current[$field_key .'_downloadable'] == 'yes') ? 1 : 0; ?>
						<input type="hidden" name="<?php echo $field_key; ?>_downloadable" value="0" />
						<input type="checkbox" id="wpfepp-<?php echo $unique_key; ?>-downloadable-field" class="wpfepp-<?php echo $field_key; ?>-downloadable-field wpfepp-form-field" name="<?php echo $field_key; ?>_downloadable" value="1" <?php checked($curr_downloadable); ?> />
						
						<div  class="wpfepp-product_external-container wpfepp-form-field-container">
							<label for="<?php echo $field_key; ?>_product_url"><?php _e('Product URL', 'woocommerce'); ?></label>
							<div class="wpfepp-prefix-text"><?php _e('Enter the external URL to the product.', 'woocommerce'); ?></div>
							<?php $curr_product_url = isset($current[$field_key .'_product_url']) ? $current[$field_key .'_product_url'] : ''; ?>
							<input type="text" class="wpfepp-<?php echo $field_key; ?>-exturl-field wpfepp-form-field" name="<?php echo $field_key; ?>_product_url" value="<?php echo esc_attr($curr_product_url); ?>" placeholder="<?php esc_attr_e( "http://", 'woocommerce' ); ?>" />
						</div>
						
						<div class="wpfepp-downloadable_files-container wpfepp-form-field-container">
							<label for="widefat"><?php _e("Downloadable Files", "wpfepp-plugin"); ?></label>
							<table class="widefat">
							<thead>
								<tr></tr>
							</thead>
							<tbody>
								<?php
								$curr_downloadable_files = isset($current[$field_key .'_downloadable_files']) ? $current[$field_key .'_downloadable_files'] : '';

								if( $curr_downloadable_files ) {
									foreach($curr_downloadable_files as $file_key => $file_value) {
										include( 'html-product-download.php' );
									}
								}
								?>		
							</tbody>
							<tfoot>
								<tr>
									<th colspan="4">
										<a href="#" class="wpfepp-button insert" data-row="<?php
											$file_value = array(
												'file' => '',
												'name' => ''
											);
											ob_start();
											include('html-product-download.php');
											echo esc_attr(ob_get_clean());
										?>"><?php _e('Add File', 'woocommerce'); ?></a>
									</th>
								</tr>
							</tfoot>
						</table>

							<label for="<?php echo $field_key; ?>_download_limit"><?php _e('Download Limit', 'woocommerce'); ?></label>
							<div class="wpfepp-prefix-text"><?php _e('Leave blank for unlimited re-downloads.', 'woocommerce'); ?></div>
							<?php $curr_download_limit = isset($current[$field_key .'_download_limit']) ? $current[$field_key .'_download_limit'] : ''; ?>
							<input type="number" class="wpfepp-<?php echo $field_key; ?>-limit-field wpfepp-form-field" name="<?php echo $field_key; ?>_download_limit" id="wpfepp-<?php echo $field_key; ?>-limit-field" value="<?php echo esc_attr($curr_download_limit); ?>" placeholder="<?php _e('Unlimited', 'woocommerce'); ?>" <?php echo $this->print_restrictions($field); ?> /> 
							
							<label for="<?php echo $field_key; ?>_download_expiry"><?php _e('Download Expiry', 'woocommerce'); ?></label>
							<div class="wpfepp-prefix-text"><?php _e('Enter the number of days before a download link expires, or leave blank.', 'woocommerce'); ?></div>
							<?php $curr_download_expiry = isset($current[$field_key .'_download_expiry']) ? $current[$field_key .'_download_expiry'] : ''; ?>
							<input type="number" class="wpfepp-<?php echo $field_key; ?>-expiry-field wpfepp-form-field" name="<?php echo $field_key; ?>_download_expiry" id="wpfepp-<?php echo $field_key; ?>-expiry-field" value="<?php echo esc_attr($curr_download_expiry); ?>" placeholder="<?php _e('Never', 'woocommerce'); ?>" <?php echo $this->print_restrictions($field); ?> /> 

							<label for="<?php echo $field_key; ?>_download_type"><?php _e('Download Type', 'woocommerce'); ?></label>
							<div class="wpfepp-prefix-text"><?php _e('Choose a download type - this controls the <a href="http://schema.org/">schema</a>.', 'woocommerce'); ?></div>
							<?php $curr_download_type = isset($current[$field_key .'_download_type']) ? $current[$field_key .'_download_type'] : ''; ?>
								<select id="wpfepp-<?php echo $unique_key; ?>-type-field" class="wpfepp-<?php echo $field_key; ?>-type-field wpfepp-form-field" name="<?php echo $field_key; ?>_download_type">
									<option value="" <?php selected($curr_download_type); ?>><?php _e('Standard Product', 'woocommerce'); ?></option>
									<option value="application" <?php selected($curr_download_type, 'application'); ?>><?php _e('Application/Software', 'woocommerce'); ?></option>
									<option value="music" <?php selected($curr_download_type, 'music'); ?>><?php _e('Music', 'woocommerce'); ?></option>
								</select> 
						</div>
					<?php } ?>
					
					<?php if( $field['type'] == 'hierarchical_taxonomy' ): ?>
						<?php
							$exclude_terms = ( isset($field['exclude'] ) && !empty( $field['exclude'] ) ) ? $field['exclude'] : '';
							$include_terms = ( isset($field['include'] ) && !empty( $field['include'] ) ) ? $field['include'] : '';
							$hide_empty = ( isset( $field['hide_empty'] ) ) ? $field['hide_empty'] : 0;
							$tax_args = array( 'hide_empty' => $hide_empty, 'exclude' => $exclude_terms, 'include' => $include_terms, 'parent' => 0 );
						?>
						<select id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-hierarchical-taxonomy-field wpfepp-form-field" name="<?php echo $field_key; ?>[]" <?php echo $this->print_restrictions($field); ?>>
							<?php if( !$field['multiple'] ): ?><option value=""><?php _e( 'Select', 'wpfepp-plugin' ); ?> ...</option><?php endif; ?>
							<?php $this->hierarchical_taxonomy_options( $field_key, $tax_args, $field_current ); ?>
						</select>
					<?php endif; ?>

					<?php if( $field['type'] == 'non_hierarchical_taxonomy' ): ?>
						<input id="wpfepp-<?php echo $unique_key; ?>-field" type="text" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-non-hierarchical-taxonomy-field wpfepp-form-field" name="<?php echo $field_key; ?>" value="<?php echo esc_attr($field_current); ?>" <?php echo $this->print_restrictions( $field ); ?> />
					<?php endif; ?>

					<?php if( $field['type'] == 'post_formats' ) { ?>
						<?php $formats = get_theme_support( 'post-formats' ); ?>
						<select id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>">
							<option value="standard"><?php _e('Standard', 'wpfepp-plugin'); ?></option>
							<?php foreach ($formats[0] as $key => $format) { ?>
								<option value="<?php echo $format; ?>" <?php selected($field_current, $format); ?>><?php echo ucfirst($format); ?></option>
							<?php } ?>
						</select>
					<?php } ?>
					
					<?php if ( $field['type'] == 'custom_field' ) : ?>
						<?php if($field['element'] == 'input'  || $field['element'] == 'email' || $field['element'] == 'url'): ?>
							<?php $cf_input_type = ($field['element'] == 'input') ? 'text' : $field['element']; ?>
							<input id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" type="<?php echo $cf_input_type; ?>" name="<?php echo $field_key; ?>" value="<?php echo esc_attr($field_current); ?>" <?php echo $this->print_restrictions($field); ?> />
						<?php elseif($field['element'] == 'textarea'): ?>
							<textarea id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>" <?php echo $this->print_restrictions($field); ?> ><?php echo esc_textarea($field_current); ?></textarea>
						<?php elseif($field['element'] == 'inputdate'): ?>
							<?php $field_current = ($field['unixtime'] == 1 && !empty($field_current)) ? date_i18n( 'Y-m-d', $field_current ) : $field_current; ?>
							<input id="wpfepp-<?php echo $unique_key; ?>-field" type="text" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field wpfepp-form-field-date" name="<?php echo $field_key; ?>" <?php echo $this->print_restrictions($field); ?> value="<?php echo esc_attr($field_current); ?>" /> 
						<?php elseif($field['element'] == 'inputnumb'): ?>
							<input id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" type="number" name="<?php echo $field_key; ?>" value="<?php echo esc_attr($field_current); ?>" <?php echo $this->print_restrictions($field); ?> />	
						<?php elseif($field['element'] == 'map'): ?>
							<input id="wpfepp_map_start_location" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" type="text" name="<?php echo $field_key; ?>" value="<?php echo esc_attr($field_current); ?>" <?php echo $this->print_restrictions($field); ?> placeholder="<?php echo $this->extended['adress_placeholder']; ?>" />
							<input type="hidden" name="rh_map_hidden_adress" id="rh_map_hidden_adress" value="" />
							<?php $this->enqueue_frontend_location_scripts($final_post_id); ?>
						<?php elseif($field['element'] == 'checkbox'): ?>
							<input type="hidden" name="<?php echo $field_key; ?>" value="0" />
							<input type="checkbox" id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>" <?php echo $this->print_restrictions($field); ?> value="1" <?php checked($field_current); ?> />
						<?php elseif($field['element'] == 'select'): ?>
							<?php $field['choices'] = wpfepp_choices($field['choices']); ?>
							<select id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>" <?php echo $this->print_restrictions($field); ?> >
								<option value=""><?php _e('Select', 'wpfepp-plugin'); ?> ...</option>
								<?php foreach ($field['choices'] as $choice): ?>
									<option value="<?php echo esc_attr($choice['key']); ?>"><?php echo $choice['val']; ?></option>
								<?php endforeach; ?>
							</select>
						<?php elseif($field['element'] == 'radio'): ?>
							<?php $field['choices'] = wpfepp_choices($field['choices']); ?>
							<?php foreach ($field['choices'] as $choice): ?>
								<input type="radio" value="<?php echo esc_attr($choice['key']); ?>" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" name="<?php echo $field_key; ?>" <?php echo $this->print_restrictions($field); ?> <?php checked($field_current); ?> /> <?php echo $choice['val']; ?><br/>
							<?php endforeach; ?>
						<?php elseif( $field['element'] == 'image_url' || $field['element'] == 'image_galery' ) : ?>
							<?php
								wp_enqueue_media();
								wp_enqueue_script('wpfepp-media');
							?>
							<?php if( $field['element'] == 'image_url' ) { ?>
							<?php $attachdata = ( $field['attachdata'] == 'attid' ) ?  $field['attachdata'] : 'atturl'; ?>
							<?php $attattribute = ( $field['attachdata'] == 'attid' ) ?  'id': 'url'; ?>
							<div class="wpfepp-media wpfepp-media-single" data-title="<?php _e( "Select Item", "wpfepp-plugin" ) ?>" data-button-text="<?php _e( "Select", "wpfepp-plugin" ) ?>" data-multiple="false" data-attribute="<?php echo esc_attr( $attattribute ); ?>">
								<input id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" type="hidden" name="<?php echo $field_key; ?>" value="<?php echo esc_attr( $field_current ); ?>" />
								<div class="wpfepp-media-preview"><?php echo wpfepp_media_preview_html( $field_current, $attachdata ); ?></div>
								<div class="element-media-controls">
									<a href="#" class="wpfepp-media-select"><?php _e( "Select / Upload File", "wpfepp-plugin" ); ?></a>
									<a href="#" class="wpfepp-media-clear"><i class="wpfepp-icon-close"></i></a>
								</div>
							</div>
							<?php } elseif( $field['element'] == 'image_galery' ) { ?>
							<div class="wpfepp-media wpfepp-media-multiple" data-title="<?php _e( "Select Items", "wpfepp-plugin" ) ?>" data-button-text="<?php _e( "Select", "wpfepp-plugin" ) ?>" data-multiple="true" data-attribute="id">
								<input id="wpfepp-<?php echo $unique_key; ?>-field" class="wpfepp-<?php echo $field_key; ?>-field wpfepp-form-field" type="hidden" name="<?php echo $field_key; ?>" value="<?php echo esc_attr( $field_current ); ?>" />
								<div class="wpfepp-media-preview"><?php echo wpfepp_media_preview_html( $field_current, 'attids' ); ?></div>
								<div class="element-media-controls">
									<a href="#" class="wpfepp-media-select"><?php _e( "Select Gallery Images", "wpfepp-plugin" ); ?></a>
									<a href="#" class="wpfepp-media-clear"><i class="wpfepp-icon-close"></i></a>
								</div>
							</div>
							<?php } ?>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				
				<?php else: ?>
					<?php if ( isset( $field['fallback_value'] ) && $field['fallback_value'] ) : ?>
						<textarea style="display:none;" name="<?php echo $field_key; ?>"><?php echo $field['fallback_value']; ?></textarea>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>

		<?php endforeach; ?>

		<?php $this->user_defined_fields( $current ); ?>

		<?php
			if( $this->settings['captcha_enabled'] && $this->post_status( $final_post_id ) == 'new' ) {
				$this->captcha->render();
			}
		?>		
		<?php //Now that all the visible fields have been generated, create the hidden fields ?>
		<?php if($this->paid_on) { ?>
			<input class="wpfepp-paid-id-field" type="hidden" name="wpfepp_paid_post" value="<?php echo $this->id; ?>" />
		<?php } ?>
		<input class="wpfepp-form-id-field" type="hidden" name="form_id" value="<?php echo $this->id; ?>" />
		<input class="wpfepp-post-id-field" type="hidden" name="post_id" value="<?php echo $final_post_id; ?>" />
		<?php wp_nonce_field( 'wpfepp-form-'.$this->id.'-nonce', '_wpnonce', false, true ); ?>
		<input type="hidden" name="action" value="wpfepp_handle_submission_ajax" />

		<?php //Finally, the submit button ?>
		<button type="submit" class="wpfepp-button wpfepp-submit-button <?php echo (isset($this->settings['button_color'])) ? $this->settings['button_color'] : 'blue'; ?>" name="wpfepp-form-<?php echo $this->id; ?>-submit"><i></i> <?php _e('Submit', 'wpfepp-plugin'); ?></button>
		<?php if( $this->settings['enable_drafts'] && ($this->post_status($final_post_id) == 'new' || $this->post_status($final_post_id) == 'draft') ): ?>
			<button type="submit" class="wpfepp-button wpfepp-save-button cancel" name="wpfepp-form-<?php echo $this->id; ?>-save"><i></i> <?php _e('Save Draft', 'wpfepp-plugin'); ?></button>
		<?php endif; ?>
	</div>
</form>
