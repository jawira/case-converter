<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

use const MB_CASE_LOWER;
use const MB_CASE_TITLE;

class SentenceCase extends SpaceGluer
{
    public function glue(): string
    {
        return $this->glueUsingRules(self::DELIMITER, MB_CASE_LOWER, MB_CASE_TITLE);
    }
}
