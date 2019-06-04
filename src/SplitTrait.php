<?php

namespace Jawira\CaseConverter;

trait SplitTrait
{
    /**
     * Generic split method.
     *
     * @param string $words
     *
     * @return array
     */
    static public function split(string $words): array
    {
        $pattern = self::DELIMITER . '+';

        return self::splitUsingPattern($words, $pattern);
    }
}
