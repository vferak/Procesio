<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Project;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Project\ProjectData;
use Psr\Http\Message\ResponseInterface as Response;

class EditProjectAction extends ProjectAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $project = null;
        $request = $this->request->getParsedBody();
        $projectUuid = $this->resolveArg('id');

        try {
            $project = $this->projectFacade->getProjectByUuid($projectUuid);

            $projectData = new ProjectData(
                $request['name'] ?? $project->getName(),
                $request['description'] ?? $project->getDescription(),
                $project->getCreatedBy(),
                $project->getCreatedAt(),
                $project->getWorkspace(),
                $project->getPackage(),
                $project->getState()
            );

            $this->projectFacade->editProject($project, $projectData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }

        return $this->respondWithData($project);
    }
}
