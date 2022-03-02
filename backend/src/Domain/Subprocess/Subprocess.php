<?php

declare(strict_types=1);

namespace Procesio\Domain\Subprocess;

use Cassandra\Date;
use DateTime;
use JsonSerializable;
use Procesio\Domain\User\User;
use Procesio\Domain\Process;
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
     * @ManyToOne(targetEntity="Procesio\Domain\Process\Process")
     * @JoinColumn(name="process_uuid", referencedColumnName="uuid")
     */
    private $process;

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Subprocess\Subprocess")
     * @JoinColumn(name="comes_from", referencedColumnName="uuid", nullable = true, unique=false)
     */
    private string $comesFrom;

    public function __construct(SubprocessData $subprocessData)
    {
        $this->generateAndSetUuid();

        $this->name = $subprocessData->getName();
        $this->description = $subprocessData->getDescription();
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
}
