<?php

declare(strict_types=1);

namespace Procesio\Domain\State;

use Doctrine\ORM\EntityManager;
use Procesio\Domain\Package\Package;
use Procesio\Domain\Package\PackageData;
use Procesio\Domain\Package\PackageRepositoryInterface;
use Procesio\Domain\Project\ProjectRepositoryInterface;
use Procesio\Domain\User\User;

class StateFacade
{
    public function __construct(
        private StateRepositoryInterface $stateRepository,
        private EntityManager $entityManager
    ) {
    }

    public function getStateByUuid(string $id): State
    {
        return $this->stateRepository->getStateByUuid($id);
    }

}
