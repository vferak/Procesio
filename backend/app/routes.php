<?php
declare(strict_types=1);

use Procesio\Application\Actions\Authentication\LoginAction;
use Procesio\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('/{id}', ViewUserAction::class);
    });

    $app->group('/v1', function (Group $group) {
        $group->post('/login', LoginAction::class);
        $group->post('/register', RegisterAction::class);

        $group->group('/workspace',function (Group $group) {
            //$group->get('/{id}', RegisterAction::class);
            $group->post('/', RegisterAction::class);
            //$group->put('/{id}', RegisterAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

    });

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
