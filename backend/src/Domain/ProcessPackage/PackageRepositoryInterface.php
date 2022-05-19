<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

interface PackageRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getPackageByUuid(string $uuid): Package;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    //public function getPackageByEmail(string $email): Package;

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistPackage(Package $package): Package;
}
