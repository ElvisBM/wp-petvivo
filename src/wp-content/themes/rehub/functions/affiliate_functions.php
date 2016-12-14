<?php

if( !function_exists('rehub_get_offer') ) {
function rehub_get_offer(){
	?>
	<?php global $post ?>
    <?php if (vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_post_review_product') : ?>

		<?php $review_aff_link = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_aff_link');

		if(function_exists('thirstyInit') && !empty($review_aff_link)) :?>
			<?php $linkpost = get_post($review_aff_link);
			if ($linkpost) : ?>
				<?php $attachments = get_posts( array(
		            'post_type' => 'attachment',
					'post_mime_type' => 'image',
		            'posts_per_page' => -1,
		            'post_parent' => $linkpost->ID,
		        ) );?>
				<?php $offer_price = get_post_meta( $linkpost->ID, 'rehub_aff_price', true ) ?>
				<?php $offer_desc = get_post_meta( $linkpost->ID, 'rehub_aff_desc', true ) ?>
				<?php $offer_btn_text = get_post_meta( $linkpost->ID, 'rehub_aff_btn_text', true ) ?>
				<?php $offer_price_old = get_post_meta( $linkpost->ID, 'rehub_aff_price_old', true ) ?>
				<?php $offer_coupon = get_post_meta( $linkpost->ID, 'rehub_aff_coupon', true ) ?>
				<?php $offer_coupon_date = get_post_meta( $linkpost->ID, 'rehub_aff_coupon_date', true ) ?>
				<?php $offer_coupon_mask = get_post_meta( $linkpost->ID, 'rehub_aff_coupon_mask', true ) ?>
	            <?php $offer_url = get_post_permalink($review_aff_link) ?>
	            <?php $offer_title = $linkpost->post_title ?>
	            <?php $term_list = wp_get_post_terms($linkpost->ID, 'thirstylink-category', array("fields" => "names"));?>
	            <?php $term_ids =  wp_get_post_terms($linkpost->ID, 'thirstylink-category', array("fields" => "ids")); if (!empty($term_ids) && ! is_wp_error($term_ids)) {$term_brand = $term_ids[0]; $term_brand_image = get_option("taxonomy_term_$term_brand");}?>
	            <?php
	            if (!empty($attachments)) {$offer_thumb = wp_get_attachment_url( $attachments[0]->ID);}
	            elseif (!empty($term_brand_image['brand_image'])) {$offer_thumb = $term_brand_image['brand_image'];}
	            else {$offer_thumb ='';}
	            ?>

				<div class="rehub_feat_block table_view_block"><div class="block_with_coupon">
			        <?php if(!empty($offer_thumb) || (has_post_thumbnail())) : ?>
			            <div class="offer_thumb">
			            <a href="<?php echo $offer_url ?>" target="_blank" class="re_track_btn">
			            	<?php if (!empty($offer_thumb) ) :?>
			            		<img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $offer_thumb, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
			            	<?php else :?>
			            		<?php $image_id = get_post_thumbnail_id($post->ID);  $image_offer_url = wp_get_attachment_url($image_id);?>
			            		<img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $image_offer_url, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
			            	<?php endif ;?>
			            </a>
			            </div>
			   		<?php endif ;?>
			   		<div class="desc_col">
			            <div class="offer_title"><?php echo esc_html($offer_title) ;?></div>
			            <p><?php echo wp_kses_post($offer_desc); ?></p>
			        </div>
			        <?php if ( !empty($offer_price) || !empty($term_list[0])) :?>
				        <div class="price_col">
				        	<?php if(!empty($offer_price)) : ?><p> <span class="price_count"><ins><?php echo esc_html($offer_price) ?></ins><?php if($offer_price_old !='') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?></span></p><?php endif ;?>
				        	<div class="aff_tag">
					            <?php if (!empty($term_brand_image['brand_image'])) :?>
					            	<img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $term_brand_image['brand_image'], $params ); ?>" alt="<?php the_title_attribute(); ?>" />
					            <?php elseif (!empty($term_list[0])) :?>
					            	<?php echo $term_list[0]; ?>
					            <?php endif; ?>
				            </div>
				        </div>
			        <?php endif; ?>
			        <div class="buttons_col">
			            <div class="priced_block clearfix">
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
			                <div><a href="<?php echo $offer_url ?>" class="re_track_btn btn_offer_block" target="_blank" rel="nofollow"><?php if($offer_btn_text !='') :?><?php echo $offer_btn_text ; ?><?php elseif(rehub_option('rehub_btn_text') !='') :?><?php echo rehub_option('rehub_btn_text') ; ?><?php else :?><?php _e('Buy It Now', 'rehub_framework') ?><?php endif ;?></a></div>
							<?php if(!empty($offer_coupon)) : ?>
								<?php wp_enqueue_script('zeroclipboard'); ?>
								<?php if ($offer_coupon_mask !='1') :?>
                                    <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>
                                <?php else :?>
                                    <div class="rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo $linkpost->ID?>" data-dest="<?php echo $offer_url ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?><i class="fa fa-external-link-square"></i></div>
                                <?php endif;?>                            	
							<?php endif ;?>
							<?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>
			            </div>
			        </div>
				</div></div>
			<?php endif ?>

		<?php else :?>

            <?php $offer_price = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_price') ?>
            <?php $offer_url = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_url') ?>
            <?php $offer_title = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_name') ?>
            <?php $offer_thumb = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_thumb') ?>
            <?php $offer_desc = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_desc') ?>
            <?php $offer_btn_text = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_btn_text') ?>
            <?php $offer_price_old = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_price_old') ?>
            <?php $offer_coupon = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_coupon') ?>
            <?php $offer_coupon_date = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_coupon_date') ?>

			<div class="rehub_feat_block table_view_block"><div class="block_with_coupon">
		        <?php if(!empty($offer_thumb) || (has_post_thumbnail())) : ?>
		            <div class="offer_thumb">
		            <a href="<?php echo $offer_url ?>" target="_blank" class="re_track_btn">
		            	<?php if (!empty($offer_thumb) ) :?>
		            		<img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $offer_thumb, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
		            	<?php else :?>
		            		<?php $image_id = get_post_thumbnail_id($post->ID);  $image_offer_url = wp_get_attachment_url($image_id);?>
		            		<img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $image_offer_url, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
		            	<?php endif ;?>
		            </a>
		            </div>
		   		<?php endif ;?>
		   		<div class="desc_col">
		            <div class="offer_title"><?php echo esc_html($offer_title) ;?></div>
		            <p><?php echo wp_kses_post($offer_desc); ?></p>
		        </div>
		        <?php if(!empty($offer_price)) : ?>
		        	<div class="price_col">
		        		<p><span class="price_count"><ins><?php echo esc_html($offer_price) ?></ins><?php if($offer_price_old !='') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?></span></p>
		        	</div>
		        <?php endif ;?>
		        <div class="buttons_col">
		            <div class="priced_block clearfix">
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

		                <div><a href="<?php echo $offer_url ?>" class="re_track_btn btn_offer_block" target="_blank" rel="nofollow"><?php if($offer_btn_text !='') :?><?php echo $offer_btn_text ; ?><?php elseif(rehub_option('rehub_btn_text') !='') :?><?php echo rehub_option('rehub_btn_text') ; ?><?php else :?><?php _e('Buy It Now', 'rehub_framework') ?><?php endif ;?></a></div>
		            	<?php if(!empty($offer_coupon)) : ?>
		            		<?php wp_enqueue_script('zeroclipboard'); ?>
							<div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>						
		            	<?php endif ;?>
		            	<?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>

		            </div>
		        </div>
	        </div></div>

	    <?php endif ;?>

    <div class="clearfix"></div>

    <?php endif ;?>

	<?php
}
}


