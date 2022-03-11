<?php

declare(strict_types=1);

namespace Procesio\Domain\Process;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
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
     * Many Users have Many Groups.
     * @var ArrayCollection|Package[]
     * @ManyToMany(targetEntity="Procesio\Domain\Package\Package")
     * @JoinTable(name="process_package",
     *      joinColumns={@JoinColumn(name="process_uuid", referencedColumnName="uuid")},
     *      inverseJoinColumns={@JoinColumn(name="package_uuid", referencedColumnName="uuid")}
     *      )
     */
    private $packages;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Process\Process")
     * @JoinColumn(name="comes_from", referencedColumnName="uuid", nullable = true, unique=false)
     */
    private ?Process $comesFrom;


    public function __construct(ProcessData $processData)
    {
        $this->generateAndSetUuid();
        $this->name = $processData->getName();
        $this->description = $processData->getDescription();
        $this->comesFrom = $processData->getComesFrom();

        $this->edit($processData);
    }

    public function edit(ProcessData $processData): void
    {
        $this->name = $processData->getName();
        $this->description = $processData->getDescription();
        $this->comesFrom = $processData->getComesFrom();
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
}
