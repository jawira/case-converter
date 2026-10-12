<?php declare(strict_types=1);

use Jawira\AnnotationUpdater\AnnotationUpdater;
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$year = date('Y');
$rules = [
  '@PSR12' => true,
  '@PHP8x5Migration' => true, // Update this according to your PHP version
  '@PhpCsFixer' => true,
  'return_assignment' => false,
  'declare_strict_types' => true,
  'linebreak_after_opening_tag' => false,
  'blank_line_after_opening_tag' => false,
  'native_function_invocation' => ['include' => ['@all']],
  'global_namespace_import' => ['import_classes' => true, 'import_constants' => true, 'import_functions' => true],
  AnnotationUpdater::NAME => [
    AnnotationUpdater::ANNOTATIONS => [
      ['tag' => 'author', 'value' => 'Jawira Portugal <dev@tugal.be>', 'mode' => 'preserve'],
      ['tag' => 'copyright', 'value' => "© 2015-$year Jawira Portugal", 'mode' => 'replace'],
      ['tag' => 'throws', 'mode' => 'remove'],
    ],
  ],
];
$finder = Finder::create()->in([__DIR__ . '/src', __DIR__ . '/tests'])->name('*.php');


return (new Config())
  ->setHideProgress(true)
  ->setRiskyAllowed(true)
  ->setIndent('  ')
  ->setFinder($finder)
  ->registerCustomFixers([new AnnotationUpdater()])
  ->setRules($rules);
