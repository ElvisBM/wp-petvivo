<?php

namespace ContentEgg\application;

use ContentEgg\application\helpers\InputHelper;
use ContentEgg\application\components\ContentManager;
use ContentEgg\application\components\ModuleManager;

/**
 * LocalRedirect class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class LocalRedirect {

    const REDIRECT_PREFIX_PARSER = 'goce';

    public function __construct()
    {
        $this->initRedirect();
    }

    public static function initAction()
    {
        \add_action('template_redirect', array(__CLASS__, 'go'));
    }

    public static function go()
    {
        if (\get_option('permalink_structure'))
        {
            global $wp;
            if (preg_match("/" . self::REDIRECT_PREFIX_PARSER . "\/(.+?)$/", $wp->request, $match))
                $goce = $match[1];
            else
                $goce = '';
        } else
            $goce = InputHelper::get(self::REDIRECT_PREFIX_PARSER);

        if (!$goce)
            return;

        $goce_parts = explode('_', $goce);

        if (count($goce_parts) == 2)
        {
            $url = $goce_parts[0];
            $code = $goce_parts[1];
        } elseif (count($goce_parts) == 3)
        {
            $url = $goce_parts[1];
            $code = $goce_parts[2];
        } else
            self::send404();

        if ($code != substr(md5($url), 0, 3))
            self::send404();

        $url = self::base64_url_decode($url);
        \wp_redirect(esc_url_raw($url), 301);
        exit;
    }

    public static function createRedirectUrl($url, $title, $prefix)
    {
        if (\get_option('permalink_structure'))
            $path = $prefix . '/';
        else
            $path = '?' . $prefix . '=';

        $r_url = self::base64_url_encode($url);
        $secure = substr(md5($r_url), 0, 3);
        if ($title)
        {
            $title = str_replace(' ', '-', trim($title));
            $title = preg_replace('/[^a-z0-9A-Z\-]/', '', $title);
            $title = trim($title, '-');
            $title = explode('-', $title, 4);
            $title = array_slice($title, 0, 3);
            $title = join('-', $title);
            $r_url = $title . '_' . $r_url;
        }
        $r_url .= '_' . $secure;
        $path .= $r_url;

        return \get_site_url(\get_current_blog_id(), $path);
    }

    public static function send404()
    {
        global $wp_query;
        $wp_query->set_404();
        \status_header(404);
        include( \get_query_template('404') );
        exit;
    }

    public static function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-~,');
    }

    public static function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-~,', '+/='));
    }

}
