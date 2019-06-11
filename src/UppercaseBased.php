<?php declare(strict_types=1);

namespace Jawira\CaseConverter;

use function preg_replace_callback;
use function reset;

abstract class UppercaseBased extends Gluer
{
    const DELIMITER = '';
}
