<?php

return [
  'name' => 'Ievent',

  "whenStatusChange" => [

    1 => "",
    2 => ""

  ],

  'notifiable' => [
    [
      "title" => "Event",
      "entityName" => "Modules\\Ievent\\Entities\\Event",
      "events" => [
        [
          "title" => "Event was created",
          "path" => "Modules\\Ievent\\Events\\EventWasCreated"
        ],
        [
          "title" => "Event was cancelled",
          "path" => "Modules\\Ievent\\Events\\EventWasCancelled"
        ],
        [
          "title" => "Event was updated",
          "path" => "Modules\\Ievent\\Events\\EventWasUpdated"
        ]
      ],
      "conditions" => [

      ],
      "settings" => [
        "email" => [
          "recipients" => [
            ['label' => 'Admin Email', 'value' => 'jcec007@gmail.com'],
          ]
        ],
      ],
    ],

  ],

  //Media Fillables
  'mediaFillable' => [
    'event' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single'
    ],
    'category' => [
      'mainimage' => 'single',
      'secondaryimage' => 'single'
    ]
  ]
];
