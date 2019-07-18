<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

class SentenceCase extends SpaceGluer
{
    public function glue(): string
    {
        return $this->glueUsingRules(self::DELIMITER, $this->lowerCase, $this->titleCase);
    }
}
