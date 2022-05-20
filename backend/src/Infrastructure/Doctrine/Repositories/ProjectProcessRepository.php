<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\ProjectProcess\ProjectProcess;
use Procesio\Domain\ProjectProcess\ProjectProcessRepositoryInterface;
use Procesio\Domain\Workspace\Workspace;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class ProjectProcessRepository extends BaseRepository implements ProjectProcessRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return ProjectProcess::class;
    }

    /**
     * @inheritDoc
     */
    public function getProjectProcessesByUuid(string $project_uuid, string $process_uuid): ProjectProcess
    {
        return $this->getByMultipleUuid(['project' => $project_uuid, 'process' => $process_uuid]);
    }

    /**
     * @inheritDoc
     */
    public function persistProjectProcess(ProjectProcess $projectProcess): ProjectProcess
    {
        $this->persist($projectProcess);
        return $projectProcess;
    }

    /**
     * @inheritDoc
     */
    public function deleteProjectProcess(ProjectProcess $projectProcess): void
    {
        $this->delete($projectProcess);
    }
}
