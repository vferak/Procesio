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
        $userRepository->method('findUserByEmail')->willReturn(null);
        $userRepository->expects($this->once())->method('findUserByEmail');

        $passwordManager = $this->createMock(PasswordManager::class);
        $passwordManager->expects($this->once())->method('validatePassword');

        $user = new User($userData, $userRepository, $passwordManager);
        $this->assertIsObject($user);
        $this->assertSame(User::class, get_class($user));
    }

    public function testConstructWithInvalidPassword(): void
    {
        $userData = new UserData('test@test.cz', '123456a', 'Test', 'Testovič');
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->expects($this->never())->method('findUserByEmail');

        $passwordManager = $this->createMock(PasswordManager::class);
        $passwordManager->method('validatePassword')
            ->willThrowException(InvalidPasswordException::createForShortPassword());
        $passwordManager->expects($this->once())->method('validatePassword');

        $this->expectException(InvalidPasswordException::class);
        new User($userData, $userRepository, $passwordManager);
    }

    public function testConstructWithSameUser(): void
    {
        $userData = new UserData('test@test.cz', '123456a', 'Test', 'Testovič');
        $userRepository = $this->createMock(UserRepositoryInterface::class);
        $userRepository->method('findUserByEmail')->willReturn([$this->createMock(User::class)]);
        $userRepository->expects($this->once())->method('findUserByEmail');

        $passwordManager = $this->createMock(PasswordManager::class);
        $passwordManager->expects($this->once())->method('validatePassword');

        $this->expectException(UserEmailAlreadyRegisteredException::class);
        new User($userData, $userRepository, $passwordManager);
    }
}
