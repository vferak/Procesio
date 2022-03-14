<?php

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Domain\Subprocess\SubprocessData;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateSubprocessAction extends SubprocessAction
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
        $subprocessData = new SubprocessData($name);

        $this->subprocessFacade->createProcess($subprocessData);

        return $this->respondWithData(statusCode: 201);


        //zavolat facade
    }
}
