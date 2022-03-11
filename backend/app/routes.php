<?php
declare(strict_types=1);

use Procesio\Application\Actions\Authentication\LoginAction;
use Procesio\Application\Actions\Authentication\RegisterAction;
use Procesio\Application\Actions\Package\CreatePackageAction;
use Procesio\Application\Actions\Package\EditPackageAction;
use Procesio\Application\Actions\Package\ViewPackageAction;
use Procesio\Application\Actions\Process\CreateProcessAction;
use Procesio\Application\Actions\Process\EditProcessAction;
use Procesio\Application\Actions\Process\ViewProcessAction;
use Procesio\Application\Actions\Project\CreateProjectAction;
use Procesio\Application\Actions\Project\EditProjectAction;
use Procesio\Application\Actions\Project\ViewProjectAction;
use Procesio\Application\Actions\Subprocess\CreateSubprocessAction;
use Procesio\Application\Actions\Subprocess\EditSubprocessAction;
use Procesio\Application\Actions\Subprocess\ViewSubprocessAction;
use Procesio\Application\Actions\User\EditUserAction;
use Procesio\Application\Actions\User\ViewUserAction;
use Procesio\Application\Actions\Workspace\AddUserToWorkspaceAction;
use Procesio\Application\Actions\Workspace\CreateWorkspaceAction;
use Procesio\Application\Actions\Workspace\DeleteWorkspaceAction;
use Procesio\Application\Actions\Workspace\EditWorkspaceAction;
use Procesio\Application\Actions\Workspace\ViewWorkspaceAction;
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

    $app->group('/v1', function (Group $group) {
        $group->post('/login', LoginAction::class);
        $group->post('/register', RegisterAction::class);

        $group->group('/users', function (Group $group) {
            $group->get('/{id}', ViewUserAction::class);
            $group->put('/{id}', EditUserAction::class);
        });

        $group->group('/workspace',function (Group $group) {
            $group->get('/{id}', ViewWorkspaceAction::class);
            $group->post('/', CreateWorkspaceAction::class);
            $group->post('/addUserToWorkspace', AddUserToWorkspaceAction::class);
            $group->put('/{id}', EditWorkspaceAction::class);
            $group->delete('/{id}', DeleteWorkspaceAction::class);
        });

        $group->group('/package',function (Group $group) {
            $group->get('/{id}', ViewPackageAction::class);
            $group->post('/', CreatePackageAction::class);
            $group->put('/{id}', EditPackageAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

        $group->group('/project',function (Group $group) {
            $group->get('/{id}', ViewProjectAction::class);
            $group->post('/', CreateProjectAction::class);
            $group->put('/{id}', EditProjectAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

        $group->group('/process',function (Group $group) {
            $group->get('/{id}', ViewProcessAction::class);
            $group->post('/', CreateProcessAction::class);
            $group->put('/{id}', EditProcessAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

        $group->group('/subprocess',function (Group $group) {
            $group->get('/{id}', ViewSubprocessAction::class);
            $group->post('/', CreateSubprocessAction::class);
            $group->put('/{id}', EditSubprocessAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

    });

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
