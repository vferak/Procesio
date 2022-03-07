<?php

namespace Procesio\Domain\Workspace;

use Doctrine\Common\Collections\ArrayCollection;
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

    /** @Column(type="string", name="description") */
    private string $description;


    public function __construct(WorkspaceData $workspace)
    {
        $this->generateAndSetUuid();
        $this->name = $workspace->getName();
        $this->description = $workspace->getDescription();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'description' => $this->getDescription()
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

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
