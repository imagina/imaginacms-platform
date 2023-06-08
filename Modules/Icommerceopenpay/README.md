# imaginacms-icommerceopenpay (PaymentMethod)

## Install
```bash
composer require imagina/icommerceopenpay-module=v8.x-dev
```
```bash
composer require openpay/sdk
```

## Enable the module
```bash
php artisan module:enable Icommerceopenpay
```

## Seeder

```bash
php artisan module:seed Icommerceopenpay
```

## FRONTEND

### Styles (Compile Theme)
```bash
npm run dev
```

### Publish Module
```bash
php artisan module:publish Icommerceopenpay
```

## Configurations
	- merchantId
    - publicKey
    - privateKey

## Webhooks
#### Documentation
https://documents.openpay.co/notificaciones/

#### Create - (To add URL - Example enviroment: SANDBOX)
https://sandbox-dashboard.openpay.co/settings

#### URL to confirmation
```bash
https://mydomain/api/icommerceopenpay/v1/confirmation
```

#### Confirmation Code
The verification code will be saved in the payment method configurations automatically

## Sandbox
Account: https://sandbox-dashboard.openpay.co

## Production
Account: https://dashboard.openpay.co
