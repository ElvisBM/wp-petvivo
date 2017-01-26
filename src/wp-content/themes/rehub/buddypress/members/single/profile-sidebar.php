<div class="rh-mini-sidebar floatleft tabletblockdisplay">
	<?php if (defined('wcv_plugin_dir')):?>
		<?php 	
			$vendor_id = bp_displayed_user_id();
			$count_likes = ( get_user_meta( $author_ID, 'overall_post_likes', true) ) ? get_user_meta( $author_ID, 'overall_post_likes', true) : '0';
		?>
		<?php if(WCV_Vendors::is_vendor( $vendor_id )):?>
			<div class="rh-cartbox user-profile-div text-center widget">
				<div class="widget-inner-title rehub-main-font"><?php _e('Owner of shop', 'rehub_framework');?></div>
				<div class="mb20"><a href="<?php echo WCV_Vendors::get_vendor_shop_page( $vendor_id );?>"><img src="<?php echo rh_show_vendor_avatar($vendor_id, 150, 150);?>" class="vendor_store_image_single" width=150 height=150 /></a>
				</div>
				<div class="profile-usertitle-name mb20">
                	<a href="<?php echo WCV_Vendors::get_vendor_shop_page( $vendor_id );?>">
                		<?php echo WCV_Vendors::get_vendor_sold_by( $vendor_id );?>
                	</a>	                    
                </div>
                <div class="profile-stats">
                    <?php if (rehub_option('woo_thumb_enable') == '1') :?><div><i class="fa fa-heartbeat"></i><?php _e( 'Product Votes', 'rehub_framework' ); echo ': ' . $count_likes; ?></div><?php endif;?>
                    <div><i class="fa fa-briefcase"></i><?php _e( 'Total products', 'rehub_framework' ); echo ': ' . count_user_posts( $vendor_id, $post_type = 'product' ); ?></div>	  	
                </div>                    						
			</div>
		<?php endif;?>
	<?php endif;?>
    <?php if ( is_active_sidebar( 'bprh-profile-sidebar' ) ) : ?>
        <?php dynamic_sidebar( 'bprh-profile-sidebar' ); ?>
    <?php endif;?>	        		
</div>