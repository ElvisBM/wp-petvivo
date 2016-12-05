<?php

namespace ContentEgg\application\components;

use ContentEgg\application\helpers\TextHelper;

/**
 * TemplateManager class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
abstract class TemplateManager {

    private $templates = null;
    private $last_render_data;

    abstract public function getTempatePrefix();

    abstract public function getTempateDir();

    abstract public function getCustomTempateDirs();

    public function getTemplatesList($short_mode = false)
    {
        $prefix = $this->getTempatePrefix();
        if ($this->templates === null)
        {
            $templates = array();
            foreach ($this->getCustomTempateDirs() as $dir)
            {
                $templates = array_merge($templates, $this->scanTemplates($dir, $prefix, true));
            }
            $templates = array_merge($templates, $this->scanTemplates($this->getTempateDir(), $prefix, false));
            $this->templates = $templates;
        }

        if ($short_mode)
        {
            $list = array();
            foreach ($this->templates as $id => $name)
            {
                $custom = '';
                if (self::isCustomTemplate($id))
                {
                    $parts = explode('/', $id);
                    $custom = 'custom/';
                    $id = $parts[1];
                }

                // del prefix
                $list[$custom . substr($id, strlen($prefix))] = $name;
            }
            return $list;
        }

        return $this->templates;
    }

    private function scanTemplates($path, $prefix, $custom = false)
    {
        if ($custom && !is_dir($path))
            return array();

        $tpl_files = glob($path . '/' . $prefix . '*.php');
        if (!$tpl_files)
            return array();

        $templates = array();
        foreach ($tpl_files as $file)
        {
            $template_id = basename($file, '.php');
            if ($custom)
                $template_id = 'custom/' . $template_id;

            $data = \get_file_data($file, array('name' => 'Name'));
            if ($data && !empty($data['name']))
                $templates[$template_id] = strip_tags($data['name']);
            else
                $templates[$template_id] = $template_id;
            if ($custom)
                $templates[$template_id] .= ' ' . __('[пользовательский]', 'content-egg');
        }
        return $templates;
    }

    public function render($view_name, array $_data = array())
    {
        $file = $this->getViewPath($view_name);
        if (!$file)
            return '';

        $this->last_render_data = $_data;
        extract($_data, EXTR_PREFIX_SAME, 'data');

        ob_start();
        ob_implicit_flush(false);
        include $file;
        $res = ob_get_clean();
        return $res;
    }

    public function renderPartial($view_name, array $_data = array(), $block = false)
    {
        $file = \ContentEgg\PLUGIN_PATH . 'application/templates/';
        if ($block)
            $file .= 'blocks/';
        else
            $file .= $this->getTempatePrefix();
        $file .= $view_name . '.php';

        if (!$file)
            return '';
        $_data = array_merge($this->last_render_data, $_data);
        extract($_data, EXTR_PREFIX_SAME, 'data');
        include $file;
    }

    public function renderBlock($view_name, array $data = array())
    {
        $this->renderPartial($view_name, $data, true);
    }

    public function getViewPath($view_name)
    {
        $view_name = str_replace('.', '', $view_name);
        if (substr($view_name, 0, 7) == 'custom/')
        {
            $view_name = substr($view_name, 7);
            foreach ($this->getCustomTempateDirs() as $custom_dir)
            {
                $tpl_path = $custom_dir;
                $file = $tpl_path . DIRECTORY_SEPARATOR . TextHelper::clear($view_name) . '.php';
                if (is_file($file) && is_readable($file))
                    return $file;
            }
            return false;
        } else
        {
            $tpl_path = $this->getTempateDir();
            $file = $tpl_path . DIRECTORY_SEPARATOR . TextHelper::clear($view_name) . '.php';
            if (is_file($file) && is_readable($file))
                return $file;
            else
                return false;
        }
    }

    public function getFullTemplateId($short_id)
    {
        $prefix = $this->getTempatePrefix();
        $custom = '';
        if (self::isCustomTemplate($short_id))
        {
            $parts = explode('/', $short_id);
            $custom = 'custom/';
            $id = $parts[1];
        } else
            $id = $short_id;

        // check _data prefix
        if (substr($id, 0, strlen($prefix)) != $prefix)
        {
            $id = $prefix . $id;
        }
        return $custom . $id;
    }

    public static function isCustomTemplate($template_id)
    {
        if (substr($template_id, 0, 7) == 'custom/')
            return true;
        else
            return false;
    }

    public function isTemplateExists($tpl)
    {
        return array_key_exists($tpl, $this->getTemplatesList());
    }

    public function prepareShortcodeTempate($template)
    {
        if (self::isCustomTemplate($template))
        {
            $is_custom = true;
            // del 'custom/' prefix
            $template = substr($template, 7);
        } else
            $is_custom = false;

        $template = TextHelper::clear($template);
        if ($is_custom)
            $template = 'custom/' . $template;
        if ($template)
            $template = $this->getFullTemplateId($template);

        return $template;
    }

}
