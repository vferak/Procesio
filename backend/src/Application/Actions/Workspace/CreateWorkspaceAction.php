<?php

namespace Procesio\Application\Actions\Workspace;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Workspace\WorkspaceData;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateWorkspaceAction extends WorkspaceAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        //prijmou data z requestu a poslat do facade nic se zde s nima nedela
        $request = $this->request->getParsedBody();

        $name = $request['name'];
        //$password = $request['password'];
        $workspaceData = new WorkspaceData($name);

        $this->workspaceFacade->registerWorkspace($workspaceData);

        return $this->respondWithData(statusCode: 201);


        //zavolat facade
    }
}