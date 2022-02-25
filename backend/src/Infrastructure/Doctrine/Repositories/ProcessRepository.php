<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\Process\Process;
use Procesio\Domain\Process\ProcessRepositoryInterface;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class ProcessRepository extends BaseRepository implements ProcessRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return Process::class;
    }

    /**
     * @inheritDoc
     */
    public function getProcessByUuid(string $uuid): Process
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
    public function persistProcess(Process $process): Process
    {
        $this->persist($process);
        return $process;
    }
}
