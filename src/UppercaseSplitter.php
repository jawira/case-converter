<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

class UppercaseSplitter extends Splitter
{
    /**
     * Splits $words using Uppercase letters.
     *
     * 1. First and underscore character '_' will be prepended before any
     * uppercase character. Now input string can be treated as an _snake case_
     * string.
     * 2. Convert::splitUnderscoreString() is called to split string from step 1.
     *
     * @return string[] Words in $input
     * @throws \Jawira\CaseConverter\CaseConverterException
     * @see https://www.regular-expressions.info/unicode.html#category
     */
    public function split(): array
    {
        $closure = function ($match) {
            return UnderscoreBased::DELIMITER . reset($match);
        };

        $result = preg_replace_callback('#\p{Lu}{1}#u', $closure, $this->inputString);

        if (is_null($result)) {
            throw new CaseConverterException("Error while processing '{$this->inputString}'");
        }

        return $this->splitUsingUnderscore($result);
    }

    protected function splitUsingUnderscore(string $result)
    {
        return (new UnderscoreSplitter($result))->split();
    }
}
