<?php

namespace ContentEgg\application\admin;

use ContentEgg\application\Plugin;
use ContentEgg\application\components\ModuleManager;
use ContentEgg\application\helpers\TextHelper;
use ContentEgg\application\helpers\InputHelper;
use ContentEgg\application\components\ContentManager;
use ContentEgg\application\libs\KeywordDensity;

/**
 * PrefillController class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2016 keywordrush.com
 */
class PrefillController {

    const slug = 'content-egg-prefill';

    public function __construct()
    {
        \add_action('admin_menu', array($this, 'add_admin_menu'));
        \add_action('wp_ajax_' . self::slug, array($this, 'addApiEntry'));

        if ($GLOBALS['pagenow'] == 'admin.php' && !empty($_GET['page']) && $_GET['page'] == self::slug)
        {
            \wp_enqueue_script('contentegg-prefill', \ContentEgg\PLUGIN_RES . '/js/prefill.js', array('jquery'));
            \wp_enqueue_script('jquery-ui-progressbar', array('jquery-ui-core'));
            \wp_enqueue_style('contentegg-admin-ui-css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css', false, Plugin::version, false);

            \wp_localize_script('contentegg-prefill', 'content_egg_prefill', array(
                'post_ids' =>
                \get_posts(array(
                    'post_type' => GeneralConfig::getInstance()->option('post_types'),
                    'numberposts' => -1,
                    'post_status' => array('publish', 'future'),
                    'fields' => 'ids',
                )),
                'nonce' => \wp_create_nonce('contentegg-prefill')
            ));
        }
    }

    public function add_admin_menu()
    {
        \add_submenu_page(Plugin::slug, __('Fill', 'content-egg') . ' &lsaquo; Content Egg', __('Fill', 'content-egg'), 'publish_posts', self::slug, array($this, 'actionIndex'));
    }

    public function actionIndex()
    {
        PluginAdmin::getInstance()->render('prefill', array(
                //'nonce' => \wp_create_nonce(basename(__FILE__)),
        ));
    }

    public static function apiBase()
    {
        return self::slug;
    }

    public function addApiEntry()
    {
        if (!\current_user_can('edit_posts'))
            throw new \Exception("Access denied.");

        \check_ajax_referer('contentegg-prefill', 'nonce');

        if (empty($_GET['module_id']))
            throw new \Exception("Module is undefined.");
        if (empty($_GET['post_id']))
            throw new \Exception("Post ID is undefined.");

        $module_id = TextHelper::clear($_GET['module_id']);
        $post_id = (int) $_GET['post_id'];
        $keyword_source = InputHelper::get('keyword_source');
        $autoupdate = (bool) InputHelper::get('autoupdate', false);
        $keyword_count = (int) InputHelper::get('keyword_count');

        $parser = ModuleManager::getInstance()->parserFactory($module_id);
        if (!$parser->isActive())
            throw new \Exception("Parser module " . $parser->getId() . " is inactive.");

        if (!$post = \get_post($post_id))
            throw new \Exception("Post does not exists.");

        $log = 'Post ID: ' . $post->ID;
        $log .= ' (' . TextHelper::truncate($post->post_title) . ').';

        // data exists?
        if (ContentManager::isDataExists($post->ID, $parser->getId()))
        {
            $log .= ' - ' . __('Data already exist.', 'content-egg');
            $this->printResult($log);
        }

        $keyword = $this->getKeyword($post_id, $keyword_source, $keyword_count);

        if (!$keyword)
            $this->printResult($log . ' - ' . __('Impossible to determine a keyword', 'content-egg'));

        $log .= ' Keyword: "' . $keyword . '"';

        // autoupdate keyword
        if ($autoupdate && $parser->isAffiliateParser())
        {
            // exists?
            if (\get_post_meta($post->ID, ContentManager::META_PREFIX_KEYWORD . $parser->getId(), true))
                $this->printResult($log . ' - ' . __('Keyword for autoupdate already exists.', 'content-egg'));

            // save & exit...
            \update_post_meta($post->ID, ContentManager::META_PREFIX_KEYWORD . $parser->getId(), $keyword);
            $this->printResult($log . ' - ' . __('Keyword for autoupdate was saved.', 'content-egg'));
        }

        try
        {
            $data = $parser->doRequest($keyword, array(), true);
        } catch (\Exception $e)
        {
            // error
            $log .= ' - ' . __('Error:', 'content-egg') . ' ' . $e->getMessage();
            $this->printResult($log);
        }

        // nodata!
        if (!$data)
        {
            $log .= ' - ' . __('No data found...', 'content-egg');
            $this->printResult($log);
        }

        // save
        ContentManager::saveData($data, $parser->getId(), $post->ID);
        $log .= ' - ' . __('Data saved:', 'content-egg') . ' ' . count($data) . '.';
        $this->printResult($log);
    }

    private function printResult($mess)
    {
        $res = array();
        $res['log'] = htmlspecialchars($mess);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($res);
        \wp_die();
    }

    private function getKeyword($post_id, $keyword_source, $keyword_count)
    {
        $keyword = '';
        if ($keyword_source == '_title')
        {
            $post = \get_post($post_id);
            $keyword = $post->post_title;
        } elseif ($keyword_source == '_tags')
        {
            $keyword = join(' ', \wp_get_post_tags($post_id, array('fields' => 'names')));
        } elseif ($keyword_source == '_density')
        {
            $kd = new KeywordDensity(GeneralConfig::getInstance()->option('lang'));
            $kd->setText($this->getDensText($post_id));
            $popular = $kd->getPopularWords($keyword_count);
            $keyword = join(' ', $popular);
        } elseif (ModuleManager::getInstance()->moduleExists($keyword_source))
        {
            $keyword = \get_post_meta($post_id, ContentManager::META_PREFIX_KEYWORD . $keyword_source, true);
        }

        // split into words
        $wordlist = preg_split('/\W/u', $keyword, 0, PREG_SPLIT_NO_EMPTY);
        $wordlist = array_unique($wordlist);

        // returns only words that have minimum 2 chars
        $wordlist = array_filter($wordlist, function($val) {
            return mb_strlen($val, 'UTF-8') >= 2;
        });

        $wordlist = array_slice($wordlist, 0, $keyword_count);

        return join(' ', $wordlist);
    }

    private function getDensText($post_id)
    {
        $post = \get_post($post_id);
        $text = $post->post_title . ' ' . $post->post_content;

        $pattern = get_shortcode_regex();
        $text = preg_replace('/' . $pattern . '/s', ' ', $text);
        return $text;
    }

}
