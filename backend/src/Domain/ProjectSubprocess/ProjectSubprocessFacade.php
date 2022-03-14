<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectSubprocess;

use Doctrine\ORM\EntityManager;

class ProjectSubprocessFacade
{
    public function __construct(
        private ProjectSubprocessRepositoryInterface $projectSubprocessRepository,
        private EntityManager $entityManager
    ) {
    }

    public function getProjectSubprocessByUuid(string $id): ProjectSubprocess
    {
        return $this->projectSubprocessRepository->getProjectSubprocessesByUuid($id);
    }

    /**
     * @return ProjectSubprocess[]
     */
    public function findAllWorkspaces(): array
    {
        return $this->projectSubprocessRepository->findAll();
    }


    public function deleteProjectProcesses(ProjectSubprocess $projectProcesses): void
    {

        $projectProcesses->delete($this->projectSubprocessRepository);
        $this->entityManager->flush();
    }

    public function registerWorkspace(ProjectSubprocessData $projectProcesses): ProjectSubprocess
    {
        $projectProcesses = new ProjectSubprocess($projectProcesses);

        return $this->projectSubprocessRepository->persistProjectSubprocesses($projectProcesses);
    }


    /*public function editWorkspace(ProjectProcess $workspace, ProjectProcessesData $workspaceData): ProjectProcess
    {
        $workspace->edit($workspaceData);
        $this->projectSubprocessRepository->persistWorkspace($workspace);

        return $workspace;
    }*/
}
