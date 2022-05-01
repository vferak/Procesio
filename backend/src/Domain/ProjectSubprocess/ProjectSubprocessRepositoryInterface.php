<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectSubprocess;

use Procesio\Domain\BaseRepositoryInterface;


interface ProjectSubprocessRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getProjectSubprocessesByUuid(string $project_uuid, string $process_uuid): ProjectSubprocess;
//TODO VYJIMKY

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistProjectSubprocesses(ProjectSubprocess $projectProcesses): ProjectSubprocess;
}
