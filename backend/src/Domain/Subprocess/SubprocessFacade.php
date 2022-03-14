<?php

declare(strict_types=1);

namespace Procesio\Domain\Subprocess;

use Procesio\Infrastructure\Doctrine\Repositories\SubprocessRepository;

class SubprocessFacade
{
    public function __construct(
        private SubprocessRepository $subprocessRepository
    ) {
    }

    public function getSubprocessByUuid(string $id): Subprocess {
        return $this->subprocessRepository->getSubprocessByUuid($id);
    }

    public function getSubprocessesByComesFrom(string $id): ?array {
        return $this->subprocessRepository->getSubprocessesByComesFrom($id);
    }

    /*public function getPackageByEmail(string $email): Package {
        return $this->packageRepository->getPackageByName($email);
    }*/

    public function createProcess(SubprocessData $subprocessData): Subprocess {
        $subprocess = new Subprocess($subprocessData);

        return $this->subprocessRepository->persistSubprocess($subprocess);
    }

    public function editSubprocess(Subprocess $subprocess, SubprocessData $subprocessData): Subprocess
    {
        $subprocess->edit($subprocessData);
        $this->subprocessRepository->persistSubprocess($subprocess);

        return $subprocess;
    }
}
