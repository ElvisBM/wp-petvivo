<?php

namespace ContentEgg\application\modules\Amazon;

use ContentEgg\application\components\AffiliateParserModule;
use ContentEgg\application\libs\amazon\AmazonProduct;
use ContentEgg\application\components\ContentProduct;
use ContentEgg\application\admin\PluginAdmin;
use ContentEgg\application\components\ExtraData;
use ContentEgg\application\helpers\TextHelper;

/**
 * AmazonModule class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class AmazonModule extends AffiliateParserModule {

    private $api_client = null;

    public function info()
    {
        return array(
            'name' => 'Amazon',
            'api_agreement' => 'https://affiliate-program.amazon.com/gp/advertising/api/detail/agreement.html',
            'description' => __('Adds goods from Amazon.', 'content-egg'),
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
        $keyword = trim($keyword);
        $search_index = $this->config('search_index');
        // Если не задана категория для поиска, то все остальные опции фильтрации работать не будут!
        if ($search_index != 'All' && $search_index != 'Blended')
        {
            if ($this->config('title'))
                $options['Title'] = $keyword;
            else
                $options['Keywords'] = $keyword;

            $options['Sort'] = $this->config('sort');
            if ((int) $this->config('brouse_node'))
                $options['BrowseNode'] = (int) $this->config('brouse_node');

            // Specifies the minimum price of the items to return. Prices are in 
            // terms of the lowest currency denomination, for example, pennies, 
            // for example, 3241 represents $32.41.
            if ($this->config('minimum_price'))
                $options['MinimumPrice'] = TextHelper::pricePenniesDenomination($this->config('minimum_price'));
            if ($this->config('maximum_price'))
                $options['MaximumPrice'] = TextHelper::pricePenniesDenomination($this->config('maximum_price'));

            // Specifies the minimum percentage off for the items to return.
            // @link: http://docs.aws.amazon.com/AWSECommerceService/latest/DG/LocaleUS.html
            if (!empty($query_params['min_percentage_off']))
                $options['MinPercentageOff'] = (int) $query_params['min_percentage_off'];
            elseif ($this->config('min_percentage_off'))
                $options['MinPercentageOff'] = (int) $this->config('min_percentage_off');
        } else
            $options['Keywords'] = $keyword; // Для категории "All" работает только поиск по ключевому слову

        if ($this->config('merchant_id'))
            $options['MerchantId'] = "Amazon";

        $options['ResponseGroup'] = 'ItemIds,Offers,ItemAttributes,Images';

        // Customer Reviews
        if ($this->config('customer_reviews'))
        {
            $options['ResponseGroup'] .= ',Reviews';
            $options['TruncateReviewsAt'] = $this->config('truncate_reviews_at');
            //$options['ReviewSort'] = $this->config('review_sort');
            $options['IncludeReviewsSummary'] = true;
        }
        // Editorial Reviews
        if ($this->config('editorial_reviews'))
        {
            $options['ResponseGroup'] .= ',EditorialReview';
        }

        // locale
        if (!empty($query_params['locale']) && array_key_exists($query_params['locale'], AmazonConfig::getActiveLocalesList()))
            $locale = $query_params['locale'];
        else
            $locale = $this->config('locale');

        // associate tag
        if (!empty($query_params['associate_tag']) && $query_params['associate_tag'])
            $associate_tag = $query_params['associate_tag'];
        else
            $associate_tag = $this->getAssociateTagForLocale($locale);

        // api client
        $client = $this->getAmazonClient();
        $client->setLocale($locale);
        $client->setAssociateTag($associate_tag);

        // Paging Through Results
        // @link: http://docs.aws.amazon.com/AWSECommerceService/latest/DG/PagingThroughResults.html
        if ($is_autoupdate)
            $total = $this->config('entries_per_page_update');
        else
            $total = $this->config('entries_per_page');

        $pages_count = ceil($total / 10);
        $results = array();

        // EAN or ASIN search
        if (TextHelper::isEan($keyword) && $search_index != 'All') 
        {
            $options['IdType'] = 'EAN';
            // All IdTypes except ASINx require a SearchIndex to be specified.
            $options['SearchIndex'] = $search_index;            
            unset($options['Keywords']);
            $ItemLookup = true;
        } elseif (TextHelper::isAsin($keyword))
        {
            $options['IdType'] = 'ASIN';
            unset($options['Keywords']);
            $ItemLookup = true;
        } else
            $ItemLookup = false;
        
        for ($i = 0; $i < $pages_count; $i++)
        {
            $options['ItemPage'] = $i + 1;
            if ($ItemLookup)
                $data = $client->ItemLookup($keyword, $options); // EAN or ASIN search
            else
                $data = $client->ItemSearch($search_index, $options); // keyword search
            
            if (!is_array($data))
                break;

            $totalPages = (int) $data['Items']['TotalPages'];
            $data = array_slice($data['Items']['Item'], 0, $total - count($results));
            $results = array_merge($results, $this->prepareResults($data, $is_autoupdate, $locale, $associate_tag));
            if ($totalPages <= $i + 1)
                break;
        }
        return $results;
    }

    public function doRequestItems(array $items)
    {
        $locales = array();
        $default_locale = $this->config('locale');

        $items = self::fixUniqueIds($items);

        // find all locales
        foreach ($items as $item)
        {
            if (!empty($item['extra']['locale']))
                $locale = $item['extra']['locale'];
            else
            {
                $locale = $default_locale;
                $item['extra']['locale'] = $locale;
            }

            if (!in_array($locale, $locales))
                $locales[] = $locale;
        }

        // request by locale
        $results = array();
        foreach ($locales as $locale)
        {
            $request = array();
            foreach ($items as $item)
            {
                if ($item['extra']['locale'] == $locale)
                    $request[] = $item;
            }
            $results = array_merge($results, $this->requestItems($request, $locale));
        }

        // assign new data
        foreach ($items as $key => $item)
        {
            if (isset($results[$item['unique_id']]))
                $items[$key] = $results[$item['unique_id']];
        }

        return $items;
    }

    private function requestItems(array $items, $locale)
    {
        $options = array();

        $item_ids = array();
        foreach ($items as $item)
        {
            $item_ids[] = $item['extra']['ASIN'];
        }

        $options['ResponseGroup'] = 'Offers';

        // update iframe url  for customer reviews
        //if ($this->config('customer_reviews') && $this->config('customer_reviews_iframe'))
        if ($this->config('customer_reviews'))
        {
            $options['ResponseGroup'] .= ',Reviews';
            $options['TruncateReviewsAt'] = $this->config('truncate_reviews_at');
            $options['IncludeReviewsSummary'] = true;
        }

        // associate tag
        $associate_tag = $this->getAssociateTagForLocale($locale);

        // api client
        $client = $this->getAmazonClient();
        $client->setLocale($locale);
        $client->setAssociateTag($associate_tag);

        $results = $client->ItemLookup($item_ids, $options);

        if (!isset($results['Items']))
            throw new \Exception('ItemLookup request error.');

        $results = $results['Items']['Item'];

        $i = 0;
        $return = array();
        foreach ($items as $key => $item)
        {
            if ($item['extra']['ASIN'] != $results[$i]['ASIN'])
                continue;

            // offer
            $items[$key] = self::fillOfferVars($results[$i], $item, $item['extra']);
            if (!empty($results[$i]['CustomerReviews']))
            {
                $items[$key]['extra']['customerReviews'] = (array) new ExtraAmazonCustomerReviews;
                $items[$key]['extra']['customerReviews'] = ExtraData::fillAttributes($items[$key]['extra']['customerReviews'], $results[$i]['CustomerReviews']);
            }
            $items[$key]['domain'] = AmazonConfig::getDomainByLocale($locale);
            $return[$item['unique_id']] = $items[$key];
            $i++;
        }

        return $return;
    }

    private function prepareResults($results, $is_autoupdate, $locale, $associate_tag)
    {
        $data = array();
        foreach ($results as $key => $r)
        {
            $content = new ContentProduct;
            $extra = new ExtraDataAmazon;
            ExtraData::fillAttributes($extra, $r);
            $extra->locale = $locale;
            $extra->associate_tag = $associate_tag;

            if (isset($r['ItemLinks']) && isset($r['ItemLinks']['ItemLink']))
            {
                foreach ($r['ItemLinks']['ItemLink'] as $link_r)
                {
                    $link = new ExtraAmazonItemLinks;
                    ExtraData::fillAttributes($link, $link_r);
                    $extra->itemLinks[] = $link;
                }
            }

            if (!empty($r['ImageSets']) && !empty($r['ImageSets']['ImageSet']))
            {
                if (!isset($r['ImageSets']['ImageSet'][0]))
                    $r['ImageSets'] = array($r['ImageSets']['ImageSet']);
                else
                    $r['ImageSets'] = $r['ImageSets']['ImageSet'];


                foreach ($r['ImageSets'] as $image_r)
                {
                    $image = new ExtraAmazonImageSet;
                    $image->attributes = $image_r['@attributes'];
                    $image->SwatchImage = $this->rewriteSslImageUrl($image_r['SwatchImage']['URL']);
                    $image->SmallImage = $this->rewriteSslImageUrl($image_r['SmallImage']['URL']);
                    $image->ThumbnailImage = $this->rewriteSslImageUrl($image_r['ThumbnailImage']['URL']);
                    $image->TinyImage = $this->rewriteSslImageUrl($image_r['TinyImage']['URL']);
                    $image->MediumImage = $this->rewriteSslImageUrl($image_r['MediumImage']['URL']);
                    $image->LargeImage = $this->rewriteSslImageUrl($image_r['LargeImage']['URL']);
                    $extra->imageSet[] = $image;
                }
            }

            if (isset($r['ItemAttributes']['Feature']) && !is_array($r['ItemAttributes']['Feature']))
                $r['ItemAttributes']['Feature'] = array($r['ItemAttributes']['Feature']);

            $extra->itemAttributes = new ExtraAmazonItemAttributes;
            ExtraData::fillAttributes($extra->itemAttributes, $r['ItemAttributes']);

            if (isset($r['ItemAttributes']['Category']))
                $content->category = $r['ItemAttributes']['Category'];
            if (isset($r['ItemAttributes']['Manufacturer']))
                $content->manufacturer = $r['ItemAttributes']['Manufacturer'];
            if (isset($r['ItemAttributes']['Author']))
                $extra->author = $r['ItemAttributes']['Author'];

            // Offers
            self::fillOfferVars($r, $content, $extra);

            if (isset($r['CustomerReviews']))
            {
                $extra->customerReviews = new ExtraAmazonCustomerReviews;
                ExtraData::fillAttributes($extra->customerReviews, $r['CustomerReviews']);
            }

            // Editorial Reviews
            if (isset($r['EditorialReviews']['EditorialReview']))
            {
                if (!isset($r['EditorialReviews']['EditorialReview'][0]))
                    $r['EditorialReviews']['EditorialReview'] = array($r['EditorialReviews']['EditorialReview']);

                foreach ($r['EditorialReviews']['EditorialReview'] as $editorialReview_r)
                {
                    $editorialReview = new ExtraAmazonEditorialReviews;
                    ExtraData::fillAttributes($editorialReview, $editorialReview_r);

                    // safe html
                    $editorialReview->Content = TextHelper::safeHtml($editorialReview->Content, $this->config('editorial_reviews_type'));

                    //размер
                    if ($this->config('editorial_reviews_size'))
                    {
                        $editorialReview->Content = TextHelper::truncateHtml($editorialReview->Content, $this->config('editorial_reviews_size'));
                    }
                    $extra->editorialReviews[] = $editorialReview;
                }
            }

            // Заполняем стандартные поля: title, description, url, price
            // все остальные данные в extra

            $content->url = urldecode($r['DetailPageURL']); // urldecode???

            if (isset($r['ItemAttributes']['Title']))
                $content->title = $r['ItemAttributes']['Title'];

            //MediumImage может и не быть, а только ImageSets, тогда берем картинки с ImageSets
            if (isset($r['MediumImage']))
            {
                $extra->smallImage = $r['SmallImage']['URL'];
                $extra->mediumImage = $r['MediumImage']['URL'];
                $extra->largeImage = $r['LargeImage']['URL'];
            } elseif (!empty($r['ImageSets']))
            {
                $extra->smallImage = $r['ImageSets'][0]['SmallImage']['URL'];
                $extra->mediumImage = $r['ImageSets'][0]['MediumImage']['URL'];
                $extra->largeImage = $r['ImageSets'][0]['LargeImage']['URL'];
            }

            if (isset($r['LargeImage']))
                $content->img = $r['LargeImage']['URL'];
            elseif ($extra->largeImage)
                $content->img = $extra->largeImage;

            if (!$this->config('save_img'))
            {
                $content->img = $this->rewriteSslImageUrl($content->img);
            }

            $extra->addToCartUrl = $this->getAmazonAddToCartUrl($locale) .
                    '?ASIN.1=' . $extra->ASIN . '&Quantity.1=1' .
                    '&AssociateTag=' . $this->getAssociateTagForLocale($locale);

            if ($this->config('link_type') == 'add_to_cart')
            {
                $content->orig_url = $content->url;
                $content->url = $extra->addToCartUrl;
            }

            $content->extra = $extra;
            $content->unique_id = $locale . '-' . $extra->ASIN;
            $content->merchant = 'Amazon';
            $content->domain = AmazonConfig::getDomainByLocale($locale);

            $data[] = $content;
        }
        return $data;
    }

    private function getAmazonClient()
    {
        if ($this->api_client === null)
        {
            $access_key_id = $this->config('access_key_id');
            $secret_access_key = $this->config('secret_access_key');
            $associate_tag = $this->config('associate_tag');
            $this->api_client = new AmazonProduct($access_key_id, $secret_access_key, $associate_tag);
            //$this->api_client->setLocale($this->config('locale'));
        }
        return $this->api_client;
    }

    static private function fillOfferVars($r, $content, $extra)
    {
        // dirty tricks with object2array conversation for doRequestItems
        $return_array = false;
        if (!is_object($content))
        {
            $return_array = true;
            unset($content['extra']);
            $content = json_decode(json_encode($content), FALSE);
            $extra = json_decode(json_encode($extra), FALSE);
        }

        // OfferSummary
        if (isset($r['OfferSummary']))
        {
            if (!empty($r['OfferSummary']['LowestNewPrice']) && isset($r['OfferSummary']['LowestNewPrice']['Amount']))
                $extra->lowestNewPrice = TextHelper::pricePenniesDenomination($r['OfferSummary']['LowestNewPrice']['Amount'], false);
            if (!empty($r['OfferSummary']['LowestUsedPrice']) && isset($r['OfferSummary']['LowestUsedPrice']['Amount']))
                $extra->lowestUsedPrice = TextHelper::pricePenniesDenomination($r['OfferSummary']['LowestUsedPrice']['Amount'], false);
            if (!empty($r['OfferSummary']['LowestCollectiblePrice']) && isset($r['OfferSummary']['LowestCollectiblePrice']['Amount']))
                $extra->lowestCollectiblePrice = TextHelper::pricePenniesDenomination($r['OfferSummary']['LowestCollectiblePrice']['Amount'], false);
            if (!empty($r['OfferSummary']['LowestRefurbishedPrice']) && isset($r['OfferSummary']['LowestRefurbishedPrice']['Amount']))
                $extra->lowestRefurbishedPrice = TextHelper::pricePenniesDenomination($r['OfferSummary']['LowestRefurbishedPrice']['Amount'], false);
            $extra->totalNew = (int) $r['OfferSummary']['TotalNew'];
            $extra->totalUsed = (int) $r['OfferSummary']['TotalUsed'];
            $extra->totalCollectible = (int) $r['OfferSummary']['TotalCollectible'];
            $extra->totalRefurbished = (int) $r['OfferSummary']['TotalRefurbished'];
        }

        // Offers
        if (isset($r['Offers']) &&
                isset($r['Offers']['Offer']) &&
                isset($r['Offers']['Offer']['OfferListing']))
        {
            // SalePrice for amazon de?
            if (isset($r['Offers']['Offer']['OfferListing']['SalePrice']))
                $r['Price'] = $r['Offers']['Offer']['OfferListing']['SalePrice'];
            else
                $r['Price'] = $r['Offers']['Offer']['OfferListing']['Price'];

            if (isset($r['Offers']['Offer']['OfferListing']['AmountSaved']))
            {
                $extra->AmountSaved = $r['Offers']['Offer']['OfferListing']['AmountSaved']['FormattedPrice'];
                if (isset($r['Offers']['Offer']['OfferListing']['PercentageSaved']))
                    $content->percentageSaved = $r['Offers']['Offer']['OfferListing']['PercentageSaved'];
            }

            //@link: http://docs.aws.amazon.com/AWSECommerceService/latest/DG/AvailabilityValues.html
            if (isset($r['Offers']['Offer']['OfferListing']['Availability']))
            {
                $extra->availability = $r['Offers']['Offer']['OfferListing']['Availability'];
            }

            if (isset($r['Offers']['Offer']['OfferListing']['IsEligibleForSuperSaverShipping']))
                $extra->IsEligibleForSuperSaverShipping = $r['Offers']['Offer']['OfferListing']['IsEligibleForSuperSaverShipping'];
        }elseif (isset($r['OfferSummary']['LowestNewPrice']))
            $r['Price'] = $r['OfferSummary']['LowestNewPrice'];


        if ((!isset($r['Price']) || !$r['Price']) && isset($r['ItemAttributes']['ListPrice']))
            $r['Price'] = $r['ItemAttributes']['ListPrice'];

        if (isset($r['ItemAttributes']['ListPrice']) &&
                $r['ItemAttributes']['ListPrice']['Amount'] &&
                ( (isset($r['Price']['Amount']) && $r['ItemAttributes']['ListPrice']['Amount'] > $r['Price']['Amount']) || $r['Price']['FormattedPrice'] == 'Too low to display'))
        {
            $content->priceOld = TextHelper::pricePenniesDenomination($r['ItemAttributes']['ListPrice']['Amount'], false);
            $content->currencyCode = $r['ItemAttributes']['ListPrice']['CurrencyCode'];
            $content->currency = TextHelper::currencyTyping($content->currencyCode);
        }

        if (isset($r['Price']['FormattedPrice']) && $r['Price']['FormattedPrice'] == 'Too low to display')
            $extra->toLowToDisplay = true;

        if (!empty($r['Price']['Amount']))
        {
            $content->price = TextHelper::pricePenniesDenomination($r['Price']['Amount'], false);
            $content->currencyCode = $r['Price']['CurrencyCode'];
            $content->currency = TextHelper::currencyTyping($content->currencyCode);
        } else
            $content->price = 0;
        
        $content->ean = $extra->itemAttributes->EAN;        

        if ($return_array)
        {
            $content = json_decode(json_encode($content), true);
            $extra = json_decode(json_encode($extra), true);
            $content['extra'] = $extra;
            return $content;
        }
    }

    private function getLocaleSite($locale)
    {
        switch ($locale)
        {
            case 'uk':
                return 'http://www.amazon.co.uk';
            case 'de':
                return 'http://www.amazon.de';
                break;
            case 'fr':
                return 'http://www.amazon.fr';
                break;
            case 'jp':
                return 'http://www.amazon.co.jp';
                break;
            case 'cn':
                return 'http://www.amazon.cn';
                break;
            case 'it':
                return 'http://www.amazon.it';
                break;
            case 'es':
                return 'http://www.amazon.es';
                break;
            case 'ca':
                return 'http://www.amazon.ca';
                break;
            case 'br':
                return 'http://www.amazon.br';
                break;
            case 'in':
                return 'http://www.amazon.in';
                break;
            default: //'us'
                return 'http://www.amazon.com';
                break;
        }
    }

    private function getAssociateTagForLocale($locale)
    {
        if ($locale == $this->config('locale'))
            return $this->config('associate_tag');
        else
            return $this->config('associate_tag_' . $locale);
    }

    private function rewriteSslImageUrl($img)
    {
        if ($this->config('https_img'))
            return str_replace('http://ecx.images-amazon.com', 'https://images-na.ssl-images-amazon.com', $img);
        else
            return $img;
    }

    /**
     * Add to shopping cart url
     * @link: http://docs.amazonwebservices.com/AWSECommerceService/latest/DG/AddToCartForm.html
     * @link: https://affiliate-program.amazon.com/gp/associates/help/t1/a10?ie=UTF8&pf_rd_i=assoc_help_t6_a1&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=&pf_rd_r=&pf_rd_s=assoc-center-1&pf_rd_t=501&ref_=amb_link_177735_1
     * @link: https://affiliate-program.amazon.com/gp/associates/help/operating
     * @link: https://affiliate-program.amazon.com/gp/associates/help/t2/a11
     */
    private function getAmazonAddToCartUrl($locale)
    {
        return $this->getLocaleSite($locale) . '/gp/aws/cart/add.html';
    }

    public function renderResults()
    {
        PluginAdmin::render('_metabox_results', array('module_id' => $this->getId()));
    }

    public function renderSearchResults()
    {
        PluginAdmin::render('_metabox_search_results', array('module_id' => $this->getId()));
    }

    public function renderSearchPanel()
    {
        $this->render('search_panel', array('module_id' => $this->getId()));
    }

    public static function fixUniqueIds(array $items)
    {
        // fix for old items
        $fixed = array();
        foreach ($items as $key => $item)
        {
            if (empty($item['extra']['locale']))
            {
                $fixed[$key] = $item;
                continue;
            }

            if (!strstr($item['unique_id'], '-'))
            {
                $new_unique_id = $item['extra']['locale'] . '-' . $item['unique_id'];
                $item['unique_id'] = $new_unique_id;
                $fixed[$new_unique_id] = $item;
            } else
                $fixed[$key] = $item;
        }
        return $fixed;
    }

}
