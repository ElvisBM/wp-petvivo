<?php


//////////////////////////////////////////////////////////////////
// Check plugin active
//////////////////////////////////////////////////////////////////
function rh_is_plugin_active( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || rh_is_plugin_active_for_network( $plugin );
}
function rh_is_plugin_active_for_network( $plugin ) {
    if ( !is_multisite() )
        return false;
    $plugins = get_site_option( 'active_sitewide_plugins');
    if ( isset($plugins[$plugin]) )
        return true;
    return false;
}

//////////////////////////////////////////////////////////////////
// Helper Functions
//////////////////////////////////////////////////////////////////
function rehub_kses($html)
{
    $allow = array_merge(wp_kses_allowed_html( 'post' ), array(
        'link' => array(
            'href'    => true,
            'rel'     => true,
            'type'    => true,
        ),
        'script' => array(
            'src' => true,
            'charset' => true,
            'type'    => true,
        ),
        'div' => array(
            'data-href' => true,
            'data-width' => true,
            'data-numposts'    => true,
            'data-colorscheme'    => true,
            'class' => true,
            'id' => true,
            'style' => true,
            'title' => true,
            'role' => true,
            'align' => true,
            'dir' => true,
            'lang' => true,
            'xml:lang' => true,         
        )
    ));
    return wp_kses($html, $allow);
}

//////////////////////////////////////////////////////////////////
// EXCERPT
//////////////////////////////////////////////////////////////////

if( !function_exists('kama_excerpt') ) {
function kama_excerpt($args=''){
    global $post;
        parse_str($args, $i);
        $maxchar     = isset($i['maxchar']) ?  (int)trim($i['maxchar'])     : 350;
        $text        = isset($i['text']) ?          trim($i['text'])        : '';
        $save_format = isset($i['save_format']) ?   trim($i['save_format'])         : false;
        $echo        = isset($i['echo']) ?          false                   : true;

    $out ='';   
    if (!$text){
        $out = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
        $out = preg_replace ("~\[/?.*?\]~", '', $out ); //delete shortcodes:[singlepic id=3]
        // for <!--more-->
        //if( !$post->post_excerpt && strpos($post->post_content, '<!--more-->') ){
        //  preg_match ('/(.*)<!--more-->/s', $out, $match);
        //  $out = str_replace("\r", '', trim($match[1], "\n"));
        //  $out = preg_replace( "!\n\n+!s", "</p><p>", $out );
        //  $out = "<p>". str_replace( "\n", "<br />", $out ) ."</p>";
        //  if ($echo)
        //      return print $out;
        //  return $out;
        //}
    }

    $out = $text.$out;
    if (!$post->post_excerpt)
        $out = strip_tags($out, $save_format);

    if ( mb_strlen( $out ) > $maxchar ){
        $out = mb_substr( $out, 0, $maxchar );
        $out = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ...', $out ); // убираем последнее слово, оно 99% неполное
    }   

    if($save_format){
        $out = str_replace( "\r", '', $out );
        $out = preg_replace( "!\n\n+!", "</p><p>", $out );
        $out = "<p>". str_replace ( "\n", "<br />", trim($out) ) ."</p>";
    }

    if($echo) return print $out;
    return $out;
}
}

// Create the Custom Truncate
if( !function_exists('rehub_truncate') ) {
function rehub_truncate($args=''){
        parse_str($args, $i);
        $maxchar     = isset($i['maxchar']) ?  (int)trim($i['maxchar'])     : 350;
        $text        = isset($i['text']) ?          trim($i['text'])        : '';
        $save_format = isset($i['save_format']) ?   trim($i['save_format'])         : false;
        $echo        = isset($i['echo']) ?          false                   : true;

    $out ='';   

    $out = $text.$out;
    $out = preg_replace ("~\[/?.*?\]~", '', $out );
    $out = strip_tags(strip_shortcodes($out));

    if ( mb_strlen( $out ) > $maxchar ){
        $out = mb_substr( $out, 0, $maxchar );
        $out = preg_replace('@(.*)\s[^\s]*$@s', '\\1 ...', $out ); // убираем последнее слово, оно 99% неполное
    }   

    if($save_format){
        $out = str_replace( "\r", '', $out );
        $out = preg_replace( "!\n\n+!", "</p><p>", $out );
        $out = "<p>". str_replace ( "\n", "<br />", trim($out) ) ."</p>";
    }

    if($echo) return print $out;
    return $out;
}
}


//////////////////////////////////////////////////////////////////
// Pagination
//////////////////////////////////////////////////////////////////

