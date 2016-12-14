<!DOCTYPE html>
<!--[if IE 8]>    <html class="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>    <html class="ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)] <?php language_attributes(); ?>><![endif]-->
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width" />
<!-- feeds & pingback -->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]><script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script><![endif]-->	
<?php wp_head(); ?>
<?php if(rehub_option('rehub_custom_css')) : ?><style><?php echo rehub_option('rehub_custom_css'); ?></style><?php endif; ?>
</head>
<body <?php body_class(); ?>>
<?php 
    $logo_menu_enable = (rehub_option('rehub_logo_inmenu') !='' || rehub_option('rehub_header_style') == 'header_five') ? ' mobile_logo_enabled' : '';
    $logo_menu_row_enable = (rehub_option('rehub_header_style') == 'header_five') ? ' logo_menu_row_enable' : '';  
?>
<?php 
    if (rehub_option('header_topline_style') == '0') {
        $header_topline_style = ' white_style';
    }
    elseif (rehub_option('header_topline_style') == '1') {
        $header_topline_style = ' dark_style';
    }
    else {
        $header_topline_style = ' white_style';
    }    
?>
<?php 
    if (rehub_option('header_logoline_style') == '0') {
        $header_logoline_style = 'white_style';
    }
    elseif (rehub_option('header_logoline_style') == '1') {
        $header_logoline_style = 'dark_style';
    }
    else {
        $header_logoline_style = 'white_style';
    }    
?>
<?php 
    if (rehub_option('header_menuline_style') == '0') {
        $header_menuline_style = ' white_style';
    }
    elseif (rehub_option('header_menuline_style') == '1') {
        $header_menuline_style = ' dark_style';
    }
    else {
        $header_menuline_style = ' dark_style';
    }    
?>
<?php get_template_part('inc/parts/branded_bg'); ?>
<?php if(rehub_option('rehub_ads_megatop') !='') : ?>
	<div class="megatop_wrap">
		<div class="mediad megatop_mediad">
			<?php echo do_shortcode(rehub_option('rehub_ads_megatop')); ?>
		</div>
	</div>
