<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Project;

use DateTime;
use PHPUnit\Framework\TestCase;
use Procesio\Domain\Package\Package;
use Procesio\Domain\Project\Exceptions\CouldNotCreateProjectException;
use Procesio\Domain\Project\Project;
use Procesio\Domain\Project\ProjectData;
use Procesio\Domain\User\User;
use Procesio\Domain\Workspace\Workspace;


class ProjectTest extends TestCase
{
    public function testCreate(): void
    {
        $user = $this->createMock(User::class);
        $workspace = $this->createMock(Workspace::class);
        $workspace->method('getUuid')->willReturn('a');
        $user->method('getWorkspaces')->willReturn([$workspace]);

        $package = $this->createMock(Package::class);
        $package->method('getWorkspace')->willReturn($workspace);
        $date = new DateTime("2022-02-02");

        $projectData = new ProjectData("ahoj", "popis", $user, $date, $workspace, $package);
        $project = new Project($projectData);

        $this->assertIsObject($project);
        $this->assertSame(Project::class, get_class($project));
    }

    public function testCreateFailForUser(): void
    {
        $user = $this->createMock(User::class);

        $workspace = $this->createMock(Workspace::class);
        $workspace->method('getUuid')->willReturn('a');
        $user->method('getWorkspaces')->willReturn([$workspace]);

        $workspace = $this->createMock(Workspace::class);
        $workspace->method('getUuid')->willReturn('b');
        $user->method('getWorkspaces')->willReturn([$workspace]);

        $package = $this->createMock(Package::class);
        $package->method('getWorkspace')->willReturn($workspace);
        $date = new DateTime("2022-02-02");

        $projectData = new ProjectData("ahoj", "popis", $user, $date, $workspace, $package);
        $this->expectException(CouldNotCreateProjectException::class);
        new Project($projectData);
    }

    public function testCreateFailForPackage(): void
    {
        $workspace = $this->createMock(Workspace::class);
        $workspace->method('getUuid')->willReturn('a');

        $package = $this->createMock(Package::class);
        $package->method('getWorkspace')->willReturn($workspace);

        $workspace = $this->createMock(Workspace::class);
        $workspace->method('getUuid')->willReturn('b');
        $user = $this->createMock(User::class);
        $user->method('getWorkspaces')->willReturn([$workspace]);

        $date = new DateTime("2022-02-02");

        $projectData = new ProjectData("ahoj", "popis", $user, $date, $workspace, $package);
        $this->expectException(CouldNotCreateProjectException::class);
        new Project($projectData);
    }
}