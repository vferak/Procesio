<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Procesio\Domain\UuidDomainObjectTrait;
use Procesio\Domain\Workspace\Workspace;

/**
 * @Entity
 * @Table(name="package")
 */
class Package implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="name") */
    private string $name;

    /** @Column(type="string", name="description") */
    private string $description;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Workspace\Workspace")
     * @JoinColumn(name="workspace_uuid", referencedColumnName="uuid")
     */
    private Workspace $workspace;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Package\Package")
     * @JoinColumn(name="comes_from", referencedColumnName="uuid", nullable = true, unique=false)
     */
    private Package $comesFrom;

    public function __construct(PackageData $packageData)
    {
        $this->generateAndSetUuid();
        $this->name = $packageData->getName();
        $this->description = $packageData->getDescription();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getWorkspace(): Workspace
    {
        return $this->workspace;
    }
}
