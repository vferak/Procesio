<?php

namespace Procesio;

use DI\Container;
use DI\ContainerBuilder;
use Slim\App;
use Slim\Factory\AppFactory;

class Bootstrap
{
    public function getContainer(): Container
    {
        $containerBuilder = new ContainerBuilder();

        if (false) { // Should be set to true in production
            $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
        }

        $settings = require __DIR__ . '/../app/settings.php';
        $settings($containerBuilder);

        $dependencies = require __DIR__ . '/../app/dependencies.php';
        $dependencies($containerBuilder);

        $repositories = require __DIR__ . '/../app/repositories.php';
        $repositories($containerBuilder);

        return $containerBuilder->build();
    }

    public function getAppInstance(Container $container): App
    {
        AppFactory::setContainer($container);
        $app = AppFactory::create();

        $middleware = require __DIR__ . '/../app/middleware.php';
        $middleware($app);

        $routes = require __DIR__ . '/../app/routes.php';
        $routes($app);

        return $app;
    }
}
