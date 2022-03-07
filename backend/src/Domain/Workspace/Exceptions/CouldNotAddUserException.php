<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace\Exceptions;

use Procesio\Domain\Exceptions\DomainException;
use Procesio\Domain\User\User;

class CouldNotAddUserException extends DomainException
{
    private function __construct(string $message = "")
    {
        parent::__construct($message);
    }


    public static function createForDuplicateUser(User $user): self
    {
        return new self(
          sprintf(
              'User %s could not be added to workspace!',$user->getUuid()
          )
        );
    }

    public static function createForUserWithTooManyWorkspaces(User $user): self
    {
        return new self(
            sprintf(
                'User %s has more than 5 workspaces!',$user->getUuid()
            )
        );
    }
}
