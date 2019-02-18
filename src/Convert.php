<?php

namespace Jawira\CaseConverter;

/**
 * Convert string from Camel Case to Snake Case and vice versa
 *
 * @package Jawira\CaseConverter
 */
class Convert
{
    /**
     * Used to represent _snake case_ strings
     */
    const SNAKE = 'snake';

    /**
     * Used to represent _camel case_ strings
     */
    const CAMEL = 'camel';

    /**
     * @var array Stores words to be transformed to _camel case_ or _snake case_
     */
    protected $words;

    /**
     * @var string Type of writing detected by \Jawira\CaseConverter\Convert::analyse
     */
    protected $detectedCase;

    /**
     * @param string $str String to convert
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct($str)
    {
        $this->load($str);
    }

    /**
     * Entry function, receives $str to change case
     *
     * @param string $str
     *
     * @return $this
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function load($str)
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
        $result = '';

        foreach ($this->words as $key => $word) {
            $mode   = ($key === 0 && $uppercase === false) ? MB_CASE_LOWER : MB_CASE_TITLE;
            $result .= mb_convert_case($word, $mode);
        }

        return $result;
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
        $mode   = $uppercase ? MB_CASE_UPPER : MB_CASE_LOWER;

        return mb_convert_case($result, $mode);
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
        return array_values(array_filter(mb_split('_+', $str)));
    }

    /**
     * Reads $str assuming is camel case string
     *
     * @param string $str
     *
     * @see https://www.regular-expressions.info/unicode.html#category
     *
     * @return array
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function readCamel($str)
    {
        $res = preg_replace_callback('#\p{Lu}{1}#u', function ($match) {
            return '_' . reset($match);
        }, $str);

        if (is_null($res)) {
             throw new CaseConverterException("Error while processing $str");
        }

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
