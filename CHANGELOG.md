# Changes in DateTimeBundle

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

## [1.1.0]

### Added
- The [DateTimeKernel](src/Component/DateTimeKernel.php) class supports now
  the validation of timezone names and a general caching of timezone objects.
- Added unit test for class [DateTimeImmutable](src/Component/DateTimeImmutable.php).
- Added new class [TestKernel](tests/TestKernel.php) to run functional tests.

### Fixed
- Classes [DateTime](src/Component/DateTime.php) and [DateTimeImmutable](src/Component/DateTimeImmutable.php)
  extend now from [prokki/ext-datetime](https://github.com/prokki/ext-datetime) package classes.
- Replaced old-style symfony/framework dependencies by new flex-style dependencies.
- Timezone configuration allows `null` values instead of empty timezone names (it is possible to use tilde `datebasse: ~` in the config yaml file).
- Available doctrine type [DateKey](src/Doctrine/DBAL/Types/DateKey.php) supports now the database timezone. 

## [1.0] - 2019-07-19

### Added
- Enabled continuous integration with [travis-ci](https://travis-ci.org/Fincallorca/DateTimeBundle) and [codecov.io](https://codecov.io/gh/Fincallorca/DateTimeBundle).

### Changed
- Requirements updated to [PHP v7.3.0](https://www.php.net/ChangeLog-7.php#7.0.0) because of mandatory `DateTime` class adjustments (i.e. [DateTime::createFromImmutable](https://www.php.net/manual/de/datetime.createfromimmutable.php))

## [0.0.14] - 2018-11-14

### Fixed
- Fixed returning an bool instead a timestamp in method [Request::getTimeStamp()](src/Component/HttpFoundation/Request.php).

## [0.0.13] - 2018-10-03

### Fixed
- DateKey extends [Fincallorca's DateTime](src/Component/DateTime.php) class instead of php native `\DateTime` class.

## [0.0.12] - 2018-09-12

### Fixed
- Second fix of incorrect date instantiation with integer.

## [0.0.11] - 2018-09-07

### Fixed
- Removed dispensable `symfony/symfony` project.

## [0.0.10] - 2018-09-07

### Fixed
- DateTimeBundle now supports Symfony 4 projects.

## [0.0.9] - 2018-09-06

### Fixed
- Fixed incorrect date instantiation with integer.

## [0.0.8] - 2018-09-05

### Fixed
- Re-added DateTime::duplicate() method.

## [0.0.7] - 2018-09-04

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

## [0.0] - 2017-10-16

First version.
