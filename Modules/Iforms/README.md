## Imagina Forms | 4.0.0
##### By Imagina Soluciones Web

### Installation

`` composer require imagina/iforms-module ``

### Configuration

This module require ``maatwebsite/excel``

The ``Maatwebsite\Excel\ExcelServiceProvider`` is auto-discovered and registered by default.
If you want to register it yourself, add the ServiceProvider in config/app.php:

```php
'providers' => [
    /*
     * Package Service Providers...
     */
    Maatwebsite\Excel\ExcelServiceProvider::class,
]
```

The Excel facade is also auto-discovered.
If you want to add it manually, add the Facade in config/app.php:

```php
'aliases' => [
    ...
    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
]
```

To publish the config, run the vendor publish command:
```
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
```
This will create a new config file named config/excel.php.

> data source [maatwebsite/excel](https://docs.laravel-excel.com/3.1/getting-started/installation.html)


Add `NOCAPTCHA_SECRET` and `NOCAPTCHA_SITEKEY` in **.env** file :

```
NOCAPTCHA_SECRET=secret-key
NOCAPTCHA_SITEKEY=site-key
```

(You can obtain them from [here](https://www.google.com/recaptcha/admin))

### End Points
  | PATH | METHODS |
  | ------------- | ------------- | 
  | /iforms/v4/forms | [GET, POST, PUT, DELETE] |
  | /iforms/v4/fields | [GET, POST, PUT, DELETE] |
  | /iforms/v4/types | [GET] |
  | /iforms/v4/leads | [GET, POST] |

