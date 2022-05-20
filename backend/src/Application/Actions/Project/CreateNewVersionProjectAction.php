<?php

namespace Procesio\Application\Actions\Project;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Project\Exceptions\CouldNotCreateProjectException;
use Psr\Http\Message\ResponseInterface as Response;

class CreateNewVersionProjectAction extends ProjectAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        $project_uuid = $request['project_uuid'];
        $package_uuid = $request['package_uuid'];

        try {
            $project = $this->projectFacade->getProjectByUuid($project_uuid);
            $newpackage = $this->packageFacade->getPackageByUuid($package_uuid);

            $this->projectFacade->applyNewPackageToProject($project,$newpackage);

        } catch (DomainObjectNotFoundException $exception) {
            return $this->respondWithData($exception->getMessage(), 404);
        } catch (CouldNotCreateProjectException $exception) {
            return $this->respondWithData($exception->getMessage(), 400);
        }

        return $this->respondWithData(statusCode: 201);
    }
}
