<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ViewUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $userId = $this->resolveArg('id');
        $user = $this->userFacade->getUserByUuid($userId);

        $this->logger->info("User of id `${userId}` was viewed.");

        return $this->respondWithData($user);
    }
}
