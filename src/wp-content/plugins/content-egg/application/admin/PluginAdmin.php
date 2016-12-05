<?php

namespace ContentEgg\application\admin;

use ContentEgg\application\Plugin;
use ContentEgg\application\helpers\TextHelper;
use ContentEgg\application\admin\GeneralConfig;
use ContentEgg\application\components\ModuleManager;
use ContentEgg\application\components\ModuleApi;
use ContentEgg\application\components\FeaturedImage;

/**
 * PluginAdmin class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class PluginAdmin {

    protected static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;

        return self::$instance;
    }

    private function __construct()
    {
        if (!\is_admin())
            die('You are not authorized to perform the requested action.');

        \add_action('admin_menu', array($this, 'add_admin_menu'));
        \add_action('admin_enqueue_scripts', array($this, 'admin_load_scripts'));

        if (isset($GLOBALS['pagenow']) && $GLOBALS['pagenow'] == 'plugins.php')
        {
            \add_filter('plugin_row_meta', array($this, 'add_plugin_row_meta'), 10, 2);
        }
        if (Plugin::isFree() || (Plugin::isPro() && Plugin::isActivated()) || Plugin::isEnvato())
        {
            GeneralConfig::getInstance()->adminInit();
            new ImportExportController;
            ModuleManager::getInstance()->adminInit();
            AdminNotice::getInstance()->adminInit();
            new EggMetabox;
            new ModuleApi;
            new FeaturedImage;
            new PrefillController;
            new AutoblogController;
            AeIntegrationConfig::getInstance()->adminInit();
        }
        if (Plugin::isEnvato() && !Plugin::isActivated() && !\get_option(Plugin::slug . '_env_install'))
            EnvatoConfig::getInstance()->adminInit();
        elseif (Plugin::isPro())
            LicConfig::getInstance()->adminInit();
        if (Plugin::isPro() && Plugin::isActivated())
        {
            new \ContentEgg\application\Autoupdate(Plugin::version(), plugin_basename(\ContentEgg\PLUGIN_FILE), Plugin::getApiBase(), Plugin::slug);
        }
    }

    function admin_load_scripts()
    {
        if ($GLOBALS['pagenow'] != 'admin.php' || empty($_GET['page']))
            return;

        $page_pats = explode('-', $_GET['page']);

        if (count($page_pats) < 2 || $page_pats[0] . '-' . $page_pats[1] != 'content-egg')
            return;
        \wp_enqueue_script('content_egg_common', \ContentEgg\PLUGIN_RES . '/js/common.js', array('jquery'));
        \wp_localize_script('content_egg_common', 'contenteggL10n', array(
            'are_you_shure' => __('Вы уверены?', 'content-egg'),
            'sitelang' => GeneralConfig::getInstance()->option('lang'),
        ));

        //\wp_enqueue_style('egg-bootstrap', \ContentEgg\PLUGIN_RES . '/bootstrap/css/egg-bootstrap.css');
        \wp_enqueue_style('contentegg-admin', \ContentEgg\PLUGIN_RES . '/css/admin.css');
    }

    public function add_plugin_row_meta(array $links, $file)
    {
        if ($file == plugin_basename(\ContentEgg\PLUGIN_FILE) && (Plugin::isActivated() || Plugin::isFree()))
        {
            return array_merge(
                    $links, array(
                '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=content-egg">' . __('Настройки', 'content-egg') . '</a>',
                    )
            );
        }
        return $links;
    }

    public function add_admin_menu()
    {
        \add_menu_page('Content Egg', 'Content Egg', 'publish_posts', Plugin::slug, null, 'dashicons-screenoptions');
    }

    public static function render($view_name, $_data = null)
    {
        if (is_array($_data))
            extract($_data, EXTR_PREFIX_SAME, 'data');
        else
            $data = $_data;

        include \ContentEgg\PLUGIN_PATH . 'application/admin/views/' . TextHelper::clear($view_name) . '.php';
    }

}
