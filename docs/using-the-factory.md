# Using the factory

The package provides `Jawira\CaseConverter\CaseConverter` and the
`CaseConverterInterface`. The factory's `convert()` method creates a new
`Convert` instance for the supplied source string.

Using the interface in your services makes the dependency easy to configure
and replace in tests:

```php
namespace App;

use Jawira\CaseConverter\CaseConverterInterface;

final class NameFormatter
{
    public function __construct(private CaseConverterInterface $converter) {}

    public function variableName(string $text): string
    {
        return $this->converter->convert($text)->toCamel();
    }

    public function constantName(string $text): string
    {
        return $this->converter->convert($text)->fromKebab()->toMacro();
    }
}
```

In Symfony, register `CaseConverterInterface` as a service and use [autowiring](https://symfony.com/doc/current/service_container/autowiring.html#working-with-interfaces)
to inject it through the interface. 

The factory can also be instantiated directly:

```php
use Jawira\CaseConverter\CaseConverter;

$converter = new CaseConverter();
$result = $converter->convert('first-name')->toCamel(); // firstName
```

Using the factory `\Jawira\CaseConverter\CaseConverter::convert` is preferred because:

* Usually the new operator is considered harmful.
* You can easily mock dependencies when writing tests.
* [It's SOLID.](https://github.com/jawira/case-converter/issues/40)
