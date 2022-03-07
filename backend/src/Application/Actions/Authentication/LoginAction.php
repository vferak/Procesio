<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Authentication;

use Procesio\Application\Authentication\Exception\AuthenticationException;
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
            $token = $this->authenticator->authenticateUser($email, $password);
            $response = $this->respondWithData(['token' => $token]);
        } catch (AuthenticationException) {
            $response = $this->respondWithData('Failure', 403);
        }

        return $response;
    }
}
