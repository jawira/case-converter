<?php

namespace Jawira\CaseConverter;

class Convert
{
    const SNAKE = 'snake';
    const CAMEL = 'camel';

    protected $words = [];
    protected $detectedCase;

    /**
     * Convert constructor.
     *
     * @param $str String to convert
     */
    function __construct($str)
    {
        $this->load($str);
    }

    /**
     * @param $str
     *
     * @return $this
     */
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
     * Returns camel case string
     *
     * @param bool $uppercase
     *
     * @return string
     */
    public function toCamel($uppercase = false)
    {
        $copy = array_map(function ($w) {
            return ucfirst(mb_strtolower($w));
        }, $this->words);
        $result = implode('', $copy);

        return $uppercase ? ucfirst($result) : lcfirst($result);
    }

    /**
     * Returns snake case string
     *
     * @param bool $uppercase
     *
     * @return string
     */
    public function toSnake($uppercase = false)
    {
        $result = implode('_', $this->words);

        return $uppercase ? mb_strtoupper($result) : mb_strtolower($result);
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

    /**
     * @param $str
     *
     * @return array
     */
    protected function readCamel($str)
    {
        $res = preg_replace_callback('/[[:upper:]]+/', function ($m) {
            return '_' . reset($m);
        }, $str);

        return $this->readSnake($res);
    }

    /**
     * Magic function
     *
     * @return string
     */
    public function __toString()
    {
        return ($this->detectedCase === self::CAMEL) ? $this->toSnake() : $this->toCamel();
    }

}
