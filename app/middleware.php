<?php
declare(strict_types=1);

use App\Application\Middleware\AfterMiddleware;
use App\Application\Middleware\BeforeMiddleware;
use App\Application\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->addErrorMiddleware(true, true, false);
    $app->add(SessionMiddleware::class);
    $app->add(BeforeMiddleware::class);
    $app->add(AfterMiddleware::class);
};
