<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Project;

use Procesio\Application\Actions\Action;
use Procesio\Domain\Package\PackageFacade;
use Procesio\Domain\Project\ProjectFacade;
use Procesio\Domain\User\UserFacade;
use Procesio\Domain\Workspace\WorkspaceFacade;
use Psr\Log\LoggerInterface;

abstract class ProjectAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected ProjectFacade $projectFacade,
        protected WorkspaceFacade $workspaceFacade,
        protected PackageFacade $packageFacade,
        protected UserFacade $userFacade
    ) {
        parent::__construct($logger);
    }
}
