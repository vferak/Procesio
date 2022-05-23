<?php

declare(strict_types=1);

namespace Procesio\Domain\Process;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Procesio\Domain\Package\Package;
use Procesio\Domain\ProcessPackage\ProcessPackage;
use Procesio\Domain\Project\Project;
use Procesio\Domain\ProjectProcess\ProjectProcess;
use Procesio\Domain\Subprocess\Subprocess;
use Procesio\Domain\UuidDomainObjectTrait;

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
     * @var ArrayCollection|ProcessPackage[]
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="Procesio\Domain\ProcessPackage\ProcessPackage", mappedBy="process")
     */
    private mixed $processPackages;

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


    /**
     * @var ArrayCollection|ProjectProcess[]
     * One product has many features. This is the inverse side.
     * @OneToMany(targetEntity="Procesio\Domain\ProjectProcess\ProjectProcess", mappedBy="process")
     */
    private mixed $projectProcesses;


    public function __construct(ProcessData $processData)
    {
        $this->generateAndSetUuid();
        $this->comesFrom = $processData->getComesFrom();
        $this->subprocesses = new ArrayCollection();
        $this->processPackages = new ArrayCollection();
        $this->projectProcesses = new ArrayCollection();
        $this->edit($processData);
    }

    public function edit(ProcessData $processData): void
    {
        $this->name = $processData->getName();
        $this->description = $processData->getDescription();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
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
        $packages = [];
        foreach ($this->processPackages as $processPackage) {
            $packages[] = $processPackage->getProcess();
        }

        return $packages;
    }

    public function addProcessPackage(ProcessPackage $processPackage): self
    {
        $this->processPackages->add($processPackage);
        return $this;
    }

    /**
     * @return Subprocess[]
     */
    public function getSubprocesses(): array
    {
        $subprocesses = $this->subprocesses->toArray();
        usort($subprocesses, static function (Subprocess $a, Subprocess $b) {
            return $a->getPriority() <=> $b->getPriority();
        });
        return $subprocesses;
    }

    /**
     * @return ProcessPackage[]
     */
    public function getProcessPackages(): array
    {
        return $this->processPackages->toArray();
    }

    public function removeSubprocess(Subprocess $subprocess): void
    {
        foreach ($this->subprocesses as $key => $thisSubprocess) {
            if ($thisSubprocess->isSame($subprocess)) {
                $this->subprocesses->remove($key);
                break;
            }
        }
    }
}
