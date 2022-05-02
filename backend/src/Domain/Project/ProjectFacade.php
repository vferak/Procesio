<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

use Procesio\Domain\Package\Package;
use Procesio\Domain\ProjectProcess\ProjectProcess;
use Procesio\Domain\ProjectProcess\ProjectProcessData;
use Procesio\Domain\ProjectSubprocess\ProjectSubprocess;
use Procesio\Domain\ProjectSubprocess\ProjectSubprocessData;
use Procesio\Domain\Workspace\Workspace;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectProcessRepository;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectRepository;
use Procesio\Infrastructure\Doctrine\Repositories\ProjectSubprocessRepository;
use Procesio\Infrastructure\Doctrine\Repositories\StateRepository;
use function DI\add;

class ProjectFacade
{
    public function __construct(
        private ProjectRepository $projectRepository,
        private StateRepository $stateRepository,
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
        $state = $this->stateRepository->getStateByUuid("571753bf-5909-44ef-9a20-a4d5e55096de");

        foreach ($processes as $process)
        {
            $projectProcessData = new ProjectProcessData($process, $project, $state);
            $projectProcess = new ProjectProcess($projectProcessData);
            $this->projectProcessRepository->persistProjectProcess($projectProcess);

            $subprocesses = $process->getSubprocesses();
            foreach ($subprocesses as $subprocess)
            {
                $projectSubprocessData = new ProjectSubprocessData($subprocess, $project, $state);
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

        $arrayOfProcesses = [];
        $arrayOfProcessesUuid = [];
        $arrayOfSubprocesses = [];

        foreach ($processesInOldPackage as $oldProcess)
        {
            $arrayOfProcessesUuid[] = $oldProcess->getUuid();
        }

        //foreach ($processesInOldPackage as $oldProcess)
        {
            foreach ($processesInNewPackage as $newProcess)
            {
                if(in_array($newProcess->getUuid(),$arrayOfProcessesUuid))
                {
                    $arrayOfProcesses[] = $oldProcess;
                    $oldSubprocesses = $oldProcess->getSubprocesses();
                    $newSubprocesses = $newProcess->getSubprocesses();
                    foreach ($oldSubprocesses as $oldSubprocess)
                    {
                        foreach ($newSubprocesses as $newSubprocess)
                        {
                            if($newSubprocess->getUuid() === $oldSubprocess->getUuid())
                            {
                                $arrayOfSubprocesses[] = $oldSubprocess;
                            }
                        }
                    }
                } else {
                    //TODO
                    $arrayOfProcesses[] = $newProcess;
                }

            }
            //DELETE ALL project processes and subprocesses
            // ADD ALL processes and subprocess to project

        }

        return $project;
    }
}
