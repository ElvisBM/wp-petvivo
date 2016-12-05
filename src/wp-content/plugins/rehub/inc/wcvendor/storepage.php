<?php 	
	$shop_name 	       =  get_user_meta( $vendor_id, 'pv_shop_name', true ); 
	$shop_url = WCV_Vendors::get_vendor_shop_page( $vendor_id );
	$has_html          = get_user_meta( $vendor_id, 'pv_shop_html_enabled', true );
	$global_html       = WC_Vendors::$pv_options->get_option( 'shop_html_enabled' );
	$description       = do_shortcode( get_user_meta( $vendor_id, 'pv_shop_description', true ) );
	$shop_description  = ( $global_html || $has_html ) ? wpautop( wptexturize( wp_kses_post( $description ) ) ) : sanitize_text_field( $description );
	$shop_description_short = esc_html($description);
	$seller_info       = ( $global_html || $has_html ) ? wpautop( get_user_meta( $vendor_id, 'pv_seller_info', true ) ) : sanitize_text_field( get_user_meta( $vendor_id, 'pv_seller_info', true ) );
	$vendor	           = get_userdata( $vendor_id );
	$vendor_email      = $vendor->user_email;
	$vendor_login      = $vendor->user_login;
	$vendor_name      = $vendor->display_name;
	$totaldeals = count_user_posts( $vendor_id, $post_type = 'product' );
	$mycredrank = ( function_exists( 'mycred_get_users_rank' ) ) ? mycred_get_users_rank($vendor_id) : '';
	$mycredpoint = ( function_exists( 'mycred_get_users_fcred' ) ) ? mycred_get_users_fcred($vendor_id ) : '';	
	$count_likes = ( get_user_meta( $vendor_id, 'overall_post_likes', true) ) ? get_user_meta( $vendor_id, 'overall_post_likes', true) : '0';
	if ( class_exists( 'WCVendors_Pro' ) ) {
		$vendor_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta($vendor_id ) );
	}	
	
