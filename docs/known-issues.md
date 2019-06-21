Known issues
============

Number handling
---------------

When using `case-converter` you cannot use a number as separator. In practice 
this means that a number is not considered as a word: 

![Phing targets](./number-problem.png "Phing targets")

As shown in the previous example, there is no way to go back to the original 
input string (i.e. `hello-8-world`), in _kebab case_ this sting is written as 
`hello8-world`.  

Full case-mapping
-----------------

PHP 7.3 introduced [full case-mapping], in practice this means than you can 
have different results depending on your PHP version.

```php
$german = new Convert('Straße');

echo $german->toUpper();
// Produces STRAßE on PHP 7.2
// Produces STRASSE on PHP 7.3
```

[full case-mapping]: https://www.php.net/manual/en/migration73.new-features.php#migration73.new-features.mbstring.case-mapping-folding
