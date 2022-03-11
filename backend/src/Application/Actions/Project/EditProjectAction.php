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
        try {
            $project = $this->projectFacade->getProjectByUuid($request['uuid']);

            if(empty($request['workspace']))
            {
                $workspace = $request['workspace'] ?? $project->getWorkspace();
            } else{
                $workspace = $this->workspaceFacade->getWorkspaceByUuid($request['workspace']);
            }

            if(empty($request['package']))
            {
                $package = $request['package'] ?? $project->getWorkspace();
            } else{
                $package = $this->packageFacade->getPackageByUuid($request['package']);
            }

            $projectData = new ProjectData(
                $request['name'] ?? $project->getName(),
                $request['description'] ?? $project->getDescription(),
                $request['createdBy'] ?? $project->getCreatedBy(),
                $request['createdAt'] ?? $project->getCreatedAt(),
                $workspace,
                $package
            );

            $this->projectFacade->editProject($project, $projectData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }

        return $this->respondWithData($project);
    }
}
