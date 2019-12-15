# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

## [v3.4.1] - 2019-12-15

### Added

- HitCount badge

### Fixed

- [#53] Removing unreachable statement
- Fixing typo in doc
 

## [v3.4.0] - 2019-10-21

### Added

- [#52] Adding badges to readme.

### Changed

- [#45] Changed hack from `UppercaseSplitter` to proper solution.
- [#51] Refactoring \Jawira\CaseConverter\Convert::analyse
- [#50] Improving PHPUnit coverage

### Fixed

- [#49] Bug fix: string wrongly recognized when starts with a delimiter.

## [v3.3.3] - 2019-09-03

### Fixed

- Fix anchor in readme

## [v3.3.2] - 2019-09-03

### Changed

- Updating documentation

## [v3.3.1] - 2019-08-21

### Fixed

- Removed unwanted dependency

## [v3.3.0] - 2019-08-21

### Added

- [#46] Added new convention: Dot notation 

## [v3.2.1] - 2019-08-17

### Changed

- Updated Readme file

## [v3.2.0] - 2019-08-17

### Added

- [#40] Added Factory class and its interface.

## [v3.1.0] - 2019-07-25

### Added

- [#41] Added `\Jawira\CaseConverter\Convert::getSource` method to retrieve 
original input string.
- [#38] Added `\Jawira\CaseConverter\Convert::forceSimpleCaseMapping` to force the
usage of _Single Case-Mapping_ in _PHP 7.3_ and newer. This method has no effect
in _PHP 7.1_ nor _PHP 7.2_.

### Fixed

- [#44] Strings with `0` in it can be handled correctly. 

## [v3.0.0] - 2019-06-30

### Added

- [#36] Static site with documentation <https://jawira.github.io/case-converter/build.png>
- [#30] Added functions to explicitly set the naming conventions of input 
string: `fromAuto()`, `fromCamel()`, `fromPascal()`, `fromSnake()`, `fromAda()`, 
`fromMacro()`, `fromKebab()`, `fromTrain()`, `fromCobol()`, `fromLower()`, 
`fromUpper()`, `fromTitle()`, and `fromSentence()`.    

### Removed

- [#37] Removed deprecated functions: `Convert::__toString()` and `Convert::count()`

## [v2.3.0] - 2019-06-15

### Changed

- [#35] Big refactoring in library's structure, user should not notice this 
changes

### Deprecated

- [#35] \Jawira\CaseConverter\Convert::__toString
- [#35] \Jawira\CaseConverter\Convert::count

### Removed

- [#35] Lot of constants have been removed from `Convert` class: ENCODING, DASH, 
EMPTY_STRING, SPACE, UNDERSCORE, STRATEGY_DASH, STRATEGY_SPACE, 
STRATEGY_UNDERSCORE, STRATEGY_UPPERCASE, ADA, CAMEL, COBOL, KEBAB, LOWER, MACRO, 
PASCAL, SENTENCE, SNAKE, TITLE, TRAIN, UPPER.

## [v2.2.0] - 2019-05-30

### Added

 - [#33] Added support for space based naming conventions: Title case, Sentence 
 case, Upper case, and Lower case.

## [v2.1.0] - 2019-05-10

### Added

- [#26] New method to get array with words extracted from original string 
`\Jawira\CaseConverter\Convert::toArray`
- PHPLoc target in buildfile
- [#31] Implement countable interface

## [v2.0.4] - 2019-04-04

### Changed

- [#24] Improving PHPUnit tests
- [#29] Adding PHPPackages badges

## [v2.0.3] - 2019-03-30

### Added

- [#22] Code Climate integration

## [v2.0.2] - 2019-03-29

### Changed

- [#24] Re-writing PHPUnit tests

### Added

- [#27] Travis-ci integration

## [v2.0.1] - 2019-03-28

### Changed

- [#25] Updated readme file

## [v2.0.0] - 2019-03-26

### Changed

- [#21] New methods to convert strings between: Snake case, Camel case,
  Kebab case, Pascal case, Ada case, Train case, Cobol case and Macro case
- [#21] Behat tests have been adapted for new CaseConverter signatures

## [v1.2.0] - 2019-03-18

### Added

- [#19] Handling Kebab case
- [#18] Armenian behat tests
- [#18] Swedish behat tests

## [v1.1.7] - 2019-02-18

### Added

- Waffle.io badge in README.md
- [#16] Use Phive to download Phar files
- [#11] Created `CaseConverterException`

### Fixed

- [#17] Fixing PHPStan error

## [v1.1.6] - 2018-12-15

### Fixed

- Phing uses `http_proxy` behind a proxy to download Behat, PHPUnit and
  Composer.

## [v1.1.5] - 2018-10-18

### Added

- New Phing target for Behat tests

### Changed

- Moved PHPUnit and Behat files to `tests` dir
- Renaming some Phing targets

### Removed

- Behat was removed from `composer.json`, instead, `bin/behat` is used.

## [v1.1.4] - 2018-10-06

### Fixed

- Fixed support for multilingual strings: spanish, greek, cyrillic, etc.

## [v1.1.3] - 2018-10-04

### Added

- Added `pds/skeleton` badge in [README.md]()
- Added `pds/skeleton` as suggestion in [composer.json]()
- Added behat tests [#9]

### Fixed

- Fixed bug with invalid Pascal Case [#12]

## [v1.1.2] - 2018-09-23

### Added

- Crated Phing visualisation `build.png`

### Fixed

- Un-versioning `composer.lock`

## [v1.1.1] - 2018-09-23

### Fixed

- Un-versioning `composer.lock`

## [v1.1.0] - 2018-01-29

### Added

- Build tools (Makefile & Phing)

### Fixed

- Bug with spanish characters ([issue #6](https://github.com/jawira/case-converter/issues/6))

## [v1.0.1] - 2017-11-10

### Added

- Unitary tests
- Unitary tests for spanish characters

### Fixed

- Bug with acronyms ([issue #5](https://github.com/jawira/case-converter/issues/5))

## [v1.0.0] - 2017-10-27

### Changed

- Slight changes on [README.md]()

### Removed

- PHPUnit and pds/skeleton dependencies

## [v0.0.0] - 2017-10-26

### Added

- Composer support

### Changed

- Directory structure has been modified to adapt it to Packagist

### Removed

- Deleted Convert::old_camelToSnake()
- Deleted Convert::old_snakeToCamel()

[#11]: https://github.com/jawira/case-converter/pull/11
[#12]: https://github.com/jawira/case-converter/pull/12
[#16]: https://github.com/jawira/case-converter/pull/16
[#17]: https://github.com/jawira/case-converter/pull/17
[#18]: https://github.com/jawira/case-converter/pull/18
[#19]: https://github.com/jawira/case-converter/pull/19
[#21]: https://github.com/jawira/case-converter/pull/21
[#22]: https://github.com/jawira/case-converter/pull/22
[#24]: https://github.com/jawira/case-converter/pull/24
[#25]: https://github.com/jawira/case-converter/pull/25
[#26]: https://github.com/jawira/case-converter/pull/26
[#27]: https://github.com/jawira/case-converter/pull/27
[#29]: https://github.com/jawira/case-converter/pull/29
[#30]: https://github.com/jawira/case-converter/pull/30
[#31]: https://github.com/jawira/case-converter/pull/31
[#33]: https://github.com/jawira/case-converter/pull/33
[#35]: https://github.com/jawira/case-converter/pull/35
[#36]: https://github.com/jawira/case-converter/pull/36
[#37]: https://github.com/jawira/case-converter/pull/37
[#38]: https://github.com/jawira/case-converter/pull/38
[#40]: https://github.com/jawira/case-converter/pull/40
[#41]: https://github.com/jawira/case-converter/pull/41
[#44]: https://github.com/jawira/case-converter/pull/44
[#9]: https://github.com/jawira/case-converter/pull/9
[v1.0.0]: https://github.com/jawira/case-converter/compare/v0.0.0...v1.0.0
[v1.0.1]: https://github.com/jawira/case-converter/compare/v1.0.0...v1.0.1
[v1.1.0]: https://github.com/jawira/case-converter/compare/v1.0.1...v1.1.0
[v1.1.1]: https://github.com/jawira/case-converter/compare/v1.1.0...v1.1.1
[v1.1.2]: https://github.com/jawira/case-converter/compare/v1.1.1...v1.1.2
[v1.1.3]: https://github.com/jawira/case-converter/compare/v1.1.2...v1.1.3
[v1.1.4]: https://github.com/jawira/case-converter/compare/v1.1.3...v1.1.4
[v1.1.5]: https://github.com/jawira/case-converter/compare/v1.1.4...v1.1.5
[v1.1.6]: https://github.com/jawira/case-converter/compare/v1.1.5...v1.1.6
[v1.1.7]: https://github.com/jawira/case-converter/compare/v1.1.6...v1.1.7
[v1.2.0]: https://github.com/jawira/case-converter/compare/v1.1.7...v1.2.0
[v2.0.0]: https://github.com/jawira/case-converter/compare/v1.2.0...v2.0.0
[v2.0.1]: https://github.com/jawira/case-converter/compare/v2.0.0...v2.0.1
[v2.0.2]: https://github.com/jawira/case-converter/compare/v2.0.1...v2.0.2
[v2.0.3]: https://github.com/jawira/case-converter/compare/v2.0.2...v2.0.3
[v2.0.4]: https://github.com/jawira/case-converter/compare/v2.0.3...v2.0.4
[v2.1.0]: https://github.com/jawira/case-converter/compare/v2.0.4...v2.1.0
[v2.2.0]: https://github.com/jawira/case-converter/compare/v2.1.0...v2.2.0
[v2.3.0]: https://github.com/jawira/case-converter/compare/v2.2.0...v2.3.0
[v3.0.0]: https://github.com/jawira/case-converter/compare/v2.3.0...v3.0.0
[v3.1.0]: https://github.com/jawira/case-converter/compare/v3.0.0...v3.1.0
[v3.2.0]: https://github.com/jawira/case-converter/compare/v3.1.0...v3.2.0
[v3.2.1]: https://github.com/jawira/case-converter/compare/v3.2.0...v3.2.1
[#46]: https://github.com/jawira/case-converter/pull/46
[v3.3.0]: https://github.com/jawira/case-converter/compare/v3.2.1...v3.3.0
[v3.3.2]: https://github.com/jawira/case-converter/compare/v3.3.1...v3.3.2
[v3.3.1]: https://github.com/jawira/case-converter/compare/v3.3.0...v3.3.1
[v3.3.3]: https://github.com/jawira/case-converter/compare/v3.3.2...v3.3.3
[#49]: https://github.com/jawira/case-converter/pull/49
[#45]: https://github.com/jawira/case-converter/pull/45
[#52]: https://github.com/jawira/case-converter/pull/52
[#51]: https://github.com/jawira/case-converter/pull/51
[#50]: https://github.com/jawira/case-converter/pull/50
[v3.4.0]: https://github.com/jawira/case-converter/compare/v3.3.3...v3.4.0
[#53]: https://github.com/jawira/case-converter/pull/53
[v3.4.1]: https://github.com/jawira/case-converter/compare/v3.4.0...v3.4.1
