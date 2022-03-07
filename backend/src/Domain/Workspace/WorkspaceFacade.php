<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace;


use Doctrine\ORM\EntityManager;
use Procesio\Domain\Package\PackageRepositoryInterface;
use Procesio\Domain\Project\ProjectRepositoryInterface;
use Procesio\Domain\User\User;

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

    public function addUserToWorkspace(Workspace $workspace, User $user): Workspace
    {
        $workspace = $workspace->addUserToWorkspace($user);
        return $this->workspaceRepository->persistWorkspace($workspace);
//        $this->entityManager->flush();
    }

}