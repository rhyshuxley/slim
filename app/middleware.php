<?php
declare(strict_types=1);

use App\Application\Middleware\AfterMiddleware;
use App\Application\Middleware\BeforeMiddleware;
use App\Application\Middleware\SessionMiddleware;
use App\Application\Settings\SettingsInterface;
use Slim\App;

return function (App $app) {
    $settings = $app->getContainer()->get(SettingsInterface::class);

    $app->addErrorMiddleware($settings->get('displayErrorDetails'), $settings->get('logError'), $settings->get('logErrorDetails'));
    $app->add(SessionMiddleware::class);
    $app->add(BeforeMiddleware::class);
    $app->add(AfterMiddleware::class);
};
