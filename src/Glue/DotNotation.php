<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

/**
 * Class DotNotation
 */
class DotNotation extends Gluer
{
    /** @internal */
    public const DELIMITER = '.';

    /**
     * Format detected words in _dot notation_
     *
     * @return string
     */
    public function glue(): string
    {
        return $this->glueUsingRules(self::DELIMITER, $this->lowerCase);
    }
}
