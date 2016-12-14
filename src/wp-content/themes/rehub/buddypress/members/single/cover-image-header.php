<?php
/**
 * BuddyPress - Users Cover Image Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>
<?php

/**
 * Fires before the display of a member's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_header' ); ?>
<?php 

$author_ID = bp_displayed_user_id();
$count_comments = get_comments( array( 'user_id' => $author_ID, 'count' => true ) );
$count_likes = ( get_user_meta( $author_ID, 'overall_post_likes', true) ) ? get_user_meta( $author_ID, 'overall_post_likes', true) : '0';
$totaldeals = count_user_posts( $author_ID, $post_type = 'product' );
$totalposts = count_user_posts( $author_ID, $post_type = 'post' );
$totalsubmitted = $totaldeals + $totalposts;
$mycredrank = ( function_exists( 'mycred_get_users_rank' ) ) ? mycred_get_users_rank($author_ID) : '';
$mycredpoint = ( function_exists( 'mycred_get_users_fcred' ) ) ? mycred_get_users_fcred($author_ID ) : '';

?>


<div id="rh-cover-image-container">
	<div id="rh-header-cover-image">

		<div id="rh-header-bp-content-wrap">		
			<div id="rh-header-bp-avatar">	
				<?php bp_displayed_user_avatar( 'type=full' ); ?>
			</div>
			<div id="rh-header-bp-content">
				<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
					<h2 class="user-nicename">
					<?php the_author_meta( 'display_name',$author_ID); ?>
					<?php if (!empty($mycredrank) && is_object( $mycredrank)) :?><span class="rh-user-rank-mc rh-user-rank-<?php echo $mycredrank->post_id; ?>"><?php echo $mycredrank->title ;?></span><?php endif;?>
					</h2>
				<?php endif; ?>	
            	<?php if ( function_exists( 'rh_mycred_display_users_badges' ) ) : ?>
	                <div class="rh-profile-achievements">
	                        <div>
	                            <?php rh_mycred_display_users_badges( $author_ID ) ?>
	                        </div>
	                </div>
	            <?php endif; ?>						            			
				<?php do_action( 'bp_before_member_header_meta' ); ?>	
				<div id="item-meta">					
					<span class="last-activity-profile"><?php _e( 'Last active', 'rehub_framework' );?>: <span><?php bp_last_activity( bp_displayed_user_id() ); ?></span></span>				
					<?php do_action( 'bp_profile_header_meta' ); ?>					
				</div>								
			</div>
            <div id="rh-bp-profile-stats">
                <div><?php _e( 'Points', 'rehub_framework' );?>: <span><?php echo $mycredpoint;?></span> </div>               
                <div><?php _e( 'Comments', 'rehub_framework' ); ?>: <span><?php echo $count_comments;?></span></div>
                <div><?php _e( 'Likes', 'rehub_framework' ); ?>: <span><?php echo $count_likes;?></span></div>
                <div><?php _e( 'Submitted', 'rehub_framework' ); ?>: <span><?php echo $totalsubmitted;?></span></div>      
            </div>			
			<div id="rh-header-bp-content-btns">
				<div id="item-buttons">
					<?php do_action( 'bp_member_header_actions' ); ?>
				</div><!-- #item-buttons -->			
			</div>
		</div>
		<span class="header-cover-image-mask"></span>	
	</div>
</div><!-- #cover-image-container -->

<?php

/**
 * Fires after the display of a group's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_member_header' );

/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
do_action( 'template_notices' ); ?>