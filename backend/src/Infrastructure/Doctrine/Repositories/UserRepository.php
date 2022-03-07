<?php

namespace Procesio\Infrastructure\Doctrine\Repositories;

use Procesio\Domain\User\User;
use Procesio\Domain\User\UserRepositoryInterface;
use Procesio\Infrastructure\Doctrine\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @inheritDoc
     */
    protected function getDomainClass(): string
    {
        return User::class;
    }

    /**
     * @inheritDoc
     */
    public function getUserByUuid(string $uuid): User
    {
        return $this->getByUuid($uuid);
    }

    /**
     * @inheritDoc
     */
    public function getUserByEmail(string $email): User
    {
        return $this->getBy(['email' => $email])[0];
    }

    /**
     * @inheritDoc
     */
    public function persistUser(User $user): User
    {
        $this->persist($user);
        return $user;
    }
}
