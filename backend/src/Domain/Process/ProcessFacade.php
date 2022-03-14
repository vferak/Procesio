<?php

declare(strict_types=1);

namespace Procesio\Domain\Process;

use Procesio\Infrastructure\Doctrine\Repositories\ProcessRepository;

class ProcessFacade
{
    public function __construct(
        private ProcessRepository $processRepository
    ) {
    }

    public function getProcessByUuid(string $id): Process {
        return $this->processRepository->getProcessByUuid($id);
    }

    public function getProcessesByComesFrom(string $id): ?array {
        return $this->processRepository->getProcessesByComesFrom($id);
    }

    /*public function getPackageByEmail(string $email): Package {
        return $this->packageRepository->getPackageByName($email);
    }*/

    public function createProcess(ProcessData $processData): Process {
        $process = new Process($processData);

        return $this->processRepository->persistProcess($process);
    }

    public function editProcess(Process $process, ProcessData $processData): Process
    {
        $process->edit($processData);
        $this->processRepository->persistProcess($process);

        return $process;
    }

    /*public function createNewVersionProcess(ProcessData $processData): Process
    {
        $process = new Process($processData);

        return $this->processRepository->persistProcess($process);
    }*/
}
