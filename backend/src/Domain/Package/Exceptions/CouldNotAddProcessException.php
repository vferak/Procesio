<?php

declare(strict_types=1);

namespace Procesio\Domain\Package\Exceptions;

use Procesio\Domain\Exceptions\DomainException;
use Procesio\Domain\Process\Process;
use Procesio\Domain\User\User;

class CouldNotAddProcessException extends DomainException
{
    private function __construct(string $message = "")
    {
        parent::__construct($message);
    }


    public static function createForDuplicateProcess(Process $process): self
    {
        return new self(
            sprintf(
                'User %s could not be added to workspace!',
                $process->getUuid()
            )
        );
    }
}
