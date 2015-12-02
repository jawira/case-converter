<?php

namespace Jawira\CaseConverter;

class Convert
{
    const SNAKE = 'snake';
    const CAMEL = 'camel';
    const AUTO = 'auto';

    protected $original = '';
    protected $words = [];

    function __construct($str)
    {
        $this->load($str);
    }

    public function load($str, $type = self::AUTO)
    {
        if (is_string($str)) {

            $strategy = $this->analyse();

            switch ($strategy) {
                case self::SNAKE:
                    $this->original = $str;
                    $this->words = array_filter(mb_split('_+', $str));
                    break;
                case self::CAMEL:
                    $this->original = $str;

                    break;
            }

        }
        return $this;
    }

    // Returns if
    protected function analyse($str)
    {
        return (mb_strpos($str, '_') !== false) ? self::SNAKE : self::CAMEL;
    }

    /**
     * Returns an CamelCase string
     *
     * @param bool|false $upper If true the result will be Pascal Case.
     * @param bool|false $private If true the result will start with an underscore
     * @return string
     */
    public function camel($upper = false, $private = false)
    {
        $copy = array_map(function ($w) {
            return ucfirst(mb_strtolower($w));
        }, $this->words);
        $str = implode('', $copy);

        return $private ? '_' : '' . $upper ? ucfirst($str) : lcfirst($str);
    }

    /**
     * Returns an SnakeCase string
     *
     * @param bool|false $upper If true the result will be an Screaming Snake Case string
     * @return string
     */
    public function snake($upper = false)
    {
        $str = implode('_', $this->words);
        return $upper ? mb_strtolower($str) : mb_strtoupper($str);
    }




    /**
     * Converts a Camel Case string to Snake Case
     *
     * @param $str
     * @param bool|false $upper
     * @return string
     */
    public static function old_camelToSnake($str, $upper = false)
    {
        $res = preg_replace_callback('|[A-Z]{1,}|', function ($m) {
            return '_' . reset($m);
        }, $str);
        $res = trim($res, '_');
        return $upper ? mb_strtoupper($res) : mb_strtolower($res);
    }

    /**
     * Converts a Snake Case string to Camel Case
     *
     * @param $str
     * @param bool|false $upper
     * @return string
     */
    public static function old_snakeToCamel($str, $upper = false)
    {
        $res = preg_replace_callback('|_{1,}\w|', function ($m) {
            return mb_strtoupper(trim(reset($m), '_'));
        }, $str);
        return $upper ? ucfirst($res) : lcfirst($res);
    }
}