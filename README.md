Case converter
==============

Use this library to convert string between:

1. 🐪 Camel case
1. 🐍 Snake case
1. 👨‍🏫 Pascal case
1. 👩‍🏫 Ada case
1. Ⓜ️ Macro case
1. 🥙 Kebab case
1. 🚆 Train case
1. 🏦 Cobol case
1. 🔠 Upper case
1. 🔡 Lower case
1. 📰 Title case
1. ✍️ Sentence case

Features:

* 🔁 automatic case detection
* 🌐 i18n

[![Latest Stable Version](https://poser.pugx.org/jawira/case-converter/v/stable)](https://packagist.org/packages/jawira/case-converter)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/jawira/case-converter.svg)](https://packagist.org/packages/jawira/case-converter)
[![Build Status](https://www.travis-ci.org/jawira/case-converter.svg?branch=master)](https://www.travis-ci.org/jawira/case-converter)
[![Maintainability](https://api.codeclimate.com/v1/badges/35677f6ce7dac27a5d0c/maintainability)](https://codeclimate.com/github/jawira/case-converter/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/35677f6ce7dac27a5d0c/test_coverage)](https://codeclimate.com/github/jawira/case-converter/test_coverage)
[![Total Downloads](https://poser.pugx.org/jawira/case-converter/downloads)](https://packagist.org/packages/jawira/case-converter)
[![Monthly Downloads](https://poser.pugx.org/jawira/case-converter/d/monthly)](https://packagist.org/packages/jawira/case-converter)
[![Daily Downloads](https://poser.pugx.org/jawira/case-converter/d/daily)](https://packagist.org/packages/jawira/case-converter)
[![PHPPackages Rank](http://phppackages.org/p/jawira/case-converter/badge/rank.svg)](http://phppackages.org/p/jawira/case-converter)
[![PHPPackages Referenced By](http://phppackages.org/p/jawira/case-converter/badge/referenced-by.svg)](http://phppackages.org/p/jawira/case-converter)
[![License](https://poser.pugx.org/jawira/case-converter/license)](https://packagist.org/packages/jawira/case-converter)
[![composer.lock](https://poser.pugx.org/jawira/case-converter/composerlock)](https://packagist.org/packages/jawira/case-converter)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg)](https://github.com/php-pds/skeleton)

Usage
-----

1. Instantiate `Convert` class with the string to transform:

    ```php
    $son = new Convert('john-connor');
    ```

    Note: Input string (i.e. _john-connor_) format is going to be detected
    automatically.

2. Then use the right method to convert the string accordingly to your needs:

    ```php
    echo $son->toCamel();   // output: johnConnor
    echo $son->toSnake();   // output: john_connor
    ```

Supported naming conventions
----------------------------

| Method          | Description   | Output example    |
| --------------- | ------------- | ----------------- |
| `toCamel()`     | Camel case    | `myNameIsBond`    |
| `toPascal()`    | Pascal case   | `MyNameIsBond`    |
| `toKebab()`     | Kebab case    | `my-name-is-bond` |
| `toTrain()`     | Train case    | `My-Name-Is-Bond` |
| `toCobol()`     | Cobol case    | `MY-NAME-IS-BOND` |
| `toSnake()`     | Snake case    | `my_name_is_bond` |
| `toAda()`       | Ada case      | `My_Name_Is_Bond` |
| `toMacro()`     | Macro case    | `MY_NAME_IS_BOND` |
| `toUpper()`     | Upper case    | `MY NAME IS BOND` |
| `toLower()`     | Lower case    | `my name is bond` |
| `toTitle()`     | Title case    | `My Name Is Bond` |
| `toSentence()`  | Sentence case | `My name is bond` |

Utility methods
---------------

| Method          | Description                                   | Output example                  |
| --------------- | --------------------------------------------- | ------------------------------- |
| `toArray()`     | Get array with detected words                 | `['my', 'name', 'is', 'bond']`  | 
| `__toString()`  | Same as Camel case ([magic method])           | `myNameIsBond`                  |
| `count()`       | Count detected words ([Countable interface])  | `4`                             |

i18n
----

Fully compatible with non-english alphabets:

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

```console
composer require jawira/case-converter
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

```text
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

This library is licensed under the [MIT LICENSE].

[MIT LICENSE]: ./LICENSE.md
[open an issue]: https://github.com/jawira/case-converter/issues/new
[CONTRIBUTING.md]: ./CONTRIBUTING.md
[magic method]: https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
[Countable interface]: https://php.net/manual/en/class.countable.php
