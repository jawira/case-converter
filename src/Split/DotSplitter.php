<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\Glue\DotNotation;

/**
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
class DotSplitter extends Splitter
{
  /** @internal */
  public const PATTERN = '#\\'.DotNotation::DELIMITER.'+#u';

  /**
   * @return string[]
   */
  public function split(): array
  {
    return $this->splitUsingPattern($this->inputString, self::PATTERN);
  }
}
