<?php

namespace Tests\Unit\Domain\User;

use Procesio\Application\Authentication\Exception\InvalidPasswordException;
use Procesio\Application\Authentication\PasswordManager;
use PHPUnit\Framework\TestCase;
use Procesio\Domain\User\Exceptions\UserEmailAlreadyRegisteredException;
use Procesio\Domain\User\User;
use Procesio\Domain\User\UserData;
use Procesio\Domain\User\UserRepositoryInterface;

class UserTest extends TestCase
{
    public function testConstruct(): void
    {
        $userData = new UserData('test@test.cz', '123456a', 'Test', 'Testovič');
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $passwordManager = $this->createMock(PasswordManager::class);

        $userRepository->method('findUserByEmail')->willReturn(null);

        $user = new User($userData, $userRepository, $passwordManager);
        $this->assertIsObject($user);
        $this->assertSame(User::class, get_class($user));
    }

    public function testConstructWithInvalidPassword(): void
    {
        $userData = new UserData('test@test.cz', '123456a', 'Test', 'Testovič');
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $passwordManager = $this->createMock(PasswordManager::class);

        $userRepository->method('findUserByEmail')->willReturn(null);
        $passwordManager->method('validatePassword')
            ->willThrowException(InvalidPasswordException::createForShortPassword());

        $this->expectException(InvalidPasswordException::class);
        new User($userData, $userRepository, $passwordManager);
    }

    public function testConstructWithSameUser(): void
    {
        $userData = new UserData('test@test.cz', '123456a', 'Test', 'Testovič');
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $passwordManager = $this->createMock(PasswordManager::class);

        $userRepository->method('findUserByEmail')->willReturn([$this->createMock(User::class)]);

        $this->expectException(UserEmailAlreadyRegisteredException::class);
        new User($userData, $userRepository, $passwordManager);
    }
}
