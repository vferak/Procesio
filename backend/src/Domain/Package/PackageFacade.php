<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

use Procesio\Domain\Package\Package;
use Procesio\Domain\Package\PackageData;

class PackageFacade
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function getPackageByUuid(string $id): Package {
        return $this->userRepository->getUserByUuid($id);
    }

    /*public function getUserByEmail(string $email): Package {
        return $this->userRepository->getUserByEmail($email);
    }*/

    public function createPackage(PackageData $packageData): Package {
        $user = new Package($packageData);

        return $this->userRepository->persistPackage($user);
    }
}
