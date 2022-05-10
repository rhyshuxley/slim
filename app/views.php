<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Loader\FileSystemLoader;

return function (App $app) {
    $container = $app->getContainer();

    $container->set('view', function () use ($container) {
        $settings = $container->get(SettingsInterface::class)->get('views');
        $loader = new FileSystemLoader($settings['path']);

        return new Twig($loader, $settings['settings']);
    });

    $container->set('viewMiddleware', function () use ($app, $container) {
        return new TwigMiddleware($container->get('view'), $app->getRouteCollector()->getRouteParser());
    });
};