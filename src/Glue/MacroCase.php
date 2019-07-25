<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

class MacroCase extends UnderscoreGluer
{
    public function glue(): string
    {
        return $this->glueUsingRules(self::DELIMITER, $this->upperCase);
    }
}
