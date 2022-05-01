<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\State\State;
use Procesio\Domain\State\StateRepositoryInterface;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class StateRepository extends BaseRepository implements StateRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return State::class;
    }

    /**
     * @inheritDoc
     */
    public function getStateByUuid(string $uuid): State
    {
        return $this->getByUuid($uuid);
    }

    /**
     * @inheritDoc
     */
    public function persistState(State $state): State
    {
        $this->persist($state);
        return $state;
    }

    /**
     * @inheritDoc
     */
    public function deleteState(State $state): void
    {
        $this->delete($state);
    }
}
