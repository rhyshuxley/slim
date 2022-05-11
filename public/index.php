<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$container = new ContainerBuilder();

$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

$connection = require __DIR__ . '/../app/connection.php';
$connection($container->build());

AppFactory::setContainer($container->build());
$app = AppFactory::create();

$cont = $app->getContainer();

$table = "{$cont->get(SettingsInterface::class)->get('connection')['dbname']}.users";
$columns = "id INTEGER (11) NOT NULL AUTO_INCREMENT PRIMARY KEY, name VARCHAR (55) NOT NULL, email VARCHAR (55) NOT NULL";
$cont->get('connection')->exec("CREATE TABLE IF NOT EXISTS {$table} ({$columns})");
$sql = "INSERT INTO {$table} (name, email) VALUES ('Rhys', 'rhys@example.com')";

if ($cont->get('connection')->exec($sql) === true) {
    echo "Success!";
} else {
    echo "ERROR: {$sql} - {$cont->get('connection')->error()}";
}

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$views = require __DIR__ . '/../app/views.php';
$views($app);

$routes = require __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();