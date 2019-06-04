<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

use function preg_replace_callback;
use function reset;

abstract class UppercaseBased extends NamingConvention
{
    const DELIMITER = '';

    /**
     * Splits $words using Uppercase letters.
     *
     * 1. First and underscore character '_' will be prepended before any
     * uppercase character. Now input string can be treated as an _snake case_
     * string.
     * 2. Convert::splitUnderscoreString() is called to split string from step 1.
     *
     * @param string $words
     *
     * @return string[] Words in $input
     * @throws \Jawira\CaseConverter\CaseConverterException
     * @see https://www.regular-expressions.info/unicode.html#category
     */
    static public function split(string $words): array
    {
        $closure = function ($match) {
            return UnderscoreBased::DELIMITER . reset($match);
        };

        $result = preg_replace_callback('#\p{Lu}{1}#u', $closure, $words);

        if (is_null($result)) {
            throw new CaseConverterException("Error while processing '{$words}'");
        }

        return UnderscoreBased::split($result);
    }
}
