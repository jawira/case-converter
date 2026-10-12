Unicode case mapping
====================

Case mapping changes letters between uppercase, lowercase, and title case. The
Unicode standard defines simple and full mappings:

- **Simple mapping** maps one code point to one code point.
- **Full mapping** may map one code point to multiple code points.

For example, full uppercase mapping converts the German `ß` to `SS`, while
simple mapping leaves it as `ß`. Case Converter uses full mapping by default.

```php
use Jawira\CaseConverter\Convert;

$value = new Convert('Straße');

$value->toUpper(); // STRASSE
$value->forceSimpleCaseMapping()->toUpper(); // STRAßE
```

`forceSimpleCaseMapping()` returns the same object. It affects subsequent
conversion calls on that object; it does not change the detected words or the
source string.

## Locale-specific behavior

Case Converter uses PHP's `mb_convert_case()` with UTF-8. The library does not
accept a locale setting, so locale-specific casing rules, such as Turkish
dotted and dotless `i`, are not selected based on the user's locale.

## Evolution of Case-Mapping in PHP

PHP 7.3 introduced full case-mapping, you can have one-to-many character
mapping. In practice this means than you can have different results depending on
your PHP version.

Internally Case-Converter uses mb_convert_case () . This function works in
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

## Further reading

<dl>
<dt>PHP 7.3 Full Case-Mapping and Case-Folding Support</dt>
<dd><a href="https://www.php.net/manual/en/migration73.new-features.php#migration73.new-features.mbstring.case-mapping-folding">https://www.php.net/manual/en/migration73.new-features.php#migration73.new-features.mbstring.case-mapping-folding</a></dd>
<dt>mb_convert_case()</dt>
<dd><a href="https://www.php.net/manual/en/function.mb-convert-case.php">https://www.php.net/manual/en/function.mb-convert-case.php</a></dd>
<dt>mbstring constant</dt>
<dd><a href="https://www.php.net/manual/en/mbstring.constants.php">https://www.php.net/manual/en/mbstring.constants.php</a></dd>
</dl>
