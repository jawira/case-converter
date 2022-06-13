<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\Glue\UnderscoreGluer;

class UnderscoreSplitter extends Splitter
{
    public const PATTERN = '#' . UnderscoreGluer::DELIMITER . '+#u';

    /**
     * @return string[]
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function split(): array
    {
        return $this->splitUsingPattern($this->inputString, self::PATTERN);
    }
}
