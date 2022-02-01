<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

class UserFacade
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    /**
     * @throws UserNotFoundException
     */
    public function findUserOfId(int $id): User {
        return $this->userRepository->findUserOfId($id);
    }

    /**
     * @throws UserNotFoundException
     */
    public function findUserByUsername(string $username): User {
        return $this->userRepository->findUserByUsername($username);
    }
}
