<?php
use Behat\Config\Config;
use Behat\Config\Formatter\PrettyFormatter;
use Behat\Config\Profile;
use Behat\Config\Suite;
use Jawira\CaseConverterBehat\FeatureContext;

$suite = (new Suite('default'))
    ->withPaths('%paths.base%/tests/behat')
    ->addContext(FeatureContext::class);

$profile = (new Profile('default'))
    ->withFormatter(new PrettyFormatter())
    ->withSuite($suite);

return (new Config())->withProfile($profile);
