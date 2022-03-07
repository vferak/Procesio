<?php

declare(strict_types=1);

namespace Procesio\Domain\User\Exceptions;

use RuntimeException;

class UserEmailAlreadyRegisteredException extends UserException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function createFromEmail(string $email): self
    {
        return new self(sprintf(
            'User with e-mail %s is already registered!',
            $email
        ));
    }
}
