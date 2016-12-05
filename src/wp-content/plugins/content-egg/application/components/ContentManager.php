<?php

namespace ContentEgg\application\components;

use ContentEgg\application\helpers\ImageHelper;
use ContentEgg\application\helpers\ArrayHelper;
use ContentEgg\application\LocalRedirect;
use ContentEgg\application\admin\GeneralConfig;
use ContentEgg\application\models\PriceHistoryModel;
use ContentEgg\application\PriceAlert;

/**
 * ContentManager class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class ContentManager {

    const META_PREFIX_DATA = '_cegg_data_';
    const META_PREFIX_LAST_ITEMS_UPDATE = '_cegg_last_update_';
    const META_PREFIX_KEYWORD = '_cegg_keyword';
    const META_PREFIX_LAST_BYKEYWORD_UPDATE = '_cegg_last_bykeyword_update';

    public static function saveData(array $data, $module_id, $post_id)
    {
        if (!$data)
        {
            self::deleteData($module_id, $post_id);
            return;
        }
        foreach ($data as $i => $d)
        {
            if (is_object($d))
                $data[$i] = ArrayHelper::object2Array($d);
        }

        $data = self::setIds($data);
        $old_data = ContentManager::getData($post_id, $module_id);

        if (!$old_data)
            $old_data = array();
        $outdated = array();
        $data_changed = true;

        if ($old_data)
        {
            $outdated = array_diff_key($old_data, $data);
            $new = array_diff_key($data, $old_data);

            if (!$outdated && !$new)
                $data_changed = false;

            /*
             * we need force data update because title or description can be edited manually or items price update
              if (!$data_changed)
              return;
             * 
             */
        }
        // Sanitize content for allowed HTML tags and more. 
        array_walk_recursive($data, array('self', 'sanitizeData'));
        $module = ModuleManager::getInstance()->factory($module_id);
        $data = $module->presavePrepare($data, $post_id);

        // save data
        \update_post_meta($post_id, self::META_PREFIX_DATA . $module_id, $data);
        self::clearData($outdated);

        // touch last update time only if data changed?
        if ($data_changed)
        {
            self::touchUpdateTime($post_id, $module_id);
        }

        // save price history
        if (GeneralConfig::getInstance()->option('price_history_days'))
        {
            PriceHistoryModel::model()->saveData($data, $module_id, $post_id);
            // ...and send price alerts
            if (GeneralConfig::getInstance()->option('price_alert_enabled'))
                PriceAlert::getInstance()->sendAlerts($data, $module_id, $post_id);
        }

        \do_action('content_egg_save_data', $data, $module_id, $post_id);
    }

    public static function deleteData($module_id, $post_id)
    {
        $data = ContentManager::getData($post_id, $module_id);
        if (!$data)
            return;

        \delete_post_meta($post_id, self::META_PREFIX_DATA . $module_id);
        \delete_post_meta($post_id, self::META_PREFIX_LAST_BYKEYWORD_UPDATE . $module_id);
        \delete_post_meta($post_id, self::META_PREFIX_LAST_ITEMS_UPDATE . $module_id);

        self::clearData($data);

        \do_action('content_egg_save_data', array(), $module_id, $post_id);
    }

    private static function clearData($data)
    {
        // delete old img files if needed
        foreach ($data as $d)
        {
            if (empty($d['img_file']))
                continue;
            $img_file = ImageHelper::getFullImgPath($d['img_file']);
            if (is_file($img_file))
                @unlink($img_file);
        }
    }

    private static function setIds($data)
    {
        $results = array();
        foreach ($data as $d)
        {
            $results[$d['unique_id']] = $d;
        }
        return $results;
    }

    public static function touchUpdateTime($post_id, $module_id)
    {
        $time = time();
        \update_post_meta($post_id, self::META_PREFIX_LAST_BYKEYWORD_UPDATE . $module_id, $time);
        self::touchUpdateItemsTime($post_id, $module_id, $time);
    }

    public static function touchUpdateItemsTime($post_id, $module_id, $time = null)
    {
        if (!$time)
            $time = time();
        \update_post_meta($post_id, self::META_PREFIX_LAST_ITEMS_UPDATE . $module_id, $time);
    }

    private static function sanitizeData(&$data, $key)
    {
        if (in_array((string) $key, array('img', 'url', 'IFrameURL', 'orig_url')))
        {
            //$data = \esc_url_raw($data);
            //@todo... This filter allows all letters, digits and $-_.+!*'(),{}|\\^~[]`"><#%;/?:@&=
            $data = filter_var($data, FILTER_SANITIZE_URL);
        } elseif ($key === 'description')
        {
            $data = \wp_kses_post($data);
        } elseif ($key === 'linkHtml')
        {
            $data; //cj link
        } elseif ($key === 'title')
        {
            $data = \sanitize_text_field($data);
        } elseif ($key === 'last_update' && !$data)
        {
            $data = time();
        } else
            $data = \strip_tags($data);
    }

    public static function isDataExists($post_id, $module_id)
    {
        return (bool) \get_post_meta($post_id, self::META_PREFIX_LAST_BYKEYWORD_UPDATE . $module_id, true);
    }

    public static function getData($post_id, $module_id)
    {
        return self::fixData(\get_post_meta($post_id, ContentManager::META_PREFIX_DATA . $module_id, true), $module_id);
    }

    public static function fixData($data, $module_id)
    {
        if (!$data || !is_array($data))
            return $data;

        if ($module_id == 'Amazon')
        {
            $data = \ContentEgg\application\modules\Amazon\AmazonModule::fixUniqueIds($data);
        }
        return $data;
    }

    public static function getViewData($module_id, $post_id, $params = array())
    {
        $data = self::getData($post_id, $module_id);
        if (!$data)
            return array();

        foreach ($data as $key => $d)
        {
            // domain fix && logo
            if (empty($d['extra']['domain']) && isset($d['domain']))
                $data[$key]['extra']['domain'] = $d['domain'];
            elseif (empty($d['domain']) && isset($d['extra']['domain']))
                $data[$key]['domain'] = $d['extra']['domain'];
            if (empty($d['extra']['logo']) && isset($d['logo']))
                $data[$key]['extra']['logo'] = $d['logo'];
            elseif (empty($d['logo']) && isset($d['extra']['logo']))
                $data[$key]['logo'] = $d['extra']['logo'];

            // locale fix...
            if (!empty($params['locale']))
            {
                if (isset($d['extra']['locale']) && strtolower($d['extra']['locale']) != strtolower($params['locale']))
                    unset($data[$key]);
            }
        }

        // local redirect
        $module = ModuleManager::getInstance()->factory($module_id);
        if ($module->isParser() && $module->config('set_local_redirect'))
        {
            foreach ($data as $key => $d)
            {
                $data[$key]['url'] = LocalRedirect::createRedirectUrl($d['url'], $d['title'], LocalRedirect::REDIRECT_PREFIX_PARSER);
            }
        }
        return $data;
    }

    public static function getProductbyUniqueId($unique_id, $module_id, $post_id)
    {
        $data = self::getViewData($module_id, $post_id);
        if ($data && isset($data[$unique_id]))
            return $data[$unique_id];
        else
            return null;
    }

    public static function updateByKeyword($post_id, $module_id)
    {
        $keyword = \get_post_meta($post_id, ContentManager::META_PREFIX_KEYWORD . $module_id, true);
        if (!$keyword)
            return;

        $module = ModuleManager::getInstance()->factory($module_id);

        // update time in any case...
        ContentManager::touchUpdateTime($post_id, $module_id);
        try
        {
            $data = $module->doRequest($keyword, array(), true);
            // nodata!
            if (!$data)
            {
                return;
            }
        } catch (\Exception $e)
        {
            // error
            return;
        }

        $data = array_map(array('self', 'object2Array'), $data);
        ContentManager::saveData($data, $module_id, $post_id);
    }

    public static function updateItems($post_id, $module_id)
    {
        $module = ModuleManager::getInstance()->factory($module_id);
        if (!$module->isItemsUpdateAvailable())
            return;

        $items = ContentManager::getData($post_id, $module_id);
        if (!$items)
            return;

        try
        {
            $updated_data = $module->doRequestItems($items);
        } catch (\Exception $e)
        {
            // error
            ContentManager::touchUpdateItemsTime($post_id, $module_id);
            return;
        }

        // save & update time
        ContentManager::saveData($updated_data, $module_id, $post_id);
        ContentManager::touchUpdateItemsTime($post_id, $module_id);
    }

    /**
     *  Full depth recursive conversion to array
     * @param type $object
     * @return array
     */
    public static function object2Array($object)
    {
        return json_decode(json_encode($object), true);
    }

}
