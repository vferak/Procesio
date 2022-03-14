<?php

declare(strict_types=1);

namespace Procesio\Domain\Subprocess\Exceptions;

use Procesio\Domain\Exceptions\DomainException;

class CouldNotDisplayParentSubprocessException extends DomainException
{
    private function __construct(string $message = "")
    {
        parent::__construct($message);
    }

    public static function displaySubprocessDomainObjectClass(): self
    {
        return new self(
          sprintf('This subprocess does not have parent!')
        );
    }
}
