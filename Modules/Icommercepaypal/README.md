# imaginacms-icommercepaypal (PaymentMethod)

## Install
```bash
composer require imagina/icommercepaypal-module=v8.x-dev
```

```bash
composer require paypal/rest-api-sdk-php
```

## Enable the module
```bash
php artisan module:enable Icommercepaypal
```

## Seeder

```bash
php artisan module:seed Icommercepaypal
```

## Configurations

    - Client ID
    - Client Secret
    - Mode (Sandbox or Live)

## Sandbox

    - PayPal sandbox testing guide:
    https://developer.paypal.com/docs/api-basics/sandbox/

    - Configure Sandbox Accounts
    https://developer.paypal.com/docs/integration/paypal-here/sandbox-testing/configuring-accounts/

    - Login Account URL:
    https://www.sandbox.paypal.com/