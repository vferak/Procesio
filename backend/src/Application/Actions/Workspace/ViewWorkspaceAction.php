<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Workspace;

use Psr\Http\Message\ResponseInterface as Response;

class ViewWorkspaceAction extends WorkspaceAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $workspaceId = $this->resolveArg('id');
        $workspace = $this->workspaceFacade->getWorkspaceByUuid($workspaceId);
        // DOSTAT ZDE users kterí jsou ve skupine a vypsat je spolecne s nazvem skupiny jak???? jak spefikuju tabulky do ktere se chci podivat
        //$users = $this->userFacade->getUsersByWorkspace($workspaceId);

        $this->logger->info("Workspace of id {$workspaceId} was viewed.");

        return $this->respondWithData($workspace);
    }
}
