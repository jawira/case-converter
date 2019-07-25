<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

class PascalCase extends UppercaseGluer
{
    public function glue(): string
    {
        return $this->glueUsingRules(self::DELIMITER, $this->titleCase);
    }
}
