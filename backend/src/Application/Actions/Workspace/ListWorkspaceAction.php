<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Workspace;

use Psr\Http\Message\ResponseInterface as Response;

class ListWorkspaceAction extends WorkspaceAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userUuid = $this->getCurrentUserUuid();
        $user = $this->userFacade->getUserByUuid($userUuid);
        $workspaces = $user->getWorkspaces();

        return $this->respondWithData($workspaces);
    }
}
