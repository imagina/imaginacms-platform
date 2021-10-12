<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Choose which filesystem you wish to use to store the media
    |--------------------------------------------------------------------------
    | Choose one or more of the filesystems you configured
    | in app/config/filesystems.php
    | Supported: "local", "s3"
    */
    'filesystem' => 'publicmedia',
    /*
    |--------------------------------------------------------------------------
    | The path where the media files will be uploaded
    |--------------------------------------------------------------------------
    | Note: Trailing slash is required
    */
    'files-path' => '/assets/media/',
    /*
    |--------------------------------------------------------------------------
    | Specify all the allowed file extensions a user can upload on the server
    |--------------------------------------------------------------------------
    */
    'allowed-types' => 'jpg,png,pdf,jpeg,mp4,webm,ogg,svg',
    'allowedImageTypes' => json_encode(["jpg", "png", "jpeg", "svg"]),
    'allowedFileTypes' => json_encode(["pdf", "doc", "docx", "xls", "xlsx"]),
    'allowedVideoTypes' => json_encode(["mp4","webm","ogg"]),
    'allowedAudioTypes' => json_encode([ "mp3", "avi"]),
    /*
    |--------------------------------------------------------------------------
    | Determine the max file size upload rate
    | Defined in MB
    |--------------------------------------------------------------------------
    */
    'max-file-size' => '10',

    /*
    |--------------------------------------------------------------------------
    | Determine the max total media folder size
    |--------------------------------------------------------------------------
    | Expressed in bytes
    */
    'max-total-size' => 1000000000,

    /*
    |--------------------------------------------------------------------------
    | Custom Sidebar Class
    |--------------------------------------------------------------------------
    | If you want to customise the admin sidebar ordering or grouping
    | You can define your own sidebar class for this module.
    | No custom sidebar: null
    */
    'custom-sidebar' => null,

    /*
    |--------------------------------------------------------------------------
    | Load additional view namespaces for a module
    |--------------------------------------------------------------------------
    | You can specify place from which you would like to use module views.
    | You can use any combination, but generally it's advisable to add only one,
    | extra view namespace.
    | By default every extra namespace will be set to false.
    */
    'useViewNamespaces' => [
        // Read module views from /Themes/<backend-theme-name>/views/modules/<module-name>
        'backend-theme' => false,
        // Read module views from /Themes/<frontend-theme-name>/views/modules/<module-name>
        'frontend-theme' => false,
        // Read module views from /resources/views/asgard/<module-name>
        'resources' => false,
    ],


  'defaultImageSize' => json_encode(['width' => 1920, 'height' => 1080, 'quality' => 90]),
 
  'watermark' => [
    'activated' => false,
    'url' => 'modules/media/img/watermark/watermark.png',
    'position' => 'top-left', //top, top-right, left, center, right, bottom-left, bottom, bottom-right
    'x' => 10,
    'y' => 10,
  ],
  
  "defaultThumbnails" => json_encode([
    "smallThumb" => [
      "quality" => 80,
      "width" => 300,
      "height" => null,
      "aspectRatio" => true,
      "upsize" => true,
      "format" => "webp",
    ],
    "mediumThumb" => [
      "quality" => 80,
      "width" => 600,
      "height" => null,
      "aspectRatio" => true,
      "upsize" => true,
      "format" => "webp",
    ],
    "largeThumb" => [
      "quality" => 80,
      "width" => 900,
      "height" => null,
      "aspectRatio" => true,
      "upsize" => true,
      "format" => "webp",
    ],
    "extraLargeThumb" => [
      "quality" => 80,
      "width" => 1920,
      "height" => null,
      "aspectRatio" => true,
      "upsize" => true,
      "format" => "webp",
    ]
  ])
];
