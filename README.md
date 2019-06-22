Case converter
==============

Use this library to convert string between:

| Name          | Method          | Output example    |
| ------------- | --------------- | ----------------- |
| 🐪 Camel case   | `toCamel()`     | `myNameIsBond`    |
| 👨‍🏫 Pascal case  | `toPascal()`    | `MyNameIsBond`    |
| 🐍 Snake case   | `toSnake()`     | `my_name_is_bond` |
| 👩‍🏫 Ada case     | `toAda()`       | `My_Name_Is_Bond` |
| Ⓜ️ Macro case | `toMacro()`     | `MY_NAME_IS_BOND` |
| 🥙 Kebab case   | `toKebab()`     | `my-name-is-bond` |
| 🚂 Train case   | `toTrain()`     | `My-Name-Is-Bond` |
| 🏦 Cobol case   | `toCobol()`     | `MY-NAME-IS-BOND` |
| 🔡 Lower case   | `toLower()`     | `my name is bond` |
| 🔠 Upper case   | `toUpper()`     | `MY NAME IS BOND` |
| 📰 Title case     | `toTitle()`     | `My Name Is Bond` |
| ✍️ Sentence case | `toSentence()`  | `My name is bond` |

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
[![Issues](https://img.shields.io/github/issues/jawira/case-converter.svg?label=HuBoard&color=694DC2)](https://huboard.com/jawira/case-converter)

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
    
Utility methods
---------------

| Method          | Description                                   | Output example                  |
| --------------- | --------------------------------------------- | ------------------------------- |
| `toArray()`     | Get array with detected words                 | `['my', 'name', 'is', 'bond']`  | 

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

Documentation
-------------

<https://jawira.github.io/case-converter/>

License
-------

This library is licensed under the [MIT LICENSE].

<!--mkdocs: Do not use relative path for links and images-->

[CONTRIBUTING.md]: https://jawira.github.io/case-converter/contributing.html
[Countable interface]: https://php.net/manual/en/class.countable.php
[magic method]: https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
[MIT LICENSE]: https://jawira.github.io/case-converter/license.html
[open an issue]: https://github.com/jawira/case-converter/issues/new
