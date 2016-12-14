<?php

/* 
 * Default size of avatar
 */
define ( 'BP_AVATAR_THUMB_WIDTH', 55 );
define ( 'BP_AVATAR_THUMB_HEIGHT', 55 );
define ( 'BP_AVATAR_FULL_WIDTH', 110 );
define ( 'BP_AVATAR_FULL_HEIGHT', 110 );
 
/*
 * BP callback for the cover image feature.
 */
 if( ! function_exists( 'rh_cover_image_callback' ) ) :
	function rh_cover_image_callback( $params = array() ) {
		if ( empty( $params ) ) {
			return;
		}

		$cover_image = !empty( $params['cover_image'] ) ? 'background-image:url(' . $params['cover_image'] . ')' : 'background-image: url("'.get_template_directory_uri() . '/images/swirl_pattern.png"); background-repeat:  repeat;background-size: inherit;';
		return '
			/* Cover image */
			#rh-header-cover-image {'. $cover_image .'}';
	}
endif;

/* Call BP cover-image styles in head */
if( ! function_exists( 'rh_cover_image_css' ) ) :
	function rh_cover_image_css( $settings = array() ) {

		// If you are using a child theme, use bp-child-css as the theme handel

		$theme_handle = (is_rtl()) ? 'bp-parent-css-rtl' : 'bp-parent-css';
	 
		$settings['theme_handle'] = $theme_handle;
		$settings['callback'] = 'rh_cover_image_callback';
	 
		return $settings;
	}
	add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'rh_cover_image_css', 10, 1 );
	add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'rh_cover_image_css', 10, 1 );
endif;


/* Custom Tabs for User`s Profile */
if( ! function_exists( 'rh_content_setup_nav_profile' ) ) :
	function rh_content_setup_nav_profile() {
		global $bp;
		$userid = (!empty($bp->displayed_user->id)) ? $bp->displayed_user->id : '';
		if($userid){
			$totaldeals = count_user_posts( $userid, $post_type = 'product' );
			$totalposts = count_user_posts( $userid, $post_type = 'post' );	
			$total = $totaldeals + $totalposts;
			$class    = ( 0 === $total ) ? 'no-count' : 'count';
		}	
		else {
			$class = 'hiddencount';
			$total = '';
		}
		if(REHUB_NAME_ACTIVE_THEME == 'REVENDOR'){
			$position_posttab = 40;
			$position_posts = 20;
			$position_product = 10;
			$post_text = sprintf( __( 'My products <span class="%s">%s</span>', 'rehub_framework' ), esc_attr( $class ), $total  );
			$default_tab = 'deals';	
			$userpostslabel = (rehub_option('rehub_userposts_text') !='') ? rehub_option('rehub_userposts_text') : __( 'Reviews', 'rehub_framework' );
			$userdealslabel = (rehub_option('rehub_userdeals_text') !='') ? rehub_option('rehub_userposts_text') : __( 'Products', 'rehub_framework' );				
		}	
		else{
			$userpostslabel = (rehub_option('rehub_userposts_text') !='') ? rehub_option('rehub_userposts_text') : __( 'Deals', 'rehub_framework' );
			$userdealslabel = (rehub_option('rehub_userdeals_text') !='') ? rehub_option('rehub_userposts_text') : __( 'Products', 'rehub_framework' );			
			$position_posttab = 40;
			$position_posts = 10;
			$position_product = 20;
			$default_tab = 'articles';
			$post_text = sprintf( __( 'My Posts <span class="%s">%s</span>', 'rehub_framework' ), esc_attr( $class ), $total  );			
		}	


		bp_core_new_nav_item( array(
			'name' => $post_text,
			'slug' => 'posts',
			'screen_function' => 'my_posts_screen_link',
			'position' => $position_posttab,
			'default_subnav_slug' => $default_tab
		) );
		bp_core_new_subnav_item( array(
			'name' => $userpostslabel,
			'slug' => 'articles',
			'parent_url' => $bp->displayed_user->domain . 'posts/',
			'parent_slug' => 'posts',
			'screen_function' => 'articles_screen_link',
			'position' => $position_posts
		) );
		bp_core_new_subnav_item( array(
			'name'                  => $userdealslabel,
			'slug'                  => 'deals',
			'parent_url'            => $bp->displayed_user->domain . 'posts/',
			'parent_slug'           => 'posts',
			'screen_function'       => 'deals_screen_link',
			'position'              => $position_product
		) );
	do_action( 'rh_content_setup_nav_profile' );
	}
	add_action( 'bp_setup_nav', 'rh_content_setup_nav_profile' );
