<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

use const MB_CASE_LOWER;

class KebabCase extends DashBased
{
    public function glue(): string
    {
        return $this->glueWithRules(self::DELIMITER, MB_CASE_LOWER);
    }
}
