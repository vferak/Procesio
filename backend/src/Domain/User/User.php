<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

use JsonSerializable;
use Procesio\Domain\UuidDomainObjectTrait;

/**
 * @Entity
 * @Table(name="users")
 */
class User implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="email", unique=true) */
    private string $email;

    /** @Column(type="string", name="password") */
    private string $password;

    /** @Column(type="string", name="firstName") */
    private string $firstName;

    /** @Column(type="string", name="lastName") */
    private string $lastName;

    /**
     * Many Users have Many Groups.
     * @ManyToMany(targetEntity="Procesio\Domain\Workspace\Workspace")
     * @JoinTable(name="user_workspace",
     *      joinColumns={@JoinColumn(name="user_uuid", referencedColumnName="uuid")},
     *      inverseJoinColumns={@JoinColumn(name="workspace_uuid", referencedColumnName="uuid")}
     *      )
     */
    private $workspaces;

    public function __construct(UserData $userData)
    {
        $this->generateAndSetUuid();

        $this->email = $userData->getEmail();
        $this->password = $userData->getPassword();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'username' => $this->getEmail(),
            'password' => $this->getPassword(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName()
        ];
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
}
