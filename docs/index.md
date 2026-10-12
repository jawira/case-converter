Case Converter
==============

Case Converter converts a string into one of 13 naming formats.
Create a `Jawira\CaseConverter\Convert` instance with the source string,
optionally you can also use [the factory class](using-the-factory.md).

The Convert class was designed to be immutable, the source cannot be changed
after construction.

## Installation

Install the package with Composer.

```console
composer require jawira/case-converter
```

## Basic usage

The library detects the input format automatically:

```php
use Jawira\CaseConverter\Convert;

$convert = new Convert('The-Terminator');

echo $convert->toPascal(); // TheTerminator
echo $convert->toCobol();  // THE-TERMINATOR
echo $convert->toSnake();  // the_terminator
```

See [all supported formats and methods](api.md).

## Choose the input format

Automatic detection follows a fixed order. If the format is known, use the
matching `from*()` method to control how the original string is split:

```php
$convert = new Convert('FBI');

$convert->fromAda()->toSnake();   // fbi: one word separated by underscores
$convert->fromCamel()->toSnake(); // f_b_i: split before each uppercase letter
```

`from*()` methods return the same object and can be chained with conversion
methods. See [automatic format detection](detection-algorithm.md) for the rules.

## Inspect the input

`getSource()` returns the original string, and `toArray()` returns the words
currently detected from it:

```php
$convert = new Convert('Mario Bros');

$convert->getSource(); // Mario Bros
$convert->toArray();   // ['Mario', 'Bros']
```

## Unicode case mapping

The library supports Unicode case conversion. By default it uses full case
mapping, which can change a string's length. Call `forceSimpleCaseMapping()` to
request simple case mapping instead:

```php
$convert = new Convert('Straße');

$convert->toUpper(); // STRASSE
$convert->forceSimpleCaseMapping()->toUpper(); // STRAßE
```

See [case mapping](case-mapping.md) for details and limitations.

## Use the factory

This library also provides `\Jawira\CaseConverter\CaseConverter` as a factory.
Call `convert()` to create a `Convert` instance:

```php
use \Jawira\CaseConverter\CaseConverter;

$cc = new CaseConverter();

// Convert string to Pascal case
$cc->convert('XML')->toPascal(); // Xml

// Convert string to Snake case
$cc->convert('v3.0.2')->toSnake(); // v3_0_2

// Convert string to Camel case
$cc->convert('first-name')->toCamel(); // firstName

// Convert from Lower case to Dot case
$cc->convert('non-SI units')->fromLower()->toDot(); // non-si.units

// Get detected words
$cc->convert('Mario Bros')->toArray(); // ['Mario', 'Bros']

// Retrieve original string
$cc->convert('use_the_force')->getSource(); // use_the_force
```

For dependency injection, `CaseConverter` implements `CaseConverterInterface`.

```php
use Jawira\CaseConverter\CaseConverterInterface;

final class NameFormatter
{
    public function __construct(private CaseConverterInterface $cc) {}

    public function format(string $slug): string
    {
        return $this->cc->convert($slug)->toCamel();
    }
}
```



See [using the factory](using-the-factory.md) for framework configuration.
