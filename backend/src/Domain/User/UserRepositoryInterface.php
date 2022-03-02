<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

interface UserRepositoryInterface
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
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     *  @return User[]
     */
    //IDK
    public function getUsersByWorkspace(string $workspace): array;

    /**
     * @throws \Procesio\Domain\Exceptions\CouldNotPersistDomainObjectException
     */
    public function persistUser(User $user): User;
}
