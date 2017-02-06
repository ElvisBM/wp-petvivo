<?php

namespace ContentEgg\application\helpers;

use ContentEgg\application\components\ContentManager;
use ContentEgg\application\models\PriceHistoryModel;
use ContentEgg\application\helpers\ArrayHelper;

/**
 * TemplateHelper class file
 * 
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 * 
 */
class TemplateHelper {

    const MERHANT_LOGO_DIR = 'ce-logos';

    public static function formatPriceCurrency($price, $currencyCode, $before_symbol = '', $after_symbol = '')
    {
        $decimal_sep = __('number_format_decimal_point', 'content-egg-tpl');
        $thousand_sep = __('number_format_thousands_sep', 'content-egg-tpl');
        if ($decimal_sep == 'number_format_decimal_point')
            $decimal_sep = null;
        if ($thousand_sep == 'number_format_thousands_sep')
            $thousand_sep = null;

        return CurrencyHelper::getInstance()->currencyFormat($price, $currencyCode, $thousand_sep, $decimal_sep, $before_symbol, $after_symbol);
    }

    public static function currencyTyping($c)
    {
        return CurrencyHelper::getInstance()->getSymbol($c);
    }

    /*
     * @deprecated
     */

    public static function number_format_i18n($number, $decimals = 0, $currency = null)
    {
        $decimal_sep = __('number_format_decimal_point', 'content-egg-tpl');
        $thousand_sep = __('number_format_thousands_sep', 'content-egg-tpl');
        if ($decimal_sep == 'number_format_decimal_point')
            $decimal_sep = null;
        if ($thousand_sep == 'number_format_thousands_sep')
            $thousand_sep = null;
        return CurrencyHelper::getInstance()->numberFormat($number, $currency, $thousand_sep, $decimal_sep, $decimals);
    }

    /*
     * @deprecated
     */

    public static function price_format_i18n($number, $currency = null)
    {
        return self::number_format_i18n($number, $decimal = null, $currency);
    }

