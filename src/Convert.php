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
    const ENCODING = 'UTF-8';

    // String separators
    const DASH         = '-';
    const UNDERSCORE   = '_';
    const EMPTY_STRING = '';

    // Strategies
    const STRATEGY_DASH       = 'dash';
    const STRATEGY_UNDERSCORE = 'underscore';
    const STRATEGY_UPPERCASE  = 'uppercase';

    // Naming conventions
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
        if (mb_strpos($input, self::UNDERSCORE)) {
            // Strings like "MARIO_WORLD"
            $strategy = self::STRATEGY_UNDERSCORE;
        } elseif (mb_strpos($input, self::DASH)) {
            // Strings like "Judo-Boy"
            $strategy = self::STRATEGY_DASH;
        } elseif ($this->isUppercaseWord($input)) {
            // Strings like "DROMEDARY"
            $strategy = self::STRATEGY_UNDERSCORE;
        } else {
            // Strings like "getLastName"
            $strategy = self::STRATEGY_UPPERCASE;
        }

        return $strategy;
    }

    /**
     * Returns true if $input string is a single word composed only by uppercase characters.
     *
     * ```
     * isUppercaseWord('BRUSSELS'); // true
     * isUppercaseWord('Brussels'); // false
     * ```
     *
     * @see     https://www.regular-expressions.info/unicode.html#category
     *
     * @param string $input String to be tested.
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
     * Splits $input using Uppercase letters.
     *
     * 1. First and underscore character '_' will be prepended before any
     * uppercase character. Now input string can be treated as an _snake case_
     * string.
     * 2. Convert::splitUnderscoreString() is called to split string from step 1.
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
     * ```
     * Example: thisIsCamelCase
     * ```
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
     * @param string $glue           Character to glue words. Even if is assumed your are using underscore or dash
     *                               character, this method should be capable to use any character as glue.
     * @param int    $mode           Case mode to apply to each word. Should be a valid mode for mb_convert_case()
     *                               function.
     * @param bool   $lowerCaseFirst Force using \MB_CASE_LOWER for the first word, this parameter is expected to be
     *                               true only for Camel case.
     *
     * @return string
     */
    protected function glueString(string $glue, int $mode, bool $lowerCaseFirst = false): string
    {
        assert(in_array($mode, [\MB_CASE_UPPER, \MB_CASE_LOWER, \MB_CASE_TITLE]), 'Invalid MB mode');

        $closure = function ($word) use ($mode) {
            return mb_convert_case($word, $mode, self::ENCODING);
        };

        $convertedWords = array_map($closure, $this->words);

        if ($lowerCaseFirst && count($this->words) > 0) {
            $convertedWords[0] = mb_convert_case($convertedWords[0], \MB_CASE_LOWER, self::ENCODING);
        }

        return implode($glue, $convertedWords);
    }

    /**
     * Return string in `Pascal case` format.
     *
     * ```
     * Example: ThisIsPascalCase
     * ```
     *
     * @return string
     */
    public function toPascal(): string
    {
        return $this->glueString(self::EMPTY_STRING, \MB_CASE_TITLE);
    }

    /**
     * Return string in `Snake case` format.
     *
     * ```
     * Example: this_is_snake_case
     * ```
     *
     * @return string
     */
    public function toSnake(): string
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_LOWER);
    }

    /**
     * Return string in `Macro case` format.
     *
     * ```
     * Example: THIS_IS_MACRO_CASE
     * ```
     *
     * @return string
     */
    public function toMacro(): string
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_UPPER);
    }

    /**
     * Return string in `Ada case` format.
     *
     * ```
     * Example: This_Is_Ada_Case
     * ```
     *
     * @return string
     */
    public function toAda(): string
    {
        return $this->glueString(self::UNDERSCORE, \MB_CASE_TITLE);
    }

    /**
     * Return string in `Kebab case` format.
     *
     * ```
     * Example: this-is-kebab-case
     * ```
     *
     * @return string
     */
    public function toKebab(): string
    {
        return $this->glueString(self::DASH, \MB_CASE_LOWER);
    }

    /**
     * Return string in `Cobol case` format.
     *
     * ```
     * Example: THIS-IS-COBOL-CASE
     * ```
     *
     * @return string
     */
    public function toCobol(): string
    {
        return $this->glueString(self::DASH, \MB_CASE_UPPER);
    }

    /**
     * Return string in `Train case` format.
     *
     * ```
     * Example: This-Is-Train-Case
     * ```
     *
     * @return string
     */
    public function toTrain(): string
    {
        return $this->glueString(self::DASH, \MB_CASE_TITLE);
    }

    /**
     * Detected words extracted from original string.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->words;
    }

}
