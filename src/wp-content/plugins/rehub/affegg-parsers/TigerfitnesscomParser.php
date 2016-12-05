<?php

namespace Keywordrush\AffiliateEgg;
/*
 Name: Tigerfitness.com
 URI: https://www.tigerfitness.com
 Icon: http://www.google.com/s2/favicons?domain=tigerfitness.com
 CPA: 
 */

/**
 * TigerfitnesscomParser class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2014 keywordrush.com
 */
class TigerfitnesscomParser extends ShopParser {

    protected $charset = 'utf-8';
    protected $currency = 'USD';

    public function parseCatalog($max) {
        $urls = array_slice($this->xpathArray(".//div[contains(@class,'v-product-grid')]//a[contains(@class,'v-product__title')]/@href"), 0, $max);
        return $urls;
    }

    public function parseTitle() {
        return $this->xpathScalar(".//*[@itemprop='name']");
    }

    public function parseDescription() {
           $results = $this->xpathScalar(".//*[@id='ProductDetail_ProductDetails_div']");           
        return $results;
    }

    public function parsePrice() {
        $price = preg_replace('/[^0-9\.]/', '', $this->xpathScalar(".//div[@class='product_productprice']//span[@itemprop='price']"));
        return (float) $price;               
    }

    public function parseOldPrice() {
        return (float) preg_replace('/[^0-9\.]/', '', $this->xpathScalar(".//div[@class='product_listprice']/b"));
    }

    public function parseManufacturer() {
        return $this->xpathScalar(".//meta[@itemprop='manufacturer']/@content");
    }

    public function parseImg() {
        $img = 'https:'.$this->xpathScalar(".//img[@itemprop='image']/@src");
        return $img;
    }

    public function parseImgLarge() {
        $img = 'https:'.$this->xpathScalar(".//a[@id='product_photo_zoom_url']/@href");
        return $img;
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