<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

use Procesio\Application\Authentication\Exception\InvalidPasswordException;
use Procesio\Application\Authentication\PasswordManager;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Workspace\Exceptions\CouldNotAddUserException;
use Procesio\Domain\Workspace\Workspace;
use Procesio\Domain\Workspace\WorkspaceData;
use Procesio\Domain\Workspace\WorkspaceRepositoryInterface;

class UserFacade
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private WorkspaceRepositoryInterface $workspaceRepository,
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
        $user = $this->userRepository->persistUser($user);

        $name = "{$user->getFirstName()} {$user->getLastName()}'s workspace";
        $description = "Default workspace with registration.";
        $workspaceData = new WorkspaceData($name, $description, $user);

        $workspace = new Workspace($workspaceData);
        $workspace->addUserToWorkspace($user);
        $this->workspaceRepository->persistWorkspace($workspace);

        return $user;
    }

    public function editUser(User $user, UserData $userData): User
    {
        $user->edit($userData, $this->passwordManager);
        $this->userRepository->persistUser($user);

        return $user;
    }
}
