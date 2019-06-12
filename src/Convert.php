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
        $strategy = $this->analyse($input);

        if (!is_subclass_of($strategy, Splitter::class)) {
            throw new CaseConverterException('Unknown naming convention'); // @codeCoverageIgnore
        }

        $this->words = $strategy->split();

        return $this;
    }

    /**
     * Detects word separator of $input string and tells you what strategy you should use.
     *
     * @param string $input String to be analysed
     *
     * @return \Jawira\CaseConverter\Splitter
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function analyse(string $input): Splitter
    {
        if (mb_strpos($input, UnderscoreGluer::DELIMITER)) {
            $strategy = new UnderscoreSplitter($input);
        } elseif (mb_strpos($input, DashGluer::DELIMITER)) {
            $strategy = new DashSplitter($input);
        } elseif (mb_strpos($input, SpaceGluer::DELIMITER)) {
            $strategy = new SpaceSplitter($input);
        } elseif ($this->isUppercaseWord($input)) {
            $strategy = new UnderscoreSplitter($input);
        } else {
            $strategy = new UppercaseSplitter($input);
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

        if (false === $match) {
            throw new CaseConverterException('Error executing regex'); // @codeCoverageIgnore
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
        $namingConvention = $this->factory(CamelCase::class);

        return $namingConvention->glue();
    }

    /**
     * Creates a \Jawira\CaseConverter\NamingConvention concrete object
     *
     * @param string $className Class name
     *
     * @return \Jawira\CaseConverter\Gluer
     */
    protected function factory(string $className): Gluer
    {
        $parent = Gluer::class;
        assert(is_subclass_of($className, $parent), "$className is not a $parent subclass");

        return new $className($this->words);
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
        $namingConvention = $this->factory(PascalCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(SnakeCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(MacroCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(AdaCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(KebabCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(CobolCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(TrainCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(TitleCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(UpperCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(LowerCase::class);

        return $namingConvention->glue();
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
        $namingConvention = $this->factory(SentenceCase::class);

        return $namingConvention->glue();
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
