<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new ContainerBuilder();

$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

AppFactory::setContainer($container->build());
$app = AppFactory::create();

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$views = require __DIR__ . '/../app/views.php';
$views($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();