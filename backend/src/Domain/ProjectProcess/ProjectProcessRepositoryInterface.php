<?php

declare(strict_types=1);

namespace Procesio\Domain\ProjectProcess;

use Procesio\Domain\BaseRepositoryInterface;

interface ProjectProcessRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getProjectProcessesByUuid(string $project_uuid, string $process_uuid): ProjectProcess;

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistProjectProcess(ProjectProcess $projectProcesses): ProjectProcess;
}
