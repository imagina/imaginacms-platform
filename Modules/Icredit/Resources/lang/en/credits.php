<?php

return [
  'list resource' => 'List credits',
  'create resource' => 'Create credits',
  'edit resource' => 'Edit credits',
  'destroy resource' => 'Destroy credits',
  'title' => [
    'credits' => 'Credit',
    'create credit' => 'Create a credit',
    'edit credit' => 'Edit a credit',
    "WithdrawalFundsRequestInProgress" => "Your request to withdrawal funds No. :requestableId it's in progress",
    "WithdrawalFundsRequestWasCreated" => "You have a new withdrawal request",
    "WithdrawalFundsRequestWasAccepted" => "Your request to withdraw funds has been approved",
    "WithdrawalFundsRequestWasRejected" => "Your request to withdraw funds has been rejected"
  ],
  'description' => "The description Module",
  'button' => [
    'create credit' => 'Create a credit',
  ],
  'table' => [
  ],
  'form' => [
  ],
  
  'settings' => [
    'icreditWithdrawalFundsForm' => 'Withdrawal funds form',
    'creditAmountCustomService' => 'Custom service for wallet amount',
  ],
  'messages' => [
    "WithdrawalFundsRequestInProgress" => "Your request to withdrawal funds it's in progress, we'll notify you when the process is completed",
    "WithdrawalFundsRequestWasCreated" => "You have a new request to withdraw funds from the client :requestUserName identified with ID number :requestableId, with a value of :requestAmount",
    "WithdrawalFundsRequestWasAccepted" => "Your withdrawal request #:requestableId has been approved, great!",
    "WithdrawalFundsRequestWasAcceptedWithETA" => "Your request to withdraw funds #:requestableId has been approved, and you will have it available for the date :requestableETA, great!",
    "WithdrawalFundsRequestWasRejected" => "Your request to withdraw funds #:requestableId, has been rejected for more information communicate to :emailTo"
  ],
  'validation' => [
  ],
  'descriptions' => [
    "orderWasCreated" => "Credit Applied to Order #:orderId",
    "WithdrawalFundsRequestWasEffected" => "Cash withdrawal applied by registration number #:requestableId",
    "WithdrawalFundsRequestWasCreated" => "Withdrawal funds No. :requestableId",
    "WithdrawalFundsRequestWasRejected" => "Withdrawal funds rejected"
  ],
  
  'withdrawalFundsForm' => [
    "requestable" => [
      "title" => "withdrawal Funds"
    ],
    'form' => [
      'title' => [
        'single' => "Withdrawal funds form"
      ],
      'fields' => [
        'amount' => "Amount"
      ]
    ]
  ],
  
  "status" => [
    'pending' => 'Pending',
    'approved' => 'Approved',
    'canceled' => 'Canceled',
  ]

];
