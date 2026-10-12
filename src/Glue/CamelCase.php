<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

/**
 * Class CamelCase.
 *
 * Outputs string in _Camel case_ format: thisIsCamelCase
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
class CamelCase extends UppercaseGluer
{
  /**
   * Format detected words in _Camel case_.
   */
  public function glue(): string
  {
    return $this->glueUsingRules(self::DELIMITER, $this->titleCase, $this->lowerCase);
  }
}
