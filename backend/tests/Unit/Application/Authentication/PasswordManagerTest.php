<?php

namespace Tests\Unit\Application\Authentication;

use PHPUnit\Framework\TestCase;
use Procesio\Application\Authentication\Exception\InvalidPasswordException;
use Procesio\Application\Authentication\PasswordManager;

class PasswordManagerTest extends TestCase
{
    /**
     * @dataProvider validatePasswordDataProvider
     */
    public function testValidatePassword(string $password): void
    {
        $passwordManager = new PasswordManager();
        
        $passwordManager->validatePassword($password);
        
        $this->assertTrue(true);
    }

    public function validatePasswordDataProvider(): array
    {
        return [
            ['123456a'],
            ['asd123'],
            ['asdfe1'],
            ['1sdfes']
        ];
    }

    /**
     * @dataProvider validatePasswordWithInvalidPasswordsDataProvider
     */
    public function testValidatePasswordWithInvalidPasswords(string $password): void
    {
        $passwordManager = new PasswordManager();

        $this->expectException(InvalidPasswordException::class);
        $passwordManager->validatePassword($password);
    }

    public function validatePasswordWithInvalidPasswordsDataProvider(): array
    {
        return [
            ['12a'],
            ['123456789'],
            ['asdfeasdas']
        ];
    }
}
