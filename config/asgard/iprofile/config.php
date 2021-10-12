<?php
return [
  'name' => 'Iprofile',
  'fields' => [
    "cellularPhone",
    "confirmPolytics",
    "birthday",
    "identification",
    "contacts",
    "socialNetworks",
    "mainImage",
    "company",
    "documentType",
    "documentNumber",
    "extraInfo",
    "user_type_id",
  ],
  //add: custom user includes (if they are empty iprofile module will be using default includes) (slim)
  'customUserIncludes' => [],
  //end custom includes and transformers
  
  'registerExtraFields' => [
    "cellularPhone",
    "birthday",
    "identification",
    "documentType",
    "documentNumber",
    "mainImage"
  ],
  
  'addressesExtraFields' => [
    "company",
    "zipCode",
    "documentType",
    "documentNumber",
    "extraInfo",
  ],
  
  'modules-to-manage-permissions' => [
    "Iprofile",
  ],
  'imagesize' => ['width' => 800, 'height' => 800],
  'mediumthumbsize' => ['width' => 400, 'height' => 400],
  'smallthumbsize' => ['width' => 100, 'height' => 100],
  
  'file_remove' => [
    'rut' => ' ',
    'camaracomercio' => ' ',
    'revenue' => '',
    'patrimony' => '',
    'expenses' => '',
    'other_revenue' => '',
    'concept_other_revenue' => '',
  ],
  
  
  'iprofile' => [
    /*
    |--------------------------------------------------------------------------
    | Partials to include on page views
    |--------------------------------------------------------------------------
    | List the partials you wish to include on the different type page views
    | The content of those fields well be caught by the PostWasCreated and PostWasEdited events
    */
    'partials' => [
      'translatable' => [
        'create' => [],
        'edit' => [],
      ],
      'normal' => [
        'create' => [],
        'edit' => [],
      ],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Dynamic relations
    |--------------------------------------------------------------------------
    | Add relations that will be dynamically added to the Post entity
    */
    'relations' => [
      //        'extension' => function ($self) {
      //            return $self->belongsTo(PostExtension::class, 'id', 'post_id')->first();
      //        }
    ],
  ],
  
  
  /*
   |--------------------------------------------------------------------------
   | Define the options to the user menu component
   |
   | @note routeName param must be set without locale. Ex: (icommerce orders: 'icommerce.store.order.index')
   | use **onlyShowInTheDropdownHeader** (boolean) if you want the link only appear in the dropdown in the header
   | use **onlyShowInTheMenuOfTheIndexProfilePage** (boolean) if you want the link only appear in the dropdown in the header
   | use **showInMenuWithoutSession** (boolean) if you want the link only appear in the dropdown when don't exist session
   | use **dispatchModal** (string - modalAlias) if you want the link only appear in the dropdown when don't exist session
   | use **url** (string) if you want customize the link
   |--------------------------------------------------------------------------
   */
  "userMenuLinks" => [
    [
      "title" => "iprofile::frontend.button.sign_in",
      "routeName" => "account.login.get",
      "quasarUrl" => '/ipanel/#/auth/login/',
      "icon" => "fa fa-user mr-2",
      "showInMenuWithoutSession" => true,
      'dispatchModal' => "#userLoginModal"
    ],
    [
      "title" => "iprofile::frontend.button.register",
      "routeName" => "account.register",
      "quasarUrl" => '/ipanel/#/auth/register/',
      "icon" => "fas fa-sign-out-alt mr-2",
      "showInMenuWithoutSession" => true,
      //'dispatchModal' => "#userRegisterModal"
    ]
  ],
  
  /*
   |--------------------------------------------------------------------------
   | Use Blade Panel or Quasar Ipanel
   |--------------------------------------------------------------------------
   | options: blade | quasar
   */
  'panel' => 'blade',
  
  /*
|--------------------------------------------------------------------------
| Define all the exportable available
|--------------------------------------------------------------------------
*/
  'exportable' => [
    "user" => [
      'moduleName' => "Iprofile",
      'fileName' => "Users",
      'fields' => ['id', 'first_name', 'last_name', 'email', 'last_login', 'created_at', 'updated_at'],
      'headings' => ['id', 'Nombre', 'Apellido', 'Email', 'Fecha Ultima Sesión', 'Fecha de Creación', 'Fecha Ultima Actualización'],
      'repositoryName' => "UserApiRepository"
    ]
  ]
];
