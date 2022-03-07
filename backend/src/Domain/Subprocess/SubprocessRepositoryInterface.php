<?php

declare(strict_types=1);

namespace Procesio\Domain\Subprocess;

interface SubprocessRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getSubprocessByUuid(string $uuid): Subprocess;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    //public function getPackageByEmail(string $email): Package;

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistSubprocess(Subprocess $subprocess): Subprocess;
}
