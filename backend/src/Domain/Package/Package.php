<?php

declare(strict_types=1);

namespace Procesio\Domain\Package;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;
use Procesio\Domain\UuidDomainObjectTrait;

/**
 * @Entity
 * @Table(name="package")
 */
class Package implements JsonSerializable
{
    use UuidDomainObjectTrait;

    /** @Column(type="string", name="name") */
    private string $name;

    public function __construct(PackageData $packageData)
    {
        $this->generateAndSetUuid();
        $this->name = $packageData->getName();

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
