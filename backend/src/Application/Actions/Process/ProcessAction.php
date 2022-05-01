<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Process;

use Procesio\Application\Actions\Action;
use Procesio\Domain\Process\ProcessFacade;
use Procesio\Domain\Project\ProjectFacade;
use Procesio\Domain\ProjectProcess\ProjectProcessFacade;
use Procesio\Domain\State\StateFacade;
use Procesio\Domain\Subprocess\SubprocessFacade;
use Psr\Log\LoggerInterface;

abstract class ProcessAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected ProcessFacade $processFacade,
        protected ProjectProcessFacade $projectProcessFacade,
        protected ProjectFacade $projectFacade,
        protected StateFacade $stateFacade,
        protected SubprocessFacade $subprocessFacade
    ) {
        parent::__construct($logger);
    }
}
