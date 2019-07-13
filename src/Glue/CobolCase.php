<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

class CobolCase extends DashGluer
{
    public function glue(): string
    {
        return $this->glueUsingRules(self::DELIMITER, $this->upperCase);
    }
}
