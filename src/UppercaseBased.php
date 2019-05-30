<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

abstract class UppercaseBased extends NamingConvention
{
    const DELIMITER = '';

    /**
     * @param string $words
     *
     * @return array
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    static public function split(string $words): array
    {
        $closure = function ($match) {
            return UnderscoreBased::DELIMITER . reset($match);
        };

        $result = preg_replace_callback('#\p{Lu}{1}#u', $closure, $words);

        if (is_null($result)) {
            throw new CaseConverterException("Error while processing $words");
        }

        return UnderscoreBased::split($result);
    }

}
