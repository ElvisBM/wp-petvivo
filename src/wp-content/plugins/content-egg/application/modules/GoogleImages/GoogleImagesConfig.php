<?php

namespace ContentEgg\application\modules\GoogleImages;

use ContentEgg\application\components\ParserModuleConfig;

/**
 * GoogleImagesConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class GoogleImagesConfig extends ParserModuleConfig {

    public function options()
    {
        $optiosn = array(
            'license' => array(
                'title' => __('Тип лицензии', 'content-egg'),
                'description' => __('Поиск изображений, которые можно использовать. Подробнее <a href="https://support.google.com/websearch/answer/29508">здесь</a>.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Любая лицензия', 'content-egg'),
                    '(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial|cc_nonderived)' => __('Любая Сreative Сommons', 'content-egg'),
                    '(cc_publicdomain|cc_attribute|cc_sharealike|cc_nonderived).-(cc_noncommercial)' => __('Разрешено коммерческое использование', 'content-egg'),
                    '(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial).-(cc_nonderived)' => __('Разрешено изменение', 'content-egg'),
                    '(cc_publicdomain|cc_attribute|cc_sharealike).-(cc_noncommercial|cc_nonderived)' => __('Коммерческое использование и изменение', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'entries_per_page' => array(
                'title' => __('Результатов', 'content-egg'),
                'description' => __('Количество результатов для одного запроса. Не может быть больше 8.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '8',
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 8,
                        'message' => __('Поле "Результатов" не может быть больше 8.', 'content-egg'),
                    ),
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
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 8,
                        'message' => __('Поле "Результатов для автоблоггинга" не может быть больше 8.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'imgc' => array(
                'title' => __('Цвет', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Любого цвета', 'content-egg'),
                    'gray' => __('Черно-белые', 'content-egg'),
                    'color' => __('Цветные', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
            ),
            'imgcolor' => array(
                'title' => __('Преобладание цвета', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Любой цвет', 'content-egg'),
                    'black' => __('Черный', 'content-egg'),
                    'blue' => __('Синий', 'content-egg'),
                    'brown' => __('Коричневый', 'content-egg'),
                    'gray' => __('Серый', 'content-egg'),
                    'green' => __('Зеленый', 'content-egg'),
                    'orange' => __('Оранжевый', 'content-egg'),
                    'pink' => __('Розовый', 'content-egg'),
                    'purple' => __('Фиолетовый', 'content-egg'),
                    'red' => __('Красный', 'content-egg'),
                    'teal' => __('Бирюзовый', 'content-egg'),
                    'white' => __('Белый', 'content-egg'),
                    'yellow' => __('Желтый', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
            ),
            'imgsz' => array(
                'title' => __('Размер', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Любого размера', 'content-egg'),
                    'icon' => __('Маленькие', 'content-egg'),
                    'small|medium|large|xlarge' => __('Средние', 'content-egg'),
                    'xxlarge' => __('Большие', 'content-egg'),
                    'huge' => __('Огромные', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'imgtype' => array(
                'title' => __('Тип', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Любого размера', 'content-egg'),
                    'face' => __('Лица', 'content-egg'),
                    'photo' => __('Фотографии', 'content-egg'),
                    'clipart' => __('Клип-арт', 'content-egg'),
                    'lineart' => __('Ч/б рисунки', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
            ),
            'safe' => array(
                'title' => __('Безопасный поиск', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'active' => __('Включен', 'content-egg'),
                    'moderate' => __('Модерация', 'content-egg'),
                    'off' => __('Отключен', 'content-egg'),
                ),
                'default' => 'moderate',
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
                'default' => '220',
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
            'as_sitesearch' => array(
                'title' => __('Поиск по сайту', 'content-egg'),
                'description' => __('Ограничить поиск только этим доменом. Например, задайте: photobucket.com', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
        );
        return array_merge(parent::options(), $optiosn);
    }

}