endif;

function articles_screen_link() {
	
	function articles_screen_content() {
		?>
		<div id="posts-list" class="bp-post-wrapper posts">

			<?php 
				$containerid = 'rh_deallist_' . uniqid();  
				$infinitescrollwrap = ' re_aj_pag_clk_wrap';    
				$show = $ajaxoffset = 12;	
				$args = array(
					'post_type' => 'post',
					'posts_per_page' => 12,
					'author' => bp_displayed_user_id(),
					);
			    $loop = new WP_Query($args);
			?>
			<?php if ( $loop->have_posts() ) : ?>
				<?php 
					$jsonargs = json_encode($args);
				?> 	
				<div class="wpsm_recent_posts_list <?php  echo $infinitescrollwrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="simplepostlist" id="<?php echo $containerid;?>">

					<?php while ( $loop->have_posts() ) : $loop->the_post();  ?>
						<?php include(locate_template('inc/parts/simplepostlist.php')); ?>
					<?php endwhile; ?>

					<div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Next posts', 'rehub_framework') ?></span></div>      

				</div>
				<div class="clearfix"></div>
			<?php endif; wp_reset_query(); ?>

		</div><!--/.posts-->
	<?php
	} 
	
    add_action( 'bp_template_content', 'articles_screen_content' );
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

function deals_screen_link() {
	
	
	function deals_screen_content() {
		if ( class_exists( 'Woocommerce' ) ) {
		?>
		<div id="posts-list" class="bp-post-wrapper posts">

			<?php 
				$containerid = 'rh_woocolumn_' . uniqid();  
				$infinitescrollwrap = ' re_aj_pag_clk_wrap';    
				$show = $ajaxoffset = 8;	
				$columns = '4_col';
				$additional_vars = array();
				$additional_vars['columns'] = $columns;
				$args = array(
					'post_type' => 'product',
					'posts_per_page' => 8,
					'author' => bp_displayed_user_id(),
					);
			    $loop = new WP_Query($args);
			?>
			<?php if ( $loop->have_posts() ) : ?>
				<?php 
					$jsonargs = json_encode($args);
					$json_innerargs = json_encode($additional_vars);
				?> 
				<div class="woocommerce">
				<div class="rh-flex-eq-height column_woo products col_wrap_fourth <?php  echo $infinitescrollwrap;?>" data-filterargs='<?php echo $jsonargs;?>' data-template="woocolumnpart" data-innerargs='<?php echo $json_innerargs;?>' id="<?php echo $containerid;?>">

					<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
						<?php include(locate_template('inc/parts/woocolumnpart.php')); ?>
					<?php endwhile; ?>

					<div class="re_ajax_pagination"><span data-offset="<?php echo $ajaxoffset;?>" data-containerid="<?php echo $containerid;?>" class="re_ajax_pagination_btn def_btn"><?php _e('Next posts', 'rehub_framework') ?></span></div>      

				</div>
				</div>
				<div class="clearfix"></div>
			<?php endif; wp_reset_query(); ?>

		</div><!--/.posts-->
		<?php
		}
	} 
	
    add_action( 'bp_template_content', 'deals_screen_content' );	
    bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
}

 /* Get the Resized Cover Image URL otherwise Background styled URL */
 if( ! function_exists( 'rh_cover_image_url' ) ) :
	function rh_cover_image_url( $object_dir, $height, $background = false ) {

		if( $object_dir == 'members' ) {
			$item_id = bp_get_member_user_id(); 
		} elseif( $object_dir == 'groups' ) {
			$item_id = bp_get_group_id();
		} else {
			$item_id = 0;
		}
		
		$get_cover_image_url = bp_attachments_get_attachment('url', array(
			'object_dir' => $object_dir,
			'item_id' => $item_id
		) );
		$resized_cover_image_url = '';
		
		if( $get_cover_image_url ) {
			
 		$resized_cover_image = new WPSM_image_resizer();
		$resized_cover_image->src = $get_cover_image_url;
        $resized_cover_image->height = $height;

		$resized_cover_image_url = $resized_cover_image->get_resized_url(); 
		}
		
		if( $background && $resized_cover_image_url ) {
			$cover_image_inline_style = 'background-image:url('. $resized_cover_image_url .')';
			echo $cover_image_inline_style;
		} else {
			echo $resized_cover_image_url;
		}
	}
endif;


if( ! function_exists( 'rh_nologedin_add_buttons' ) ) :
	function rh_nologedin_add_buttons() {
		if( ! is_user_logged_in() && rehub_option('userlogin_enable') == '1') {
		?>
			<div class="generic-button">
				<a href="#" title="Add Friend" rel="add" class="act-rehub-login-popup friendship-button"><?php _e( 'Add Friend', 'budypress' ); ?></a>
			</div>
			<div class="generic-button">
				<a href="#" title="Send a private message to this user." class="act-rehub-login-popup send-message"><?php echo __( 'Private Message', 'buddypress' ); ?></a>
			</div>
		<?php
		}
	}
	add_action( 'bp_member_header_actions', 'rh_nologedin_add_buttons', 10, 0 );
endif;

if( ! function_exists( 'rh_nologedin_add_buttons_group' ) ) :
	function rh_nologedin_add_buttons_group() {
		if( ! is_user_logged_in() && rehub_option('userlogin_enable') == '1') {
		?>
			<div class="generic-button">
				<a href="#" title="Join Group" rel="add" class="act-rehub-login-popup"><?php echo __( 'Join Group', 'budypress' ); ?></a>
			</div>
		<?php
		}
	}
	add_action( 'bp_group_header_actions', 'rh_nologedin_add_buttons_group', 10, 0 );
endif;

if (rehub_option('bp_deactivateemail_confirm') == 1){
	add_filter( 'bp_registration_needs_activation', '__return_false' );	
}

if (!function_exists('rh_show_vendor_store_in_bp')) {
function rh_show_vendor_store_in_bp() { 
	$vendor_id = bp_displayed_user_id();
	$label = __('Owner of shop:', 'rehub_framework');
	rh_show_vendor_ministore($vendor_id, $label);
}}
if (defined('wcv_plugin_dir')) {
add_action( 'bp_after_member_header', 'rh_show_vendor_store_in_bp' );
}

if(!bp_is_active( 'activity' ) && REHUB_NAME_ACTIVE_THEME == 'REVENDOR'){
	define('BP_DEFAULT_COMPONENT', 'posts' );	
}

add_post_type_support( 'product', 'buddypress-activity' );
function rh_customize_product_tracking_args() {
    // Check if the Activity component is active before using it.
    if ( ! bp_is_active( 'activity' ) ) {
        return;
    }
 
    bp_activity_set_post_type_tracking_args( 'product', array(
        
        'action_id'                => 'new_product',
        'bp_activity_admin_filter' => __( 'Published a new product', 'rehub_framework' ),
        'bp_activity_front_filter' => __( 'Products', 'rehub_framework' ),
        'contexts'                 => array( 'activity', 'member' ),
        'activity_comment'         => true,
        'bp_activity_new_post'     => __( '%1$s posted a new <a href="%2$s">product</a>', 'rehub_framework' ),
        'bp_activity_new_post_ms'  => __( '%1$s posted a new <a href="%2$s">product</a>, on the site %3$s', 'rehub_framework' ),
        'position'                 => 100,
    ) );
}
add_action( 'bp_init', 'rh_customize_product_tracking_args' );

add_filter('bp_get_messages_content_value', 'rh_custom_message_placeholder_in_bp_message' );
function rh_custom_message_placeholder_in_bp_message(){
	if(!empty($_GET['ref'])){
		$content = __('I am interesting in: ', 'rehub_framework').urldecode($_GET['ref']);
		$content = esc_html($content);
	}
	elseif(!empty( $_POST['content'] )){
		$content = $_POST['content'];
	}
	else{
		$content = '';
	}
	return $content;	
}