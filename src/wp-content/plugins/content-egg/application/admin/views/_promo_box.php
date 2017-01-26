<div class="cegg-rightcol">
    <?php if (\ContentEgg\application\Plugin::isFree()): ?>
        <div class="cegg-box" style="margin-top: 95px;">
            <h2><?php _e('Maximum profit with minimum efforts', 'content-egg'); ?></h2>

            <a href="<?php echo ContentEgg\application\Plugin::pluginSiteUrl(); ?>">
                <img src="<?php echo ContentEgg\PLUGIN_RES; ?>/img/ce_pro_header.png" class="cegg-imgcenter" />        
            </a>
            <a href="<?php echo ContentEgg\application\Plugin::pluginSiteUrl(); ?>">
                <img src="<?php echo ContentEgg\PLUGIN_RES; ?>/img/ce_pro_coupon.png" class="cegg-imgcenter" />
            </a>
            <h4><?php _e('Many additional modules and extended functions.', 'content-egg'); ?></h4>

            <?php /*
              <h3><?php _e('Монетизация:', 'content-egg'); ?></h3>
              <ul>
              <li>Aliexpress</li>
              <?php if (\ContentEgg\application\admin\GeneralConfig::getInstance()->option('lang') == 'ru'): ?>
              <li>Где Слон</li>
              <li>Cityads</li>
              <li>Ozon.ru</li>
              <?php endif; ?>
              <li>eBay</li>
              <li>CJ Products</li>
              <li>Affilinet</li>
              <li>Linkshare</li>
              <li>Shareasale</li>
              <li>Zanox</li>
              <li>ClickBank</li>
              <li>...</li>
              </ul>

              <h3><?php _e('Контент модули:', 'content-egg'); ?></h3>
              <ul>
              <li><?php _e('Bing картинки', 'content-egg'); ?></li>
              <li><?php _e('Flickr фотографии', 'content-egg'); ?></li>
              <li><?php _e('Google книги', 'content-egg'); ?></li>
              <li><?php _e('Google новости', 'content-egg'); ?></li>
              <li><?php _e('Яндекс.Маркет', 'content-egg'); ?></li>
              <li>Twitter</li>
              <li><?php _e('ВКонтакте новости', 'content-egg'); ?></li>
              <li>...</li>
              </ul>
             * 
             */
            ?>
            <p>
                <a target="_blank" class="button-cegg-banner" href="<?php echo ContentEgg\application\Plugin::pluginSiteUrl(); ?>">Get it now!</a>
            </p>
        </div>
    <?php endif; ?>
    <?php if (\ContentEgg\application\Plugin::isEnvato()): ?>
        <div class="cegg-box" style="margin-top: 95px;">
            <h2><?php _e('Activate plugin', 'content-egg'); ?></h2>
            <p><?php _e('Activate plugin, to get urgent important updates of plugin inside admin panel and official support. ', 'content-egg'); ?></p>

            <p>
                <a class="button-cegg-banner" href="<?php echo get_admin_url(\get_current_blog_id(), 'admin.php?page=content-egg-lic'); ?>"><?php _e('Go to ', 'content-egg'); ?></a>
            </p>


        </div>
    <?php endif; ?>
</div>
