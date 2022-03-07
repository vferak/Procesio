<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\Project\Project;
use Procesio\Domain\Project\ProjectRepositoryInterface;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return Project::class;
    }

    /**
     * @inheritDoc
     */
    public function getProjectByUuid(string $uuid): Project
    {
        return $this->getByUuid($uuid);
    }

    /**
     * @inheritDoc
     */
    /*public function getProjectByName(string $uuid): Project
    {
        return $this->getBzgetByN($uuid);
    }*/

    /**
     * @inheritDoc
     */
    public function persistProject(Project $project): Project
    {
        $this->persist($project);
        return $project;
    }
}
