<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

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

        $this->edit($packageData);
    }

    public function edit(PackageData $packageData): void
    {
        //TODO: popřemýšlet jestli se tady bude updatovat i comes_from nebo az v jiné metodě
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
