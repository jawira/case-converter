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
 * A Gluer subclass allow to export an array of words in a single string
 *
 * @author Jawira Portugal <dev@tugal.be>
 */
abstract class Gluer
{
    /**
     * Encoding to be used by `mb_convert_case()` function.
     *
     * This value should never change.
     */
    protected const ENCODING = 'UTF-8';

    /**
     * @var string[] Words extracted from input string
     */
    protected array $words;

    /**
     * @var int MB_CASE_LOWER or MB_CASE_LOWER_SIMPLE
     */
    protected int $lowerCase;

    /**
     * @var int MB_CASE_UPPER or MB_CASE_UPPER_SIMPLE
     */
    protected int $upperCase;

    /**
     * @var int MB_CASE_TITLE or MB_CASE_TITLE_SIMPLE
     */
    protected int $titleCase;


    /**
     * Gluer constructor.
     *
     * @param string[] $words
     * @param bool     $forceSimpleCaseMapping
     */
    final public function __construct(array $words, bool $forceSimpleCaseMapping)
    {
        $this->words     = $words;
        $this->lowerCase = $forceSimpleCaseMapping ? MB_CASE_LOWER_SIMPLE : MB_CASE_LOWER;
        $this->upperCase = $forceSimpleCaseMapping ? MB_CASE_UPPER_SIMPLE : MB_CASE_UPPER;
        $this->titleCase = $forceSimpleCaseMapping ? MB_CASE_TITLE_SIMPLE : MB_CASE_TITLE;
    }

    /**
     * Creates a string which respects concrete naming convention.
     *
     * @return string
     */
    abstract public function glue(): string;

    /**
     * Implode self::$words array using $glue.
     *
     * @param string   $glue          Character to glue words. Even if is assumed you are using underscore or dash character, this method should be capable to use any character as glue.
     * @param int      $wordsMode     The mode of the conversion. It should be one of `Gluer::$lowerCase`, `Gluer::$upperCase` or  `Gluer::$titleCase`.
     * @param null|int $firstWordMode Sometimes first word requires special treatment. It should be one of `Gluer::$lowerCase`,  `Gluer::$upperCase` or  `Gluer::$titleCase`.
     *
     * @return string Converted words.
     */
    protected function glueUsingRules(string $glue, int $wordsMode, ?int $firstWordMode = null): string
    {
        $convertedWords = $this->changeWordsCase($this->words, $wordsMode);

        if (is_int($firstWordMode)) {
            $convertedWords = $this->changeFirstWordCase($convertedWords, $firstWordMode);
        }

        return implode($glue, $convertedWords);
    }

    /**
     * Changes the case of every $words element
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

        $convertCase = static fn(string $word): string => mb_convert_case($word, $caseMode, self::ENCODING);

        return array_map($convertCase, $words);
    }

    /**
     * Changes the case of first $words element
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