if( !function_exists('rehub_pagination') ) {
function rehub_pagination() {

    if( is_singular() )
        return;
    global $paged;
    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<ul class="page-numbers">' . "\n";

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li class="prev_paginate_link">%s</li>' . "\n", get_previous_posts_link() );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li class="hellip_paginate_link">&hellip;</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li class="hellip_paginate_link">&hellip;</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li class="next_paginate_link">%s</li>' . "\n", get_next_posts_link() );

    echo '</ul>' . "\n";

}
}

//////////////////////////////////////////////////////////////////
// Breadcrumbs
//////////////////////////////////////////////////////////////////

if( !function_exists('dimox_breadcrumbs') ) {
function dimox_breadcrumbs() {

  /* === OPTIONS === */
  $text['home'] = __('Home', 'rehub_framework');
  $text['category'] = __('Archive category "%s"', 'rehub_framework');
  $text['search'] = __('Search results for "%s"', 'rehub_framework');
  $text['tag'] = __('Posts with tag "%s"', 'rehub_framework');
  $text['author'] = __('Author archive "%s"', 'rehub_framework');
  $text['404'] = __('Error 404', 'rehub_framework');

  $show_current = 1; // 1 - show current name of article
  $show_on_home = 0; 
  $show_home_link = 1; // 1 - show link to Home page
  $show_title = 1; // 1 - show titles for links
  $delimiter = ' &raquo; '; // delimiter
  $before = '<span class="current">'; // tag before current 
  $after = '</span>'; // tag after current

  global $post;
  $home_link = home_url('/');
  $link_before = '<span typeof="v:Breadcrumb">';
  $link_after = '</span>';
  $link_attr = ' rel="v:url" property="v:title"';
  $link = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
  $parent_id = $parent_id_2 = $post->post_parent;
  $frontpage_id = get_option('page_on_front');

  if (is_home() || is_front_page()) {

    if ($show_on_home == 1) echo '<div class="breadcrumb"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

  } else {
    echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
    if ($show_home_link == 1) {
      echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
      if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
    }
    if ( is_category() ) {
      $this_cat = get_category(get_query_var('cat'), false);
      if ($this_cat->parent != 0) {
        $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
      }
      if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
    } elseif ( is_search() ) {
      echo $before . sprintf($text['search'], get_search_query()) . $after;
    } elseif ( is_day() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
      echo $before . get_the_time('d') . $after;
    } elseif ( is_month() ) {
      echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
      echo $before . get_the_time('F') . $after;
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);
        if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, $delimiter);
        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
        if ($show_current == 1) echo $before . get_the_title() . $after;
      }
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
    } elseif ( is_attachment() ) {
      $parent = get_post($parent_id);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      if ($cat) {
        $cats = get_category_parents($cat, TRUE, $delimiter);
        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
        echo $cats;
      }
      printf($link, get_permalink($parent), $parent->post_title);
      if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

    } elseif ( is_page() && !$parent_id ) {
      if ($show_current == 1) echo $before . get_the_title() . $after;
    } elseif ( is_page() && $parent_id ) {
      if ($parent_id != $frontpage_id) {
        $breadcrumbs = array();
        while ($parent_id) {
          $page = get_page($parent_id);
          if ($parent_id != $frontpage_id) {
            $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
          }
          $parent_id = $page->post_parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        for ($i = 0; $i < count($breadcrumbs); $i++) {
          echo $breadcrumbs[$i];
          if ($i != count($breadcrumbs)-1) echo $delimiter;
        }
      }
      if ($show_current == 1) {
        if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
        echo $before . get_the_title() . $after;
      }
    } elseif ( is_tag() ) {
      echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
    } elseif ( is_author() ) {
        global $author;
      $userdata = get_userdata($author);
      echo $before . sprintf($text['author'], $userdata->display_name) . $after;
    } elseif ( is_404() ) {
      echo $before . $text['404'] . $after;
    } elseif ( has_post_format() && !is_singular() ) {
      echo get_post_format_string( get_post_format() );
    }
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo 'Страница ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
    echo '</div><!-- .breadcrumbs -->';
  }
} // end dimox_breadcrumbs()
}


/** Autocontents class
 * Taken from: wp-kama.ru/?p=1513
 * V: 2.9.4
 */
class Kama_Contents{    
    // defaults options
    public $opt = array(
        'margin'     => 40,
        'selectors'  => array('h2','h3','h4'),
        'to_menu'    => '↑',
        'title'      => '',
        'css'        => '',
        'min_found'  => 2,
        'min_length' => 1500,
        'page_url'   => '',
        'shortcode'  => 'contents',
        'spec'       => '\'.+$*~=',
        'wrap'       => '',
        'tag_inside' => '',
        // Какой тип анкора использовать: 'a' - <a name="anchor"></a> или 'id' - 
        'anchor_type' => 'a',
    );

    public $contents; // collect html contents

    private $temp;

    static $inst;

