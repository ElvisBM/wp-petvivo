<?php

namespace ContentEgg\application\components;

/**
 * LinkHandler class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class LinkHandler {

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;

        return self::$instance;
    }

    /**
     * Deeplink & more...
     */
    public static function createAffUrl($url, $deeplink, $subid = '')
    {
        if (!$deeplink)
        {
            return $url;
        } elseif (strstr($deeplink, '{{') && strstr($deeplink, '}}'))
        {
            // teplate deeplink
            return self::getUrlTemplate($url, $deeplink);
        } elseif (!preg_match('/^https?:\/\//i', $deeplink))
        {
            // url with tail
            return self::getUrlWithTail($url, $deeplink);
        } else
        {
            // deeplink
            // @todo: subid
            //if ($subid)
            //$deeplink = Cpa::deeplinkSetSubid($deeplink, $subid);
            return $deeplink . urlencode($url);
        }
    }

    public static function getUrlWithTail($url, $tail)
    {
        $tail = preg_replace('/^[?&]/', '', $tail);

        $query = parse_url($url, PHP_URL_QUERY);
        if ($query)
            $url .= '&';
        else
            $url .= '?';

        parse_str($tail, $tail_array);
        $url .= http_build_query($tail_array);
        return $url;
    }

    public static function getUrlTemplate($url, $template)
    {
        $template = str_replace('{{url}}', $url, $template);
        $template = str_replace('{{url_encoded}}', urlencode($url), $template);
        return $template;
    }

}
