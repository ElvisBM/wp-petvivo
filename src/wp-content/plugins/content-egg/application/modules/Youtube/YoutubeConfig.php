<?php

namespace ContentEgg\application\modules\Youtube;

use ContentEgg\application\components\ParserModuleConfig;

/**
 * YoutubeConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class YoutubeConfig extends ParserModuleConfig {

    public function options()
    {
        $optiosn = array(
            'api_key' => array(
                'title' => 'API Key <span class="cegg_required">*</span>',
                'description' => __('Ключ для доступа к API. Получить можно в Google <a href="http://code.google.com/apis/console">API консоли</a>', 'content-egg'),
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
                'default' => '5',
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
            'entries_per_page_update' => array(
                'title' => __('Результатов для автоблоггинга', 'content-egg'),
                'description' => __('Количество результатов для автоблоггинга.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 3,
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
            'order' => array(
                'title' => __('Сортировка', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'date' => __('Дата', 'content-egg'),
                    'rating' => __('Рейтинг', 'content-egg'),
                    'relevance' => __('Релевантность', 'content-egg'),
                    'title' => __('Заголовок', 'content-egg'),
                    'viewCount' => __('Просмотры', 'content-egg'),
                ),
                'default' => 'relevance',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'license' => array(
                'title' => __('Тип лицензии', 'content-egg'),
                'description' => __('Многие видео на Youtube загружены с лицензией Creative Commons. <a href="http://www.google.com/support/youtube/bin/answer.py?answer=1284989">Узнать больше</a>.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'any' => __('Любая лицензия', 'content-egg'),
                    'creativeCommon' => __('Сreative Сommons лицензия', 'content-egg'),
                    'youtube' => __('Стандартная лицензия', 'content-egg'),
                ),
                'default' => 'any',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'description_size' => array(
                'title' => __('Обрезать описание', 'content-egg'),
                'description' => __('Размер описания в символах (0 - не обрезать)', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '280',
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
        );
        $parent = parent::options();
        unset($parent['featured_image']);
        return array_merge($parent, $optiosn);
    }

}
