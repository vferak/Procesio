<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Authentication;

use Procesio\Application\Actions\Action;
use Procesio\Application\Authentication\Authenticator;
use Procesio\Domain\User\UserFacade;
use Procesio\Domain\Workspace\WorkspaceFacade;
use Psr\Log\LoggerInterface;

abstract class AuthenticationAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected UserFacade $userFacade,
        protected WorkspaceFacade $workspaceFacade,
        protected Authenticator $authenticator
    ) {
        parent::__construct($logger);
    }
}