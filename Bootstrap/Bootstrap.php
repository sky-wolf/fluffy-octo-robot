<?php

namespace Bootstrap;
session_start();

//use DI\Container;
use DI\ContainerBuilder;


require __DIR__.'/../../vendor/autoload.php';

$Builder = new ContainerBuilder;
$Builder->addDefinitions('/config/config.php');

$container = $Builder->build();
    
var_dump($container);
