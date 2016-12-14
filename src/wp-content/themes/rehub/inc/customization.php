<?php ob_start(); ?>
<style type="text/css">
<?php if (rehub_option('rehub_logo_pad_top') !='') :?>
	@media (min-width: 768px){
		header .logo-section{padding-top: <?php echo rehub_option('rehub_logo_pad_top') ?>px;}		
	}
<?php endif; ?>
<?php if (rehub_option('rehub_logo_pad_bottom') !='') :?>
	@media (min-width: 768px){
		header .logo-section{padding-bottom: <?php echo rehub_option('rehub_logo_pad_bottom') ?>px;}		
	}
<?php endif; ?>
<?php if (rehub_option('rehub_logo_padsix_top') !='') :?>
	.header_six_style .user-dropdown-intop, .header_six_style .wpsm-button, .header_six_style .head_search, .header_six_style #re_menu_near_logo{ margin-top: <?php echo rehub_option('rehub_logo_padsix_top') ?>px; margin-bottom: <?php echo rehub_option('rehub_logo_padsix_top') ?>px }
<?php endif; ?>
<?php if (rehub_option('rehub_logo_padseven_top') !='') :?>
	.header_seven_style .search, .header_seven_style .header-actions-logo{ margin-top: <?php echo rehub_option('rehub_logo_padseven_top') ?>px; margin-bottom: <?php echo rehub_option('rehub_logo_padseven_top') ?>px }
<?php endif; ?>
<?php if (rehub_option('rehub_color_link')) :?>
	article.post a{color: <?php echo rehub_option('rehub_color_link') ?>;}
