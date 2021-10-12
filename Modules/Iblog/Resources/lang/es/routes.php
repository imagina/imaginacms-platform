<?php

return [
  
  'blog' => [
    'index' => [
      'index' => 'blog',
      'category' => 'blog/c/{categorySlug}',
      'tag' => 'blog/t/{tagSlug}'
    ],
    
    'show' => [
      'post' => 'blog/{categorySlug}/{postSlug}',
    ],
  ],
];