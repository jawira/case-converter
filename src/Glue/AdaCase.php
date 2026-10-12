<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

/**
 * Class AdaCase.
 *
 * Outputs string in _Ada case_ format: This_Is_Ada_Case
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
class AdaCase extends UnderscoreGluer
{
  /**
   * Format detected words in _Ada case_.
   */
  public function glue(): string
  {
    return $this->glueUsingRules(self::DELIMITER, $this->titleCase);
  }
}
