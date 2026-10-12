<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Glue;

/**
 * Class DotNotation.
 *
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
class DotNotation extends Gluer
{
  /** @internal */
  public const DELIMITER = '.';

  /**
   * Format detected words in _dot notation_.
   */
  public function glue(): string
  {
    return $this->glueUsingRules(self::DELIMITER, $this->lowerCase);
  }
}
