<?php

return [

  
  'icreditWithdrawalFundsForm' => [
    "onlySuperAdmin" => true,
    'name' => 'icredit::icreditFormicreditWithdrawalFundsForm',
    'value' => [],
    'type' => 'select',
    'columns' => 'col-12 col-md-6',
    'loadOptions' => [
      'apiRoute' => 'apiRoutes.qform.forms',
      'select' => ['label' => 'title', 'id' => 'id'],
    ],
    'props' => [
      'label' => 'icredit::credits.settings.icreditWithdrawalFundsForm',
      'multiple' => false,
      'clearable' => true,
    ],
  ],
  
  'creditAmountCustomService' => [
    "onlySuperAdmin" => true,
    'name' => 'icredit::creditAmountCustomService',
    'value' => '',
    'type' => 'input',
    'columns' => 'col-12',
    'props' => [
      'label' => 'icredit::credits.settings.creditAmountCustomService',
      'type' => 'text',
    ],
  ],
];
