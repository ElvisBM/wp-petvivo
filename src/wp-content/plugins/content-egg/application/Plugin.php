<?php

namespace ContentEgg\application;

use ContentEgg\application\admin\GeneralConfig;
use ContentEgg\application\helpers\CurrencyHelper;

/**
 * Plugin class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class Plugin {

    const version = '2.9.1';
    const db_version = 24;
    const wp_requires = '4.2.2';
    const slug = 'content-egg';
    const api_base = 'http://www.keywordrush.com/api/v1';
    const api_base2 = 'http://209.59.164.45/api/v1';
    const product_id = 302;

    private static $instance = null;
    private static $is_pro = null;
    private static $is_envato = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;

        return self::$instance;
    }

    private function __construct()
    {
        $this->loadTextdomain();
        if (self::isFree() || (self::isPro() && self::isActivated()) || self::isEnvato())
        {
            if (!\is_admin())
            {
                \add_action('wp_enqueue_scripts', array($this, 'registerScripts'));
                EggShortcode::getInstance();
                BlockShortcode::getInstance();
                ModuleViewer::getInstance()->init();
                ModuleUpdateVisit::getInstance()->init();
                LocalRedirect::initAction();
                CurrencyHelper::getInstance(GeneralConfig::getInstance()->option('lang'));
            }
            PriceAlert::getInstance()->init();
            AutoblogScheduler::initAction();
        }
    }

    public function registerScripts()
    {
        \wp_register_style('egg-bootstrap', \ContentEgg\PLUGIN_RES . '/bootstrap/css/egg-bootstrap.css');
        \wp_register_script('bootstrap', \ContentEgg\PLUGIN_RES . '/bootstrap/js/bootstrap.min.js', array('jquery'), null, false);
        \wp_register_style('content-egg-products', \ContentEgg\PLUGIN_RES . '/css/products.css');
        \wp_register_script('raphaeljs', \ContentEgg\PLUGIN_RES . '/js/morris.js/raphael.min.js', array('jquery'));
        \wp_register_script('morrisjs', \ContentEgg\PLUGIN_RES . '/js/morris.js/morris.min.js', array('raphaeljs'));
        \wp_register_style('morrisjs', \ContentEgg\PLUGIN_RES . '/js/morris.js/morris.min.css');
    }

    static public function version()
    {
        return self::version;
    }

    static public function slug()
    {
        return self::slug;
    }

    public static function getApiBase()
    {
        return self::api_base;
    }

    public static function isFree()
    {
        return !self::isPro();
    }

    public static function isPro()
    {
        if (self::$is_pro === null)
        {
            if (class_exists("\\ContentEgg\\application\\Autoupdate", true))
                self::$is_pro = true;
            else
                self::$is_pro = false;
        }
        return self::$is_pro;
    }

    public static function isEnvato()
    {
        if (self::$is_envato === null)
        {
            if (class_exists("\\ContentEgg\\application\\admin\\EnvatoConfig", true) || \get_option(Plugin::slug . '_env_install'))
                self::$is_envato = true;
            else
                self::$is_envato = false;
        }
        return self::$is_envato;
    }

    public static function isActivated()
    {
        if (self::isPro() && \ContentEgg\application\admin\LicConfig::getInstance()->option('license_key'))
            return true;
        else
            return false;
    }

    public static function isInactiveEnvato()
    {
        if (self::isEnvato() && !self::isActivated())
            return true;
        else
            return false;
    }

    public static function apiRequest($params = array())
    {
        $api_urls = array(self::api_base, self::api_base2);
        foreach ($api_urls as $api_url)
        {
            $response = \wp_remote_post($api_url, $params);
            if (\is_wp_error($response))
                continue; // try alternative api uri

            $response_code = (int) \wp_remote_retrieve_response_code($response);
            if ($response_code == 200)
                return $response;
            else
                return false;
        }
        return false;
    }

    private function loadTextdomain()
    {
        // plugin backend
        $locale = \get_locale();
        $mo_file = \ContentEgg\PLUGIN_PATH . 'languages/content-egg-' . $locale . '.mo';
        if (file_exists($mo_file) && is_readable($mo_file))
            \load_textdomain('content-egg', $mo_file);
        elseif (!in_array($locale, array('ru_RU', 'uk')))
            \load_textdomain('content-egg', \ContentEgg\PLUGIN_PATH . 'languages/content-egg-en_US.mo');

        // frontend templates
        $lang = GeneralConfig::getInstance()->option('lang');
        $lang = strtoupper($lang);
        $mo_file = \ContentEgg\PLUGIN_PATH . 'languages/tpl/content-egg-tpl-' . $lang . '.mo';
        if (file_exists($mo_file) && is_readable($mo_file))
            $v = \load_textdomain('content-egg-tpl', $mo_file);
    }

}
