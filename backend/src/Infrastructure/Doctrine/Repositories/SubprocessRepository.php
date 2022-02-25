<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\Subprocess\Subprocess;
use Procesio\Domain\Subprocess\SubprocessRepositoryInterface;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class SubprocessRepository extends BaseRepository implements SubprocessRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return Subprocess::class;
    }

    /**
     * @inheritDoc
     */
    public function getSubprocessByUuid(string $uuid): Subprocess
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
    public function persistSubprocess(Subprocess $subprocess): Subprocess
    {
        $this->persist($subprocess);
        return $subprocess;
    }
}
