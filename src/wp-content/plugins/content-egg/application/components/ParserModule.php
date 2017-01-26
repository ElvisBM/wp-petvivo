<?php

namespace ContentEgg\application\components;

use ContentEgg\application\helpers\ImageHelper;
use ContentEgg\application\helpers\TextHelper;

/**
 * ParserModule abstract class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
abstract class ParserModule extends Module {

    const PARSER_TYPE_CONTENT = 'CONTENT';
    const PARSER_TYPE_PRODUCT = 'PRODUCT';
    const PARSER_TYPE_COUPON = 'COUPON';
    const PARSER_TYPE_IMAGE = 'IMAGE';
    const PARSER_TYPE_VIDEO = 'VIDEO';
    const PARSER_TYPE_OTHER = 'OTHER';

    abstract public function doRequest($keyword, $query_params = array(), $is_autoupdate = false);

    abstract public function getParserType();

    public function isActive()
    {
        if ($this->is_active === null)
        {
            if ($this->getConfigInstance()->option('is_active'))
                $this->is_active = true;
            else
                $this->is_active = false;
        }
        return $this->is_active;
    }

    final public function isParser()
    {
        return true;
    }

    public function presavePrepare($data, $post_id)
    {
        global $post;

        $data = parent::presavePrepare($data, $post_id);

        // do not save images for revisions
        if ($post && wp_is_post_revision($post_id))
            return $data;

        foreach ($data as $key => $item)
        {
            // fill domain
            if (empty($item['domain']))
            {
                if (!empty($item['orig_url']))
                    $url = $item['orig_url'];
                elseif (!empty($item['img']))
                    $url = $item['img'];
                else
                    $url = $item['url'];
					
                if ($url)
                    $data[$key]['domain'] = TextHelper::getHostName($url);
            }

            // save img
            if ($this->config('save_img') && !wp_is_post_revision($post_id))
            {
                // check old_data also. need for fix behavior with "preview changes" button
                if ($item['img'] && empty($item['img_file']) && empty($old_data[$key]['img_file']))
                {
                    $local_img_name = ImageHelper::saveImgLocaly($item['img'], $item['title']);
                    if ($local_img_name)
                    {
                        $uploads = \wp_upload_dir();
                        $item['img'] = $uploads['url'] . '/' . $local_img_name;
                        $item['img_file'] = ltrim(trailingslashit($uploads['subdir']), '\/') . $local_img_name;
                    }
                    $data[$key] = $item;
                }
            }
        }
        return $data;
    }

    public static function getFullImgPath($img_path)
    {
        $uploads = \wp_upload_dir();
        return trailingslashit($uploads['basedir']) . $img_path;
    }

    public function defaultTemplateName()
    {
        return 'data_simple';
    }

}
