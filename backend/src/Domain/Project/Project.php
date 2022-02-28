<?php

declare(strict_types=1);

namespace Procesio\Domain\Project;

use JsonSerializable;
use Procesio\Domain\UuidDomainObjectTrait;
use Procesio\Domain\Workspace;
use Procesio\Domain\Package;


/**
 * @Entity
 * @Table(name="project")
 */
class Project implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="name") */
    private string $name;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Workspace\Workspace")
     * @JoinColumn(name="workspace_uuid", referencedColumnName="uuid")
     */
    private $workspace;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Package\Package")
     * @JoinColumn(name="package_uuid", referencedColumnName="uuid")
     */
    private $package;

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
