<?php

namespace Procesio\Application\Actions\Project;


use DateTime;
use Exception;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Project\ProjectData;
use Psr\Http\Message\ResponseInterface as Response;

class CreateProjectAction extends ProjectAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        $name = $request['name'];
        $description = $request['description'];
        $createdBy = $request['createdBy'];
        $workspace_uuid = $request['workspace_uuid'];
        $package_uuid = $request['package_uuid'];
        $createdAt = $request['createdAt'];

        try {
            $createdAt = new DateTime($createdAt);
        }catch (Exception $exception){
            return $this->respondWithData($exception->getMessage(), 400);
        }

        try {
            $user = $this->userFacade->getUserByUuid($createdBy);
            $package = $this->packageFacade->getPackageByUuid($package_uuid);
            $workspace = $this->workspaceFacade->getWorkspaceByUuid($workspace_uuid);
        } catch (DomainObjectNotFoundException $exception){
            return $this->respondWithData($exception->getMessage(), 404);
        }

        $projectData = new ProjectData($name, $description, $user, $createdAt, $workspace, $package);

        $this->projectFacade->createProject($projectData);

        return $this->respondWithData(statusCode: 201);

    }
}