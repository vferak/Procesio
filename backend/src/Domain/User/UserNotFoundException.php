<?php

declare(strict_types=1);

namespace Procesio\Domain\User;

use Procesio\Domain\DomainException\DomainRecordNotFoundException;

class UserNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The user you requested does not exist.';
}
