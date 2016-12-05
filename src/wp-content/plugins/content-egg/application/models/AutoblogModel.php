<?php

namespace ContentEgg\application\models;

use ContentEgg\application\components\ModuleManager;
use ContentEgg\application\components\ContentManager;
use ContentEgg\application\helpers\TextHelper;
use ContentEgg\application\components\FeaturedImage;
use ContentEgg\application\helpers\TemplateHelper;

/**
 * AutoblogModel class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class AutoblogModel extends Model {

    const INACTIVATE_AFTER_ERR_COUNT = 5;

    public function tableName()
    {
        return $this->getDb()->prefix . 'cegg_autoblog';
    }

    public function getDump()
    {

        return "CREATE TABLE " . $this->tableName() . " (
                    id int(11) unsigned NOT NULL auto_increment,
                    create_date datetime NOT NULL,
                    last_run datetime NOT NULL default '0000-00-00 00:00:00',
                    status tinyint(1) DEFAULT '0',
                    name varchar(200) DEFAULT NULL,
                    run_frequency int(11) NOT NULL,                    
                    keywords_per_run tinyint(3) NOT NULL,
                    post_status tinyint(1) DEFAULT '0',
                    user_id int(11) DEFAULT NULL,
                    post_count int(11) DEFAULT '0',
                    min_modules_count int(11) DEFAULT '0',
                    template_body text,
                    template_title text,
                    keywords text,
                    include_modules text,
                    exclude_modules text,
                    required_modules text,
                    autoupdate_modules text,
                    last_error varchar(255) DEFAULT NULL,
                    category int(11) DEFAULT NULL,
                    PRIMARY KEY  (id),
                    KEY last_run (status,last_run,run_frequency)
                    ) $this->charset_collate;";
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => __('Название', 'content-egg'),
            'create_date' => __('Дата создания', 'content-egg'),
            'last_run' => __('Последний запуск', 'content-egg'),
            'status' => __('Статус', 'content-egg'),
            'post_count' => __('Всего постов', 'content-egg'),
            'last_error' => __('Последняя ошибка', 'content-egg'),
            'keywords' => __('Ключевые слова', 'content-egg'),
        );
    }

    public function save(array $item)
    {
        $item['id'] = (int) $item['id'];

        $serialized_fileds = array(
            'keywords',
            'include_modules',
            'exclude_modules',
            'required_modules',
            'autoupdate_modules'
        );
        foreach ($serialized_fileds as $field)
        {
            if (isset($item[$field]) && is_array($item[$field]))
                $item[$field] = serialize($item[$field]);
        }

        if (!$item['id'])
        {
            $item['id'] = 0;
            $item['create_date'] = current_time('mysql');
            $this->getDb()->insert($this->tableName(), $item);
            return $this->getDb()->insert_id;
        } else
        {
            $this->getDb()->update($this->tableName(), $item, array('id' => $item['id']));
            return $item['id'];
        }
    }

    public function run($id)
    {
        $autoblog = self::model()->findByPk($id);
        if (!$autoblog)
            return false;

        $autoblog['include_modules'] = unserialize($autoblog['include_modules']);
        $autoblog['exclude_modules'] = unserialize($autoblog['exclude_modules']);
        $autoblog['required_modules'] = unserialize($autoblog['required_modules']);
        $autoblog['keywords'] = unserialize($autoblog['keywords']);
        $autoblog['autoupdate_modules'] = unserialize($autoblog['autoupdate_modules']);

        $autoblog_save = array();
        $autoblog_save['id'] = $autoblog['id'];
        $autoblog_save['last_run'] = current_time('mysql');

        // next keyword exists?
        $keyword_id = self::getNextKeywordId($autoblog['keywords']);
        if ($keyword_id === false)
        {
            $autoblog_save['status'] = 0;
            $this->save($autoblog_save);
            return false;
        }
        // pre save autoblog
        $this->save($autoblog_save);

        $keywords_per_run = (int) $autoblog['keywords_per_run'];
        if ($keywords_per_run < 1)
            $keywords_per_run = 1;

        // create posts
        for ($i = 0; $i < $keywords_per_run; $i++)
        {
            if ($i)
                sleep(1);

            $keyword = $autoblog['keywords'][$keyword_id];

            $post_id = null;
            try
            {
                $post_id = $this->createPost($keyword, $autoblog);
            } catch (\Exception $e)
            {
                $error_mess = TemplateHelper::formatDatetime(time(), 'timestamp') . ' [' . $keyword . '] - ';
                $autoblog['last_error'] = $error_mess . $e->getMessage();
            }

            if ($post_id)
            {
                $autoblog['post_count'] ++;
                \do_action('cegg_autoblog_post_create', $post_id);
            }
            $autoblog['keywords'][$keyword_id] = self::markKeywordInactive($keyword);
            $keyword_id = self::getNextKeywordId($autoblog['keywords']);
            if ($keyword_id === false)
            {
                $autoblog['status'] = 0;
                break;
            }
        } //.for

        $autoblog['last_run'] = current_time('mysql');
        $this->save($autoblog);
        return true;
    }

    public function createPost($keyword, $autoblog)
    {
        $module_ids = ModuleManager::getInstance()->getParserModulesIdList(true);
        if ($autoblog['include_modules'])
            $module_ids = array_intersect($module_ids, $autoblog['include_modules']);
        if ($autoblog['exclude_modules'])
            $module_ids = array_diff($module_ids, $autoblog['exclude_modules']);

        // copy module_ids to keys        
        $module_ids = array_combine($module_ids, $module_ids);

        // run required modules first
        if ($autoblog['required_modules'])
        {
            foreach ($autoblog['required_modules'] as $required_module)
            {
                // module not found?
                if (!isset($module_ids[$required_module]))
                    throw new \Exception(sprintf(__('Обязательный модуль %s не будет запущен. Модуль не настроен или исключен.', 'content-egg'), $required_module));

                unset($module_ids[$required_module]);
                $module_ids = array($required_module => $required_module) + $module_ids;
            }
        }
        $modules_data = array();
        $count = count($module_ids) - 1;
        foreach ($module_ids as $module_id)
        {
            $module = ModuleManager::getInstance()->factory($module_id);
            try
            {
                $data = $module->doRequest($keyword, array(), true);
            } catch (\Exception $e)
            {
                // error
                $data = null;
            }
            if ($data)
            {
                foreach ($data as $i => $d)
                {
                    $data[$i]->keyword = $keyword;
                }
                $modules_data[$module->getId()] = $data;
            } elseif ($autoblog['required_modules'] && in_array($module_id, $autoblog['required_modules']))
            {
                throw new \Exception(sprintf(__('Не найдены данные для обязательного модуля %s.', 'content-egg'), $module_id));
            }

            // check min count modules
            if ($autoblog['min_modules_count'])
            {
                if (count($modules_data) + $count < $autoblog['min_modules_count'])
                    throw new \Exception(sprintf(__('Не достигнуто требуемое количество данных. Минимум требуется модулей: %d.', 'content-egg'), $autoblog['min_modules_count']));
            }
            $count--;
        }

        $title = $this->buildTemplate($autoblog['template_title'], $modules_data, $keyword);
        if (!$title)
            $title = $keyword;
        $body = $this->buildTemplate($autoblog['template_body'], $modules_data, $keyword);
        if ((bool) $autoblog['post_status'])
            $post_status = 'publish';
        else
            $post_status = 'pending';

        // create post
        $post = array(
            'ID' => null,
            'post_title' => $title,
            'post_content' => $body,
            'post_status' => $post_status,
            'post_author' => $autoblog['user_id'],
            'post_category' => array($autoblog['category']),
        );

        $post_id = \wp_insert_post($post);

        if (!$post_id)
            throw new \Exception(sprintf(__('Пост не может быть создан. Неизвестная ошибка.', 'content-egg'), $autoblog['min_modules_count']));

        // save modules data & keyword for autoupdate
        $autoupdate_keyword = \sanitize_text_field($keyword);

        foreach ($modules_data as $module_id => $data)
        {
            ContentManager::saveData($data, $module_id, $post_id);
            if (in_array($module_id, $autoblog['autoupdate_modules']) && $autoupdate_keyword)
            {
                \update_post_meta($post_id, ContentManager::META_PREFIX_KEYWORD . $module_id, $autoupdate_keyword);
            }
        }
        //\do_action('content_egg_autoblog_create_post', $post_id);
        // set featured image
        $fi = new FeaturedImage();
        $fi->setImage($post_id);

        return $post_id;
    }

    private function buildTemplate($template, array $modules_data, $keyword)
    {
        if (!$template)
            return $template;

        $template = TextHelper::spin($template);
        if (!preg_match_all('/%[a-zA-Z0-9_\.]+%/', $template, $matches))
            return $template;

        $replace = array();
        foreach ($matches[0] as $pattern)
        {
            if (stristr($pattern, '%KEYWORD%'))
            {
                $replace[$pattern] = $keyword;
                continue;
            }
            $pattern_parts = explode('.', $pattern);
            if (count($pattern_parts) == 3)
            {
                $index = (int) $pattern_parts[1]; // Amazon.0.title
                $var_name = $pattern_parts[2];
            } elseif (count($pattern_parts) == 2)
            {
                $index = 0; // Amazon.title
                $var_name = $pattern_parts[1];
            } else
            {
                $replace[$pattern] = '';
                continue;
            }
            $module_id = ltrim($pattern_parts[0], '%');
            $var_name = rtrim($var_name, '%');

            if (array_key_exists($module_id, $modules_data) && isset($modules_data[$module_id][$index]) && property_exists($modules_data[$module_id][$index], $var_name))
                $replace[$pattern] = $modules_data[$module_id][$index]->$var_name;
            else
                $replace[$pattern] = '';
        }

        return str_ireplace(array_keys($replace), array_values($replace), $template);
    }

    public static function getNextKeywordId(array $keywords)
    {
        foreach ($keywords as $id => $keyword)
        {
            if (self::isActiveKeyword($keyword))
                return $id;
        }
        return false;
    }

    public static function isInactiveKeyword($keyword)
    {
        if ($keyword[0] == '[')
            return true;
        else
            return false;
    }

    public static function isActiveKeyword($keyword)
    {
        return !self::isInactiveKeyword($keyword);
    }

    public static function markKeywordInactive($keyword)
    {
        return '[' . $keyword . ']';
    }

    public static function isActiveAutoblogs()
    {
        $total_autoblogs = AutoblogModel::model()->count('status = 1');
        if ($total_autoblogs)
            return true;
        else
            return false;
    }

}
