# imaginacms-icomments

## Install
```bash
composer require imagina/icomments-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Icomments
```

## Migrations
```bash
php artisan module:migrate Icomments
```

## Frontend - Component

1. Add this trait in the model
```bash
use Modules\Icomments\Traits\Commentable;
```
```bash
use Commentable;
```

2. Component Params:
	- model - entity = Model where comments will be obtained
	- approved - boolean - (optional) = If it is not sent, you will get all the comments of the model
	- showRating - boolean (default true) = Show rating (stars in each comment)
	
```bash
<x-icomments::comments :model="$product" :approved="true" />
```