if( !function_exists('rehub_get_aff_offer') ) {
function rehub_get_aff_offer(){
	?>
	<?php global $post ?>
    <?php if (vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_aff_product') : ?>
       	<div class="rehub_feat_block"><a name="aff-link-list"></a>
            <?php $aff_title = vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_product_name') ?>
            <?php $aff_thumb = vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_product_thumb') ?>
            <div class="aff_offer_desc"><?php if(!empty($aff_thumb) || (has_post_thumbnail())) : ?>
	            <div class="offer_thumb">
	            	<?php if (!empty($aff_thumb) ) :?>
	            		<img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $aff_thumb, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
	            	<?php else :?>
	            		<?php $image_id = get_post_thumbnail_id($post->ID);  $image_offer_url = wp_get_attachment_url($image_id);?>
	            		<img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $image_offer_url, $params ); ?>" alt="<?php the_title_attribute(); ?>" />
	            	<?php endif ;?>
	            </div>
       		<?php endif ;?>
            <div class="offer_title"><?php echo esc_html($aff_title) ;?></div>
            <p><?php echo wp_kses_post(vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_product_desc')); ?></p>

			</div>
			<?php $rehub_aff_post_ids = vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_links');
			if(function_exists('thirstyInit') && !empty($rehub_aff_post_ids)) :?>
				<div class="clearfix"></div>
				<?php $min_aff_price_count = get_post_meta(get_the_ID(), 'rehub_min_aff_price', true); if ($min_aff_price_count !='') : ?>
					<p class="start_price"><?php _e('Pricing starts from ', 'rehub_framework') ?> <span itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer"><?php echo rehub_option('rehub_currency') ?><span itemprop="lowPrice"><?php echo $min_aff_price_count; ?></span></span></p>
				<?php endif ;?>
				<div class="aff_offer_links_heading"><?php _e('Choose best offer', 'rehub_framework') ?> &#8595;</div>
				<div class="aff_offer_links">
				<?php
				$rehub_aff_posts = get_posts(array(
					'post_type'        => 'thirstylink',
					'post__in' => $rehub_aff_post_ids,
	                'orderby' => 'post__in',
					'numberposts' => '-1'
				));
				$result_min = array(); //add array of prices
				foreach($rehub_aff_posts as $aff_post) { ?>
				<?php 	$attachments = get_posts( array(
		            'post_type' => 'attachment',
					'post_mime_type' => 'image',
		            'posts_per_page' => -1,
		            'post_parent' => $aff_post->ID,
	        	) );
				if (!empty($attachments)) {$aff_thumb_list = wp_get_attachment_url( $attachments[0]->ID );} else {$aff_thumb_list ='';}
				$term_list = wp_get_post_terms($aff_post->ID, 'thirstylink-category', array("fields" => "names"));
				$term_ids =  wp_get_post_terms($aff_post->ID, 'thirstylink-category', array("fields" => "ids")); if (!empty($term_ids)) {$term_brand = $term_ids[0]; $term_brand_image = get_option("taxonomy_term_$term_ids[0]");} else {$term_brand_image ='';}
				?>
				<div class="rehub_feat_block table_view_block">
					<?php if (get_post_meta( $aff_post->ID, 'rehub_aff_sticky', true) == '1') :?><div class="vip_corner"><span class="vip_badge"><i class="fa fa-thumbs-o-up"></i></span></div><?php endif ?>
					<div class="block_with_coupon">
						<div class="offer_thumb">
						<a href="<?php echo get_post_permalink($aff_post) ?>" target="_blank" rel="nofollow" class="re_track_btn">
							<?php if (!empty($aff_thumb_list) ) :?>
		            			<img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $aff_thumb_list, $params ); ?>" alt="<?php echo $aff_post->post_title; ?>" />
		            		<?php elseif (!empty($term_brand_image['brand_image'])) :?>
		            			<img src="<?php $params = array( 'width' => 120, 'height' => 120 ); echo bfi_thumb( $term_brand_image['brand_image'], $params ); ?>" alt="<?php echo $aff_post->post_title; ?>" />
		            		<?php else :?>
		            			<img src="<?php echo get_template_directory_uri(); ?>/images/default/noimage_100_70.png" alt="<?php echo $aff_post->post_title; ?>" />
		            		<?php endif?>
		            	</a>
						</div>
						<div class="desc_col">
							<div class="offer_title"><a href="<?php echo get_post_permalink($aff_post) ?>" target="_blank" class="re_track_btn"><?php echo esc_html($aff_post->post_title); ?></a></div>
							<p><?php echo esc_html(get_post_meta( $aff_post->ID, 'rehub_aff_desc', true ));?></p>
							<?php $rehub_aff_review_related = get_post_meta( $aff_post->ID, "rehub_aff_rel", true ); if ( !empty($rehub_aff_review_related)) : ?>
								<a href="<?php echo $rehub_aff_review_related; ?>" target="_blank" class="color_link"><?php _e("Read review", "rehub_framework") ;?></a>
							<?php endif; ?>
						</div>
						<?php
						$product_price = get_post_meta( $aff_post->ID, 'rehub_aff_price', true );
						$offer_price_old = get_post_meta( $aff_post->ID, 'rehub_aff_price_old', true );
						if ( !empty($product_price) || !empty($term_list[0])) :?>
					        <div class="price_col">
								<?php
									if (!empty($product_price)) :
									$price_clean = rehub_price_clean($product_price); //Clean price from currence symbols
									$result_min[] = $price_clean;
								?>
									<p><span class="price_count"><ins><?php echo esc_html($product_price) ;?></ins><?php if($offer_price_old !='') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?></span></p>
								<?php endif ;?>
					        	<div class="aff_tag">
						            <?php if (!empty($term_brand_image['brand_image'])) :?>
						            	<img src="<?php $params = array( 'width' => 100, 'height' => 100 ); echo bfi_thumb( $term_brand_image['brand_image'], $params ); ?>" alt="<?php the_title_attribute(); ?>" />
						            <?php elseif (!empty($term_list[0])) :?>
						            	<?php echo $term_list[0]; ?>
						            <?php endif; ?>
					            </div>
					        </div>
				        <?php endif ;?>
						<div class="buttons_col">
							<div class="priced_block">
							<?php $offer_btn_text = get_post_meta( $aff_post->ID, 'rehub_aff_btn_text', true ) ?>
							<?php $offer_coupon = get_post_meta( $aff_post->ID, 'rehub_aff_coupon', true ) ?>
							<?php $offer_coupon_date = get_post_meta( $aff_post->ID, 'rehub_aff_coupon_date', true ) ?>
							<?php $offer_coupon_mask = get_post_meta( $aff_post->ID, 'rehub_aff_coupon_mask', true ) ?>
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
								<div><a class="re_track_btn btn_offer_block" href="<?php echo get_post_permalink($aff_post) ?>" target="_blank" rel="nofollow"><?php if($offer_btn_text !='') :?><?php echo $offer_btn_text ; ?><?php elseif(rehub_option('rehub_btn_text') !='') :?><?php echo rehub_option('rehub_btn_text') ; ?><?php else :?><?php _e('Buy It Now', 'rehub_framework') ?><?php endif ;?></a></div>
								<?php if(!empty($offer_coupon)) : ?>
									<?php wp_enqueue_script('zeroclipboard'); ?>
									<?php if ($offer_coupon_mask !='1') :?>
	                                    <div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span></div>
	                                <?php else :?>
	                                    <div class="rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>" data-codeid="<?php echo $aff_post->ID?>" data-dest="<?php echo get_post_permalink($aff_post) ?>"><?php if(rehub_option('rehub_mask_text') !='') :?><?php echo rehub_option('rehub_mask_text') ; ?><?php else :?><?php _e('Reveal coupon', 'rehub_framework') ?><?php endif ;?><i class="fa fa-external-link-square"></i></div>
	                                <?php endif;?>
	                            	<?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>
								<?php endif ;?>

							</div>
						</div>
					</div>
				</div>
				<?php
				}
				if (!empty($result_min)) {
 
					$min_aff_price_old = get_post_meta( get_the_ID(), 'rehub_min_aff_price', true );
					$min_aff_price = min($result_min); //Get minimal affiliate price
					if ( $min_aff_price !='' && $min_aff_price_old !='' && $min_aff_price != $min_aff_price_old ){
						update_post_meta(get_the_ID(), 'rehub_min_aff_price', $min_aff_price); // save minimal price of price range affiliate links
						update_post_meta(get_the_ID(), 'rehub_main_product_price', $min_aff_price);
					}
					elseif($min_aff_price !='' && $min_aff_price_old =='') {
						update_post_meta(get_the_ID(), 'rehub_min_aff_price', $min_aff_price);
						update_post_meta(get_the_ID(), 'rehub_main_product_price', $min_aff_price); 
					}					 
				}
				?>
				</div>
			<?php endif;?>
        </div>
        <div class="clearfix"></div>
    <?php endif ;?>
	<?php
}
}

