<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/../application/config/prod.php';
require __DIR__.'/../application/app.php';
require __DIR__.'/../application/routes.php';

$app->run();