<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

use JsonSerializable;

/**
 * @Entity
 * @Table(name="users")
 */
class User implements JsonSerializable
{
    /** @Id @Column(type="integer", name="id") @GeneratedValue */
    private int $id;

    /** @Column(type="string", name="username") */
    private string $username;

    /** @Column(type="string", name="password") */
    private string $password;

    /** @Column(type="string", name="firstName") */
    private string $firstName;

    /** @Column(type="string", name="lastName") */
    private string $lastName;

    public function __construct(int $id, string $username, string $password, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->username = strtolower($username);
        $this->password = $password;
        $this->firstName = ucfirst($firstName);
        $this->lastName = ucfirst($lastName);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
