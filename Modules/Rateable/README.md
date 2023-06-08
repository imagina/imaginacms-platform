# imaginacms-rateable

## Install
```bash
composer require imagina/rateable-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Rateable
```

## Migrations
```bash
php artisan module:migrate Rateable
```

## Comments to Module
You must also follow the installation steps of the Icomments Module (Enable Module and run Migrations)
https://github.com/imagina/imaginacms-icomments/tree/v8.x#enable-the-module

## Frontend - Component

1. Add this trait in the model
```bash
use Modules\Rateable\Traits\Rateable;
```
```bash
use Rateable;
```

2. Component Params:
	- model - (optional) = Model where data will be obtained
	- layout - (optional) =
		- rating-layout-1 (default)
	- rating - Default 0 = If you do not send the MODEL, this value will be taken as the rating

	Examples:

Get rating from model:
```bash
<x-rateable::rating :model="$product"/>
```
Set rating value to the component:
```bash
<x-rateable::rating rating="5"/>
```
