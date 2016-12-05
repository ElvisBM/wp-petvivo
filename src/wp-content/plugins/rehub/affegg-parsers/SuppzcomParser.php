<?php

namespace Keywordrush\AffiliateEgg;
/*
 Name: Suppz.com
 URI: http://suppz.com
 Icon: http://www.google.com/s2/favicons?domain=suppz.com
 CPA: 
 */

/**
 * SuppzcomParser class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2014 keywordrush.com
 */
class SuppzcomParser extends ShopParser {

    protected $charset = 'utf-8';
    protected $currency = 'USD';

    public function parseCatalog($max) {
        $urls = array_slice($this->xpathArray(".//div[contains(@class,'category-products')]//h2[@class='product-name']/a/@href"), 0, $max);
        return $urls;
    }

    public function parseTitle() {
        return $this->xpathScalar(".//h1[@itemprop='name']");
    }

    public function parseDescription() {
           $results = $this->xpathScalar(".//div[@id='tab_description_tabbed_contents']//div[contains(@class,'std')]");           
        return $results;
    }

    public function parsePrice() {
        $price = preg_replace('/[^0-9\.]/', '', $this->xpathScalar(".//div[@class='product-info']//meta[@itemprop='price']/@content"));
        return (float) $price;               
    }

    public function parseOldPrice() {
        return (float) preg_replace('/[^0-9\.]/', '', $this->xpathScalar(".//div[@class='product-info']//p[@class='old-price']/span[@class='price']"));
    }

    public function parseManufacturer() {
        return;
    }

    public function parseImg() {
        return $this->xpathScalar(".//img[@class='etalage_thumb_image']/@src");
    }

    public function parseImgLarge() {
        return $this->xpathScalar(".//img[@class='etalage_thumb_image']/@src");
    }

    public function parseExtra() {
        $extra = array();
        return $extra;
    }

    public function isInStock() {
        {
            $in_stock = trim(strip_tags($this->xpathScalar(".//div[@class='product-info']//p[contains(@class,'in-stock')]/span")));
            if ($in_stock == 'In Stock')
                return true;
            else
                return false;       
        }
    }

}