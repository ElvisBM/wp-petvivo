<?php

namespace ContentEgg\application\modules\AE;

use ContentEgg\application\admin\AeIntegrationConfig;
use ContentEgg\application\components\AffiliateParserModule;
use ContentEgg\application\components\ContentProduct;
use ContentEgg\application\admin\PluginAdmin;
use ContentEgg\application\helpers\TextHelper;
use ContentEgg\application\components\LinkHandler;
use \Keywordrush\AffiliateEgg\ParserManager;

/**
 * AmazonModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class AEModule extends AffiliateParserModule {

    public function __construct($module_id = null)
    {
        if (!AeIntegrationConfig::isAEIntegrationPosible())
            throw new \Exception('The required Affiliate Egg plugin is not installed.');

        parent::__construct($module_id);
    }

    public function info()
    {
        $name = \Keywordrush\AffiliateEgg\ShopManager::getInstance()->getShopName($this->getMyShortId());
        $uri = \Keywordrush\AffiliateEgg\ShopManager::getInstance()->getShopUri($this->getMyShortId());
        $uri = str_replace('http://', '', $uri);
        return array(
            'name' => 'AE:' . $name,
            'description' => __('Поиск на основании парсера Affiliate Egg плагина для' . ' ' . $uri . '.', 'content-egg'),
        );
    }

    public function getParserType()
    {
        return self::PARSER_TYPE_PRODUCT;
    }

    public function defaultTemplateName()
    {
        return 'data_grid';
    }

    public function isItemsUpdateAvailable()
    {
        return true;
    }

    public function isFree()
    {
        return true;
    }

    public function doRequest($keyword, $query_params = array(), $is_autoupdate = false)
    {
        if ($is_autoupdate)
            $entries_per_page = $this->config('entries_per_page_update');
        else
            $entries_per_page = $this->config('entries_per_page');

        // 1. Parse catalog
        $product_urls = ParserManager::getInstance()->parseSearchCatalog($this->getMyShortId(), $keyword, $entries_per_page);
        if (!$product_urls || !is_array($product_urls))
            return array();

        //2. Parse products
        $product_sleep = \Keywordrush\AffiliateEgg\GeneralConfig::getInstance()->option('product_sleep');

        $results = array();
        foreach ($product_urls as $key => $url)
        {
            try
            {
                $results[] = ParserManager::getInstance()->parseProduct($url);
            } catch (\Exception $e)
            {
                continue;
            }

            // sleep
            if ($product_sleep && $key < count($product_urls) - 1)
                usleep($product_sleep);
        }

        return $this->prepareResults($results);
    }

    private function prepareResults($results)
    {
        $data = array();
        $deeplink = $this->config('deeplink');

        foreach ($results as $key => $r)
        {
            $content = new ContentProduct;
            $content->unique_id = md5($r['orig_url']);
            $content->url = LinkHandler::createAffUrl($r['orig_url'], $deeplink);
            $content->orig_url = $r['orig_url'];
            $content->img = $r['img'];
            $content->title = $r['title'];
            $content->description = $r['description'];
            $content->price = $r['price'];
            $content->priceOld = $r['old_price'];
            $content->currencyCode = $r['currency'];
            $content->currency = TextHelper::currencyTyping($content->currencyCode);
            $content->manufacturer = $r['manufacturer'];
            $content->availability = $r['in_stock'];
            $content->rating = $r['rating'];

            $content->extra = new ExtraDataAE;
            if (isset($r['extra']['features']))
            {
                $content->extra->features = $r['extra']['features'];
                unset($r['extra']['features']);
            }
            if (isset($r['extra']['comments']))
            {
                $content->extra->comments = $r['extra']['comments'];
                unset($r['extra']['comments']);
            }
            if (isset($r['extra']['images']))
            {
                $content->extra->images = $r['extra']['images'];
                unset($r['extra']['images']);
            }
            $content->extra->data = $r['extra'];

            $data[] = $content;
        }
        return $data;
    }

    public function doRequestItems(array $items)
    {
        $key = 0;
        $product_sleep = \Keywordrush\AffiliateEgg\GeneralConfig::getInstance()->option('product_update_sleep');
        foreach ($items as $i => $item)
        {
            if ($product_sleep && $key > 0)
                usleep($product_sleep);
            $key++;

            try
            {
                $r = ParserManager::getInstance()->parseProduct($item['orig_url']);

                // update url if deeplink changed
                $items[$i]['url'] = LinkHandler::createAffUrl($r['orig_url'], $this->config('deeplink'));
                $items[$i]['price'] = $r['price'];
                $items[$i]['priceOld'] = $r['old_price'];
                $items[$i]['currencyCode'] = $r['currency'];
                $items[$i]['currency'] = TextHelper::currencyTyping($items[$i]['currencyCode']);
            } catch (\Exception $e)
            {
                continue;
            }
        }

        return $items;
    }

    public function renderResults()
    {
        PluginAdmin::render('_metabox_results', array('module_id' => $this->getId()));
    }

    public function renderSearchResults()
    {
        PluginAdmin::render('_metabox_search_results', array('module_id' => $this->getId()));
    }

}
