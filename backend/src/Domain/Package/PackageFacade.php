<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

use Procesio\Domain\Process\Process;
use Procesio\Infrastructure\Doctrine\Repositories\PackageRepository;

class PackageFacade
{
    public function __construct(
        private PackageRepository $packageRepository
    ) {
    }

    public function getPackageByUuid(string $id): Package
    {
        return $this->packageRepository->getPackageByUuid($id);
    }

    public function addProcessToPackage(Package $package, Process $process): Package
    {
        $package = $package->addProcessToPackage($process);
        return $this->packageRepository->persistPackage($package);
    }

    public function createPackage(PackageData $packageData): Package
    {
        $package = new Package($packageData);

        return $this->packageRepository->persistPackage($package);
    }

    public function editPackage(Package $package, PackageData $packageData): Package
    {
        $package->edit($packageData);
        $this->packageRepository->persistPackage($package);

        return $package;
    }
}
