<?php

namespace Tests\Unit\Application\Authentication;

use Procesio\Application\Authentication\Authenticator;
use PHPUnit\Framework\TestCase;
use Procesio\Application\Authentication\Exception\AuthenticationException;
use Procesio\Application\Settings\Settings;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\User\User;
use Procesio\Domain\User\UserData;
use Procesio\Domain\User\UserFacade;

class AuthenticatorTest extends TestCase
{
    private function createSettings(): Settings
    {
        return new Settings([
            'jwt_secret' => 'superSecretPassphrase**8896',
            'jwt_algorithm' => 'HS256'
        ]);
    }

    private function createAuthenticator(UserFacade $userFacade = null): Authenticator
    {
        if ($userFacade === null) {
            $userFacade = $this->createMock(UserFacade::class);
        }

        return new Authenticator($this->createSettings(), $userFacade);
    }

    public function testAuthenticateUser(): void
    {
        $username = 'vferak@gmail.com';
        $password = '123456';

        $user = new User(new UserData($username, $password, 'asd', 'asd'));

        $userFacade = $this->createMock(UserFacade::class);
        $userFacade->method('getUserByEmail')->willReturn($user);

        $authenticator = $this->createAuthenticator($userFacade);

        $token = $authenticator->authenticateUser($username, $password);

        $this->assertIsString($token);
    }

    public function testAuthenticateUserUserNotFound(): void
    {
        $userFacade = $this->createMock(UserFacade::class);
        $userFacade->method('getUserByEmail')
            ->willThrowException(DomainObjectNotFoundException::createFromDomainObjectClass(User::class));

        $authenticator = $this->createAuthenticator($userFacade);

        $this->expectException(AuthenticationException::class);
        $token = $authenticator->authenticateUser('vferak@gmail.com', '123456');

        $this->assertIsString($token);
    }

    public function testAuthenticateUserPasswordDoesNotMatch(): void
    {
        $username = 'vferak@gmail.com';
        $password = '123456';

        $userData = new UserData($username, $password, 'asd', 'asd');
        $user = new User($userData);

        $userFacade = $this->createMock(UserFacade::class);
        $userFacade->method('getUserByEmail')->willReturn($user);

        $authenticator = $this->createAuthenticator($userFacade);

        $this->expectException(AuthenticationException::class);
        $token = $authenticator->authenticateUser($username, '123');

        $this->assertIsString($token);
    }
}
