<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

use Procesio\Infrastructure\Doctrine\Repositories\ProjectRepository;

class ProjectFacade
{
    public function __construct(
        //ProjectRepositoryInteface by měl být ale nefunguje mi to s ním...jenom v USER to jde
        private ProjectRepository $projectRepository
    ) {
    }

    public function getProjectByUuid(string $id): Project {
        return $this->projectRepository->getProjectByUuid($id);
    }

    /*public function getProjectByName(string $name): Project {
        return $this->projectRepository->getProjectByName($name);
    }*/

    public function createProject(ProjectData $projectData): Project {
        $project = new Project($projectData);

        return $this->projectRepository->persistProject($project);
    }

    public function editProject(Project $project, ProjectData $projectData): Project
    {
        $project->edit($projectData);
        $this->projectRepository->persistProject($project);
        return $project;
    }
}
