<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace;

use Procesio\Infrastructure\Doctrine\Repositories\WorkspaceRepository;

class WorkspaceFacade
{
    public function __construct(
        private WorkspaceRepository $workspaceRepository
    ) {
    }

    public function getWorkspaceByUuid(string $id): Workspace {
        return $this->workspaceRepository->getWorkspaceByUuid($id);
    }

    public function registerWorkspace(WorkspaceData $workspace): Workspace {
        $workspace = new Workspace($workspace);

        return $this->workspaceRepository->persistWorkspace($workspace);
    }

}