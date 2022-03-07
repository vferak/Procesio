<?php

declare(strict_types=1);

namespace Procesio\Application\Authentication;

use Procesio\Application\Authentication\Exception\InvalidPasswordException;
use Procesio\Domain\User\User;

class PasswordManager
{
    public const MIN_PASSWORD_LENGTH = 6;
    private const BCRYPT_COST = 12;

    public function validatePassword(string $password): void
    {
        if (strlen($password) < self::MIN_PASSWORD_LENGTH) {
            throw InvalidPasswordException::createForShortPassword();
        }

        if (!preg_match('/[A-Za-z]/', $password)) {
            throw InvalidPasswordException::createForOnlyNumbersPassword();
        }

        if (!preg_match('/\d/', $password)) {
            throw InvalidPasswordException::createForOnlyLettersPassword();
        }
    }

    public function hashPassword(string $password): string
    {
        $options = [
            'cost' => self::BCRYPT_COST
        ];

        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function isPasswordValidForUser(string $password, User $user): bool
    {
        return password_verify($password, $user->getPassword());
    }
}
