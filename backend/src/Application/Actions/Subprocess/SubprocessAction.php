<?php

declare(strict_types=1);

namespace Procesio\Application\Actions\Subprocess;

use Procesio\Application\Actions\Action;
use Procesio\Domain\Process\ProcessFacade;
use Procesio\Domain\Project\ProjectFacade;
use Procesio\Domain\ProjectSubprocess\ProjectSubprocessFacade;
use Procesio\Domain\State\StateFacade;
use Procesio\Domain\Subprocess\SubprocessFacade;
use Psr\Log\LoggerInterface;

abstract class SubprocessAction extends Action
{
    public function __construct(
        LoggerInterface $logger,
        protected ProjectFacade $projectFacade,
        protected SubprocessFacade $subprocessFacade,
        protected ProjectSubprocessFacade $projectSubprocessFacade,
        protected StateFacade $stateFacade,
        protected ProcessFacade $processFacade
    ) {
        parent::__construct($logger);
    }
}
