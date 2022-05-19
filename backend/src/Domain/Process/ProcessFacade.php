<?php

declare(strict_types=1);

namespace Procesio\Domain\Process;

use Doctrine\ORM\EntityManager;
use Procesio\Domain\Subprocess\Subprocess;
use Procesio\Domain\Workspace\Workspace;
use Procesio\Infrastructure\Doctrine\Repositories\ProcessRepository;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectProcessRepository;
use Procesio\Infrastructure\Doctrine\Repositories\SubprocessRepository;

class ProcessFacade
{
    public function __construct(
        private ProcessRepository $processRepository,
        private ProjectProcessRepository $projectProcessRepository,
        private SubprocessRepository $subprocessRepository,
        private EntityManager $entityManager
    ) {
    }

    public function getProcessByUuid(string $id): Process
    {
        return $this->processRepository->getProcessByUuid($id);
    }

    public function getProcessesByComesFrom(string $id): ?array
    {
        return $this->processRepository->getProcessesByComesFrom($id);
    }

    /*public function getPackageByEmail(string $email): Package {
        return $this->packageRepository->getPackageByName($email);
    }*/

    public function createProcess(ProcessData $processData): Process
    {
        $process = new Process($processData);

        return $this->processRepository->persistProcess($process);
    }

    public function editProcess(Process $process, ProcessData $processData): Process
    {
        $process->edit($processData);
        $this->processRepository->persistProcess($process);

        return $process;
    }

    /**
     * @return ?Process[]
     */
    public function findProcesses(): array
    {
        return $this->processRepository->findAllProcesses();
    }

    /**
     * @return ?Subprocess[]
     */
    public function findSubprocesses(Process $process): array
    {
        return $this->subprocessRepository->getSubprocessesByProcess($process);
    }

    public function deleteProcess(Process $process): void
    {
        $process->delete($this->processRepository,$this->projectProcessRepository);
        $this->entityManager->flush();
    }

    /*public function createNewVersionProcess(ProcessData $processData): Process
    {
        $process = new Process($processData);

        return $this->processRepository->persistProcess($process);
    }*/
}
