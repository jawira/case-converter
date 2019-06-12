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
            return UnderscoreGluer::DELIMITER . reset($match);
        };

        $newString = preg_replace_callback('#\p{Lu}{1}#u', $closure, $this->inputString);

        if (is_null($newString)) {
            throw new CaseConverterException("Error while processing '{$this->inputString}'");
        }

        return $this->splitUsingUnderscore($newString);
    }

    protected function splitUsingUnderscore(string $inputString): array
    {
        return (new UnderscoreSplitter($inputString))->split();
    }
}
