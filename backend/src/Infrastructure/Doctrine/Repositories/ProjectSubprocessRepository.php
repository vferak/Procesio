<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\ProjectSubprocess\ProjectSubprocess;
use Procesio\Domain\ProjectSubprocess\ProjectSubprocessRepositoryInterface;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class ProjectSubprocessRepository extends BaseRepository implements ProjectSubprocessRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return ProjectSubprocess::class;
    }

    /**
     * @inheritDoc
     */
    public function getProjectSubprocessesByUuid(string $project_uuid, string $subprocess_uuid): ProjectSubprocess
    {
        return $this->getByMultipleUuid(['project' => $project_uuid, 'subprocess' => $subprocess_uuid]);
    }

    /**
     * @inheritDoc
     */
    public function persistProjectSubprocesses(ProjectSubprocess $projectSubprocess): ProjectSubprocess
    {
        $this->persist($projectSubprocess);
        return $projectSubprocess;
    }
}
