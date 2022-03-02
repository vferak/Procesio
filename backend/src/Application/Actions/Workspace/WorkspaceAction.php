<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Workspace;

use Procesio\Application\Actions\Action;
use Procesio\Domain\User\UserFacade;
use Procesio\Domain\Workspace\WorkspaceFacade;
use Psr\Log\LoggerInterface;

abstract class WorkspaceAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected WorkspaceFacade $workspaceFacade,
        protected UserFacade $userFacade
    ) {
        parent::__construct($logger);
    }
}