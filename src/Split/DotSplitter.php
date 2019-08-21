<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\Glue\DotNotation;
use Jawira\CaseConverter\Glue\SpaceGluer;

class DotSplitter extends Splitter
{
    const PATTERN = '\\' . DotNotation::DELIMITER . '+';

    /**
     * @return string[]
     */
    public function split(): array
    {
        return $this->splitUsingPattern($this->inputString, self::PATTERN);
    }
}
