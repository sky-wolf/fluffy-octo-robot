<?php

require __DIR__.'/../vendor/autoload.php';
use app\core\Application;

$app = new Application(dirname(__DIR__));


$app->run(); 