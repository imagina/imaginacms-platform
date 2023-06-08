# Requestable Imagina Module

Requestable it's a module for Imagina CMS open source fully customizable for entrepreneurs around the world.

###Seeder config
This module has a seed in charge of going through all the configurations of the enabled modules looking for a
configuration named 'requestable' with which it creates the necessary categories and statuses in the database, such
config must be an array of arrays and needs to have the following structure:

```

   /*
|--------------------------------------------------------------------------
| Requestable config
|--------------------------------------------------------------------------
*/
  "requestable" => [
    
    1 => [
      //Required: this is the identificator of the request, must be unique with respect to other requestable types 
      "type" => "nameOfTheRequest",
     
      // Title can be trantaled or not, the language take the config app.locale 
      "title" => "module::tranlation.requestable1.title",
           
      // Time elapsed to cancel in days
      "timeElapsedToCancel" => 30,
      
      /* 
       Optional: Path of the Entity related to the requestable 
       The requestable Id can be saved in the requestable
       if the requestableType is  Modules\\User\\Entities\\Sentinel\\User the id can be taked automatically of the Auth User if the id it's not specified
       */
      "requestableType" => "Modules\\ModuleName\\Entities\\EntityName",
      
      // Optional: this form is used to get the fields data of the requestable, need to be a setting name previously charged with the formId
      "formId" => "module::settingNameForm",
        
      // Optional: This columns has true by default
      "internal" => false,
        
      //requestable events to dispatch  
      "events" => [
          "create" => "Modules\\ModuleName\\Events\\EventDispatchedWhenRequestWasCreated",
          "update" => "Modules\\ModuleName\\Events\\EventDispatchedWhenRequestWasUpdated",
          "delete" => "Modules\\ModuleName\\Events\\EventDispatchedWhenRequestWasDeleted",
          "etaUpdated" => "Modules\\ModuleName\\Events\\EventDispatchedWhenRequestEtaWasUpdated",
      ],
      
      /*
      The module has four statuses by default with the following structure:
          const PENDING = 1; (default)
          const INPROGRESS = 2;
          const COMPLETED = 3; (final)
          const CANCELLED = 4; (final)
      */
      "useDefaultStatuses" => true,
      
      //Optional: if the useDefaultStatuses is true, statuses is ignored 
      "statuses" => [
        1 => [
            "id" => 1,
            "title" => "module::translation.status1.title", // Title can be trantaled or not, the language take the config app.locale 
            "final" => false, //optional (default false)
            "default" => true,
            "delete_request" => false, //optional (default false)
            "cancelled_elapsed_time" => false,
            "events" => "Modules\\ModuleName\\Events\\RequestInStatus1" //optional (default null)
        ],
        2 => [
            "id" => 2,
            "title" => "module::translation.status2.title",
            "final" => true,
            "default" => false,
            "delete_request" => true,
            "cancelled_elapsed_time" => true,
            "events" => [ //optional can be multiple too
                "Modules\\ModuleName\\Events\\RequestInStatus2",
                "Modules\\ModuleName\\Events\\RequestInStatus2SecondEvent"
            ]
        ],
        .
        .
        .
        "N" => [
            "id" => "N",
            "title" => "module::translation.statusN.title"
            "final" => true/false,
            "default" => true/false,
            "delete_request" => true/false,
            "cancelled_elapsed_time" => true/false,
             "events" => [
                "Modules\\ModuleName\\Events\\RequestInStatusN",
                "Modules\\ModuleName\\Events\\RequestInStatusNSecondEvent"
            ]
        ],
      ],
      
      //if you don't use the statuses configuration but you need to configure the delete request by status you can use this extra config: 
      'deleteRequestWhenStatus' => [
        1 => false,
        2 => true,
        3 => false,
        4 => true
      ],
      
      //if you don't use the statuses configuration but you need to configure the events by status you can use this extra config:
      "eventsWhenStatus" => [
        2 => "Modules\\ModuleName\\Events\\RequestInStatus2",
        3 =>  [
                "Modules\\ModuleName\\Events\\RequestInStatus3",
                "Modules\\ModuleName\\Events\\RequestInStatus3SecondEvent"
            ],
      ], 
      
      /*
      Optional: If you don't use this config and the useDefaultStatuses is true the default status used is 1
      if you use the statuses and defined some one by default that's would be the status applied.
      */
      'defaultStatus' => 1,
      
      //Optional: if you don't use the statuses configuration but you need to configure the cancelled when elapsed time status you can use this extra config:
      "statusToSetWhenElapsedTime" => 4,
           
    ]
  ]


```
 - Note: All the information obtained from the config is stored in the database in Category and Status models, which can then be customized if necessary via api.


###Api
The module has implemented the standard json:api in all its entities so that it can be consumed with the endpoint prefix:  ```api/requestable/v1```


###Services
There is a service to create and update request to be consumed by the backend itself when needed.

```Modules\Requestable\Services\RequestableService```

Example of data to the service create:

```
    $requestableService = app("Modules\Requestable\Services\RequestableService");
    
    $requestableService->create([
        "type":"withdrawalFunds",
        "fields": [
            {
            "name": "amount",
            "value": 43000
            }
        ]
    ]);
```

Example of data to the service update:

```
    $requestableService = app("Modules\Requestable\Services\RequestableService");
    
    $requestableService->update(11, [
        //if you know the status_id in the database you can send status_id, but if only know the status value defined in the config just send status
        "status": 2,
        "eta": "2021-06-21"
    ]);
```
All the rest of the request configuration is taken from the information obtained from the config with the same type

###Events

The module is very customizable when you need it to execute events, in each type of enabled event different parameters are sent:


| Event | Parameters | 
| ------------- | ------------- 
| created | $request
| updated | $updatedRequest - $oldRequest
| deleted | $deletedRequest
| etaUpdated | $updatedRequest - $oldRequest

### JOBS to Automation Rules

#### Migration Commands
```
php artisan queue:table
```
```
php artisan queue:failed-table
```
#### Extra Commands
```
php artisan queue:restart
```

#### File .env
```
QUEUE_CONNECTION=database
```
#### Migrate jobs table
```
php artisan migrate
```

### Reports

#### Create Multiples Reports

1. Add a new "option" in reportType ("config.exportable.requestables.exportFields.reportType") example:
```
 ['label' => 'requestable::exports.exportFields.type.mynew', 'value' => "mynew"],
```

2. Go to Requestable/Exports/Reports/" and copy the file from other report (Ej: detailedReport.php) and set name to the file (mynewReport.php) and the new class (class mynewReport) with the same value from the option created above Example:
```
mynewReport.php
```

3. To set the Heading use the method "getHeading" in the new file.
```
public function getHeading()
{
    //your nice code here
}
```

4. To set each Row use the method "getMap" in the new file.
```
public function getMap($item)
{
    //your nice code here
}
```

5. If you need a method from the RequestableExport you can use:
```
$this->requestableExport
```