<?php

namespace Procesio\Application\Actions\Process;

use Procesio\Domain\Process\ProcessData;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateProcessAction extends ProcessAction
{
    /**
     * {@inheritdoc}
     */

    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        $name = $request['name'];
        $description = $request['description'];
        $comesFrom = $request['comesFrom'] ?? null;

        $processData = new ProcessData($name,$description,$comesFrom);
        $this->processFacade->createProcess($processData);

        return $this->respondWithData(statusCode: 201);
    }
}
