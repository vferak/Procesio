<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Authentication;

use Procesio\Application\Authentication\Exception\InvalidPasswordException;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\User\UserData;
use Procesio\Domain\Workspace\Exceptions\CouldNotAddUserException;
use Procesio\Domain\Workspace\WorkspaceData;
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

        try {
            $this->userFacade->registerUser($userData);
        } catch (DomainObjectNotFoundException | CouldNotAddUserException | InvalidPasswordException $exception) {
            return $this->respondWithData($exception->getMessage(), 400);
        }

        return $this->respondWithData(statusCode: 201);
    }
}
