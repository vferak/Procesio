<?php

declare(strict_types=1);

namespace Procesio\Domain\Process;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Procesio\Domain\Package\Package;
use Procesio\Domain\Project\Project;
use Procesio\Domain\ProjectProcess\ProjectProcessData;
use Procesio\Domain\State\State;
use Procesio\Domain\Subprocess\Subprocess;
use Procesio\Domain\User\User;
use Procesio\Domain\UuidDomainObjectTrait;
use Procesio\Domain\Workspace\Workspace;

/**
 * @Entity
 * @Table(name="process")
 */
class Process implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="name") */
    private string $name;

    /** @Column(type="string", name="description") */
    private string $description;

    /**
     * Many Processes have Many Packages.
     * @var ArrayCollection|Package[]
     * @ManyToMany(targetEntity="Procesio\Domain\Package\Package")
     * @JoinTable(name="process_package",
     *      joinColumns={@JoinColumn(name="process_uuid", referencedColumnName="uuid")},
     *      inverseJoinColumns={@JoinColumn(name="package_uuid", referencedColumnName="uuid")}
     *      )
     */
    private mixed $packages;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Process\Process")
     * @JoinColumn(name="comes_from", referencedColumnName="uuid", nullable = true, unique=false)
     */
    private ?Process $comesFrom;

    /**
     * @var ArrayCollection|Subprocess[]
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="Procesio\Domain\Subprocess\Subprocess", mappedBy="process")
     */
    private mixed $subprocesses;

    /*
    /**
     * @var ArrayCollection|Workspace[]
     * @ManyToMany(targetEntity="Procesio\Domain\Workspace\Workspace", mappedBy="processes")
     */
    //private mixed $workspaces;


    public function __construct(ProcessData $processData)
    {
        $this->generateAndSetUuid();
        $this->comesFrom = $processData->getComesFrom();
        $this->packages = new ArrayCollection();
        $this->subprocesses = new ArrayCollection();

        $this->edit($processData);
    }

    public function edit(ProcessData $processData): void
    {
        $this->name = $processData->getName();
        $this->description = $processData->getDescription();
    }

    /*public function createNewVersionProcess(ProcessData $processData): void
    {
        $this->generateAndSetUuid();
        $this->name = $processData->getName();
        $this->description = $processData->getDescription();
        $this->comesFrom = $processData->getComesFrom();
    }*/

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'packages' => $this->getPackages(),
            'comesFrom' => $this->getComesFrom(),
            'subprocesses' => $this->getSubprocesses()
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return ?Process
     */

    public function getComesFrom(): ?Process
    {
        return $this->comesFrom;
    }

    /**
     * @return Package[]
     */
    public function getPackages(): array
    {
        return $this->packages->toArray();
    }

    public function addPackage(Package $package): self
    {
        $this->packages->add($package);
        return $this;
    }

    /**
     * @return Subprocess[]
     */
    public function getSubprocesses(): array
    {
        return $this->subprocesses->toArray();
    }

}
