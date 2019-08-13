# Fincallorca DateTimeBundle

[![Latest Stable Version](https://poser.pugx.org/fincallorca/datetimebundle/v/stable)](https://packagist.org/packages/fincallorca/datetimebundle)
[![codecov](https://codecov.io/gh/Fincallorca/DateTimeBundle/branch/master/graph/badge.svg)](https://codecov.io/gh/Fincallorca/DateTimeBundle)
[![Build Status](https://travis-ci.org/Fincallorca/DateTimeBundle.svg?branch=master)](https://travis-ci.org/Fincallorca/DateTimeBundle)
[![License](https://poser.pugx.org/fincallorca/datetimebundle/license)](https://packagist.org/packages/fincallorca/datetimebundle)
[![PHP ≥ v7.3](https://img.shields.io/badge/PHP-%E2%89%A57%2E3-red.svg)](https://www.php.net/manual/en/migration73.new-features.php)
[![Symfony ≥ v4](https://img.shields.io/badge/Symfony-%E2%89%A54-red.svg)](https://symfony.com/)

The symfony **DateTimeBundle** provides a couple of functionalities to get rid of the current lack of php, symfony and doctrine date management support:

1. Usage of new [DateTime](src/Component/DateTime.php)/[DateTimeImmutable](src/Component/DateTimeImmutable.php) methods. 

2. Access Symfony's http request time by method - not by global `$_SERVER` property. See class [Request](src/Component/HttpFoundation/Request.php).

3. Save datetime values in database always in the same timezone.
 
4. Switch between different preconfigured timezone settings easily (available configs: *server*, *database* and *client*).

5. Use the doctrine's column type date as primary key.

6. A new central point for [\DateTimeZone](https://www.php.net/manual/class.datetimezone.php) object caching.

All these functionalities are optional. You can install this bundle without using any of this features or with using only one or a few of them.

## Table of Contents

* [Requirements](#requirements)
* [Integration](#integration)
* [Usage](#usage)
  * [Enable Support in Class Request](#enable-support-in-class-request)
  * [Configure Timezones](#configure-timezones)
    * [Configure Database Timezone](#configure-database-timezone)
    * [Configure Default Client Timezone](#configure-default-client-timezone)
  * [Use Timezone Caching](#use-timezone-caching)
* [Deprecated: Symfony v3](#deprecated-symfony-v3)
* [Credits](#credits)


## Requirements

The usage of **PHP v7.3** is obligatory. It is strongly recommend to start with **Symfony v4**.

If you want to use the library in **Symfony v3** (and PHP _v5.\*) please use the release version 0.\*. 



## Integration

```bash
composer require fincallorca/datetimebundle "^1.0"
```


## Usage

To use the new datetime method replace the instantiation of your existing `\DateTime`/`\DateTimeImmutable` objects
to the provided [\Fincallorca\DateTimeBundle\Component\DateTime](src/Component/DateTime.php)/[\Fincallorca\DateTimeBundle\Component\DateTimeImmutable](src/Component/DateTimeImmutable.php) classes.

These classes provide **additional useful datetime methods** like

* `$dateTime->duplicate()`
* `$dateTime->addHours()`
* `$dateTime->toEndOfDay()`
* etc.

Please visit [prokki/ext-datetime](https://github.com/prokki/ext-datetime) to get more information of all new features.

Furthermore the datetime classes support all preconfigured timezones. Use the methods 

* `$dateTime->toServerDateTime()`
* `$dateTime->toDatabaseDateTime()`
* `$dateTime->toClientDateTime()`

to **switch fast between the timezones**. To see how to configure the timezones take a look chapter [Configure Timezones](#configure-timezones).



### Enable Support in Class Request

The current **symfony's request class** does not return the request's time value properly.
Especially if need to access the request's time often the change of the Request object will
help you to save a lot of time.

To use the [\Fincallorca\DateTimeBundle\Component\HttpFoundation\Request](src/Component/HttpFoundation/Request.php) class in your controllers
replace the current request class by the new one in your `public/index.php` or in all `public/app*.php` files (Symfony v3.*).

```php
// comment follwing line
//use Symfony\Component\HttpFoundation\Request;

// and add the new request class
use Fincallorca\DateTimeBundle\Component\HttpFoundation\Request;
```

Additionally do the same in all controllers or at least in these controllers
you want to access the request's time.

Afterwards you can access the request's time method specified in the [RequestDateTimeInterface](src/Component/HttpFoundation/RequestDateTimeInterface.php).

Example:

```php

use Fincallorca\DateTimeBundle\Component\HttpFoundation\Request;

class MyController extends Controller

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        // get the request's date time
        $requestDateTime = $request->getDateTime();
    }
```



### Configure Timezones
 
The possibilities

1. to save all datetimes in one common timezone and

2. to initialize a general client timezone

are both optional.

To configure at least one of both you need to create
a new file `config/packages/datetime.yml` and insert following content:
```yaml
datetime:
  database: ~  
  client: ~
```



#### Configure Database Timezone

To save all datetime objects into the database with one common timezone only (i.e. with **UTC**),
modify the configuration variable `database`: 

```yaml
datetime:
  # feel free to change the timezone name to your needs!
  database: "UTC" 
  client: ~
```

:warning: But please take care that
1. all datetimes read from the database are initialized with the new database timezone and
2. all datetimes saved into the database are converted into the given timezone before saving.



#### Configure Default Client Timezone

You can set up a client's default timezone by simply changing the variable `client`
in the configuration:

```yaml
datetime:
  database: ~
  # both variables (database and client) are optional...
  # if you do not specify the timezones, all times will be saved with your default server time  
  client: "Europe/London"
``` 

In opposite to the configured database timezone it is possible to change the
default client's timezone during the runtime by calling [Fincallorca\DateTimeBundle\Component\DateTimeKernel::setTimeZoneClient()](src/Component/DateTimeKernel.php)



### Use Timezone Caching

If you are working intensively with timezones, you might want to avoid
instantiating timezone object multiple times. Thus the [Fincallorca\DateTimeBundle\Component\DateTimeKernel](src/Component/DateTimeKernel.php) class
provides the static method `getTimeZoneByName()` to work with cached timezone.

A call of `DateTimeKernel::getTimeZoneByName()` with the same passed timezone name for multiple times will always return the same timezone object.

To be sure to use the timezone caching, change the instantiations of all your [\DateTimeZone](https://www.php.net/manual/class.datetimezone.php) objects
from `new \DateTimeZone($STRING)` to `DateTimeKernel::getTimeZoneByName($STRING)`.



## Deprecated: Symfony v3

Install the bundle via composer:

```bash
composer require fincallorca/datetimebundle "^0.0"
```

Extend your `AppKernel.php` with the new bundle:

```php

class Kernel extends \Symfony\Component\HttpKernel\Kernel
{
    public function registerBundles()
    {
        return [
            // [...]
            new Fincallorca\DateTimeBundle\DateTimeBundle(),
        ];
    }
    
    // [...]
}
```

Configure the bundle by adding the timezone configuration to your `config.yml`

```yaml
datetime:
    database: "UTC"
    client: "Europe/London"
```


## Credits

A big thank you to [prokki/ext-datetime](https://github.com/prokki/ext-datetime) for the extension of the `\DateTime`/`\DateTimeImmutable` classes.