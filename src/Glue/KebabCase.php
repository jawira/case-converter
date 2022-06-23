<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

/**
 * Class KebabCase
 *
 * Outputs string in _Cobol case_ format: this-is-kebab-case
 */
class KebabCase extends DashGluer
{
    /**
     * Format detected words in _Kebab case_
     *
     * @return string
     */
    public function glue(): string
    {
        return $this->glueUsingRules(self::DELIMITER, $this->lowerCase);
    }
}
