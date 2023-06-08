# imaginacms-igamification

## Install
```bash
composer require imagina/igamification-module=v8.x-dev
```

## Enable the module
```bash
php artisan module:enable Igamification
```

## Migrations
```bash
php artisan module:migrate Igamification
```
## Publish Assets (Run it before the seeders)
```bash
php artisan module:publish Igamification
```

## Seeder
```bash
php artisan module:seed Igamification
```

## Config `gamification` for any module to seed in the gamification
If a module needs to seed categories or activities for the gamification it's able to do it 
with a config named `gamification` with the following structure and dispatching the igamification seed.
```bash
[
  //Data of categories to seed in the gamification
  'categories' => [
    [
      'systemName' => "admin_home", //System name|unique
      "title" => "igamification::igamification.gamification.categories.adminHome",//Category title|Translatable
      "description" => "igamification::igamification.gamification.categories.adminHomeDescription", //Category description|Translatable
      "icon" => 'fa-light fa-rocket',//Category icon|fontaweson|nullable
      "categoryView" => "card",//Category view mode|card-button-popup
      "activityView" => "list",//Activity view mode|listButton-list-cardImage-cardIcon
      "mainImage" => "modules/igamification/category/gamification_admin_home.png",//relative path of a internal public image for category|nullable
    ]
  ],
  //Data of activities what needs to seed in the gamification
  'activities' => [
    [
      'systemName' => 'admin_home_tour_menu',//System name|unique,
      'title' => "igamification::igamification.gamification.activities.adminHomeTourMenu",//activity title|Translatable,
      'description' => "igamification::igamification.gamification.activities.adminHomeTourMenu",//Activity description|Translatable,
      'type' => 6,//activity type|action of activity|values: INTERNAL_URL = 1, EXTERNAL_URL = 2, INTERNAL_FORM = 3, FORM_SCRIPT = 4, IFRAME = 5, TOUR = 6
      'url' => "www.google.com",//Url to link|for type 1,
      'formId' => "contacto",//systemName of internal form|for type 3
      'externalScript' => "<script...>",//an external script|for type 4
      'iframe' => "<iframe...>",//iframe context|for type 5
      'tourElement' => "#adminMenu",//Identifier for DOM element to pick a popup(tour)|for type 6
      'tourElementPosition' => "right",//position to show a popup(tour)|for type 6|top-left-bottom-right
      'roles' => ["editor","admin"],//array of slugs of internal roles|limit the activity for this roles|empty enable it for everyone
      'categoryId' => "admin_home",//systemName of internal category
      "icon" => 'fa-light fa-rocket',//activity icon|from fontaweson,
      "mainImage" => "modules/igamification/category/gamification_admin_home.png",//relative path of a internal public image for category
    ]
]
the categories from each module will seeded first of any activity
```

## Events

### Example adding event in Entity Module when this model is created
```bash
public $dispatchesEventsWithBindings = [
  'created' => [
        [
          'path' => 'Modules\Igamification\Events\ActivityWasCompleted',
          'extraData' => ['systemNameActivity' => 'system-name-example']
        ]
      ]
  ];
```

### ActivityWasCompleted
Add in your Module when your considered that process is completed for logged user

```bash
if (is_module_enabled("Igamification")) event(new \Modules\Igamification\Events\ActivityWasCompleted([
      'extraData' => [
        'systemNameActivity' => 'system-name-example'
      ]
  ])
);
```
