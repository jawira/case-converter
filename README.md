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

The input string is automatically 

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

Multilingual strings are handled automatically:

```php
// Spanish
$esp = new Convert('DON_RAMÓN_Y_ÑOÑO'); 
echo $esp->toCamel();   // output: donRamónYÑoño

// Greek
$grc =(new Convert('πολύΚαλό');          
echo $grc->toCamel();   // output: πολύΚαλό

// Russian
$rus = new Convert('ОЧЕНЬ_ПРИЯТНО');    
echo $rus->toCamel();   // output: оченьПриятно
```

Handled formats
---------------

| Name          | Example           |
| ------------- | ----------------- |
| Camel case    | myNameIsBond      |
| Pascal case   | MyNameIsBond      |
| Kebab case    | my-name-is-bond   |
| Train case    | My-Name-Is-Bond   |
| Cobol case    | MY-NAME-IS-BOND   |
| Snake case    | my_name_is_bond   |
| Ada case      | My_Name_Is_Bond   |
| Macro case    | MY_NAME_IS_BOND   |

Notes
-----

* This library expects to receive an _UTF-8_ string.
* Magic function `__toString` will always print string in _Camel case_ format.
* Input string are not supposed to have numbers in it. If you have a problem 
please [open an issue].

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

Pull requests are welcome, please [open an issue] before committing.

Good practices are described in [CONTRIBUTING.md].

License
-------

This library is licensed under the [MIT LICENSE](LICENSE.md).


[open an issue]: https://github.com/jawira/case-converter/issues/new
[CONTRIBUTING.md]: ./CONTRIBUTING.md
