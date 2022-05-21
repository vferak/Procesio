<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\User;

use Procesio\Application\Actions\Action;
use Procesio\Domain\Process\ProcessFacade;
use Procesio\Domain\Project\ProjectFacade;
use Procesio\Domain\User\UserFacade;
use Procesio\Domain\User\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected UserFacade $userFacade,
        protected ProjectFacade $projectFacade,
        protected ProcessFacade $processFacade
    ) {
        parent::__construct($logger);
    }
}
