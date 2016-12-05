<?php

namespace ContentEgg\application\modules\AdmitadProducts;

use ContentEgg\application\components\AffiliateParserModuleConfig;

/**
 * AdmitadProductsConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class AdmitadProductsConfig extends AffiliateParserModuleConfig {

    public function options()
    {
        $optiosn = array(
            'offer_id' => array(
                'title' => __('ID оффера', 'content-egg') . ' ' . '<span class="cegg_required">*</span>',
                'description' => __('Вы можете работать только с офферами, представленными на <a target="_blank" href="https://www.admitadgoods.ru/offers.php">этой странице</a>.', 'content-egg')
                . ' ' . __('ID оффера можно найти в URL, если кликнуть по логотипу оффера.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => __('Поле "ID оффера" не может быть пустым.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'deeplink' => array(
                'title' => 'Deeplink' . ' ' . '<span class="cegg_required">*</span>',
                'description' => __('Deeplink соотвествующего оффера.', 'content-egg')
                . ' ' . __('<a target="_blank" href="http://keywordrush.com/manuals/affegg_manual.pdf">Мануал</a> по настройке Deeplink для различных CPA-сетей.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array($this, 'deeplinkPrepare'),
                        'type' => 'filter'
                    ),
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => __('Поле "Deeplink" не может быть пустым.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page' => array(
                'title' => __('Результатов', 'content-egg'),
                'description' => __('Количество результатов для одного поискового запроса.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 20,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 20,
                        'message' => __('Поле "Результатов" не может быть больше 20.', 'content-egg'),
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
                        'arg' => 20,
                        'message' => __('Поле "Результатов для обновления" не может быть больше 20.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'only_sale' => array(
                'title' => __('Скидка', 'content-egg'),
                'description' => __('Только товары со скидкой.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'price_from' => array(
                'title' => __('Минимальная цена', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
            'price_to' => array(
                'title' => __('Максимальная цена', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
            'save_img' => array(
                'title' => __('Сохранять картинки', 'content-egg'),
                'description' => __('Сохранять картинки на сервер', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'description_size' => array(
                'title' => __('Обрезать описание', 'content-egg'),
                'description' => __('Размер описания в символах (0 - не обрезать)', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '300',
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
        );

        $parent = parent::options();
        $parent['ttl_items']['validator'] = array(
            'trim',
            'absint',
            array(
                'call' => array('\ContentEgg\application\helpers\FormValidator', 'greater_than'),
                'arg' => 86400,
                'message' => sprintf(__('Поле "%s" не может быть меньше %d.', 'content-egg'), __('Обновить товары', 'content-egg'), 86400),
            ),
        );
        $parent['ttl']['validator'] = array(
            'trim',
            'absint',
            array(
                'call' => array('\ContentEgg\application\helpers\FormValidator', 'greater_than'),
                'arg' => 259200,
                'message' => sprintf(__('Поле "%s" не может быть меньше %d.', 'content-egg'), __('Автоматическое обновление', 'content-egg'), 259200),
            ),
        );

        return array_merge($parent, $optiosn);
    }

    public function deeplinkPrepare($deeplink)
    {
        $cpa = array(
            'ad.admitad.com' => 'ulp',
            'modato.ru' => 'ulp', // lamoda admitad?
            'f.gdeslon.ru' => 'goto',
            'cityadspix.com' => 'url',
            'www.cityads.ru' => 'url',
            'epnclick.ru' => 'to',
        );

        $p = parse_url($deeplink);

        if ($p === false || empty($p['host']))
            return $deeplink;

        $host = $p['host'];

        if ($host == 'n.actionpay.ru')
        {
            return str_replace('url=example.com', 'url=', $deeplink);
        }

        if (array_key_exists($host, $cpa))
        {
            $param = $cpa[$host];
            if (!empty($p['query']))
                parse_str($p['query'], $query);
            else
                $query = array();
            if (isset($query[$param]))
                unset($query[$param]);
            $url = $p['scheme'] . '://' . $p['host'] . $p['path'] . '?';
            if ($query)
                $url .= http_build_query($query) . '&';
            $url .= $param . '=';
            return $url;
        }
        return $deeplink;
    }

}
