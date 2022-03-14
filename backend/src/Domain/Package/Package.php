<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Procesio\Domain\Package\Exceptions\CouldNotAddProcessException;
use Procesio\Domain\Process\Process;
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
     * @var ?ArrayCollection|?Process[]
     * @ManyToMany(targetEntity="Procesio\Domain\Process\Process", mappedBy="packages")
     */
    private mixed $processes;

    public function __construct(PackageData $packageData)
    {
        $this->generateAndSetUuid();
        $this->name = $packageData->getName();
        $this->description = $packageData->getDescription();
        $this->workspace = $packageData->getWorkspace();
        $this->comesFrom = $packageData->getComesFrom();

        $this->processes = new ArrayCollection();
        //TODO: vlozeni do tabulny M:N pri vytvoreni nebo zvlast akce?
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
            'workspace' => $this->getWorkspace(),
            'comesFrom' => $this->getComesFrom()
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

    public function addProcessToPackage(Process $process): self
    {
        $processes = $this->getProcesses();

        foreach ($processes as $proce)
        {
            if ($proce->getUuid() === $process->getUuid())
            {
                throw CouldNotAddProcessException::createForDuplicateProcess($proce);
            }

        }

        $this->addProcess($process);
        $process->addPackage($this);

        return $this;
    }

    public function addProcess(Process $process): self
    {
        $this->processes->add($process);
        return $this;
    }

    /**
     * @return Process[]
     */
    public function getProcesses(): array
    {
        return $this->processes->toArray();
    }
}
