# Changelog

All notable changes to this project will be documented in this file.

## Unreleased

### Added

- Waffle.io badge in README.md

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

- Unversioning `composer.lock`

## [v1.1.1] - 2018-09-23

### Fixed

- Unversioning `composer.lock`

## [v1.1.0] - 2018-01-29

### Added
* Buildtools (Makefile & Phing)

### Fixed
* Bug with spanish characters ([issue #6](https://github.com/jawira/case-converter/issues/6))

## [v1.0.1] - 2017-11-10

### Added
* Unitary tests
* Unitary tests for spanish characters

### Fixed
* Bug with acronyms ([issue #5](https://github.com/jawira/case-converter/issues/5))

## [v1.0.0] - 2017-10-27

### Changed
* Slight changes on [README.md]()

### Removed
* PHPUnit and pds/skeleton dependencies

## [v0.0.0] - 2017-10-26

### Added
* Composer support

### Changed
* Directory structure has been modified to adapt it to Packagist

### Removed
* Deleted Convert::old_camelToSnake()
* Deleted Convert::old_snakeToCamel()

[#12]: https://github.com/jawira/case-converter/pull/12
[#9]: https://github.com/jawira/case-converter/pull/9
[v1.1.5]: https://github.com/jawira/case-converter/compare/v1.1.4...v1.1.5
[v1.1.4]: https://github.com/jawira/case-converter/compare/v1.1.3...v1.1.4
[v1.1.3]: https://github.com/jawira/case-converter/compare/v1.1.2...v1.1.3
[v1.1.2]: https://github.com/jawira/case-converter/compare/v1.1.1...v1.1.2
[v1.1.1]: https://github.com/jawira/case-converter/compare/v1.1.0...v1.1.1
[v1.1.0]: https://github.com/jawira/case-converter/compare/v1.0.1...v1.1.0
[v1.0.1]: https://github.com/jawira/case-converter/compare/v1.0.0...v1.0.1
[v1.0.0]: https://github.com/jawira/case-converter/compare/v0.0.0...v1.0.0
[v1.1.6]: https://github.com/jawira/case-converter/compare/v1.1.5...v1.1.6