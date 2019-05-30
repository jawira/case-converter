<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

abstract class SpaceBased extends NamingConvention
{
    use SplitTrait;

    const DELIMITER = ' ';
}
