<?php

namespace ContentEgg\application\modules\AdmitadProducts;

use ContentEgg\application\components\AffiliateParserModule;
use ContentEgg\application\libs\admitad\AdmitadProducts;
use ContentEgg\application\components\ContentProduct;
use ContentEgg\application\admin\PluginAdmin;
use ContentEgg\application\helpers\TextHelper;

/**
 * AdmitadProductsModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class AdmitadProductsModule extends AffiliateParserModule {

    public function info()
    {
        return array(
            'name' => 'Admitad Products',
            'description' => __('Add products from <a href="https://www.admitad.com/ru/promo/?ref=770f943d83">Admitad</a>.', 'content-egg') . ' ' . __('You must get approve for each program separately.', 'content-egg')
            . '<br>' . __('Used API the <a href="https://www.admitadgoods.ru/en.html" target="_blank">Admitad Goods</a> WP plugin.', 'content-egg')
        );
    }

    public function getParserType()
    {
        return self::PARSER_TYPE_PRODUCT;
    }

    public function defaultTemplateName()
    {
        return 'data_item';
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
        $options = array();

        $offer_id = (int) $this->config('offer_id');
        $options['offer_id'] = $offer_id;

        if ($this->config('only_sale'))
            $options['only_sale'] = 1;

        if ($this->config('price_from'))
            $options['price_from'] = (int) $this->config('price_from');
        if ($this->config('price_to'))
            $options['price_to'] = (int) $this->config('price_to');

        $client = new AdmitadProducts();
        $results = $client->search($keyword, $options);

        if (!is_array($results) || !isset($results['items']))
            return array();
        if ($is_autoupdate)
            $limit = $this->config('entries_per_page_update');
        else
            $limit = $this->config('entries_per_page');
        $results = array_slice($results['items'], 0, $limit);
        return $this->prepareResults($results, $offer_id);
    }

    public function prepareResults($results, $offer_id)
    {
        $data = array();

        foreach ($results as $key => $r)
        {
            $content = new ContentProduct;
            $content->unique_id = $offer_id . '-' . $r['id_item'];
            $content->category = $r['categoryId'];
            $content->currencyCode = $r['currencyId'];
            $content->currency = TextHelper::currencyTyping($content->currencyCode);
            $content->title = $r['name'];
            $content->priceOld = (float) $r['oldprice'];
            $content->price = (float) $r['price'];
            $content->img = $r['picture'];
            $content->manufacturer = $r['vendor'];
            $content->orig_url = $this->parseUrl($r['url']);
            $content->domain = TextHelper::parseDomain($content->orig_url, 'ulp');
            $content->url = $this->config('deeplink') . urlencode($content->orig_url);
            $content->description = $r['description'];
            if ($max_size = $this->config('description_size'))
                $content->description = TextHelper::truncate($content->description, $max_size);

            $content->extra = new ExtraDataAdmitadProducts;
            $content->extra->offer_id = $offer_id;
            $content->extra->id_item = $r['id_item'];
            ExtraDataAdmitadProducts::fillAttributes($content->extra, $r);

            $data[] = $content;
        }
        return $data;
    }

    public function doRequestItems(array $items)
    {
        $productsToUpdate = array();
        foreach ($items as $item)
        {
            if (empty($item['extra']['offer_id']) || empty($item['extra']['id_item']) || empty($item['extra']['id']))
                continue;
            $productsToUpdate[$item['extra']['offer_id']][] = $item['extra']['id_item'];
        }

        $client = new AdmitadProducts();
        $results = $client->update($productsToUpdate);
        if (!is_array($results) || !isset($results[0]['id_item']))
            throw new \Exception('doRequestItems request error.');

        // assign new price        
        foreach ($results as $r)
        {
            foreach ($items as $key => $item)
            {
                if ((int) $item['extra']['id_item'] == (int) $r['id_item'])
                {
                    $items[$key]['priceOld'] = (float) $r['oldprice'];
                    $items[$key]['price'] = (float) $r['price'];
                    //$items['url'] = $this->config('deeplink') . urlencode($content->orig_url);             $content->description = $r['description'];
                    break;
                }
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

    private function parseUrl($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $params);
        if (empty($params['ulp']))
            throw new \Exception('Invalid product URI');
        return $params['ulp'];
    }

}
