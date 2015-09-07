<?php
/**
 * Created by PhpStorm.
 * User: jawira
 * Date: 07/09/2015
 * Time: 23:02
 */

namespace Jawira\WordsCase;


class WordsCase
{
    /**
     * Converts a Camel Case string to Snake Case
     *
     * @param $str
     * @param bool|false $upper
     * @return string
     */
    public static function camelToSnake($str, $upper = false)
    {
        $res = preg_replace_callback('|[A-Z]{1,}|', function ($m) {
            return '_' . reset($m);
        }, $str);
        $res = trim($res, '_');
        return ($upper)?mb_strtoupper($res):mb_strtolower($res);
    }

    /**
     * Converts a Snake Case string to Camel Case
     * @param $str
     * @param bool|false $upper
     * @return string
     */
    public static function snakeToCamel($str, $upper = false)
    {
        $res = preg_replace_callback('|_{1,}\w|', function ($m) {
            return mb_strtoupper(trim(reset($m), '_'));
        }, $str);
        return $upper ? ucfirst($res) : lcfirst($res);
    }
}