Case converter
==============

Use this library to convert string between:

| Name              | Method         | Output example    |
|-------------------|----------------|-------------------|
| 🐪 Camel case     | `toCamel()`    | `myNameIsBond`    |
| 👨‍🏫 Pascal case | `toPascal()`   | `MyNameIsBond`    |
| 🐍 Snake case     | `toSnake()`    | `my_name_is_bond` |
| 👩‍🏫 Ada case    | `toAda()`      | `My_Name_Is_Bond` |
| Ⓜ️ Macro case     | `toMacro()`    | `MY_NAME_IS_BOND` |
| 🥙 Kebab case     | `toKebab()`    | `my-name-is-bond` |
| 🚂 Train case     | `toTrain()`    | `My-Name-Is-Bond` |
| 🏦 Cobol case     | `toCobol()`    | `MY-NAME-IS-BOND` |
| 🔡 Lower case     | `toLower()`    | `my name is bond` |
| 🔠 Upper case     | `toUpper()`    | `MY NAME IS BOND` |
| 📰 Title case     | `toTitle()`    | `My Name Is Bond` |
| ✍️ Sentence case  | `toSentence()` | `My name is bond` |
| ⚙️ Dot notation   | `toDot()`      | `my.name.is.bond` |

Features:

* 🔁 [automatic case detection][detection algorithm]
* 🏭 [factory][]
* 🌐 [i18n](#i18n)

[![Packagist Version](https://img.shields.io/packagist/v/jawira/case-converter?style=for-the-badge)](https://packagist.org/packages/jawira/case-converter)
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/jawira/case-converter?style=for-the-badge)](https://packagist.org/packages/jawira/case-converter)
[![Packagist Downloads](https://img.shields.io/packagist/dt/jawira/case-converter?style=for-the-badge)](https://packagist.org/packages/jawira/case-converter)
[![Packagist License](https://img.shields.io/packagist/l/jawira/case-converter?style=for-the-badge)](https://packagist.org/packages/jawira/case-converter)  
[![Maintainability](https://api.codeclimate.com/v1/badges/35677f6ce7dac27a5d0c/maintainability)](https://codeclimate.com/github/jawira/case-converter/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/35677f6ce7dac27a5d0c/test_coverage)](https://codeclimate.com/github/jawira/case-converter/test_coverage)

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
Case-Mapping_.
[Learn more about Case-Mapping][Case-Mapping].

Installation
------------

```console
composer require jawira/case-converter
```

Documentation
-------------

<https://jawira.github.io/case-converter/>

Contributing
------------

- If you liked this project, ⭐ star it on GitHub.
  [![GitHub Repo stars](https://img.shields.io/github/stars/jawira/case-converter?style=social)](https://github.com/jawira/case-converter)
- Or follow me on X.
  [![Twitter Follow](https://img.shields.io/twitter/follow/jawira?style=social)](https://twitter.com/jawira)

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

<dt>
    <a href="https://packagist.org/packages/jawira/emoji-catalog">jawira/emoji-catalog
    <img alt="GitHub stars" src="https://badgen.net/github/stars/jawira/emoji-catalog?icon=github"/></a>
</dt>
<dd>Get access to +3000 emojis as class constants.</dd>

<dt>
    <a href="https://packagist.org/packages/jawira/plantuml-client"> jawira/plantuml-client
    <img alt="GitHub stars" src="https://badgen.net/github/stars/jawira/plantuml-client?icon=github"/></a>
</dt>
<dd>Convert PlantUML diagrams into images (svg, png, ...).</dd>

<dt>
    <a href="https://packagist.org/packages/jawira/doctrine-diagram-bundle">jawira/doctrine-diagram-bundle
    <img alt="GitHub stars" src="https://badgen.net/github/stars/jawira/doctrine-diagram-bundle?icon=github"/></a>
</dt>
<dd>Symfony Bundle to generate database diagrams.</dd>

<dt><a href="https://packagist.org/packages/jawira/">more...</a></dt>
</dl>
