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
    /**
     * @Column(type="string", name="uuid", length=36, options={"fixed": true})
     * @Id
     */
    private string $uuid;

    /** @Column(type="string", name="name") */
    private string $name;


    public function __construct(StateData $stateData)
    {
        $this->uuid = $stateData->
        $this->name = $stateData->getName();
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'name' => $this->getName()
        ];
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
