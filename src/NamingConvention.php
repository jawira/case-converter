<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

use function array_filter;
use function array_map;
use function array_values;
use function assert;
use function implode;
use function in_array;
use function mb_convert_case;
use function mb_split;

abstract class NamingConvention
{
    const ENCODING = 'UTF-8';

    /**
     * @var array Words extracted from input string
     */
    protected $words;

    public function __construct(array $words)
    {
        $this->words = $words;
    }

    abstract static public function split(string $words): array;

    /**
     * This is an utility method, typically this method is used by \Jawira\CaseConverter\NamingConvention::split
     *
     * @param string $words
     * @param string $pattern
     *
     * @return array
     */
    static protected function splitUsingPattern(string $words, string $pattern): array
    {
        return array_values(array_filter(mb_split($pattern, $words)));
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
     *                               MB_CASE_UPPER, or MB_CASE_LOWER.
     *
     * @return string
     */
    protected function glueWithRules(string $glue, int $wordsMode, int $firstWordMode = null): string
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
