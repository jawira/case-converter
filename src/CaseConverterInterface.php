<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

/**
 * Interface CaseConverterInterface
 *
 * @author  Jawira Portugal <dev@tugal.be>
 */
interface CaseConverterInterface
{
    public function convert(string $source): Convert;
}
