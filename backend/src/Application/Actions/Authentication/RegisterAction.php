<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Authentication;

use Procesio\Application\Authentication\Exception\AuthenticationException;
use Procesio\Domain\User\UserData;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends AuthenticationAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $body = $this->getFormData();

        $userData = new UserData($body->email, $body->password);

        $this->userFacade->registerUser($userData);

        return $this->respondWithData(statusCode: 201);
    }
}
