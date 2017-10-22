<?php

namespace Jawira\CaseConverter;

class Convert
{
    const SNAKE = 'snake';
    const CAMEL = 'camel';

    protected $words = [];
    protected $detectedCase;

    function __construct($str)
    {
        $this->load($str);
    }

    public function load($str)
    {
        $this->detectedCase = $this->analyse($str);

        switch ($this->detectedCase) {
            case self::SNAKE:
                $this->words = $this->readSnake($str);
                break;
            case self::CAMEL:
            default:
                $this->words = $this->readCamel($str);
                break;
        }

        return $this;
    }

    /**
     * Detects the case type of $str
     *
     * @param $str
     *
     * @return string
     */
    protected function analyse($str)
    {
        return (mb_strpos($str, '_') !== false) ? self::SNAKE : self::CAMEL;
    }

    /**
     * Returns an CamelCase string
     *
     * @param boolean $uppercase First character must be uppercase
     *
     * @return string
     */
    public function toCamel($uppercase = false)
    {
        $copy = array_map(function ($w) {
            return ucfirst(mb_strtolower($w));
        }, $this->words);
        $str = implode('', $copy);

        return $uppercase ? ucfirst($str) : lcfirst($str);
    }

    /**
     * Returns an SnakeCase string
     *
     * @param bool|false $uppercase If true the result will be an Screaming Snake Case string
     *
     * @return string
     */
    public function toSnake($uppercase = false)
    {
        $str = implode('_', $this->words);
        return $uppercase ? mb_strtolower($str) : mb_strtoupper($str);
    }

    /**
     * @param $str
     *
     * @return array
     */
    protected function readSnake($str)
    {
        return array_filter(mb_split('_+', $str));
    }

    protected function readCamel($str)
    {
        $res = preg_replace_callback('/[[:upper:]]+/', function ($m) {
            return '_' . reset($m);
        }, $str);

        return $this->readSnake($res);
    }

    public function __toString()
    {
        return ($this->detectedCase === self::CAMEL) ? $this->toSnake() : $this->toCamel();
    }
}
