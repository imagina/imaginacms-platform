# imaginacms-icommercebraintree (PaymentMethod)

## Install
```bash
composer require imagina/icommercebraintree-module=v8.x-dev
```

```bash
composer require braintree/braintree_php
```

## Enable the module
```bash
php artisan module:enable Icommercebraintree
```

## Seeder

```bash
php artisan module:seed Icommercebraintree
```

## Configurations
	- Merchant ID
    - Public Key
    - Private key
    - Mode (sandbox or production)

## Sandbox
Account: https://www.braintreepayments.com/sandbox

## Documentation SDK
PHP: https://developer.paypal.com/braintree/docs/start/hello-server/php

## API

### * Get Client Token
```GET``` ```/api/icommercebraintree/get-client-token```
##### Response:
``` 
data:
 -Token
```
### * Process Payment
```POST``` ```/api/icommercebraintree/process-payment```
##### Data:
```
attributes:
 - orderId
 - clientNonce
 - planId (Optional) - Suscriptions
 - planPrice (Optional) - Suscriptions (Override Plan Price)
 ```
##### Response:
``` 
data:
 - success (true or false)
 - transaction
```
### * Find Transaction
```GET``` ```/api/icommercebraintree/find-transaction/{id}```
##### Data:
```
- id (Braintree Transaction Id)
 ```
##### Response:
``` 
data:
 -transaction
```

