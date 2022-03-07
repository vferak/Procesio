<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

use Procesio\Application\Authentication\PasswordManager;

class UserFacade
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private PasswordManager $passwordManager
    ) {
    }

    public function getUserByUuid(string $id): User
    {
        return $this->userRepository->getUserByUuid($id);
    }

    public function getUserByEmail(string $email): User
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function findAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @return User[]
     */
    public function getUsersByWorkspace(User $user): array
    {
        return $user->getWorkspaces();
    }

    public function registerUser(UserData $userData): User
    {
        $user = new User($userData, $this->userRepository, $this->passwordManager);

        return $this->userRepository->persistUser($user);
    }
}
