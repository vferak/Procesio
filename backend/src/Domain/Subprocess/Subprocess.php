<?php

declare(strict_types=1);

namespace Procesio\Domain\Subprocess;

use JsonSerializable;
use Procesio\Domain\Process\Process;
use Procesio\Domain\UuidDomainObjectTrait;

/**
 * @Entity
 * @Table(name="subprocess")
 */
class Subprocess implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="name") */
    private string $name;

    /** @Column(type="string", name="description") */
    private string $description;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Process\Process", inversedBy="subprocesses")
     * @JoinColumn(name="process_uuid", referencedColumnName="uuid")
     */
    private ?Process $process;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Subprocess\Subprocess")
     * @JoinColumn(name="comes_from", referencedColumnName="uuid", nullable = true, unique=false)
     */
    private ?Subprocess $comesFrom;

    /** @Column(type="integer") */
    private int $priority;


    public function __construct(SubprocessData $subprocessData)
    {
        $this->generateAndSetUuid();

        $this->name = $subprocessData->getName();
        $this->description = $subprocessData->getDescription();
        $this->process = $subprocessData->getProcess();
        $this->comesFrom = $subprocessData->getComesFrom();
        $this->priority = $subprocessData->getPriority();

        $this->edit($subprocessData);
    }

    public function edit(SubprocessData $subprocessData): void
    {
        $this->name = $subprocessData->getName();
        $this->description = $subprocessData->getDescription();
        $this->comesFrom = $subprocessData->getComesFrom();
        $this->process = $subprocessData->getProcess();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'process_uuid' => $this->getProcess()?->getUuid(),
            'comesFrom' => $this->getComesFrom(),
            'priority' => $this->getPriority(),
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

    public function getComesFrom(): ?Subprocess
    {
        return $this->comesFrom;
    }

    public function getProcess(): ?Process
    {
        return $this->process;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
    
    public function isSame(Subprocess $subprocess): bool
    {
        return $this->getUuid() === $subprocess->getUuid();
    }
}
