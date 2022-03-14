<?php

declare(strict_types=1);

namespace Procesio\Domain\State;

use JsonSerializable;
use Procesio\Domain\UuidDomainObjectTrait;

/**
 * @Entity
 * @Table(name="state")
 */
class State implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="name") */
    private string $name;


    public function __construct(StateData $stateData)
    {
        $this->generateAndSetUuid();
        $this->name = $stateData->getName();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName()
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

}
