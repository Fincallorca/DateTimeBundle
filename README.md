## Sequenceable behavior extension for Doctrine2

[![Release](https://img.shields.io/badge/Release-0.0.0-blue.svg?style=flat)](https://github.com/Fincallorca/DateTimeBundle/releases/tag/0.0.0)
[![Packagist](https://img.shields.io/badge/Packagist-0.0.0-blue.svg?style=flat)](https://packagist.org/packages/fincallorca/datetimebundle)
[![LICENSE](https://img.shields.io/badge/License-MIT-blue.svg?style=flat)](LICENSE)
[![Symfony](https://img.shields.io/badge/Symfony-≥3-red.svg?style=flat)](https://symfony.com/)
[![Doctrine DBAL](https://img.shields.io/badge/Doctrine_DBAL-≥2.5-red.svg?style=flat)](https://github.com/doctrine/dbal)


The symfony **DateTimeBundle** provides a couple of functionality:
1. You can switch between different preconfigured timezone settings for *server*, *database* and *client* easily.
2. The datetime class is extended by additional useful methods (similar to [https://momentjs.com/](Moment.js)).
3. The database column type date can be used as primary key.

### Table of Contents

* [Integration](#integration)
  * [Install via Composer](#install-via-composer)
  * [Add Bundle to Symfony Application](#add-bundle-to-symfony-application)
  * [Configure](#add-bundle-to-symfony-application)

### Integration

#### Install via Composer

```bash
composer require fincallorca/datetimebundle "dev-master"
```

#### Add Bundle to Symfony Application

##### Add the `Fincallorca\DateTimeBundle` to `app/AppKernel.php`

```php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
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

##### Add Timezone Configuration

Via the `config.yml`

```yaml
datetime:
    database: "UTC"
    client: "Europe/London"
```