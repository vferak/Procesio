<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

interface UserRepository
{
    /**
     * @return User[]
     */
    public function findAll(): array;

    /**
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User;

    /**
     * @throws UserNotFoundException
     */
    public function findUserByUsername(string $username): User;
}
