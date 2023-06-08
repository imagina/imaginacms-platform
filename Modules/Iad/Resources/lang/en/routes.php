<?php

return [

  'ad' => [
    'index' => [
      'index' => 'ads',
      'category' => 'ads/c/{categorySlug}',
      'service' => 'ads/s/{serviceSlug}',
    ],

    'show' => [
      'ad' => 'ad/{adSlug}',
    ],

        'create' => [
          'ad' => 'create/ad',
        ],
  ],
];
