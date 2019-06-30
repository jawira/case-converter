<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

use Jawira\CaseConverter\Glue\AdaCase;
use Jawira\CaseConverter\Glue\CamelCase;
use Jawira\CaseConverter\Glue\CobolCase;
use Jawira\CaseConverter\Glue\DashGluer;
use Jawira\CaseConverter\Glue\Gluer;
use Jawira\CaseConverter\Glue\KebabCase;
use Jawira\CaseConverter\Glue\LowerCase;
use Jawira\CaseConverter\Glue\MacroCase;
use Jawira\CaseConverter\Glue\PascalCase;
use Jawira\CaseConverter\Glue\SentenceCase;
use Jawira\CaseConverter\Glue\SnakeCase;
use Jawira\CaseConverter\Glue\SpaceGluer;
use Jawira\CaseConverter\Glue\TitleCase;
use Jawira\CaseConverter\Glue\TrainCase;
use Jawira\CaseConverter\Glue\UnderscoreGluer;
use Jawira\CaseConverter\Glue\UpperCase;
use Jawira\CaseConverter\Split\DashSplitter;
use Jawira\CaseConverter\Split\SpaceSplitter;
use Jawira\CaseConverter\Split\Splitter;
use Jawira\CaseConverter\Split\UnderscoreSplitter;
use Jawira\CaseConverter\Split\UppercaseSplitter;
use function is_subclass_of;
use function mb_strpos;
use function preg_match;

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
 * @method self fromCamel() Treat input string as Camel case
 * @method self fromPascal() Treat input string as Pascal case
 * @method self fromSnake() Treat input string as Snake case
 * @method self fromAda() Treat input string as Ada case
 * @method self fromMacro() Treat input string as Macro case
 * @method self fromKebab() Treat input string as Kebab case
 * @method self fromTrain() Treat input string as Train case
 * @method self fromCobol() Treat input string as Cobol case
 * @method self fromLower() Treat input string as Lower case
 * @method self fromUpper() Treat input string as Upper case
 * @method self fromTitle() Treat input string as Title case
 * @method self fromSentence() Treat input string as Sentence case
 *
 * @see     https://softwareengineering.stackexchange.com/questions/322413/bothered-by-an-unknown-letter-case-name
 * @see     http://www.unicode.org/charts/case/
 * @package Jawira\CaseConverter
 * @author  Jawira Portugal <dev@tugal.be>
 */
class Convert
{
    /**
     * @var string Input string to convert
     */
    protected $originalString;

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
        $this->originalString = $input;
        $this->fromAuto();
    }

    /**
     * Auto-detect naming convention
     *
     * @return \Jawira\CaseConverter\Convert
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function fromAuto(): self
    {
        $strategy = $this->analyse($this->originalString);
        $this->extractWords($strategy);

        return $this;
    }

    /**
     * Detects word separator of $input string and tells you what strategy you should use.
     *
     * @param string $input String to be analysed
     *
     * @return \Jawira\CaseConverter\Split\Splitter
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
     * Main function, receives input string and then it stores extracted words into an array.
     *
     * @param \Jawira\CaseConverter\Split\Splitter $splitter
     *
     * @return $this
     */
    protected function extractWords(Splitter $splitter): self
    {
        assert(is_subclass_of($splitter, Splitter::class), 'Unknown naming convention');

        $this->words = $splitter->split();

        return $this;
    }

    /**
     * Methods to explicitly define naming conventions for input string
     *
     * @param string $methodName
     * @param array  $arguments
     *
     * @return $this
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __call($methodName, $arguments): self
    {
        $strategy = null;
        switch ($methodName) {
            case 'fromCamel':
            case 'fromPascal':
                $strategy = new UppercaseSplitter($this->originalString);
                break;
            case 'fromSnake':
            case 'fromAda':
            case 'fromMacro':
                $strategy = new UnderscoreSplitter($this->originalString);
                break;
            case 'fromKebab':
            case 'fromTrain':
            case 'fromCobol':
                $strategy = new DashSplitter($this->originalString);
                break;
            case 'fromLower':
            case 'fromUpper':
            case 'fromTitle':
            case 'fromSentence':
                $strategy = new SpaceSplitter($this->originalString);
                break;
            default:
                throw new CaseConverterException("Unknown method: $methodName");
                break;
        }

        $this->extractWords($strategy);

        return $this;
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
     * @return \Jawira\CaseConverter\Glue\Gluer
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
}
