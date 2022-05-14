<?php
declare(strict_types=1);

use Procesio\Application\Middleware\AuthMiddleware;
use Procesio\Application\Middleware\SessionMiddleware;
use Slim\App;
use Tuupola\Middleware\CorsMiddleware;

return static function (App $app) {
    $app->add(SessionMiddleware::class);
    $app->add(new CorsMiddleware([
        "origin" => ["*"],
        "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
        "headers.allow" => ["Authorization", "If-Match", "If-Unmodified-Since"],
        "headers.expose" => ["Etag"],
        "credentials" => true,
        "cache" => 86400
    ]));
    $app->add(AuthMiddleware::class);
};
