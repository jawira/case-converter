<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

abstract class UnderscoreBased extends NamingConvention
{
    use SplitTrait;

    const DELIMITER = '_';
}
