<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

use JsonSerializable;
use Procesio\Domain\UuidDomainObjectTrait;

/**
 * @Entity
 * @Table(name="project")
 */
class Project implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="name") */
    private string $name;

    public function __construct(ProjectData $projectData)
    {
        $this->generateAndSetUuid();

        $this->name = $projectData->getName();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName()
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }
}
