<?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    <div class="cegg-maincol">
    <?php endif; ?>
    <div class="wrap">
        <h2><?php _e('Integration with Affiliate Egg', 'content-egg') ?></h2>
        <?php settings_errors(); ?>

        <p>
            <?php _e('You can activate parsers of <a href="http://www.keywordrush.com/en/affiliateegg">Affiliate Egg</a> as modules of Content Egg.', 'content-egg'); ?>
            <?php _e('For search by keyword, plugin will use search of original site.', 'content-egg'); ?>
        </p>

        <?php if (!ContentEgg\application\admin\AeIntegrationConfig::isAEIntegrationPosible()): ?>
            <p>
                <b><?php _e('For first step make next actions:', 'content-egg'); ?></b>
            <ul>
                <li><?php _e('Set and activate <a href="www.keywordrush.com/en/affiliateegg">Affiliate Egg</a>', 'content-egg'); ?></li>
                <li><?php _e('Version of Affiliate Egg must be great than', 'content-egg'); ?> <?php echo ContentEgg\application\admin\AeIntegrationConfig::MIN_AE_VERSION; ?>
                </li>
            </ul>
            </p>
        <?php else: ?>
            <form action="options.php" method="POST">
                <?php settings_fields($page_slug); ?>
                <table class="form-table">
                    <?php do_settings_fields($page_slug, 'default'); ?>
                </table>
                <?php submit_button(); ?>
            </form>   
        <?php endif; ?>
    </div>
    <?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    </div>    
    <?php include('_promo_box.php'); ?>
<?php endif; ?>          