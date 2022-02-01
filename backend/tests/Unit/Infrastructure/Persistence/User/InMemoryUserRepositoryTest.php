<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Persistence\User;

use Procesio\Domain\User\User;
use Procesio\Domain\User\UserNotFoundException;
use Procesio\Infrastructure\Persistence\User\InMemoryUserRepository;
use Tests\TestCase;

class InMemoryUserRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        $user = new User(1, 'bill.gates', '123', 'Bill', 'Gates');

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $this->assertEquals([$user], $userRepository->findAll());
    }

    public function testFindAllUsersByDefault()
    {
        $users = [
            1 => new User(1, 'bill.gates', 'asd', 'Bill', 'Gates'),
            2 => new User(2, 'steve.jobs', 'asd', 'Steve', 'Jobs'),
            3 => new User(3, 'mark.zuckerberg', 'asd', 'Mark', 'Zuckerberg'),
            4 => new User(4, 'evan.spiegel', 'asd', 'Evan', 'Spiegel'),
            5 => new User(5, 'jack.dorsey', 'asd', 'Jack', 'Dorsey'),
        ];

        $userRepository = new InMemoryUserRepository();

        $this->assertEquals(array_values($users), $userRepository->findAll());
    }

    public function testFindUserOfId()
    {
        $user = new User(1, 'bill.gates', '123', 'Bill', 'Gates');

        $userRepository = new InMemoryUserRepository([1 => $user]);

        $this->assertEquals($user, $userRepository->findUserOfId(1));
    }

    public function testFindUserOfIdThrowsNotFoundException()
    {
        $userRepository = new InMemoryUserRepository([]);
        $this->expectException(UserNotFoundException::class);
        $userRepository->findUserOfId(1);
    }
}