if( !function_exists('rehub_get_woo_offer') ) {
function rehub_get_woo_offer($review_woo_link){
	?>
	<?php global $woocommerce; if($woocommerce) :?>
		<?php
			$args = array(
				'post_type' 		=> 'product',
				'posts_per_page' 	=> 1,
				'no_found_rows' 	=> 1,
				'post_status' 		=> 'publish',
				'p'					=> $review_woo_link,

			);
		?>
		<?php $products = new WP_Query( $args ); if ( $products->have_posts() ) : ?>
    		<?php while ( $products->have_posts() ) : $products->the_post(); global $product?>
    			<?php //$the_ID = get_the_ID();?>
				<?php $offer_price = $product->get_price_html() ?>
	            <?php $woolink = ($product->product_type =='external' && $product->add_to_cart_url() !='') ? $product->add_to_cart_url() : get_post_permalink($product->id) ;?>
	            <?php $offer_title = $product->get_title() ?>
	            <?php $attributes = $product->get_attributes();  ?>
	            <?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy It Now', 'rehub_framework') ;?><?php endif ;?>
	            <?php $gallery_images = $product->get_gallery_attachment_ids(); ?>
	            <?php 
	            	$rehub_woodeals_short = get_post_meta($product->id, 'rehub_woodeals_short', true );
	            	$rehub_woodeals_short_side = get_post_meta($product->id, 'rh_code_incart', true );
	            	$woo_aff_links_inreview = ($rehub_woodeals_short !='' || $rehub_woodeals_short_side !='') ? '1' : ''; ?>
	            <?php $offer_coupon = get_post_meta( $product->id, 'rehub_woo_coupon_code', true ) ?>
	            <?php $offer_coupon_date = get_post_meta( $product->id, 'rehub_woo_coupon_date', true ) ?>
	            <?php $offer_coupon_mask = get_post_meta( $product->id, 'rehub_woo_coupon_mask', true ) ?>
	            <?php $offer_coupon_url = esc_url( $product->add_to_cart_url() ); ?>
	            <?php $coupon_style = $expired = ''; if(!empty($offer_coupon_date)) : ?>
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
					  $expired = '1';
					}
					?>
	          	<?php endif ;?>
	          	<?php do_action('woo_change_expired', $expired); //Here we update our expired?>
				<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?>
				<?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
				<?php $outsidelinkpart = ($coupon_mask_enabled=='1') ? ' data-codeid="'.$product->id.'" data-dest="'.$offer_coupon_url.'" data-clipboard-text="'.$offer_coupon.'" class="masked_coupon"' : '';?>									            
    			<div class="rehub_woo_review">
    				<?php if (!empty ($attributes) || !empty ($gallery_images) || !empty ($woo_aff_links_inreview)) :?>
    					<ul class="rehub_woo_tabs_menu">
				            <li><?php _e('Product', 'rehub_framework') ?></li>
				            <?php if (!empty ($attributes)) :?><li><?php _e('Specification', 'rehub_framework') ?></li><?php endif ;?>
				            <?php if (!empty ($gallery_images)) :?><li><?php _e('Photos', 'rehub_framework') ?></li><?php endif ;?>
				            <?php if (!empty ($woo_aff_links_inreview)) :?><li class='woo_deals_tab'><?php _e('Deals', 'rehub_framework') ?></li><?php endif ;?>
						</ul>
						<?php endif ;?>
						<div class="rehub_feat_block table_view_block<?php echo $reveal_enabled; echo $coupon_style;?>">
			            <div class="rehub_woo_review_tabs" style="display:table-row">
						    <div class="yith_re_block">
        						<?php if(rehub_option('woo_rhcompare') == 1) {echo wpsm_comparison_button(array('class'=>'rhwooloopcompare'));}?>
						        <?php if ( defined( 'YITH_WCWL' )){ ?>
						            <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
						        <?php } ?>
						    </div>			            
				            <div class="offer_thumb">
				            	<a href="<?php echo $woolink ;?>" target="_blank" rel="nofollow" class="re_track_btn">
				            		<?php WPSM_image_resizer::show_static_resized_image(array('thumb'=> true, 'crop'=> false, 'height'=> 120, 'no_thumb_url' => rehub_woocommerce_placeholder_img_src('')));?>
				            	</a>
				            </div>
							<div class="desc_col">
				            	<div class="offer_title"><a href="<?php echo $woolink ;?>" target="_blank" rel="nofollow" class="re_track_btn"><?php echo esc_attr($offer_title) ;?></a></div>
				            	<p><?php kama_excerpt('maxchar=200'); ?></p>
								<?php if (rehub_option('woo_thumb_enable') == '1') :?><?php echo getHotThumb(get_the_ID(), false);?><?php endif;?>
				            </div>
				            <div class="buttons_col">
					            <div class="priced_block clearfix">
					                <?php if(!empty($offer_price)) : ?><p><span class="price_count"><?php echo $offer_price ?></span></p><?php endif ;?>
					                <div>
					                	<?php if ($product->product_type =='external' && $product->add_to_cart_url() ==''  && !empty ($woo_aff_links_inreview)) :?>
					                		<a class='btn_offer_block choose_offer_woo' href="#"><?php _e('Check Deals', 'rehub_framework') ;?></a>
					                	<?php else :?>

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
            							<?php endif; ?>
					                </div>
					            </div>
						        <div class="brand_logo_small">       
						        	<?php WPSM_Woohelper::re_show_brand_tax('list'); //show brand taxonomy?>
						        </div>
				            </div>
		        		</div>
		        		<?php if (!empty ($attributes)) :?>
				        	<div class="rehub_woo_review_tabs">
				     			<div><?php $product->list_attributes() ;?></div>

				        	</div>
			        	<?php endif ;?>
		        		<?php if (!empty ($gallery_images)) :?>
		        			<script>
		        			jQuery(document).ready(function($) {
								'use strict';
		        				$('.rehub_woo_review .pretty_woo a').attr('rel', 'prettyPhoto[rehub_product_gallery]');
								$(".rehub_woo_review .pretty_woo a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
							});
		        			</script>
				        	<div class="rehub_woo_review_tabs pretty_woo">
				     			<?php wp_enqueue_script('prettyphoto');
									foreach ($gallery_images as $gallery_img) {
										?>
										<?php $thumbfull = wp_get_attachment_link($gallery_img, array(100,100)); ?>
										<?php echo $thumbfull; ?>
										<?php
									}
								?>
				        	</div>
			        	<?php endif ;?>
			        	<?php if (!empty ($woo_aff_links_inreview)) :?>
			        		<div class="rehub_woo_review_tabs">
			        			<div class="woo_inreview_deals_links">
			        				<?php echo do_shortcode($rehub_woodeals_short); ?>
			        				<?php echo do_shortcode($rehub_woodeals_short_side); ?>
			        			</div>
			        		</div>
			        	<?php endif ;?>
		        	</div>
		        </div>
		        <div class="clearfix"></div>	        

    		<?php endwhile; endif;  wp_reset_query(); ?>

	<?php endif ;?>
	<?php
}
}

if( !function_exists('rehub_get_woo_list') ) {
function rehub_get_woo_list( $data_source = '', $type ='', $cat = '', $tag = '', $ids = '', $orderby = '', $order = '', $show = '', $show_coupons_only = ''){
?>
<?php echo do_shortcode ('[wpsm_woolist data_source="'.$data_source.'" type="'.$type.'" cat="'.$cat.'" tag="'.$tag.'" ids="'.$ids.'" orderby="'.$orderby.'" order="'.$order.'" show="'.$show.'"]');?>
<?php
}
}


/*-----------------------------------------------------------------------------------*/
# 	Exerpt affiliate button generating
/*-----------------------------------------------------------------------------------*/

