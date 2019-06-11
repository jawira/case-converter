<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

class SpaceSplitter extends Splitter
{
    const PATTERN = SpaceBased::DELIMITER . '+';

    public function split(): array
    {
        return $this->splitUsingPattern($this->inputString, self::PATTERN);
    }
}
