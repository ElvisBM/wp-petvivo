<?php

namespace ContentEgg\application\components;

/**
 * EggAutoblogger class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2015 keywordrush.com
 */
class EggAutoblogger {

    //private $keyword;
    private $autoblog;

    public function __construct(array $autoblog)
    {
        $this->autoblog = $autoblog;
    }

    /*
      public function setKeyword($keyword)
      {
      $this->keyword = $keyword;
      }

      public function getKeyword()
      {
      return $this->keyword;
      }
     * 
     */

    public function createPost($keyword)
    {
        //$this->setKeyword($keyword);
        //0. Отметить задание автоблоггинга как запущеное

        $modules_data = array();
        foreach (ModuleManager::getInstance()->getParserModules(true) as $module)
        {

            try
            {
                $data = $module->doRequest($keyword, array(), true);
            } catch (\Exception $e)
            {
                // error
                continue;
            }
            foreach ($data as $i => $d)
            {
                $data[$i]->keyword = $keyword;
            }
            $modules_data[$module->getId()] = $data;
        }

        // @todo: проверки обязательных плагинов и т.д.
        // create post
        $post = array(
            'ID' => null,
            'post_title' => $keyword,
            'post_content' => 'content',
            'post_status' => 'publish',
            'post_author' => $this->autoblog['user_id'],
            'post_category' => array($this->autoblog['category']),
        );

        $post_id = \wp_insert_post($post);
        if (!$post_id)
            return false;

        // \do_action('content_egg_autoblog_create_post', $post_id);
        // save modules data
        foreach ($modules_data as $module_id => $data)
        {
            ContentManager::saveData($data, $module_id, $post_id);
        }

        //@todo: пересохранить заданеи автоблоггинга

        return $post_id;
    }

}
