<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Workspace;

use Psr\Http\Message\ResponseInterface as Response;

class ListOfUsersNotInWorkspaceAction extends WorkspaceAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $workspaceId = $this->resolveArg('id');
        $workspace = $this->workspaceFacade->getWorkspaceByUuid($workspaceId);

        $usersInWorkspace = $workspace->getUsers();
        $allUsersInSystem = $this->userFacade->findAllUsers();

        $usersNotInWorkspace = $this->workspaceFacade->getUsersNotInWorkspace($usersInWorkspace, $allUsersInSystem);

        return $this->respondWithData($usersNotInWorkspace);
    }
}
