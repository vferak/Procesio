<?php

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Process\ProcessData;
use Procesio\Domain\ProjectProcess\ProjectProcessData;
use Procesio\Domain\ProjectSubprocess\ProjectSubprocessData;
use Procesio\Domain\Subprocess\Subprocess;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ChangeStatusSubprocessAction extends SubprocessAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        $subprocess_uuid = $request['subprocess_uuid'];
        $project_uuid = $request['project_uuid'];
        $state_uuid = $request['state_uuid'];

        try {
            $projectProcess = $this->projectSubprocessFacade->getProjectProcessByUuid($project_uuid,$subprocess_uuid);

            $subprocess = $this->subprocessFacade->getSubprocessByUuid($subprocess_uuid);
            $project = $this->projectFacade->getProjectByUuid($project_uuid);
            $state = $this->stateFacade->getStateByUuid($state_uuid);

        } catch (DomainObjectNotFoundException $exception) {
            return $this->respondWithData($exception->getMessage(), 404);
        }

        $projectProcessData = new ProjectSubprocessData($subprocess,$project,$state);
        $this->projectSubprocessFacade->changeState($projectProcess, $projectProcessData);

        return $this->respondWithData(statusCode: 201);
    }
}
