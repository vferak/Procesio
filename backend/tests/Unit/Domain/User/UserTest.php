<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\User;

use Procesio\Domain\User\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function userProvider()
    {
        return [
            [1, 'bill.gates', '123', 'Bill', 'Gates'],
            [2, 'steve.jobs', '123', 'Steve', 'Jobs'],
            [3, 'mark.zuckerberg', '123', 'Mark', 'Zuckerberg'],
            [4, 'evan.spiegel', '123', 'Evan', 'Spiegel'],
            [5, 'jack.dorsey', '123', 'Jack', 'Dorsey'],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     */
    public function testGetters(int $id, string $username, string $password, string $firstName, string $lastName)
    {
        $user = new User($id, $username, $password, $firstName, $lastName);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
    }

    /**
     * @dataProvider userProvider
     * @param int    $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     */
    public function testJsonSerialize(int $id, string $username, string $password, string $firstName, string $lastName)
    {
        $user = new User($id, $username, $password, $firstName, $lastName);

        $expectedPayload = json_encode([
            'id' => $id,
            'username' => $username,
            'password' => $password,
            'firstName' => $firstName,
            'lastName' => $lastName,
        ], JSON_THROW_ON_ERROR);

        $this->assertEquals($expectedPayload, json_encode($user, JSON_THROW_ON_ERROR));
    }
}
