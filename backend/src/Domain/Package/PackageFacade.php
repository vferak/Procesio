<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

use Procesio\Infrastructure\Doctrine\Repositories\PackageRepository;

class PackageFacade
{
    public function __construct(
        private PackageRepository $packageRepository
    ) {
    }

    public function getPackageByUuid(string $id): Package {
        return $this->packageRepository->getPackageByUuid($id);
    }

    /*public function getPackageByEmail(string $email): Package {
        return $this->packageRepository->getPackageByName($email);
    }*/

    public function createWorkspace(PackageData $packageData): Package {
        $package = new Package($packageData);

        return $this->packageRepository->persistPackage($package);
    }
}
