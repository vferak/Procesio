<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Workspace;

use Procesio\Domain\Exceptions\CouldNotDeleteDomainObjectException;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Workspace\Exceptions\CouldNotDeleteWorkspaceException;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteWorkspaceAction extends WorkspaceAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $workspaceId = $this->resolveArg('id');
        try {
            $workspace = $this->workspaceFacade->getWorkspaceByUuid($workspaceId);
            $this->workspaceFacade->deleteWorkspace($workspace);
        } catch (DomainObjectNotFoundException $exception) {
            return $this->respondWithData($exception->getMessage(), 404);
        } catch (CouldNotDeleteDomainObjectException | CouldNotDeleteWorkspaceException $exception) {
            return $this->respondWithData($exception->getMessage(), 400);
        }

        return $this->respondWithData();
    }
}
