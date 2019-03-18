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
     * Identifier for _snake case_ strings
     */
    const SNAKE = 'snake';

    /**
     * Glue used in _Snake case_ strings
     */
    const SNAKE_GLUE = '_';

    /**
     * Identifier for _camel case_ strings
     */
    const CAMEL = 'camel';

    /**
     * Identifier for _kebab case_ strings
     */
    const KEBAB = 'kebab';

    /**
     * Glue used in _Kebab case_ strings
     */
    const KEBAB_GLUE = '-';

    /**
     * @var array Words extracted from input string
     */
    protected $words;

    /**
     * @var string Detected naming convention
     *
     * @see https://en.wikipedia.org/wiki/Naming_convention_(programming)
     */
    protected $namingConvention;

    /**
     * @param string $input String to convert
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct($input)
    {
        $this->load($input);
    }

    /**
     * Main function, receives input string and then it stores extracted words into an array.
     *
     * @param string $input
     *
     * @return $this
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function load($input)
    {
        $this->namingConvention = $this->analyse($input);

        switch ($this->namingConvention) {
            case self::SNAKE:
                $this->words = $this->readSnake($input);
                break;
            case self::KEBAB:
                $this->words = $this->readKebab($input);
                break;
            case self::CAMEL:
            default:
                $this->words = $this->readCamel($input);
                break;
        }

        return $this;
    }

    /**
     * Detects naming convention of $input string.
     *
     * @param string $input String to be analysed
     *
     * @return string
     */
    protected function analyse($input)
    {
        if (mb_strpos($input, self::SNAKE_GLUE)) {
            return self::SNAKE;
        }

        if (mb_strpos($input, self::KEBAB_GLUE)) {
            return self::KEBAB;
        }

        return self::CAMEL;
    }

    /**
     * Reads $input assuming is snake case string.
     *
     * @param string $input
     *
     * @return array
     */
    protected function readSnake($input)
    {
        return $this->splitString(self::SNAKE_GLUE . '+', $input);
    }

    /**
     * Splits $input according to $pattern.
     *
     * @param string $pattern
     * @param string $input
     *
     * @return array
     */
    protected function splitString($pattern, $input)
    {
        return array_values(array_filter(mb_split($pattern, $input)));
    }

    /**
     * Returns words from $input, assuming it's in kebab case
     *
     * @param string $input
     *
     * @return array
     */
    protected function readKebab($input)
    {
        return $this->splitString(self::KEBAB_GLUE . '+', $input);
    }

    /**
     * Returns words from $input, assuming is camel case string
     *
     * @param string $input
     *
     * @see https://www.regular-expressions.info/unicode.html#category
     *
     * @return array
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function readCamel($input)
    {
        $res = preg_replace_callback('#\p{Lu}{1}#u',
            function ($match) {
                return self::SNAKE_GLUE . reset($match);
            },
                                     $input);

        if (is_null($res)) {
            throw new CaseConverterException("Error while processing $input");
        }

        return $this->readSnake($res);
    }

    /**
     * Return a Camel case or Snake case according to detected naming convention
     *
     * @return string
     */
    public function __toString()
    {
        // TODO v2 should always print in Camel case, no exceptions.
        return ($this->namingConvention === self::CAMEL) ? $this->toSnake() : $this->toCamel();
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
        $result = implode(self::SNAKE_GLUE, $this->words);
        $mode   = $uppercase ? \MB_CASE_UPPER : \MB_CASE_LOWER;

        return mb_convert_case($result, $mode);
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
            $mode   = ($key === 0 && $uppercase === false) ? \MB_CASE_LOWER : \MB_CASE_TITLE;
            $result .= mb_convert_case($word, $mode);
        }

        return $result;
    }

    /**
     * @param bool $uppercase
     *
     * @return string
     */
    public function toKebab($uppercase = false)
    {
        $words = array_map(function ($word) use ($uppercase) {
            $mode = $uppercase ? \MB_CASE_TITLE : \MB_CASE_LOWER;

            return mb_convert_case($word, $mode);
        },
            $this->words);

        return implode(self::KEBAB_GLUE, $words);
    }

}