    function __construct( $args = array() ){
        $this->set_opt( $args );
        return $this;
    }

    static function init( $args = array() ){
        is_null( self::$inst ) && self::$inst = new self( $args );
        //if( $args ) self::$inst->set_opt( $args ); // ! NO
        return self::$inst;
    }

    function set_opt( $args = array() ){
        $this->opt = (object) array_merge( $this->opt, (array) $args );
    }

    function shortcode( $content, $contents_cb = '' ){
        if( false === strpos( $content, '['. $this->opt->shortcode ) ) 
            return $content; 

        // get contents data
        if( ! preg_match('~^(.*)\['. $this->opt->shortcode .'([^\]]*)\](.*)$~s', $content, $m ) )
            return $content;

        $contents = $this->make_contents( $m[3], $m[2] );

        if( $contents && $contents_cb && is_callable($contents_cb) )
            $contents = $contents_cb( $contents );

        return $m[1] . $contents . $m[3];
    }

    function make_contents( & $content, $tags = '' ){

        //if( mb_strlen( strip_tags($content) ) < $this->opt->min_length ) return;

        $this->temp     = $this->opt;
        $this->temp->i  = 0;
        $this->contents = '';

        if( is_string($tags) && $tags = trim($tags) )
            $tags = array_map('trim', preg_split('~\s+~', $tags ) );

        if( ! $tags )
            $tags = $this->opt->selectors;

        // check tags
        foreach( $tags as $k => $tag ){
            // remove special marker tags and set $args
            if( in_array( $tag, array('embed','no_to_menu') ) ){
                if( $tag == 'embed' ) $this->temp->embed = true;
                if( $tag == 'no_to_menu' ) $this->opt->to_menu = false;

                unset( $tags[ $k ] );
                continue;
            }

            // remove tag if it's not exists in content
            $patt = ( ($tag[0] == '.') ? 'class=[\'"][^\'"]*'. substr($tag, 1) : "<$tag" );
            if( ! preg_match("/$patt/i", $content ) ){
                unset( $tags[ $k ] );
                continue;
            }
        }

        if( ! $tags ) return;

        // set patterns from given $tags
        // separate classes & tags & set
        $class_patt = $tag_patt = $level_tags = array();
        foreach( $tags as $tag ){
            // class
            if( $tag{0} == '.' ){
                $tag  = substr( $tag, 1 );
                $link = & $class_patt;
            }
            // html tag
            else
                $link = & $tag_patt;

            $link[] = $tag;         
            $level_tags[] = $tag;
        }

        $this->temp->level_tags = array_flip( $level_tags );

        $patt_in = array();
        if( $tag_patt )   $patt_in[] = '(?:<('. implode('|', $tag_patt) .')([^>]*)>(.*?)<\/\1>)';
        if( $class_patt ) $patt_in[] = '(?:<([^ >]+) ([^>]*class=["\'][^>]*('. implode('|', $class_patt) .')[^>]*["\'][^>]*)>(.*?)<\/'. ($patt_in?'\4':'\1') .'>)';

        $patt_in = implode('|', $patt_in );

        // collect and replace
        $_content = preg_replace_callback("/$patt_in/is", array( &$this, '__make_contents_callback'), $content, -1, $count );

        if( ! $count || $count < $this->opt->min_found )
            return;

        $content = $_content; // опять работаем с важной $content
        // html
        static $css;
        $embed = !! isset($this->temp->embed);
        $this->contents = 
            ( ( $this->opt->wrap ) ? '<div id="'.$this->opt->wrap.'">' : '' ) .
            ( ( !$embed && $this->opt->title ) ? '<div class="kc__wrap">' : '' ) .
            ( ( ! $css && $this->opt->css )    ? '<style>'. $this->opt->css .'</style>' : '' ) .
            ( ( !$embed && $this->opt->title ) ? '<div class="kc-title kc__title" id="kcmenu">'. $this->opt->title .'</div>'. "\n" : '' ) .
                '<ul class="autocontents"'. ((!$this->opt->title || $embed) ? ' id="kcmenu"' : '') .'>'. "\n". 
                    implode('', $this->contents ) .
                '</ul>'."\n" .
            ( ( !$embed && $this->opt->title ) ? '</div>' : '' ).
            ( ( $this->opt->wrap ) ? '</div>' : '' );

        return $this->contents;
    }

