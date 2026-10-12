<?php declare(strict_types=1);

namespace Jawira\CaseConverter\Split;

use Jawira\CaseConverter\CaseConverterException;
use Jawira\CaseConverter\Glue\UnderscoreGluer;

/**
 * @author Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
class UnderscoreSplitter extends Splitter
{
  public const PATTERN = '#'.UnderscoreGluer::DELIMITER.'+#u';

  /**
   * @return string[]
   *
   * @throws CaseConverterException
   */
  public function split(): array
  {
    return $this->splitUsingPattern($this->inputString, self::PATTERN);
  }
}
