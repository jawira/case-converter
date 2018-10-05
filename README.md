Case converter 
==============

Convert strings between **Camel Case** 🐪 and **Snake Case** 🐍.

* 🔁 automatic case detection
* 🌐 i18n

[![Latest Stable Version](https://poser.pugx.org/jawira/case-converter/v/stable)](https://packagist.org/packages/jawira/case-converter)
[![Total Downloads](https://poser.pugx.org/jawira/case-converter/downloads)](https://packagist.org/packages/jawira/case-converter)
[![License](https://poser.pugx.org/jawira/case-converter/license)](https://packagist.org/packages/jawira/case-converter)
[![composer.lock](https://poser.pugx.org/jawira/case-converter/composerlock)](https://packagist.org/packages/jawira/case-converter)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat-square)](https://github.com/php-pds/skeleton)

Usage
-----

Automatic conversion:

```php
echo (new Convert('helloWorld'));   // output: hello_world 
echo (new Convert('HelloWorld'));   // output: hello_world 
echo (new Convert('hello_world'));  // output: helloWorld 
echo (new Convert('HELLO_WORLD'));  // output: helloWorld 
```

Explicitly set output case:

```php
$son = new Convert('john_connor'); 
echo $son->toSnake();  // output: john_connor 
echo $son->toCamel();  // output: johnConnor
```

Using uppercase versions:

```php
$mother = new Convert('sarahConnor'); 
echo $mother->toSnake(true);  // output: SARAH_CONNOR (aka Screaming Snake Case)
echo $mother->toCamel(true);  // output: SarahConnor (aka Pascal Case)
```

Handling multilingual strings:

```php
echo (new Convert('DON_RAMÓN_Y_ÑOÑO')); // output: donRamónYÑoño 
echo (new Convert('πολύΚαλό'));         // output: πολύ_καλό 
echo (new Convert('очень_приятно'));    // output: оченьПриятно 
```

How it works
------------

If any underscore `_` if found, the input string is considered to be Snake Case, and Camel Case otherwise.

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

Contributing
------------

To contribute to this project please read [CONTRIBUTING.md](./CONTRIBUTING.md)

License
-------

This library is licensed under the [MIT LICENSE](LICENSE.md).
