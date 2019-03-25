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
     *
     * @param string $input
     *
     * @return bool
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function isUppercaseWord(string $input)
    {
        $match = preg_match('#^\p{Lu}+$#u', $input);

        if ($match === false) {
            throw new CaseConverterException('Error executing regex');
        }

        return $match === 1;
    }

    /**
     * Reads $input assuming is snake case string.
     *
     * @param string $input
     *
     * @return array
     */
    protected function splitUnderscoreString(string $input): array
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
    protected function splitString(string $pattern, string $input): array
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
    protected function splitDashString(string $input): array
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
     * Returns camel case string
     *
     * @example thisIsCamelCase
     *
     * @return string
     */
    public function toCamel()
    {
        return $this->glueString(self::EMPTY_STRING, \MB_CASE_TITLE, true);
    }

    /**
     * @param string $glue           Character to glue words
     * @param int    $mode           MB String constant
     * @param bool   $lowerCaseFirst Force using lower case for the first word
     *
     * @return string
     */
    protected function glueString(string $glue, int $mode, bool $lowerCaseFirst = false): string
    {
        assert(in_array($mode, [\MB_CASE_UPPER, \MB_CASE_LOWER, \MB_CASE_TITLE]), 'Invalid MB mode');

        $closure = function ($word) use ($mode) {
            return mb_convert_case($word, $mode, 'UTF-8');
        };

        $words = array_map($closure, $this->words);

        if ($lowerCaseFirst && count($this->words) > 0) {
            $words[0] = mb_convert_case($words[0], \MB_CASE_LOWER, 'UTF-8');
        }

        return implode($glue, $words);
    }

    /**
     * @example ThisIsPascalCase
     * @return string
     */
    public function toPascal(): string
    {
        return $this->glueString(self::EMPTY_STRING, \MB_CASE_TITLE);
    }

    /**
     * @example this_is_snake_case
     * @return string
     */
    public function toSnake(): string
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_LOWER);
    }

    /**
     * @example THIS_IS_MACRO_CASE
     * @return string
     */
    public function toMacro(): string
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_UPPER);
    }

    /**
     * @example This_Is_Ada_Case
     * @return string
     */
    public function toAda(): string
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_TITLE);
    }

    /**
     * @example this-is-kebab-case
     * @return string
     */
    public function toKebab(): string
    {
        return $this->glueString(self::DASH, \MB_CASE_LOWER);
    }

    /**
     * @example THIS-IS-COBOL-CASE
     * @return string
     */
    public function toCobol(): string
    {
        return $this->glueString(self::DASH, \MB_CASE_UPPER);
    }

    /**
     * @example This-Is-Train-Case
     * @return string
     */
    public function toTrain(): string
    {
        return $this->glueString(self::DASH, \MB_CASE_TITLE);
    }

}
