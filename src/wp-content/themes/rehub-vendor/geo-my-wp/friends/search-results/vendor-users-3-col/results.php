<?php
/**
 * Members locator "default" search results template file. 
 * 
 * The information on this file will be displayed as the search results.
 * 
 * The function pass 2 args for you to use:
 * $gmw    - the form being used ( array )
 * $member - each member in the loop
 * 
 * You could but It is not recomemnded to edit this file directly as your changes will be overridden on the next update of the plugin.
 * Instead you can copy-paste this template ( the "default" folder contains this file and the "css" folder ) 
 * into the theme's or child theme's folder of your site and apply your changes from there. 
 * 
 * The template folder will need to be placed under:
 * your-theme's-or-child-theme's-folder/geo-my-wp/friends/search-results/
 * 
 * Once the template folder is in the theme's folder you will be able to choose it when editing the Members locator form.
 * It will show in the "Search results" dropdown menu as "Custom: default".
 */
?>	
<?php if (!class_exists('WCV_Vendors')) return;?>
<!--  Main results wrapper - wraps the paginations, map and results -->
<div class="gmw-results-wrapper gmw-results-wrapper-<?php echo $gmw['ID']; ?> gmw-fl-default-results-wrapper">
    <div id="buddypress">
	<?php do_action( 'gmw_search_results_start' , $gmw ); ?>
	
    <div id="pag-top" class="geo-pagination">

    	<!-- results message -->
        <div class="pag-count floatleft" id="member-dir-count-top">
            <?php bp_members_pagination_count(); ?><?php gmw_results_message( $gmw, false ); ?>
        </div>
		
		<!-- per page -->
		<?php gmw_per_page( $gmw, $gmw['total_results'], 'paged' ); ?>
		
		<!-- pagination -->
        <div class="pagination-links" id="member-dir-pag-top">
    		<?php gmw_pagination( $gmw, 'paged', $gmw['max_pages'] ); ?>
        </div>
    </div>

    <div class="clear"></div>

    <!-- GEO my WP Map -->
    <?php 
    if ( $gmw['search_results']['display_map'] == 'results' ) {
        gmw_results_map( $gmw );
    }
    ?>
    
    <?php do_action( 'bp_before_directory_members_list' ); ?>
    <div class="mt20"></div>
    <ul class="wcv_vendorslist col_wrap_three rh-flex-eq-height">
    <?php while ( bp_members() ) : bp_the_member(); ?>
        
        <!-- do not remove this line -->
        <?php $member = $members_template->member; ?>
        <?php $vendor_id = bp_get_member_user_id();?>
        <?php $shop_link = WCV_Vendors::is_vendor($vendor_id) ? WCV_Vendors::get_vendor_shop_page($vendor_id) : bp_get_member_permalink();?>
        <?php $shop_name = WCV_Vendors::is_vendor( $vendor_id ) ? WCV_Vendors::get_vendor_sold_by( $vendor_id ) : $member->display_name;?>
        <?php 
        $store_bg = '';
        if ( class_exists( 'WCVendors_Pro' ) ) {
            $vendor_meta = array_map( function( $a ){ return $a[0]; }, get_user_meta($vendor_id ) );
            $store_icon_src     = wp_get_attachment_image_src( get_user_meta( $vendor_id, '_wcv_store_banner_id', true ), 'full');
            if ( is_array( $store_icon_src ) ) { 
                $store_bg= $store_icon_src[0]; 
            }   
        }
        else {
            $store_banner_src  = wp_get_attachment_image_src( get_user_meta( $vendor_id, 'rh_vendor_free_header', true ), 'full');
            if ( is_array( $store_banner_src ) ) { 
                $store_bg= $store_banner_src[0]; 
            }   
        }        
        $bg_styles = (!empty($store_bg)) ? ' style="background-image: url('.$store_bg.'); background-repeat: no-repeat;background-size: cover;"' : '';
        ?>        
        <li <?php bp_member_class( array('col_item') ); ?>>
            <!-- do not remove this line -->
            <?php do_action( 'gmw_search_results_loop_item_start', $gmw, $member ); ?>        
            <?php 
                $author_ID = bp_get_member_user_id();
            ?>
            <div class="member-inner-list">
                <div class="vendor-list-like"><?php echo getShopLikeButton($vendor_id);?></div>
                <a href="<?php echo $shop_link; ?>">
                    <span class="cover_logo"<?php echo $bg_styles; ?>></span>
                </a>   
                <div class="member-details">                    
                    <div class="item-avatar">
                        <a href="<?php echo $shop_link; ?>">
                            <img src="<?php echo rh_show_vendor_avatar($vendor_id, 80, 80);?>" class="vendor_store_image_single" width=80 height=80 />
                        </a>
                    </div>  
                    <a href="<?php echo $shop_link; ?>" class="wcv-grid-shop-name"><?php echo $shop_name; ?></a>
                    <?php if ( class_exists( 'WCVendors_Pro' ) ) {
                        if ( ! WCVendors_Pro::get_option( 'ratings_management_cap' ) ) {
                            echo '<div class="wcv_grid_rating">';
                            echo WCVendors_Pro_Ratings_Controller::ratings_link( $vendor_id, true );
                            echo '</div>';
                        }
                    }?>
                    <div class="adress-vendor-gmw-list">
                        <?php do_action( 'gmw_search_results_before_distance', $gmw, $member); ?>                        
                        <!-- distance -->
                        <div class="distance-to-user-geo"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php gmw_distance_to_location( $members_template->member, $gmw ); ?></div>
                        <?php do_action( 'gmw_fl_search_results_member_items', $gmw, $member ); ?> 
                        <div class="adress-user-geo">
                            <?php do_action( 'gmw_search_results_before_address', $gmw, $member ); ?>                   
                            <!-- address -->
                            <div>
                                <span><?php echo $gmw['labels']['search_results']['address'] ?></span>
                                <?php gmw_location_address( $member, $gmw ); ?>
                            </div>                
                            <!-- Get directions -->     
                            <?php if ( isset( $gmw['search_results']['get_directions'] ) ) { ?>
                                <?php global $members_template; ?>
                                <div class="get-directions-link">
                                    <?php gmw_directions_link( $members_template->member, $gmw, $gmw['labels']['search_results']['directions'] ); ?>
                                </div>
                            <?php } ?>                
                        </div>                        
                    </div> 
                </div>                              

                <?php do_action( 'gmw_search_results_loop_item_end', $gmw, $member ); ?>                
            </div>
        </li>
    <?php endwhile; ?>
    </ul>

    <?php do_action( 'bp_after_directory_members_list' ); ?>

    <?php bp_member_hidden_fields(); ?>
	
	<?php do_action( 'gmw_search_results_end', $gmw ); ?>	
    </div>
</div>