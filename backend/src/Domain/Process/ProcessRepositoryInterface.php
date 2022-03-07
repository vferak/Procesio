<?php

declare(strict_types=1);

namespace Procesio\Domain\Process;

interface ProcessRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getProcessByUuid(string $uuid): Process;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    //public function getPackageByEmail(string $email): Package;

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistProcess(Process $process): Process;
}
