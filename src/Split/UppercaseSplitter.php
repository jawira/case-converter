<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

class UppercaseSplitter extends Splitter
{
    // language=PhpRegExp
    public const PATTERN = '#(?=\p{Lu}{1})#u';

    /**
     * Splits $words using Uppercase letters.
     *
     * @see https://www.regular-expressions.info/unicode.html#category
     * @return string[] Words in $input
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function split(): array
    {
        return $this->splitUsingPattern($this->inputString, self::PATTERN);
    }
}
