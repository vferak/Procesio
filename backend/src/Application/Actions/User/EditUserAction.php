<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\User;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\User\UserData;
use Psr\Http\Message\ResponseInterface as Response;

class EditUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $user = null;
        $request = $this->request->getParsedBody();
        $userUuid = $this->resolveArg('id');

        try {
            $user = $this->userFacade->getUserByUuid($userUuid);

            $userData = new UserData(
                $request['email'] ?? $user->getEmail(),
                $request['password'] ?? $user->getPassword(),
                $request['firstName'] ?? $user->getFirstName(),
                $request['lastName'] ?? $user->getLastName(),
            );

            $this->userFacade->editUser($user, $userData);
        } catch (DomainObjectNotFoundException $exception) {
            $this->respondWithData($exception->getMessage(), 404);
        }
        return $this->respondWithData($user);
    }
}
