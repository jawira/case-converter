<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

/**
 * Class CobolCase.
 *
 * Outputs string in _Cobol case_ format: THIS-IS-COBOL-CASE
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
class CobolCase extends DashGluer
{
  /**
   * Format detected words in _Cobol case_.
   */
  public function glue(): string
  {
    return $this->glueUsingRules(self::DELIMITER, $this->upperCase);
  }
}
