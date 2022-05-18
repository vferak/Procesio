<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace;

use Procesio\Domain\BaseRepositoryInterface;
use Procesio\Domain\User\User;

interface WorkspaceRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getWorkspaceByUuid(string $uuid): Workspace;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getDefaultUserWorkspaceByUuid(string $uuid): array;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotDeleteDomainObjectException
     */
    public function deleteWorkspace(Workspace $workspace): void;
    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistWorkspace(Workspace $workspace): Workspace;
}
