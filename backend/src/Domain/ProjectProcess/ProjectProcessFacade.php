<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectProcess;

use Doctrine\ORM\EntityManager;

class ProjectProcessFacade
{
    public function __construct(
        private ProjectProcessRepositoryInterface $projectProcessRepository,
        private EntityManager $entityManager
    ) {
    }

    public function getProjectProcessFacadeByUuid(string $id): ProjectProcess
    {
        return $this->projectProcessRepository->getProjectProcessesByUuid($id);
    }

    /**
     * @return ProjectProcess[]
     */
    public function findAllWorkspaces(): array
    {
        return $this->projectProcessRepository->findAll();
    }


    public function deleteProjectProcesses(ProjectProcess $projectProcesses): void
    {

        $projectProcesses->delete($this->projectProcessRepository);
        $this->entityManager->flush();
    }

    public function registerWorkspace(ProjectProcessData $projectProcesses): ProjectProcess
    {
        $projectProcesses = new ProjectProcess($projectProcesses);

        return $this->projectProcessRepository->persistProjectProcesses($projectProcesses);
    }


    /*public function editWorkspace(ProjectProcess $workspace, ProjectProcessesData $workspaceData): ProjectProcess
    {
        $workspace->edit($workspaceData);
        $this->projectRepository->persistWorkspace($workspace);

        return $workspace;
    }*/
}
