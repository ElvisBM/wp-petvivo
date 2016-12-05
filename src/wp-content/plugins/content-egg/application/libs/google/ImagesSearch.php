<?php

namespace ContentEgg\application\libs\google;

use ContentEgg\application\libs\RestClient;

/**
 * ImagesSearch class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 * 
 * @link: https://developers.google.com/youtube/v3/docs/search/list
 *
 */
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'RestClient.php';

class ImagesSearch extends RestClient {

    const API_URI_BASE = 'https://ajax.googleapis.com/ajax/services/search';
    const API_VERSION = '1.0';

    /**
     * @var array Response Format Types
     */
    protected $_responseTypes = array(
        'atom',
        'json',
    );

    /**
     * Constructor
     * @param  string $responseType
     */
    public function __construct($responseType = 'json')
    {
        $this->setResponseType($responseType);
        $this->setUri(self::API_URI_BASE);
    }

    public function search($query, array $params = array())
    {
        $_query = array();
        $_query['v'] = self::API_VERSION;
        $_query['q'] = $query;

        foreach ($params as $key => $param)
        {
            switch ($key)
            {
                case 'as_filetype':
                case 'as_rights':
                case 'as_sitesearch':
                case 'hl':
                case 'imgc':
                case 'imgcolor':
                case 'imgsz':
                case 'imgtype':
                case 'restrict':
                case 'safe':
                case 'start':
                case 'userip':
                    $_query[$key] = $param;
                    break;
                case 'rsz':
                    $_query[$key] = ((int) $param > 8) ? 8 : (int) $param;
                    break;
            }
        }
        $response = $this->restGet('/images', $_query);
        return $this->_decodeResponse($response);
    }

}