<?php endif ;?>	
<!-- HEADER -->
<header id="main_header" class="<?php echo $header_logoline_style; echo $logo_menu_enable; echo $logo_menu_row_enable; ?>">
<div class="header_wrap">
    <div id="top_ankor"></div>
    <?php if(rehub_option('rehub_header_top') !='1')  : ?>  
        <!-- top -->  
        <div class="header_top_wrap<?php echo $header_topline_style;?>">
            <div class="header-top clearfix">    
                <?php if(has_nav_menu('user_logged_in_menu') && is_user_logged_in() && rehub_option('rehub_logged_enable_intop') == '1'): ?>
                    <?php wp_nav_menu( array( 'container_class' => 'top-nav', 'container' => 'div', 'theme_location' => 'user_logged_in_menu', 'fallback_cb' => 'add_top_menu_for_blank', 'depth' => '1', 'items_wrap' => '<i class="fa fa-caret-down re-top-menu-collapse"></i><ul id="%1$s" class="%2$s">%3$s</ul>'  ) ); ?> 
                <?php else :?>
                    <?php wp_nav_menu( array( 'container_class' => 'top-nav', 'container' => 'div', 'theme_location' => 'top-menu', 'fallback_cb' => 'add_top_menu_for_blank', 'depth' => '1', 'items_wrap' => '<i class="fa fa-caret-down re-top-menu-collapse"></i><ul id="%1$s" class="%2$s">%3$s</ul>'  ) ); ?>
                <?php endif;?>
                <div class="top-social"> 
                    <?php if(rehub_option('rehub_login_icon') == 'top' && rehub_option('userlogin_enable') == '1') : ?>
                       <?php echo do_shortcode ('[wpsm_user_modal]');?>
                    <?php endif; ?>            
           			<?php if(rehub_option('rehub_header_social')) : ?>
                     	<?php rehub_get_social_links('small');?>  
                   	<?php endif; ?>        
                    <?php global $woocommerce; ?>
                    <?php if ($woocommerce && rehub_option('woo_cart_place') =='1') : ?><a class="cart-contents cart_count_<?php echo $woocommerce->cart->cart_contents_count; ?>" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i> <?php _e( 'Cart', 'rehub_framework' ); ?> (<?php echo $woocommerce->cart->cart_contents_count; ?>) - <?php echo $woocommerce->cart->get_cart_total(); ?></a><?php endif; ?>
                </div>
            </div>
        </div>
        <!-- /top --> 
    <?php endif; ?>
    <!-- Logo section -->
    <div class="logo_section_wrap">
        <div class="logo-section <?php echo rehub_option('rehub_header_style') ;?>_style clearfix">
            <div class="logo">
          		<?php if(rehub_option('rehub_logo')) : ?>
          			<a href="<?php echo home_url(); ?>" class="logo_image"><img src="<?php echo rehub_option('rehub_logo'); ?>" alt="<?php bloginfo( 'name' ); ?>" height="<?php echo rehub_option( 'rehub_logo_retina_height' ); ?>" width="<?php echo rehub_option( 'rehub_logo_retina_width' ); ?>" /></a>
          		<?php elseif (rehub_option('rehub_text_logo')) : ?>
                <div class="textlogo"><?php echo rehub_option('rehub_text_logo'); ?></div>
                <div class="sloganlogo">
                    <?php if(rehub_option('rehub_text_slogan')) : ?><?php echo rehub_option('rehub_text_slogan'); ?><?php else : ?><?php bloginfo( 'description' ); ?><?php endif; ?>
                </div> 
                <?php else : ?>
          			<div class="textlogo"><?php bloginfo( 'name' ); ?></div>
                    <div class="sloganlogo"><?php bloginfo( 'description' ); ?></div>
          		<?php endif; ?>       
            </div>
            <?php if(rehub_option('rehub_header_style') == 'header_first' || rehub_option('rehub_header_style') == 'header_seven') : ?><div class="search head_search"><?php get_search_form(); ?></div><?php endif; ?>
            <?php if(rehub_option('rehub_header_style') != 'header_third' && rehub_option('rehub_header_style') != 'header_six') : ?><?php if(rehub_option('rehub_ads_top')) : ?><div class="mediad"><?php echo do_shortcode(rehub_option('rehub_ads_top')); ?></div><?php endif; ?><?php endif; ?>
            <?php if(rehub_option('rehub_header_style') == 'header_six') : ?>
                <?php if(rehub_option('header_six_menu') != '') : ?>
                    <?php $nav_menu = wp_get_nav_menu_object( rehub_option('header_six_menu') ); // Get menu
                    if (!empty ($nav_menu)) :?>
                        <div id="re_menu_near_logo">
                            <?php wp_nav_menu( array( 'fallback_cb' => '', 'menu' => $nav_menu, 'container' => false  ) );?>
                        </div>
                    <?php endif ;?>                                       
                <?php endif; ?>
                <?php if(rehub_option('header_six_login') == 1) : ?>
                    <?php $rtlclass = (is_rtl()) ? 'floatleft mr10' : 'floatright ml10'; ?>
                    <?php $loginurl = (rehub_option('header_six_btn_login_url')) ? ' loginurl='.esc_url(rehub_option('header_six_btn_login_url')).'' : '';?>
                    <?php echo do_shortcode('[wpsm_user_modal as_btn="1" class="mobileinmenu '.$rtlclass.'"'.$loginurl.']') ;?>
                <?php endif; ?> 
                <?php if(rehub_option('header_six_btn') == 1) : ?>
                    <?php $rtlclass = (is_rtl()) ? 'floatleft' : 'floatright'; ?>
                    <?php $btnlink = rehub_option('header_six_btn_url'); ?>
                    <?php $btnlabel = rehub_option('header_six_btn_txt'); ?>
                    <?php $btn_color = (rehub_option('header_six_btn_color') != '') ? rehub_option('header_six_btn_color') : 'green'; ?>
                    <?php $header_six_btn_login = (rehub_option('header_six_btn_login') == 1) ? 'act-rehub-login-popup' : ''; ?>
                    <?php echo do_shortcode('[wpsm_button icon="plus" link="'.$btnlink.'" class="addsomebtn mobileinmenu mr5 ml5 '.$header_six_btn_login.' '.$rtlclass.'" color="'.$btn_color.'"]'.$btnlabel.'[/wpsm_button]') ;?>
                <?php endif; ?>
                <?php if(rehub_option('header_six_src') == 1) : ?>
                    <?php $rtlclass = (is_rtl()) ? 'floatleft' : 'floatright'; ?>
                    <?php echo do_shortcode('[wpsm_searchform class="head_search floatright disableonmobile mr5 ml5"]') ;?>
                <?php endif; ?>                                                
            <?php endif; ?> 
            <?php if(rehub_option('rehub_header_style') == 'header_seven') : ?>
                <div class="header-actions-logo">
                    <div class="tabledisplay">
                        <?php if(rehub_option('header_seven_more_element') != '') : ?>
                            <?php $custom_element = rehub_option('header_seven_more_element'); ?>
                            <div class="celldisplay link-add-cell">
                                <?php echo do_shortcode($custom_element);?>
                            </div>
                        <?php endif; ?>                                    
                        <?php $loginurl = (rehub_option('header_seven_btn_login_url')) ? ' loginurl='.esc_url(rehub_option('header_seven_btn_login_url')).'' : '';?>
                        <div class="celldisplay login-btn-cell">
                            <?php $rtlclass = (is_rtl()) ? 'floatleft' : 'floatright'; ?>
                            <?php echo do_shortcode('[wpsm_user_modal as_btn="1" class="mobileinmenu '.$rtlclass.'"'.$loginurl.']') ;?>
                        </div> 
                        <?php 
                        if (rehub_option('header_seven_compare_btn') != 1){
                            global $woocommerce;
                            if ($woocommerce){
                            echo '<div class="celldisplay rh_woocartmenu_cell"><a class="rh_woocartmenu-link icon-in-main-menu menu-item-one-line cart-contents cart_count_'.$woocommerce->cart->cart_contents_count.'" href="'.$woocommerce->cart->get_cart_url().'"><span class="rh_woocartmenu-icon"><strong>'.$woocommerce->cart->cart_contents_count.'</strong><span class="rh_woocartmenu-icon-handle"></span></span><span class="rh_woocartmenu-amount">'.$woocommerce->cart->get_cart_total().'</span></a></div>';
                            }                            
                        }
                        else{
                            echo '<div class="celldisplay rh_woocartmenu_cell">';
                            echo do_shortcode('[rh_compare_icon]' );
                            echo '</div>';
                        }
                        ?>
                    </div>                     
                </div>                                              
            <?php endif; ?>                         
        </div>
    </div>
    <!-- /Logo section -->  
    <!-- Main Navigation -->
    <div class="main-nav<?php echo $header_menuline_style;?>">   
        <?php wp_nav_menu( array( 'container_class' => 'top_menu', 'container' => 'nav', 'theme_location' => 'primary-menu', 'fallback_cb' => 'add_menu_for_blank', 'walker' => new Rehub_Walker ) ); ?>
        <div class="responsive_nav_wrap">
        </div>
        <div class="search-header-contents"><?php get_search_form() ?></div>
    </div>
    <!-- /Main Navigation -->
</div>  
</header>
<?php get_template_part('inc/parts/branded_banner'); ?>
<?php get_template_part('inc/parts/news_ticker'); ?>
<?php do_action('rehub_action_after_header'); ?>