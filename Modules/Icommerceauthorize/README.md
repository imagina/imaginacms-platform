# imaginacms-icommerceauthorize (PaymentMethod)

## Install
```bash
composer require imagina/icommerceauthorize-module=v8.x-dev
```

```bash
composer require authorizenet/authorizenet
```

## Enable the module
```bash
php artisan module:enable Icommerceauthorize
```
## Seeder

```bash
php artisan module:seed Icommerceauthorize
```

## Configurations

    You must generate: 
        - Api Login
        - Transaction Key
        - Public Key Client
    
    Links Accounts:
        - Mode Sandbox: https://sandbox.authorize.net/
        - Mode Production: https://account.authorize.net/