# imaginacms-icommercewompi (PaymentMethod)

## Install
```bash
composer require imagina/icommercewompi-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Icommercewompi
```

## Seeder

```bash
php artisan module:seed Icommercewompi
```

## Configuration (Admin)

	- Public Key
	- Private Key
	- Event Secret Key

## Configuration Wompi Panel

	- Add this URL to Confirmation Event:
		https://mysite.com/api/icommercewompi/confirmation

	- Panel Wompi: 
		https://comercios.wompi.co/my-account/