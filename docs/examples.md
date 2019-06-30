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

Code:

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
