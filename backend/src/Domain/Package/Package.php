<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Procesio\Domain\Package\Exceptions\CouldNotAddProcessException;
use Procesio\Domain\Process\Process;
use Procesio\Domain\ProcessPackage\ProcessPackage;
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
    private ?Workspace $workspace;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Package\Package")
     * @JoinColumn(name="comes_from", referencedColumnName="uuid", nullable = true, unique=false)
     */
    private ?Package $comesFrom;

    /**
     * @var ArrayCollection|ProcessPackage[]
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="Procesio\Domain\ProcessPackage\ProcessPackage", mappedBy="package")
     */
    private mixed $processPackages;


    public function __construct(PackageData $packageData)
    {
        $this->generateAndSetUuid();
        $this->name = $packageData->getName();
        $this->description = $packageData->getDescription();
        $this->workspace = $packageData->getWorkspace();
        $this->comesFrom = $packageData->getComesFrom();

        $this->processPackages = new ArrayCollection();

        $this->edit($packageData);
    }

    public function edit(PackageData $packageData): void
    {
        //TODO: popřemýšlet jestli se tady bude updatovat i comes_from nebo az v jiné metodě
        $this->name = $packageData->getName();
        $this->description = $packageData->getDescription();
        $this->workspace = $packageData->getWorkspace();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'workspace' => $this->getWorkspace(),
            'comesFrom' => $this->getComesFrom(),
            'processes' => $this->getProcesses()
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

    public function getWorkspace(): ?Workspace
    {
        return $this->workspace;
    }

    public function getComesFrom(): ?Package
    {
        return $this->comesFrom;
    }

    public function addProcessPackage(ProcessPackage $processPackage): self
    {
        $this->processPackages->add($processPackage);
        return $this;
    }

    /**
     * @return Process[]
     */
    public function getProcesses(): array
    {
        $processes = [];
        foreach ($this->processPackages as $processPackage)
        {
            $processes[] = $processPackage->getProcess();
        }

        return $processes;
    }

    /**
     * @return ProcessPackage[]
     */
    public function getProcessPackages(): array
    {
        return $this->processPackages->toArray();
    }
}
