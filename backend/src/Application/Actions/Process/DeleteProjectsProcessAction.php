<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Process;

use Procesio\Domain\Exceptions\CouldNotDeleteDomainObjectException;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class DeleteProjectsProcessAction extends ProcessAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        $process_uuid = $request['process_uuid'];
        $project_uuid = $request['project_uuid'];

        try {
            $projectProcess = $this->projectProcessFacade->getProjectProcessByUuid($project_uuid,$process_uuid);
            $this->projectProcessFacade->deleteProjectProcess($projectProcess);
        } catch (DomainObjectNotFoundException $exception) {
            return $this->respondWithData($exception->getMessage(), 404);
        } catch (CouldNotDeleteDomainObjectException $exception) {
            return $this->respondWithData($exception->getMessage(), 400);
        }

        return $this->respondWithData();
    }
}
