<?php

namespace Procesio\Application\Actions\Process;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Process\ProcessData;
use Procesio\Domain\ProjectProcess\ProjectProcessData;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class ChangeStatusProcessAction extends ProcessAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        $process_uuid = $request['process_uuid'];
        $project_uuid = $request['project_uuid'];
        $state_uuid = $request['state_uuid'];

        try {
            $projectProcess = $this->projectProcessFacade->getProjectProcessByUuid($project_uuid,$process_uuid);

            $process = $this->processFacade->getProcessByUuid($process_uuid);
            $project = $this->projectFacade->getProjectByUuid($project_uuid);
            $state = $this->stateFacade->getStateByUuid($state_uuid);

        } catch (DomainObjectNotFoundException $exception) {
            return $this->respondWithData($exception->getMessage(), 404);
        }

        $projectProcessData = new ProjectProcessData($process,$project,$state);
        $this->projectProcessFacade->changeState($projectProcess, $projectProcessData);

        return $this->respondWithData(statusCode: 201);
    }
}