    public static function truncate($string, $length = 80, $etc = '...', $charset = 'UTF-8', $break_words = false, $middle = false)
    {
        if ($length == 0)
            return '';

        if (mb_strlen($string, 'UTF-8') > $length)
        {
            $length -= min($length, mb_strlen($etc, 'UTF-8'));
            if (!$break_words && !$middle)
            {
                $string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $length + 1, $charset));
            }
            if (!$middle)
            {
                return mb_substr($string, 0, $length, $charset) . $etc;
            } else
            {
                return mb_substr($string, 0, $length / 2, $charset) . $etc . mb_substr($string, -$length / 2, $charset);
            }
        } else
        {
            return $string;
        }
    }

    /**
     * Возвращает количтсво дней, секунд и минут с текущего момента
     * до окончания события
     * @param string $end_time_gmt GNU формат даты
     * @param bool $return_array вернуть в виде массива или форматированной строки?
     * @return mixed false - если $timeleft < 0, массив или строку
     */
    static public function getTimeLeft($end_time_gmt, $return_array = false)
    {

        $current_time = strtotime(gmdate("M d Y H:i:s"));
        $timeleft = strtotime($end_time_gmt) - $current_time;
        if ($timeleft < 0)
            return '';

        $days_left = floor($timeleft / 86400);
        $hours_left = floor(($timeleft - $days_left * 86400) / 3600);
        $min_left = floor(($timeleft - $days_left * 86400 - $hours_left * 3600) / 60);
        // Если нужно вернуть в виде массива
        if ($return_array)
        {
            return array(
                'days' => $days_left,
                'hours' => $hours_left,
                'min' => $min_left,
            );
        }

        if ($days_left)
            return $days_left . __('d', 'content-egg-tpl') . ' ';
        elseif ($hours_left)
            return $hours_left . __('h', 'content-egg-tpl') . ' ';
        elseif ($min_left)
            return $min_left . __('m', 'content-egg-tpl');
        else
            return '<1' . __('m', 'content-egg-tpl');
    }

    public static function filterData($data, $field_name, $field_values, $extra = false, $inverse = false)
    {
        $results = array();
        foreach ($data as $key => $d)
        {
            if ($extra)
            {
                if (!isset($d['extra']) || !isset($d['extra'][$field_name]))
                    continue;
                $value = $d['extra'][$field_name];
            } else
            {
                if (!isset($d[$field_name]))
                    continue;
                $value = $d[$field_name];
            }
            if (!is_array($field_values))
                $field_values = array($field_values);

            if (!$inverse && in_array($value, $field_values))
                $results[$key] = $d;
            elseif ($inverse && !in_array($value, $field_values))
                $results[$key] = $d;
        }
        return $results;
    }

    public static function formatDatetime($datetime, $type = 'mysql', $separator = ' ')
    {
        if ('mysql' == $type)
        {
            return mysql2date(get_option('date_format'), $datetime) . $separator . mysql2date(get_option('time_format'), $datetime);
        } else
        {
            return date_i18n(get_option('date_format'), $datetime) . $separator . date_i18n(get_option('time_format'), $datetime);
        }
    }

    public static function splitAttributeName($attribute)
    {
        return trim(preg_replace('/([A-Z])/', ' $1', $attribute));
    }

    public static function getAmazonLink(array $itemLinks, $description)
    {
        foreach ($itemLinks as $link)
        {
            if ($link['Description'] == $description)
                return $link['URL'];
        }
        return false;
    }

    public static function getLastUpdate($module_id, $post_id = null)
    {
        if (!$post_id)
        {
            global $post;
            $post_id = $post->ID;
        }
        return \get_post_meta($post_id, ContentManager::META_PREFIX_LAST_ITEMS_UPDATE . $module_id, true);
    }

    public static function getLastUpdateFormatted($module_id, $timezone = true, $post_id = null, $time = true)
    {
        if (!$post_id)
        {
            global $post;
            $post_id = $post->ID;
        }

        $format = \get_option('date_format');
        if ($time)
            $format .= ' ' . \get_option('time_format');
        if ($timezone)
            $format .= ' T';
        // local time
        return get_date_from_gmt(date('Y-m-d H:i:s', self::getLastUpdate($module_id, $post_id)), $format);
    }

    public static function filterDataByType($data, $type)
    {
        $results = array();
        foreach ($data as $module_id => $items)
        {
            $module = \ContentEgg\application\components\ModuleManager::getInstance()->factory($module_id);
            if ($module->getParserType() == $type)
                $results[$module_id] = $items;
        }
        return $results;
    }

    public static function filterDataByModule($data, $module_ids)
    {
        if (!is_array($module_ids))
            $module_ids = array($module_ids);
        $results = array();

        foreach ($data as $module_id => $items)
        {
            if (in_array($module_id, $module_ids))
                $results[$module_id] = $items;
        }
        return $results;
    }

    public static function priceHistoryPrices($unique_id, $plugin_id, $limit = 5)
    {
        $prices = PriceHistoryModel::model()->getLastPrices($unique_id, $plugin_id, $limit);
        $results = array();
        foreach ($prices as $price)
        {
            $results[] = array(
                'date' => strtotime($price['create_date']),
                'price' => $price['price'],
            );
        }
        return $results;
    }

    public static function priceHistoryMax($unique_id, $module_id)
    {
        if (!$price = PriceHistoryModel::model()->getMaxPrice($unique_id, $module_id))
            return null;
        return array('price' => $price['price'], 'date' => strtotime($price['create_date']));
    }

    public static function priceHistoryMin($unique_id, $module_id)
    {
        if (!$price = PriceHistoryModel::model()->getMinPrice($unique_id, $module_id))
            return null;
        return array('price' => $price['price'], 'date' => strtotime($price['create_date']));
    }

    public static function priceHistorySinceDate($unique_id, $module_id)
    {
        if (!$date = PriceHistoryModel::model()->getFirstDateValue($unique_id, $module_id))
            return null;
        return strtotime($date);
    }

    public static function priceChangesProducts($limit = 5)
    {
        $params = array(
            //'select' => 'DISTINCT unique_id',
            'order' => 'create_date DESC',
            'where' => 'post_id IS NOT NULL',
            'group' => 'unique_id',
            'limit' => $limit,
        );
        $prices = PriceHistoryModel::model()->findAll($params);
        $products = array();
        // find products
        foreach ($prices as $price)
        {
            if ($prod = ContentManager::getProductbyUniqueId($price['unique_id'], $price['module_id'], $price['post_id']))
                $products[] = $prod;
        }
        return $products;
    }

    public static function priceHistoryMorrisChart($unique_id, $module_id, $days = 180, array $options = array(), $htmlOptions = array())
    {
        $where = PriceHistoryModel::model()->prepareWhere(
                (array('unique_id = %s AND module_id = %s', array($unique_id, $module_id))), false);
        $params = array(
            'select' => 'date(create_date) as date, price as price',
            'where' => $where . ' AND TIMESTAMPDIFF( DAY, create_date, "' . current_time('mysql') . '") <= ' . $days,
            'group' => 'date',
            'order' => 'date DESC'
        );
        $prices = PriceHistoryModel::model()->findAll($params);

        $data = array(
            'chartType' => 'Area',
            'data' => $prices,
            'xkey' => 'date',
            'ykeys' => array('price'),
            'labels' => array(__('Price', 'content-egg-tpl')),
        );
        $options = array_merge($data, $options);
        $id = $module_id . '-' . $unique_id . '-chart';
        self::viewMorrisChart($id, $options, $htmlOptions);
    }

    public static function viewMorrisChart($id, array $options, $htmlOptions = array('style' => 'height: 250px;'))
    {
        // morris.js
        \wp_enqueue_style('morrisjs');
        \wp_enqueue_script('morrisjs');

        if (!empty($options['chartType']) && in_array($options['chartType'], array('Line', 'Area', 'Donut', 'Bar')))
        {
            $chartType = $options['chartType'];
            unset($options['chartType']);
        } else
            $chartType = 'Line';
        $options['element'] = $id;

        $html_attr = '';
        foreach ($htmlOptions as $name => $value)
        {
            $html_attr .= ' ' . esc_attr($name) . '="' . esc_attr($value) . '"';
        }

        echo '<div id="' . esc_attr($id) . '"' . $html_attr . '></div>
        <script>
        jQuery(document).ready(function($) {
            new Morris.' . $chartType . '(' . json_encode($options) . ');
                });
        </script>';
    }

    public static function isPriceAlertAllowed($unique_id = null, $module_id = null)
    {
        return \ContentEgg\application\PriceAlert::isPriceAlertAllowed($unique_id, $module_id);
    }

    public static function getCurrencyPos($currency)
    {
        return CurrencyHelper::getInstance()->getCurrencyPos($currency);
    }

    public static function getCurrencySymbol($currency)
    {
        return CurrencyHelper::getInstance()->getSymbol($currency);
    }

    public static function getCurrencyName($currency)
    {
        return CurrencyHelper::getInstance()->getName($currency);
    }

    private static function getMerchantImageUrl(array $item, $prefix = '', $remote_url = null, $blank_on_error = false)
    {
        $default_ext = 'png'; // ???

        if (!empty($item['domain']))
            $logo_file_name = $item['domain'];
        elseif (!empty($item['logo']))
            $logo_file_name = md5($item['logo']);
        else
            return $blank_on_error ? self::getBlankImg() : false;

        $logo_file_name = str_replace('.', '-', $logo_file_name);
        $logo_file_name .= '.' . $default_ext;
        $logo_file_name = $prefix . $logo_file_name;

        // check in distrib
        if (file_exists(\ContentEgg\PLUGIN_PATH . 'res/logos/' . $logo_file_name))
            return \ContentEgg\PLUGIN_RES . '/logos/' . $logo_file_name;

        $uploads = \wp_upload_dir();
        if (!$logo_dir = self::getMerchantLogoDir())
            return $blank_on_error ? self::getBlankImg() : false;
        $logo_file = \trailingslashit($logo_dir) . $logo_file_name;
        $logo_url = $uploads['baseurl'] . '/' . self::MERHANT_LOGO_DIR . '/' . $logo_file_name;

        // logo exists
        if (file_exists($logo_file))
            return $logo_url;

        // download
        if (!$remote_url)
            return $blank_on_error ? self::getBlankImg() : false;
        if ($logo_file_name = ImageHelper::downloadImg($remote_url, $logo_dir, $logo_file_name, '', true))
            return $uploads['baseurl'] . '/' . self::MERHANT_LOGO_DIR . '/' . $logo_file_name;
        else
        {
            // save blank to prevent new requests           
            copy(\ContentEgg\PLUGIN_PATH . 'res/img/blank.gif', $logo_file);
            return $blank_on_error ? self::getBlankImg() : false;
        }
    }

    public static function getMerhantLogoUrl(array $item, $blank_on_error = false)
    {
        $prefix = '';
        if (!empty($item['logo']))
            $remote_url = $item['logo'];
        elseif (!empty($item['domain']))
            $remote_url = 'https://logo.clearbit.com/' . urlencode($item['domain']) . '?size=128';
        else
            $remote_url = '';
        return self::getMerchantImageUrl($item, $prefix, $remote_url, $blank_on_error);
    }

    public static function getMerhantIconUrl(array $item, $blank_on_error = false)
    {
        $prefix = 'icon_';
        if (empty($item['domain']))
            return $blank_on_error ? self::getBlankImg() : false;
        $remote_url = 'http://www.google.com/s2/favicons?domain=' . urlencode($item['domain']);
        return self::getMerchantImageUrl($item, $prefix, $remote_url, $blank_on_error);
    }

    public static function getMerchantLogoDir()
    {
        $uploads = \wp_upload_dir();
        $logo_dir = \trailingslashit($uploads['basedir']) . self::MERHANT_LOGO_DIR;
        if (is_dir($logo_dir))
            return $logo_dir;

        // create
        if (\wp_mkdir_p($logo_dir))
            return $logo_dir;
        else
            return false;
    }

    public static function getBlankImg()
    {
        return \ContentEgg\PLUGIN_RES . '/img/blank.gif';
    }

    public static function mergeData(array $data)
    {
        foreach ($data as $module_id => $items)
        {
            foreach ($items as $item_ar)
            {
                $item_ar['module_id'] = $module_id;
                $all_items[] = $item_ar;
            }
        }
        return $all_items;
    }

    public static function getMaxPriceItem(array $data)
    {
        return $data[ArrayHelper::getMaxKeyAssoc($data, 'price')];
    }

    public static function getMinPriceItem(array $data)
    {
        return $data[ArrayHelper::getMinKeyAssoc($data, 'price')];
    }

    public static function getCommonCurrencyCode($data)
    {
        $first = reset($data);
        $currency = $first['currencyCode'];
        foreach ($data as $d)
        {
            if (!empty($d['currencyCode']) && $d['currencyCode'] != $currency)
                return false;
        }
        return $currency;
    }

    public static function getShopsList($data)
    {
        $list = array();
        foreach ($data as $d)
        {
            if (!isset($list[$d['domain']]))
            {
                $parts = explode('.', $d['domain']);
                $list[$d['domain']] = ucfirst($parts[0]);
            }
        }
        return $list;
    }


}
