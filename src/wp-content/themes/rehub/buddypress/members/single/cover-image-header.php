<?php	
	$author_ID = bp_displayed_user_id();
	$seo_user_description = $phone = '';
	$count_comments = get_comments( array( 'user_id' => $author_ID, 'count' => true ) );
	$count_likes = ( get_user_meta( $author_ID, 'overall_post_likes', true) ) ? get_user_meta( $author_ID, 'overall_post_likes', true) : '0';
	$totaldeals = count_user_posts( $author_ID, $post_type = 'product' );
	$totalposts = count_user_posts( $author_ID, $post_type = 'post' );
	$totalsubmitted = $totaldeals + $totalposts;
	$mycredrank = ( function_exists( 'mycred_get_users_rank' ) ) ? mycred_get_users_rank($author_ID) : '';
	$mycredpoint = ( function_exists( 'mycred_get_users_fcred' ) ) ? mycred_get_users_fcred($author_ID ) : '';
	$membertype = bp_get_member_type($author_ID);
	$membertype_object = bp_get_member_type_object($membertype);
	$membertype_label = (!empty($membertype_object) && is_object($membertype_object)) ? $membertype_object->labels['singular_name'] : '';
	if(function_exists('bp_get_profile_field_data')){
		$profile_description = rehub_option('rh_bp_seo_description');
		$profile_phone = rehub_option('rh_bp_phone');
		if ($profile_description){
			$seo_user_description = bp_get_profile_field_data('field='.$profile_description);
		}	
		if ($profile_phone){
			$phone = bp_get_profile_field_data('field='.$profile_phone);
		}					
	}
?>
<div class="bprh_wrap_bg mb30">
	<div id="item-header" role="complementary">
		<?php
		/**
		 * Fires before the display of a member's header.
		 *
		 * @since 1.2.0
		 */
		do_action( 'bp_before_member_header' ); ?>
		<div id="rh-cover-image-container">
			<div id="rh-header-cover-image">
				<div id="rh-header-bp-content-wrap">
					<div class="rh-container" id="rhbp-header-profile-cont">		
						<div id="rh-header-bp-avatar">	
							<?php echo get_avatar( $author_ID, 140 ); ?>
						</div>
						<div id="rh-header-bp-content">
							<h2 class="user-nicename">
								<?php the_author_meta( 'display_name',$author_ID); ?>
								<?php if ($phone): ?>
	                                <span class="bp_user_phone_details">
	                                    <i class="fa fa-phone" aria-hidden="true"></i> <?php echo esc_html($phone); ?>
	                                </span>                   
	                            <?php endif; ?>										
								<?php if (!empty($mycredrank) && is_object( $mycredrank)) :?>
									<span class="rh-user-rank-mc rh-user-rank-<?php echo $mycredrank->post_id; ?>"><?php echo $mycredrank->title ;?></span>
								<?php endif;?>
								<?php if($membertype_label):?>
    								<span class="rh-user-rank-mc rh-user-rank-<?php echo $membertype;?>"><?php echo $membertype_label;?></span>
    							<?php endif; ?>							
							</h2>	
			            	<?php if ( function_exists( 'rh_mycred_display_users_badges' ) ) : ?>
				                <div class="rh-profile-achievements">
			                        <div>
			                            <?php rh_mycred_display_users_badges( $author_ID ) ?>
			                        </div>
				                </div>
				            <?php endif; ?>						            			
							<?php do_action( 'bp_before_member_header_meta' ); ?>	
							<div id="item-meta">	
								<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>			
									<span class="last-activity-profile"><?php _e( 'Last active', 'rehub_framework' );?>: <span><?php bp_last_activity( bp_displayed_user_id() ); ?></span></span>
								<?php endif; ?>
								<?php if ($seo_user_description): ?>
	                                <div class="bp_user_about_details">
	                                    <?php $desc_len = strlen(esc_html($seo_user_description));?>
	                                    <?php if ($desc_len > 180) :?>                           
	                                        <p><?php kama_excerpt('maxchar=180&text='.$seo_user_description); ?> <a href="<?php echo bp_core_get_user_domain($author_ID);?>profile"><?php _e('(Read more)', 'rehub_framework');?></a></p>
	                                    <?php else :?>
	                                        <p><?php echo esc_html($seo_user_description); ?></p>
	                                    <?php endif;?>
	                                </div>                     
	                            <?php endif; ?> 			
								<?php do_action( 'bp_profile_header_meta' ); ?>	
								<div class="share-profile-bp mt20">
								<?php _e('SHARE:', 'rehub_framework');?>
								<?php echo rehub_social_inimage('flat', false, false, 'user');?>
								</div>				
							</div>								
						</div>
			            <div id="rh-bp-profile-stats">
			            	<?php if($mycredpoint):?>
			                <div><?php _e( 'Points', 'rehub_framework' );?>: <span><?php echo $mycredpoint;?></span> </div> 
			                <?php endif;?>              
			                <div><?php _e( 'Comments', 'rehub_framework' ); ?>: <span><?php echo $count_comments;?></span></div>
			                <div><?php _e( 'Likes', 'rehub_framework' ); ?>: <span><?php echo $count_likes;?></span></div>
			                <div><?php _e( 'Submitted', 'rehub_framework' ); ?>: <span><?php echo $totalsubmitted;?></span></div>
							<?php
							if ( function_exists( 'bp_follow_total_follow_counts' ) ) :?>
							    <?php $count = bp_follow_total_follow_counts( array(
							        // change 5 to whatever user ID you need to fetch
							        'user_id' => $author_ID
							    ) );?>
							    <div><?php _e( 'Followers', 'rehub_framework' ); ?>: <span><?php echo $count['followers']; ?></span></div>
							    <div><?php _e( 'Following', 'rehub_framework' ); ?>: <span><?php echo $count['following']; ?></span></div>
							<?php endif;?>

			                <?php if(bp_is_active( 'friends' )) :?>
				                <div><?php _e( 'Friends', 'rehub_framework' ); ?>: <span><?php echo friends_get_total_friend_count();?></span></div>				                
				                <div><?php echo rehub_get_user_rate('admin', 'user', bp_displayed_user_id());?></div> 				                
			                <?php endif;?>    
			            </div>			
						<div id="rh-header-bp-content-btns">
							<div id="item-buttons">
								<?php do_action( 'bp_member_header_actions' ); ?>
							</div><!-- #item-buttons -->			
						</div>
					</div>
				</div>
				<span class="header-cover-image-mask"></span>	
			</div>
		</div><!-- #cover-image-container -->

		<div id="rhbp-iconed-menu">
			<div class="rh-container">
				<div id="item-nav">
					<div class="responsive-nav-greedy item-list-tabs no-ajax rh-flex-eq-height clearfix" id="object-nav" role="navigation">
						<ul class="rhgreedylinks">
							<?php bp_get_displayed_user_nav(); ?>
							<?php do_action( 'bp_member_options_nav' ); ?>
						</ul>
						<span class="togglegreedybtn rhhidden floatright ml5"><?php _e('More', 'rehub_framework');?></span>
						<ul class='hidden-links rhhidden'></ul>							
					</div>
				</div><!-- #item-nav -->
			</div>
		</div>
	</div><!-- #item-header -->
</div>