<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class GetUserStatistics extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = $this->request->getAttribute("userUuid");
        $user = $this->userFacade->getUserByUuid($userId);



        $projectsCreated = $this->projectFacade->findProjectsByUser($user) === null ? 0 : count($this->projectFacade->findProjectsByUser($user));
        $workspaces = $user->getWorkspaces() === null ? 0 : count($user->getWorkspaces());
        $registered = $user->getRegisteredAt()->format("d. m. Y");

        return $this->respondWithData(['projects' => $projectsCreated, 'workspaces' => $workspaces, 'registered' => $registered]);
    }
}
