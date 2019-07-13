Examples
========

Basic usage
-----------

Code:

```php
<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Jawira\CaseConverter\Convert;

$robot = new Convert('The-Terminator');

echo $robot->toPascal() . PHP_EOL;
echo $robot->toCobol() . PHP_EOL;
echo $robot->toSnake() . PHP_EOL;
```

Output:

```text
TheTerminator
THE-TERMINATOR
the_terminator
```

Explicit case detection 
-----------------------

In some edge cases you have to explicitly set the format of input string to have 
the desired output:  

```php
<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Jawira\CaseConverter\Convert;

$agency = new Convert('FBI');

echo $agency->fromAda()
            ->toCobol() . PHP_EOL;   // output: FBI
echo $agency->toSnake() . PHP_EOL;   // output: fbi

echo $agency->fromCamel()
            ->toCobol() . PHP_EOL;   // output: F-B-I
echo $agency->toSnake() . PHP_EOL;   // output: f_b_i

echo $agency->fromAuto()
            ->toCobol() . PHP_EOL;   // output: FBI
echo $agency->toSnake() . PHP_EOL;   // output: fbi
```

Output:

```
FBI
fbi
F-B-I
f_b_i
FBI
fbi
```

Force _Simple Case-Mapping_
---------------------------

You can still use `Simple Case-Mapping` even if you are using PHP 7.3 or newer:

```php
<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Jawira\CaseConverter\Convert;

$robot = new Convert('Straße');

echo $robot->forceSimpleCaseMapping()->toMacro();
```

Output:

```
STRAßE
```

Learn more about [Full Case-Mapping]. 

[Full Case-Mapping]: https://jawira.github.io/case-converter/known-issues.html#full-case-mapping
