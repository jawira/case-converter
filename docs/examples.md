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

$agency->fromAda();
echo $agency->toCobol();   // output: FBI
echo $agency->toSnake();   // output: fbi

$agency->fromCamel();
echo $agency->toCobol();   // output: F-B-I
echo $agency->toSnake();   // output: f_b_i

$agency->fromAuto();
echo $agency->toCobol();   // output: FBI
echo $agency->toSnake();   // output: fbi
```

Force _Simple Case-Mapping_
---------------------------

You can still use _Simple Case-Mapping_ even if you are using PHP 7.3 or newer:

```php
<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Jawira\CaseConverter\Convert;

$robot = new Convert('Straße');

$robot->forceSimpleCaseMapping();
echo $robot->toMacro();     // output: STRAßE
echo $robot->toCobol();     // output: STRAßE
```

[Learn more about Case-Mapping][Case-Mapping]. 

[Case-Mapping]: https://jawira.github.io/case-converter/case-mapping.html
