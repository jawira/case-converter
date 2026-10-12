<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

/**
 * Interface CaseConverterInterface.
 *
 * @author  Jawira Portugal <dev@tugal.be>
 * @copyright © 2015-2026 Jawira Portugal
 */
interface CaseConverterInterface
{
  public function convert(string $source): Convert;
}
