<?php

return [
  'name' => 'Icomments',
  
  /**
   * By default comments posted are marked as approved. If you want
   * to change this, set this option to true. Then, all comments
   * will need to be approved by setting the `approved` column to
   * `true` for each comment.
   *
   */
  'approval_required' => false,


  "mediaFillable" => [
    'comment' => [
      'mainimage' => 'single',
      'gallery' => 'multiple',
    ]
  ],
  
  /**
   * Set this option to `true` to enable guest commenting.
   *
   * Visitors will be asked to provide their name and email
   * address in order to post a comment.
   */
  'guest_commenting' => false,

];
