<?php

declare(strict_types=1);

namespace Procesio\Domain\ProcessPackage;

use Procesio\Infrastructure\Doctrine\Repositories\ProcessPackageRepository;

class ProcessPackageFacade
{
    public function __construct(
        private ProcessPackageRepository $processPackageRepository
    ) {
    }

    public function getProcessPackageByUuid(string $process_uuid, string $package_uuid): ProcessPackage
    {
        return $this->processPackageRepository->getProcessPackageByUuid($process_uuid, $package_uuid);
    }

    public function addProcessToPackage(ProcessPackageData $processPackageData): ProcessPackage
    {
        $package = new ProcessPackage($processPackageData);
        return $this->processPackageRepository->persistProcessPackage($package);
    }

}
