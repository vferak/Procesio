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

            //TODO takhle dostanu nový workspace který mi byl poslan z formulaře a ten ulozim?..to same pak pro package
            // createdBy..
            if(empty($request['workspace']))
            {
                $workspace = $request['workspace'] ?? $project->getWorkspace();
            } else{
                $workspace = $this->workspaceFacade->getWorkspaceByUuid($request['workspace']);
            }


            $projectData = new ProjectData(
                $request['name'] ?? $project->getName(),
                $request['description'] ?? $project->getDescription(),
                $request['createdBy'] ?? $project->getCreatedBy(),
                $request['createdAt'] ?? $project->getCreatedAt(),
                $workspace,
                $request['package'] ?? $project->getPackage(),
            );



            $this->projectFacade->editProject($project, $projectData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }

        return $this->respondWithData($project);
    }
}
