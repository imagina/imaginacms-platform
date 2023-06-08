# imaginacms-icommercepayu (PaymentMethod)

## Install
```bash
composer require imagina/icommercepayu-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Icommercepayu
```

## Seeder

```bash
php artisan module:seed Icommercepayu
```

## Configurations

    - merchantId
    - apilogin
    - apiKey
    - accountId
    - Allow use of Test Credit Cards

## Production

    - Confirmation URL:
         https://mydomain/api/icommercepayu/response