<?php
/*
 * Некоторые иконы Yusuke Kamiyamane. Доступно по лицензии Creative Commons Attribution 3.0.
 * @link: http://p.yusukekamiyamane.com
 */
?>

<?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    <div class="cegg-maincol">
    <?php endif; ?>
    <div class="wrap">
        <h2>
            <?php _e('Content Egg Settings', 'content-egg'); ?>
            <?php if (\ContentEgg\application\Plugin::isPro()): ?>
                <span class="cegg-pro-label">pro</span>
            <?php endif; ?>
        </h2>

        <?php $modules = \ContentEgg\application\components\ModuleManager::getInstance()->getConfigurableModules(); ?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=content-egg" 
               class="nav-tab<?php if (!empty($_GET['page']) && $_GET['page'] == 'content-egg') echo ' nav-tab-active'; ?>">
                   <?php _e('General settings', 'content-egg'); ?>
            </a>
            <?php foreach ($modules as $module): ?>
                <?php $config = $module->getConfigInstance(); ?>
                <a href="?page=<?php echo esc_attr($config->page_slug()); ?>" 
                   class="nav-tab<?php if (!empty($_GET['page']) && $_GET['page'] == $config->page_slug()) echo ' nav-tab-active'; ?>">
                    <img src="<?php echo ContentEgg\PLUGIN_RES; ?>/img/status-<?php echo $module->isActive() ? 'active' : 'inactive' ?>.png" />
                    <?php echo esc_html($module->getName()); ?>                    
                    <?php if($module->isNew()): ?><img src="<?php echo ContentEgg\PLUGIN_RES; ?>/img/new.png" alt="New" title="New" /><?php endif; ?>                    
                </a>
            <?php endforeach; ?>
        </h2> 

        <div class="ui-sortable meta-box-sortables">
            <div class="postbox1">
                <div class="inside">

                    <div class="cegg-wrap">

                        <div class="cegg-maincol">

                            <h3>
                                <?php
                                if (!empty($_GET['page']) && $_GET['page'] == 'content-egg')
                                    _e('General settings', 'content-egg');
                                else
                                    echo esc_html($header);
                                ?>                
                            </h3>

                            <?php settings_errors(); ?>    
                            <form action="options.php" method="POST">
                                <?php settings_fields($page_slug); ?>
                                <table class="form-table">
                                    <?php do_settings_fields($page_slug, 'default'); ?>
                                </table>        
                                <?php submit_button(); ?>
                            </form>

                        </div>

                        <div class="cegg-rightcol">
                            <div>
                                <?php
                                if (!empty($description))
                                    echo '<p>' . $description . '</p>';

                                if (!empty($api_agreement))
                                    echo '<div style="text-align: right;"><small><a href="' . $api_agreement . '" target="_blank">' . __('Conditions', 'content-egg') . '</a></small></div>';
                                ?>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>   
    </div>


    <?php if (\ContentEgg\application\Plugin::isFree() || \ContentEgg\application\Plugin::isInactiveEnvato()): ?>
    </div>    
    <?php include('_promo_box.php'); ?>
<?php endif; ?>