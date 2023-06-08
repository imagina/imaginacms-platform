<?php

return [
  'name' => 'Icredit',
  'paymentName' => 'icredit',

  /*-----------------------------------------------------------------------------------------------------------------
  /* Status config description
   * 1 => pending
   * 2 => available
   * 3 => canceled / by default for all another order status
   *///---------------------------------------------------------------------------------------------------------------
  'orderStatusSync' => [
    1 => 1,   //pending
    2 => 2,   //shipped
    3 => 3,   //canceled
    4 => 2,   //completed
    5 => 3,   //denied
    6 => 3,   //canceledreversal
    7 => 3,   //failed
    8 => 3,   //refunded
    9 => 3,   //reserved
    10 => 3,  //chargeback
    11 => 1,  //pending
    12 => 3,  //voided
    13 => 2,  //processed
    14 => 3   //expired
  ],

  "requestable" => [

    1 => [
      //Required: this is the identificator of the request, must be unique with respect to other requestable types
      "type" => "withdrawalFunds",

      // Title can be trantaled or not, the language take the config app.locale
      "title" => "icredit::credits.withdrawalFundsForm.requestable.title",

      // Time elapsed to cancel in days
      "timeElapsedToCancel" => 30,

      /*
       Optional: Path of the Entity related to the requestable
       The requestable Id can be saved in the requestable
       if the requestableType is  Modules\\User\\Entities\\Sentinel\\User the id can be taked automatically of the Auth User if the id it's not specified
       */
      "requestableType" => "Modules\\Icredit\\Entities\\Icredit",

      // Optional: this form is used to get the fields data of the requestable, need to be a setting name previously charged with the formId
      "formId" => "icredit::icreditWithdrawalFundsForm",

      //requestable events to dispatch
      "events" => [
        "create" => "Modules\\Icredit\\Events\\WithdrawalFundsRequestWasCreated",
      ],

      /*
      The module has four statuses by default with the following structure:
          const PENDING = 1; (default)
          const INPROGRESS = 2;
          const COMPLETED = 3; (final)
          const CANCELLED = 4; (final)
      */
      "useDefaultStatuses" => true,


      //if you don't use the statuses configuration but you need to configure the delete request by status you can use this extra config:
      'deleteRequestWhenStatus' => [
        1 => false,
        2 => false,
        3 => true,
        4 => true
      ],

      //if you don't use the statuses configuration but you need to configure the events by status you can use this extra config:
      "eventsWhenStatus" => [
        3 => "Modules\\Icredit\\Events\\WithdrawalFundsRequestWasAcepted",
        4 => "Modules\\Icredit\\Events\\WithdrawalFundsRequestWasRejected",
      ],

      //Optional: if you don't use the statuses configuration but you need to configure the cancelled when elapsed time status you can use this extra config:
      "statusToSetWhenElapsedTime" => 4,

    ]
  ],

  /*
  *
  * Config to Activities in Igamification Module
  */
  'activities' => [
      [
        'system_name' => 'setup-wallet',
        'title' => 'icredit::activities.setup-wallet.title',
        'description' => 'icredit::activities.setup-wallet.description',
        'status' => 1,
        'url' => 'ipanel/#/credit/wallet/'
      ]
  ]

];
