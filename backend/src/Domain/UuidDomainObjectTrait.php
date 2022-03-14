<?php

namespace Procesio\Domain;

use Procesio\Domain\Exceptions\DomainObjectNotFoundException;
use Ramsey\Uuid\Uuid;

trait UuidDomainObjectTrait
{
    /**
     * @Column(type="string", name="uuid", length=36, options={"fixed": true})
     * @Id
     */
    private string $uuid;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    protected function generateAndSetUuid(): void
    {
        $this->uuid = Uuid::uuid4()->toString();
    }
}
