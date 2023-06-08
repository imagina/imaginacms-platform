# Icurrency 💱

## Installation

`composer require imagina/icurrency`

`php artisan module:migrate Icurrency`

`php artisan db:seed --class=\\Modules\\Icurrency\\Database\\Seeders\\CurrencyTableSeederTableSeeder`

Add middleware in `acms/app/Http/Kernel.php`

```php  
  protected $middleware = [
    // ...
      \Modules\Icurrency\Http\Middleware\CurrencyMiddleware::class,
    // ...
  ];
```

_Note: This middleware expects the currency configuration within the object or from the request filter object. Example:_
_`api/iquote/v1/products?setting={"currency":"COP"}` o `api/iquote/v1/products?filter={"currency":"COP"}`, 'settings' have higher priority._

Add command for updates TRM in `acms/app/Console/Kernel.php`

```php
  protected $commands = [
    // ...
      Modules\Icurrency\Console\UpdateCurrencies::class
    // ...
  ];
```

Add .env your Api Key 

Get your api key in [currencyconverterapi](https://www.currencyconverterapi.com/)

*Free Forex API Rate Limits*  
Currency Pairs per Request: 2  
Number of Requests per Hour: 100  

```env
CURRCONV_APIKEY=apikye
```


Run the following command the first time after making the migration to synchronize the currencies at the current exchange rate, after this they will be updated automatically with cron job.
```ssh
php artisan currencies:update
```

Add command in schedule Laravel in `acms/app/Console/Kernel.php`

```php
  protected function schedule(Schedule $schedule)
  {
    // ...
    $schedule->command(Modules\Icurrency\Console\UpdateCurrencies::class)->dailyAt('01:00');
    // ...
  }
```

### Default Currencies Available

| NAME | CODE | 
| ------------- | ------------- |
| United States Dollar| USD |  
| Colombian Peso | COP |  
| Australian dollar | AUD |
| Mexican Peso | MXN |
| Euro | EUR |  

### Use Facade Currency

Add follow line on the class that you need use this Facade:

```php 
use Modules\Icurrency\Support\Facades\Currency;
```

Methods Available

* Convert a value:
  ```php
    /* Example */
    Currency::convert(1000): 
  ``` 

* Convert a value from one currency to another currency:
  ```php
    /* Example */
    Currency::convertFromTo(1000, 'COP', 'AUD');
  ```   
* Get the current currency:
  ```php
    /* Example */
    Currency::getLocaleCurrency();
  ```
* Set current currency:
  ```php
    /* Example */
    Currency::setLocaleCurrency('COP');
  ```
  
* Get array with all current supported:
  ```php
    /* Example */
    Currency::getSupportedCurrencies();
  ```

## End Points
Route Base: `https://yourhost/api/icurrency/v1/`

* #### Currencies

* Attributes
  
    | NAME | TYPE | NULLABLE | TRANSLATABLE |
    | ------------- | ------------- |------------- | ------------- |
    | name | String | &#9744; | &#9745; | 
    | code | String | &#9744; | &#9744; | 
    | symbol_left | String | &#9744; | &#9744; | 
    | symbol_right | String | &#9744; | &#9744; | 
    | decimal_place | char | &#9744; | &#9744; | 
    | value | double | &#9744; | &#9744; | 
    | status | tinyInteger | &#9744; | &#9744; | 
    | default_currency | boolean | &#9744; | &#9744; | 
    | options | text | &#9744; | &#9744; | 
  
  * Create.
     * Method: `POST`  
     * Requires Authentication: &#9745;
     * Routes: 
        * `/currencies`
     * Post params (Example): 
     
        ```
        {
           attributes:{
             name: 'name',
             code: 'code',
             symbol_left: 'symbol_left',
             symbol_right: 'symbol_right',
             decimal_place: 'decimal_place',
             value: 'value',
             status: 'status',
             default_currency: 'default_currency',
           }
        }
        ```
  
  * Read
    * Method: `GET`
    * Requires Authentication: &#9744;
    * Routes: 
      * `/currencies`
      * `/currencies/id`
   
    * Filters
    
        |  | 
        | ------------- |
        | search |  
        | date |  
        | order |  
  * Update
    * Method: `PUT`
    * Requires Authentication: &#9745;
    * Routes: 
      * `/currencies/id`
  
  * Delete
    * Method: `DELETE`
    * Requires Authentication: &#9745;
    * Routes: 
      * `/currencies/id`
