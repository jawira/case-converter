Case-Mapping
============

Introduction
------------

_Case-mapping_ or _case conversion_ is performed everytime a character is
changed from _upper case_ to _lower case_, or from _lower case_ to _upper case_.
_Case converter_ performs _case-mapping_ everytime you use it.

There are two kind of case-mapping:

1. _Simple case-mapping_
2. _Full case-mapping_

_Simple case-mapping_ is one-to-one character mapping, for example a single
character "`A`" is replaced with another single character "`a`".

As you can image, _Full case-mapping_ performs one-to-many character
replacements (more precisely one-to-many code-points).
In real world use-cases, it's rare to perform _full case-mapping_, this is
because it only concerns a very small set of characters. For example in german
language, the letter "`ß`" is strictly lowercase and should be mapped to "`SS`"
in uppercase words.

Case-Converter behaviour
------------------------

By default, Case-Converter will perform _full case-mapping_

```php
// Full case-mapping
$ger = new Convert('Straße');
echo $ger->toUpper(); // output: STRASSE
```

If you want to perform _simple case-mapping_ then you have to
call `->forceSimpleCaseMapping()`:

```php
// Simple case-mapping
$ger = new Convert('Straße');
$ger->forceSimpleCaseMapping();
echo $ger->toUpper(); // output: STRAßE
```

As you can see, in _full case-mapping_ string length can change.

Case-Mapping in PHP
-------------------

PHP 7.3 introduced _full case-mapping_, you can have one-to-many character
mapping. In practice this means than you can have different results depending on
your PHP version.

Internally Case-Converter uses _mb_convert_case()_ . This function works in
conjunction with specific constants to tell what action to perform. For example:

```php
mb_convert_case('Foo', MB_CASE_UPPER); // FOO
```

Prior to PHP 7.3, these were the available constants and their use:

| Constant      | Meaning                                     |
|---------------|---------------------------------------------|
| MB_CASE_UPPER | Performs simple upper-case fold conversion. |
| MB_CASE_LOWER | Performs simple lower-case fold conversion. |
| MB_CASE_TITLE | Performs simple title-case fold conversion. |

But from PHP 7.3, new constants were added and their meaning changed:

| Constant             | Meaning                                     |
|----------------------|---------------------------------------------|
| MB_CASE_UPPER        | Performs a full upper-case folding.         |
| MB_CASE_LOWER        | Performs a full lower-case folding.         |
| MB_CASE_TITLE        | Performs a full title-case conversion.      |
| MB_CASE_UPPER_SIMPLE | Performs simple upper-case fold conversion. |
| MB_CASE_LOWER_SIMPLE | Performs simple lower-case fold conversion. |
| MB_CASE_TITLE_SIMPLE | Performs simple title-case fold conversion. |

Locale dependent mapping
------------------------

Some case-mapping are locale dependent. This is the case of Turkish where the
small letter "`i`" should be replaced by a capital letter with a dot "`İ`".
However, according to documentation:

> Only unconditional, language agnostic full case-mapping is performed.

This means that locale dependent mapping are ignored and not performed.

Resources
---------

<dl>
<dt>PHP 7.3 Full Case-Mapping and Case-Folding Support</dt>
<dd><a href="https://www.php.net/manual/en/migration73.new-features.php#migration73.new-features.mbstring.case-mapping-folding">https://www.php.net/manual/en/migration73.new-features.php#migration73.new-features.mbstring.case-mapping-folding</a></dd>
<dt>mb_convert_case()</dt>
<dd><a href="https://www.php.net/manual/en/function.mb-convert-case.php">https://www.php.net/manual/en/function.mb-convert-case.php</a></dd>
<dt>mbstring constant</dt>
<dd><a href="https://www.php.net/manual/en/mbstring.constants.php">https://www.php.net/manual/en/mbstring.constants.php</a></dd>
</dl>
