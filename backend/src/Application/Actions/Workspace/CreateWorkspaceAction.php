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
        $request = $this->request->getParsedBody();

        $name = $request['name'];
        $description = $request['description'];
        $user = $request['user'];


        if (empty($user)) {
            $user = null;
        } else {
            $user = $this->userFacade->getUserByUuid($user);
        }

        $workspaceData = new WorkspaceData($name, $description, $user);
        $this->workspaceFacade->createWorkspace($workspaceData);

        return $this->respondWithData(statusCode: 201);
    }
}
