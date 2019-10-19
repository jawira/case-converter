<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\CaseConverterException;
use Jawira\CaseConverter\Glue\UnderscoreGluer;

class UppercaseSplitter extends Splitter
{
    /** @lang PhpRegExp */
    const PATTERN = '#(?=\p{Lu}{1})#u';

    /**
     * Splits $words using Uppercase letters.
     *
     * @see https://www.regular-expressions.info/unicode.html#category
     * @return string[] Words in $input
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function split(): array
    {
        $words = preg_split(self::PATTERN, $this->inputString, 0, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        if ($words === false) {
            throw new CaseConverterException("Error while processing '{$this->inputString}'"); // @codeCoverageIgnore
        }

        return $words;
    }
}
