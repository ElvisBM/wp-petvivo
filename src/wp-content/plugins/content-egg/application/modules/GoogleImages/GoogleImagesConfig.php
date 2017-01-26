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
                'title' => __('Type of license', 'content-egg'),
                'description' => __('Searching of images, which you can use. More about, <a href="https://support.google.com/websearch/answer/29508">here</a>.', 'content-egg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Any license', 'content-egg'),
                    '(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial|cc_nonderived)' => __('Any Creative Commons', 'content-egg'),
                    '(cc_publicdomain|cc_attribute|cc_sharealike|cc_nonderived).-(cc_noncommercial)' => __('With Allow of commercial use', 'content-egg'),
                    '(cc_publicdomain|cc_attribute|cc_sharealike|cc_noncommercial).-(cc_nonderived)' => __('Allowed change', 'content-egg'),
                    '(cc_publicdomain|cc_attribute|cc_sharealike).-(cc_noncommercial|cc_nonderived)' => __('Commercial use and change', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'entries_per_page' => array(
                'title' => __('Results', 'content-egg'),
                'description' => __('Number of results for one query. Can not be more than 8.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '8',
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 8,
                        'message' => __('The "Results" can not be more than 8.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'entries_per_page_update' => array(
                'title' => __('Results for autoblogging ', 'content-egg'),
                'description' => __('Number of results for autoblogging.', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => 3,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\ContentEgg\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 8,
                        'message' => __('Field "Results for autoblogging" can not be more than 8.', 'content-egg'),
                    ),
                ),
                'section' => 'default',
            ),
            'imgc' => array(
                'title' => __('Color', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Any color', 'content-egg'),
                    'gray' => __('Black and white', 'content-egg'),
                    'color' => __('Colored', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
            ),
            'imgcolor' => array(
                'title' => __('Predominance of the color', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Any color', 'content-egg'),
                    'black' => __('Black', 'content-egg'),
                    'blue' => __('Blue', 'content-egg'),
                    'brown' => __('Brown', 'content-egg'),
                    'gray' => __('Gray', 'content-egg'),
                    'green' => __('Green', 'content-egg'),
                    'orange' => __('Orange', 'content-egg'),
                    'pink' => __('Pink', 'content-egg'),
                    'purple' => __('Purple', 'content-egg'),
                    'red' => __('Red', 'content-egg'),
                    'teal' => __('Turquoise', 'content-egg'),
                    'white' => __('White', 'content-egg'),
                    'yellow' => __('Yellow', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
            ),
            'imgsz' => array(
                'title' => __('Size', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Any size', 'content-egg'),
                    'icon' => __('Small', 'content-egg'),
                    'small|medium|large|xlarge' => __('Medium', 'content-egg'),
                    'xxlarge' => __('Large', 'content-egg'),
                    'huge' => __('Huge', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
                'metaboxInit' => true,
            ),
            'imgtype' => array(
                'title' => __('Type', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '' => __('Any size', 'content-egg'),
                    'face' => __('Faces', 'content-egg'),
                    'photo' => __('Photo', 'content-egg'),
                    'clipart' => __('Clip-art', 'content-egg'),
                    'lineart' => __('B/w pictures', 'content-egg'),
                ),
                'default' => '',
                'section' => 'default',
            ),
            'safe' => array(
                'title' => __('Safe search', 'content-egg'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'active' => __('Included', 'content-egg'),
                    'moderate' => __('Moderation', 'content-egg'),
                    'off' => __('Disabled', 'content-egg'),
                ),
                'default' => 'moderate',
                'section' => 'default',
            ),
            'save_img' => array(
                'title' => __('Save images', 'content-egg'),
                'description' => __('Save images on server', 'content-egg'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'description_size' => array(
                'title' => __('Trim description', 'content-egg'),
                'description' => __('Description size in characters (0 - do not cut)', 'content-egg'),
                'callback' => array($this, 'render_input'),
                'default' => '220',
                'validator' => array(
                    'trim',
                    'absint',
                ),
                'section' => 'default',
            ),
            'as_sitesearch' => array(
                'title' => __('Search', 'content-egg'),
                'description' => __('Limit search to only that domain. For example ask: photobucket.com', 'content-egg'),
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