    private function __make_contents_callback( $match ){
        // it's only class selector in pattern
        if( count($match) == 5 ){
            $tag   = $match[1];
            $attrs = $match[2];
            $title = $match[4];

            $level_tag = $match[3]; // class_name
        }
        // it's found tag selector
        elseif( count($match) == 4 ){
            $tag   = $match[1];
            $attrs = $match[2];
            $title = $match[3];

            $level_tag = $tag;
        }
        // it's found class selector
        else{
            $tag   = $match[4];
            $attrs = $match[5];
            $title = $match[7];

            $level_tag = $match[6]; // class_name
        }

        $anchor = $this->__sanitaze_anchor( $title );
        $opt = & $this->opt;

        $level = @ $this->temp->level_tags[ $level_tag ];
        if( $level > 0 )
            $sub = ( $opt->margin ? ' style="margin-left:'. ($level*$opt->margin) .'px;"' : '') . ' class="sub sub_'. $level .'"';
        else 
            $sub = ' class="top"';

        // собираем оглавление
        $this->contents[] = "\t". '<li'. $sub .'><a href="'. $opt->page_url .'#'. $anchor .'">'. $title .'</a></li>'. "\n";

        // заменяем
        $to_menu = $new_el = '';
        if( $opt->to_menu )
            $to_menu = (++$this->temp->i == 1) ? '' : '<a class="kc-gotop kc__gotop" href="'. $opt->page_url .'#kcmenu">'. $opt->to_menu .'</a>';

        $tag_inside_head = ( $opt->tag_inside) ? ' class="'.$opt->tag_inside.'"' : '';
        $new_el = "\n<$tag id=\"$anchor\" $tag_inside_head $attrs>$title</$tag>";
        if( $opt->anchor_type == 'a' )
            $new_el = '<a class="kc-anchor kc__anchor" name="'. $anchor .'"></a>'."\n<$tag $attrs>$title</$tag>";

        return $to_menu . $new_el;
    }

    ## Транслитерация УРЛ
    private function __sanitaze_anchor( $str ){
        $str = strip_tags( $str );

        $iso9 = array(
            'А'=>'A', 'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D', 'Е'=>'E', 'Ё'=>'YO', 'Ж'=>'ZH',
            'З'=>'Z', 'И'=>'I', 'Й'=>'J', 'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O',
            'П'=>'P', 'Р'=>'R', 'С'=>'S', 'Т'=>'T', 'У'=>'U', 'Ф'=>'F', 'Х'=>'H', 'Ц'=>'TS',
            'Ч'=>'CH', 'Ш'=>'SH', 'Щ'=>'SHH', 'Ъ'=>'', 'Ы'=>'Y', 'Ь'=>'', 'Э'=>'E', 'Ю'=>'YU', 'Я'=>'YA',
            // small
            'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d', 'е'=>'e', 'ё'=>'yo', 'ж'=>'zh',
            'з'=>'z', 'и'=>'i', 'й'=>'j', 'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o',
            'п'=>'p', 'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 'ф'=>'f', 'х'=>'h', 'ц'=>'ts',
            'ч'=>'ch', 'ш'=>'sh', 'щ'=>'shh', 'ъ'=>'', 'ы'=>'y', 'ь'=>'', 'э'=>'e', 'ю'=>'yu', 'я'=>'ya',
            // other
            'Ѓ'=>'G', 'Ґ'=>'G', 'Є'=>'YE', 'Ѕ'=>'Z', 'Ј'=>'J', 'І'=>'I', 'Ї'=>'YI', 'Ќ'=>'K', 'Љ'=>'L', 'Њ'=>'N', 'Ў'=>'U', 'Џ'=>'DH',          
            'ѓ'=>'g', 'ґ'=>'g', 'є'=>'ye', 'ѕ'=>'z', 'ј'=>'j', 'і'=>'i', 'ї'=>'yi', 'ќ'=>'k', 'љ'=>'l', 'њ'=>'n', 'ў'=>'u', 'џ'=>'dh'
        );

        $str = strtr( $str, $iso9 );

        $spec = preg_quote( $this->opt->spec );
        $str  = preg_replace("/[^a-zA-Z0-9\-_$spec]+/", '-', $str ); // все ненужное на '-'
        $str  = preg_replace('/^-+|-+$/', '', $str ); // кил конечные ---

        return strtolower( $str );
    }

    ## Strip shortcode
    function strip_shortcode( $text ){
        return preg_replace('~\['. $this->opt->shortcode .'[^\]]*\]~', '', $text );
    }
}


## Proccesing contents shortcode
add_filter('the_content', 'rehub_contents_shortcode');
function rehub_contents_shortcode( $content ){
    $args = array();
    $args['to_menu']  = __('back to menu', 'rehub_framework').' ↑';

    $autocontents = new Kama_Contents($args);   
    if( is_singular() ){        
        return $autocontents->shortcode( $content );
    }
    else{
        return $autocontents->strip_shortcode( $content );
    }
}

