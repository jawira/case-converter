<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

use function array_map;
use function implode;
use function mb_convert_case;
use const MB_CASE_LOWER;
use const MB_CASE_TITLE;
use const MB_CASE_UPPER;

/**
 * Class Gluer
 *
 * A Gluer sub-class allow to export an array of words in a single string
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @package Jawira\CaseConverter\Glue
 */
abstract class Gluer
{
    /**
     * Encoding to be used by `mb_convert_case()` function.
     *
     * This value should never change.
     */
    const ENCODING = 'UTF-8';

    /**
     * @var string[] Words extracted from input string
     */
    protected $words;

    /**
     * @var int MB_CASE_LOWER or MB_CASE_LOWER_SIMPLE
     */
    protected $lowerCase;

    /**
     * @var int MB_CASE_UPPER or MB_CASE_UPPER_SIMPLE
     */
    protected $upperCase;

    /**
     * @var int MB_CASE_TITLE or MB_CASE_TITLE_SIMPLE
     */
    protected $titleCase;


    /**
     * Gluer constructor.
     *
     * @param string[] $words
     * @param bool     $forceSimpleCaseMapping
     */
    final public function __construct(array $words, bool $forceSimpleCaseMapping)
    {
        $this->words     = $words;
        $this->lowerCase = MB_CASE_LOWER;
        $this->upperCase = MB_CASE_UPPER;
        $this->titleCase = MB_CASE_TITLE;

        if ($forceSimpleCaseMapping) {
            $this->setSimpleCaseMappingConstants();
        }
    }

    /**
     * Creates a string which respects concrete naming convention.
     *
     * @return string
     */
    abstract public function glue(): string;

    /**
     * Use new constants if available
     *
     * Since PHP 7.3, new constants are used to specify _simple case mapping_. This method handles these new constants.
     *
     * Usually you would use:
     *
     * - MB_CASE_LOWER
     * - MB_CASE_UPPER
     * - MB_CASE_TITLE
     *
     * But PHP 7.3 introduced new constants:
     *
     * - MB_CASE_LOWER_SIMPLE
     * - MB_CASE_UPPER_SIMPLE
     * - MB_CASE_TITLE_SIMPLE
     *
     * @see https://www.php.net/manual/en/migration73.constants.php#migration73.constants.mbstring
     * @see https://www.php.net/manual/en/migration73.new-features.php#migration73.new-features.mbstring.case-mapping-folding
     */
    protected function setSimpleCaseMappingConstants(): self
    {
        /** @var int $lowerCase */
        $lowerCase = defined('\MB_CASE_LOWER_SIMPLE') ? constant('\MB_CASE_LOWER_SIMPLE') : MB_CASE_LOWER;
        /** @var int $upperCase */
        $upperCase = defined('\MB_CASE_UPPER_SIMPLE') ? constant('\MB_CASE_UPPER_SIMPLE') : MB_CASE_UPPER;
        /** @var int $titleCase */
        $titleCase = defined('\MB_CASE_TITLE_SIMPLE') ? constant('\MB_CASE_TITLE_SIMPLE') : MB_CASE_TITLE;

        $this->lowerCase = $lowerCase;
        $this->upperCase = $upperCase;
        $this->titleCase = $titleCase;

        return $this;
    }

    /**
     * Implode self::$words array using $glue.
     *
     * @param string $glue           Character to glue words. Even if is assumed your are using underscore or dash
     *                               character, this method should be capable to use any character as glue.
     * @param int    $wordsMode      The mode of the conversion. It should be one of `Gluer::$lowerCase`,
     *                               `Gluer::$upperCase` or  `Gluer::$titleCase`.
     * @param int    $firstWordMode  Sometimes first word requires special treatment. It should be one of
     *                               `Gluer::$lowerCase`,  `Gluer::$upperCase` or  `Gluer::$titleCase`.
     *
     * @return string
     */
    protected function glueUsingRules(string $glue, int $wordsMode, int $firstWordMode = null): string
    {
        $convertedWords = $this->changeWordsCase($this->words, $wordsMode);

        if ($firstWordMode) {
            $convertedWords = $this->changeFirstWordCase($convertedWords, $firstWordMode);
        }

        return implode($glue, $convertedWords);
    }

    /**
     * Changes the case of every $words' element
     *
     * @param string[] $words    Words to modify
     * @param int      $caseMode It should be one of `Gluer::$lowerCase`,  `Gluer::$upperCase` or  `Gluer::$titleCase`.
     *
     * @return string[]
     */
    protected function changeWordsCase(array $words, int $caseMode): array
    {
        if (empty($words)) {
            return $words;
        }

        $closure = function (string $word) use ($caseMode): string {
            return mb_convert_case($word, $caseMode, self::ENCODING);
        };

        $convertedWords = array_map($closure, $words);

        return $convertedWords;
    }

    /**
     * Changes the case of first $words' element
     *
     * @param string[] $words    Words to modify
     * @param int      $caseMode It should be one of `Gluer::$lowerCase`,  `Gluer::$upperCase` or  `Gluer::$titleCase`.
     *
     * @return string[]
     */
    protected function changeFirstWordCase(array $words, int $caseMode): array
    {
        if (empty($words)) {
            return $words;
        }

        $words[0] = mb_convert_case($words[0], $caseMode, self::ENCODING);

        return $words;
    }

}
