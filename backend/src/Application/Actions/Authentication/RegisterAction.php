<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Authentication;

use Procesio\Domain\User\UserData;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends AuthenticationAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->request->getParsedBody();

        $userData = new UserData(
            $body['email'],
            $body['password'],
            $body['firstName'],
            $body['lastName']
        );

        $this->userFacade->registerUser($userData);

        return $this->respondWithData(statusCode: 201);
    }
}