## Proccesing toplist shortcode
add_filter('the_content', 'rehubtop_contents_shortcode');
function rehubtop_contents_shortcode( $content ){
    $args = array();
    $args['shortcode'] = 'wpsm_toplist';
    $args['anchor_type'] = 'id';
    $args['wrap'] = 'toplistmenu';
    $args['tag_inside'] = 'wpsm_toplist_heading';
    $args['to_menu']  = __('back to menu', 'rehub_framework').' ↑'; 
    $args['selectors'] = array ('h2');
    $toplist = new Kama_Contents($args);

    if( is_singular() ){
        return $toplist->shortcode( $content );
    }
    else{
        return $toplist->strip_shortcode( $content );
    }
}

//Get site favicon
if (!function_exists('rehub_get_site_favicon')) {

    function rehub_get_site_favicon($url) {
        $shop = parse_url($url, PHP_URL_HOST);
        $shop = preg_replace('/^www\./', '', $shop);

        if ($shop){
            if($shop == 'dl.flipkart.com'){
                $shop = 'flipkart.com';
            }
            elseif($shop == 'click.linksynergy.com'){
                $shop = 'linkshare.com';
            } 
            elseif($shop == 'rover.ebay.com'){
                $shop = 'ebay.com';
            }             
            elseif($shop == 'pdt.tradedoubler.com'){
                $shop = 'tradedoubler.com';
            }
            elseif($shop == 'partners.webmasterplan.com'){
                $shop = 'affili.net';
            } 
            elseif($shop == 'ad.zanox.com'){
                $shop = 'zanox.com';
            }                                                
            $d = explode('.', $shop);
            $title = $d[0]; 
            $logo_urls_trans = get_transient('ce_favicon_urls');
            if (empty($logo_urls_trans)){
                $logo_urls_trans = array();
            }
            if(array_key_exists($shop, $logo_urls_trans)){
                return '<img src="'.$logo_urls_trans[$shop].'" height=16 width=16 alt='.$title.' /> '.$shop;
            }
            else {         
                $img_uri = '//www.google.com/s2/favicons?domain=http://'.$shop;                  
                $new_logo_url = rh_ae_saveimg_towp($img_uri, $title);
                if(!empty($new_logo_url)){
                    $logo_urls_trans[$shop] = $new_logo_url;
                    set_transient('ce_favicon_urls', $logo_urls_trans, 180 * DAY_IN_SECONDS); 
                    return '<img src="'.$new_logo_url.'" height=16 width=16 alt='.$title.' /> '.$shop;
                }
            }            
        }
    }
} 

if (!function_exists('rehub_get_site_favicon_icon')) {

    function rehub_get_site_favicon_icon($url) {
        $shop = parse_url($url, PHP_URL_HOST);
        $shop = preg_replace('/^www\./', '', $shop);
        if ($shop){
            if($shop == 'dl.flipkart.com'){
                $shop = 'flipkart.com';
            }
            elseif($shop == 'click.linksynergy.com'){
                $shop = 'linkshare.com';
            } 
            elseif($shop == 'rover.ebay.com'){
                $shop = 'ebay.com';
            }             
            elseif($shop == 'pdt.tradedoubler.com'){
                $shop = 'tradedoubler.com';
            }
            elseif($shop == 'partners.webmasterplan.com'){
                $shop = 'affili.net';
            }  
            elseif($shop == 'ad.zanox.com'){
                $shop = 'zanox.com';
            }                        
            $d = explode('.', $shop);
            $title = $d[0]; 
            $logo_urls_trans = get_transient('ce_favicon_urls');
            if (empty($logo_urls_trans)){
                $logo_urls_trans = array();
            }
            if(array_key_exists($shop, $logo_urls_trans)){
                return '<img src="'.$logo_urls_trans[$shop].'" height=16 width=16 alt='.$title.' />';
            }
            else {         
                $img_uri = '//www.google.com/s2/favicons?domain=http://'.$shop;                  
                $new_logo_url = rh_ae_saveimg_towp($img_uri, $title);
                if(!empty($new_logo_url)){
                    $logo_urls_trans[$shop] = $new_logo_url;
                    set_transient('ce_favicon_urls', $logo_urls_trans, 180 * DAY_IN_SECONDS); 
                    return '<img src="'.$new_logo_url.'" height=16 width=16 alt='.$title.' />';
                }
            }            
        }       
    }
} 

if(!function_exists('rh_fix_domain')){
    function rh_fix_domain($merchant, $domain){
        if($merchant){
            $merchant = trim($merchant);
        }
        if($merchant == 'Ferrari Store UK'){
            $domain = 'ferrari.com';
        }  
        if($domain == 'dl.flipkart.com'){
            $domain = 'flipkart.com';
        }
        elseif($domain == 'click.linksynergy.com'){
            $domain = 'linkshare.com';
        } 
        elseif($domain == 'pdt.tradedoubler.com'){
            $domain = 'tradedoubler.com';
        }
        elseif($domain == 'rover.ebay.com'){
            $domain = 'ebay.com';
        }         
        elseif($domain == 'partners.webmasterplan.com'){
            $domain = 'affili.net';
        }  
        elseif($domain == 'ad.zanox.com'){
            $domain = 'zanox.com';
        }   
        elseif($domain == 'catalog.paytm.com'){
            $domain = 'paytm.com';
        }                     
        return $domain;
    }
}

