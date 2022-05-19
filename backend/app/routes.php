<?php
declare(strict_types=1);

use Procesio\Application\Actions\Authentication\LoginAction;
use Procesio\Application\Actions\Authentication\RegisterAction;
use Procesio\Application\Actions\Package\AddProcessToPackageAction;
use Procesio\Application\Actions\Package\CreateNewVersionPackageAction;
use Procesio\Application\Actions\Package\CreatePackageAction;
use Procesio\Application\Actions\Package\EditPackageAction;
use Procesio\Application\Actions\Package\ListPackagesAction;
use Procesio\Application\Actions\Package\ViewPackageAction;
use Procesio\Application\Actions\Process\ChangeStatusProcessAction;
use Procesio\Application\Actions\Process\CreateNewVersionProcessAction;
use Procesio\Application\Actions\Process\CreateProcessAction;
use Procesio\Application\Actions\Process\EditProcessAction;
use Procesio\Application\Actions\Process\ListProcessesAction;
use Procesio\Application\Actions\Process\ViewHistoryProcessAction;
use Procesio\Application\Actions\Process\ViewParentProcessAction;
use Procesio\Application\Actions\Process\ViewProcessAction;
use Procesio\Application\Actions\Project\CreateProjectAction;
use Procesio\Application\Actions\Project\EditProjectAction;
use Procesio\Application\Actions\Project\ListProjectsAction;
use Procesio\Application\Actions\Project\ViewProjectAction;
use Procesio\Application\Actions\Subprocess\ChangeStatusSubprocessAction;
use Procesio\Application\Actions\Subprocess\CreateSubprocessAction;
use Procesio\Application\Actions\Subprocess\EditSubprocessAction;
use Procesio\Application\Actions\Subprocess\ViewHistorySubprocessAction;
use Procesio\Application\Actions\Subprocess\ViewParentSubprocessAction;
use Procesio\Application\Actions\Subprocess\ViewSubprocessAction;
use Procesio\Application\Actions\User\EditUserAction;
use Procesio\Application\Actions\User\GetUserStatistics;
use Procesio\Application\Actions\User\ViewUserAction;
use Procesio\Application\Actions\Workspace\AddUserToWorkspaceAction;
use Procesio\Application\Actions\Workspace\CreateWorkspaceAction;
use Procesio\Application\Actions\Workspace\DeleteWorkspaceAction;
use Procesio\Application\Actions\Workspace\EditWorkspaceAction;
use Procesio\Application\Actions\Workspace\ListWorkspaceAction;
use Procesio\Application\Actions\Workspace\ViewDefaultUserWorkspaceAction;
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

        $group->group('/user', function (Group $group) {
            $group->get('', ViewUserAction::class);
            $group->get('/statistics', GetUserStatistics::class);
            $group->post('', EditUserAction::class);
        });

        $group->group('/workspace',function (Group $group) {
            $group->get('/{id}', ViewWorkspaceAction::class);
            $group->get('/defaulUsertWorkspace/{id}', ViewDefaultUserWorkspaceAction::class);
            $group->post('', CreateWorkspaceAction::class);
            $group->post('/addUserToWorkspace', AddUserToWorkspaceAction::class);
            $group->post('/{id}', EditWorkspaceAction::class);
            $group->delete('/{id}', DeleteWorkspaceAction::class);
            $group->get('/all/{id}', ListWorkspaceAction::class);
        });

        $group->group('/package',function (Group $group) {
            $group->get('/all/{id}', ListPackagesAction::class);
            $group->get('/{id}', ViewPackageAction::class);
            $group->post('', CreatePackageAction::class);
            $group->post('/newversion', CreateNewVersionPackageAction::class);
            $group->post('/addProcessToPackage', AddProcessToPackageAction::class);
            $group->post('/{id}', EditPackageAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

        $group->group('/project',function (Group $group) {
            $group->get('/{id}', ViewProjectAction::class);
            $group->get('/all/{id}', ListProjectsAction::class);
            $group->post('', CreateProjectAction::class);
            $group->post('/{id}', EditProjectAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

        $group->group('/process',function (Group $group) {
            $group->get('/all', ListProcessesAction::class);
            $group->get('/{id}', ViewProcessAction::class);
            $group->post('', CreateProcessAction::class);
            $group->post('/newversion', CreateNewVersionProcessAction::class);
            $group->post('/{id}', EditProcessAction::class);
            $group->get('/displayhistory/{id}', ViewHistoryProcessAction::class);
            $group->get('/displayparent/{id}', ViewParentProcessAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

        $group->group('/subprocess',function (Group $group) {
            $group->get('/{id}', ViewSubprocessAction::class);
            $group->post('', CreateSubprocessAction::class);
            $group->post('/{id}', EditSubprocessAction::class);
            $group->get('/displayhistory/{id}', ViewHistorySubprocessAction::class);
            $group->get('/displayparent/{id}', ViewParentSubprocessAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

        $group->group('/projectProcess',function (Group $group) {
            //$group->get('/{id}', ViewSubprocessAction::class);
           // $group->post('', CreateSubprocessAction::class);
            $group->post('/changeStatus', ChangeStatusProcessAction::class);
            //$group->get('/displayhistory/{id}', ViewHistorySubprocessAction::class);
            //$group->get('/displayparent/{id}', ViewParentSubprocessAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

        $group->group('/projectSubprocess',function (Group $group) {
            //$group->get('/{id}', ViewSubprocessAction::class);
            // $group->post('', CreateSubprocessAction::class);
            $group->post('/changeStatus', ChangeStatusSubprocessAction::class);
            //$group->get('/displayhistory/{id}', ViewHistorySubprocessAction::class);
            //$group->get('/displayparent/{id}', ViewParentSubprocessAction::class);
            //$group->delete('/{id}', RegisterAction::class);
        });

    });

    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
