<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\Glue\UnderscoreGluer;

class UnderscoreSplitter extends Splitter
{
    const PATTERN = UnderscoreGluer::DELIMITER . '+';

    /**
     * @return string[]
     */
    public function split(): array
    {
        return $this->splitUsingPattern($this->inputString, self::PATTERN);
    }
}
