# imaginacms-imeeting (Provider Module)

## Install
```bash
composer require imagina/imeeting-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Imeeting
```

## Migration

```bash
php artisan module:migrate Imeeting
```

## Seeder

```bash
php artisan module:seed Imeeting
```

## Providers

### * Zoom (By Default)

#### Account and get configurations (App JWT)
Account: https://zoom.us/signin
- Api Key
- Api Secret

## Meeting Service

### Params
	@param meetingAttr - Array | Example: 'title','startTime','email'
	@param entityAttr - Array | Example: 'id','type'
	@param providerName - String (optional) | Example: 'zoom'
### Example

```php
// Example to create a meeting
// Zoom is Provider Default
if(is_module_enabled('Imeeting')){

        // Meeting
        $dataToCreate['meetingAttr'] =[
            'title' => 'Reunion con Usuario - CitaId:'.$appointment->id,
            'startTime' => '27-08-2021 14:00:00',
             'email' => 'hostemail@email.com' //Host
        ];

        // Entity
        $dataToCreate['entityAttr'] =[
            'id' => $appointment->id,
            'type' => get_class($appointment),  
        ];

        $meeting = app('Modules\Imeeting\Services\MeetingService')->create($dataToCreate);

}
```
