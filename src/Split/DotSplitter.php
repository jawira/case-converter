<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\Glue\DotNotation;

class DotSplitter extends Splitter
{
    /** @internal */
    public const PATTERN = '#\\' . DotNotation::DELIMITER . '+#u';

    /**
     * @return string[]
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function split(): array
    {
        return $this->splitUsingPattern($this->inputString, self::PATTERN);
    }
}
