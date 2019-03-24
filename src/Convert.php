<?php

namespace Jawira\CaseConverter;

/**
 * Convert string between different naming conventions.
 *
 * Handled formats:
 *
 * - Ada case
 * - Camel case
 * - Cobol case
 * - Kebab case
 * - Macro case
 * - Pascal case
 * - Snake case
 * - Train case
 *
 * @see     https://softwareengineering.stackexchange.com/questions/322413/bothered-by-an-unknown-letter-case-name
 * @package Jawira\CaseConverter
 * @author  Jawira Portugal
 */
class Convert
{
    /**
     * Glue used in _Kebab case_ strings
     */
    const DASH = '-';

    /**
     * Glue used in _Snake case_ strings
     */
    const UNDERSCORE = '_';

    /**
     * Identifier for _Snake case_ and _Pascal case_
     */
    const UPPERCASE = 'uppercase';

    /**
     * Identifier for _snake case_ strings
     */
    const SNAKE = 'snake';

    /**
     * Identifier for _camel case_ strings
     */
    const CAMEL = 'camel';

    /**
     * Identifier for _kebab case_ strings
     */
    const KEBAB = 'kebab';

    const ADA = 'ada';

    const MACRO = 'macro';

    const PASCAL = 'pascal';

    /**
     * @var array Words extracted from input string
     */
    protected $words;

    /**
     * @var string Detected naming convention
     *
     * @see https://en.wikipedia.org/wiki/Naming_convention_(programming)
     */
    protected $wordDivider;

    /**
     * @param string $input String to convert
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct($input)
    {
        $this->detectNamingConvention($input);
    }

    /**
     * Main function, receives input string and then it stores extracted words into an array.
     *
     * @param string $input
     *
     * @return $this
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function detectNamingConvention($input)
    {
        $this->wordDivider = $this->analyse($input);

        switch ($this->wordDivider) {
            case self::UNDERSCORE:
                $this->words = $this->splitUnderscoreString($input);
                break;
            case self::DASH:
                $this->words = $this->splitDashString($input);
                break;
            case self::UPPERCASE:
                $this->words = $this->splitUppercaseString($input);
                break;
            default:
                throw new CaseConverterException('Unknown naming convention');
                break;
        }

        return $this;
    }

    /**
     * Detects word separator of $input string.
     *
     * @param string $input String to be analysed
     *
     * @return string
     */
    protected function analyse($input)
    {
        if (mb_strpos($input, self::UNDERSCORE)) {
            return self::UNDERSCORE;
        }

        if (mb_strpos($input, self::DASH)) {
            return self::DASH;
        }

        return self::UPPERCASE;
    }

    /**
     * Reads $input assuming is snake case string.
     *
     * @param string $input
     *
     * @return array
     */
    protected function splitUnderscoreString($input)
    {
        return $this->splitString(self::UNDERSCORE . '+', $input);
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
    protected function splitDashString($input)
    {
        return $this->splitString(self::DASH . '+', $input);
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
    protected function splitUppercaseString($input)
    {
        $res = preg_replace_callback('#\p{Lu}{1}#u',
            function ($match) {
                return self::UNDERSCORE . reset($match);
            },
                                     $input);

        if (is_null($res)) {
            throw new CaseConverterException("Error while processing $input");
        }

        return $this->splitUnderscoreString($res);
    }

    /**
     * Return a _Camel case_ string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toCamel();
    }

    /**
     * Returns camel case string
     *
     * @param bool $uppercase Should first letter be in uppercase
     *
     * @example thisIsCamelCase
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
     * @example ThisIsPascalCase
     * @return string
     */
    public function toPascal()
    {
        return $this->toCamel(true);
    }

    /**
     * @example this_is_snake_case
     * @return string
     */
    public function toSnake()
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_LOWER);
    }

    /**
     * @param string $glue Character to glue words
     * @param int    $mode MB String constant
     *
     * @return string
     */
    protected function glueString($glue, $mode)
    {
        assert(in_array($mode, [\MB_CASE_UPPER, \MB_CASE_LOWER, \MB_CASE_TITLE]));

        $convertCase = function ($word) use ($mode) {
            return mb_convert_case($word, $mode);
        };

        $words = array_map($convertCase, $this->words);

        return implode($glue, $words);
    }

    /**
     * @example THIS_IS_MACRO_CASE
     * @return string
     */
    public function toMacro()
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_UPPER);
    }

    /**
     * @example This_Is_Ada_Case
     * @return string
     */
    public function toAda()
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_TITLE);
    }

    /**
     * @example this-is-kebab-case
     * @return string
     */
    public function toKebab()
    {
        return $this->glueString(self::DASH, \MB_CASE_LOWER);
    }

    /**
     * @example THIS-IS-COBOL-CASE
     * @return string
     */
    public function toCobol()
    {
        return $this->glueString(self::DASH, \MB_CASE_UPPER);
    }

    /**
     * @example This-Is-Train-Case
     * @return string
     */
    public function toTrain()
    {
        return $this->glueString(self::DASH, \MB_CASE_TITLE);
    }

}
