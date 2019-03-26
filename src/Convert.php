<?php declare(strict_types=1);

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
    const DASH         = '-';
    const UNDERSCORE   = '_';
    const EMPTY_STRING = '';
    const ENCODING     = 'UTF-8';

    const STRATEGY_DASH       = 'dash';
    const STRATEGY_UNDERSCORE = 'underscore';
    const STRATEGY_UPPERCASE  = 'uppercase';

    const ADA    = 'Ada';
    const CAMEL  = 'Camel';
    const COBOL  = 'Cobol';
    const KEBAB  = 'Kebab';
    const MACRO  = 'Macro';
    const PASCAL = 'Pascal';
    const SNAKE  = 'Snake';
    const TRAIN  = 'Train';

    /**
     * @var array Words extracted from input string
     */
    protected $words;

    /**
     * Constructor method
     *
     * @param string $input String to convert
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct(string $input)
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
    protected function detectNamingConvention(string $input): self
    {
        switch ($this->analyse($input)) {
            case self::STRATEGY_UNDERSCORE:
                $this->words = $this->splitUnderscoreString($input);
                break;
            case self::STRATEGY_DASH:
                $this->words = $this->splitDashString($input);
                break;
            case self::STRATEGY_UPPERCASE:
                $this->words = $this->splitUppercaseString($input);
                break;
            default:
                throw new CaseConverterException('Unknown naming convention');
                break;
        }

        return $this;
    }

    /**
     * Detects word separator of $input string and tells you what strategy you should use.
     *
     * @param string $input String to be analysed
     *
     * @return string Strategy to use
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function analyse(string $input): string
    {
        // Strings like "MARIO_WORLD"
        if (mb_strpos($input, self::UNDERSCORE)) {
            return self::STRATEGY_UNDERSCORE;
        }

        // Strings like "Judo-Boy"
        if (mb_strpos($input, self::DASH)) {
            return self::STRATEGY_DASH;
        }

        // Strings like "DROMEDARY"
        if ($this->isUppercaseWord($input)) {
            return self::STRATEGY_UNDERSCORE;
        }

        // Strings like "getLastName"
        return self::STRATEGY_UPPERCASE;
    }

    /**
     * Returns true if $input string is a single word composed only by uppercase characters.
     *
     * @example isUppercaseWord('BRUSSELS'); // true
     * @example isUppercaseWord('Brussels'); // false
     * @see     https://www.regular-expressions.info/unicode.html#category
     *
     * @param string $input
     *
     * @return bool
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function isUppercaseWord(string $input): bool
    {
        $match = preg_match('#^\p{Lu}+$#u', $input);

        if ($match === false) {
            throw new CaseConverterException('Error executing regex');
        }

        return $match === 1;
    }

    /**
     * Splits $input using `_`
     *
     * @param string $input
     *
     * @return array Words in $input
     */
    protected function splitUnderscoreString(string $input): array
    {
        return $this->splitString(self::UNDERSCORE . '+', $input);
    }

    /**
     * Splits $input string using $pattern.
     *
     * @param string $pattern
     * @param string $input
     *
     * @return array Words in $input
     */
    protected function splitString(string $pattern, string $input): array
    {
        return array_values(array_filter(mb_split($pattern, $input)));
    }

    /**
     * Splits $input using dash `-`
     *
     * @param string $input
     *
     * @return array Words in $input
     */
    protected function splitDashString(string $input): array
    {
        return $this->splitString(self::DASH . '+', $input);
    }

    /**
     * Splits $input using Uppercase letters
     *
     * @param string $input
     *
     * @see https://www.regular-expressions.info/unicode.html#category
     *
     * @return array Words in $input
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function splitUppercaseString(string $input): array
    {
        $closure = function ($match) {
            return self::UNDERSCORE . reset($match);
        };

        $result = preg_replace_callback('#\p{Lu}{1}#u', $closure, $input);

        if (is_null($result)) {
            throw new CaseConverterException("Error while processing $input");
        }

        return $this->splitUnderscoreString($result);
    }

    /**
     * Return a _Camel case_ string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toCamel();
    }

    /**
     * Return string in `Camel case` format.
     *
     * @example thisIsCamelCase
     *
     * @return string
     */
    public function toCamel(): string
    {
        return $this->glueString(self::EMPTY_STRING, \MB_CASE_TITLE, true);
    }

    /**
     * Implode self::$words array using $glue.
     *
     * @param string $glue           Character to glue words
     * @param int    $mode           Case mode to apply to each word
     * @param bool   $lowerCaseFirst Force using \MB_CASE_LOWER for the first word
     *
     * @return string
     */
    protected function glueString(string $glue, int $mode, bool $lowerCaseFirst = false): string
    {
        assert(in_array($mode, [\MB_CASE_UPPER, \MB_CASE_LOWER, \MB_CASE_TITLE]), 'Invalid MB mode');

        $closure = function ($word) use ($mode) {
            return mb_convert_case($word, $mode, self::ENCODING);
        };

        $words = array_map($closure, $this->words);

        if ($lowerCaseFirst && count($this->words) > 0) {
            $words[0] = mb_convert_case($words[0], \MB_CASE_LOWER, self::ENCODING);
        }

        return implode($glue, $words);
    }

    /**
     * Return string in `Pascal case` format.
     *
     * @example ThisIsPascalCase
     * @return string
     */
    public function toPascal(): string
    {
        return $this->glueString(self::EMPTY_STRING, \MB_CASE_TITLE);
    }

    /**
     * Return string in `Snake case` format.
     *
     * @example this_is_snake_case
     * @return string
     */
    public function toSnake(): string
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_LOWER);
    }

    /**
     * Return string in `Macro case` format.
     *
     * @example THIS_IS_MACRO_CASE
     * @return string
     */
    public function toMacro(): string
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_UPPER);
    }

    /**
     * Return string in `Ada case` format.
     *
     * @example This_Is_Ada_Case
     * @return string
     */
    public function toAda(): string
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_TITLE);
    }

    /**
     * Return string in `Kebab case` format.
     *
     * @example this-is-kebab-case
     * @return string
     */
    public function toKebab(): string
    {
        return $this->glueString(self::DASH, \MB_CASE_LOWER);
    }

    /**
     * Return string in `Cobol case` format.
     *
     * @example THIS-IS-COBOL-CASE
     * @return string
     */
    public function toCobol(): string
    {
        return $this->glueString(self::DASH, \MB_CASE_UPPER);
    }

    /**
     * Return string in `Train case` format.
     *
     * @example This-Is-Train-Case
     * @return string
     */
    public function toTrain(): string
    {
        return $this->glueString(self::DASH, \MB_CASE_TITLE);
    }

}
