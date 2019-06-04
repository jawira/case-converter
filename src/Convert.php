<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

use Countable;
use function count;
use function mb_strpos;
use function preg_match;
use const COUNT_NORMAL;

/**
 * Convert string between different naming conventions.
 *
 * Handled formats:
 *
 * - Ada case
 * - Camel case
 * - Cobol case
 * - Kebab case
 * - Lower case
 * - Macro case
 * - Pascal case
 * - Sentence case
 * - Snake case
 * - Title case
 * - Train case
 * - Upper case
 *
 * @see     https://softwareengineering.stackexchange.com/questions/322413/bothered-by-an-unknown-letter-case-name
 * @package Jawira\CaseConverter
 * @author  Jawira Portugal <dev@tugal.be>
 */
class Convert implements Countable
{
    /**
     * @var string[] Words extracted from input string
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
        $this->extractWords($input);
    }

    /**
     * Main function, receives input string and then it stores extracted words into an array.
     *
     * @param string $input
     *
     * @return $this
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function extractWords(string $input): self
    {
        /** @var \Jawira\CaseConverter\NamingConvention $strategy Class name */
        $strategy = $this->analyse($input);

        if (!is_subclass_of($strategy, NamingConvention::class)) {
            throw new CaseConverterException('Unknown naming convention');
        }

        $this->words = $strategy::split($input);

        return $this;
    }

    /**
     * Detects word separator of $input string and tells you what strategy you should use.
     *
     * @param string $input String to be analysed
     *
     * @return string Abstract class to use as strategy
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function analyse(string $input): string
    {
        if (mb_strpos($input, UnderscoreBased::DELIMITER)) {
            $strategy = UnderscoreBased::class;
        } elseif (mb_strpos($input, DashBased::DELIMITER)) {
            $strategy = DashBased::class;
        } elseif (mb_strpos($input, SpaceBased::DELIMITER)) {
            $strategy = SpaceBased::class;
        } elseif ($this->isUppercaseWord($input)) {
            $strategy = UnderscoreBased::class;
        } else {
            $strategy = UppercaseBased::class;
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
     * Return a _Camel case_ string
     *
     * @return string
     * @deprecated This is a pet feature, not useful in real life
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
        return (new CamelCase($this->words))->glue();
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
        return (new PascalCase($this->words))->glue();
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
        return (new SnakeCase($this->words))->glue();
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
        return (new MacroCase($this->words))->glue();
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
        return (new AdaCase($this->words))->glue();
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
        return (new KebabCase($this->words))->glue();
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
        return (new CobolCase($this->words))->glue();
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
        return (new TrainCase($this->words))->glue();
    }

    /**
     * Return string in `Title case` format.
     *
     * ```
     * Example: This Is Title Case
     * ```
     *
     * @return string
     */
    public function toTitle(): string
    {
        return (new TitleCase($this->words))->glue();
    }

    /**
     * Return string in `Upper case` format.
     *
     * ```
     * Example: THIS IS UPPER CASE
     * ```
     *
     * @return string
     */
    public function toUpper(): string
    {
        return (new UpperCase($this->words))->glue();
    }

    /**
     * Return string in `Lower case` format.
     *
     * ```
     * Example: this is lower case
     * ```
     *
     * @return string
     */
    public function toLower(): string
    {
        return (new LowerCase($this->words))->glue();
    }

    /**
     * Return string in `Sentence case` format.
     *
     * ```
     * Example: This is sentence case
     * ```
     *
     * @return string
     */
    public function toSentence(): string
    {
        return (new SentenceCase($this->words))->glue();
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

    /**
     * Count detected words
     *
     * @link       https://php.net/manual/en/countable.count.php
     *
     * @deprecated This is a pet feature, not useful in real life
     * @return int The custom count as an integer.
     */
    public function count(): int
    {
        return count($this->words, COUNT_NORMAL);
    }
}
