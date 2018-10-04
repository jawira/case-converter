Changelog
=========
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

v1.1.3 - 2018-10-04
-------------------

### Added

- Added `pds/skeleton` badge in [README.md]()
- Added `pds/skeleton` as suggestion in [composer.json]()
- Added behat tests #9

### Fixed

- Fixed bug with invalid Pascal Case #12

v1.1.2 - 2018-09-23
-------------------

### Added

- Crated Phing visualisation `build.png`

### Fixed

- Unversioning `composer.lock`

v1.1.1 - 2018-09-23
-------------------

### Fixed

- Unversioning `composer.lock`

v1.1.0 - 2018-01-29
-------------------

### Added
* Buildtools (Makefile & Phing)

### Fixed
* Bug with spanish characters ([issue #6](https://github.com/jawira/case-converter/issues/6))

v1.0.1 - 2017-11-10
-------------------

### Added
* Unitary tests
* Unitary tests for spanish characters

### Fixed
* Bug with acronyms ([issue #5](https://github.com/jawira/case-converter/issues/5))

v1.0.0 - 2017-10-27
-------------------

### Changed
* Slight changes on [README.md]()

### Removed
* PHPUnit and pds/skeleton dependencies

v0.0.0 - 2017-10-26
-------------------

### Added
* Composer support

### Changed
* Directory structure has been modified to adapt it to Packagist

### Removed
* Deleted Convert::old_camelToSnake()
* Deteled Convert::old_snakeToCamel()
