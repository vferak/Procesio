<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Project;

use Procesio\Application\Actions\Action;
use Procesio\Domain\Project\ProjectFacade;
use Psr\Log\LoggerInterface;

abstract class ProjectAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected ProjectFacade $projectFacade
    ) {
        parent::__construct($logger);
    }
}