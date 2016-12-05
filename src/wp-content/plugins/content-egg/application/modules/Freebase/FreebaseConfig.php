<?php

namespace ContentEgg\application\modules\Freebase;

use ContentEgg\application\components\ParserModuleConfig;

/**
 * FreebaseConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class FreebaseConfig extends ParserModuleConfig {

    public function options()
    {
        $optiosn = array(
            'api_key' => array(
                'title' => 'API Key <span class="cegg_required">*</span>',
                'description' => __('Ключ для доступа к API. Получить можно в Google <a href="http://code.google.com/apis/console">API консоли</a>.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => __('Поле "API Key" не может быть пустым.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page' => array(
                'title' => __('Результатов', 'content-egg'),
                'description' => __('Количество результатов для одного запроса', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 3,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 10,
                        'message' => __('Поле "Результатов" не может быть больше 10.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page_update' => array(
                'title' => __('Результатов для автоблоггинга', 'content-egg'),
                'description' => __('Количество результатов для автоблоггинга.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 1,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 10,
                        'message' => __('Поле "Результатов для автоблоггинга" не может быть больше 10.', 'content-egg'),
                    ),
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
                'default' => '800',
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
        );
        return array_merge(parent::options(), $optiosn);
    }

}
