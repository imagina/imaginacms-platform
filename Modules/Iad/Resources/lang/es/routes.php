<?php

return [

  'ad' => [
    'index' => [
      'index' => 'anuncios',
      'category' => 'anuncios/c/{categorySlug}',
      'service' => 'anuncios/s/{serviceSlug}',
    ],

    'show' => [
      'ad' => 'anuncios/{adSlug}',
    ],


  ],
];
