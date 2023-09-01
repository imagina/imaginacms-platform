<?php

return [

    'usersToNotify' => [
        'name' => 'iauctions::usersToNotify',
        'value' => [],
        'type' => 'select',
        'columns' => 'col-12 col-md-6',
        'loadOptions' => [
            'apiRoute' => 'apiRoutes.quser.users',
            'select' => ['label' => 'email', 'id' => 'id'],
        ],
        'props' => [
            'label' => 'iauctions::common.settings.usersToNotify',
            'multiple' => true,
            'clearable' => true,
        ],
    ],

    'formEmails' => [
        'name' => 'iauctions::formEmails',
        'value' => [],
        'type' => 'select',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hint' => 'iauctions::common.settingHints.emails',
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'label' => 'iauctions::common.settings.emails',
        ],
    ],

];
