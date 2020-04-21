<?php

session_start();

use application\Container;
use components\Bootstrap;
use components\App;
use components\Config;

require __DIR__ . '/../components/Bootstrap.php';

$bootstrap = new Bootstrap();
$bootstrap->addNamespace('components', __DIR__ . '/../components');
$bootstrap->addNamespace('application', __DIR__ . '/../application');

$config = new Config();
$config->loadConfig(__DIR__ . '/../config/app.php');
$config->loadConfig(__DIR__ . '/../config/db.php');
$config->loadConfig(__DIR__ . '/../config/routing.php');

$container = new Container($config);

/** @var App $app */
$app = $container->get(App::class);

$app->handleRequest();
