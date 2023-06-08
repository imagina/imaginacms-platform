# imaginacms-icommercepaymentez (PaymentMethod)

## Install
```bash
composer require imagina/icommercepaymentez-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Icommercepaymentez
```

## Seeder

```bash
php artisan module:seed Icommercepaymentez
```

## Configurations
    - Server App Code
    - Server App Key
	- Client App Code
    - Client App Key
    - Mode
    - Type
        - Checkout - In the same page, only cards
        - Link to pay - Reedirect to Paymentez, required webhook to the response

## Account
https://secure.paymentez.com/login

## WebHook URL to Response
    https://mydomain/api/icommercepaymentez/v1/response
