<?php

require 'vendor/autoload.php';

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Api\Service\RouterServiceProvider;
use Api\Service\ControllerServiceProvider;

$app = new Application();

$app['debug'] = true;

$app->register(new ServiceControllerServiceProvider());
$app->register(new RouterServiceProvider());
$app->register(new ControllerServiceProvider());
