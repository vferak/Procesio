<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

interface ProjectRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getProjectByUuid(string $uuid): Project;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    //public function getProjectByName(string $email): Project;

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistProject(Project $user): Project;
}
