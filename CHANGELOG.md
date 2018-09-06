# Changes in DateTimeBundle

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

## [0.0.9] - 2018-09-06

### Fixed
- Fixed incorrect date instantiation with integer.

## [0.0.8] - 2018-09-05

### Fixed
- Re-added DateTime::duplicate() method.

## [0.0.7] - 2018-09-04

### Added
- DateTimeBundle now supports Symfony 4 projects.

### Fixed
- Initialization of server datetime fixed.

## [0.0.6] - 2018-07-18

### Fixed
- Priority of kernel requests listeners changed to use datetimebundle functionality in other listeners. 

## [0.0.5] - 2018-07-11

### Fixed
- Copied missing [DateTimeImmutable](src/Component/DateTimeImmutable.php) methods from [DateTime](src/Component/DateTime.php) class.

## [0.0.4] - 2018-07-11

### Fixed
- Reduced requirements to symfony v3.1 (before v3.3).

## [0.0.3] - 2018-07-11

### Added
- Added method [DateTime::today()](src/Component/DateTime.php)
- Added methods [DateTime::addMonth()](src/Component/DateTime.php) and [DateTime::subMonth()](src/Component/DateTime.php)
- Added methods [DateTime::toStartOfMonth()](src/Component/DateTime.php) and [DateTime::toEndOfMonth()](src/Component/DateTime.php)

## [0.0.2] - 2018-04-27

### Added
- Added support for usage in console commands.
- Added DateTimeImmutable class.

### Changed
- Refactored services.
- Changed minimum php version to 5.5.

### Removed
- Removed static service container.

## [0.0.1] - 2017-10-17

### Fixed
- Namespace of bundle file changed.

## [0.0.0] - 2017-10-16

First version.