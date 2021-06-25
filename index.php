<?php

require __DIR__ . '/kirby/bootstrap.php';
require __DIR__ . '/site/plugins/dbusers/src/DbKirby.php';


$kirby = new DbKirby([]);

echo $kirby->render();