//Get social buttons
if( !function_exists('rehub_social_inimage') ) {
function rehub_social_inimage($small = '', $favorite = '', $rh_favorite = '')
{   
    global $post;
    if ($small == 'minimal') {
        $small_class = ' social_icon_inimage small_social_inimage';
        $text_fb = $text_tw = '';
    }
    elseif ($small =='row') {
        $small_class = ' row_social_inpost';
        $text_fb = 'Facebook';
        $text_tw = '';
    }
    elseif ($small == 'flat') {
        $text_fb = $text_tw = $small_class = '';
    }    
    else {
        $small_class = ' social_icon_inimage';
    }
    $output ='';
    $output .='<div class="social_icon '.$small_class.'">';
    if ($favorite == '1') {
        if(function_exists('get_favorites_button')){
            $output .='<div class="favour_in_row">'.get_favorites_button().'</div>';
        } 
    }
    if ($rh_favorite == '1' && !function_exists('get_favorites_button')) {
        $output .= getHotThumb($post->ID, false, false, true);
    }    
    $output .= do_action('rh_social_inimage_before');
    $output .='<span data-href="https://www.facebook.com/sharer/sharer.php?u='.urlencode(get_permalink()).'" class="fb share-link-image" data-service="facebook"><i class="fa fa-facebook"></i></span>';
    $output .='<span data-href="https://twitter.com/share?url='.urlencode(get_permalink()).'&text='.urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')).'" class="tw share-link-image" data-service="twitter"><i class="fa fa-twitter"></i></span>';
    $output .='<span data-href="https://pinterest.com/pin/create/button/?url='.urlencode(get_permalink()).'&amp;media='.get_post_thumb().'&amp;description='.urlencode(get_the_title()).'" class="pn share-link-image" data-service="pinterest"><i class="fa fa-pinterest-p"></i></span>';
    if ($small =='row' || $small =='flat' ) {
        $output .='<span data-href="https://plus.google.com/share?url='.urlencode(get_permalink()).'" class="gp share-link-image" data-service="googleplus"><i class="fa fa-google-plus"></i></span>';
    }
    $output .= do_action('rh_social_inimage_after');
    $output .='</div>';         
    return $output; 
}
}

