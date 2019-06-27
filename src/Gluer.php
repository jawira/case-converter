<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

use function array_map;
use function assert;
use function implode;
use function in_array;
use function mb_convert_case;
use const MB_CASE_LOWER;
use const MB_CASE_TITLE;
use const MB_CASE_UPPER;

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

    public function __construct(array $words)
    {
        $this->words = $words;
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
     * @param string $glue           Character to glue words. Even if is assumed your are using underscore or dash
     *                               character, this method should be capable to use any character as glue.
     * @param int    $wordsMode      The mode of the conversion. It should be one of MB_CASE_UPPER, MB_CASE_LOWER, or
     *                               MB_CASE_TITLE.
     * @param int    $firstWordMode  Sometimes first word requires special treatment. It should be one of
     *                               MB_CASE_UPPER, MB_CASE_LOWER, or MB_CASE_TITLE.
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
     * @param int      $caseMode It should be one of MB_CASE_UPPER, MB_CASE_LOWER, or MB_CASE_TITLE.
     *
     * @return string[]
     */
    protected function changeWordsCase(array $words, int $caseMode): array
    {
        assert(in_array($caseMode, [MB_CASE_UPPER, MB_CASE_LOWER, MB_CASE_TITLE]), 'Invalid MultiByte constant');

        if (empty($words)) {
            return $words;
        }

        $closure = function (string $word) use ($caseMode) {
            return mb_convert_case($word, $caseMode, self::ENCODING);
        };

        $convertedWords = array_map($closure, $words);

        return $convertedWords;
    }

    /**
     * Changes the case of first $words' element
     *
     * @param string[] $words    Words to modify
     * @param int      $caseMode It should be one of MB_CASE_UPPER, MB_CASE_LOWER, or MB_CASE_TITLE.
     *
     * @return string[]
     */
    protected function changeFirstWordCase(array $words, int $caseMode): array
    {
        assert(in_array($caseMode, [MB_CASE_UPPER, MB_CASE_LOWER, MB_CASE_TITLE]), 'Invalid MultiByte constant');

        if (empty($words)) {
            return $words;
        }

        $words[0] = mb_convert_case($words[0], $caseMode, self::ENCODING);

        return $words;
    }
}
