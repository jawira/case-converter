Case converter 
==============

Use this library to convert string between:

* 🐪 Camel case
* 👨‍🏫 Pascal case
* 🐍 Snake case
* 👩‍🏫 Ada case
* 🔠 Macro case
* 🥙 Kebab case
* 🚆 Train case
* 🏦 Cobol case

Features:

* 🔁 automatic case detection
* 🌐 i18n

[![Latest Stable Version](https://poser.pugx.org/jawira/case-converter/v/stable)](https://packagist.org/packages/jawira/case-converter)
[![License](https://poser.pugx.org/jawira/case-converter/license)](https://packagist.org/packages/jawira/case-converter)
[![Total Downloads](https://poser.pugx.org/jawira/case-converter/downloads)](https://packagist.org/packages/jawira/case-converter)
[![Monthly Downloads](https://poser.pugx.org/jawira/case-converter/d/monthly)](https://packagist.org/packages/jawira/case-converter)
[![Daily Downloads](https://poser.pugx.org/jawira/case-converter/d/daily)](https://packagist.org/packages/jawira/case-converter)
[![composer.lock](https://poser.pugx.org/jawira/case-converter/composerlock)](https://packagist.org/packages/jawira/case-converter)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg)](https://github.com/php-pds/skeleton)

Usage
-----

Pass the string to be converted as parameter when instantiating `Convert` class.

The format from input string (e.g. _john_connor_) is going to be automatically 
detected. The use the right method to convert the string according to your 
needs.  

```php
$son = new Convert('john-connor');

echo $son->toCamel();   // output: johnConnor
echo $son->toSnake();   // output: john_connor 
```

Handled formats
---------------

| Name          | Method        | Example           | 
| ------------- | ------------- | ----------------- |
| Camel case    | `toCamel()`   | myNameIsBond      |
| Pascal case   | `toPascal()`  | MyNameIsBond      |
| Kebab case    | `toKebab()`   | my-name-is-bond   |
| Train case    | `toTrain()`   | My-Name-Is-Bond   |
| Cobol case    | `toCobol()`   | MY-NAME-IS-BOND   |
| Snake case    | `toSnake()`   | my_name_is_bond   |
| Ada case      | `toAda()`     | My_Name_Is_Bond   |
| Macro case    | `toMacro()`   | MY_NAME_IS_BOND   |

i18n
----

Fully compatible with multilingual strings:

```php
// Spanish
$esp = new Convert('DON_RAMÓN_Y_ÑOÑO'); 
echo $esp->toCamel();   // output: donRamónYÑoño

// Greek
$grc = new Convert('πολύ-Καλό');          
echo $grc->toCamel();   // output: πολύΚαλό

// Russian
$rus = new Convert('ОЧЕНЬ_ПРИЯТНО');    
echo $rus->toCamel();   // output: оченьПриятно
```

Notes
-----

* You must use _UTF-8_ encoding.
* Magic function `__toString` will always print string in _Camel case_ format.
* Input strings are not supposed to have numbers in it. If you need to handle
numbers then please [open an issue].

Installation
------------

Install using Composer:

```
$ composer require jawira/case-converter
```

Then import `Convert` class into your code:

```php
<?php
use Jawira\CaseConverter\Convert;
```

Full example
------------

```php
<?php declare(strict_types=1);

namespace Demo;

require __DIR__ . '/vendor/autoload.php';

use Jawira\CaseConverter\Convert;

$robot = new Convert('The-Terminator');

echo $robot->toPascal() . PHP_EOL;
echo $robot->toCobol() . PHP_EOL;
```

Output:

```
TheTerminator
THE-TERMINATOR
```

Contributing
------------

Pull requests are welcome, please [open an issue] before committing.

Good development practices are described in [CONTRIBUTING.md], you are not 
required to follow these rules.

License
-------

This library is licensed under the [MIT LICENSE](LICENSE.md).


[open an issue]: https://github.com/jawira/case-converter/issues/new
[CONTRIBUTING.md]: ./CONTRIBUTING.md
