<?php
/* * **************************************
 * Main.php
 *
 * The main template file, that loads the header, footer and sidebar
 * apart from loading the appropriate rtMedia template
 * *************************************** */
// by default it is not an ajax request
global $rt_ajax_request;
$rt_ajax_request = false;

//todo sanitize and fix $_SERVER variable usage
// check if it is an ajax request

$_rt_ajax_request = rtm_get_server_var( 'HTTP_X_REQUESTED_WITH', 'FILTER_SANITIZE_STRING' );
if ( 'xmlhttprequest' === strtolower( $_rt_ajax_request ) ) {
	$rt_ajax_request = true;
}
$author_ID = bp_displayed_user_id();	
$membertype = ($author_ID) ?  bp_get_member_type($author_ID) : '';
?>

<div id="buddypress" class="register_wrap_type<?php echo $membertype;?>">
<?php
//if it's not an ajax request, load headers
if ( ! $rt_ajax_request ) {
	// if this is a BuddyPress page, set template type to
	// buddypress to load appropriate headers
	if ( class_exists( 'BuddyPress' ) && ! bp_is_blog_page() && apply_filters( 'rtm_main_template_buddypress_enable', true ) ) {
		$template_type = 'buddypress';
	} else {
		$template_type = '';
	}
	//get_header( $template_type );

	if ( 'buddypress' === $template_type ) {
		//load buddypress markup
		if ( bp_displayed_user_id() ) {
			//if it is a buddypress member profile
			?>			
				<div id="item-body" role="main">
					<?php do_action( 'bp_before_member_body' ); ?>
					<?php do_action( 'bp_before_member_media' ); ?>
					<div class="item-list-tabs no-ajax" id="subnav">
						<ul>
							<?php rtmedia_sub_nav(); ?>
							<?php do_action( 'rtmedia_sub_nav' ); ?>
						</ul>
					</div><!-- .item-list-tabs -->

			<?php
		} else if ( bp_is_group() ) {
		?>
			<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>
				<div id="item-body">
					<?php do_action( 'bp_before_group_body' ); ?>
					<?php do_action( 'bp_before_group_media' ); ?>
					<div class="item-list-tabs no-ajax" id="subnav">
						<ul>
							<?php rtmedia_sub_nav(); ?>
							<?php do_action( 'rtmedia_sub_nav' ); ?>
						</ul>
					</div>
				
			<?php endwhile; endif; 
		}
	}
	else { 
		?>
		<div id="item-body">
		<?php
	}
} // if ajax
// include the right rtMedia template
rtmedia_load_template();

if ( ! $rt_ajax_request ) {
	if ( function_exists( 'bp_displayed_user_id' ) && 'buddypress' === $template_type && ( bp_displayed_user_id() || bp_is_group() ) ) {
		if ( bp_is_group() ) {
			do_action( 'bp_after_group_media' );
			do_action( 'bp_after_group_body' );
		}
		if ( bp_displayed_user_id() ) {
			do_action( 'bp_after_member_media' );
			do_action( 'bp_after_member_body' );
		}
	}
	?>
	</div><!--#item-body-->
	<?php
	if ( function_exists( 'bp_displayed_user_id' ) && 'buddypress' === $template_type && ( bp_displayed_user_id() || bp_is_group() ) ) {
		if ( bp_is_group() ) {
			do_action( 'bp_after_group_home_content' );
		}
		if ( bp_displayed_user_id() ) {
			do_action( 'bp_after_member_home_content' );
		}
	}
}
?>
</div><!--#buddypress-->