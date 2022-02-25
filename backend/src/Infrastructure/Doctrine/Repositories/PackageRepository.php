<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\Package\Package;
use Procesio\Domain\Package\PackageRepositoryInterface;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class PackageRepository extends BaseRepository implements PackageRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return Package::class;
    }

    /**
     * @inheritDoc
     */
    public function getPackageByUuid(string $uuid): Package
    {
        return $this->getByUuid($uuid);
    }

    /**
     * @inheritDoc
     */
    /*public function getPackageByUuid(string $uuid): Package
    {
        return $this->getByUuid($uuid);
    }*/

    /**
     * @inheritDoc
     */
    public function persistPackage(Package $package): Package
    {
        $this->persist($package);
        return $package;
    }
}
