<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\Glue\DashGluer;

class DashSplitter extends Splitter
{
    /** @internal */
    public const PATTERN = '#' . DashGluer::DELIMITER . '+#u';

    /**
     * @return string[]
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function split(): array
    {
        return $this->splitUsingPattern($this->inputString, self::PATTERN);
    }
}