?>
<div class="wcvendor_store_wrap_bg">
	<style scoped>#wcvendor_image_bg{<?php echo rh_show_vendor_bg($vendor_id);?>}</style>
	<div id="wcvendor_image_bg">	
		<div id="wcvendor_profile_wrap">
			<div class="content">
	    		<div id="wcvendor_profile_logo" class="wcvendor_profile_cell">
	    			<a href="<?php echo $shop_url;?>"><img src="<?php echo rh_show_vendor_avatar($vendor_id, 150, 150);?>" class="vendor_store_image_single" width=150 height=150 /></a>	        
	    		</div>
	    		<div id="wcvendor_profile_act_desc" class="wcvendor_profile_cell">
	    			<div class="wcvendor_store_name"><h1><?php echo esc_html($shop_name);?></h1></div>
				    <?php if ( class_exists( 'WCVendors_Pro' ) ) :?>
					    <div class="wcvendor_store_stars">
						    <?php if ( ! WCVendors_Pro::get_option( 'ratings_management_cap' ) ) echo WCVendors_Pro_Ratings_Controller::ratings_link( $vendor_id, true );?>
					    </div>
					    <?php 
					    $address1 			= ( array_key_exists( '_wcv_store_address1', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_address1' ] : '';
					    $address2 			= ( array_key_exists( '_wcv_store_address2', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_address2' ] : '';
					    $city	 			= ( array_key_exists( '_wcv_store_city', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_city' ]  : '';
					    $state	 			= ( array_key_exists( '_wcv_store_state', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_state' ] : '';
					    $phone				= ( array_key_exists( '_wcv_store_phone', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_phone' ]  : '';
					    $store_postcode		= ( array_key_exists( '_wcv_store_postcode', $vendor_meta ) ) ? $vendor_meta[ '_wcv_store_postcode' ]  : '';

					    $twitter_username 	= get_user_meta( $vendor_id , '_wcv_twitter_username', true );
					    $instagram_username = get_user_meta( $vendor_id , '_wcv_instagram_username', true );
					    $facebook_url 		= get_user_meta( $vendor_id , '_wcv_facebook_url', true );
					    $linkedin_url 		= get_user_meta( $vendor_id , '_wcv_linkedin_url', true );
					    $youtube_url 		= get_user_meta( $vendor_id , '_wcv_youtube_url', true );
					    $googleplus_url 	= get_user_meta( $vendor_id , '_wcv_googleplus_url', true );
					    $pinterest_url 		= get_user_meta( $vendor_id , '_wcv_pinterest_url', true );

					    $social_icons = empty( $twitter_username ) && empty( $instagram_username ) && empty( $facebook_url ) && empty( $linkedin_url ) && empty( $youtube_url ) && empty( $googleplus_url ) && empty( $pinterst_url ) ? false : true;
					    $address 			= ( $address1 != '') ? $address1 .', ' . $city .', '. $state .', '. $store_postcode : '';
					    ?>
					    <div class="wcvendor_store_desc"><?php echo $address; ?></div>
					<?php else:?>
					    <div class="wcvendor_store_desc"><?php rehub_truncate('maxchar=200&text='.$shop_description_short.''); ?></div>
					<?php endif;?>
	    		</div>	        			        		
	    		<div id="wcvendor_profile_act_btns" class="wcvendor_profile_cell">
	    			<span class="wpsm-button medium red"><?php echo getShopLikeButton($vendor_id);?></span>	    			
				    <?php if ( class_exists( 'BuddyPress' ) ) :?>
				    	<?php if ( bp_loggedin_user_id() && bp_loggedin_user_id() != $vendor_id ) :?>
							<?php 
								if ( function_exists( 'bp_follow_add_follow_button' ) ) {
							        bp_follow_add_follow_button( array(
							            'leader_id'   => $vendor_id,
							            'follower_id' => bp_loggedin_user_id(),
							            'link_class'  => 'wpsm-button medium green'
							        ) );
							    }
							?>				    		
						    <?php
						        if ( bp_is_active( 'messages' )){
							    $link = (is_user_logged_in()) ? wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $vendor_id)) : '#';
							    $class = (!is_user_logged_in() && rehub_option('userlogin_enable') == '1') ? ' act-rehub-login-popup' : '';
							    echo ' <a href="'.$link.'" class="wpsm-button medium white'.$class.'">'. __('Contact vendor', 'rehub_framework') .'</a>';
						    }?>
					    <?php endif;?>
					<?php endif;?>
	    		</div>	        			
			</div>
		</div>
		<span class="wcvendor-cover-image-mask"></span>
	</div>
	<div id="wcvendor_profile_menu">
		<div class="content">			
			<form id="wcvendor_search_shops" role="search" action="<?php echo $shop_url;?>" method="get" class="wcvendor-search-inside search-form">
				<input type="text" name="rh_wcv_search" placeholder="<?php _e('Search in this shop', 'rehub_framework');?>" value="">
				<button type="submit" class="btnsearch"><i class="fa fa-search"></i></button>					
			</form>	
			<ul class="wcvendor_profile_menu_items">		
			<li class="active"><a href="#vendor-items" aria-controls="vendor-items" role="tab" data-toggle="tab" aria-expanded="true"><?php _e('Items', 'rehub_framework');?></a></li>
			<?php if ( class_exists( 'WCVendors_Pro' ) ) :?>
				<?php $feedback_form_page =  		WCVendors_Pro::get_option( 'feedback_page_id' );?>
				<?php if ( $feedback_form_page ) :?>
					<?php $url = apply_filters( 'wcv_ratings_link_url', WCVendors_Pro_Vendor_Controller::get_vendor_store_url( $vendor_id ) . 'ratings/' ); ?>
					<li><a href="<?php echo $url;?>"><?php _e('Reviews', 'rehub_framework');?></a></li>	
				<?php endif;?>
			<?php endif;?>
			<li><a href="#vendor-about" aria-controls="vendor-about" role="tab" data-toggle="tab" aria-expanded="true" data-scrollto="#vendor-about"><?php _e('About', 'rehub_framework');?></a></li>
			</ul>

		</div>
	</div>
</div>


<!-- CONTENT -->
<div class="content no_shadow wcvcontent"> 
	<div class="clearfix">
	    <!-- Main Side -->
	    <aside class="vcwendor_profile_sidebar user-profile-div">
	    	<div class="rh-cartbox">
	            <div>
	            	<div class="wcvendor_ownertitle"><h5>Shop owner</h5></div>
	                <div class="profile-avatar">
	                    <?php echo get_avatar( $vendor_email, '128' ); ?>
	                </div>
	                <div class="profile-usertitle">
	                    <div class="profile-usertitle-name">
	                    <?php if ( function_exists('bp_core_get_user_domain') ) : ?>
	                    	<a href="<?php echo bp_core_get_user_domain( $vendor_id ); ?>">
	                    <?php endif;?>
	                        <?php echo $vendor_name; ?> <?php if (!empty($mycredrank)) :?><span class="rh-user-rank-mc rh-user-rank-<?php echo mycred_get_users_rank_id($vendor_id); ?>"><?php echo $mycredrank ;?></span><?php endif;?>
	                        <?php if ( function_exists('bp_core_get_user_domain') ) : ?></a><?php endif;?>
	                    </div>
	                </div>
	                <div class="profile-stats">
	                    <div><i class="fa fa-user"></i> <?php _e( 'Registration', 'rehub_framework' );  echo ': ' . mb_substr( $vendor->user_registered, 0, 10 ); ?></div>
	                    <?php if (rehub_option('woo_thumb_enable') == '1') :?><div><i class="fa fa-heartbeat"></i><?php _e( 'Product Votes', 'rehub_framework' ); echo ': ' . $count_likes; ?></div><?php endif;?>
	                    <div><i class="fa fa-briefcase"></i><?php _e( 'Total submitted', 'rehub_framework' ); echo ': ' . $totaldeals; ?></div>
	                    <?php if (!empty($mycredpoint)) :?><div><i class="fa fa-bar-chart"></i><?php _e( 'Reputation points', 'rehub_framework' ); echo ': ' . $mycredpoint; ?></div><?php endif;?>                               
	                </div>
					<?php if ( class_exists( 'WCVendors_Pro' ) ) :?>
						<div class="profile-description">
							<div>
								<span><?php _e( 'Contacts', 'rehub_framework' ); ?></span>
								<p>
									<?php echo $address; ?>
									<?php if ($phone):?>
										<br />
										<a href="tel:<?php echo $phone; ?>"><i class="fa fa-phone"></i> <?php echo $phone; ?></a>
									<?php endif;?>
								</p>
							</div>
						</div>
						<?php if ($social_icons):?>
			                <div class="profile-socbutton">
			                    <div class="social_icon small_i">
				                    <?php if ( $facebook_url != '') { ?><a href="<?php echo $facebook_url; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-facebook"></i></a><?php } ?>
				                    <?php if ( $instagram_username != '') { ?><a href="//instagram.com/<?php echo $instagram_username; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-instagram"></i></a><?php } ?>
				                    <?php if ( $twitter_username != '') { ?><a href="//twitter.com/<?php echo $twitter_username; ?>" target="_blank" class="author-social tw" rel="nofollow"><i class="fa fa-twitter"></i></a><?php } ?>
				                    <?php if ( $googleplus_url != '') { ?><a href="<?php echo $googleplus_url; ?>" target="_blank" class="author-social gp" rel="nofollow"><i class="fa fa-google-plus"></i></a><?php } ?>
				                    <?php if ( $pinterest_url != '') { ?><a href="<?php echo $pinterest_url; ?>" target="_blank" class="author-social gp" rel="nofollow"><i class="fa fa-pinterest"></i></a><?php } ?>
				                    <?php if ( $youtube_url != '') { ?><a href="<?php echo $youtube_url; ?>" target="_blank" class="author-social yt" rel="nofollow"><i class="fa fa-youtube"></i></a><?php } ?>
				                    <?php if ( $linkedin_url != '') { ?><a href="<?php echo $linkedin_url; ?>" target="_blank" class="author-social fb" rel="nofollow"><i class="fa fa-linkedin"></i></a><?php } ?>
			                     </div>
			                </div>
		           		<?php endif;?>
					<?php endif;?>
	            <?php if ( !empty( $vendor->description ) ) : ?>
	                <div class="profile-description">
	                    <div>
	                        <span><?php _e( 'About author', 'rehub_framework' ); ?></span>
	                        <p><?php echo $vendor->description; ?></p>
	                    </div>
	                </div>
	            <?php endif; ?>
	            <?php if ( function_exists( 'mycred_get_users_badges' ) ) : ?>
	                <div class="profile-achievements">
	                        <div>
	                            <?php rh_mycred_display_users_badges( $vendor_id ) ?>
	                        </div>
	                </div>
	            <?php endif; ?>
                <?php if ( function_exists('bp_core_get_user_domain') ) : ?>
                    <div class="profile-usermenu">
	                    <ul class="user-menu-tab" role="tablist">
	                        <li class="text-center">
	                            <a href="<?php echo bp_core_get_user_domain( $vendor_id ); ?>"><i class="fa fa-folder-open"></i><?php _e( 'Show full profile', 'rehub_framework' ); ?></a>
	                        </li>
	                    </ul>
                    </div>
                <?php endif; ?>

	            </div>	    		
	    	</div>
	    	<div class="rh-cartbox">
	            <div>
	            	<div class="wcvendor_ownertitle"><h5><?php _e('Shop categories', 'rehub_framework');?></h5></div>
					<?php global $wpdb; $categories = $wpdb->get_results("
					    SELECT DISTINCT(terms.term_id) as ID, terms.name, terms.slug
					    FROM $wpdb->posts as posts
					    LEFT JOIN $wpdb->term_relationships as relationships ON posts.ID = relationships.object_ID
					    LEFT JOIN $wpdb->term_taxonomy as tax ON relationships.term_taxonomy_id = tax.term_taxonomy_id
					    LEFT JOIN $wpdb->terms as terms ON tax.term_id = terms.term_id
					    WHERE posts.post_status = 'publish' AND
					        posts.post_author = '$vendor_id' AND
					        posts.post_type = 'product' AND
					        tax.taxonomy = 'product_cat'
					    ORDER BY terms.name ASC
					");
					?>
					<?php $cat_string = (isset($_GET['rh_wcv_vendor_cat'])) ? esc_html($_GET['rh_wcv_vendor_cat']) : '';?>
					<ul class="category-vendormenu">
					    <?php foreach($categories as $category) : ?>
					    <?php $liclass = ($cat_string == $category->ID) ? ' class="current"' : '';?>
					    <li<?php echo $liclass;?>>
					    	<?php $author_posts = new WP_Query( array( 
					    		'post_type' => 'product', 
					    		'author' => $vendor_id, 
					    		'tax_query'=>array(
					    			array(
					    				'taxonomy' => 'product_cat', 
					    				'terms' => array($category->ID), 
					    				'field' => 'term_id'
					    				)
					    			)    			 
					    			
					    		));
					    		$count = $author_posts->found_posts;
					    		wp_reset_query();
					    	?>
					        <a href="<?php echo $shop_url;?>?rh_wcv_vendor_cat=<?php echo $category->ID;?>" title="<?php echo $category->name ?>">
					            <?php echo $category->name.'<span>'.$count.'</span> '; ?>
					        </a>
					    </li>
					    <?php endforeach; ?>
					</ul>

	            </div>	    		
	    	</div>	    	
	    	
	    </aside>
	    <div class="vcwendor_profile_content woocommerce page clearfix">
	        <article class="post" id="page-<?php the_ID(); ?>">
	        	<div role="tabvendor" class="tab-pane active" id="vendor-items">
				<?php if ( have_posts() ) : ?>
					<?php
						/**
						 * woocommerce_before_shop_loop hook
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
					?>
					<?php woocommerce_product_loop_start(); ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php 
								$custom_col = 'yes'; 
								$custom_img_height = 284; 
								$custom_img_width = 284; 
							?>
							<?php include(locate_template('inc/parts/woocolumnpart.php')); ?>
						<?php endwhile; // end of the loop. ?>
					<?php woocommerce_product_loop_end(); ?>
					<?php
						/**
						 * woocommerce_after_shop_loop hook
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					?>
				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
					<?php wc_get_template( 'loop/no-products-found.php' ); ?>
				<?php endif; ?>
				</div>
				<div role="tabvendor" class="tab-pane" id="vendor-about">
					<?php echo $shop_description;?>
				</div>
			</article>
		</div>
		<!-- /Main Side --> 
    </div>
</div>
<!-- /CONTENT -->


<?php get_footer(); ?>