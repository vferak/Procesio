<?php

declare(strict_types=1);

namespace Procesio\Domain\ProcessPackage;


interface ProcessPackageRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getProcessPackageByUuid(string $project_uuid, string $process_uuid): ProcessPackage;

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistProcessPackage(ProcessPackage $processPackage): ProcessPackage;
}
