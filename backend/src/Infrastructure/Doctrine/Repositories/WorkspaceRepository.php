<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\User\User;
use Procesio\Domain\Workspace\Workspace;
use Procesio\Domain\Workspace\WorkspaceRepositoryInterface;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class WorkspaceRepository extends BaseRepository implements WorkspaceRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return Workspace::class;
    }

    /**
     * @inheritDoc
     */
    public function getWorkspaceByUuid(string $uuid): Workspace
    {
        return $this->getByUuid($uuid);
    }

    /**
     * @inheritDoc
     */
    public function persistWorkspace(Workspace $workspace): Workspace
    {
        $this->persist($workspace);
        return $workspace;
    }

    /**
     * @inheritDoc
     */
    public function deleteWorkspace(Workspace $workspace): void
    {
        $this->delete($workspace);
    }


}
