<?php

declare(strict_types=1);

namespace Procesio\Infrastructure\Persistence\User;

use Procesio\Domain\User\User;
use Procesio\Domain\User\UserNotFoundException;
use Procesio\Domain\User\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    /**
     * @var User[]
     */
    private $users;

    /**
     * InMemoryUserRepository constructor.
     *
     * @param array|null $users
     */
    public function __construct(array $users = null)
    {
        $this->users = $users ?? [
            1 => new User(1, 'bill.gates', 'asd', 'Bill', 'Gates'),
            2 => new User(2, 'steve.jobs', 'asd', 'Steve', 'Jobs'),
            3 => new User(3, 'mark.zuckerberg', 'asd', 'Mark', 'Zuckerberg'),
            4 => new User(4, 'evan.spiegel', 'asd', 'Evan', 'Spiegel'),
            5 => new User(5, 'jack.dorsey', 'asd', 'Jack', 'Dorsey'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        if (!isset($this->users[$id])) {
            throw new UserNotFoundException();
        }

        return $this->users[$id];
    }

    public function findUserByUsername(string $username): User
    {
        $users = array_filter($this->users, function ($user) use ($username) {
            return $user->getUsername() === $username;
        });

        if (count($users) === 0) {
            throw new UserNotFoundException();
        }

        return reset($users);
    }
}
