<?php

namespace ContentEgg\application\components;

use ContentEgg\application\helpers\ImageHelper;

/**
 * AffiliateParserModule abstract class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
abstract class AffiliateParserModule extends ParserModule {

    final public function isAffiliateParser()
    {
        return true;
    }

    public function isItemsUpdateAvailable()
    {
        return false;
    }

    public function doRequestItems(array $items)
    {
        throw new \Exception('doRequestItems method not implemented yet');
    }

    public function presavePrepare($data, $post_id)
    {
        $data = parent::presavePrepare($data, $post_id);
        foreach ($data as $key => $item)
        {
            if (!isset($item['percentageSaved']))
                $item['percentageSaved'] = 0;
            if (!isset($item['priceOld']))
                $item['priceOld'] = 0;
            if ($item['priceOld'] && $item['price'] && $item['price'] < $item['priceOld'])
            {
                $data[$key]['percentageSaved'] = floor(((float) $item['priceOld'] - (float) $item['price']) / (float) $item['priceOld'] * 100);
            }
        }
        return $data;
    }

}
