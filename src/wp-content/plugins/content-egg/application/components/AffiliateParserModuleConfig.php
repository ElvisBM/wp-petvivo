<?php

namespace ContentEgg\application\components;

/**
 * ParserModuleConfig abstract class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
abstract class AffiliateParserModuleConfig extends ParserModuleConfig {

    public function options()
    {
        $options = array(
            'ttl' => array(
                'title' => __('Обновление по ключевому слову', 'content-egg'),
                'description' => __('Время жини кэша в секундах, через которое необходимо обновить товары, если задано ключевое слово для обновления. 0 - никогда не обновлять.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 2592000,
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
        );

        if ($this->getModuleInstance()->isItemsUpdateAvailable())
        {
            $options['ttl_items'] = array(
                'title' => __('Обновление цены', 'content-egg'),
                'description' => __('Время в секундах, через которое необходимо обновить цену, наличие и некоторую другую информацию по товарам. 0 - никогда не обновлять.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 604800,
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            );
        }
        $options['update_mode'] = array(
            'title' => __('Режим обновления', 'content-egg'),
            'description' => __('Если вы используете обновление по расписанию, для более надежной работы замените WordPress cron на реальный cron.', 'content-egg'),
            'callback' => array($this, 'render_dropdown'),
            'dropdown_options' => array(
                'visit' => __('При открытии страницы', 'content-egg'),
                'cron' => __('По расписанию (по крону)', 'content-egg'),
                'visit_cron' => __('При открытии страницы и по расписанию', 'content-egg'),
            ),
            'default' => 'visit',
            array(
                'call' => array($this, 'setCron'),
                'message' => __('Ошибка установки cron.', 'content-egg'),
            ),
        );

        return
                array_merge(
                parent::options(), $options
        );
    }

    public function setCron($value)
    {
        return true;
    }

}
