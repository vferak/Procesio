<?php

declare(strict_types=1);

namespace Procesio\Domain\Workspace\Exceptions;

use Procesio\Domain\Exceptions\DomainException;
use Procesio\Domain\Package\Package;

class CouldNotDeleteWorkspaceException extends DomainException
{
    private function __construct(string $message = "")
    {
        parent::__construct($message);
    }

    /**
     * @param Package[] $packages
     */
    public static function createForPackages(array $packages): self
    {
        $packageUuids = [];
        foreach ($packages as $package) {
            $packageUuids[] = $package->getUuid();
        }

        return new self(
          sprintf(
              'Workspace could not be deleted because these packages exist: %s!',
              implode(', ', $packageUuids)
          )
        );
    }
}
