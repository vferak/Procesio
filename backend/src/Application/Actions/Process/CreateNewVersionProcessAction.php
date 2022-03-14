<?php

namespace Procesio\Application\Actions\Process;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\Process\ProcessData;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateNewVersionProcessAction extends ProcessAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        try {
            $oldprocess = $this->processFacade->getProcessByUuid($request['uuid']);

            $processData = new ProcessData(
                $request['name'],
                $request['description'],
                $oldprocess
            );

            $this->processFacade->createProcess($processData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }
        return $this->respondWithData(statusCode: 201);
    }
}
