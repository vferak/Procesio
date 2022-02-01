<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Authentication;

use Procesio\Application\Actions\Action;
use Procesio\Application\Authentication\Authenticator;
use Procesio\Domain\User\UserRepository;
use Psr\Log\LoggerInterface;

abstract class AuthenticationAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected UserRepository $userRepository,
        protected Authenticator $authenticator
    ) {
        parent::__construct($logger);
    }
}
