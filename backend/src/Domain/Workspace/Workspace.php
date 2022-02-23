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

    /** @Column(type="string", name="name") */
    private string $name;

    public function __construct(WorkspaceData $workspace)
    {
        $this->generateAndSetUuid();

        $this->name = $workspace->getName();
        //$this->password = $workspace->getPassword();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            /*'password' => $this->getPassword()*/
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}