Case converter 🐪🐍
=================

Convert strings between **camel case** and **snake case**.

Examples
--------

Automatic conversion:

```php
echo (new Convert('helloWorld'));   // output: hello_world 
echo (new Convert('HelloWorld'));   // output: hello_world 
echo (new Convert('hello_world'));  // output: helloWorld 
echo (new Convert('HELLO_WORLD'));  // output: helloWorld 
```

Explicitly set output case:

```php
$son = (new Convert('john_connor'); 
echo $son->toSnake();  // output: john_connor 
echo $son->toCamel();  // output: johnConnor
```

Use uppercase versions for output:

```php
$mother = (new Convert('sarahConnor'); 
echo $mother->toSnake(true);  // output: SARAH_CONNOR 
echo $mother->toCamel(true);  // output: SarahConnor
```

Installation
------------
Install using composer:
```sh
$ composer require jawira/case-converter
```

Import class into your code:

```php
<?php
use Jawira\CaseConverter\Convert;
```
