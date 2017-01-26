<?php

namespace Keywordrush\AffiliateEgg;
/*
 Name: Bodybuilding.com
 URI: http://www.bodybuilding.com
 Icon: http://www.google.com/s2/favicons?domain=bodybuilding.com
 CPA: 
 */

/**
 * BodybuildingcomParser class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2014 keywordrush.com
 */
class BodybuildingcomParser extends ShopParser {

    protected $charset = 'utf-8';
    protected $currency = 'USD';

    public function parseCatalog($max) {
        $urls = array_slice($this->xpathArray(".//article[contains(@class,'store-layout-product-item')]//div[contains(@class,'product-details')]/h3/a/@href"), 0, $max);
        foreach ($urls as $key => $url)
        {
            if (!preg_match('/^http:/', $url))
            $urls[$key] = 'http://www.bodybuilding.com/' . $url;
        }
        return $urls;
    }

    public function parseTitle() {
        return $this->xpathScalar(".//meta[@property='og:title']/@content");
    }

    public function parseDescription() {
           $results = $this->xpathScalar(".//div[contains(@class,'product-description')]//*[contains(@class,'summary')]");           
        return $results;
    }

    public function parsePrice() {
        $price = preg_replace('/[^0-9\.]/', '', $this->xpathScalar("(.//div[contains(@id,'right-content-prod')]//span[@class='price'])[1]"));
        if (empty($price)){
            $price = $this->xpathScalar("(.//meta[@itemprop='price']/@content)[1]");
        }        
        return (float) $price;               
    }

    public function parseOldPrice() {
        return (float) preg_replace('/[^0-9\.]/', '', $this->xpathScalar("(.//div[contains(@id,'right-content-prod')]//span[@class='strike'])[1]"));
    }

    public function parseManufacturer() {
        return $this->xpathScalar(".//div[contains(@class,'product-overview')]//h1//span[@class='presents']");
    }

    public function parseImg() {
        $image = $this->xpathScalar(".//meta[@property='og:image']/@content");
        $image = str_replace('X_130', 'X_450', $image);
        return $image;
    }

    public function parseImgLarge() {
        $image = $this->xpathScalar(".//meta[@property='og:image']/@content");
        $image = str_replace('X_130', 'X_450', $image);
        return $image;
    }

    public function parseExtra() {
        $extra = array();
        return $extra;
    }

    public function isInStock() {
        {
            return true;     
        }
    }

}