<?php

namespace ContentEgg\application\modules\Pixabay;

use ContentEgg\application\components\ParserModuleConfig;

/**
 * PixabayConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class PixabayConfig extends ParserModuleConfig {

    public function options()
    {
        $optiosn = array(
            'key' => array(
                'title' => 'API Key <span class="cegg_required">*</span>',
                'description' => __('Ключ доступа к Pixabay API. Найти можно <a href="https://pixabay.com/api/docs/">здесь</a> (сначала залогиньтесь в свой аккаунт pixabay).', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => __('Поле "Key" не может быть пустым.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page' => array(
                'title' => __('Результатов', 'content-egg'),
                'description' => __('Количество результатов для одного запроса.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 20,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 200,
                        'message' => __('Поле "Результатов" не может быть больше 200.', 'content-egg'),
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
                        'arg' => 200,
                        'message' => __('Поле "Результатов для автоблоггинга" не может быть больше 200.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'image_size' => array(
                'title' => __('Размер', 'content-egg'),
                'description' => __('Размер изображения по высоте.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '_180' => '180px',
                    '_340' => '340px',
                    '_640' => '640px',
                    '_960' => '960px',
                ),
                'default' => '_640',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'image_type' => array(
                'title' => __('Тип изображения', 'content-egg'),
                'description' => 'A media type to search within.',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'all' => __('Все', 'content-egg'),
                    'photo' => 'Photo',
                    'illustration' => 'Illustration',
                    'vector' => 'Vector',
                ),
                'default' => 'all',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'orientation' => array(
                'title' => __('Ориентация', 'content-egg'),
                'description' => 'Whether an image is wider than it is tall, or taller than it is wide.',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'all' => __('Все', 'content-egg'),
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ),
                'default' => 'all',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'category' => array(
                'title' => __('Категория', 'content-egg'),
                'description' => 'Filter images by category.',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Все', 'content-egg'),
                    'fashion' => 'Fashion',
                    'nature' => 'Nature',
                    'backgrounds' => 'Backgrounds',
                    'science' => 'Science',
                    'education' => 'Education',
                    'people' => 'People',
                    'feelings' => 'Feelings',
                    'religion' => 'Religion',
                    'health' => 'Health',
                    'places' => 'Places',
                    'animals' => 'Animals',
                    'industry' => 'Industry',
                    'food' => 'Food',
                    'computer' => 'Computer',
                    'sports' => 'Sports',
                    'transportation' => 'Transportation',
                    'travel' => 'Travel',
                    'buildings' => 'Buildings',
                    'business' => 'Business',
                    'music' => 'Music',
                ),
                'default' => '',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'editors_choice' => array(
                'title' => __('Выбор редактора', 'content-egg'),
                'description' => "Select images that have received an Editor's Choice award.",
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'safesearch' => array(
                'title' => __('Безопасный поиск', 'content-egg'),
                'description' => 'A flag indicating that only images suitable for all ages should be returned.',
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'order' => array(
                'title' => __('Сортировка', 'content-egg'),
                'description' => 'How the results should be ordered.',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'popular' => 'Popular',
                    'latest' => 'Latest',
                ),
                'default' => 'popular',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'save_img' => array(
                'title' => __('Сохранять картинки', 'content-egg'),
                'description' => __('Сохранять картинки на сервер. Hotlinking не разрешен правилами pixabay API. Ссылки на картинки pixabay будут валидны 24 часа.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => true,
                'section' => 'default',
            ),
        );
        return array_merge(parent::options(), $optiosn);
    }

}
