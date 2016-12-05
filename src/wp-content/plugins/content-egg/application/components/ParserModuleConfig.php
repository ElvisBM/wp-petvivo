<?php

namespace ContentEgg\application\components;

/**
 * ParserModuleConfig abstract class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
abstract class ParserModuleConfig extends ModuleConfig {

    public function options()
    {
        $tpl_manager = ModuleTemplateManager::getInstance($this->module_id);
        $options = array(
            'is_active' => array(
                'title' => __('Включить модуль', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_checkbox'),
                'default' => 0,
                'section' => 'default',
            ),
            'embed_at' => array(
                'title' => __('Добавить', 'content-egg'),
                'description' => __('Куда добавить контент этого модуля? Шорткоды работают всегда в независимости от настройки.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'post_bottom' => __('В конец поста', 'content-egg'),
                    'post_top' => __('В начало поста', 'content-egg'),
                    'shortcode' => __('Только шорткоды', 'content-egg'),
                ),
                'default' => 'post_bottom',
                'section' => 'default',
            ),
            'priority' => array(
                'title' => __('Приоритет', 'content-egg'),
                'description' => __('Приоритет задает порядок включения модулей в пост. 0 - самый высокий приоритет.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 10,
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
            'template' => array(
                'title' => __('Шаблон', 'content-egg'),
                'description' => __('Шаблон по-умолчанию.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => $tpl_manager->getTemplatesList(),
                'default' => $this->getModuleInstance()->defaultTemplateName(),
                'section' => 'default',
            ),
            'tpl_title' => array(
                'title' => __('Заголовок', 'content-egg'),
                'description' => __('Шаблоны могут использовать заголовок при выводе данных.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
            'featured_image' => array(
                'title' => 'Featured image',
                'description' => __('Автоматически установить Featured image для поста.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Не устанавливать', 'content-egg'),
                    'first' => __('Первый элемент', 'content-egg'),
                    'second' => __('Второй элемент', 'content-egg'),
                    'rand' => __('Случайный элемент', 'content-egg'),
                    'last' => __('Последний элемент', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
            ),
            'set_local_redirect' => array(
                'title' => __('Редирект', 'content-egg'),
                'description' => __('Ссылки через локальный 301 редирект.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => 0,
                'section' => 'default',
            ),
        );

        return
                array_merge(
                parent::options(), $options
        );
    }

}
