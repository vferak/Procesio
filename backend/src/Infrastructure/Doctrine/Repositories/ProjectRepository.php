<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\Project\Project;
use Procesio\Domain\Project\ProjectRepositoryInterface;
use Procesio\Domain\User\User;
use Procesio\Domain\Workspace\Workspace;
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
    public function persistProject(Project $project): Project
    {
        $this->persist($project);
        return $project;
    }

    /**
     * @return ?Project[]
     */
    public function findAllProjectsByWorkspaces(Workspace $workspace): ?array
    {
        return $this->findBy(['workspace' => $workspace]);
    }

    /**
     * @return ?Project[]
     */
    public function findAllProjectsByUser(User $user): ?array
    {
        return $this->findBy(['createdBy' => $user]);
    }
}
