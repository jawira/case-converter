<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

use Jawira\CaseConverter\Glue\AdaCase;
use Jawira\CaseConverter\Glue\CamelCase;
use Jawira\CaseConverter\Glue\CobolCase;
use Jawira\CaseConverter\Glue\DashGluer;
use Jawira\CaseConverter\Glue\DotNotation;
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
use Jawira\CaseConverter\Split\DotSplitter;
use Jawira\CaseConverter\Split\SpaceSplitter;
use Jawira\CaseConverter\Split\Splitter;
use Jawira\CaseConverter\Split\UnderscoreSplitter;
use Jawira\CaseConverter\Split\UppercaseSplitter;
use function is_subclass_of;
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
 * @method self fromAda() Treat input string as _Ada case_
 * @method self fromCamel() Treat input string as _Camel case_
 * @method self fromCobol() Treat input string as _Cobol case_
 * @method self fromDot() Treat input string as _Dot notation_
 * @method self fromKebab() Treat input string as _Kebab case_
 * @method self fromLower() Treat input string as _Lower case_
 * @method self fromMacro() Treat input string as _Macro case_
 * @method self fromPascal() Treat input string as _Pascal case_
 * @method self fromSentence() Treat input string as _Sentence case_
 * @method self fromSnake() Treat input string as _Snake case_
 * @method self fromTitle() Treat input string as _Title case_
 * @method self fromTrain() Treat input string as _Train case_
 * @method self fromUpper() Treat input string as _Upper case_
 *
 * @method string toAda() Return string in _Ada case_ format
 * @method string toCamel() Return string in _Camel case_ format
 * @method string toCobol() Return string in _Cobol case_ format
 * @method string toDot() Return string in _Dot notation_
 * @method string toKebab() Return string in _Kebab case_ format
 * @method string toLower() Return string in _Lower case_ format
 * @method string toMacro() Return string in _Macro case_ format
 * @method string toPascal() Return string in _Pascal case_ format
 * @method string toSentence() Return string in _Sentence case_ format
 * @method string toSnake() Return string in _Snake case_ format
 * @method string toTitle() Return string in _Title case_ format
 * @method string toTrain() Return string in _Train case_ format
 * @method string toUpper() Return string in _Upper case_ format
 *
 * @see     https://softwareengineering.stackexchange.com/questions/322413/bothered-by-an-unknown-letter-case-name
 * @see     http://www.unicode.org/charts/case/
 * @author  Jawira Portugal <dev@tugal.be>
 */
class Convert
{
    /** @var string Input string to convert */
    protected string $source;

    /** @var string[] Words extracted from input string */
    protected array $words;

    protected bool $forceSimpleCaseMapping;

    /**
     * Constructor method
     *
     * @param string $source String to convert
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __construct(string $source)
    {
        $this->source                 = $source;
        $this->forceSimpleCaseMapping = false;
        $this->fromAuto();
    }

    /**
     * Handle `to*` methods and `from*` methods
     *
     * @param string  $methodName
     * @param mixed[] $arguments
     *
     * @return string|\Jawira\CaseConverter\Convert
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function __call(string $methodName, array $arguments)
    {
        $strStartsWith = static fn(string $haystack, string $needle): bool => 0 === mb_strpos($haystack, $needle);
        if ($strStartsWith($methodName, 'from')) {
            $result = $this->handleSplitterMethod($methodName);
        } elseif ($strStartsWith($methodName, 'to')) {
            $result = $this->handleGluerMethod($methodName);
        } else {
            throw new CaseConverterException("Unknown method: $methodName");
        }

        return $result;
    }

    /**
     * Auto-detect naming convention
     *
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function fromAuto(): self
    {
        $splitter = $this->analyse($this->source);
        $this->extractWords($splitter);

        return $this;
    }

    /**
     * Returns original input string
     *
     * @return string Original input string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Detected words extracted from original string.
     *
     * @return string[]
     */
    public function toArray(): array
    {
        return $this->words;
    }

