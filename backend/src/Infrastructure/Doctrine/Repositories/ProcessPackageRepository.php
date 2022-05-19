<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\ProcessPackage\ProcessPackage;

use Procesio\Domain\ProcessPackage\ProcessPackageRepositoryInterface;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class ProcessPackageRepository extends BaseRepository implements ProcessPackageRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return ProcessPackage::class;
    }

    /**
     * @inheritDoc
     */
    public function getProcessPackageByUuid(string $project_uuid, string $process_uuid): ProcessPackage
    {
        return $this->getByMultipleUuid(['project' => $project_uuid, 'process' => $process_uuid]);
    }

    /**
     * @inheritDoc
     */
    public function persistProcessPackage(ProcessPackage $processPackage): ProcessPackage
    {
        $this->persist($processPackage);
        return $processPackage;
    }

    /**
     * @inheritDoc
     */
    public function deleteProcessPackage(ProcessPackage $processPackage): void
    {
        $this->delete($processPackage);
    }
}
