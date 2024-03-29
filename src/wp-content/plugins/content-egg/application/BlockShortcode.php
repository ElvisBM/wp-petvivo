<?php

namespace ContentEgg\application;

use ContentEgg\application\components\ModuleManager;
use ContentEgg\application\components\BlockTemplateManager;
use ContentEgg\application\components\Shortcoded;
use ContentEgg\application\components\ContentManager;

/**
 * BlockShortcode class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class BlockShortcode {

    const shortcode = 'content-egg-block';

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;
        return self::$instance;
    }

    private function __construct()
    {
        \add_shortcode(self::shortcode, array($this, 'viewData'));
    }

    private function prepareAttr($atts)
    {
        $a = \shortcode_atts(array(
            'modules' => null,
            'template' => '',
            'post_id' => 0,
            'limit' => 0,
            'offset' => 0,
            'next' => 0,
            'title' => '',
                ), $atts);

        $a['next'] = (int) $a['next'];
        $a['limit'] = (int) $a['limit'];
        $a['offset'] = (int) $a['offset'];
        $a['title'] = \sanitize_text_field($a['title']);

        if ($a['modules'])
        {
            $modules = explode(',', $a['modules']);
            $module_ids = array();
            foreach ($modules as $key => $module_id)
            {
                $module_id = trim($module_id);
                if (ModuleManager::getInstance()->isModuleActive($module_id))
                    $module_ids[] = $module_id;
            }
            $a['modules'] = $module_ids;
        } else
            $a['modules'] = array();

        if ($a['template'])
        {
            $a['template'] = BlockTemplateManager::getInstance()->prepareShortcodeTempate($a['template']);
        }
        $a['post_id'] = (int) $a['post_id'];

        return $a;
    }

    public function viewData($atts, $content = "")
    {
        $a = $this->prepareAttr($atts);

        if (empty($a['post_id']))
        {
            global $post;
            $post_id = $post->ID;
        } else
            $post_id = $a['post_id'];

        $tpl_manager = BlockTemplateManager::getInstance();
        if (empty($a['template']) || !$tpl_manager->isTemplateExists($a['template']))
            return;

        if (!$template_file = $tpl_manager->getViewPath($a['template']))
            return '';

        // Get supported modules for this tpl
        $headers = \get_file_data($template_file, array('module_ids' => 'Modules', 'module_types' => 'Module Types', 'shortcoded' => 'Shortcoded'));
        $supported_module_ids = array();
        if ($headers && !empty($headers['module_ids']))
        {
            $supported_module_ids = explode(',', $headers['module_ids']);
            $supported_module_ids = array_map('trim', $supported_module_ids);
        } elseif ($headers && !empty($headers['module_types']))
        {
            $module_types = explode(',', $headers['module_types']);
            $module_types = array_map('trim', $module_types);
            $supported_module_ids = ModuleManager::getInstance()->getParserModuleIdsByTypes($module_types, true);
        }

        if ($headers && !empty($headers['shortcoded']))
        {
            // convert string to boolean
            $a['shortcoded'] = filter_var($headers['shortcoded'], FILTER_VALIDATE_BOOLEAN);
        }

        // Module IDs from shortcode param. Validated.
        if ($a['modules'])
            $module_ids = $a['modules'];
        else
            $module_ids = ModuleManager::getInstance()->getParserModulesIdList(true);

        if ($supported_module_ids)
        {
            $module_ids = array_intersect($module_ids, $supported_module_ids);
        }

        return ModuleViewer::getInstance()->viewBlockData($module_ids, $post_id, $a);
    }

}
