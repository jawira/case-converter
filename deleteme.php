<?php

include __DIR__ . '/vendor/autoload.php';


$cc       = new \Jawira\CaseConverter\CaseConverter();
$myString = $cc->convert('CPU486')->fromAuto()->toMacro();

echo $myString, PHP_EOL;
