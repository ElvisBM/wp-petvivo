<?php

namespace ContentEgg\application\helpers;

/**
 * TextHelper class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link http://www.keywordrush.com/
 * @copyright Copyright &copy; 2014 keywordrush.com
 */
class TextHelper {

    public static function truncate($string, $length = 80, $etc = '...', $charset = 'UTF-8', $break_words = false, $middle = false)
    {
        if ($length == 0)
            return '';

        if (mb_strlen($string, 'UTF-8') > $length)
        {
            $length -= min($length, mb_strlen($etc, 'UTF-8'));
            if (!$break_words && !$middle)
            {
                $string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $length + 1, $charset));
            }
            if (!$middle)
            {
                return mb_substr($string, 0, $length, $charset) . $etc;
            } else
            {
                return mb_substr($string, 0, $length / 2, $charset) . $etc . mb_substr($string, -$length / 2, $charset);
            }
        } else
        {
            return $string;
        }
    }

    /**
     * Truncates text.
     * Modified version of cakephp truncate.
     *
     * Cuts a string to the length of $length and replaces the last characters
     * with the ellipsis if the text is longer than length.
     *
     * ### Options:
     *
     * - `ellipsis` Will be used as Ending and appended to the trimmed string (`ending` is deprecated)
     * - `exact` If false, $text will not be cut mid-word
     * - `html` If true, HTML tags would be handled correctly
     *
     * @param string $text String to truncate.
     * @param int $length Length of returned string, including ellipsis.
     * @param array $options An array of html attributes and options.
     * @return string Trimmed string.
     * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/text.html#TextHelper::truncate
     */
    public static function truncateHtml($text, $length = 100, $options = array())
    {
        $defaults = array(
            'ellipsis' => '...', 'exact' => false, 'html' => true
        );
        if (isset($options['ending']))
        {
            $defaults['ellipsis'] = $options['ending'];
        } elseif (!empty($options['html']))
        {
            $defaults['ellipsis'] = "\xe2\x80\xa6";
        }
        $options += $defaults;
        extract($options);

        if (!function_exists('mb_strlen'))
        {
            class_exists('Multibyte');
        }

        if ($html)
        {
            if (mb_strlen(preg_replace('/<.*?>/', '', $text), 'UTF-8') <= $length)
            {
                return $text;
            }
            $totalLength = mb_strlen(strip_tags($ellipsis), 'UTF-8');
            $openTags = array();
            $truncate = '';

            preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
            foreach ($tags as $tag)
            {
                if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2]))
                {
                    if (preg_match('/<[\w]+[^>]*>/s', $tag[0]))
                    {
                        array_unshift($openTags, $tag[2]);
                    } elseif (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag))
                    {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false)
                        {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
                $truncate .= $tag[1];

                $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]), 'UTF-8');
                if ($contentLength + $totalLength > $length)
                {
                    $left = $length - $totalLength;
                    $entitiesLength = 0;
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE))
                    {
                        foreach ($entities[0] as $entity)
                        {
                            if ($entity[1] + 1 - $entitiesLength <= $left)
                            {
                                $left--;
                                $entitiesLength += mb_strlen($entity[0], 'UTF-8');
                            } else
                            {
                                break;
                            }
                        }
                    }

                    $truncate .= mb_substr($tag[3], 0, $left + $entitiesLength, 'UTF-8');
                    break;
                } else
                {
                    $truncate .= $tag[3];
                    $totalLength += $contentLength;
                }
                if ($totalLength >= $length)
                {
                    break;
                }
            }
        } else
        {
            if (mb_strlen($text, 'UTF-8') <= $length)
            {
                return $text;
            }
            $truncate = mb_substr($text, 0, $length - mb_strlen($ellipsis, 'UTF-8'), 'UTF-8');
        }
        if (!$exact)
        {
            $spacepos = mb_strrpos($truncate, ' ', 'UTF-8');
            if ($html)
            {
                $truncateCheck = mb_substr($truncate, 0, $spacepos, 'UTF-8');
                $lastOpenTag = mb_strrpos($truncateCheck, '<', 'UTF-8');
                $lastCloseTag = mb_strrpos($truncateCheck, '>', 'UTF-8');
                if ($lastOpenTag > $lastCloseTag)
                {
                    preg_match_all('/<[\w]+[^>]*>/s', $truncate, $lastTagMatches);
                    $lastTag = array_pop($lastTagMatches[0]);
                    $spacepos = mb_strrpos($truncate, $lastTag, 'UTF-8') + mb_strlen($lastTag, 'UTF-8');
                }
                $bits = mb_substr($truncate, $spacepos, 'UTF-8');
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags))
                {
                    if (!empty($openTags))
                    {
                        foreach ($droppedTags as $closingTag)
                        {
                            if (!in_array($closingTag[1], $openTags))
                            {
                                array_unshift($openTags, $closingTag[1]);
                            }
                        }
                    } else
                    {
                        foreach ($droppedTags as $closingTag)
                        {
                            $openTags[] = $closingTag[1];
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, 0, $spacepos, 'UTF-8');
        }
        $truncate .= $ellipsis;

        if ($html)
        {
            foreach ($openTags as $tag)
            {
                $truncate .= '</' . $tag . '>';
            }
        }

        return $truncate;
    }

    static function rus2latin($str)
    {
        $iso = array(
            "Є" => "YE", "І" => "I", "Ѓ" => "G", "і" => "i", "№" => "#", "є" => "ye", "ѓ" => "g",
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
            "Е" => "E", "Ё" => "YO", "Ж" => "ZH",
            "З" => "Z", "И" => "I", "Й" => "J", "К" => "K", "Л" => "L",
            "М" => "M", "Н" => "N", "О" => "O", "П" => "P", "Р" => "R",
            "С" => "S", "Т" => "T", "У" => "U", "Ф" => "F", "Х" => "X",
            "Ц" => "C", "Ч" => "CH", "Ш" => "SH", "Щ" => "SHH", "Ъ" => "'",
            "Ы" => "Y", "Ь" => "", "Э" => "E", "Ю" => "YU", "Я" => "YA",
            "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
            "е" => "e", "ё" => "yo", "ж" => "zh",
            "з" => "z", "и" => "i", "й" => "j", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "x",
            "ц" => "c", "ч" => "ch", "ш" => "sh", "щ" => "shh", "ъ" => "",
            "ы" => "y", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya",
            "'" => "", "\"" => "", " " => "-"
        );

        return strtr($str, $iso);
    }

    public static function clear($str)
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $str);
    }

    public static function clearId($str)
    {
        return preg_replace('/[^a-zA-Z0-9_\-~\.@]/', '', $str);
    }

    public static function clear_utf8($str)
    {
        $str = preg_replace("/[^\pL\s\d\-\.\+_]+/ui", '', $str);
        $str = preg_replace("/\s+/ui", ' ', $str);
        return $str;
    }

    private static function get_random($matches)
    {
        $rand = array_rand($split = explode("|", $matches[1]));
        return $split[$rand];
    }

    public static function spin($str)
    {
//$new_str = preg_replace_callback('/\{([^{}]*)\}/uim', array('TextHelper', 'get_random'), $str);
        $new_str = preg_replace_callback(
                '/\{([^{}]*)\}/uim', function ($matches) {
            $rand = array_rand($split = explode("|", $matches[1]));
            return $split[$rand];
        }
                , $str);
        if ($new_str !== $str)
            $str = TextHelper::spin($new_str);
        return $str;
    }

    /* bool/array unserialize_xml ( string $input [ , callback $callback ] )
     * Unserializes an XML string, returning a multi-dimensional associative array, optionally runs a callback on all non-array data
     * Returns false on all failure
     * Notes:
     * Root XML tags are stripped
     * Due to its recursive nature, unserialize_xml() will also support SimpleXMLElement objects and arrays as input
     * Uses simplexml_load_string() for XML parsing, see SimpleXML documentation for more info
     */

    static public function unserialize_xml($input, $callback = null, $recurse = false)
    {
        //Отключение ошибок libxml 
        libxml_use_internal_errors(false);

        // Get input, loading an xml string with simplexml if its the top level of recursion
        $data = ((!$recurse) && is_string($input)) ? @simplexml_load_string($input, '\SimpleXMLElement', LIBXML_NOCDATA) : $input;

        // Convert SimpleXMLElements to array
        if ($data instanceof \SimpleXMLElement)
            $data = (array) $data;

        // Recurse into arrays
        if (is_array($data))
            foreach ($data as &$item)
                $item = self::unserialize_xml($item, $callback, true);
        // Run callback and return
        return (!is_array($data) && is_callable($callback)) ? call_user_func($callback, $data) : $data;
    }

    static public function br2nl($str)
    {
        return str_ireplace(array("<br />", "<br>", "<br/>"), "\r\n", $str);
    }

    static public function nl2br($str)
    {
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $str);
    }

    static public function removeExtraBreaks($str)
    {
        return trim(preg_replace("/(\r\n)+/i", "\r\n", $str));
    }

    /**
     * 10.55 -> 1055 & 1055 -> 10.55
     */
    static public function pricePenniesDenomination($p, $to_int = true)
    {
        if ($to_int)
            $p = number_format($p, 2, '', '');
        else
            $p = number_format(preg_replace("/(\d+)(\d{2}$)/msi", '${1}.${2}', $p), 2, '.', '');

        return $p;
    }

    static public function currencyTyping($c)
    {
        return TemplateHelper::currencyTyping($c);
    }

    public static function safeHtml($html, $type)
    {
        $allowed = array(
            'p' => array(),
            'h1' => array(),
            'h2' => array(),
            'h3' => array(),
            'h4' => array(),
            'h5' => array(),
            'b' => array(),
            'i' => array(),
            'strong' => array(),
            'em' => array(),
            'ul' => array(),
            'ol' => array(),
            'li' => array(),
            'br' => array(),
            'hr' => array(),
            'em' => array(),
        );
        switch ($type)
        {
            case 'allow_all':
                return $html;
            // Безопасный HTML
            case 'safe_html':
                return \wp_kses_post($html);
            // Разрешенные HTML теги
            case 'allowed_tags':
                return \wp_kses($html, $allowed);
            default:
                // @todo: add safe strip_tags
                return strip_tags($html);
        }
    }

    public static function commaList($str, $input_delimer = ',', $return_delimer = ',')
    {
        $parts = explode($input_delimer, $str);
        $parts = array_map('trim', $parts);
        return join($return_delimer, $parts);
    }

    public static function prepareKeywords(array $keywords)
    {
        $result = array();
        foreach ($keywords as $keyword)
        {
            $keyword = \sanitize_text_field($keyword);
            $keyword = trim($keyword);
            if (!$keyword)
                continue;
            $result[] = $keyword;
        }
        return $result;
    }

    public static function parsePriceAmount($money)
    {
        if (is_float($money) || is_int($money))
            return $money;
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousendSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '', $stringWithCommaOrDot);

        return (float) str_replace(',', '.', $removedThousendSeparator);
    }

    public static function randomPassword($len = 8)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array();
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $len; $i++)
        {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public static function getHostName($url)
    {
        return TextHelper::getDomainWithoutSubdomain(strtolower(str_ireplace('www.', '', parse_url($url, PHP_URL_HOST))));
    }

    public static function parseDomain($url, $go_param)
    {
        if (!$query = parse_url($url, PHP_URL_QUERY))
            return '';
        parse_str($query, $arr);
        if (isset($arr[$go_param]))
            return TextHelper::getHostName($arr[$go_param]);
        else
            return '';
    }

    public static function getDomainWithoutSubdomain($domain)
    {
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs))
        {
            return $regs['domain'];
        }
        return $domain;
    }

}
