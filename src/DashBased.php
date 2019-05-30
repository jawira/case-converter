<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

abstract class DashBased extends NamingConvention
{
    use SplitTrait;

    const DELIMITER = '-';
}