if( !function_exists('rehub_create_btn') ) {
function rehub_create_btn ($btn_more='', $showme = '') {
	?>

		<?php
			$aff_url_exist = get_post_meta( get_the_ID(), 'affegg_product_orig_url', true );
			$offer_url_exist = get_post_meta( get_the_ID(), 'rehub_offer_product_url', true );
			$multiofferrows = get_post_meta(get_the_ID(), 'rehub_multioffer_group', true);
		?>
		<?php if (!empty($offer_url_exist)) : ?>

			<?php
				$offer_url = apply_filters('rh_post_offer_url_filter', $offer_url_exist);
			 	$offer_price = get_post_meta( get_the_ID(), 'rehub_offer_product_price', true );
			 	$offer_btn_text = get_post_meta( get_the_ID(), 'rehub_offer_btn_text', true );
			 	$offer_price_old = get_post_meta( get_the_ID(), 'rehub_offer_product_price_old', true );
			 	$offer_coupon = get_post_meta( get_the_ID(), 'rehub_offer_product_coupon', true );
			 	$offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_offer_coupon_date', true );
			 	$offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_offer_coupon_mask', true );
			?>				

			<?php $coupon_style = $expired = ''; if(!empty($offer_coupon_date)) : ?>
				<?php
					$timestamp1 = strtotime($offer_coupon_date);
					$seconds = $timestamp1 - (int)current_time('timestamp',0);
					$days = floor($seconds / 86400);
					$seconds %= 86400;
            		if ($days > 0) {
            			$coupon_style = '';
            		}
            		elseif ($days == 0){
            			$coupon_style = '';
            		}
            		else {
            			$coupon_text = __('Expired', 'rehub_framework');
            			$coupon_style = ' expired_coupon';
            			$expired = '1';
            		}
				?>
			<?php endif ;?>
			<?php do_action('post_change_expired', $expired); //Here we update our expired?>
			<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?> 
			<?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
	        <div class="priced_block clearfix <?php echo $reveal_enabled; echo $coupon_style; ?>">
	            <?php if(!empty($offer_price) && $showme !='button') : ?>
	            	<p>
	            		<span class="price_count">
	            			<ins><?php echo esc_html($offer_price) ?></ins>
	            			<?php if($offer_price_old !='') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?>
	            		</span>
	            	</p>
	            <?php endif ;?>
	    		<?php if($showme !='price') : ?>
		            <div>
			            <a href="<?php echo esc_url ($offer_url) ?>" class="btn_offer_block re_track_btn" target="_blank" rel="nofollow">
			            <?php if($offer_btn_text !='') :?>
			            	<?php echo esc_html ($offer_btn_text); ?>
			            <?php elseif(rehub_option('rehub_btn_text') !='') :?>
			            	<?php echo rehub_option('rehub_btn_text') ; ?>
			            <?php else :?>
			            	<?php _e('Buy It Now', 'rehub_framework') ?>
			            <?php endif ;?>
			            </a>
		            </div>
	            <?php endif;?>	
		    	<?php if ($coupon_mask_enabled =='1') :?>
		    		<?php if($showme !='price') : ?>
			    		<div class="post_offer_anons">
			    			<?php wp_enqueue_script('zeroclipboard'); ?>
		                	<span class="coupon_btn re_track_btn btn_offer_block rehub_offer_coupon masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo esc_html ($offer_coupon) ?>" data-codeid="<?php echo get_the_ID()?>" data-dest="<?php echo esc_url($offer_url) ?>">
		                		<?php if($offer_btn_text !='') :?>
			            			<?php echo esc_html ($offer_btn_text) ; ?>
		                		<?php elseif(rehub_option('rehub_mask_text') !='') :?>
		                			<?php echo rehub_option('rehub_mask_text') ; ?>
		                		<?php else :?>
		                			<?php _e('Reveal coupon', 'rehub_framework') ?>
		                		<?php endif ;?>
		                	</span>
		            	</div>
	            	<?php endif;?>
		    	<?php else : ?>
					<?php if(!empty($offer_coupon) && $showme !='price') : ?>
						<?php wp_enqueue_script('zeroclipboard'); ?>
					  	<div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span>
					  	</div>
				  	<?php endif;?>		    		
		        <?php endif; ?>	            	        
	        </div>
		<?php elseif(!empty($multiofferrows[0]['multioffer_url'])):?>
	        <div class="priced_block clearfix">
                <?php 
                	$min_price = get_post_meta(get_the_ID(), 'rehub_main_product_price', true );
                 	if ($min_price !='' && $showme !='button') : ?>
                		<p>
                			<span class="price_count">
                				<ins><?php echo rehub_option('rehub_currency'); echo $min_price; ?></ins>
                			</span>
                		</p>
                <?php endif ;?>
	            <?php if($showme !='price') : ?>
	            	<div>
	            		<a href="<?php the_permalink();?>#multiofferlist" class="btn_offer_block">
	            			<?php if(rehub_option('rehub_btn_text_aff_links') !='') :?>
	            				<?php echo rehub_option('rehub_btn_text_aff_links') ; ?>
	            			<?php else :?>
	            				<?php _e('Choose offer', 'rehub_framework') ?>
	            			<?php endif ;?>
	            		</a>
	            	</div>
	            <?php endif ;?>
	        </div>		
		<?php elseif (!empty($aff_url_exist)) : ?>

			<?php if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
				include(locate_template( 'inc/parts/affeggbutton.php' ) );
			} ?>
		<?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_post_review_product') : ?>
			<?php $review_aff_link = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_aff_link');
			if(function_exists('thirstyInit') && !empty($review_aff_link)) :?>
				<?php
					$linkpost = get_post($review_aff_link);
				 	$offer_price = get_post_meta( $linkpost->ID, 'rehub_aff_price', true );
				 	$offer_btn_text = get_post_meta( $linkpost->ID, 'rehub_aff_btn_text', true );
				 	$offer_url = get_post_permalink($review_aff_link) ;
				 	$offer_price_old = get_post_meta( $linkpost->ID, 'rehub_aff_price_old', true );
				?>
			<?php else :?>
		        <?php $offer_price = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_price') ?>
		        <?php $offer_url = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_url') ?>
		        <?php $offer_btn_text = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_btn_text') ?>
		        <?php $offer_price_old = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_price_old') ?>
	    	<?php endif;?>
	        <div class="priced_block clearfix">
	            <?php if(!empty($offer_price) && $showme !='button') : ?><p> <span class="price_count"><ins><?php echo esc_html($offer_price) ?></ins><?php if($offer_price_old !='') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?></span></p><?php endif ;?>
	            <?php if($showme !='price') : ?><div><a href="<?php echo esc_url ($offer_url) ?>" class="re_track_btn btn_offer_block" target="_blank" rel="nofollow"><?php if($offer_btn_text !='') :?><?php echo $offer_btn_text ; ?><?php elseif(rehub_option('rehub_btn_text') !='') :?><?php echo rehub_option('rehub_btn_text') ; ?><?php else :?><?php _e('Buy It Now', 'rehub_framework') ?><?php endif ;?></a></div><?php endif ;?>
	        </div>
	    <?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_aff_product') :?>
			<?php $rehub_aff_post_ids = vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_links');
			if(function_exists('thirstyInit') && !empty($rehub_aff_post_ids)) :?>
		        <div class="priced_block clearfix">
	                <?php $min_aff_price_count = get_post_meta(get_the_ID(), 'rehub_min_aff_price', true); if ($min_aff_price_count !='' && $showme !='button') : ?>
	                	<p><span class="price_count"><ins><?php echo rehub_option('rehub_currency'); echo esc_html($min_aff_price_count); ?></ins></span></p>
	                <?php endif ;?>
		            <?php if($showme !='price') : ?><div><a href="<?php the_permalink();?>#aff-link-list" class="btn_offer_block" target="_blank" rel="nofollow"><?php if(rehub_option('rehub_btn_text_aff_links') !='') :?><?php echo rehub_option('rehub_btn_text_aff_links') ; ?><?php else :?><?php _e('Choose offer', 'rehub_framework') ?><?php endif ;?></a></div><?php endif ;?>
		        </div>
	    	<?php endif ;?>
	    <?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_list') :?>
			<?php $review_woo_list_links = vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_links');
			if(class_exists('Woocommerce') && !empty($review_woo_list_links)) :?>
		        <div class="priced_block clearfix">
	                <?php $min_woo_price_count = get_post_meta(get_the_ID(), 'rehub_min_woo_price', true); if ($min_woo_price_count !='' && $showme !='button') : ?>
	                	<p><span class="price_count"><ins><?php echo rehub_option('rehub_currency'); echo $min_woo_price_count; ?></ins></span></p>
	                <?php endif ;?>
		            <?php if($showme !='price') : ?><div><a href="<?php the_permalink();?>#woo-link-list" class="btn_offer_block"><?php if(rehub_option('rehub_btn_text_aff_links') !='') :?><?php echo rehub_option('rehub_btn_text_aff_links') ; ?><?php else :?><?php _e('Choose offer', 'rehub_framework') ?><?php endif ;?></a></div><?php endif ;?>
		        </div>
	    	<?php endif ;?>

		<?php elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') :?>
        	<?php $review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');?>
        	<?php if(rehub_option('rehub_btn_text') !='') :?><?php $btn_txt = rehub_option('rehub_btn_text') ; ?><?php else :?><?php $btn_txt = __('Buy It Now', 'rehub_framework') ;?><?php endif ;?>
        	<?php global $woocommerce; global $post;$backup=$post; if($woocommerce) :?>
				<?php
					$args = array(
						'post_type' 		=> 'product',
						'posts_per_page' 	=> 1,
						'no_found_rows' 	=> 1,
						'post_status' 		=> 'publish',
						'p'					=> $review_woo_link,

					);
				?>
				<?php $products = new WP_Query( $args ); if ( $products->have_posts() ) : ?>
					<?php while ( $products->have_posts() ) : $products->the_post(); global $product?>
					<?php $offer_price = $product->get_price_html() ?>
					<div class="priced_block clearfix">
		                <?php if(!empty($offer_price) && $showme !='button') : ?><p> <span class="price_count"><?php echo $offer_price ?></span></p><?php endif ;?>
		                <?php if($showme !='price') : ?>
			                <div>
			                	<?php if ($product->product_type =='external' && $product->add_to_cart_url() =='') :?>
			                		<a class='re_track_btn btn_offer_block' href="<?php the_permalink();?>" target="_blank"><?php _e('Prices', 'rehub_framework') ;?></a>
			                	<?php else :?>
						            <?php if ( $product->is_in_stock() &&  $product->add_to_cart_url() !='') : ?>
						             <?php  echo apply_filters( 'woocommerce_loop_add_to_cart_link',
						                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" class="woo_loop_btn btn_offer_block %s %s product_type_%s"%s>%s</a>',
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
								<?php endif; ?>
			                </div>
		                <?php endif; ?>
		            </div>
				<?php endwhile; endif;  wp_reset_postdata(); $post=$backup; ?>
        	<?php endif ;?>

        <?php else :?>
        	<?php if ($btn_more =='yes' && $showme !='price') :?>

	        	<?php if (vp_metabox('rehub_post_side.read_more_custom')): ?>
			  		<a href="<?php the_permalink();?>" class="btn_more btn_more_custom"><?php echo strip_tags(vp_metabox('rehub_post_side.read_more_custom'));?></a>
				<?php elseif (rehub_option('rehub_readmore_text') !=''): ?>
			  		<a href="<?php the_permalink();?>" class="btn_more"><?php echo strip_tags(rehub_option('rehub_readmore_text'));?></a>
			  	<?php else: ?>
					<a href="<?php the_permalink();?>" class="btn_more"><?php _e('READ MORE  +', 'rehub_framework') ;?></a>
			  	<?php endif ?>

        	<?php endif ;?>

	    <?php endif ;?>

	<?php
}
}

if( !function_exists('rehub_create_affiliate_link') ) {
function rehub_create_affiliate_link() {
$out='';
$aff_url_exist = get_post_meta( get_the_ID(), 'affegg_product_orig_url', true );
$offer_url_exist = get_post_meta( get_the_ID(), 'rehub_offer_product_url', true );
if(!empty($offer_url_exist) ) :
	$offer_url = apply_filters('rh_post_offer_url_filter', $offer_url_exist );
	$out = esc_url($offer_url);
elseif(!empty($aff_url_exist)) :
	if (version_compare(PHP_VERSION, '5.3.0', '>=')) :
		include(locate_template( 'inc/parts/affeggurl.php' ) );
	endif; 
elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_post_review_product') :
	$review_aff_link = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_aff_link');
	if(function_exists('thirstyInit') && !empty($review_aff_link)) :
		$offer_url = get_post_permalink($review_aff_link);
	else :
        $offer_url = vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_product_url');
	endif;
    $out = $offer_url;
elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_aff_product') :
	$out = get_the_permalink().'#aff-link-list';
elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_list') :
	$out = get_the_permalink().'#woo-link-list';
elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') :
	$review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');
	global $woocommerce; global $post;$backup=$post; if($woocommerce) :
		$args = array(
			'post_type' 		=> 'product',
			'posts_per_page' 	=> 1,
			'no_found_rows' 	=> 1,
			'post_status' 		=> 'publish',
			'p'					=> $review_woo_link,

		);
		$products = new WP_Query( $args );
		if ( $products->have_posts() ) :
		while ( $products->have_posts() ) : $products->the_post(); global $product;
        	if ($product->product_type =='external' && $product->add_to_cart_url() =='') :
        		$out = get_the_permalink();
        	else :
            	$out = esc_url( $product->add_to_cart_url() );
			endif;
		endwhile; endif; wp_reset_postdata(); $post=$backup;
	endif;
elseif (vp_metabox('rehub_post.rehub_framework_post_type') == 'link' && vp_metabox('rehub_post.link_post.0.link_post_url') != '') :
	$offer_url = vp_metabox('rehub_post.link_post.0.link_post_url');
	$out = $offer_url;
else :
	$out = get_the_permalink();
endif;
return $out;
}
}


