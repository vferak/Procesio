<?php

declare(strict_types=1);

namespace Procesio\Domain\Process;

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

    public function __construct(ProcessData $processData)
    {
        $this->generateAndSetUuid();

        $this->name = $processData->getName();
        //$this->password = $userData->getPassword();
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
