<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

class UserFacade
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function getUserByUuid(string $id): User {
        return $this->userRepository->getUserByUuid($id);
    }

    public function getUserByEmail(string $email): User {
        return $this->userRepository->getUserByEmail($email);
    }

    /**
     * @return User[]
     */
    public function getUsersByWorkspace(string $workspace): array
    {
        return $this->userRepository->getUsersByWorkspace($workspace);
    }

    public function registerUser(UserData $userData): User {
        $user = new User($userData);

        return $this->userRepository->persistUser($user);
    }
}
