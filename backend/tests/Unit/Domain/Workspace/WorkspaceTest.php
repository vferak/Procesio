<?php

namespace Tests\Unit\Domain\Workspace;

use phpDocumentor\Reflection\Types\Void_;
use Procesio\Application\Authentication\PasswordManager;
use PHPUnit\Framework\TestCase;
use Procesio\Domain\Package\Package;
use Procesio\Domain\Project\Project;
use Procesio\Domain\User\User;
use Procesio\Domain\User\UserData;
use Procesio\Domain\User\UserRepositoryInterface;
use Procesio\Domain\Workspace\Exceptions\CouldNotAddUserException;
use Procesio\Domain\Workspace\Exceptions\CouldNotDeleteWorkspaceException;
use Procesio\Domain\Workspace\Workspace;
use Procesio\Domain\Workspace\WorkspaceData;
use Procesio\Infrastructure\Doctrine\Repositories\PackageRepository;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectRepository;
use Procesio\Infrastructure\Doctrine\Repositories\WorkspaceRepository;

class WorkspaceTest extends TestCase
{
    public function testDelete(): void
    {
        $workspaceData = new WorkspaceData("skupina_1", "testovací skupina");
        $workspace = new Workspace($workspaceData);

        $workspaceRepositoryMock = $this->createMock(WorkspaceRepository::class);
        $packageRepositoryMock = $this->createMock(PackageRepository::class);
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);

        $packageRepositoryMock->method("findWorkspaces")->willReturn(null);
        $projectRepositoryMock->method("findWorkspaces")->willReturn(null);

        $workspaceRepositoryMock->expects($this->once())->method("deleteWorkspace");

        $workspace->delete($workspaceRepositoryMock, $packageRepositoryMock, $projectRepositoryMock);
    }

    /**
     * @dataProvider deleteFailDataProvider
     * @param ?Package[] $packages
     * @param ?Project[] $projects
     */
    public function testDeleteFail(?array $packages, ?array $projects): void
    {
        $workspaceData = new WorkspaceData("skupina_1", "testovací skupina");
        $workspace = new Workspace($workspaceData);

        $workspaceRepositoryMock = $this->createMock(WorkspaceRepository::class);
        $packageRepositoryMock = $this->createMock(PackageRepository::class);
        $projectRepositoryMock = $this->createMock(ProjectRepository::class);

        $packageRepositoryMock->method("findWorkspaces")->willReturn($packages);
        $projectRepositoryMock->method("findWorkspaces")->willReturn($projects);
        $this->expectException(CouldNotDeleteWorkspaceException::class);

        $workspace->delete($workspaceRepositoryMock, $packageRepositoryMock, $projectRepositoryMock);
    }

    public function deleteFailDataProvider(): array
    {
        return [
            "withOnePackage" => [
                [$this->createMock(Package::class)],
                null
            ],
            "withOneProject" => [
                null,
                [$this->createMock(Project::class)]
            ],
            "withOneProjectOnePackage" => [
                [$this->createMock(Package::class)],
                [$this->createMock(Project::class)]
            ]
        ];
    }

    public function testAddUserToWorkspace(): void
    {
        $workspaceData = new WorkspaceData("skupina_1", "testovací skupina");
        $workspace = new Workspace($workspaceData);

        $user = $this->createMock(User::class);
        $user->method("getUuid")->willReturn("a");
        $workspace->addUser($user);

        $userData = new UserData("awdawd", "rerer", "aaaa", "llll");
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $passwordManager = $this->createMock(PasswordManager::class);

        $userRepository->method("findUserByEmail")->willReturn(null);

        $user = new User($userData, $userRepository, $passwordManager);

        $workspaceUserCount = count($workspace->getUsers());
        $userCount = count($user->getWorkspaces());

        $workspace->addUserToWorkspace($user);

        $this->assertCount($workspaceUserCount + 1, $workspace->getUsers());
        $this->assertCount($userCount + 1, $user->getWorkspaces());
    }

    public function testAddUserToWorkspaceFailWithSameUser(): void
    {
        $workspaceData = new WorkspaceData("skupina_1", "testovací skupina");
        $workspace = new Workspace($workspaceData);

        $user = $this->createMock(User::class);
        $user->method("getUuid")->willReturn("a");

        $workspace->addUser($user);
        $this->expectException(CouldNotAddUserException::class);

        $workspace->addUserToWorkspace($user);
    }

    public function testAddUserToWorkspaceFailOverMaximum(): void
    {
        $workspaceData = new WorkspaceData("skupina_1", "testovací skupina");
        $workspace = new Workspace($workspaceData);

        $user = $this->createMock(User::class);
        $user->method("getUuid")->willReturn("a");
        $user->method("getWorkspaces")->willReturn([[],[],[],[],[]]);

        $workspace->addUser($user);
        $user = $this->createMock(User::class);
        $user->method("getUuid")->willReturn("awdwad");
        $this->expectException(CouldNotAddUserException::class);

        $workspace->addUserToWorkspace($user);
    }
}
