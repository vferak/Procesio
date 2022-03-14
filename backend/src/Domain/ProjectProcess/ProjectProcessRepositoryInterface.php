<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectProcess;

use Procesio\Domain\BaseRepositoryInterface;

interface ProjectProcessRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getProjectProcessesByUuid(string $uuid): ProjectProcess;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotDeleteDomainObjectException
     */
    public function deleteProjectProcesses(ProjectProcess $projectProcesses): void;
    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistProjectProcesses(ProjectProcess $projectProcesses): ProjectProcess;
}
