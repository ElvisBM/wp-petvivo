<?php

namespace Keywordrush\AffiliateEgg;
/*
 Name: Jabong.com
 URI: http://www.jabong.com
 Icon: http://www.google.com/s2/favicons?domain=jabong.com
 CPA: 
 */

/**
 * JabongcomParser class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2014 keywordrush.com
 */
class JabongcomParser extends ShopParser {

    protected $charset = 'utf-8';
    protected $currency = 'INR';

    public function parseCatalog($max) {
        $urls = array_slice($this->xpathArray(".//section[contains(@class,'search-product')]//div[contains(@class,'product-tile')]/a/@href"), 0, $max);
        foreach ($urls as $key => $url)
        {
            if (!preg_match('/^http:/', $url))
            $urls[$key] = 'http://www.jabong.com/' . $url;
        }
        return $urls;
    }

    public function parseTitle() {
        return $this->xpathScalar(".//*[@class='content']//span[@itemprop='name']");
    }

    public function parseDescription() {
           $results = $this->xpathScalar(".//*[@itemprop='description']");           
        return $results;
    }

    public function parsePrice() {
        $price = preg_replace('/[^0-9]/', '', $this->xpathScalar(".//*[@itemprop='offers']//span[@itemprop='price']"));
        return (float) $price;               
    }

    public function parseOldPrice() {
        return (float) preg_replace('/[^0-9]/', '', $this->xpathScalar(".//*[@itemprop='offers']//span[contains(@class,'standard-price')]"));
    }

    public function parseManufacturer() {
        return $this->xpathScalar(".//*[@class='content']//span[@itemprop='brand']");
    }

    public function parseImg() {
        return $this->xpathScalar(".//meta[@property='og:image']/@content");
    }

    public function parseImgLarge() {
        return $this->xpathScalar(".//meta[@property='og:image']/@content");       
    }

    public function parseExtra() {
        $extra = array();

        $extra['features'] = array();

        $names = $this->xpathArray(".//ul[contains(@class,'prod-main-wrapper')]/li/label");
        $values = $this->xpathArray(".//ul[contains(@class,'prod-main-wrapper')]/li/span");
        $feature = array();
        for ($i = 0; $i < count($names); $i++) {
            if (!empty($values[$i]) && $names[$i] != 'Condition:' && $names[$i] != 'Brand') {
                $feature['name'] = str_replace(":", "", $names[$i]);
                $feature['value'] = $values[$i];
                $extra['features'][] = $feature;
            }
        }            
        
        $extra['images'] = array();
        $results = $this->xpathArray("(.//*[contains(@class,'product-details')]//img[@itemprop='image']/@data-src-500)[position() >=2]");
        if (empty($results)){
            $results = $this->xpathScalar("(.//div[contains(@class,'slide')]/img[contains(@class,'primary-image')]/@src)[position() >=2]");
        }
        foreach ($results as $i => $res) {
            if ($i == 0)
                continue;
            if ($res) {
                $extra['images'][] = $res;
            }
        }
        return $extra;
    }

    public function isInStock() {
        {
            $in_stock = trim(strip_tags($this->xpathScalar(".//*[@itemprop='availability']/@content")));
            if ($in_stock == 'In Stock')
                return true;
            else
                return false;       
        }
    }

}