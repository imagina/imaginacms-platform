<?php

return [
  "name" => "Ads",
  "requestable" => [
    "requestCheckAd" => "Check Ad",
    "notifyNewRequest" => [
      "title" => 'New Request',
      "message" => 'You have a new request to verify an ad',
      "viewRequests" => 'View Requests'
    ],
    "notifyUpdateRequest" => [
      "title" => 'Verification of advertisement',
      "message" => 'Your ad verification request has been updated, status: :status',
      "viewRequests" => 'View Requests'
    ]
  ],
  "settings" => [
    'allowRequestForChecked' => 'Allow request for checked'
  ]
];
