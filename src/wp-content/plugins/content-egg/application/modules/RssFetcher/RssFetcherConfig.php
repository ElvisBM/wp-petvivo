<?php

namespace ContentEgg\application\modules\RssFetcher;

use ContentEgg\application\components\ParserModuleConfig;

/**
 * RssFetcherConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class RssFetcherConfig extends ParserModuleConfig {

    public function options()
    {
        $optiosn = array(
            'uri' => array(
                'title' => 'RSS URL <span class="cegg_required">*</span>',
                'description' => __('Для подстановки текущего ключевого слова используйте <em>%KEYWORD%</em>.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 'http://www.bing.com/search?format=rss&FORM=RSRE&q=%KEYWORD%',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => __('Поле "RSS URL" не может быть пустым.', 'content-egg'),
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
                        'message' => __('Поле "Результатов" не может быть больше 50.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page_update' => array(
                'title' => __('Результатов для автоблоггинга', 'content-egg'),
                'description' => __('Количество результатов для автоблоггинга.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 5,
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
            'allowed_tags' => array(
                'title' => __('Разрешенные теги', 'content-egg'),
                'description' => __('Теги, которые разрешены в title и description.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '<p><br><img>',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
        );
        $parent = parent::options();
        unset($parent['featured_image']);
        return array_merge($parent, $optiosn);
    }

}
