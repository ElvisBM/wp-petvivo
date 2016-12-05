<?php

namespace ContentEgg\application\modules\GoogleImages;

use ContentEgg\application\components\ParserModule;
use ContentEgg\application\libs\google\ImagesSearch;
use ContentEgg\application\components\Content;
use ContentEgg\application\helpers\TextHelper;
use ContentEgg\application\admin\PluginAdmin;
use ContentEgg\application\admin\GeneralConfig;

/**
 * GoogleImagesModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class GoogleImagesModule extends ParserModule {

    public function info()
    {
        return array(
            'name' => 'Google Images',
            'description' => __('<span style="color:red;">Этот модуль больше не работает по причине закрытия Google Image Search API. Модуль оставлен в целях совместимости с предыдущими версиями плагина.</span>', 'content-egg'),
                //'api_agreement' => 'https://developers.google.com/image-search/terms',
        );
    }

    public function getParserType()
    {
        return self::PARSER_TYPE_IMAGE;
    }

    public function defaultTemplateName()
    {
        return 'data_image';
    }

    public function isFree()
    {
        return true;
    }

    public function doRequest($keyword, $query_params = array(), $is_autoupdate = false)
    {

        // The Google Image Search API has been officially deprecated as 
        // of May 26, 2011. It will continue to work as per our deprecation 
        // policy, but the number of requests you may make per day may be 
        // limited. We encourage you to use the Custom Search API, which now 
        // supports image search.

        throw new \Exception('The Google Image Search API has been officially closed.');

        $options = array();

        if ($is_autoupdate)
            $options['rsz'] = $this->config('entries_per_page_update');
        else
            $options['rsz'] = $this->config('entries_per_page');

        if (isset($query_params['license']))
            $options['as_rights'] = $query_params['license'];
        elseif ($this->config('license'))
            $options['as_rights'] = $this->config('license');

        if (isset($query_params['imgsz']))
            $options['imgsz'] = $query_params['imgsz'];
        elseif ($this->config('imgsz'))
            $options['imgsz'] = $this->config('imgsz');

        $options['hl'] = GeneralConfig::getInstance()->option('lang');
        if (!empty($_SERVER['REMOTE_ADDR']))
            $options['userip'] = $_SERVER['REMOTE_ADDR'];

        $options_list = array('as_sitesearch', 'imgc', 'imgcolor', 'imgtype', 'safe', 'as_sitesearch');
        foreach ($options_list as $o)
        {
            if ($this->config($o))
                $options[$o] = $this->config($o);
        }
        try
        {
            $api_client = new ImagesSearch();
            $results = $api_client->search($keyword, $options);
        } catch (Exception $e)
        {
            throw new \Exception(strip_tags($e->getMessage()));
        }

        if (empty($results['responseData']) || empty($results['responseData']['results']))
            return array();

        return $this->prepareResults($results['responseData']['results']);
    }

    private function prepareResults($results)
    {
        $data = array();
        foreach ($results as $key => $r)
        {
            $content = new Content;

            $content->unique_id = $r['imageId'];
            $content->title = $r['titleNoFormatting'];
            $content->description = trim($r['contentNoFormatting']);
            if ($max_size = $this->config('description_size'))
                $content->description = TextHelper::truncate($content->description, $max_size);

            $content->img = $r['url'];
            $content->url = $r['originalContextUrl'];

            $extra = new ExtraDataGoogleImages;
            $extra->source = $r['visibleUrl'];
            $content->extra = $extra;
            $data[] = $content;
        }
        return $data;
    }

    public function renderResults()
    {
        PluginAdmin::render('_metabox_results', array('module_id' => $this->getId()));
    }

    public function renderSearchResults()
    {
        PluginAdmin::render('_metabox_search_results_images', array('module_id' => $this->getId()));
    }

    public function renderSearchPanel()
    {
        $this->render('search_panel', array('module_id' => $this->getId()));
    }

}
