<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Authentication;

use Procesio\Application\Authentication\Exception\AuthenticationException;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends AuthenticationAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $request = $this->request->getParsedBody();

        $email = $request['email'];
        $password = $request['password'];

        try {
            $user = $this->userFacade->getUserByEmail($email);
            $workspace = $user->getDefaultWorkspace();
            $token = $this->authenticator->authenticateUser($user, $password);
            $response = $this->respondWithData(['token' => $token, 'workspace_uuid' => $workspace->getUuid()]);
        } catch (AuthenticationException | DomainObjectNotFoundException $exception) {
            $response = $this->respondWithData($exception->getMessage(), 403);
        }


        return $response;
    }
}
