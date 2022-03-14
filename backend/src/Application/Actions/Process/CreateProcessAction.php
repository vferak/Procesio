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
        //prijmou data z requestu a poslat do facade nic se zde s nima nedela
        $request = $this->request->getParsedBody();

        $name = $request['name'];
        //$password = $request['password'];
        //TODO dodelat prametry
        $processData = new ProcessData($name);

        $this->processFacade->createProcess($processData);

        return $this->respondWithData(statusCode: 201);


        //zavolat facade
    }
}