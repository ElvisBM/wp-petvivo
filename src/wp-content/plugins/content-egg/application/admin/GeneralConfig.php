<?php

namespace ContentEgg\application\admin;

use ContentEgg\application\components\Config;
use ContentEgg\application\Plugin;
use ContentEgg\application\admin\PluginAdmin;
use ContentEgg\application\models\PriceAlertModel;

/**
 * GeneralSettings class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class GeneralConfig extends Config {

    public function page_slug()
    {
        return Plugin::slug() . '';
    }

    public function option_name()
    {
        return 'contentegg_options';
    }

    public function add_admin_menu()
    {
        \add_submenu_page(Plugin::slug, __('Settings', 'content-egg') . ' &lsaquo; Content Egg', __('Settings', 'content-egg'), 'manage_options', $this->page_slug, array($this, 'settings_page'));
    }

    public static function langs()
    {
        return array(
            'ar' => 'Arabic',
            'bg' => 'Bulgarian',
            'ca' => 'Catalan',
            //'zh_CN' => 'Chinese (simplified)',
            //'zh_TW' => 'Chinese (traditional)',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'nl' => 'Dutch',
            'en' => 'English',
            'et' => 'Estonian',
            'tl' => 'Filipino',
            'fi' => 'Finnish',
            'fr' => 'French',
            'de' => 'German',
            'el' => 'Greek',
            'iw' => 'Hebrew',
            'hi' => 'Hindi',
            'hu' => 'Hungarian',
            'is' => 'Icelandic',
            'id' => 'Indonesian',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'ko' => 'Korean',
            'lv' => 'Latvian',
            'lt' => 'Lithuanian',
            'ms' => 'Malay',
            'no' => 'Norwegian',
            'fa' => 'Persian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'ro' => 'Romanian',
            'ru' => 'Russian',
            'sr' => 'Serbian',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'es' => 'Spanish',
            'sv' => 'Swedish',
            'th' => 'Thai',
            'tr' => 'Turkish',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'vi' => 'Vietnamese',
        );
    }

    protected function options()
    {

        $post_types = get_post_types(array('public' => true), 'names');
        if (isset($post_types['attachment']))
            unset($post_types['attachment']);

        $total_price_alerts = PriceAlertModel::model()->count('status = ' . PriceAlertModel::STATUS_ACTIVE);
        $sent_price_alerts = PriceAlertModel::model()->count('status = ' . PriceAlertModel::STATUS_DELETED
                . ' AND TIMESTAMPDIFF( DAY, complet_date, "' . \current_time('mysql') . '") <= ' . PriceAlertModel::CLEAN_DELETED_DAYS);

        return array(
            'lang' => array(
                'title' => __('Website language', 'content-egg'),
                'description' => __('Modules, which have Multilanguage support, will have priority for this language. Also, this setting will point on language of output templates', 'content-egg'),
                'dropdown_options' => self::langs(),
                'callback' => array($this, 'render_dropdown'),
                'default' => self::getDefaultLang(),
                'section' => 'default',
            ),
            'post_types' => array(
                'title' => 'Post Types',
                'description' => __('What post types do you want to use for Content Egg?', 'content-egg') . ' ' .
                __('This setting also shows post types for Autofill extension', 'content-egg'),
                'checkbox_options' => $post_types,
                'callback' => array($this, 'render_checkbox_list'),
                'default' => array('post', 'page'),
                'section' => 'default',
            ),
            'filter_bots' => array(
                'title' => __('Filter bots', 'content-egg'),
                'description' => __('Bots can\'t activate parsers.', 'content-egg') .
                '<p class="description">' . __('Updating price and keyword updating is made with page opening. If we determine update by useragent, and page is opened by one of known bots, no parsers will work in this case.', 'content-egg') . '</p>',
                'checkbox_options' => $post_types,
                'callback' => array($this, 'render_checkbox'),
                'default' => true,
                'section' => 'default',
            ),
            'price_history_days' => array(
                'title' => __('Price history', 'content-egg'),
                'description' => __('How long save price history. 0 - deactivate price history.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 180,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 365,
                        'message' => sprintf(__('The field "%s" can\'t be more than %d.', 'content-egg'), __('Price history', 'content-egg'), 362),
                    ),
                ),
            ),
            'price_alert_enabled' => array(
                'title' => 'Price alert',
                'description' => __('Allow members to subscribe for price drop alert on email.', 'content-egg') .
                '<p class="description">' . sprintf(__('Active subscriptions now: <b>%d</b>', 'content-egg'), $total_price_alerts) .
                '. ' . sprintf(__('Messages are sent for last %d days: <b>%d</b>', 'content-egg'), PriceAlertModel::CLEAN_DELETED_DAYS, $sent_price_alerts) . '.</p>' .
                '<p class="description">' . __('This option requires "Price history" option (must be enabled) to work.', 'content-egg') . '</p>',
                'callback' => array($this, 'render_checkbox'),
                'default' => true,
                'section' => 'default',
            ),
            'button_color' => array(
                'title' => __('Button color', 'content-egg'),
                'description' => __('Button color for standard templates.', 'content-egg'),
                'callback' => array($this, 'render_color_picker'),
                'default' => '#5cb85c',
                'validator' => array(
                    'trim',
                ),
            ),            
        );
        
    }

    public static function getDefaultLang()
    {
        $locale = \get_locale();
        $lang = explode('_', $locale);
        if (array_key_exists($lang[0], self::langs()))
            return $lang[0];
        else
            return 'en';
    }

    public function settings_page()
    {
        PluginAdmin::render('settings', array('page_slug' => $this->page_slug()));
    }

}
