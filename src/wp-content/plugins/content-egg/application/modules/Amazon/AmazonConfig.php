<?php

namespace ContentEgg\application\modules\Amazon;

use ContentEgg\application\components\AffiliateParserModuleConfig;
use ContentEgg\application\admin\GeneralConfig;

/**
 * AmazonConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class AmazonConfig extends AffiliateParserModuleConfig {

    public function options()
    {
        $options = array(
            'access_key_id' => array(
                'title' => 'Access Key ID <span class="cegg_required">*</span>',
                'description' => __('Специальный ключ для доступа к Amazon API.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => __('Поле "Access Key ID" не может быть пустым.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'secret_access_key' => array(
                'title' => 'Secret Access Key <span class="cegg_required">*</span>',
                'description' => __('Еще один специальный ключ для доступа к Amazon API.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => __('Поле "Secret Access Key" не может быть пустым.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'associate_tag' => array(
                'title' => __('Tracking ID по-умолчанию', 'content-egg') . ' <span class="cegg_required">*</span>',
                'description' => __('Связь с вашим аккаунтом в партнерской программе. Чтобы получать комиссию от продаж, правильно укажите этот параметр.', 'content-egg') . ' ' .
                __('Tracking ID должен соотвествовать установке локали по-умолчанию.', 'content-egg') . ' ' .
                __('Ниже вы можете задать значения Tracking ID для остальных локалей, если хотите добавить товары более чем с одной локали.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => __('Поле "Tracking ID" не может быть пустым.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'locale' => array(
                'title' => __('Локаль по-умолчанию', 'content-egg'),
                'description' => __('Локаль/сайт amazon. Для каждой локали необходима отдельная регистрация в соответствующей партнерской программе.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => self::getLocalesList(),
                'default' => self::getDefaultLocale(),
                'section' => 'default',
            ),
            'entries_per_page' => array(
                'title' => __('Результатов', 'content-egg'),
                'description' => __('Количество результатов для одного поискового запроса.', 'content-egg') . ' ' .
                __('Получение более 10 результатов потребует дополнительное время на запрос данных.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 10,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 50, // The value you specified for ItemPage is invalid. Valid values must be between 1 and 5.
                        'message' => __('Поле "Результатов" не может быть больше 50.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page_update' => array(
                'title' => __('Результатов для обновления', 'content-egg'),
                'description' => __('Количество результатов для автоматического обновления и автоблоггинга.', 'content-egg') . ' ' .
                __('Получение более 10 результатов потребует дополнительное время на запрос данных.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 3,
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
            'link_type' => array(
                'title' => __('Вид ссылок', 'content-egg'),
                'description' => __('Вид партнерских ссылок. Узнайте больше про amazon <a target="_blank" href="https://affiliate-program.amazon.com/gp/associates/help/t2/a11">90 day cookie</a>.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'product' => 'Product page',
                    'add_to_cart' => 'Add to cart',
                ),
                'default' => 'product',
                'section' => 'default',
            ),
            'search_index' => array(
                'title' => __('Категория для поиска', 'content-egg'),
                'description' => __('Список категорий для US Amazon. Для локальных филиалов некоторые категории могут быть недоступны. Если Вы не зададите категорию для поиска, то никакие другие опции фильтрации кроме поиска по ключевому слову (например, минимальная цена или сортировка) работать не будут.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array('All' => '[ All ]', 'Blended' => '[ Blended ]', 'Music' => '[ Music ]', 'Video' => '[ Video ]', 'Apparel' => 'Apparel', 'Automotive' => 'Automotive', 'Baby' => 'Baby', 'Beauty' => 'Beauty', 'Books' => 'Books', 'Classical' => 'Classical', 'DigitalMusic' => 'DigitalMusic', 'DVD' => 'DVD', 'Electronics' => 'Electronics', 'GourmetFood' => 'GourmetFood', 'Grocery' => 'Grocery', 'HealthPersonalCare' => 'HealthPersonalCare', 'HomeGarden' => 'HomeGarden', 'Industrial' => 'Industrial', 'Jewelry' => 'Jewelry', 'KindleStore' => 'KindleStore', 'Kitchen' => 'Kitchen', 'Magazines' => 'Magazines', 'Merchants' => 'Merchants', 'Miscellaneous' => 'Miscellaneous', 'MP3Downloads' => 'MP3Downloads', 'MusicalInstruments' => 'MusicalInstruments', 'MusicTracks' => 'MusicTracks', 'OfficeProducts' => 'OfficeProducts', 'OutdoorLiving' => 'OutdoorLiving', 'PCHardware' => 'PCHardware', 'PetSupplies' => 'PetSupplies', 'Photo' => 'Photo', 'Shoes' => 'Shoes', 'Software' => 'Software', 'SportingGoods' => 'SportingGoods', 'Tools' => 'Tools', 'Toys' => 'Toys', 'UnboxVideo' => 'UnboxVideo', 'VHS' => 'VHS', 'VideoGames' => 'VideoGames', 'Watches' => 'Watches', 'Wireless' => 'Wireless', 'WirelessAccessories' => 'WirelessAccessories'),
                'default' => 'All',
                'section' => 'default',
            ),
            'sort' => array(
                'title' => __('Порядок сортировки', 'content-egg'),
                'description' => __('Варианты сортировки зависят от locale и выбранной категории. Список доступных значений можно найти <a href="http://docs.amazonwebservices.com/AWSECommerceService/latest/DG/index.html?APPNDX_SortValuesArticle.html">здесь</a>.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
            'brouse_node' => array(
                'title' => __('Brouse node', 'content-egg'),
                'description' => __('Целочисленное ID "узла" на amazon. Поиск будет произведен только в этом "узле".', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
            'title' => array(
                'title' => __('Поиск в названии', 'content-egg'),
                'description' => __('Поиск будет произведет только по названиям товаров.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'merchant_id' => array(
                'title' => __('Только Amazon', 'content-egg'),
                'description' => __('Выбрать товары, которые продает Amazon. Другие продавцы исключаются из поиска.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'minimum_price' => array(
                'title' => __('Минимальная цена', 'content-egg'),
                'description' => __('Например, 8.99', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
            'maximum_price' => array(
                'title' => __('Максимальная цена', 'content-egg'),
                'description' => __('Например, 98.50', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'section' => 'default',
            ),
            'min_percentage_off' => array(
                'title' => __('Минимальная скидка', 'content-egg'),
                'description' => __('Выбрать товары со скидкой. Обязательно должна быть задана категория. Обратите внимание, эта опция работает не для всех категорий.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Неважно', 'content-egg'),
                    '5%' => '5%',
                    '10%' => '10%',
                    '15%' => '15%',
                    '20%' => '20%',
                    '25%' => '25%',
                    '30%' => '30%',
                    '35%' => '35%',
                    '40%' => '40%',
                    '45%' => '45%',
                    '50%' => '50%',
                    '60%' => '60%',
                    '70%' => '70%',
                    '80%' => '80%',
                    '90%' => '90%',
                    '95%' => '95%',
                ),
                'default' => '',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'customer_reviews' => array(
                'title' => __('Отзывы покупателей', 'content-egg'),
                'description' => __('Получить отзывы покупателей. Отзывы будут показаны в iframe. iframe URL валидный 24 часа, используйте функцию автообноления, чтобы держать URL в актуальном состоянии.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            /*
              'customer_reviews_iframe' => array(
              'title' => __('Отзывы в iframe.', 'content-egg'),
              'description' => __('Показывать отзывы покупателей в iframe с amazon (отключение этой опции, возможно, нарушает правила партнерской программы amazon).', 'content-egg'),
              'callback' => array($this, 'render_checkbox'),
              'default' => true,
              'section' => 'default',
              ),
             */
            'truncate_reviews_at' => array(
                'title' => __('Обрезать отзывы', 'content-egg'),
                'description' => __('Количество символов для одного отзыва. 0 - максимально возможная длина текста.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 500,
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
            /*
              'review_products_number' => array(
              'title' => __('Товар с отзывами', 'content-egg'),
              'description' => __('Отзывы только для заданного количества товаров.', 'content-egg'),
              'callback' => array($this, 'render_input'),
              'default' => 1,
              'validator' => array(
              'trim',
              'absint',
              ),
              'section' => 'default',
              ),
             * 
             */
            'editorial_reviews' => array(
                'title' => __('Парсить отписание', 'content-egg'),
                'description' => __('Парсить описание товаров от продавца.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'editorial_reviews_type' => array(
                'title' => __('Вид описания', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'allow_all' => __('Как на Amazon', 'content-egg'),
                    'safe_html' => __('Безопасный HTML', 'content-egg'),
                    'allowed_tags' => __('Только разрешенные теги HTML', 'content-egg'),
                    'text' => __('Только текст', 'content-egg'),
                ),
                'default' => 'All',
                'section' => 'default',
            ),
            'editorial_reviews_size' => array(
                'title' => __('Размер описания', 'content-egg'),
                'description' => __('Максимальный размер описания товара. 0 - не обрезать.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 1000,
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
            'https_img' => array(
                'title' => __('Картинки через https', 'content-egg'),
                'description' => __('Перезаписать адреса картинок через https протокол. Включите эту опцию, если вы используете SSL сертификат на своем домене.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'save_img' => array(
                'title' => __('Сохранять картинки', 'content-egg'),
                'description' => __('Сохранять картинки на сервер.', 'content-egg') . ' ' . __('Включение этой опции возможно нарушает правила API. Используйте на свой страх и риск.', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
        );

        foreach (self::getLocalesList() as $locale_id => $locale_name)
        {
            $options['associate_tag_' . $locale_id] = array(
                'title' => sprintf(__('Tracking ID для %s локали', 'content-egg'), $locale_name),
                'description' => __('Задайте, если хотите добавлять товары с соответствующего amazon сайта (локали).', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
                'metaboxInit' => true,
            );
        }

        $parent = parent::options();
        $parent['ttl_items']['default'] = 86400;
        return array_merge($parent, $options);
    }

    public static function getLocalesList()
    {
        return array('us' => 'US', 'uk' => 'UK', 'de' => 'DE', 'jp' => 'JP', 'cn' => 'CN', 'fr' => 'FR', 'it' => 'IT', 'es' => 'ES', 'ca' => 'CA', 'br' => 'BR', 'in' => 'IN');
    }

    public static function getDefaultLocale()
    {
        $lang = GeneralConfig::getInstance()->option('lang');
        if (array_key_exists($lang, self::getLocalesList()))
            return $lang;
        else
            return 'us';
    }

    public static function getActiveLocalesList()
    {
        $locales = self::getLocalesList();
        $active = array();

        $default = self::getInstance()->option('locale');
        $active[$default] = $locales[$default];

        foreach ($locales as $locale => $name)
        {
            if ($locale == $default)
                continue;
            if (self::getInstance()->option('associate_tag_' . $locale))
                $active[$locale] = $name;
        }
        return $active;
    }

    public static function getDomainByLocale($locale)
    {
        $domains = array(
            'us' => 'amazon.com',
            'uk' => 'amazon.co.uk',
            'de' => 'amazon.de',
            'jp' => 'amazon.jp',
            'cn' => 'amazon.cn',
            'fr' => 'amazon.fr',
            'it' => 'amazon.it',
            'es' => 'amazon.es',
            'ca' => 'amazon.ca',
            'br' => 'amazon.br',
            'in' => 'amazon.in',
        );
        if (isset($domains[$locale]))
            return $domains[$locale];
        else
            return 'amazon.com';
    }

}
