<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\Glue\SpaceGluer;

class SpaceSplitter extends Splitter
{
    /** @internal */
    public const PATTERN = '#' . SpaceGluer::DELIMITER . '+#u';

    /**
     * @return string[]
     * @throws \Jawira\CaseConverter\CaseConverterException
     */
    public function split(): array
    {
        return $this->splitUsingPattern($this->inputString, self::PATTERN);
    }
}
