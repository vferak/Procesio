<?php

namespace Tests\Unit\Application\Authentication;

use Procesio\Application\Authentication\Authenticator;
use PHPUnit\Framework\TestCase;
use Procesio\Application\Authentication\Exception\AuthenticationException;
use Procesio\Application\Authentication\PasswordManager;
use Procesio\Application\Settings\Settings;
use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Procesio\Domain\User\User;
use Procesio\Domain\User\UserData;
use Procesio\Domain\User\UserFacade;
use Procesio\Infrastructure\Doctrine\Repositories\UserRepository;

class AuthenticatorTest extends TestCase
{
    private function createSettings(): Settings
    {
        return new Settings([
            'jwt_secret' => 'superSecretPassphrase**8896',
            'jwt_algorithm' => 'HS256'
        ]);
    }

    private function createDummyUser(string $username, string $password): User
    {
        return new User(
            new UserData($username, $password, 'asd', 'asd'),
            $this->createMock(UserRepository::class),
            new PasswordManager()
        );
    }

    public function testAuthenticateUser(): void
    {
        $username = 'vferak@gmail.com';
        $password = '123456a';

        $user = $this->createDummyUser($username, $password);

        $userFacade = $this->createMock(UserFacade::class);
        $userFacade->method('getUserByEmail')->willReturn($user);
        $userFacade->expects($this->once())->method('getUserByEmail');

        $passwordManager = $this->createMock(PasswordManager::class);
        $passwordManager->method('isPasswordValidForUser')->willReturn(true);
        $passwordManager->expects($this->once())->method('isPasswordValidForUser');

        $authenticator = new Authenticator($this->createSettings(), $userFacade, $passwordManager);

        $token = $authenticator->authenticateUser($username, $password);

        $this->assertIsString($token);
    }

    public function testAuthenticateUserUserNotFound(): void
    {
        $userFacade = $this->createMock(UserFacade::class);
        $userFacade->method('getUserByEmail')
            ->willThrowException(DomainObjectNotFoundException::createFromDomainObjectClass(User::class));
        $userFacade->expects($this->once())->method('getUserByEmail');

        $passwordManager = $this->createMock(PasswordManager::class);
        $passwordManager->expects($this->never())->method('isPasswordValidForUser');

        $authenticator = new Authenticator($this->createSettings(), $userFacade, $passwordManager);

        $this->expectException(AuthenticationException::class);
        $token = $authenticator->authenticateUser('vferak@gmail.com', '123456');

        $this->assertIsString($token);
    }

    public function testAuthenticateUserPasswordDoesNotMatch(): void
    {
        $username = 'vferak@gmail.com';
        $password = '123456a';

        $user = $this->createDummyUser($username, $password);

        $userFacade = $this->createMock(UserFacade::class);
        $userFacade->method('getUserByEmail')->willReturn($user);

        $passwordManager = $this->createMock(PasswordManager::class);
        $passwordManager->expects($this->once())->method('isPasswordValidForUser');

        $authenticator = new Authenticator($this->createSettings(), $userFacade, $passwordManager);

        $this->expectException(AuthenticationException::class);
        $token = $authenticator->authenticateUser($username, '123');

        $this->assertIsString($token);
    }
}