if(!function_exists('rehub_get_ip')) {
    #get the user's ip address
    function rehub_get_ip() {
        if (empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip_address = $_SERVER["REMOTE_ADDR"];
        } else {
            $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        if(strpos($ip_address, ',') !== false) {
            $ip_address = explode(',', $ip_address);
            $ip_address = $ip_address[0];
        }
        return esc_attr($ip_address);
    }
}

if (!function_exists('rehub_truncate_title')) {
    #get custom length titles
    function rehub_truncate_title($len = 110, $id = NULL) {
        $title = get_the_title($id);        
        if (!empty($len) && mb_strlen($title)>$len) $title = mb_substr($title, 0, $len-3) . "...";
        return $title;
    }
}

if ( !function_exists( 'rh_serialize_data_review' ) ) {
    function rh_serialize_data_review( $array_data ) {
        serialize( $array_data );
        return $array_data;
    }
}

if ( !function_exists( 'rh_ae_logo_get' ) ) {
    function rh_ae_logo_get( $offerurl, $size=120 ) {
        if ($offerurl){
             $domain = str_ireplace('www.', '', parse_url($offerurl, PHP_URL_HOST));
        }
        if ($domain){   
            if ($domain == 'amazon.de' || $domain == 'amazon.com' || $domain == 'amazon.co.uk' || $domain == 'amazon.es' || $domain == 'amazon.in' || $domain == 'amazon.nl' ){
                return get_template_directory_uri().'/images/logos/amazon.png';
            } 
            elseif ($domain == 'ebay.de' || $domain == 'ebay.com' || $domain == 'ebay.co.uk' || $domain == 'ebay.es' || $domain == 'ebay.in' || $domain == 'ebay.nl' ){
                return get_template_directory_uri().'/images/logos/ebay.png';
            }  
            elseif ($domain == 'aliexpress.com'){
                return get_template_directory_uri().'/images/logos/aliexpress.png';
            }  
            elseif ($domain == 'flipkart.com' || $domain == 'dl.flipkart.com' ){
                return get_template_directory_uri().'/images/logos/flipkart.png';
            }    
            elseif ($domain == 'snapdeal.com'){
                return get_template_directory_uri().'/images/logos/snapdeal.png';
            }  
            elseif ($domain == 'banggood.com'){
                return get_template_directory_uri().'/images/logos/banggood.png';
            }             
            elseif ($domain == 'shopclues.com'){
                return get_template_directory_uri().'/images/logos/shopclues.png';
            }  
            elseif ($domain == 'etsy.com'){
                return get_template_directory_uri().'/images/logos/etsy.png';
            }  
            elseif ($domain == 'wiggle.com' || $domain == 'wiggle.co.uk'){
                return get_template_directory_uri().'/images/logos/wiggle.jpg';
            } 
            elseif ($domain == 'iherb.com' || $domain == 'ru.iherb.com'){
                return get_template_directory_uri().'/images/logos/iherb.jpg';
            }  
            elseif ($domain == 'airbnb.com' || $domain == 'ru.airbnb.com'){
                return get_template_directory_uri().'/images/logos/airbnb.jpg';
            } 
            elseif ($domain == 'infibeam.com'){
                return get_template_directory_uri().'/images/logos/infibeam.png';
            }                                                                                                        
            $logo_urls_trans = get_transient('ae_logo_store_urls');
            if (empty($logo_urls_trans)){
                $logo_urls_trans = array();
            }
            if(array_key_exists($domain, $logo_urls_trans)){
                return $logo_urls_trans[$domain];
            }
            else {
                $d = explode('.', $domain);
                $title = $d[0];  
                $img_uri = '//logo.clearbit.com/'.$domain.'?size='.$size.'';                  
                $new_logo_url = rh_ae_saveimg_towp($img_uri, $title);
                if(!empty($new_logo_url)){
                    $logo_urls_trans[$domain] = $new_logo_url;
                    set_transient('ae_logo_store_urls', $logo_urls_trans, 180 * DAY_IN_SECONDS); 
                    return $new_logo_url;
                }
            }

        }
    }
}

if ( !function_exists( 'rh_ae_saveimg_towp' ) ) {
    function rh_ae_saveimg_towp($img_uri, $title = '', $check_image_type = true)
    {
        if (!defined('FS_CHMOD_FILE'))
            define('FS_CHMOD_FILE', ( fileperms(ABSPATH . 'index.php') & 0777 | 0644));

        $uploads = wp_upload_dir();
        $newfilename = $title;
        $newfilename = preg_replace('/[^a-zA-Z0-9\-]/', '', $newfilename);
        $newfilename = strtolower($newfilename);
        if (!$newfilename)
            $newfilename = time();
        if (0 === strpos($img_uri, '//')) {
            $img_uri = 'https:' . $img_uri;
        }
        elseif(false === strpos($img_uri, '://')){
            $img_uri = 'https://' . $img_uri;
        }   
        require_once(ABSPATH . 'wp-admin/includes/file.php');     
        $downloadfile = download_url( $img_uri, 30 );
        if (is_wp_error($downloadfile) ){
            return false;
        }

        $newfilename .= '.png';
        $newfilename = wp_unique_filename($uploads['path'], $newfilename);

        if ($check_image_type)
        {
            $filetype = wp_check_filetype($newfilename, null);
            if (substr($filetype['type'], 0, 5) != 'image')
                return false;
        }

        $file_path = $uploads['path'] . DIRECTORY_SEPARATOR . $newfilename;
        $current = @file_get_contents($downloadfile);
        if (!file_put_contents($file_path, $current)) {
            return false;
        }

        @chmod($file_path, FS_CHMOD_FILE);
        return trailingslashit($uploads['url']).$newfilename;
    }

}

if(!function_exists('wpsm_inline_list_shortcode')) {
    function wpsm_inline_list_shortcode($atts, $content) {  
      $content = do_shortcode($content);    
        return '<div class="inline-list-wrap">' . $content . '</div>';  
    } 
    // add the shortcode to system
    add_shortcode('wpsm_inline_list', 'wpsm_inline_list_shortcode');
}

if(!function_exists('wpsm_stickypanel_shortcode')) {
    function wpsm_stickypanel_shortcode($atts, $content) {  
        $content = do_shortcode($content); 
        wp_enqueue_script('rehubwaypoints' );   
        return '<div id="content-sticky-panel"><span id="mobileactivate"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>' . $content . '</div>';  
    } 
    // add the shortcode to system
    add_shortcode('wpsm_stickypanel', 'wpsm_stickypanel_shortcode');
}


add_filter( 'gmw_pt_map_icon', 'rh_gmw_post_mapin', 10, 2);
if (!function_exists('rh_gmw_post_mapin')){
    function rh_gmw_post_mapin ($post, $gmw_form){
        global $post;
        $postid = $post->ID;
        return get_template_directory_uri() . '/images/default/mappostpin.png';        
    }
}

if (!function_exists('rh_gmw_post_in_popup')){
    function rh_gmw_post_in_popup ($output, $post, $gmw_form){
        $address   = ( !empty( $post->formatted_address ) ) ? $post->formatted_address : $post->address;
        $permalink = get_permalink( $post->ID );
        $thumb     = get_the_post_thumbnail( $post->ID );
        
        $output                  = array();
        $output['start']         = "<div class=\"gmw-pt-info-window-wrapper wppl-pt-info-window\">";
        $output['thumb']         = "<div class=\"thumb wppl-info-window-thumb\">{$thumb}</div>";
        $output['content_start'] = "<div class=\"content wppl-info-window-info\"><table>";
        $output['title']         = "<tr><td><div class=\"title wppl-info-window-permalink\"><a href=\"{$permalink}\">{$post->post_title}</a></div></td></tr>";
        $output['address']       = "<tr><td><span class=\"address\">{$gmw_form['labels']['info_window']['address']}</span>{$address}</td></tr>";
        
        if ( isset( $post->distance ) ) {
            $output['distance'] = "<tr><td><span class=\"distance\">{$gmw_form['labels']['info_window']['distance']}</span>{$post->distance} {$gmw_form['units_array']['name']}</td></tr>";
        }
        
        if ( !empty( $gmw_form['search_results']['additional_info'] ) ) {
        
            foreach ( $gmw_form['search_results']['additional_info'] as $field ) {
                if ( isset( $post->$field ) ) {
                    $output[$gmw_form['labels']['info_window'][$field]] = "<tr><td><span class=\"{$gmw_form['labels']['info_window'][$field]}\">{$gmw_form['labels']['info_window'][$field]}</span>{$post->$field}</td></tr>";
                }
            }
        }
        
        $output['content_end'] = "</table></div>";
        $output['end']         = "</div>";
        return $output;
    }
}
//add_filter( 'gmw_pt_info_window_content', 'rh_gmw_post_in_popup', 10, 3);

//////////////////////////////////////////////////////////////////
// PRICE HELPER
//////////////////////////////////////////////////////////////////
if(!class_exists('PriceTemplateHelper')){
class RhPriceTemplateHelper {

    static public function currencyTyping($c)
    {
        $types = array("RUB" => "руб.", "UAH" => "грн.", "USD" => "$", "CAD" => "C$", "GBP" => "&pound;", "EUR" => "&euro;", "JPY" => "&yen;", "CNY" => "&yen;", "INR" => "&#8377;", "AUD" => "AU $", "RUR" => 'руб.');
        if (key_exists($c, $types))
            return $types[$c];
        else
            return $c;
    }

    public static function number_format_i18n($number, $decimals = 0)
    {
        $decimal_point = __('number_format_decimal_point', 'rehub_framework');
        $thousands_sep = __('number_format_thousands_sep', 'rehub_framework');

        if ($decimal_point == 'number_format_decimal_point')
            $decimal_point = '.';

        if ($thousands_sep == 'number_format_thousands_sep')
            $thousands_sep = ',';

        return number_format($number, absint($decimals), $decimal_point, $thousands_sep);
    }

    public static function price_format_i18n($number, $currency = null)
    {
        if ($currency && in_array($currency, array('RUB', 'UAH', 'INR', 'RUR')))
            $decimal = 0;
        else
            $decimal = 2;
        return self::number_format_i18n($number, $decimal);
    }

    public static function formatPriceCurrency($price, $currencyCode)
    {
        $return = '';
        $currency = self::currencyTyping($currencyCode);
        $price = self::price_format_i18n($price, $currencyCode);

        if (in_array($currencyCode, array('RUB', 'UAH', 'RUR')))
            return $price . ' ' . $currency;
        else
            return $currency . '' . $price;
    }
}
}


//////////////////////////////////////////////////////////////////
// Hex to RGBA
//////////////////////////////////////////////////////////////////
if (!function_exists('hex2rgba')){
function hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}
}


//////////////////////////////////////////////////////////////////
// CSS minify
//////////////////////////////////////////////////////////////////
if (!function_exists('rehub_quick_minify')){ 
function rehub_quick_minify( $css ) {
    $css = preg_replace( '/\s+/', ' ', $css );
    $css = preg_replace( '/\/\*[^\!](.*?)\*\//', '', $css );
    $css = preg_replace( '/(,|:|;|\{|}) /', '$1', $css );
    $css = preg_replace( '/ (,|;|\{|})/', '$1', $css );
    $css = preg_replace( '/(:| )0\.([0-9]+)(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );
    $css = preg_replace( '/(:| )(\.?)0(%|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );
    return trim( $css );
}
}