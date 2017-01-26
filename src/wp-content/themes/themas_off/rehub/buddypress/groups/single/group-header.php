<?php
/**
 * BuddyPress - Groups Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires before the display of a group's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_group_header' );

?>

<div id="rh-nocover-image-container">
	<div id="rh-header-bp-content-wrap">
		<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>		
		<div id="rh-header-bp-avatar">	
			<?php bp_group_avatar(); ?>
		</div>
		<?php endif; ?>
		<div id="rh-header-bp-content">
			<h2><?php the_title(); ?></h2>		
			<?php do_action( 'bp_before_group_header_meta' ); ?>
			<div id="item-meta">
				<span class="highlight"><?php bp_group_type(); ?></span>
				<span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>
				<?php bp_group_description(); ?>
				<?php do_action( 'bp_group_header_meta' ); ?>
			</div>			
		</div>
		<div id="rh-header-bp-content-btns">
			<div id="item-buttons">
				<?php do_action( 'bp_group_header_actions' ); ?>
			</div><!-- #item-buttons -->			
		</div>
	</div>
	<div id="rh-item-admins">
		<?php if ( bp_group_is_visible() ) : ?>
			<div class="group-list-admins">
				<div class="admin-groups"><?php _e( 'Group Admins', 'buddypress' ); ?></div>
				<?php 
				bp_group_list_admins();
				do_action( 'bp_after_group_menu_admins' ); ?>
			</div>
		<?php if ( bp_group_has_moderators() ) : ?>
			<div class="group-list-admins group-list-mods">
				<?php do_action( 'bp_before_group_menu_mods' ); ?>
				<div class="admin-groups"><?php _e( 'Group Mods' , 'buddypress' ); ?></div>
				<?php 
				bp_group_list_mods();
				do_action( 'bp_after_group_menu_mods' ); 
				?>
			</div>
		<?php endif; endif; ?>
	</div><!-- #item-actions -->	
</div><!-- #cover-image-container -->

<?php

/**
 * Fires after the display of a group's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_after_group_header' );

/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
do_action( 'template_notices' ); ?>