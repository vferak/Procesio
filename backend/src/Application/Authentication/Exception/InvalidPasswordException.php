<?php

declare(strict_types=1);

namespace Procesio\Application\Authentication\Exception;

use Procesio\Application\Authentication\PasswordManager;
use RuntimeException;

class InvalidPasswordException extends RuntimeException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function createForShortPassword(): self
    {
        return new self(
            sprintf(
                'Password is too short! Required length is %s number or letters combined.',
                PasswordManager::MIN_PASSWORD_LENGTH
            )
        );
    }

    public static function createForOnlyNumbersPassword(): self
    {
        return new self('Password has to contain at least one letter!');
    }

    public static function createForOnlyLettersPassword(): self
    {
        return new self('Password has to contain at least one number!');
    }
}
