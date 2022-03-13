<?php

declare(strict_types=1);

namespace Procesio\Domain\Process\Exceptions;

use Procesio\Domain\Exceptions\DomainException;

class CouldNotDisplayParentProcessException extends DomainException
{
    private function __construct(string $message = "")
    {
        parent::__construct($message);
    }

    public static function displayProcessDomainObjectClass(): self
    {
        return new self(
          sprintf('This process does not have parent!')
        );
    }
}
