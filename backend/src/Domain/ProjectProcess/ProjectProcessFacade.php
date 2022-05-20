<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectProcess;

use Doctrine\ORM\EntityManager;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectProcessRepository;


class ProjectProcessFacade
{
    public function __construct(
        private ProjectProcessRepository $projectProcessRepository,
        private EntityManager $entityManager
    ) {
    }

    public function getProjectProcessByUuid(string $project_uuid, string $process_uuid): ProjectProcess
    {
        return $this->projectProcessRepository->getProjectProcessesByUuid($project_uuid, $process_uuid);
    }


    public function changeState(ProjectProcess $projectProcess, ProjectProcessData $projectProcessData): ProjectProcess
    {
        $projectProcess->changeState($projectProcessData);

        $this->projectProcessRepository->persistProjectProcess($projectProcess);
        return $projectProcess;

    }

    public function persistProjectProcess(ProjectProcessData $projectProcessData): ProjectProcess
    {
        $projectProcess = new ProjectProcess($projectProcessData);

        return $this->projectProcessRepository->persistProjectProcess($projectProcess);
    }

    public function deleteProjectProcess(ProjectProcess $projectProcess): void
    {
        $projectProcess->delete($this->projectProcessRepository);
        $this->entityManager->flush();
    }

}
