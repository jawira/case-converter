<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

use function array_filter;
use function array_values;
use function mb_split;

abstract class Splitter
{

    /**
     * @var string[] Words extracted from input string
     */
    protected $inputString;

    public function __construct(string $inputString)
    {
        $this->inputString = $inputString;
    }

    /**
     * Tells how to split a string into valid words.
     *
     * @return array
     */
    abstract public function split(): array;

    /**
     * This is an utility method, typically this method is used by to split a string based on pattern.
     *
     * @param string $words
     * @param string $pattern
     *
     * @return string[]
     */
    protected function splitUsingPattern(string $words, string $pattern): array
    {
        return array_values(array_filter(mb_split($pattern, $words)));
    }
}
