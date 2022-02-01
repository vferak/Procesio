<?php
declare(strict_types=1);

use Procesio\Application\Middleware\AuthMiddleware;
use Procesio\Application\Middleware\SessionMiddleware;
use Slim\App;
use Tuupola\Middleware\CorsMiddleware;

return static function (App $app) {
    $app->add(SessionMiddleware::class);
    $app->add(CorsMiddleware::class);
    $app->add(AuthMiddleware::class);
};
