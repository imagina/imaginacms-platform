<?php

$filesystems = config('filesystems.disks');
$disksOptions = [];
foreach ($filesystems as $index => $disk) {
    array_push($disksOptions, ['label' => $index, 'value' => $index]);
}

return [

    'filesystem' => [
        'onlySuperAdmin' => true,
        'name' => 'media::filesystem',
        'value' => config('asgard.media.config.filesystem'),
        'type' => 'select',
        'columns' => 'col-12',
        'props' => [
            'label' => 'media::settings.label.filesystem',
            'useInput' => false,
            'useChips' => false,
            'multiple' => false,
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'options' => $disksOptions,
        ],
    ],

    'allowedImageTypes' => [
        'onlySuperAdmin' => true,
        'name' => 'media::allowedImageTypes',
        'value' => config('asgard.media.config.allowedImageTypes'),
        'type' => 'select',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hint' => 'media::settings.hint.allowedTypes',
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'label' => 'media::settings.label.allowedImageTypes',
        ],
    ],

    'allowedFileTypes' => [
        'onlySuperAdmin' => true,
        'name' => 'media::allowedFileTypes',
        'value' => config('asgard.media.config.allowedFileTypes'),
        'type' => 'select',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hint' => 'media::settings.hint.allowedTypes',
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'label' => 'media::settings.label.allowedFileTypes',
        ],
    ],

    'allowedVideoTypes' => [
        'onlySuperAdmin' => true,
        'name' => 'media::allowedVideoTypes',
        'value' => config('asgard.media.config.allowedVideoTypes'),
        'type' => 'select',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hint' => 'media::settings.hint.allowedTypes',
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'label' => 'media::settings.label.allowedVideoTypes',
        ],
    ],
    'allowedAudioTypes' => [
        'onlySuperAdmin' => true,
        'name' => 'media::allowedAudioTypes',
        'value' => config('asgard.media.config.allowedAudioTypes'),
        'type' => 'select',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hint' => 'media::settings.hint.allowedTypes',
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'label' => 'media::settings.label.allowedAudioTypes',
        ],
    ],
    'allowedRatios' => [
        'onlySuperAdmin' => true,
        'name' => 'media::allowedRatios',
        'value' => config('asgard.media.config.allowedRatios'),
        'type' => 'select',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'useInput' => true,
            'useChips' => true,
            'multiple' => true,
            'hint' => 'media::settings.hint.allowedTypes',
            'hideDropdownIcon' => true,
            'newValueMode' => 'add-unique',
            'label' => 'media::settings.label.allowedRatios',
        ],
    ],
    'maxFileSize' => [
        'onlySuperAdmin' => true,
        'name' => 'media::maxFileSize',
        'value' => config('asgard.media.config.max-file-size'),
        'type' => 'input',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'media::settings.label.maxFileSize',
        ],
    ],
    'maxTotalSize' => [
        'onlySuperAdmin' => true,
        'name' => 'media::maxTotalSize',
        'value' => config('asgard.media.config.max-total-size'),
        'type' => 'input',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'media::settings.label.maxTotalSize',
        ],
    ],

    'thumbnails' => [
        'onlySuperAdmin' => true,
        'name' => 'media::thumbnails',
        'value' => config('asgard.media.config.defaultThumbnails'),
        'label' => 'Thumbnail Config',
        'type' => 'json',
        'columns' => 'col-12',
        'props' => [
            'label' => 'media::settings.label.thumbnails',
            'type' => 'textarea',
        ],

    ],

    'defaultImageSize' => [
        'onlySuperAdmin' => true,
        'name' => 'media::defaultImageSize',
        'value' => config('asgard.media.config.defaultImageSize'),
        'label' => 'Default Image Size',
        'type' => 'json',
        'columns' => 'col-12',
        'props' => [
            'label' => 'media::settings.label.defaultImageSize',
            'type' => 'textarea',
        ],

    ],

    //configuring AWS in the Modules\Media\Providers\MediaServiceProvider::155
    'awsAccessKeyId' => [
        'onlySuperAdmin' => true,
        'name' => 'media::awsAccessKeyId',
        'value' => '',
        'type' => 'input',
        'groupName' => 'aws',
        'groupTitle' => 'media::settings.groups.aws',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'media::settings.label.awsAccessKeyId',
        ],
    ],
    'awsSecretAccessKey' => [
        'onlySuperAdmin' => true,
        'name' => 'media::awsSecretAccessKey',
        'value' => '',
        'type' => 'input',
        'groupName' => 'aws',
        'groupTitle' => 'media::settings.groups.aws',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'media::settings.label.awsSecretAccessKey',
        ],
    ],
    'awsDefaultRegion' => [
        'onlySuperAdmin' => true,
        'name' => 'media::awsDefaultRegion',
        'value' => '',
        'type' => 'input',
        'groupName' => 'aws',
        'groupTitle' => 'media::settings.groups.aws',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'media::settings.label.awsDefaultRegion',
        ],
    ],
    'awsBucket' => [
        'onlySuperAdmin' => true,
        'name' => 'media::awsBucket',
        'value' => '',
        'type' => 'input',
        'groupName' => 'aws',
        'groupTitle' => 'media::settings.groups.aws',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'media::settings.label.awsBucket',
        ],
    ],
    'awsUrl' => [
        'onlySuperAdmin' => true,
        'name' => 'media::awsUrl',
        'value' => '',
        'type' => 'input',
        'groupName' => 'aws',
        'groupTitle' => 'media::settings.groups.aws',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'media::settings.label.awsUrl',
        ],
    ],
    'awsEndpoint' => [
        'onlySuperAdmin' => true,
        'name' => 'media::awsEndpoint',
        'value' => '',
        'type' => 'input',
        'groupName' => 'aws',
        'groupTitle' => 'media::settings.groups.aws',
        'columns' => 'col-12 col-md-6',
        'props' => [
            'label' => 'media::settings.label.awsEndpoint',
        ],
    ],
    'activateCheckOfDirSize' => [
        'onlySuperAdmin' => true,
        'value' => '1',
        'name' => 'media::activateCheckOfDirSize',
        'type' => 'checkbox',
        'props' => [
            'label' => 'media::settings.label.activateCheckOfDirSize',
            'trueValue' => '1',
            'falseValue' => '0',
        ],
    ],
];
