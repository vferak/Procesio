<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace;

interface WorkspaceRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    //public function getUserByUuid(string $uuid): Workspace;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    //public function getUserByEmail(string $email): Workspace;

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistWorkspace(Workspace $workspace): Workspace;
}
