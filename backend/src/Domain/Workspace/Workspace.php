<?php

namespace Procesio\Domain\Workspace;

use JsonSerializable;
use Procesio\Domain\UuidDomainObjectTrait;

/**
 * @Entity
 * @Table(name="workspace")
 */
class Workspace implements JsonSerializable
{
    use UuidDomainObjectTrait;
    //private string name;

    /** @Column(type="string", name="email", unique=true) */
    private string $email;

    /** @Column(type="string", name="password") */
    private string $password;

    /** @Column(type="string", name="firstName") */
    private string $firstName;

    /** @Column(type="string", name="lastName") */
    private string $lastName;

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
            'password' => $this->getPassword()
        ];
    }
}