<?php

namespace Jawira\CaseConverter;

class Convert
{
    const SNAKE = 'snake';
    const CAMEL = 'camel';

    protected $words;
    protected $detectedCase;

    /**
     * @param $str String to convert
     */
    function __construct($str)
    {
        $this->load($str);
    }

    /**
     * Entry function, receives $str to change case
     *
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
     * Detects if $str is camel case or snake case
     *
     * @param string $str String to be analysed
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
     * @param bool $uppercase Should first letter be in uppercase
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
     * @param bool $uppercase Returns string in uppercase
     *
     * @return string
     */
    public function toSnake($uppercase = false)
    {
        $result = implode('_', $this->words);

        return $uppercase ? mb_strtoupper($result) : mb_strtolower($result);
    }

    /**
     * Reads $str assuming is snake case string
     *
     * @param string $str
     *
     * @return array
     */
    protected function readSnake($str)
    {
        return array_filter(mb_split('_+', $str));
    }

    /**
     * Reads $str assuming is camel case string
     *
     * @param string $str
     *
     * @return array
     */
    protected function readCamel($str)
    {
        $res = preg_replace_callback('/[[:upper:]]+/', function ($match) {
            return '_' . reset($match);
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
