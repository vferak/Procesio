<?php

namespace Procesio\Application\Actions\Workspace;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateWorkspaceAction extends WorkspaceAction
{

    protected function action(): Response
    {
        //prijmou data z requestu a poslat do facade nic se zde s nima nedela
        $request = $this->request->getParsedBody();

        $email = $request['name'];
        $password = $request['password'];


        //zavolat facade
    }
}