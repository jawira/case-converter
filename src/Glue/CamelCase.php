<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

class CamelCase extends UppercaseGluer
{
    public function glue(): string
    {
        return $this->glueUsingRules(self::DELIMITER, $this->titleCase, $this->lowerCase);
    }
}
