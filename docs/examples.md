Examples
========

To use **Case Converter** you have to instantiate `Convert` class, then you
should call `to*()` methods.

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
```

[Learn more about Case-Mapping][Case-Mapping].

Using the factory
-----------------

[CaseConverter factory] is going to instantiate `Convert` class for you.
Everything else is the same:


```php
// Convert string to Pascal case
$this->cc->convert('XML')->toPascal();          // Xml

// Convert string to Snake case
$this->cc->convert('v3.0.2')->toSnake();        // v3_0_2

// Convert string to Camel case
$this->cc->convert('first-name')->toCamel();    // firstName

// Convert from Lower case to Dot case
$this->cc->convert('non-SI units')->fromLower()->toDot(); // non-si.units

// Get detected words
$this->cc->convert('Mario Bros')->toArray();  // ['Mario', 'Bros']

// Retrieve original string
$this->cc->convert('use_the_force')->getSource();   // use_the_force
```


[Case-Mapping]: ./case-mapping.md
[CaseConverter factory]: ./using-the-factory.md
