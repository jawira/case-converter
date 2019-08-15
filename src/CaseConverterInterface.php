<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

/**
 * Interface CaseConverterInterface
 *
 * @package Jawira\CaseConverter
 * @author  Jawira Portugal <dev@tugal.be>
 */
interface CaseConverterInterface
{
    public function convert(string $source): Convert;
}
