<?php

use Kirby\Cms\App as Kirby;

require __DIR__ . '/src/DbUser.php';
require __DIR__ . '/src/DbUsers.php';

Kirby::plugin('cookbook/dbusers', [
  'options' => [
    'contentTable'    => 'content',
    'userTable'       => 'users',
    'defaultLanguage' => 'en',
  ],
  'blueprints' => [
    'users/default' => __DIR__ . '/blueprints/users/default.yml',
  ],
  'routes' => [
  
  ]
]);