    /**
     * Forces to use Simple Case-Mapping
     *
     * Call this method if you want to maintain the behaviour before PHP 7.3
     *
     * @see https://unicode.org/faq/casemap_charprop.html
     * @return \Jawira\CaseConverter\Convert
     */
    public function forceSimpleCaseMapping(): self
    {
        $this->forceSimpleCaseMapping = true;

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
        $strContains = static fn(string $input, string $needle): bool => is_int(mb_strpos($input, $needle));

        switch (true) {
            case $strContains($input, UnderscoreGluer::DELIMITER):
                $splittingStrategy = new UnderscoreSplitter($input);
                break;
            case $strContains($input, DashGluer::DELIMITER):
                $splittingStrategy = new DashSplitter($input);
                break;
            case $strContains($input, SpaceGluer::DELIMITER):
                $splittingStrategy = new SpaceSplitter($input);
                break;
            case $strContains($input, DotNotation::DELIMITER):
                $splittingStrategy = new DotSplitter($input);
                break;
            case $this->isUppercaseWord($input):
                $splittingStrategy = new UnderscoreSplitter($input);
                break;
            default:
                $splittingStrategy = new UppercaseSplitter($input);
                break;
        }

        return $splittingStrategy;
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

        return 1 === $match;
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
        $this->words = $splitter->split();

        return $this;
    }

    /**
     * Methods to explicitly define naming conventions for input string
     *
     * @param string $methodName
     *
     * @return $this
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function handleSplitterMethod(string $methodName): self
    {
        switch ($methodName) {
            case 'fromCamel':
            case 'fromPascal':
                $splitterName = UppercaseSplitter::class;
                break;
            case 'fromSnake':
            case 'fromAda':
            case 'fromMacro':
                $splitterName = UnderscoreSplitter::class;
                break;
            case 'fromKebab':
            case 'fromTrain':
            case 'fromCobol':
                $splitterName = DashSplitter::class;
                break;
            case 'fromLower':
            case 'fromUpper':
            case 'fromTitle':
            case 'fromSentence':
                $splitterName = SpaceSplitter::class;
                break;
            case 'fromDot':
                $splitterName = DotSplitter::class;
                break;
            default:
                throw new CaseConverterException("Unknown method: $methodName");
        }

        $splitter = $this->createSplitter($splitterName, $this->source);
        $this->extractWords($splitter);

        return $this;
    }

    /**
     * @param string $className Class name in string format
     * @param string $source    Input string to be split
     *
     * @return \Jawira\CaseConverter\Split\Splitter
     */
    protected function createSplitter(string $className, string $source): Splitter
    {
        assert(is_subclass_of($className, Splitter::class));

        return new $className($source);
    }

    /**
     * Handles all methods starting by `to*`
     *
     * @param string $methodName
     *
     * @return string
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    protected function handleGluerMethod(string $methodName): string
    {

        switch ($methodName) {
            case 'toAda':
                $className = AdaCase::class;
                break;
            case 'toCamel':
                $className = CamelCase::class;
                break;
            case 'toCobol':
                $className = CobolCase::class;
                break;
            case 'toKebab':
                $className = KebabCase::class;
                break;
            case 'toLower':
                $className = LowerCase::class;
                break;
            case 'toMacro':
                $className = MacroCase::class;
                break;
            case 'toPascal':
                $className = PascalCase::class;
                break;
            case 'toSentence':
                $className = SentenceCase::class;
                break;
            case 'toSnake':
                $className = SnakeCase::class;
                break;
            case 'toTitle':
                $className = TitleCase::class;
                break;
            case 'toTrain':
                $className = TrainCase::class;
                break;
            case 'toUpper':
                $className = UpperCase::class;
                break;
            case 'toDot':
                $className = DotNotation::class;
                break;
            default:
                throw new CaseConverterException("Unknown method: $methodName");
        }

        $gluer = $this->createGluer($className, $this->words, $this->forceSimpleCaseMapping);

        return $gluer->glue();
    }

    /**
     * @param string   $className              Class name in string format
     * @param string[] $words                  Words to glue
     * @param bool     $forceSimpleCaseMapping Should _Simple Case-Mapping_ be forced?
     *
     * @return \Jawira\CaseConverter\Glue\Gluer
     */
    protected function createGluer(string $className, array $words, bool $forceSimpleCaseMapping): Gluer
    {
        assert(is_subclass_of($className, Gluer::class));

        return new $className($words, $forceSimpleCaseMapping);
    }
}
