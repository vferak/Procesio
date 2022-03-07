<?php

declare(strict_types=1);

namespace Procesio\Domain\Subprocess;

use JsonSerializable;
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

    /**
     * @ManyToOne(targetEntity="Procesio\Domain\Subprocess\Subprocess")
     * @JoinColumn(name="process_uuid", referencedColumnName="uuid")
     */
    private $process;

    public function __construct(SubprocessData $subprocessData)
    {
        $this->generateAndSetUuid();

        $this->name = $subprocessData->getName();
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
