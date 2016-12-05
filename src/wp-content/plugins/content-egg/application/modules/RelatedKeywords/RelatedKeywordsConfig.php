<?php

namespace ContentEgg\application\modules\RelatedKeywords;

use ContentEgg\application\components\ParserModuleConfig;

/**
 * RelatedKeywordsConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class RelatedKeywordsConfig extends ParserModuleConfig {

    public function options()
    {
        $optiosn = array(
            'account_key' => array(
                'title' => 'Account Key <span class="cegg_required">*</span>',
                'description' => __('Ключ доступа к Bing API. Получить можно <a href="https://datamarket.azure.com/account/keys">здесь</a> (потребуется аккаунт в bing).', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => __('Поле "Account Key" не может быть пустым.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page' => array(
                'title' => __('Результатов', 'content-egg'),
                'description' => __('Количество результатов для одного запроса', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 10,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 50,
                        'message' => __('Поле "Результатов" не может быть больше 5ы0.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page_update' => array(
                'title' => __('Результатов для автоблоггинга', 'content-egg'),
                'description' => __('Количество результатов для автоблоггинга.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 6,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 50,
                        'message' => __('Поле "Результатов для автоблоггинга" не может быть больше 50.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
        );
        $parent = parent::options();
        unset($parent['featured_image']);
        return array_merge($parent, $optiosn);
    }

}
