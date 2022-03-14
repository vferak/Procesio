<?php

declare(strict_types=1);

namespace Procesio\Domain\Exceptions;

class DomainObjectNotFoundException extends DomainException
{
    private function __construct(string $message = "")
    {
        parent::__construct($message);
    }

    /**
     * @param class-string $objectClass
     */
    public static function createFromDomainObjectClass(string $objectClass): self
    {
        return new self(
            sprintf('Domain object %s not found!', $objectClass)
        );
    }
}
