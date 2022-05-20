<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

use Procesio\Application\States\State;
use Procesio\Domain\Package\Package;
use Procesio\Domain\ProjectProcess\ProjectProcess;
use Procesio\Domain\ProjectProcess\ProjectProcessData;
use Procesio\Domain\ProjectSubprocess\ProjectSubprocess;
use Procesio\Domain\ProjectSubprocess\ProjectSubprocessData;
use Procesio\Domain\User\User;
use Procesio\Domain\Workspace\Workspace;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectProcessRepository;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectRepository;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectSubprocessRepository;

class ProjectFacade
{
    public function __construct(
        private ProjectRepository $projectRepository,
        private ProjectProcessRepository $projectProcessRepository,
        private ProjectSubprocessRepository $projectSubprocessRepository
    ) {
    }

    public function getProjectByUuid(string $id): Project
    {
        return $this->projectRepository->getProjectByUuid($id);
    }

    public function createProject(ProjectData $projectData): Project
    {
        $project = new Project($projectData);
        $this->projectRepository->persistProject($project);

        $processes = $project->getPackage()->getProcesses();

        foreach ($processes as $process)
        {
            $projectProcessData = new ProjectProcessData($process, $project, State::STATUS_NEW,1);
            $projectProcess = new ProjectProcess($projectProcessData);
            $this->projectProcessRepository->persistProjectProcess($projectProcess);

            $subprocesses = $process->getSubprocesses();
            foreach ($subprocesses as $subprocess)
            {
                $projectSubprocessData = new ProjectSubprocessData($subprocess, $project, State::STATUS_NEW,1);
                $projectSubprocess = new ProjectSubprocess($projectSubprocessData);
                $this->projectSubprocessRepository->persistProjectSubprocesses($projectSubprocess);
            }
        }

        return $project;
    }

    public function editProject(Project $project, ProjectData $projectData): Project
    {
        $project->edit($projectData);
        $this->projectRepository->persistProject($project);
        return $project;
    }

    /**
     * @return ?Project[]
     */
    public function findProjects(Workspace $workspace): array
    {
        return $this->projectRepository->findAllProjectsByWorkspaces($workspace);
    }

    public function applyNewPackageToProject(Project $project, Package $newpackage): Project
    {
        $processesInOldPackage = $project->getPackage()->getProcesses();
        $processesInNewPackage = $newpackage->getProcesses();

        $project = $project->applyNewPackageToProject($processesInOldPackage,$processesInNewPackage);

        return $project;
    }

    /**
     * @return ?Project[]
     */
    public function findProjectsByUser(User $user): ?array
    {
        return $this->projectRepository->findAllProjectsByUser($user);
    }
}
