<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectSubprocess;

use Doctrine\ORM\EntityManager;
use Procesio\Domain\ProjectProcess\ProjectProcess;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectSubprocessRepository;

class ProjectSubprocessFacade
{
    public function __construct(
        private ProjectSubprocessRepository $projectSubprocessRepository,
        private EntityManager $entityManager
    ) {
    }

    public function getProjectSubpprocessByUuid(string $project_uuid, string $process_uuid): ProjectSubprocess
    {
        return $this->projectSubprocessRepository->getProjectSubprocessesByUuid($project_uuid, $process_uuid);
    }

    public function changeState(ProjectSubprocess $projectSubprocess, ProjectSubprocessData $projectSubprocessData): ProjectSubprocess
    {
        $projectSubprocess->changeState($projectSubprocessData);
        $this->projectSubprocessRepository->persistProjectSubprocesses($projectSubprocess);
        return $projectSubprocess;
    }

    public function deleteProjectSubprocess(ProjectSubprocess $projectSubprocess): void
    {
        $projectSubprocess->delete($this->projectSubprocessRepository);
        $this->entityManager->flush();
    }
}
