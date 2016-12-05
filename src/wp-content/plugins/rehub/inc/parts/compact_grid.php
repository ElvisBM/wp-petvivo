<?php global $post;?>
<?php
$columns = (isset($columns)) ? $columns : '';
$aff_link = (isset($aff_link)) ? $aff_link : '';
$disable_btn = (isset($disable_btn)) ? $disable_btn : '';
$disable_act = (isset($disable_act)) ? $disable_act : '';
$price_meta = (isset($price_meta)) ? $price_meta : 'admin';
?>

<?php 
if ($aff_link == '1') {
    $link = rehub_create_affiliate_link ();
    $target = ' rel="nofollow" target="_blank"';
}
else {
    $link = get_the_permalink();
    $target = '';  
}
?>
<article class="col_item offer_grid offer_grid_com<?php if ($disable_act != 1) :?> offer_act_enabled<?php endif;?><?php echo rh_expired_or_not($post->ID, 'class');?>"> 
    <div class="eq_height_inpost"><?php echo re_badge_create('ribbonleft'); ?> 
        <figure>
            <a href="<?php echo $link;?>"<?php echo $target;?>>
                <?php 
                $showimg = new WPSM_image_resizer();
                $showimg->use_thumb = true;                                    
                ?>
                <?php if($columns == '3_col') : ?>
                    <?php $showimg->height = '210';?>
                <?php elseif($columns == '4_col') : ?>
                    <?php $showimg->height = '150';?>                    
                <?php elseif($columns == '5_col') : ?>
                    <?php $showimg->height = '180';?>  
                <?php elseif($columns == '6_col') : ?>
                    <?php $showimg->height = '140';?>                    
                <?php else : ?>
                    <?php $showimg->height = '210';?>                                   
                <?php endif ; ?>
                <?php $showimg->show_resized_image(); ?>
            </a>
        </figure>
        <?php do_action( 'rehub_after_compact_grid_figure' ); ?>
        <div class="price_row_grid">
            <div class="price_for_grid floatleft">
                <?php rehub_create_btn('no', 'price') ;?>
            </div>
            <div class="floatright vendor_for_grid">
                <?php if ($price_meta == 'admin'):?>
                    <?php $author_id=$post->post_author;?>
                    <a class="admin" href="<?php echo get_author_posts_url( $author_id ) ?>" title="<?php the_author_meta( 'display_name', $author_id ); ?>">
                    <?php echo get_avatar( $author_id, '22' ); ?>
                    </a>
                <?php elseif ($price_meta == 'store'):?>
                    <div class="brand_logo_small">       
                        <?php WPSM_Postfilters::re_show_brand_tax('logo'); //show brand logo?>
                    </div>                    
                <?php endif;?>
            </div>
        </div>     
        <?php do_action( 'rehub_after_compact_grid_price' ); ?>        
        <h3 class="<?php if(rehub_option('hotmeter_disable') !='1') :?><?php echo getHotIconclass($post->ID); ?><?php endif ;?>"><?php echo rh_expired_or_not($post->ID, 'span');?><a href="<?php echo $link;?>"<?php echo $target;?>><?php the_title();?></a></h3> 
        <?php do_action( 'rehub_after_compact_grid_title' ); ?>
        <?php if ($disable_btn != 1) :?>
            <?php rehub_create_btn('no', 'button') ;?>
        <?php endif;?>                                          
    </div>
    <div class="meta_for_grid">
        <div class="cat_store_for_grid floatleft">
            <div class="cat_for_grid">
                <?php if ('post' == get_post_type($post->ID) && rehub_option('exclude_cat_meta') != 1) :?>
                    <?php $category = get_the_category($post->ID);  ?>
                    <?php if ($category) {$first_cat = $category[0]->term_id; meta_small( false, $first_cat, false, false );} ?>            
                <?php endif; ?>             
            </div>
            <?php do_action( 'rehub_after_compact_grid_cat' ); ?> 
            <div class="store_for_grid">
                <?php WPSM_Postfilters::re_show_brand_tax('list');?>
            </div>            
        </div>
        <div class="date_for_grid floatright">
            <span class="date_ago">
                <i class="fa fa-clock-o"></i><?php printf( __( '%s ago', 'rehub_framework' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?>
            </span>        
        </div>   
    </div>
    <?php do_action( 'rehub_after_compact_grid_meta' ); ?>
    <?php if ($disable_act != 1) :?>  
    <div class="re_actions_for_grid two_col_btn_for_grid">
        <div class="btn_act_for_grid">
            <?php echo getHotThumb($post->ID, false);?>
        </div>
        <div class="btn_act_for_grid">
            <span class="comm_number_for_grid"><?php echo get_comments_number(); ?></span>
        </div>
    </div> 
    <?php do_action( 'rehub_after_compact_grid_actions' ); ?>
    <?php endif;?>      
</article>