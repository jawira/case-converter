<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

/**
 * Class CaseConverter.
 *
 * Factory class which returns a Convert object.
 *
 * @author  Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
class CaseConverter implements CaseConverterInterface
{
  /**
   * Returns a Convert object.
   *
   * @param string $source Input string to be converted
   */
  public function convert(string $source): Convert
  {
    return new Convert($source);
  }
}
