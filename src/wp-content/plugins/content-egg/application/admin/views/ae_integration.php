<?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    <div class="cegg-maincol">
    <?php endif; ?>
    <div class="wrap">
        <h2><?php _e('Интеграция с Affiliate Egg плагин', 'content-egg') ?></h2>
        <?php settings_errors(); ?>

        <p>
            <?php _e('Вы можете подключить веб-парсеры <a href="http://www.keywordrush.com/affiliateegg">Affiliate Egg плагина</a> в качестве модулей Content Egg.', 'content-egg'); ?>
            <?php _e('Для поиска по ключевому слову будет использоваться "родной" поиск на сайте магазина.', 'content-egg'); ?>
        </p>

        <?php if (!ContentEgg\application\admin\AeIntegrationConfig::isAEIntegrationPosible()): ?>
            <p>
                <b><?php _e('Для начала работы выполните следующие действия:', 'content-egg'); ?></b>
            <ul>
                <li><?php _e('Установите и активируйте <a href="http://www.keywordrush.com/affiliateegg">Affiliate Egg плагин</a>', 'content-egg'); ?></li>
                <li><?php _e('Версия Affiliate Egg должна быть не ниже', 'content-egg'); ?> <?php echo ContentEgg\application\admin\AeIntegrationConfig::MIN_AE_VERSION; ?>
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