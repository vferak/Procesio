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
        $body = $this->getFormData();

        $username = $body->username;
        $password = $body->password;

        try {
            $token = $this->authenticator->authenticateUser($username, $password);
            $response = $this->respondWithData(['token' => $token]);
        } catch (AuthenticationException) {
            $response = $this->respondWithData('Failure', 403);
        }

        return $response;
    }
}
