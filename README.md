# Case converter

Use this library to convert strings between the following cases:

| Name             | Method         | Output example    |
|------------------|----------------|-------------------|
| 🐪 Camel case    | `toCamel()`    | `myNameIsBond`    |
| 👨‍🏫 Pascal case   | `toPascal()`   | `MyNameIsBond`    |
| 🐍 Snake case    | `toSnake()`    | `my_name_is_bond` |
| 👩‍🏫 Ada case      | `toAda()`      | `My_Name_Is_Bond` |
| Ⓜ️ Macro case     | `toMacro()`    | `MY_NAME_IS_BOND` |
| 🥙 Kebab case    | `toKebab()`    | `my-name-is-bond` |
| 🚂 Train case    | `toTrain()`    | `My-Name-Is-Bond` |
| 🏦 Cobol case    | `toCobol()`    | `MY-NAME-IS-BOND` |
| 🔡 Lower case    | `toLower()`    | `my name is bond` |
| 🔠 Upper case    | `toUpper()`    | `MY NAME IS BOND` |
| 📰 Title case    | `toTitle()`    | `My Name Is Bond` |
| ✍️ Sentence case | `toSentence()` | `My name is bond` |
| ⚙️ Dot notation  | `toDot()`      | `my.name.is.bond` |

Features:

* 🔁 [automatic case detection][detection algorithm]
* 🏭 [factory][]
* 🌐 [i18n](#i18n)

[![Total Downloads](http://poser.pugx.org/jawira/case-converter/downloads?style=for-the-badge)](https://packagist.org/packages/jawira/case-converter)
[![PHP Version Require](http://poser.pugx.org/jawira/case-converter/require/php?style=for-the-badge)](https://packagist.org/packages/jawira/case-converter)
[![Latest Stable Version](http://poser.pugx.org/jawira/case-converter/v?style=for-the-badge)](https://packagist.org/packages/jawira/case-converter)
[![License](http://poser.pugx.org/jawira/case-converter/license?style=for-the-badge)](https://packagist.org/packages/jawira/case-converter)

## Usage

The input string's format is [detected automatically][detection algorithm].

For example:

```php
use Jawira\CaseConverter\Convert;

$hero = new Convert('john-connor');

echo $hero->toCamel();   // output: johnConnor
```

You can also specify the input string's format explicitly:

```php
echo $hero->fromKebab()->toSnake();   // output: john_connor
```

You can also use the [provided factory][factory] to create a `Convert` instance.
See the list of [all public methods] for more options.

## i18n

The library supports non-English alphabets:

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

`case-converter` supports both _Simple Case-Mapping_ and _Full Case-Mapping_.
[Learn more about Case-Mapping][Case-Mapping].

## Installation

```shell
composer require jawira/case-converter
```

## Documentation

<https://jawira.github.io/case-converter/>

## Contributing

- If you liked this project, ⭐ star it on GitHub.
  [![GitHub Repo stars](https://img.shields.io/github/stars/jawira/case-converter?style=social)](https://github.com/jawira/case-converter)
- Or follow me on X.
  [![Twitter Follow](https://img.shields.io/twitter/follow/jawira?style=social)](https://twitter.com/jawira)

## License

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

## Packages from jawira

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