if( !function_exists('rehub_create_price_for_list') ) {
function rehub_create_price_for_list($id) {
	?>

		<?php
			$offer_price = get_post_meta($id, 'rehub_offer_product_price', true );
			$offer_price_old = get_post_meta($id, 'rehub_offer_product_price_old', true );
			$offer_price_ae = get_post_meta($id, 'affegg_product_price', true );

		if (!empty($offer_price)) : ?>			
    		<span class="simple_price_count">
    			<?php echo esc_html($offer_price) ?>
    			<?php if($offer_price_old !='' && $offer_price_old !='0') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?>
    		</span>
		<?php elseif (!empty($offer_price_ae)) : ?>
    		<?php 
    			$offer_price_old_ae = get_post_meta($id, 'affegg_product_old_price', true );
				$re_egg_currency = get_post_meta($id, 'affegg_product_currency', true );
			?>
            <span class="simple_price_count">
                <?php echo ' <span>'.esc_html($re_egg_currency).' </span>' ?><?php echo esc_html($offer_price_ae); ?>
                <?php if(!empty($offer_price_old_ae) && $offer_price_old_ae !='0') :?> <del><?php echo esc_html($offer_price_old_ae) ; ?></del><?php endif ;?>
            </span>
        <?php elseif ('product' == get_post_type($id)) : ?>
        	<?php global $product;?>
        	<span class="simple_price_count"><?php echo $product->get_price_html();?></span>
	    <?php endif ;?>	    

	<?php
}
}

/*-----------------------------------------------------------------------------------*/
# 	Quick offer function
/*-----------------------------------------------------------------------------------*/

if( !function_exists('rehub_quick_offer') ) {
function rehub_quick_offer($id=''){
	global $post;
	$postid = (!empty($id)) ? $id : $post->ID;
	$multiofferrows = get_post_meta($postid, 'rehub_multioffer_group', true);
	if(!empty($multiofferrows[0]['multioffer_url'])){
		$result_min = array();
		echo '<div class="woo_offer_list multiofferlist">';
		echo '<a name="multiofferlist"></a>';
		foreach ($multiofferrows as $key => $value) {
			$brand_image_url = $brand_link = $brandtermname = $brandterm = '';
			$offer_post_url = (!empty($value['multioffer_url'])) ? $value['multioffer_url'] : '';
			$offer_url = apply_filters('rh_post_multioffer_url_filter', $offer_post_url );
			$offer_coupon = (!empty($value['multioffer_coupon'])) ? $value['multioffer_coupon'] : '';
			$offer_coupon_date = (!empty($value['multioffer_date'])) ? $value['multioffer_date'] : '';
			$offer_coupon_mask = (!empty($value['multioffer_mask'])) ? $value['multioffer_mask'] : '';
			$offer_price = (!empty($value['multioffer_price'])) ? $value['multioffer_price'] : '';
			$offer_price_old = (!empty($value['multioffer_price_old'])) ? $value['multioffer_price_old'] : '';
			$offer_btn_text = (!empty($value['multioffer_btn_text'])) ? $value['multioffer_btn_text'] : '';
			$offer_desc = (!empty($value['multioffer_desc'])) ? $value['multioffer_desc'] : '';
			$offer_title = (!empty($value['multioffer_name'])) ? $value['multioffer_name'] : '';
			$offer_badge = (!empty($value['featured_multioffer'])) ? $value['featured_multioffer'] : '';
			$offer_thumb = (!empty($value['multioffer_image'])) ? $value['multioffer_image'] : '';
			$offer_user = (!empty($value['multioffer_user'])) ? $value['multioffer_user'] : '';
			$offer_brand = (!empty($value['multioffer_brand'])) ? $value['multioffer_brand'] : '';
			$offer_coupon_mask = '1';
			if($offer_brand){
				$brandterm = get_term((int)$offer_brand);
				if(!empty($brandterm) && !is_wp_error($brandterm )){
					$brand_image_url = get_term_meta((int)$offer_brand, 'brandimage', true );
		        	$brand_link = get_term_link((int)$offer_brand );
		        	$brandtermname = $brandterm->name;
				}
			}
            $price_clean = rehub_price_clean($offer_price); 
            $result_min[] = $price_clean;							
			include(locate_template('inc/parts/multiofferpart.php'));
		}
		echo '</div>';
		if (!empty($result_min)) {
			$min_price_old = get_post_meta($postid, 'rehub_main_product_price', true );
			$min_price = min($result_min); 
			if ( $min_price !='' && $min_price_old !='' && $min_price != $min_price_old ){
				update_post_meta($postid, 'rehub_main_product_price', $min_price); 
			}
			elseif($min_price !='' && $min_price_old =='') {
				update_post_meta($postid, 'rehub_main_product_price', $min_price);
			}					 
		}		
	}
	else{
		$offer_post_url = get_post_meta( $postid, 'rehub_offer_product_url', true );
		$offer_url = apply_filters('rh_post_offer_url_filter', $offer_post_url );
		$offer_price = get_post_meta( $postid, 'rehub_offer_product_price', true );
		$offer_title = get_post_meta( $postid, 'rehub_offer_name', true );
		$offer_thumb = get_post_meta( $postid, 'rehub_offer_product_thumb', true );
		$offer_btn_text = get_post_meta( $postid, 'rehub_offer_btn_text', true );
		$offer_price_old = get_post_meta( $postid, 'rehub_offer_product_price_old', true );
		$offer_coupon = get_post_meta( $postid, 'rehub_offer_product_coupon', true );
		$offer_coupon_date = get_post_meta( $postid, 'rehub_offer_coupon_date', true );
		$offer_coupon_mask = get_post_meta( $postid, 'rehub_offer_coupon_mask', true );
		$offer_desc = get_post_meta( $postid, 'rehub_offer_product_desc', true );
		$offer_brand_url = esc_url (get_post_meta( $postid, 'rehub_offer_logo_url', true ));
		include(locate_template('inc/parts/singleofferpart.php'));	
	}	
}
}

/*-----------------------------------------------------------------------------------*/
# 	Hook offer after content
/*-----------------------------------------------------------------------------------*/

