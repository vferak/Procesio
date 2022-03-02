<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Workspace;

use Procesio\Application\Authentication\Exception\AuthenticationException;
use Procesio\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;

class AddUserWorkspace extends WorkspaceAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $request = $this->request->getParsedBody();
        $uuid = $request['uuid'];

        try {
            $user = $this->userFacade->getUserByUuid($uuid);
            try{
                //ziskat seznam useru co jsou ve skupine a porovnat zda se v něm nachází hledany USER
                //$users = $this->userFacade->getUsersByWorkspace($workspace);
            } catch (AuthenticationException)
            {
                $response = $this->respondWithData('User already exists in workspace.', 403);
            }
        } catch (AuthenticationException) {
            $response = $this->respondWithData('User does not exists.', 403);
        }

        return $response;
    }
}
