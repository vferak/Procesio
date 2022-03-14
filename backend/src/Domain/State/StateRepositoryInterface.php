<?php

declare(strict_types=1);

namespace Procesio\Domain\State;

use Procesio\Domain\BaseRepositoryInterface;

interface StateRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getStateByUuid(string $uuid): State;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotDeleteDomainObjectException
     */
    public function deleteState(State $state): void;
    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistState(State $state): State;
}