<?php endif; ?>
<?php if (is_page_template('visual_builder.php')) :?>
	<?php if (vp_metabox('vcr.bg_disable') =='1') :?>body{ background: none #fff}<?php endif; ?>
	<?php if (vp_metabox('vcr.menu_disable') =='1') :?>nav.top_menu{display: none !important;}<?php endif; ?>
<?php endif; ?>	
<?php if (rehub_option('rehub_sticky_nav')) :?>
	header .main-nav{position: relative; z-index: 999;    width: 100%;}
<?php endif; ?>
<?php if (is_singular('post') && rehub_option('rehub_replace_color') =='1' && rehub_option('color_type_review') =='simple') :?>
	<?php $category = get_the_category($post->ID); $first_cat = $category[0]->term_id; $cat_data = get_option("category_$first_cat");?>
		<?php if (!empty($cat_data['cat_color'])) :?>
			.category-<?php echo $first_cat ;?> .rate-line .filled, .category-<?php echo $first_cat ;?> .rate_bar_wrap .review-top .overall-score, .category-<?php echo $first_cat ;?> .rate-bar-bar{background-color: <?php echo $cat_data['cat_color'];?> !important; color:#fff !important; text-decoration: none;}
			.category-<?php echo $first_cat ;?> .rate_bar_wrap_two_reviews .score_val, .category-<?php echo $first_cat ;?> .rate_bar_wrap_two_reviews .user-review-criteria .score_val{border-color: <?php echo $cat_data['cat_color'];?>}
			.category-<?php echo $first_cat ;?>.user_reviews_view .userstar-rating span:before{color: <?php echo $cat_data['cat_color'];?>}
		<?php endif;?>
<?php endif; ?>				 
<?php if (rehub_option('rehub_bg_flat_color')) :?>
	body{background-color: <?php echo rehub_option('rehub_bg_flat_color') ?> ; background-image: none;}
<?php endif; ?>	
<?php if (rehub_option('rehub_review_color') && rehub_option('color_type_review') =='simple') :?>
	.rate-line .filled, .rate_bar_wrap .review-top .overall-score, .rate-bar-bar, .top_rating_item .score.square_score, .radial-progress .circle .mask .fill{background-color: <?php echo rehub_option('rehub_review_color') ?> ;}
	.meter-wrapper .meter, .rate_bar_wrap_two_reviews .score_val{border-color: <?php echo rehub_option('rehub_review_color') ?>;}
<?php endif; ?>	
<?php if (rehub_option('rehub_review_color_user') && rehub_option('color_type_review') =='simple') :?>
	.user-review-criteria .rate-bar-bar{background-color: <?php echo rehub_option('rehub_review_color_user') ?> ;}
	.userstar-rating span:before{color: <?php echo rehub_option('rehub_review_color_user') ?>;}
	.rate_bar_wrap_two_reviews .user-review-criteria .score_val{border-color: <?php echo rehub_option('rehub_review_color_user') ?>;}
<?php endif; ?>
<?php if (rehub_option('rehub_userreview_multicolor') && rehub_option('color_type_review') =='multicolor') :?>
	.userstar-rating span:before{color: <?php echo rehub_option('rehub_userreview_multicolor') ?>;}
<?php endif; ?>	
<?php if (rehub_option('rehub_content_shadow') ) :?>
	.main-side, .vc_row.vc_rehub_container > .vc_col-sm-8, .sidebar .widget, .masonry_grid_fullwidth .small_post, .repick_item.small_post{border: none;}
	.masonry_grid_fullwidth .small_post, .repick_item.small_post{ box-shadow: none;}
<?php endif; ?>	

<?php if(rehub_option('rehub_nav_font')) : ?>
	.dl-menuwrapper li a, nav.top_menu ul li a, #re_menu_near_logo li, #re_menu_near_logo li {
		font-family:"<?php echo rehub_option('rehub_nav_font'); ?>", trebuchet ms !important;
		font-weight:<?php echo rehub_option('rehub_nav_font_weight'); ?>!important;
		font-style:<?php echo rehub_option('rehub_nav_font_style');?>;
		<?php if(rehub_option('rehub_nav_font_trans') =='1') : ?>text-transform:none;<?php endif; ?>			
	}
<?php endif; ?>	
<?php if(rehub_option('rehub_headings_font')) : ?>
	.priced_block .btn_offer_block,
	.rh-deal-compact-btn,
	.btn_block_part .btn_offer_block,
	.wpsm-button.rehub_main_btn,
	input[type="submit"],
	.woocommerce div.product p.price,
	.rehub_feat_block div.offer_title,
	.rh_wrapper_video_playlist .rh_video_title_and_time .rh_video_title,
	.main_slider .flex-overlay h2,
	.main_slider .flex-overlay a.btn_more,
	.woo_sell_block .price,
	.re-line-badge,
	.related_articles ul li > a,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.news_out_tabs .tabs-menu li,
	.cats_def a,
	.btn_more,
	.widget.tabs > ul > li,
	.featured_slider .reviews,
	.sidebar .featured_slider .link,
	.widget .title,
	.video_widget p,
	.footer-bottom .featured_slider .link,
	.title h1,
	.title h5,
	.small_post blockquote p,
	.post_slider .caption a,
	.related_articles .related_title,
	#comments .title_comments,
	.commentlist .comment-author .fn,
	.commentlist .comment-author .fn a,
	#commentform #submit,
	.media_video > p,
	.title_ecwid,
	.rate_bar_wrap .review-top .review-text span.review-header,
	.ap-pro-form-field-wrapper input[type="submit"],
	.vc_btn3,
	.wpsm-numbox.wpsm-style6 span.num,
	.wpsm-numbox.wpsm-style5 span.num,
	.woocommerce ul.product_list_widget li a,
	.widget.better_woocat,
	.re-compare-destin.wpsm-button,
	.rehub-main-font {
		font-family:"<?php echo rehub_option('rehub_headings_font'); ?>", trebuchet ms !important;
		font-weight:<?php echo rehub_option('rehub_headings_font_weight'); ?> !important;
		font-style:<?php echo rehub_option('rehub_headings_font_style'); ?> !important;
		<?php if(rehub_option('rehub_headings_font_upper') =='1') : ?>text-transform:uppercase;<?php endif; ?>			
	}
<?php endif; ?>
<?php if(rehub_option('rehub_body_font')) : ?>
	.news .detail p, article, .small_post > p, .single .star .title_stars, .breadcrumb, footer div.f_text, .header-top .top-nav li, .related_articles ul li > a, .commentlist .comment-content p, .sidebar, .prosconswidget, .rehub-body-font, .rehub_feat_block p {
		font-family:"<?php echo rehub_option('rehub_body_font'); ?>", arial;
		font-weight:<?php echo rehub_option('rehub_body_font_weight'); ?>!important;
		font-style:<?php echo rehub_option('rehub_body_font_style'); ?>;			
	}
<?php endif; ?>	
<?php if(rehub_option('body_font_size')) : ?>
	article {
		font-size:<?php echo intval(rehub_option('body_font_size'));?>px;		
	}
<?php endif; ?>		
<?php if(rehub_option('rehub_custom_color_nav') !='') : ?>
	header .main-nav, .main-nav.dark_style{
		background: none repeat scroll 0 0 <?php echo rehub_option('rehub_custom_color_nav'); ?>!important;
		box-shadow: none;			
	}
	.main-nav{ border-bottom: none;}
	.dl-menuwrapper .dl-menu{margin: 0 !important}
<?php endif; ?>	
<?php if(rehub_option('rehub_custom_color_top') !='') : ?>
	.header_top_wrap{
		background: none repeat scroll 0 0 <?php echo rehub_option('rehub_custom_color_top'); ?>!important;			
	}
	.header-top, .header_top_wrap{ border: none !important}
<?php endif; ?>	
<?php if(rehub_option('rehub_custom_color_top_font') !='') : ?>
	.header_top_wrap .user-ava-intop:after, .header-top .top-nav a, .header-top a.cart-contents, .header_top_wrap .icon-search-onclick:before{
		color: <?php echo rehub_option('rehub_custom_color_top_font'); ?> !important;			
	}
	.header-top .top-nav li{border: none !important;}
<?php endif; ?>			
<?php if(rehub_option('rehub_custom_color_nav_font') !='') : ?>
	.main-nav .user-ava-intop:after, nav.top_menu ul li a, .dl-menuwrapper button i{
		color: <?php echo rehub_option('rehub_custom_color_nav_font'); ?> !important;			
	}
	nav.top_menu > ul > li > a:hover{box-shadow: none;}
<?php endif; ?>	
<?php if (rehub_option('rehub_header_color_background') !='') :?>
	#main_header{background-color: <?php echo rehub_option('rehub_header_color_background'); ?> !important }
	.header-top{border: none;}
<?php endif; ?>
<?php if (rehub_option('rehub_header_background_image') !='') :?>
	<?php $bg_header_url = rehub_option('rehub_header_background_image'); ?>
	<?php $bg_header_position = (rehub_option('rehub_header_background_position') !='') ? rehub_option('rehub_header_background_position') : 'left'; ?>
	<?php $bg_header_repeat = (rehub_option('rehub_header_background_repeat') !='') ? rehub_option('rehub_header_background_repeat') : 'repeat'; ?>
	#main_header {background-image: url("<?php echo $bg_header_url ?>") ; background-position: <?php echo $bg_header_position ?> top; background-repeat: <?php echo $bg_header_repeat ?>}
<?php endif; ?>			
<?php if(rehub_option('rehub_sidebar_left') =='1') : ?>
	.main-side {float:right;}
	.sidebar{float: left}
<?php endif; ?>
<?php if(rehub_option('rehub_feature_color') !='') : ?>
	.main_slider .pattern {background-color: <?php echo rehub_option('rehub_feature_color'); ?>;}
<?php endif; ?>
<?php if (rehub_option('footer_color_background') !='') :?>
	.footer-bottom{background-color: <?php echo rehub_option('footer_color_background'); ?> !important }
	.footer-bottom .footer_widget{border: none !important}
<?php endif; ?>	
<?php if (rehub_option('footer_background_image') !='') :?>
	<?php $bg_footer_url = rehub_option('footer_background_image'); ?>
	<?php $bg_footer_position = (rehub_option('footer_background_position') !='') ? rehub_option('footer_background_position') : 'left'; ?>
	<?php $bg_footer_repeat = (rehub_option('footer_background_repeat') !='') ? rehub_option('footer_background_repeat') : 'repeat'; ?>
	.footer-bottom{background-image: url("<?php echo $bg_footer_url ?>") ; background-position: <?php echo $bg_footer_position ?> top; background-repeat: <?php echo $bg_footer_repeat ?>}
<?php endif; ?>	

/**********MAIN COLOR SCHEME*************/
<?php 
	if (rehub_option('rehub_custom_color')) {
		$maincolor = rehub_option('rehub_custom_color');
	} 
	elseif (rehub_option('rehub_color_schema') =='blue') {
		$maincolor = '#258FEF';
	}
	elseif (rehub_option('rehub_color_schema') =='green') {
		$maincolor = '#75C000';
	}
	elseif (rehub_option('rehub_color_schema') =='violet') {
		$maincolor = '#6B3387';
	}
	elseif (rehub_option('rehub_color_schema') =='yellow') {
		$maincolor = '#F9BA00';
	}
	else {
		if (REHUB_NAME_ACTIVE_THEME == 'RECASH') {
			$maincolor = '#fb7203';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'REPICK') {
			$maincolor = '#D7541A';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'RETHING') {
			$maincolor = '#B07C01';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'REVENDOR') {
			$maincolor = '#17baae';	
		}						
		else{
			$maincolor = '#fb7203';			
		}
	}
?>
<?php if (REHUB_NAME_ACTIVE_THEME == 'REVENDOR' || REHUB_NAME_ACTIVE_THEME == 'REWISE' ):?>
.rehub-main-color-border{border-color: <?php echo $maincolor; ?>;}
.widget .title:after{border-bottom: 2px solid <?php echo $maincolor; ?>;}
<?php endif;?>

.wpsm_promobox.rehub_promobox { border-left-color: <?php echo $maincolor; ?>!important; }
.top_rating_block .top_rating_item .rating_col a.read_full, .color_link{ color: <?php echo $maincolor; ?> !important;}
nav.top_menu > ul:not(.off-canvas) > li > a:hover, nav.top_menu > ul:not(.off-canvas) > li.current-menu-item a, .search-header-contents{border-top-color: <?php echo $maincolor; ?>; }

nav.top_menu > ul > li ul, .main-nav.dark_style { border-bottom: 2px solid <?php echo $maincolor; ?>; }
.wpb_content_element.wpsm-tabs.n_b_tab .wpb_tour_tabs_wrapper .wpb_tabs_nav .ui-state-active a{ border-bottom: 3px solid <?php echo $maincolor; ?> !important }
.featured_slider:hover .score, .top_chart_controls .controls:hover, article.post .wpsm_toplist_heading:before{border-color:<?php echo $maincolor; ?>;}
.btn_more:hover, .small_post .overlay .btn_more:hover { border: 1px solid <?php echo $maincolor; ?>; color: #fff }
.wpsm-tabs ul.ui-tabs-nav .ui-state-active a, .rehub_woo_review .rehub_woo_tabs_menu li.current { border-top: 3px solid <?php echo $maincolor; ?>; }
.wps_promobox { border-left: 3px solid <?php echo $maincolor; ?>; }
.gallery-pics .gp-overlay {  box-shadow: 0 0 0 4px <?php echo $maincolor; ?> inset; }
.post .rehub_woo_tabs_menu li.current, .woocommerce div.product .woocommerce-tabs ul.tabs li.active{ border-top:2px solid <?php echo $maincolor; ?>;}
.rething_item a.cat{border-bottom-color: <?php echo $maincolor; ?>}
nav.top_menu ul li ul { border-bottom: 2px solid <?php echo $maincolor; ?>; }
.widget.deal_daywoo{border: 3px solid <?php echo $maincolor; ?>; padding: 20px; background: #fff; box-sizing: border-box;}
.deal_daywoo .wpsm-bar-bar{background-color: <?php echo $maincolor; ?> !important}

/*BGS*/
#buddypress div.item-list-tabs ul li.selected a span,
#buddypress div.item-list-tabs ul li.current a span,
#buddypress div.item-list-tabs ul li a span,
.user-profile-div .user-menu-tab > li.active > a,
.user-profile-div .user-menu-tab > li.active > a:focus,
.user-profile-div .user-menu-tab > li.active > a:hover,
.slide .news_cat a,
.news_in_thumb:hover .news_cat a,
.news_out_thumb:hover .news_cat a,
.col-feat-grid:hover .news_cat a,
.alphabet-filter .return_to_letters span,
.carousel-style-deal .re_carousel .controls,
.re_carousel .controls:hover,
.openedprevnext .postNavigation a,
.postNavigation a:hover,
.top_chart_pagination a.selected,
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,
.main_slider .flex-control-paging li a.flex-active,
.main_slider .flex-control-paging li a:hover,
.widget_edd_cart_widget .edd-cart-number-of-items .edd-cart-quantity,
.btn_more:hover,
.news_out_tabs > ul > li:hover,
.news_out_tabs > ul > li.current,
.featured_slider:hover .score,
#bbp_user_edit_submit,
.bbp-topic-pagination a,
.bbp-topic-pagination a,
.widget.tabs > ul > li:hover,
.custom-checkbox label.checked:after,
.post_slider .caption,
.slider_post .caption,
ul.postpagination li.active a,
ul.postpagination li:hover a,
ul.postpagination li a:focus,
.post_slider .flex-control-nav li a.flex-active,
.post_slider .flex-control-nav li a:hover,
.top_theme h5 strong,
.re_carousel .text:after,
.widget.tabs .current,
#topcontrol:hover,
.featured_slider .flex-control-paging li a.flex-active,
.featured_slider .flex-control-paging li a:hover,
.main_slider .flex-overlay:hover a.read-more,
.rehub_chimp #mc_embed_signup input#mc-embedded-subscribe, 
#rank_1.top_rating_item .rank_count, 
#toplistmenu > ul li:before,
.rehub_chimp:before,
.wpsm-members > strong:first-child,
.r_catbox_btn,
.wpcf7 .wpcf7-submit,
.rh_woocartmenu-icon,
.comm_meta_wrap .rh_user_s2_label,
.wpsm_pretty_hover li:hover,
.rehub-main-color-bg
 { background: <?php echo $maincolor;?>;}
@media (max-width: 767px) {
	.postNavigation a{ background: <?php echo $maincolor; ?>; }
}

/*color*/
a, 
.carousel-style-deal .deal-item .priced_block .price_count ins, 
nav.top_menu ul li.menu-item-has-children ul li.menu-item-has-children > a:before, 
.top_chart_controls .controls:hover,
.flexslider .fa-pulse,
.footer-bottom .widget .f_menu li a:hover,
.comment_form h3 a,
.bbp-body li.bbp-forum-info > a:hover,
.bbp-body li.bbp-topic-title > a:hover,
#subscription-toggle a:before,
#favorite-toggle a:before,
.aff_offer_links .aff_name a,
.rh-deal-price,
.rehub_feat_block .start_price span,
.news_lettr p a,
.sidebar .featured_slider .link,
.commentlist .comment-content small a,
.related_articles .title_cat_related a,
article em.emph,
.campare_table table.one td strong.red,
.sidebar .tabs-item .detail p a,
.category_tab h5 a:hover,
.footer-bottom .widget .title span,
footer p a,
.welcome-frase strong, 
.news_lettr:after, 
article.post .wpsm_toplist_heading:before, 
article.post a.color_link,
.categoriesbox:hover h3 a:after,
.bbp-body li.bbp-forum-info > a,
.bbp-body li.bbp-topic-title > a,
.widget .title i,
.woocommerce-MyAccount-navigation ul li.is-active a,
.category-vendormenu li.current a,
.deal_daywoo .title,
.rehub-main-color
{ color: <?php echo $maincolor; ?>; }

<?php if (rehub_option('rehub_ecwid_enable')) :?>
	/*ecwid*/
	html#ecwid_html body#ecwid_body div.ecwid-minicart-counter, html#ecwid_html body#ecwid_body .ecwid-AddressForm-buttonsPanel button.gwt-Button { background-color: <?php echo $maincolor; ?> !important; }
	html#ecwid_html body#ecwid_body div.ecwid-minicart-link * { color: <?php echo $maincolor; ?> !important; }
	html#ecwid_html body#ecwid_body td.ecwid-categories-vertical-table-cell.ecwid-categories-vertical-table-cell-selected span.ecwid-categories-category { background-color: <?php echo $maincolor; ?> !important; color: #fff !important; }
	html#ecwid_html body#ecwid_body div.ecwid-productBrowser-categoryPath a, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-categoryPath a:active, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-categoryPath a:visited { color: #111 !important; }
	html#ecwid_html body#ecwid_body .ecwid-productBrowser-subcategories-mainTable tbody tr td:hover > div { border: 1px solid <?php echo $maincolor; ?> !important }
	html#ecwid_html body#ecwid_body .ecwid-productBrowser-subcategories-mainTable tbody tr:nth-child(3n+2) td:hover > div{ border: 1px solid <?php echo $maincolor; ?> !important; border-top: none !important; background: <?php echo $maincolor; ?> none !important; color: #fff !important }
	html#ecwid_html body#ecwid_body div.ecwid-productBrowser-price { color: #A20505 !important; }
	html#ecwid_html body#ecwid_body div.ecwid-ProductBrowser-auth-anonim a, html#ecwid_html body#ecwid_body div.ecwid-ProductBrowser-auth-logged a, html#ecwid_html body#ecwid_body div.ecwid-pager span.ecwid-pager-link-disabled, html#ecwid_html body#ecwid_body div.ecwid-Invoice-cell-title { background-color: <?php echo $maincolor; ?> !important; }
	html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart div.ecwid-productBrowser-price { color: #A20505 !important; }
	html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-totalAmount { color: #A20505 !important; }
	html#ecwid_html body#ecwid_body div.ecwid-Checkout-blockTitle, html#ecwid_html body#ecwid_body table.ecwid-Checkout-blockTitle div.gwt-Label, html#ecwid_html body#ecwid_body table.ecwid-Checkout-blockTitle div.gwt-HTML { color: #444 !important; }
	html#ecwid_html body#ecwid_body div.ecwid-Checkout-BreadCrumbs-link-visited{color: <?php echo $maincolor; ?> !important; }
	html#ecwid_html body#ecwid_body div.ecwid-Checkout-BreadCrumbs-link-current {border-bottom: 3px solid <?php echo $maincolor; ?> !important; color: <?php echo $maincolor; ?> !important;}
	html#ecwid_html body#ecwid_body div.ecwid-Invoice-cell-title {background-color: <?php echo $maincolor; ?> !important; }
	html#ecwid_html body#ecwid_body div.ecwid-Invoice-productPrice{ color: #A20505 !important; }
	html#ecwid_html body#ecwid_body td.ecwid-Invoice-Header-OrderId span, html#ecwid_html body#ecwid_body td.ecwid-Invoice-Header-OrderId-long span, html#ecwid_html body#ecwid_body td.ecwid-Invoice-Header-OrderId-very-long span{ color: #A20505 !important; }
	html#ecwid_html body#ecwid_body div.ecwid-Invoice-Summary-value-price{ color: #A20505 !important; }
	/*html#ecwid_html body#ecwid_body .ecwid a, html#ecwid_html body#ecwid_body .ecwid a:active, html#ecwid_html body#ecwid_body .ecwid a:visited{ color: #258FEF !important; }*/
	/* buttons */
	html#ecwid_html body#ecwid_body .ecwid .ecwid-btn--primary, html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-up, html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-ie6-up, html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-ie6-up-hovering, html#ecwid_html body#ecwid_body button.ecwid-AccentedButton, html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-down, html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-down-hovering, html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-ie6-down, html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-ie6-down-hovering, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-up, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-ie6-up, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-ie6-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-down, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-down-hovering, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-ie6-down, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-ie6-down-hovering, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-up, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-ie6-up, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-ie6-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-down, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-down-hovering, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-ie6-down, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-ie6-down-hovering, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-up, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-ie6-up, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-ie6-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-down, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-down-hovering, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-ie6-down, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-ie6-down-hovering  { background-color: <?php echo $maincolor; ?> !important;  box-shadow: none !important; border-radius: 3px !important; -webkit-transition: all 0.4s ease 0s !important; -moz-transition: all 0.4s ease 0s !important; -ms-transition: all 0.4s ease 0s !important; -o-transition: all 0.4s ease 0s !important; transition: all 0.4s ease 0s !important; }
	html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-ContinueShoppingButton-ie6-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-AddToBagButton-ie6-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-productBrowser-cart-checkoutButton-ie6-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-up-hovering, html#ecwid_html body#ecwid_body div.ecwid-Checkout-placeOrderButton-ie6-up-hovering, html#ecwid_html body#ecwid_body button.ecwid-AccentedButton:hover { background-color: #111111 !important; background-position: left bottom !important }
<?php endif; ?>

/**********SECONDARY COLOR SCHEME*************/
<?php 
	if (rehub_option('rehub_sec_color')) {
		$seccolor = rehub_option('rehub_sec_color');
	} 
	else {
		if (REHUB_NAME_ACTIVE_THEME == 'REPICK') {
			$seccolor = '#44AEFF';	
		}			
		else{
			$seccolor = '#111';			
		}
		
	}
?>
span.re_filtersort_btn:hover, 
span.active.re_filtersort_btn, 
.page-link > span:not(.page-link-title), 
.postimagetrend .title, .widget.widget_affegg_widget .title, 
.widget.top_offers .title, 
header .header_first_style .search form.search-form [type="submit"], 
.more_post a, 
.more_post span, 
.filter_home_pick span.active, 
.filter_home_pick span:hover, 
.filter_product_pick span.active,
.filter_product_pick span:hover,
.rh_tab_links a.active, 
.rh_tab_links a:hover, 
.wcv-navigation ul.menu li.active, 
.wcv-navigation ul.menu li:hover a, 
header .header_seven_style .search form.search-form [type="submit"],
.title_deal_wrap,
.rehub-sec-color-bg{ background: <?php echo $seccolor ?> !important; color: #fff !important;}
.widget.widget_affegg_widget .title:after, .widget.top_offers .title:after, .vc_tta-tabs.wpsm-tabs .vc_tta-tab.vc_active, .vc_tta-tabs.wpsm-tabs .vc_tta-panel.vc_active .vc_tta-panel-heading{border-top-color: <?php echo $seccolor ?> !important;}  
.page-link > span:not(.page-link-title){border: 1px solid <?php echo $seccolor ?>;}  
.page-link > span:not(.page-link-title), .header_first_style .search form.search-form [type="submit"] i{color:#fff !important;}
.rh_tab_links a.active,
.rh_tab_links a:hover,
.rehub-sec-color-border{border-color: <?php echo $seccolor ?>}
.rh_wrapper_video_playlist .rh_video_currently_playing, .rh_wrapper_video_playlist .rh_video_currently_playing.rh_click_video:hover {background-color: <?php echo $seccolor; ?>;box-shadow: 1200px 0 0 <?php echo $seccolor; ?> inset;}	
.rehub-sec-color{color: <?php echo $seccolor ?>}	
<?php if (REHUB_NAME_ACTIVE_THEME == 'REPICK'):?>
.rehub_chimp{background-color: <?php echo $seccolor; ?>;border-color: <?php echo $seccolor; ?>;}
<?php endif;?>

/**********BUTTON COLOR SCHEME*************/
<?php 
	$boxshadow = '';
	if (rehub_option('rehub_btnoffer_color')) {
		$btncolor = rehub_option('rehub_btnoffer_color');
	} 
	else {
		if (REHUB_NAME_ACTIVE_THEME == 'REPICK') {
			$btncolor = '#D7541A';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'RETHING') {
			$btncolor = '#B07C01';	
		}
		elseif (REHUB_NAME_ACTIVE_THEME == 'REWISE') {
			$btncolor = '#43c801';	
		}						
		else{
			$btncolor = '#fb7203';			
		}
	}
	if (REHUB_NAME_ACTIVE_THEME == 'REWISE'){
		$boxshadow = hex2rgba($btncolor, 0.25);
	}
?>
/*woo style btn*/
.woocommerce .summary .masked_coupon,
.woocommerce a.woo_loop_btn,
.woocommerce input.button.alt,
.woocommerce .checkout-button.button,
.woocommerce a.add_to_cart_button,
.woocommerce-page a.add_to_cart_button,
.woocommerce .single_add_to_cart_button,
.woocommerce div.product form.cart .button,
.priced_block .btn_offer_block, 
.rh-deal-compact-btn, 
input.mdf_button, 
#buddypress input[type="submit"], 
#buddypress input[type="button"], 
#buddypress input[type="reset"], 
#buddypress button.submit,
.ap-pro-form-field-wrapper input[type="submit"], 
.btn_block_part .btn_offer_block,
.wpsm-button.rehub_main_btn,
.wcv-grid a.button,
input.gmw-submit,
#ws-plugin--s2member-profile-submit 
{ background: none <?php echo $btncolor ?> !important; 
	color: #fff !important; 
	border:none !important;
	text-decoration: none !important; 
	outline: 0;  
	<?php if($boxshadow) :?>
		border-radius: 100px !important;
		box-shadow: -1px 6px 19px <?php echo $boxshadow;?> !important;
	<?php else:?>
		border-radius: 0 !important;
		box-shadow: 0 2px 2px #E7E7E7 !important;
	<?php endif; ?>
}

.woocommerce a.woo_loop_btn:hover,
.woocommerce input.button.alt:hover,
.woocommerce .checkout-button.button:hover,
.woocommerce a.add_to_cart_button:hover,
.woocommerce-page a.add_to_cart_button:hover,
.woocommerce a.single_add_to_cart_button:hover,
.woocommerce-page a.single_add_to_cart_button:hover,
.woocommerce div.product form.cart .button:hover,
.woocommerce-page div.product form.cart .button:hover,
.priced_block .btn_offer_block:hover, 
.wpsm-button.rehub_main_btn:hover, 
#buddypress input[type="submit"]:hover, 
#buddypress input[type="button"]:hover, 
#buddypress input[type="reset"]:hover, 
#buddypress button.submit:hover, 
.small_post .btn:hover,
.ap-pro-form-field-wrapper input[type="submit"]:hover,
.btn_block_part .btn_offer_block:hover,
.wcv-grid a.button:hover,
#ws-plugin--s2member-profile-submit:hover{ background: none <?php echo $btncolor ?> !important;color: #fff !important; opacity: 0.8; box-shadow: none !important; border-color: transparent;}

.woocommerce a.woo_loop_btn:active,
.woocommerce .button.alt:active,
.woocommerce .checkout-button.button:active,
.woocommerce a.add_to_cart_button:active,
.woocommerce-page a.add_to_cart_button:active,
.woocommerce a.single_add_to_cart_button:active,
.woocommerce-page a.single_add_to_cart_button:active,
.woocommerce div.product form.cart .button:active,
.woocommerce-page div.product form.cart .button:active, 
.wpsm-button.rehub_main_btn:active, 
#buddypress input[type="submit"]:active, 
#buddypress input[type="button"]:active, 
#buddypress input[type="reset"]:active, 
#buddypress button.submit:active,
.ap-pro-form-field-wrapper input[type="submit"]:active,
.btn_block_part .btn_offer_block:active,
.wcv-grid a.button:active,
#ws-plugin--s2member-profile-submit:active{ background: none <?php echo $btncolor ?> !important; box-shadow: none; top:2px;color: #fff !important;}

.re_thing_btn .rehub_offer_coupon.masked_coupon:after{border: 1px dashed <?php echo $btncolor ?>; border-left: none;}
.re_thing_btn.continue_thing_btn a, .re_thing_btn .rehub_offer_coupon.not_masked_coupon{color: <?php echo $btncolor ?> !important;}
.re_thing_btn a, .re_thing_btn .rehub_offer_coupon {background-color: <?php echo $btncolor ?>; border: 1px solid <?php echo $btncolor ?>;}
.main_slider .re_thing_btn a, .widget_merchant_list .buttons_col{background-color: <?php echo $btncolor ?> !important;}
.re_thing_btn .rehub_offer_coupon {border-style: dashed;}
<?php if(rehub_option('rehub_btnoffer_color_hover') !='') : ?>
	.re_thing_btn a:hover, .re_thing_btn.continue_thing_btn a:hover, .woocommerce .summary .masked_coupon.zeroclipboard-is-hover, .woocommerce a.woo_loop_btn:hover, .woocommerce input.button.alt:hover, .woocommerce .checkout-button.button:hover, .woocommerce a.add_to_cart_button:hover, .woocommerce a.single_add_to_cart_button:hover, .woocommerce div.product form.cart .button:hover{background-color:<?php echo rehub_option('rehub_btnoffer_color_hover') ?>; border: 1px solid <?php echo rehub_option('rehub_btnoffer_color_hover') ?>; color: #fff !important}
	.rehub_offer_coupon.zeroclipboard-is-hover{border: 1px dashed <?php echo rehub_option('rehub_btnoffer_color_hover') ?>; }
	.rehub_offer_coupon.zeroclipboard-is-hover i.fa{ color: <?php echo rehub_option('rehub_btnoffer_color_hover') ?>}
	.re_thing_btn .rehub_offer_coupon.not_masked_coupon.zeroclipboard-is-hover{color: <?php echo rehub_option('rehub_btnoffer_color_hover') ?> !important}
<?php else :?>
	.re_thing_btn a:hover, .re_thing_btn.continue_thing_btn a:hover{background-color:#CC940F; border: 1px solid #CC940F; color: #fff !important}
	.rehub_offer_coupon.zeroclipboard-is-hover{border: 1px dashed #CC940F; }
	.rehub_offer_coupon.zeroclipboard-is-hover i.fa{ color: #CC940F}
	.re_thing_btn .rehub_offer_coupon.not_masked_coupon.zeroclipboard-is-hover{color: #CC940F !important}
<?php endif; ?>
.deal_daywoo .price{color: <?php echo $btncolor ?>}


<?php if(rehub_option('enable_adsense_opt') =='1') : ?>
	@media screen and (min-width: 1100px) {
	.header-top, header .logo-section, nav.top_menu, .top_theme, .footer-bottom .container, .footer-bottom.block_foot, footer#theme_footer.block_foot, footer#theme_footer .container, .block_style #main_header, .block_style header .logo-section, #branded_img{ width: 1074px;}
	.separate_sidebar_bg .header-top, .separate_sidebar_bg header .logo-section, .separate_sidebar_bg nav.top_menu, .separate_sidebar_bg .top_theme, .separate_sidebar_bg .footer-bottom .container, .separate_sidebar_bg .footer-bottom.block_foot, .separate_sidebar_bg footer#theme_footer.block_foot, .separate_sidebar_bg footer#theme_footer .container, .separate_sidebar_bg.block_style #main_header, .separate_sidebar_bg.block_style header .logo-section, .separate_sidebar_bg #branded_img{width: 1044px}	
	.content { width: 1074px; padding: 15px}
	.content.no_shadow, .separate_sidebar_bg .content{width: 1074px}
	.content.no_shadow .vc_row.vc_rehub_container > .vc_col-sm-8{ width: 758px }
	.sidebar, .side-twocol{ width: 300px}
	.side-twocol .columns {height: 200px}
	.main_slider.flexslider .slides .slide{ height: 418px; line-height: 418px}
	.main_slider.flexslider{height: 418px}	
	.main-side, .gallery-pics, .main_slider.flexslider{width:728px;}
	.main_slider .flex-overlay h2{ font-size: 36px; line-height: 34px}
	.edd_downloads_list.edd_download_columns_1 .edd_download_inner > div.edd_download_text { text-align: left; width: 255px }
	.full_width .edd_downloads_list.edd_download_columns_1 .edd_download_inner > div.edd_download_text { width: 565px }
	.woo_offer_list .rehub_feat_block.table_view_block{padding: 30px 0;}
	.woo_offer_list{border-left:none; border-right: none;}
	.offer_grid .offer_thumb{ height: 130px}
	.offer_grid .offer_thumb img, .offer_grid figure img{max-height: 130px}
	.vc_row.vc_rehub_container > .vc_col-sm-8 {width: 728px;}
	.vc_row.vc_rehub_container > .vc_col-sm-4 {width: 300px;}
	.block_style header .logo { margin-left: 20px; max-width: 220px }
	header .logo { max-width: 300px;}
	.top_rating_block.list_style_rating .desc_col{ width: 500px}
	.with_sidebar_rating.top_rating_block.list_style_rating .desc_col { width: 240px; }
	.with_sidebar_rating.top_rating_block.list_style_rating .buttons_col{ width: 150px}		
	.rh_video_playlist_column_full .rh_container_video_playlist{ width: 320px !important}
  	.rh_video_playlist_column_full .rh_wrapper_player {width: calc(100% - 320px) !important;}
  	.woocommerce .full_width div.product div.images figure .rh_table_image{height: 300px}
  	.single_product_egg{border-bottom:none;}
	}
<?php endif; ?>	

<?php if(rehub_option('badge_color_1') !='') : ?>
	.re-starburst.badge_1, .re-starburst.badge_1 span, .re-line-badge.badge_1, .re-ribbon-badge.badge_1 span{background: <?php echo rehub_option('badge_color_1')?>;}
	.table_view_charts .top_chart_item.badge_1{border-top: 1px solid <?php echo rehub_option('badge_color_1')?>;}
	.re-line-badge.re-line-table-badge.badge_1:before{border-top-color: <?php echo rehub_option('badge_color_1')?>}
	.re-line-badge.re-line-table-badge.badge_1:after{border-bottom-color: <?php echo rehub_option('badge_color_1')?>}
<?php endif;?>
<?php if(rehub_option('badge_color_2') !='') : ?>
	.re-starburst.badge_2, .re-starburst.badge_2 span, .re-line-badge.badge_2, .re-ribbon-badge.badge_2 span{background: <?php echo rehub_option('badge_color_2')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_2, .table_view_charts .top_chart_item.ed_choice_col.badge_2 li:first-child:before, .table_view_charts .top_chart_item.ed_choice_col.badge_2 > ul > li:last-child:before{border-top: 1px solid <?php echo rehub_option('badge_color_2')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_2 > ul > li:last-child{border-bottom:1px solid <?php echo rehub_option('badge_color_2')?>;}
	.re-line-badge.re-line-table-badge.badge_2:before{border-top-color: <?php echo rehub_option('badge_color_2')?>}
	.re-line-badge.re-line-table-badge.badge_2:after{border-bottom-color: <?php echo rehub_option('badge_color_2')?>}
<?php endif;?>
<?php if(rehub_option('badge_color_3') !='') : ?>
	.re-starburst.badge_3, .re-starburst.badge_3 span, .re-line-badge.badge_3, .re-ribbon-badge.badge_3 span{background: <?php echo rehub_option('badge_color_3')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_3, .table_view_charts .top_chart_item.ed_choice_col.badge_3 li:first-child:before, .table_view_charts .top_chart_item.ed_choice_col.badge_3 > ul > li:last-child:before{border-top: 1px solid <?php echo rehub_option('badge_color_3')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_3 > ul > li:last-child{border-bottom:1px solid <?php echo rehub_option('badge_color_3')?>;}
	.re-line-badge.re-line-table-badge.badge_3:before{border-top-color: <?php echo rehub_option('badge_color_3')?>}
	.re-line-badge.re-line-table-badge.badge_3:after{border-bottom-color: <?php echo rehub_option('badge_color_3')?>}
<?php endif;?>
<?php if(rehub_option('badge_color_4') !='') : ?>
	.re-starburst.badge_4, .re-starburst.badge_4 span, .re-line-badge.badge_4, .re-ribbon-badge.badge_4 span{background: <?php echo rehub_option('badge_color_4')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_4, .table_view_charts .top_chart_item.ed_choice_col.badge_4 li:first-child:before, .table_view_charts .top_chart_item.ed_choice_col.badge_4 > ul > li:last-child:before{border-top: 1px solid <?php echo rehub_option('badge_color_4')?>;}
	.table_view_charts .top_chart_item.ed_choice_col.badge_4 > ul > li:last-child{border-bottom:1px solid <?php echo rehub_option('badge_color_4')?>;}
	.re-line-badge.re-line-table-badge.badge_4:before{border-top-color: <?php echo rehub_option('badge_color_4')?>}
	.re-line-badge.re-line-table-badge.badge_4:after{border-bottom-color: <?php echo rehub_option('badge_color_4')?>}
<?php endif;?>

<?php if (vp_metabox('rehub_framework_brand.rehub_background_image_single') && (is_single() || is_page())) :?>
	<?php $bg_url = vp_metabox('rehub_framework_brand.rehub_background_image_single')?>
	<?php $bg_repeat = vp_metabox('rehub_framework_brand.rehub_background_repeat_single')?>
	<?php $bg_position = vp_metabox('rehub_framework_brand.rehub_background_position_single'); if ($bg_position =='') {$bg_position ='left';}?>
	<?php $bg_offset = vp_metabox('rehub_framework_brand.rehub_background_offset_single'); if ($bg_offset =='') {$bg_offset ='0';}?>
	<?php $bg_fixed = vp_metabox('rehub_framework_brand.rehub_background_fixed_single')?>
	<?php $bg_color = vp_metabox('rehub_framework_brand.rehub_color_background_single')?>
	<?php $bg_sized = vp_metabox('rehub_framework_brand.rehub_background_sized_single')?>
	body{background-color: <?php echo $bg_color ?> ; background-image: url("<?php echo $bg_url; ?>"); background-repeat: <?php echo $bg_repeat; ?>; background-position: <?php echo $bg_position ?> <?php echo $bg_offset ?>px; <?php if($bg_fixed) : ?>background-attachment:fixed;<?php endif; ?> <?php if($bg_sized) : ?>background-size:cover;<?php endif; ?>}
<?php elseif (rehub_option('rehub_background_image') ) :?>
	<?php $bg_url = rehub_option('rehub_background_image');?>
	<?php $bg_repeat = rehub_option('rehub_background_repeat');?>
	<?php $bg_position = rehub_option('rehub_background_position');  if ($bg_position =='') {$bg_position ='left';}?>
	<?php $bg_offset = rehub_option('rehub_background_offset'); if ($bg_offset =='') {$bg_offset ='0';}?>
	<?php $bg_fixed = rehub_option('rehub_background_fixed')?>
	<?php $bg_color = rehub_option('rehub_color_background') ?>
	<?php $bg_sized = rehub_option('rehub_sized_background')?>
	body{background-color: <?php echo $bg_color ?> !important;background-image: url("<?php echo $bg_url; ?>") !important; background-repeat: <?php echo $bg_repeat; ?>; background-position: <?php echo $bg_position ?> <?php echo $bg_offset ?>px; <?php if($bg_fixed) : ?>background-attachment:fixed;<?php endif; ?> <?php if($bg_sized) : ?>background-size:cover;<?php endif; ?>}
<?php endif; ?>	
<?php if (vp_metabox('rehub_framework_brand.rehub_branded_bg_url_single') && (is_single() || is_page())) :?>
	<?php $bg_branded_url = vp_metabox('rehub_framework_brand.rehub_branded_background_image_single')?>
	#branded_bg {height: 100%;left: 0;position: fixed;top: 0;width: 100%;z-index: 0;}
	footer, .top_theme, .content, .footer-bottom, header { position: relative; z-index: 1 }
<?php elseif (rehub_option('rehub_branded_bg_url') ) :?>
	<?php $bg_branded_url = rehub_option('rehub_branded_background_image'); ?>
	#branded_bg {height: 100%;left: 0;position: fixed;top: 0;width: 100%;z-index: 0;}
	footer, .top_theme, .content, .footer-bottom, header { position: relative; z-index: 1 }
<?php endif; ?>
<?php if(rehub_option('rehub_branded_banner_image') || (vp_metabox('rehub_framework_brand.rehub_branded_banner_image_single') && (is_single() || is_page()))  ) : ?>
	.top_theme { display: none }
	header .main-nav { margin-bottom: 0 !important }
	.content.landing_page{ margin-top: 0 !important}
<?php endif; ?>	
<?php if(rehub_option('rehub_enable_fullwith_layout') ==1) : ?>
	@media (min-width:1560px){ 
		.header-top, header .logo-section, nav.top_menu, .top_theme, .footer-bottom .container, .footer-bottom.block_foot, footer#theme_footer.block_foot, footer#theme_footer .container, .block_style #main_header, .block_style header .logo-section, #branded_img, .content, .content.no_shadow, .separate_sidebar_bg .content{width:1530px;} 
		.sidebar, .side-twocol, .vc_row.vc_rehub_container > .vc_col-sm-4{ width: 336px} 
		.separate_sidebar_bg .content .vc_row.vc_rehub_container > .vc_col-sm-8, .separate_sidebar_bg .main-side:not(.full_width), .main-side, .gallery-pics, .main_slider.flexslider, .vc_row.vc_rehub_container > .vc_col-sm-8{width:1170px;} .centered-container .vc_col-sm-12 .wpb_wrapper, .vc_section .centered-container{max-width:1530px;} 
	}
<?php endif; ?>	
<?php if (REHUB_NAME_ACTIVE_THEME == 'REHUB' || REHUB_NAME_ACTIVE_THEME == 'RECASH') :?>
	@media(min-width: 1224px) {
		.single-post .full_width > article.post, single-product .full_width > article.post{padding: 32px}
		.title_single_area.full_width{margin: 25px 32px 0 32px;}	
		.main-side .title_single_area.full_width{margin: 0;}
		.full_width .wpsm-comptable td img{padding:5px}
	}
<?php endif; ?>	

</style>
<?php 
	$dynamic_css = ob_get_contents();
	ob_end_clean();
	if (function_exists('rehub_quick_minify')) {
		echo rehub_quick_minify($dynamic_css);
	}
	else {echo $dynamic_css;}
?>