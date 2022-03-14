<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectSubprocess;

use Procesio\Domain\BaseRepositoryInterface;

interface ProjectSubprocessRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getProjectSubprocessesByUuid(string $uuid): ProjectSubprocess;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotDeleteDomainObjectException
     */
    public function deleteProjectProcesses(ProjectSubprocess $projectSubprocess): void;
    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistProjectSubprocesses(ProjectSubprocess $projectSubprocess): ProjectSubprocess;
}
