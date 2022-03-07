<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Workspace;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Workspace\Exceptions\CouldNotAddUserException;
use Psr\Http\Message\ResponseInterface as Response;

class AddUserToWorkspaceAction extends WorkspaceAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $request = $this->request->getParsedBody();
        $user_uuid = $request['user_uuid'];
        $workspace_uuid = $request['workspace_uuid'];

        try {
            $user = $this->userFacade->getUserByUuid($user_uuid);
            $workspace = $this->workspaceFacade->getWorkspaceByUuid($workspace_uuid);
            $workspace = $this->workspaceFacade->addUserToWorkspace($workspace, $user);
        } catch (DomainObjectNotFoundException|CouldNotAddUserException $exception) {
            return $this->respondWithData($exception->getMessage(), 400);
        }

        return $this->respondWithData($workspace);
    }
}
