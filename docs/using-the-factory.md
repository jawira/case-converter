Using the factory
=================

Besides `\Jawira\CaseConverter\Convert` you also have at your disposal:

- `\Jawira\CaseConverter\CaseConverter`
- `\Jawira\CaseConverter\CaseConverterInterface`

Instead of using `new Convert();` you can use the convenience method from 
`CaseConverter` class.

In concrete, you have to call `\Jawira\CaseConverter\CaseConverter::convert` to 
create `Convert` objects.

Here an example:

```php
<?php
namespace My\App;
use Jawira\CaseConverter\CaseConverterInterface;

class MySuperNameCreator
{
    protected $cc;

    public function __construct(CaseConverterInterface $cc)
    {
        $this->cc = $cc;
    }

    public function variableName(string $slug): string
    {
        // `->convert()` returns a `Convert` object.
        $myConvert = $this->cc->convert($slug);
        return $myConvert->toCamel();
    }

    public function constantName(string $slug): string
    {
        // Of course you can also chain everything.
        return $this->cc->convert($slug)->fromKebab()->toMacro();
    }
}
```

Please note that an interface -`CaseConverterInterface`- is also provided. If 
you are using _Symfony_ you can use this interface with [Symfony autowiring][] 
to automatically instantiate `CaseConverter`, otherwise if you are working in 
a standalone project you should try [php-di project][].

Using `\Jawira\CaseConverter\CaseConverter::convert` is preferred because:

- Usually the `new` operator is considered harmful.
- You can easily mock dependencies when writing tests.
- [It's SOLID]

[It's SOLID]: https://github.com/jawira/case-converter/issues/40
[php-di project]: http://php-di.org/#autowiring
[Symfony autowiring]: https://symfony.com/doc/current/service_container/autowiring.html