if( !function_exists('set_content_end') ) {
function set_content_end($content) {
	global $post;

	if( is_feed() || !is_singular()) return $content;

	$output = '';
	ob_start();
	wp_link_pages(array( 'before' => '<div class="page-link"><span class="page-link-title">' . __( 'Pages:', 'rehub_framework' ).'</span>', 'after' => '</div>', 'pagelink' => '<span>%</span>' ));
	$output .= ob_get_clean();
	if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review') :
		if(vp_metabox('rehub_post.review_post.0.review_post_product.0.review_post_offer_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_post_review_product') :
			ob_start();
			rehub_get_offer();
			$output .= ob_get_clean();
		endif;
		if(vp_metabox('rehub_post.review_post.0.review_aff_product.0.review_aff_offer_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_aff_product') :
			ob_start();
			rehub_get_aff_offer();
			$output .= ob_get_clean();
		endif;
		if(vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_offer_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_product') :
			$review_woo_link = vp_metabox('rehub_post.review_post.0.review_woo_product.0.review_woo_link');
			ob_start();
			rehub_get_woo_offer($review_woo_link);
			$output .= ob_get_clean();
		endif;
		if(vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_shortcode') != '1' && vp_metabox('rehub_post.review_post.0.review_post_schema_type') == 'review_woo_list') :
			$review_woo_list_links = vp_metabox('rehub_post.review_post.0.review_woo_list.0.review_woo_list_links');
			if (is_array($review_woo_list_links)) { $review_woo_list_links = implode(',', $review_woo_list_links); }
			ob_start();
			echo do_shortcode('[wpsm_woolist data_source="ids" ids="'.$review_woo_list_links.'"]');
			$output .= ob_get_clean();
		endif;
	endif;

	if(vp_metabox('rehub_post.rehub_framework_post_type') == 'review' && vp_metabox('rehub_post.review_post.0.review_post_product_shortcode') == '0') :
		ob_start();
		rehub_get_review();
		$output .= ob_get_clean();
	endif;
	$post_layout = vp_metabox('rehub_post_side._post_layout');
	if ($post_layout == 'meta_compact' || $post_layout == 'meta_compact_dir' || $post_layout == 'corner_offer' || $post_layout == 'big_post_offer' || $post_layout == 'offer_and_review'){
			$offer_url_exist = get_post_meta( $post->ID, 'rehub_offer_product_url', true );
			if (!empty($offer_url_exist)) :
				ob_start();
				echo '<div class="rehub_quick_offer_justbtn text-center">';
				rehub_create_btn('', 'button');
				echo '</div>';
				$output .= ob_get_clean();
			endif;		
	}	

	return $content.$output;
}
}
add_filter ('the_content', 'set_content_end');


//Save data from CE
function rehub_sort_price_ce ($a, $b) {
	if (!$a['price']) return 1;
	if (!$b['price']) return -1;
	return $a['price'] - $b['price'];
}
if (!function_exists('rehub_save_meta_ce')) {
    function rehub_save_meta_ce($data, $module_id, $post_id = null) {
		if (!$post_id){
			global $post;
			if (isset($post)){
				$post_id = $post->ID;
			}
			else{
				return false; // Error: no POST ID
			}
		}
        $cegg_field_array = rehub_option('save_meta_for_ce');
        $cegg_fields = array();
    	if (!empty($cegg_field_array) && is_array($cegg_field_array)) {

        	foreach ($cegg_field_array as $cegg_field) {
        		$cegg_field_value = get_post_meta ($post_id, '_cegg_data_'.$cegg_field.'', true);
        		if (!empty ($cegg_field_value) && is_array($cegg_field_value)) {
                    foreach ($cegg_field_value as $key => $value) {
                        $value['module_id'] = $cegg_field;
                        $cegg_fields[$key] = $value;
                    }        			
        			//$cegg_fields += $cegg_field_value;
        		}		
        	}

        	$postsync = get_post_meta($post_id, '_rh_post_offer_sync_ce', true); 
			if (!empty($cegg_fields) && is_array($cegg_fields)) {

				//Check how to sync
	        	if($postsync){
	        		if($postsync == 'none'){
	        			return false;
	        		}
	        		elseif($postsync == 'lowest'){
	        			$keyupdate = 0;
	        			usort($cegg_fields, 'rehub_sort_price_ce'); 
	        		}
	        		else{
	        			$keyupdate = $postsync;
	        			if(!isset($cegg_fields[$keyupdate])){
	        				update_post_meta($post_id, '_rh_post_offer_sync_ce', 'lowest'); 
			        		$keyupdate = 0;
			        		usort($cegg_fields, 'rehub_sort_price_ce');
	        			}
	        		}
	        	}
	        	else{
	        		$keyupdate = 0;
	        		usort($cegg_fields, 'rehub_sort_price_ce'); 
	        	}

				$price_sale = $price_old = '';        							
				$currency_code = (!empty($cegg_fields[$keyupdate]['currencyCode'])) ? $cegg_fields[$keyupdate]['currencyCode'] : '';
	    		if(!empty ($cegg_fields[$keyupdate]['price'])) { //Saving price with price pattern
					$price_sale = RhPriceTemplateHelper::formatPriceCurrency($cegg_fields[$keyupdate]['price'], $currency_code);
	    		}	
	    		if(!empty ($cegg_fields[$keyupdate]['priceOld'])) {
	    			$price_old = RhPriceTemplateHelper::formatPriceCurrency($cegg_fields[$keyupdate]['priceOld'], $currency_code);
	    		}
				if ('product' == get_post_type($post_id)) {
					if(!empty ($cegg_fields[$keyupdate]['price'])) {						
						update_post_meta($post_id, '_price', $cegg_fields[$keyupdate]['price']);
						if(!empty ($cegg_fields[$keyupdate]['priceOld'])) {
							update_post_meta($post_id, '_sale_price', $cegg_fields[$keyupdate]['price']);
						}
						else{
							update_post_meta($post_id, '_regular_price', $cegg_fields[$keyupdate]['price']);
						}
					}
					if(!empty ($cegg_fields[$keyupdate]['priceOld'])) {
						update_post_meta($post_id, '_regular_price', $cegg_fields[$keyupdate]['priceOld']);
					}
					//wp_set_object_terms($post_id, 'external', 'product_type', false );
					//update_post_meta($post_id, '_product_url', $cegg_fields[$keyupdate]['url']);									
				}	
				else {
					update_post_meta($post_id, 'rehub_main_product_price', $cegg_fields[$keyupdate]['price']);			
		    		if(!empty($cegg_fields[$keyupdate]['currencyCode'])){
		    			update_post_meta($post_id, 'rehub_main_product_currency', $cegg_fields[$keyupdate]['currencyCode']);
		    		}
			    	update_post_meta($post_id, 'rehub_offer_product_price', $price_sale);
			    	if ($price_old == '') {
			    		delete_post_meta($post_id, 'rehub_offer_product_price_old');
			    	}
			    	else{
			    		update_post_meta($post_id, 'rehub_offer_product_price_old', $price_old);
			    	}		    					 
		    		update_post_meta($post_id, 'rehub_offer_product_url', $cegg_fields[$keyupdate]['url']);	 
		    		if(!empty ($cegg_fields[$keyupdate]['title'])) {
		    			update_post_meta($post_id, 'rehub_offer_name', esc_html($cegg_fields[$keyupdate]['title'])); 
		    		}
		    		if(!empty ($cegg_fields[$keyupdate]['domain'])) {
		    			$domain = $cegg_fields[$keyupdate]['domain'];
		    			update_post_meta($post_id, 'rehub_offer_domain', $domain); 
		    		}		    		
		    		elseif(!empty ($cegg_fields[$keyupdate]['extra']['domain'])) {
		    			$domain = $cegg_fields[$keyupdate]['extra']['domain'];
		    			update_post_meta($post_id, 'rehub_offer_domain', $domain); 
		    		}	
		    		if(!empty ($cegg_fields[$keyupdate]['merchant'])) {
		    			$merchant = $cegg_fields[$keyupdate]['merchant'];
		    			update_post_meta($post_id, 'rehub_offer_merchant', $merchant); 
		    		}	
            		if (!empty($cegg_fields[$keyupdate]['logo'])){
            			$logo = $cegg_fields[$keyupdate]['logo'];
            		}		    		
            		elseif (!empty($cegg_fields[$keyupdate]['extra']['logo'])){
            			$logo = $cegg_fields[$keyupdate]['extra']['logo'];
            		}
            		elseif(!empty($cegg_fields[$keyupdate]['extra']['MerchantLogoURL'])){
            			$logo = $cegg_fields[$keyupdate]['extra']['MerchantLogoURL'];
            		}
            		else{
            			$logo = '';
            		}
            		if($logo){
            			update_post_meta($post_id, 'rehub_offer_logo_url', $logo);	 
            		}
	    			    			    			    		
		    		if(!empty ($cegg_fields[$keyupdate]['description'])) {
		    			update_post_meta($post_id, 'rehub_offer_product_desc', esc_html($cegg_fields[$keyupdate]['description'])); 
		    		}
		    		if(!empty ($cegg_fields[$keyupdate]['img'])) {
		    			update_post_meta($post_id, 'rehub_offer_product_thumb', $cegg_fields[$keyupdate]['img']); 
		    		}
		    		if(!empty ($cegg_fields[$keyupdate]['module_id'])) {
		    			update_post_meta($post_id, '_rehub_module_ce_id', $cegg_fields[$keyupdate]['module_id']); 
		    		}
		    		if(!empty ($cegg_fields[$keyupdate]['unique_id'])) {
		    			update_post_meta($post_id, '_rehub_product_unique_id', $cegg_fields[$keyupdate]['unique_id']); 
		    		}		    				    		
	    		}	        	

			}

    		$url_field = get_post_meta ($post_id, 'rehub_offer_product_url', true);
    		if (rehub_option('delete_meta_for_ce') == '1' && !empty($url_field) && empty($cegg_fields)) {
    			delete_post_meta($post_id, 'rehub_offer_product_price'); 
    			delete_post_meta($post_id, 'rehub_main_product_currency'); 
    			delete_post_meta($post_id, 'rehub_offer_product_price_old');
    			delete_post_meta($post_id, 'rehub_offer_product_url');  
    			delete_post_meta($post_id, 'rehub_main_product_price');
    			delete_post_meta($post_id, 'rehub_offer_name');
    			delete_post_meta($post_id, 'rehub_offer_product_desc');
    			delete_post_meta($post_id, 'rehub_offer_product_thumb');    			  			    			
    		}

    	}
    }
}
if (!function_exists('rh_save_autoblog_ce')) {
function rh_save_autoblog_ce ($post_id){ 
    $cegg_field_array = rehub_option('save_meta_for_ce');
    $cegg_fields = array();
    if (!empty($cegg_field_array) && is_array($cegg_field_array)) {
    	foreach ($cegg_field_array as $cegg_field) {
    		$cegg_field_value = get_post_meta ($post_id, '_cegg_data_'.$cegg_field.'', true);
    		if (!empty ($cegg_field_value) && is_array($cegg_field_value)) {
                foreach ($cegg_field_value as $key => $value) {
                    $value['module_id'] = $cegg_field;
                    $cegg_fields[$key] = $value;
                }     			
    			//$cegg_fields += $cegg_field_value;
    		}		
    	}
    	usort($cegg_fields, 'rehub_sort_price_ce');
    }
	if (!empty($cegg_field_array) && is_array($cegg_field_array)) {
		if (!empty($cegg_fields) && is_array($cegg_fields)) {
			$price_sale = $price_old = '';   
			$currency_code = (!empty($cegg_fields[0]['currencyCode'])) ? $cegg_fields[0]['currencyCode'] : '';
    		if(!empty ($cegg_fields[0]['price'])) { //Saving price with price pattern
				$price_sale = RhPriceTemplateHelper::formatPriceCurrency($cegg_fields[0]['price'], $currency_code);
    		}	
    		if(!empty ($cegg_fields[0]['priceOld'])) {
    			$price_old = RhPriceTemplateHelper::formatPriceCurrency($cegg_fields[0]['priceOld'], $currency_code);
    		}
			if ('product' == get_post_type($post_id)) {
				if(!empty ($cegg_fields[0]['price'])) {						
					update_post_meta($post_id, '_price', $cegg_fields[0]['price']);
					if(!empty ($cegg_fields[0]['priceOld'])) {
						update_post_meta($post_id, '_sale_price', $cegg_fields[0]['price']);
					}
					else{
						update_post_meta($post_id, '_regular_price', $cegg_fields[0]['price']);
					}
				}
				if(!empty ($cegg_fields[0]['priceOld'])) {
					update_post_meta($post_id, '_regular_price', $cegg_fields[0]['priceOld']);
				}
				//wp_set_object_terms($post_id, 'external', 'product_type', false );
				//update_post_meta($post_id, '_product_url', $cegg_fields[0]['url']);									
			}	
			else {   		
	    		update_post_meta($post_id, 'rehub_main_product_price', $cegg_fields[0]['price']);
		    	update_post_meta($post_id, 'rehub_offer_product_price', $price_sale);
		    	if ($price_old == '') {
		    		delete_post_meta($post_id, 'rehub_offer_product_price_old');
		    	}
		    	else{
		    		update_post_meta($post_id, 'rehub_offer_product_price_old', $price_old);
		    	}		    					 
	    		update_post_meta($post_id, 'rehub_offer_product_url', $cegg_fields[0]['url']);	 
	    		if(!empty ($cegg_fields[0]['title'])) {
	    			update_post_meta($post_id, 'rehub_offer_name', esc_html($cegg_fields[0]['title'])); 
	    		}	    		
	    		if(!empty ($cegg_fields[0]['description'])) {
	    			update_post_meta($post_id, 'rehub_offer_product_desc', esc_html($cegg_fields[0]['description'])); 
	    		}
	    		if(!empty ($cegg_fields[0]['img'])) {
	    			update_post_meta($post_id, 'rehub_offer_product_thumb', $cegg_fields[0]['img']); 
	    		}
	    		if(!empty ($cegg_fields[0]['extra']['domain'])) {
	    			$domain = $cegg_fields[0]['extra']['domain'];
	    			update_post_meta($post_id, 'rehub_offer_domain', $domain); 
	    		}	
	    		if(!empty ($cegg_fields[0]['merchant'])) {
	    			$merchant = $cegg_fields[0]['merchant'];
	    			update_post_meta($post_id, 'rehub_offer_merchant', $merchant); 
	    		}	
        		if (!empty($cegg_fields[0]['extra']['logo'])){
        			$logo = $cegg_fields[0]['extra']['logo'];
        		}
        		elseif(!empty($cegg_fields[0]['extra']['MerchantLogoURL'])){
        			$logo = $cegg_fields[0]['extra']['MerchantLogoURL'];
        		}
        		elseif (!empty($cegg_fields[0]['extra']['programLogo'])){
        			$logo = $cegg_fields[0]['extra']['programLogo'];
        		}
        		else{
        			$logo = '';
        		}
        		if($logo){
        			update_post_meta($post_id, 'rehub_offer_logo_url', $logo);	 
        		}	    		
	    		if(!empty ($cegg_fields[0]['module_id'])) {
	    			update_post_meta($post_id, '_rehub_module_ce_id', $cegg_fields[0]['module_id']); 
	    		}
	    		if(!empty ($cegg_fields[0]['unique_id'])) {
	    			update_post_meta($post_id, '_rehub_product_unique_id', $cegg_fields[0]['unique_id']); 
	    		}

    		}
		}
	}
}
}
add_action('content_egg_save_data', 'rehub_save_meta_ce', 13, 3);
add_action('cegg_autoblog_post_create', 'rh_save_autoblog_ce', 13, 1);


//////////////////////////////////////////////////////////////////
//EXPIRE FUNCTION
//////////////////////////////////////////////////////////////////
add_action('post_change_expired', 'post_change_expired_function', 10, 1);
if (!function_exists('post_change_expired_function')) {
function post_change_expired_function($expired=''){
	global $post;
	$expired_exist = get_post_meta($post->ID, 're_post_expired', true);
	if($expired ==1 && $expired_exist !=1){
		update_post_meta($post->ID, 're_post_expired', 1);
	}
	elseif($expired =='' && $expired_exist == 1){
		update_post_meta($post->ID, 're_post_expired', 0);
	}	
	elseif($expired_exist==''){
		update_post_meta($post->ID, 're_post_expired', 0);
	}
}
}

if (!function_exists('rh_expired_or_not')) {
function rh_expired_or_not($id, $type='class'){
	if (empty($id) || !is_numeric($id)) return;
	$expired = get_post_meta($id, 're_post_expired', true);
	if ($type == 'class'){
		if ($expired == 1) {
			return ' rh-expired-class';
		}
	}
	if ($type == 'span'){
		if ($expired == 1) {
			return '<span class="rh-expired-notice">'.__('Expired', 'rehub_framework').'</span>';
		}
	}	
}
}

if ( !function_exists( 'rh_review_frontend_fields' ) ) {
function rh_review_frontend_fields($current_values){
	$criteriaNamesArray = $review_post_criteria = array();	
	$review_heading = $review_summary = $criteriaInputs = $review_proses = $review_conses = '';
	$reviewCriteria = rehub_option('rh_front_review_fields');
	if ($reviewCriteria){
		$currentReview = get_post_meta( $current_values['post_id'], 'review_post' );
		$currentReviewscore = (get_post_meta( $current_values['post_id'], 'rehub_review_overall_score', true ) !='') ? get_post_meta( $current_values['post_id'], 'rehub_review_overall_score', true ) * 10 : 0;
		if (!empty($currentReview)){
			$review_heading = $currentReview[0][0]['review_post_heading'];
			$review_summary = $currentReview[0][0]['review_post_summary_text'];
			$review_proses = $currentReview[0][0]['review_post_pros_text'];
			$review_conses = $currentReview[0][0]['review_post_cons_text'];					
		}
		wp_enqueue_style('jquery.nouislider'); 
		wp_enqueue_script('jquery.nouislider'); 		
		$reviewCriteria = explode(',', $reviewCriteria);
	    
		for($i = 0; $i < count($reviewCriteria); $i++) {
			$criteriaNamesArray[$i] = $reviewCriteria[$i];
			$scorevalue = (!empty($currentReview[0][0]['review_post_criteria'][$i]['review_post_score'])) ? $currentReview[0][0]['review_post_criteria'][$i]['review_post_score'] : 0;
			$criteriaInputs .= '<label for="criteria_input_'.$i.'">'.$reviewCriteria[$i].'</label>';
			$criteriaInputs .= '<input id="criteria_input_'.$i.'" type="hidden" name="criteria_score_'.$i.'" value="'.$scorevalue.'" class="criteria_hidden_input'.$i.'" /><span class="criteria_visible_input'.$i.'"></span><div class="rh_front_criteria"></div>';
		};
		$criteriaInputs .= '<div class="your_total_score">'.__('Your total score','rehub_framework').' <span class="user_reviews_view_score"><span class="userstar-rating"><span style="width: '.$currentReviewscore.'%"></span></span></span></div><input type="hidden" name="criteria_names" value="'.implode(",", $criteriaNamesArray).'" />';

	    ?> 
	    <div id="user_reviews_in_frontend" class="rate_bar_wrap">
	    	<div class="wpfepp-form-field-container">
	    		<label><?php _e('Review heading', 'rehub_framework');?></label>
	        	<input type="text" name="review_heading" value="<?php echo $review_heading; ?>" />
	        </div>
	        <div class="wpfepp-form-field-container">
				<label><?php _e('Review summary', 'rehub_framework');?></label>
	        	<textarea name="review_summary"><?php echo $review_summary; ?></textarea>
	        </div>
	        <div class="wpfepp-form-field-container">
				<label><?php _e('PROS. Add each from separate line', 'rehub_framework');?></label>
	        	<textarea name="review_post_pros_text"><?php echo $review_proses; ?></textarea>
	        </div>
	        <div class="wpfepp-form-field-container">
				<label><?php _e('CONS. Add each from separate line', 'rehub_framework');?></label>
	        	<textarea name="review_post_cons_text"><?php echo $review_conses; ?></textarea>
	        </div>	        	        
	        <div class="wpfepp-form-field-container">        
	        	<?php echo $criteriaInputs; ?>
	        </div>
	    </div>
	    <?php		
	}
}
}

if ( !function_exists( 'rh_review_frontend_actions' ) ) {
function rh_review_frontend_actions($data){
    $criterianames = $data['criteria_names'];
    if (!empty($criterianames)){
    	$criterianames = explode(',', $criterianames);
		$review_post_criteria = array();
		$review_criteria_overall = $total_counter = 0;
		$postscore = '';    	
		for( $i = 0; $i < count($criterianames); $i++ ) {
			$review_name = $criterianames[$i];
			$review_score = 'criteria_score_' . $i;			
			$review_post_criteria[] = array( 'review_post_name' => $review_name, 'review_post_score' => $data[$review_score] );
			$review_criteria_overall += $data[$review_score];
			$total_counter ++;
		}    
		if( $review_criteria_overall !=0 && $total_counter !=0) {
			$postscore =  $review_criteria_overall / $total_counter ;			
		} 					
    }
	$review_post_array = array (
	  array (
		'rehub_review_slider' => '0',
		'rehub_review_slider_resize' => '0',
		'rehub_review_slider_images' => 
		array ( 
		  array (
			'review_post_image' => '',
			'review_post_image_caption' => '',
			'review_post_image_url' => '',
			'review_post_video' => ''
		  )
		),
		'review_post_schema_type' => 'review_post_review_simple',
		'review_post_product' => 
		array (
		  array (
			'review_aff_link' => '',
			'review_aff_link_preview' => '',
			'review_post_offer_shortcode' => '0'
		  )
		),
		'review_woo_product' => 
		array (
		  array (
			'review_woo_link' => '',
			'review_woo_slider' => '0',
			'review_woo_slider_resize' => '0',
			'review_woo_offer_shortcode' => '0'
		  )
		),
		'review_woo_list' => 
		array (
		  array (
			'review_woo_list_links' => '',
			'review_woo_list_shortcode' => '0'
		  )
		),
		'review_aff_product' => 
		array (
		  array (
			'review_aff_product_name' => '',
			'review_aff_product_desc' => '',
			'review_aff_product_thumb' => '',
			'review_aff_offer_shortcode' => '0'
		  )
		),
		'review_post_heading' => $data['review_heading'],
		'review_post_summary_text' => $data['review_summary'],
		'review_post_pros_text' => $data['review_post_pros_text'],	
		'review_post_cons_text' => $data['review_post_cons_text'],			
		'review_post_product_shortcode' => '0',
		'review_post_score_manual' => '',
		'review_post_criteria' => $review_post_criteria
	  )
	);    
	$review_post_s_array = rh_serialize_data_review( $review_post_array );
	update_post_meta($data['post_id'], 'review_post', $review_post_s_array );
	if (!empty($postscore)) {
		update_post_meta($data['post_id'], 'rehub_review_overall_score', $postscore );
	}	
	$data_post_fields = array( 'rehub_framework_post_type', 'video_post', 'gallery_post', 'review_post', 'music_post' );
	update_post_meta($data['post_id'], 'rehub_post_fields', rh_serialize_data_review( $data_post_fields ) );	
	update_post_meta($data['post_id'], 'rehub_framework_post_type', 'review' );
}
}

if (rehub_option('rh_front_reviewform_id') !='') {
	$formidforreview = rehub_option('rh_front_reviewform_id');
	add_action('wpfepp_form_'.$formidforreview.'_actions', 'rh_review_frontend_actions');
	add_action('wpfepp_form_'.$formidforreview.'_fields', 'rh_review_frontend_fields');
}

/*-----------------------------------------------------------------------------------*/
# 	SINGLE AFF POST BUTTON
/*-----------------------------------------------------------------------------------*/

if( !function_exists('rehub_create_btn_post') ) {
function rehub_create_btn_post ($showme = '', $size = 'medium') {
	?>

		<?php
			$offer_url_exist = get_post_meta( get_the_ID(), 'rehub_offer_product_url', true );
			$multiofferrows = get_post_meta(get_the_ID(), 'rehub_multioffer_group', true);
		if (!empty($offer_url_exist)) : ?>

			<?php
				$offer_url = apply_filters('rh_post_offer_url_filter', $offer_url_exist );
			 	$offer_price = get_post_meta( get_the_ID(), 'rehub_offer_product_price', true );
			 	$offer_btn_text = get_post_meta( get_the_ID(), 'rehub_offer_btn_text', true );
			 	$offer_price_old = get_post_meta( get_the_ID(), 'rehub_offer_product_price_old', true );
			 	$offer_coupon = get_post_meta( get_the_ID(), 'rehub_offer_product_coupon', true );
			 	$offer_coupon_date = get_post_meta( get_the_ID(), 'rehub_offer_coupon_date', true );
			 	$offer_coupon_mask = get_post_meta( get_the_ID(), 'rehub_offer_coupon_mask', true );
			?>				

			<?php $coupon_style = $expired = ''; if(!empty($offer_coupon_date)) : ?>
				<?php
					$timestamp1 = strtotime($offer_coupon_date);
					$seconds = $timestamp1 - (int)current_time('timestamp',0);
					$days = floor($seconds / 86400);
					$seconds %= 86400;
            		if ($days > 0) {
            			$coupon_style = '';
            			$coupon_text = $days.' '.__('days left', 'rehub_framework');
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
			<?php do_action('post_change_expired', $expired); //Here we update our expired?>
			<?php $coupon_mask_enabled = (!empty($offer_coupon) && ($offer_coupon_mask =='1' || $offer_coupon_mask =='on') && $expired!='1') ? '1' : ''; ?> 
			<?php $reveal_enabled = ($coupon_mask_enabled =='1') ? ' reveal_enabled' : '';?>
	        <div class="single_priced_block <?php echo $reveal_enabled; echo $coupon_style; ?>">
	            <?php if(!empty($offer_price) && $showme !='button') : ?>
            		<span class="single_price_count">
            			<?php echo esc_html($offer_price) ?>
            			<?php if($offer_price_old !='') :?> <del><?php echo esc_html($offer_price_old) ; ?></del><?php endif ;?>
            		</span>
	            <?php endif ;?>
	    		<?php if($showme !='price') : ?>
		            <div class="btn_block_part">
			            <a href="<?php echo esc_url($offer_url) ?>" class="btn_offer_block re_track_btn <?php echo $size ?>" target="_blank" rel="nofollow">
			            <?php if($offer_btn_text !='') :?>
			            	<?php echo esc_html ($offer_btn_text); ?>
			            <?php elseif(rehub_option('rehub_btn_text') !='') :?>
			            	<?php echo rehub_option('rehub_btn_text') ; ?>
			            <?php else :?>
			            	<?php _e('Buy It Now', 'rehub_framework') ?>
			            <?php endif ;?>
			            </a>
				    	<?php if ($coupon_mask_enabled =='1') :?>
			    			<?php wp_enqueue_script('zeroclipboard'); ?>
		                	<span class="coupon_btn btn_offer_block re_track_btn rehub_offer_coupon masked_coupon <?php echo $size ?> <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo esc_html ($offer_coupon) ?>" data-codeid="<?php echo get_the_ID()?>" data-dest="<?php echo esc_url($offer_url) ?>">
		                		<?php if($offer_btn_text !='') :?>
			            			<?php echo esc_html ($offer_btn_text) ; ?>
		                		<?php elseif(rehub_option('rehub_mask_text') !='') :?>
		                			<?php echo rehub_option('rehub_mask_text') ; ?>
		                		<?php else :?>
		                			<?php _e('Reveal coupon', 'rehub_framework') ?>
		                		<?php endif ;?>
		                	</span>
				    	<?php else : ?>
							<?php if(!empty($offer_coupon) && $showme !='price') : ?>
								<?php wp_enqueue_script('zeroclipboard'); ?>
							  	<div class="rehub_offer_coupon not_masked_coupon <?php if(!empty($offer_coupon_date)) {echo $coupon_style ;} ?>" data-clipboard-text="<?php echo $offer_coupon ?>"><i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text"><?php echo $offer_coupon ?></span>
							  	</div>
						  	<?php endif;?>		    		
				        <?php endif; ?>	
				        <?php if(!empty($offer_coupon_date)) {echo '<div class="time_offer">'.$coupon_text.'</div>';} ?>	            
		            </div>
	            <?php endif;?>	            	        
	        </div>
		<?php elseif(!empty($multiofferrows[0]['multioffer_url'])):?>
		    <div class="single_priced_block">
		        <?php 
		        	$min_price = get_post_meta(get_the_ID(), 'rehub_main_product_price', true );
		         	if ($min_price !='' && $showme !='button') : ?>
	        			<span class="single_price_count">
	        				<ins><?php echo rehub_option('rehub_currency'); echo $min_price; ?></ins>
	        			</span>
		        <?php endif ;?>
		        <?php if($showme !='price') : ?>
		        	<div class="btn_block_part">
		        		<a href="<?php the_permalink();?>#multiofferlist" class="btn_offer_block">
		        			<?php if(rehub_option('rehub_btn_text_aff_links') !='') :?>
		        				<?php echo rehub_option('rehub_btn_text_aff_links') ; ?>
		        			<?php else :?>
		        				<?php _e('Choose offer', 'rehub_framework') ?>
		        			<?php endif ;?>
		        		</a>
		        	</div>
		        <?php endif ;?>
		    </div>
	    <?php endif ;?>

	<?php
}
}


add_action( 'pre_get_posts', 'rehub_change_post_query' ); //Here we change and extend post loop data
if (!function_exists('rehub_change_post_query')){
	function rehub_change_post_query($q){
		if (rehub_option('rehub_post_exclude_expired') == '1') {
			//exclude from woo archives expired products
		    if (is_post_type_archive('post') || is_category() || is_home()) {
			    $q->set( 'meta_query', array(
			    	'relation' => 'OR',
			    	array(
			       		'key' => 're_post_expired',
			       		'value' => '1',
			       		'compare' => '!=',
			    	),
			    	array(
			       		'key' => 're_post_expired',
			       		'compare' => 'NOT EXISTS',
			    	),				    	 				    	   	
			    ));
			}
		}
		if(rehub_option('enable_brand_taxonomy')){
			if (is_tax('dealstore')){ //Here we change number of posts in brand store archives
				$q->set( 'posts_per_page', 30);
			}			
		}	
	}
}

?>