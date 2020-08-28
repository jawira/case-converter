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
| ⚙️ Dot notation  | `toDot()`       | `my.name.is.bond` |

Features:

* 🔁 [automatic case detection][detection algorithm]
* 🏭 [factory][]
* 🌐 [i18n](#i18n)

[![Latest Stable Version](https://poser.pugx.org/jawira/case-converter/v/stable)](https://packagist.org/packages/jawira/case-converter)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/jawira/case-converter.svg)](https://packagist.org/packages/jawira/case-converter)
[![Build Status](https://www.travis-ci.org/jawira/case-converter.svg?branch=master)](https://www.travis-ci.org/jawira/case-converter)
[![Build Status](https://img.shields.io/github/forks/jawira/case-converter.svg)](https://github.com/jawira/case-converter)
[![Build Status](https://img.shields.io/github/stars/jawira/case-converter.svg)](https://github.com/jawira/case-converter)
[![Maintainability](https://api.codeclimate.com/v1/badges/35677f6ce7dac27a5d0c/maintainability)](https://codeclimate.com/github/jawira/case-converter/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/35677f6ce7dac27a5d0c/test_coverage)](https://codeclimate.com/github/jawira/case-converter/test_coverage)
[![Total Downloads](https://poser.pugx.org/jawira/case-converter/downloads)](https://packagist.org/packages/jawira/case-converter)
[![Monthly Downloads](https://poser.pugx.org/jawira/case-converter/d/monthly)](https://packagist.org/packages/jawira/case-converter)
[![Daily Downloads](https://poser.pugx.org/jawira/case-converter/d/daily)](https://packagist.org/packages/jawira/case-converter)
[![PHPPackages Rank](http://phppackages.org/p/jawira/case-converter/badge/rank.svg)](http://phppackages.org/p/jawira/case-converter)
[![PHPPackages Referenced By](http://phppackages.org/p/jawira/case-converter/badge/referenced-by.svg)](http://phppackages.org/p/jawira/case-converter)
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/jawira/case-converter.svg)](http://isitmaintained.com/project/jawira/case-converter "Average time to resolve an issue")
[![Percentage of issues still open](http://isitmaintained.com/badge/open/jawira/case-converter.svg)](http://isitmaintained.com/project/jawira/case-converter "Percentage of issues still open")
[![License](https://poser.pugx.org/jawira/case-converter/license)](https://packagist.org/packages/jawira/case-converter)
[![composer.lock](https://poser.pugx.org/jawira/case-converter/composerlock)](https://packagist.org/packages/jawira/case-converter)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg)](https://github.com/php-pds/skeleton)
[![Issues](https://img.shields.io/github/issues/jawira/case-converter.svg?label=HuBoard&color=694DC2)](https://huboard.com/jawira/case-converter)
[![HitCount](http://hits.dwyl.io/jawira/case-converter.svg)](http://hits.dwyl.io/jawira/case-converter)

Usage
-----

Input string (i.e. _john-connor_) format is going to be 
[detected automatically][detection algorithm]. Here's an example:

```php
use Jawira\CaseConverter\Convert;

$hero = new Convert('john-connor');

echo $hero->toCamel();   // output: johnConnor
```

Of course you can explicitly set the format of input string:

```php
echo $hero->fromKebab()->toSnake();   // output: john_connor
```

You can also use the [provided factory][factory] to instantiate `Convert` class.
A list of [all public methods] is also available.

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
 
`case-converter` is compatible with _Simple Case-Mapping_ and _Full 
Case-Mapping_. [Learn more about Case-Mapping][Case-Mapping].

Installation
------------

```
$ composer require jawira/case-converter
```

Documentation
-------------

<https://jawira.github.io/case-converter/>

Contributing
------------

- If you liked this project, ⭐ star it on [GitHub].
- _Pull requests_ and _issues_ are welcomed.

Contributors
------------

<a href="https://github.com/jawira/case-converter/graphs/contributors">
  <img alt="Contributors" src="https://contributors-img.web.app/image?repo=jawira/case-converter" />
</a>

License
-------

This library is licensed under the [MIT LICENSE].

<!--mkdocs: Do not use relative path for links and images-->

[all public methods]: https://jawira.github.io/case-converter/api.html
[CONTRIBUTING.md]: https://jawira.github.io/case-converter/contributing.html
[Countable interface]: https://php.net/manual/en/class.countable.php
[Case-Mapping]: https://jawira.github.io/case-converter/case-mapping.html
[magic method]: https://www.php.net/manual/en/language.oop5.magic.php#object.tostring
[MIT LICENSE]: https://jawira.github.io/case-converter/license.html
[open an issue]: https://github.com/jawira/case-converter/issues/new
[detection algorithm]: https://jawira.github.io/case-converter/detection-algorithm.html
[factory]: https://jawira.github.io/case-converter/using-the-factory.html
[GitHub]: https://github.com/jawira/case-converter/

***

Packages from jawira
--------------------

<dl>

<dt><a href="https://packagist.org/packages/jawira/emoji-catalog">jawira/emoji-catalog</a> (library)</dt>
<dd>Get access to +3000 emojis as class constants.</dd>

<dt><a href="https://packagist.org/packages/jawira/phing-visualizer">jawira/phing-visualizer</a> (library)</dt>
<dd>Graphical representation of Phing's buildfile.</dd>

<dt><a href="https://packagist.org/packages/jawira/phing-open-task">jawira/phing-open-task</a> (library)</dt>
<dd>Phing task to open files, directories, and URLs with your favorite software.</dd>

<dt><a href="https://packagist.org/packages/jawira/">more...</a></dt>
</dl>
