<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

class LowerCase extends SpaceGluer
{
    public function glue(): string
    {
        return $this->glueUsingRules(self::DELIMITER, $this->lowerCase);
    }
}
