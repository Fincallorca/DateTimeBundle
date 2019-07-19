## Fincallorca DateTimeBundle

[![Release](https://img.shields.io/badge/Release-1.0.0-blue.svg?style=flat)](https://github.com/Fincallorca/DateTimeBundle/releases/tag/1.0.0)
[![Packagist](https://img.shields.io/badge/Packagist-1.0.0-blue.svg?style=flat)](https://packagist.org/packages/fincallorca/datetimebundle)
[![codecov](https://codecov.io/gh/Fincallorca/DateTimeBundle/branch/master/graph/badge.svg)](https://codecov.io/gh/Fincallorca/DateTimeBundle)
[![Build Status](https://travis-ci.org/Fincallorca/DateTimeBundle.svg?branch=master)](https://travis-ci.org/Fincallorca/DateTimeBundle)
[![PHP v7.3](https://img.shields.io/badge/PHP-≥7.3-0044aa.svg)](https://www.php.net/)
[![LICENSE](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)](LICENSE)

The symfony **DateTimeBundle** provides a couple of functionality:
1. Save all datetime objects in database as UTC (or in a custom timezone).
2. You can switch between different preconfigured timezone settings for *server*, *database* and *client* easily.
3. The datetime class is extended by additional useful methods (similar to [https://momentjs.com/](Moment.js)).
4. The database column type date can be used as primary key.

### Table of Contents

* [Integration](#integration)
  * [Install via Composer](#install-via-composer)
  * [Add Bundle to Symfony Application](#add-bundle-to-symfony-application)
  * [Configure](#add-bundle-to-symfony-application)

### Requirements

The usage of **PHP v7.3** is obligatory.

If you want to use the library within a Symfony project, it is strongly recommend to start with **Symfony v4**.

If you want to use the library in **Symfony v3** (and PHP v5.\*) please use the release versions 0.\*. 

### Integration

#### Install via Composer

```bash
composer require fincallorca/datetimebundle "^1.0"
```

#### Add Bundle to Symfony Application

##### Symfony v4.*: Add the `Fincallorca\DateTimeBundle` to your `bundles.php`

```php

return [

    Fincallorca\DateTimeBundle\DateTimeBundle::class => ['all' => true],

]
```


##### Symfony v3.*: Add the `Fincallorca\DateTimeBundle` to your `app/Kernel.php`

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

#### Configure

##### Symfony v4.*: `config/packages/datetime.yml`

Create a new file `config/packages/datetime.yml` and insert following content:

```yaml
datetime:
    database: "UTC"
    client: "Europe/London"
```

##### Symfony v3.*: `config.yml`

Add the timezone Configuration to your `config.yml`

```yaml
datetime:
    database: "UTC"
    client: "Europe/London"
```

#### Enable Support in Class Request

Change the used Request class in the `public/index.php` or in all `public/app*.php` files (Symfony v3.*).

```php
// comment follwing line
//use Symfony\Component\HttpFoundation\Request;

// and add the new request class
use Fincallorca\DateTimeBundle\Component\HttpFoundation\Request;
```
