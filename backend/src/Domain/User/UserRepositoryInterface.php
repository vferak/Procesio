<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

use Procesio\Domain\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getUserByUuid(string $uuid): User;

    /**
     * @throws \Procesio\Domain\Exceptions\DomainObjectNotFoundException
     */
    public function getUserByEmail(string $email): User;

    /**
     * @return ?User[]
     */
    public function findUserByEmail(string $email): ?array;

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistUser(User $user): User;
}
