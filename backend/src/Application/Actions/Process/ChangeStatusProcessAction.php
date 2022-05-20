<?php

namespace Procesio\Application\Actions\Process;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\ProjectProcess\ProjectProcessData;
use Psr\Http\Message\ResponseInterface as Response;

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
        $state = $request['state'];

        try {
            $projectProcess = $this->projectProcessFacade->getProjectProcessByUuid($project_uuid,$process_uuid);
            $priority = $projectProcess->getPriority();
            $process = $this->processFacade->getProcessByUuid($process_uuid);
            $project = $this->projectFacade->getProjectByUuid($project_uuid);

            if (!in_array($state, array('DONE', 'in progress', 'TODO'))) {
                throw new \InvalidArgumentException("Neplatná hodnota");
            }

        } catch (DomainObjectNotFoundException $exception) {
            return $this->respondWithData($exception->getMessage(), 404);
        }

        $projectProcessData = new ProjectProcessData($process,$project,$state,$priority);
        $this->projectProcessFacade->changeState($projectProcess, $projectProcessData);

        return $this->respondWithData(statusCode: 201);
    }
}
