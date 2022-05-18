<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace;

use Doctrine\ORM\EntityManager;
use Procesio\Domain\Package\Package;
use Procesio\Domain\Package\PackageData;
use Procesio\Domain\Package\PackageRepositoryInterface;
use Procesio\Domain\Project\Project;
use Procesio\Domain\Project\ProjectRepositoryInterface;
use Procesio\Domain\User\User;

class WorkspaceFacade
{
    public function __construct(
        private WorkspaceRepositoryInterface $workspaceRepository,
        private PackageRepositoryInterface $packageRepository,
        private ProjectRepositoryInterface $projectRepository,
        private EntityManager $entityManager
    ) {
    }

    public function getWorkspaceByUuid(string $id): Workspace
    {
        return $this->workspaceRepository->getWorkspaceByUuid($id);
    }

    public function getDefaultUserWorkspaceByUuid(string $userUuid): array
    {
        return $this->workspaceRepository->getDefaultUserWorkspaceByUuid($userUuid);
    }

    public function findAllUsers(Workspace $workspace): array
    {
        return $workspace->getUsers();
    }
    public function deleteWorkspace(Workspace $workspace): void
    {
        $workspace->delete($this->workspaceRepository, $this->packageRepository, $this->projectRepository);
        $this->entityManager->flush();
    }

    public function createWorkspace(WorkspaceData $workspaceData, User $user): Workspace
    {
        $workspace = new Workspace($workspaceData);
        $workspace->addUserToWorkspace($user);
        return $this->workspaceRepository->persistWorkspace($workspace);
    }

    public function addUserToWorkspace(Workspace $workspace, User $user): Workspace
    {
        $workspace = $workspace->addUserToWorkspace($user);
        return $this->workspaceRepository->persistWorkspace($workspace);
    }

    public function editWorkspace(Workspace $workspace, WorkspaceData $workspaceData): Workspace
    {
        $workspace->edit($workspaceData);
        $this->workspaceRepository->persistWorkspace($workspace);

        return $workspace;
    }
}
