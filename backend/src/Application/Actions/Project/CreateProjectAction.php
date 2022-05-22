<?php

namespace Procesio\Application\Actions\Project;

use DateTime;
use Exception;
use Procesio\Application\States\State;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Project\Exceptions\CouldNotCreateProjectException;
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
        $createdBy = $this->getCurrentUserUuid();
        $workspace_uuid = $request['workspace_uuid'];
        $package_uuid = $request['package_uuid'];
        $createdAt = date("Y-m-d H:i:s");

        try {
            $createdAt = new DateTime($createdAt);
        } catch (Exception $exception) {
            return $this->respondWithData($exception->getMessage(), 400);
        }

        try {
            $user = $this->userFacade->getUserByUuid($createdBy);
            $package = $this->packageFacade->getPackageByUuid($package_uuid);
            $workspace = $this->workspaceFacade->getWorkspaceByUuid($workspace_uuid);

            $projectData = new ProjectData($name, $description, $user, $createdAt, $workspace, $package, State::STATUS_TODO);
            $this->projectFacade->createProject($projectData);

        } catch (DomainObjectNotFoundException $exception) {
            return $this->respondWithData($exception->getMessage(), 404);
        } catch (CouldNotCreateProjectException $exception) {
            return $this->respondWithData($exception->getMessage(), 400);
        }

        return $this->respondWithData(statusCode: 201);
    }
}
