Case-Mapping
============

Introduction
------------

> Case mapping or case conversion is a process whereby strings are converted 
> to a particular form—uppercase, lowercase, or titlecase—possibly for display 
> to the user.

PHP always performed _Simple Case-Mapping_, this is map one-to-one character
mapping. For example, one _lower case_ character is converter to one _upper
case_ character.

PHP 7.3 introduced [Full Case-Mapping], you can have one-to-many character
mapping. In practice this means than you can have different results depending on
your PHP version.

```php
$german = new Convert('Straße');

echo $german->toUpper();
// Produces STRAßE on PHP 7.2
// Produces STRASSE on PHP 7.3
```

Please note that _Full Case-Mapping_ is locale dependent:

```php
// Turkish (requires appropriate locale)
$tur = new Convert('istambul');     
echo $tur->toTrain();   // output: İstanbul
```

Forcing _Simple Case-Mapping_
------------------------------

As told before, _Full Case-Mapping_ is only available on PHP 7.3 and newer.

The following code snippet is executed on PHP 7.3:

```php
// German
$ger = new Convert('Straße');
echo $ger->toUpper();    // output: STRASSE
```

To force _Simple Case-Mapping_ you have to call `->forceSimpleCaseMapping()`:

```php
// German
$ger = new Convert('Straße');
$ger->forceSimpleCaseMapping();
echo $ger->toUpper();    // output: STRAßE
```

Please note `->forceSimpleCaseMapping()` has no effect on _PHP 7.1_ and _PHP
7.2_ as these version can only perform _Simple Case-Mapping_.

Technical details
-----------------

Internally `Case-Converter` uses [mb_convert_case()], this function uses the
following constants:

- MB_CASE_LOWER
- MB_CASE_TITLE
- MB_CASE_UPPER

The problem is that, Before _PHP 7.3_, these constants perform simple
case-mapping and after _PHP 7.3_ perform full case-mapping.

If you want to maintain the old functionality after _PHP 7.3_ you have to call
`->forceSimpleCaseMapping()`:

```php
// German
$ger = new Convert('Straße');
$ger->forceSimpleCaseMapping();
echo $ger->toUpper();    // output: STRASSE
```

***

IMHO this is a _breaking change_, PHP people should have keep untouched old
constants and create new ones for [Full Case-Mapping], for example:
`MB_CASE_LOWER_FULL`, `MB_CASE_TITLE_FULL`, and `MB_CASE_UPPER_FULL` (please
note these constants do not exist).

[Full Case-Mapping]: https://www.php.net/manual/en/migration73.new-features.php#migration73.new-features.mbstring.case-mapping-folding

[mb_convert_case()]: https://www.php.net/manual/en/function.mb-convert-case.php

