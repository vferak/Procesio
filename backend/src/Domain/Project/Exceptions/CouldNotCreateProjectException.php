<?php

declare(strict_types=1);

namespace Procesio\Domain\Project\Exceptions;

use Procesio\Domain\Exceptions\DomainException;
use Procesio\Domain\Package\Package;
use Procesio\Domain\User\User;

class CouldNotCreateProjectException extends DomainException
{
    private function __construct(string $message = "")
    {
        parent::__construct($message);
    }


    public static function createForUserWithDifferentWorkspace(User $user): self
    {
        return new self(
          sprintf(
              'Project could not be created because its user %s is not part of the same workspace!', $user->getUuid()
          )
        );
    }

    public static function createForPackageWithDifferentWorkspace(Package $package): self
    {
        return new self(
            sprintf(
                'Project could not be created because its package %s is not part of the same workspace!', $package->getUuid()
            )
        );
    }
}
