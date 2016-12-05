<?php

namespace ContentEgg\application\modules\AE;

use ContentEgg\application\components\AffiliateParserModuleConfig;

/**
 * AEConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class AEConfig extends AffiliateParserModuleConfig {

    public function options()
    {
        $options = array(
            'deeplink' => array(
                'title' => __('Партнеркая ссылка', 'content-egg'),
                'description' => __('Укажите Deeplink одной из CPA-сетей. Для прямых партнерских программ вы можете использовать параметр вида <em>partner_id=12345</em>, или сформируйте партнерскую ссылку по шаблону, например: <em>{{url}}/partner_id-12345/</em>. Пример ссылки с deeplink: https://ad.admitad.com/g/g8f0qmlavfa/?ulp={{url_encoded}}. {{url}} и {{url_encoded}} - будут заменены на URL текущего товара).', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
            'entries_per_page' => array(
                'title' => __('Результатов', 'content-egg'),
                'description' => __('Количество результатов для одного поискового запроса.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 9,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 50,
                        'message' => __('Поле "Результатов" не может быть больше 50.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page_update' => array(
                'title' => __('Результатов для обновления', 'content-egg'),
                'description' => __('Количество результатов для автоматического обновления и автоблоггинга.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 6,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 50,
                        'message' => __('Поле "Результатов" не может быть больше 50.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'save_img' => array(
                'title' => __('Сохранять картинки', 'content-egg'),
                'description' => __('Сохранять картинки на сервер.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
        );

        $parent = parent::options();
        $parent['ttl']['default'] = 4320000;
        $parent['ttl_items']['default'] = 2592000;
        return array_merge($parent, $options);
    }

}
