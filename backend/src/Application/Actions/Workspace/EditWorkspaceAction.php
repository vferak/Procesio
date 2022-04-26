<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Workspace;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Package\PackageData;
use Procesio\Domain\Workspace\WorkspaceData;
use Psr\Http\Message\ResponseInterface as Response;

class EditWorkspaceAction extends WorkspaceAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $workspace = null;
        $request = $this->request->getParsedBody();
        $workspaceUuid = $this->resolveArg('id');

        try {
            $workspace = $this->workspaceFacade->getWorkspaceByUuid($workspaceUuid);

            $workspaceData = new WorkspaceData(
                $request["name"] ?? $workspace->getName(),
                $request["description"] ?? $workspace->getDescription()
            );

            $this->workspaceFacade->editWorkspace($workspace, $workspaceData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }
        return $this->respondWithData($workspace);
    }
}
