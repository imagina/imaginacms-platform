<?php

return [
  /*
  |--------------------------------------------------------------------------
  | Real time notifications
  |--------------------------------------------------------------------------
  | Setting this to true requires a broadcast setting configured, asgard
  | comes by default with the Pusher integration (js).
  */
  'real-time' => false,
  
  'defaultEmailContent' => 'notification::emails.contents.default',
  'defaultEmailLayout' => 'notification::emails.layouts.default',
  
  "notificationTypes" => [
    
    ["title" => "SMS", "system_name" => "sms"],
    ["title" => "Whatsapp", "system_name" => "whatsapp"],
    ["title" => "Slack", "system_name" => "slack"],
    ["title" => "Email", "system_name" => "email"],
    ["title" => "Push", "system_name" => "push"],
    ["title" => "Broadcast", "system_name" => "broadcast"],
  
  ],
  
  "providers" => [
    
    "email" => [// EMAIL PROVIDER
      "name" => "Email",
      "systemName" => "email",
      "icon" => "far fa-envelope",
      "color" => "#ff1400",
      "rules" => [
        "email"
      ],
      "type" => 'email',
      "fields" => [
        "id" => [
          'value' => null,
        ],
        
        "type" => [
          "name" => "type",
          'value' => 'email',
          'type' => 'hidden',
        ],
        "fromName" => [
          "name" => "fromName",
          'value' => '',
          "isFakeField" => 'fields',
          'type' => 'input',
          'required' => true,
          'props' => [
            'label' => 'From Name *',
            "hint" => "The name the notification should come from"
          ],
        ],
        "fromAddress" => [
          "name" => "fromAddress",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'fields',
          'required' => true,
          'props' => [
            'type' => 'email',
            'label' => 'From Address *',
            "hint" => "The email address the notification should come from"
          ],
        ],
        "status" => [
          "name" => "status",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Enable',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
        "default" => [
          "name" => "default",
          'value' => false,
          'type' => 'checkbox',
          'props' => [
            'label' => 'Default',
          ],
        ],
        
        "saveInDatabase" => [
          "name" => "saveInDatabase",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Save in database',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
      ],
      
      "settings" => [
        
        "recipients" => [
          "name" => "recipients",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'settings',
          'props' => [
            'label' => 'Recipients',
            "hint" => "Enter recipient email address(es) - separate entries with commas"
          ],
        ],
        "emailTemplate" => [
          "name" => "emailTemplate",
          'value' => '',
          'type' => 'select',
          "isFakeField" => 'settings',
          'loadOptions' => [
            'apiRoute' => 'apiRoutes.notification.templates',
            'select' => ['label' => 'title', 'id' => 'id']
          ],
          'options' => [
            ['label' => 'Default', 'id' => 'default']
          ],
          'props' => [
            'label' => 'Email Template',
            "hint" => "Choose the notification email template. You can create new email templates in Email Templates"
          ],
        ],
        "status" => [
          "name" => "status",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Enable',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
        "saveInDatabase" => [
          "name" => "saveInDatabase",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Save in database',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
      ]
    ],
    
    "pusher" => [// PUSHER PROVIDER
      "name" => "Pusher",
      "systemName" => "pusher",
      "icon" => "far fa-bell",
      "color" => "#c223ce",
      "rules" => [
        "numeric",
        "min:1",
      ],
      "type" => 'broadcast',
      "fields" => [
        "id" => [
          'value' => null,
        ],
        "type" => [
          "name" => "type",
          'value' => 'broadcast',
          'type' => 'hidden',
        ],
        "pusherAppEncrypted" => [
          "name" => "pusherAppEncrypted",
          'value' => true,
          'type' => 'toggle',
          "isFakeField" => 'fields',
          'props' => [
            'label' => 'Pusher App Encrypted',
            'falseValue' => false,
            'trueValue' => true
          ],
          "configRoute" => "broadcasting.connections.pusher.options.useTLS"
        ],
        
        "pusherAppId" => [
          "name" => "pusherAppId",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'fields',
          'required' => true,
          'props' => [
            'label' => 'Pusher App Id *'
          ],
          "configRoute" => "broadcasting.connections.pusher.app_id"
        ],
        
        "pusherAppKey" => [
          "name" => "pusherAppKey",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'fields',
          'required' => true,
          'props' => [
            'label' => 'Pusher App Key *'
          ],
          "configRoute" => "broadcasting.connections.pusher.key"
        ],
        
        "pusherAppSecret" => [
          "name" => "pusherAppSecret",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'fields',
          'required' => true,
          'props' => [
            'label' => 'Pusher App Secret *'
          ],
          "configRoute" => "broadcasting.connections.pusher.secret"
        ],
        
        "pusherAppCluster" => [
          "name" => "pusherAppCluster",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'fields',
          'required' => true,
          'props' => [
            'label' => 'Pusher App Cluster *'
          ],
          "configRoute" => "broadcasting.connections.pusher.options.cluster"
        ],
        "status" => [
          "name" => "status",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Status',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
        "default" => [
          "name" => "default",
          'value' => false,
          'type' => 'checkbox',
          'props' => [
            'label' => 'Default',
          ]
        ],
        "saveInDatabase" => [
          "name" => "saveInDatabase",
          'value' => '1',
          'type' => 'select',
          'required' => true,
          "isFakeField" => 'fields',
          'props' => [
            'label' => 'Save in database',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
      
      ],
      "settings" => [
        "recipients" => [
          "name" => "recipients",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'settings',
          'props' => [
            'label' => 'Recipients',
            "hint" => "Enter recipient ID - separate entries with commas"
          ],
        ],
        "status" => [
          "name" => "status",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Enable',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
        "saveInDatabase" => [
          "name" => "saveInDatabase",
          'value' => '1',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Save in database',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
      ]
    ],
    
    "firebase" => [// PUSHER PROVIDER
      "name" => "Firebase",
      "systemName" => "firebase",
      "icon" => "fas fa-fire-alt",
      "color" => "#fbc02d",
      "rules" => [
        "numeric",
        "min:1",
      ],
      "type" >= 'broadcast',
      "fields" => [
        "id" => [
          'value' => null,
        ],
        "type" => [
          "name" => "type",
          'value' => 'push',
          'type' => 'hidden',
        ],
        "firebaseApiKey" => [
          "name" => "firebaseApiKey",
          'value' => '',
          'type' => 'input',
          'required' => true,
          "isFakeField" => 'fields',
          'props' => [
            'label' => 'Firebase Api Key *'
          ],
        ],
        "firebaseServerKey" => [
          "name" => "firebaseServerKey",
          'value' => '',
          'type' => 'input',
          'required' => true,
          "isFakeField" => 'fields',
          'props' => [
            'label' => 'Firebase Server Key *'
          ],
        ],
        "status" => [
          "name" => "status",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Enable',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
        "default" => [
          "name" => "default",
          'value' => false,
          'type' => 'checkbox',
          'props' => [
            'label' => 'Default',
          ]
        ],
        "saveInDatabase" => [
          "name" => "saveInDatabase",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Save in database',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
     
      ],
      "settings" => [
        "recipients" => [
          "name" => "recipients",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'settings',
          'props' => [
            'label' => 'Recipients',
            "hint" => "Enter recipient ID - separate entries with commas"
          ],
        ],
        "status" => [
          "name" => "status",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Enable',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
        "saveInDatabase" => [
          "name" => "saveInDatabase",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Save in database',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
      ]
    ],
  
    "labsMobile" => [// LABS MOBILE PROVIDER
      "name" => "Labs Mobile",
      "systemName" => "labsMobile",
      "icon" => "far fa-bell",
      "color" => "#c223ce",
      "rules" => [
        "numeric",
        "min:10",
      ],
      "type" => 'sms',
      "fields" => [
        "id" => [
          'value' => null,
        ],
        "type" => [
          "name" => "type",
          'value' => 'sms',
          'type' => 'hidden',
        ],
        "driver" => [
          'value' => 'labsmobile',
          'name' => 'driver',
          'type' => 'hidden',
          "isFakeField" => 'fields',
          "configRoute" => "sms.driver"
        ],
        "from" => [
          'value' => '22435',
          'name' => 'from',
          'type' => 'hidden',
          "isFakeField" => 'fields',
          "configRoute" => "sms.from"
        ],
        "clientId" => [
          "name" => "clientId",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'fields',
          'required' => true,
          'props' => [
            'label' => 'Client Id *',
          ],
          "configRoute" => "sms.labsmobile.client_id"
        ],
      
        "userName" => [
          "name" => "userName",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'fields',
          'required' => true,
          'props' => [
            'label' => 'User Name *'
          ],
          "configRoute" => "sms.labsmobile.username"
        ],
      
        "password" => [
          "name" => "password",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'fields',
          'required' => true,
          'props' => [
            'label' => 'Password *'
          ],
          "configRoute" => "sms.labsmobile.password"
        ],
  
        "test" => [
          "name" => "test",
          'value' => true,
          'type' => 'toggle',
          "isFakeField" => 'fields',
          'props' => [
            'label' => 'Test',
            'falseValue' => false,
            'trueValue' => true
          ],
          "configRoute" => "sms.labsmobile.test"
        ],
  
       
        "status" => [
          "name" => "status",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Status',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
        "default" => [
          "name" => "default",
          'value' => false,
          'type' => 'checkbox',
          'props' => [
            'label' => 'Default',
          ]
        ],
        "saveInDatabase" => [
          "name" => "saveInDatabase",
          'value' => '1',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Save in database',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
       
      ],
      "settings" => [
        "recipients" => [
          "name" => "recipients",
          'value' => '',
          'type' => 'input',
          "isFakeField" => 'settings',
          'props' => [
            'label' => 'Recipients',
            "hint" => "Enter recipient Number - separate entries with commas"
          ],
        ],
        "status" => [
          "name" => "status",
          'value' => '0',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Enable',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
        "saveInDatabase" => [
          "name" => "saveInDatabase",
          'value' => '1',
          'type' => 'select',
          'required' => true,
          'props' => [
            'label' => 'Save in database',
            'options' => [
              ["label" => 'enabled', "value" => '1'],
              ["label" => 'disabled', "value" => '0'],
            ],
          ],
        ],
      ]
    ],
  ]
];
