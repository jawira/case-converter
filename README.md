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

Explicitly set output case:

```php
$son = new Convert('john_connor');

echo $son->toCamel();   // output: johnConnor
echo $son->toPascal();  // output: JohnConnor 
echo $son->toSnake();   // output: john_connor 
echo $son->toAda();     // output: John_Connor 
echo $son->toMacro();   // output: JOHN_CONNOR 
echo $son->toKebab();   // output: john-connor 
echo $son->toTrain();   // output: John-Connor 
echo $son->toCobol();   // output: JOHN-CONNOR 
```

Handling multilingual
---------------------

```php
echo (new Convert('DON_RAMÓN_Y_ÑOÑO')); // output: donRamónYÑoño 
echo (new Convert('πολύΚαλό'));         // output: πολύΚαλό 
echo (new Convert('ОЧЕНЬ_ПРИЯТНО'));    // output: оченьПриятно 
```

Notes
-----

* Magic function `__toString` will always print string in Camel case format.
* todo: numbers not handled, please open issue
* // todo: update notes

Installation
------------

Install using composer:

```sh
$ composer require jawira/case-converter
```

Then import `Convert` class into your code:

```php
<?php
use Jawira\CaseConverter\Convert;
```

Full example
------------

```
// todo: full code w/require...
```

Contributing
------------

To contribute to this project please read [CONTRIBUTING.md](./CONTRIBUTING.md).

License
-------

This library is licensed under the [MIT LICENSE](LICENSE.md).
