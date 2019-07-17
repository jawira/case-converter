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

```php
use Jawira\CaseConverter\Convert;

$hero = new Convert('john-connor');

echo $hero->toCamel();   // output: johnConnor
echo $hero->toSnake();   // output: john_connor
```

Note: Input string (i.e. _john-connor_) format is going to be detected automatically.

You can see a list of [all public methods].

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

_Full Case-Mapping_ (only from **PHP 7.3**):

```php
// German
$ger = new Convert('Straße');
echo $ger->toUpper();    // output: STRASSE

// Turkish (requires appropriate locale) 
$tur = new Convert('istambul');     
echo $tur->toTrain();   // output: İstanbul
```

To force _Single Case-Mapping_ you have to call `->forceSimpleCaseMapping()`:

```php
// German
$ger = new Convert('Straße');
$ger->forceSimpleCaseMapping();
echo $ger->toUpper();    // output: STRASSE
```

Please note `->forceSimpleCaseMapping()` has no effect on _PHP 7.1_ and _PHP 7.2_ as they already 
perform _Single Case-Mapping_. Learn more about [Full Case-Mapping].

Installation
------------

```
$ composer require jawira/case-converter
```

Documentation
-------------

<https://jawira.github.io/case-converter/>

License
-------

This library is licensed under the [MIT LICENSE].

<!--mkdocs: Do not use relative path for links and images-->

[all public methods]: https://jawira.github.io/case-converter/api.html
[CONTRIBUTING.md]: https://jawira.github.io/case-converter/contributing.html
[Countable interface]: https://php.net/manual/en/class.countable.php
[Full Case-Mapping]: https://jawira.github.io/case-converter/known-issues.html#full-case-mapping
[magic method]: https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
[MIT LICENSE]: https://jawira.github.io/case-converter/license.html
[open an issue]: https://github.com/jawira/case-converter/issues/new

***

My other packages
-----------------

<dl>

<dt><a href="https://packagist.org/packages/jawira/phing-visualizer">jawira/phing-visualizer</a></dt>
<dd>Graphical representation of Phing's buildfile.</dd>

<dt><a href="https://packagist.org/packages/jawira/plantuml">jawira/plantuml</a></dt>
<dd>Provides PlantUML integration: plantuml executable and plantuml.jar</dd>

<dt><a href="https://packagist.org/packages/jawira/plantuml-encoding">jawira/plantuml-encoding</a></dt>
<dd>PlantUML encoding functions.</dd>

<dt><a href="https://packagist.org/packages/jawira/process-maker">jawira/process-maker</a></dt>
<dd>Easily install and try ProcessMaker using Docker Compose.</dd>

</dl>
