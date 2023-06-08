# Documnets Module 1.0

The Docummnets module allows authorized users to maintain a blog. Blogs are a series of posts that are time stamped and are typically viewed by date as you would view a journal. Blog entries can be made public or private to the site members, depending on which roles have access to view content.

##Docuemnt API Services

##List documents

###all
route

``https://mydomain.com/api/idocs/v1/documents?``

filters
```json
filter={"categories":{1,2,3},"document":[1,3,2], }

```
The `Maatwebsite\Excel\ExcelServiceProvider` is auto-discovered and registered by default.

If you want to register it yourself, add the ServiceProvider in config/app.php:
```php
'providers' => [
    /*
     * Package Service Providers...
     */
    Maatwebsite\Excel\ExcelServiceProvider::class,
]
```
The `Excel` facade is also auto-discovered.

If you want to add it manually, add the Facade in config/app.php:
```php
'aliases' => [
    ...
    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
]
```
To publish the config, run the vendor publish command:
```php
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider
```

This will create a new config file named `config/excel.php`.